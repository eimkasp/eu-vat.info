<?php

namespace App\Services\VatChanges;

use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Http;
use RuntimeException;
use SimpleXMLElement;

/**
 * Reads the rates that Member States report to the European Commission's Taxes in Europe Database (TEDB).
 */
class TedbClient
{
    private const NS_REQUEST = 'urn:ec.europa.eu:taxud:tedb:services:v1:IVatRetrievalService';

    private const NS_TYPES = 'urn:ec.europa.eu:taxud:tedb:services:v1:IVatRetrievalService:types';

    private const SOAP_ACTION = 'urn:ec.europa.eu:taxud:tedb:services:v1:VatRetrievalService/RetrieveVatRates';

    private const RATE_TYPES = [
        'DEFAULT' => 'standard',
        'REDUCED_RATE' => 'reduced',
        'SUPER_REDUCED_RATE' => 'super_reduced',
        'PARKING_RATE' => 'parking',
    ];

    private const TEDB_CODES = ['GR' => 'EL'];

    /**
     * @param  list<string>  $isoCodes
     * @return list<array{country: string, type: string, rate: float, regional: bool}>
     *
     * @throws RuntimeException
     */
    public function rates(array $isoCodes, CarbonInterface $on): array
    {
        $response = Http::withHeaders(['SOAPAction' => '"'.self::SOAP_ACTION.'"', 'Accept' => 'text/xml'])
            ->withBody($this->envelope($isoCodes, $on), 'text/xml; charset=UTF-8')
            ->timeout((int) config('vat-changes.tedb.timeout', 90))
            ->post((string) config('vat-changes.tedb.endpoint'));

        $xml = $this->parse($response->body());

        if ($response->failed() || $xml === null) {
            throw new RuntimeException('TEDB request failed: '.$this->failure($response->status(), $xml));
        }

        $xml->registerXPathNamespace('t', self::NS_TYPES);
        $countries = array_flip(self::TEDB_CODES);
        $rates = [];

        foreach ($xml->xpath('//t:vatRateResults') ?: [] as $result) {
            $result->registerXPathNamespace('t', self::NS_TYPES);

            $type = self::RATE_TYPES[$this->field($result, 't:rate/t:type')] ?? null;
            $value = $this->field($result, 't:rate/t:value');

            if ($type === null || ! is_numeric($value)) {
                continue;
            }

            $member = $this->field($result, 't:memberState');

            $rates[] = [
                'country' => $countries[$member] ?? $member,
                'type' => $type,
                'rate' => (float) $value,
                'regional' => $this->field($result, 't:category/t:identifier') === 'REGION',
            ];
        }

        return $rates;
    }

    /**
     * @param  list<string>  $isoCodes
     */
    private function envelope(array $isoCodes, CarbonInterface $on): string
    {
        $states = implode('', array_map(
            fn (string $iso) => '<typ:isoCode>'.htmlspecialchars(self::TEDB_CODES[$iso] ?? $iso, ENT_XML1).'</typ:isoCode>',
            $isoCodes,
        ));

        return '<?xml version="1.0" encoding="UTF-8"?>'
            .'<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:v1="'.self::NS_REQUEST.'" xmlns:typ="'.self::NS_TYPES.'">'
            .'<soapenv:Header/><soapenv:Body><v1:retrieveVatRatesReqMsg>'
            .'<typ:memberStates>'.$states.'</typ:memberStates>'
            .'<typ:situationOn>'.$on->toDateString().'</typ:situationOn>'
            .'</v1:retrieveVatRatesReqMsg></soapenv:Body></soapenv:Envelope>';
    }

    private function field(SimpleXMLElement $node, string $path): string
    {
        return trim((string) ($node->xpath($path)[0] ?? ''));
    }

    private function parse(string $body): ?SimpleXMLElement
    {
        if (trim($body) === '') {
            return null;
        }

        $previous = libxml_use_internal_errors(true);
        $xml = simplexml_load_string($body, SimpleXMLElement::class, LIBXML_NONET);
        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        return $xml instanceof SimpleXMLElement ? $xml : null;
    }

    private function failure(int $status, ?SimpleXMLElement $xml): string
    {
        $fault = $xml?->xpath('//faultstring');
        $description = $xml?->xpath('//*[local-name()="description"]');

        return trim(($fault[0] ?? "HTTP {$status}").' '.($description[0] ?? ''));
    }
}
