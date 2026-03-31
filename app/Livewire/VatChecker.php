<?php

namespace App\Livewire;

use App\Models\Country;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class VatChecker extends Component
{
    // Seller inputs
    public $sellerCountry = '';
    public $sellerVatNumber = '';
    public $sellerHasVat = true;

    // Buyer inputs
    public $buyerCountry = '';
    public $buyerVatNumber = '';
    public $buyerHasVat = false;

    // Transaction details
    public $transactionType = 'goods'; // goods | services
    public $serviceCategory = 'general'; // general | digital | transport | property | training
    public $goodsCategory = 'standard'; // standard | food | medical | books | childrens

    // Results
    public $result = null;
    public $showResult = false;

    // Country list
    public $countries = [];

    // EU country ISO codes
    public const EU_COUNTRIES = [
        'AT', 'BE', 'BG', 'HR', 'CY', 'CZ', 'DK', 'EE', 'FI', 'FR',
        'DE', 'GR', 'HU', 'IE', 'IT', 'LV', 'LT', 'LU', 'MT', 'NL',
        'PL', 'PT', 'RO', 'SK', 'SI', 'ES', 'SE',
    ];

    public function mount()
    {
        $this->countries = Cache::remember('vat_checker_countries', 600, function () {
            return Country::orderBy('name', 'ASC')->get()->map(function ($c) {
                return [
                    'slug' => $c->slug,
                    'name' => $c->name,
                    'iso' => strtoupper($c->iso_code),
                    'standard_rate' => $c->standard_rate,
                    'reduced_rate' => $c->reduced_rate,
                    'currency_display' => $c->currency_display,
                ];
            })->toArray();
        });
    }

    public function check()
    {
        $this->showResult = true;
        $this->result = $this->determineVatObligation();
    }

    public function updatedSellerCountry()
    {
        $this->resetResult();
    }

    public function updatedBuyerCountry()
    {
        $this->resetResult();
    }

    public function updatedTransactionType()
    {
        $this->resetResult();
    }

    public function updatedServiceCategory()
    {
        $this->resetResult();
    }

    public function updatedSellerHasVat()
    {
        $this->resetResult();
    }

    public function updatedBuyerHasVat()
    {
        $this->resetResult();
    }

    private function resetResult()
    {
        $this->showResult = false;
        $this->result = null;
    }

    private function getCountryBySlug(string $slug): ?array
    {
        return collect($this->countries)->firstWhere('slug', $slug);
    }

    private function isEuCountry(string $iso): bool
    {
        return in_array(strtoupper($iso), self::EU_COUNTRIES);
    }

    private function determineVatObligation(): array
    {
        $seller = $this->getCountryBySlug($this->sellerCountry);
        $buyer = $this->getCountryBySlug($this->buyerCountry);

        if (!$seller || !$buyer) {
            return [
                'status' => 'error',
                'title' => 'Missing Information',
                'summary' => 'Please select both seller and buyer countries.',
                'details' => [],
                'color' => 'red',
                'icon' => 'error',
            ];
        }

        $sellerEu = $this->isEuCountry($seller['iso']);
        $buyerEu = $this->isEuCountry($buyer['iso']);
        $sameCountry = $seller['slug'] === $buyer['slug'];
        $isB2B = $this->sellerHasVat && $this->buyerHasVat;

        // Determine the scenario
        if ($sameCountry) {
            return $this->domesticTransaction($seller, $buyer);
        }

        if ($sellerEu && $buyerEu) {
            if ($this->transactionType === 'goods') {
                return $isB2B
                    ? $this->euB2bGoods($seller, $buyer)
                    : $this->euB2cGoods($seller, $buyer);
            }

            return $isB2B
                ? $this->euB2bServices($seller, $buyer)
                : $this->euB2cServices($seller, $buyer);
        }

        if ($sellerEu && !$buyerEu) {
            return $this->exportOutsideEu($seller, $buyer);
        }

        if (!$sellerEu && $buyerEu) {
            return $this->importIntoEu($seller, $buyer);
        }

        return $this->nonEuToNonEu($seller, $buyer);
    }

    private function domesticTransaction(array $seller, array $buyer): array
    {
        $rate = $this->getApplicableRate($seller);

        return [
            'status' => 'vat_applies',
            'title' => 'VAT Applies — Domestic Transaction',
            'summary' => "Since both parties are in {$seller['name']}, standard domestic VAT rules apply.",
            'color' => 'blue',
            'icon' => 'info',
            'vat_rate' => $rate,
            'country' => $seller['name'],
            'details' => [
                ['label' => 'Transaction type', 'value' => 'Domestic (same country)'],
                ['label' => 'VAT charged by', 'value' => "Seller in {$seller['name']}"],
                ['label' => 'Applicable VAT rate', 'value' => "{$rate}%"],
                ['label' => 'VAT shown on invoice', 'value' => 'Yes — standard invoice with VAT'],
            ],
            'rules' => [
                'The seller must charge and collect VAT at the applicable rate.',
                'VAT must be shown separately on the invoice.',
                $this->buyerHasVat
                    ? 'The buyer (VAT registered) can deduct the input VAT on their VAT return.'
                    : 'The buyer (not VAT registered) pays VAT as a final cost.',
            ],
        ];
    }

    private function euB2bGoods(array $seller, array $buyer): array
    {
        return [
            'status' => 'reverse_charge',
            'title' => 'Reverse Charge — No VAT Charged by Seller',
            'summary' => "This is an intra-EU B2B supply of goods from {$seller['name']} to {$buyer['name']}. The reverse charge mechanism applies.",
            'color' => 'green',
            'icon' => 'check',
            'vat_rate' => 0,
            'country' => $buyer['name'],
            'details' => [
                ['label' => 'Transaction type', 'value' => 'Intra-EU B2B supply of goods'],
                ['label' => 'VAT charged by seller', 'value' => "No — zero-rated / exempt in {$seller['name']}"],
                ['label' => 'Reverse charge applies', 'value' => "Yes — buyer self-assesses VAT in {$buyer['name']}"],
                ['label' => 'Buyer VAT rate', 'value' => "{$buyer['standard_rate']}% ({$buyer['name']} standard rate)"],
            ],
            'rules' => [
                "The seller invoices without VAT (zero-rated intra-Community supply).",
                "The seller must verify the buyer's VAT number via the VIES system.",
                "The buyer must report the purchase on their VAT return as both output and input VAT (reverse charge).",
                "Both parties must include this transaction in their EC Sales/Purchases Lists.",
                "The seller's invoice must reference \"Intra-Community supply — Article 138 VAT Directive\" or \"Reverse charge\".",
            ],
        ];
    }

    private function euB2cGoods(array $seller, array $buyer): array
    {
        $rate = $buyer['standard_rate'];

        return [
            'status' => 'vat_applies',
            'title' => "VAT Applies — Buyer's Country Rate",
            'summary' => "For B2C intra-EU supplies of goods, VAT is generally due in the buyer's country ({$buyer['name']}) under the One-Stop-Shop (OSS) scheme.",
            'color' => 'amber',
            'icon' => 'warning',
            'vat_rate' => $rate,
            'country' => $buyer['name'],
            'details' => [
                ['label' => 'Transaction type', 'value' => 'Intra-EU B2C distance sale of goods'],
                ['label' => 'VAT due in', 'value' => "{$buyer['name']} (destination principle)"],
                ['label' => 'Applicable VAT rate', 'value' => "{$rate}% ({$buyer['name']} standard rate)"],
                ['label' => 'OSS scheme', 'value' => 'Seller can register for OSS in their home country to report and pay VAT for all EU member states'],
            ],
            'rules' => [
                "Since July 2021, the EU-wide threshold for distance sales is €10,000 per year (total EU-wide B2C sales).",
                "Below the threshold, the seller MAY charge their own country's VAT rate instead.",
                "Above the threshold (or if voluntarily opted in), the seller must charge the buyer's country VAT rate.",
                "The One-Stop-Shop (OSS) simplifies registration — register in one EU country for all EU distance sales.",
                "The seller must still issue an invoice showing the correct destination-country VAT.",
            ],
        ];
    }

    private function euB2bServices(array $seller, array $buyer): array
    {
        if ($this->serviceCategory === 'property') {
            return [
                'status' => 'vat_applies',
                'title' => 'VAT Applies — Where Property is Located',
                'summary' => "Services related to immovable property are taxed where the property is located, regardless of where the parties are established.",
                'color' => 'amber',
                'icon' => 'warning',
                'vat_rate' => null,
                'country' => 'Where the property is located',
                'details' => [
                    ['label' => 'Transaction type', 'value' => 'B2B services related to immovable property'],
                    ['label' => 'VAT due in', 'value' => 'Country where the property is located'],
                    ['label' => 'Special rule', 'value' => 'Article 47 VAT Directive — place of supply is where the property is'],
                ],
                'rules' => [
                    "This includes construction, architectural, property management, and real estate agent services.",
                    "VAT is always due in the country where the property is physically located.",
                    "The supplier may need to register for VAT in that country if the reverse charge doesn't apply.",
                ],
            ];
        }

        return [
            'status' => 'reverse_charge',
            'title' => 'Reverse Charge — No VAT Charged by Seller',
            'summary' => "For B2B services between EU countries, the general rule is that VAT is due in the buyer's country ({$buyer['name']}). The reverse charge mechanism applies.",
            'color' => 'green',
            'icon' => 'check',
            'vat_rate' => 0,
            'country' => $buyer['name'],
            'details' => [
                ['label' => 'Transaction type', 'value' => 'Intra-EU B2B supply of services'],
                ['label' => 'VAT charged by seller', 'value' => 'No — reverse charge applies'],
                ['label' => 'Reverse charge applies', 'value' => "Yes — buyer self-assesses VAT in {$buyer['name']}"],
                ['label' => 'Buyer VAT rate', 'value' => "{$buyer['standard_rate']}% ({$buyer['name']} standard rate)"],
            ],
            'rules' => [
                "The general rule (Article 44 VAT Directive): B2B services are taxed where the customer is established.",
                "The seller invoices without VAT and must include \"Reverse charge — Article 196 VAT Directive\" on the invoice.",
                "The buyer self-assesses VAT on their VAT return (reports as both output and input VAT).",
                "The seller must verify the buyer's VAT number via VIES.",
            ],
        ];
    }

    private function euB2cServices(array $seller, array $buyer): array
    {
        if ($this->serviceCategory === 'digital') {
            return [
                'status' => 'vat_applies',
                'title' => "VAT Applies — Buyer's Country Rate",
                'summary' => "Electronically supplied services (digital services) to non-VAT-registered consumers are taxed in the buyer's country ({$buyer['name']}).",
                'color' => 'amber',
                'icon' => 'warning',
                'vat_rate' => $buyer['standard_rate'],
                'country' => $buyer['name'],
                'details' => [
                    ['label' => 'Transaction type', 'value' => 'B2C digital/electronic services'],
                    ['label' => 'VAT due in', 'value' => "{$buyer['name']} (destination principle)"],
                    ['label' => 'Applicable VAT rate', 'value' => "{$buyer['standard_rate']}% ({$buyer['name']} standard rate)"],
                    ['label' => 'OSS scheme', 'value' => 'Use the One-Stop-Shop (OSS) to declare and pay VAT'],
                ],
                'rules' => [
                    "Digital services include: SaaS, streaming, downloads, online courses, cloud storage, etc.",
                    "EU-wide threshold of €10,000/year applies — below this, you can charge your home country rate.",
                    "Above the threshold, you must charge the customer's country VAT rate.",
                    "Register for the OSS (One-Stop-Shop) scheme to simplify VAT compliance across all EU countries.",
                ],
            ];
        }

        if ($this->serviceCategory === 'property') {
            return [
                'status' => 'vat_applies',
                'title' => 'VAT Applies — Where Property is Located',
                'summary' => "Services related to immovable property are taxed where the property is located.",
                'color' => 'amber',
                'icon' => 'warning',
                'vat_rate' => null,
                'country' => 'Where the property is located',
                'details' => [
                    ['label' => 'Transaction type', 'value' => 'B2C services related to immovable property'],
                    ['label' => 'VAT due in', 'value' => 'Country where the property is located'],
                ],
                'rules' => [
                    "VAT is always due in the country where the property is physically located.",
                    "The supplier may need to register for VAT in that country.",
                ],
            ];
        }

        if ($this->serviceCategory === 'transport') {
            return [
                'status' => 'vat_applies',
                'title' => 'VAT Applies — Complex Rules for Transport',
                'summary' => "Passenger transport is taxed where the transport takes place. Goods transport for B2C is taxed where the transport takes place.",
                'color' => 'amber',
                'icon' => 'warning',
                'vat_rate' => null,
                'country' => 'Where transport takes place',
                'details' => [
                    ['label' => 'Transaction type', 'value' => 'B2C transport services'],
                    ['label' => 'Passenger transport', 'value' => 'VAT due where the transport takes place (proportionally)'],
                    ['label' => 'Goods transport', 'value' => 'VAT due where the transport takes place'],
                ],
                'rules' => [
                    "Passenger transport: VAT is charged in proportion to the distances covered in each country.",
                    "Intra-community goods transport for B2C: taxed at original point of departure.",
                    "These rules can be complex — consult a tax advisor for specific cases.",
                ],
            ];
        }

        // General B2C services
        return [
            'status' => 'vat_applies',
            'title' => "VAT Applies — Seller's Country Rate",
            'summary' => "For general B2C services, VAT is normally due in the seller's country ({$seller['name']}).",
            'color' => 'blue',
            'icon' => 'info',
            'vat_rate' => $seller['standard_rate'],
            'country' => $seller['name'],
            'details' => [
                ['label' => 'Transaction type', 'value' => 'Intra-EU B2C supply of general services'],
                ['label' => 'VAT due in', 'value' => "{$seller['name']} (origin principle for general services)"],
                ['label' => 'Applicable VAT rate', 'value' => "{$seller['standard_rate']}% ({$seller['name']} standard rate)"],
            ],
            'rules' => [
                "The general rule for B2C services (Article 45 VAT Directive): VAT is due where the supplier is established.",
                "The seller charges their own country's VAT rate and remits it to their local tax authority.",
                "Important exceptions exist for digital services, property services, transport, and certain other categories.",
            ],
        ];
    }

    private function exportOutsideEu(array $seller, array $buyer): array
    {
        return [
            'status' => 'no_vat',
            'title' => 'No EU VAT — Export Outside the EU',
            'summary' => "Exports of {$this->transactionType} from {$seller['name']} (EU) to {$buyer['name']} (non-EU) are zero-rated or exempt from EU VAT.",
            'color' => 'green',
            'icon' => 'check',
            'vat_rate' => 0,
            'country' => $buyer['name'],
            'details' => [
                ['label' => 'Transaction type', 'value' => "Export of {$this->transactionType} outside the EU"],
                ['label' => 'EU VAT charged', 'value' => 'No — zero-rated export'],
                ['label' => 'Local import duties/VAT', 'value' => "May apply upon import into {$buyer['name']} (check local rules)"],
            ],
            'rules' => [
                "Exports outside the EU are zero-rated (0% VAT) for both goods and most services.",
                "For goods, the seller must retain proof of export (shipping documents, customs declarations).",
                "For services, the place of supply rules determine if VAT applies — for B2B services supplied to non-EU businesses, no EU VAT applies.",
                "The buyer's country may impose import VAT or duties — check the destination country's rules.",
            ],
        ];
    }

    private function importIntoEu(array $seller, array $buyer): array
    {
        return [
            'status' => 'vat_applies',
            'title' => 'Import VAT Applies in the EU',
            'summary' => "Importing {$this->transactionType} from {$seller['name']} (non-EU) into {$buyer['name']} (EU) will be subject to import VAT.",
            'color' => 'amber',
            'icon' => 'warning',
            'vat_rate' => $buyer['standard_rate'],
            'country' => $buyer['name'],
            'details' => [
                ['label' => 'Transaction type', 'value' => "Import of {$this->transactionType} into the EU"],
                ['label' => 'Import VAT due in', 'value' => $buyer['name']],
                ['label' => 'Applicable VAT rate', 'value' => "{$buyer['standard_rate']}% ({$buyer['name']} standard rate)"],
                ['label' => 'Customs duties', 'value' => 'May also apply depending on the type of goods'],
            ],
            'rules' => [
                "Import VAT is normally payable at the point of entry into the EU (customs).",
                $this->buyerHasVat
                    ? "As a VAT-registered business, you can normally deduct the import VAT on your VAT return."
                    : "As a non-VAT-registered buyer, import VAT is a final cost.",
                "For goods valued under €150, the Import One-Stop-Shop (IOSS) scheme may apply.",
                "Customs duties may also be levied depending on the product classification (HS code).",
            ],
        ];
    }

    private function nonEuToNonEu(array $seller, array $buyer): array
    {
        return [
            'status' => 'no_vat',
            'title' => 'No EU VAT — Non-EU Transaction',
            'summary' => "This transaction between {$seller['name']} and {$buyer['name']} does not involve any EU country. EU VAT rules do not apply.",
            'color' => 'gray',
            'icon' => 'info',
            'vat_rate' => 0,
            'country' => null,
            'details' => [
                ['label' => 'Transaction type', 'value' => 'Non-EU to Non-EU'],
                ['label' => 'EU VAT', 'value' => 'Not applicable'],
                ['label' => 'Local tax', 'value' => 'Check the local tax rules of both countries'],
            ],
            'rules' => [
                "EU VAT legislation does not apply to this transaction.",
                "Check the local sales tax, GST, or VAT rules of {$seller['name']} and {$buyer['name']}.",
            ],
        ];
    }

    private function getApplicableRate(array $country): float
    {
        if ($this->transactionType === 'goods') {
            return match ($this->goodsCategory) {
                'food', 'medical', 'books', 'childrens' => $country['reduced_rate'] ?: $country['standard_rate'],
                default => $country['standard_rate'],
            };
        }

        return $country['standard_rate'];
    }

    public function render()
    {
        return view('livewire.vat-checker');
    }
}
