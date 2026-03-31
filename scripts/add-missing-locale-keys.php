<?php

/**
 * One-shot script to add missing translation keys to all 23 non-English locale files.
 * Run: php scripts/add-missing-locale-keys.php
 * Delete after use.
 *
 * Strategy: string insertion — finds the closing ], of the calculator and breadcrumbs
 * sections and inserts the new keys immediately before them, preserving all existing
 * formatting, indentation and comments.
 */

$calculatorAdditions = [
    'de' => [
        'heading'                  => 'MwSt.-Rechner',
        'standard_rate_label'      => 'Regelsatz (:rate%)',
        'reduced_rate_label'       => 'Ermäßigt (:rate%)',
        'super_reduced_rate_label' => 'Stark ermäßigt (:rate%)',
        'parking_rate_label'       => 'Zwischensteuersatz (:rate%)',
        'vat_percentage_label'     => 'MwSt. (:rate%)',
        'current_vat_rates'        => 'Aktuelle MwSt.-Sätze',
        'need_more_details'        => 'Mehr Details benötigt?',
        'need_more_details_desc'   => 'Erfahren Sie alles über MwSt.-Konformität, Registrierung und Ausnahmen in :country.',
        'view_vat_guide'           => 'MwSt.-Leitfaden für :country anzeigen',
        'country_heading'          => ':country MwSt.-Rechner',
        'european_heading'         => 'Europäischer MwSt.-Rechner',
        'country_subtitle'         => 'Berechnen Sie die Mehrwertsteuer für Transaktionen in :country einfach. Der aktuelle Regelsteuersatz beträgt :rate%.',
        'generic_subtitle'         => 'Berechnen Sie MwSt.-Beträge schnell für jeden der 27 Mitgliedstaaten der Europäischen Union.',
        'breadcrumb_label'         => 'MwSt.-Rechner',
    ],
    'fr' => [
        'heading'                  => 'Calculateur de TVA',
        'standard_rate_label'      => 'Standard (:rate%)',
        'reduced_rate_label'       => 'Réduit (:rate%)',
        'super_reduced_rate_label' => 'Super réduit (:rate%)',
        'parking_rate_label'       => 'Parking (:rate%)',
        'vat_percentage_label'     => 'TVA (:rate%)',
        'current_vat_rates'        => 'Taux de TVA actuels',
        'need_more_details'        => 'Besoin de plus de détails ?',
        'need_more_details_desc'   => 'Apprenez tout sur la conformité TVA, l\'enregistrement et les exceptions en :country.',
        'view_vat_guide'           => 'Voir le guide TVA de :country',
        'country_heading'          => 'Calculateur TVA :country',
        'european_heading'         => 'Calculateur de TVA européen',
        'country_subtitle'         => 'Calculez facilement la TVA pour les transactions en :country. Le taux normal actuel est de :rate%.',
        'generic_subtitle'         => 'Calculez rapidement les montants de TVA pour les 27 États membres de l\'Union européenne.',
        'breadcrumb_label'         => 'Calculateur de TVA',
    ],
    'es' => [
        'heading'                  => 'Calculadora de IVA',
        'standard_rate_label'      => 'Estándar (:rate%)',
        'reduced_rate_label'       => 'Reducido (:rate%)',
        'super_reduced_rate_label' => 'Superreducido (:rate%)',
        'parking_rate_label'       => 'Estacionamiento (:rate%)',
        'vat_percentage_label'     => 'IVA (:rate%)',
        'current_vat_rates'        => 'Tipos de IVA actuales',
        'need_more_details'        => '¿Necesita más detalles?',
        'need_more_details_desc'   => 'Aprenda todo sobre el cumplimiento del IVA, el registro y las excepciones en :country.',
        'view_vat_guide'           => 'Ver la guía de IVA de :country',
        'country_heading'          => 'Calculadora de IVA de :country',
        'european_heading'         => 'Calculadora de IVA europea',
        'country_subtitle'         => 'Calcule fácilmente el IVA para transacciones en :country. El tipo general actual es del :rate%.',
        'generic_subtitle'         => 'Calcule rápidamente los importes del IVA para cualquiera de los 27 Estados miembros de la Unión Europea.',
        'breadcrumb_label'         => 'Calculadora de IVA',
    ],
    'it' => [
        'heading'                  => 'Calcolatore IVA',
        'standard_rate_label'      => 'Standard (:rate%)',
        'reduced_rate_label'       => 'Ridotta (:rate%)',
        'super_reduced_rate_label' => 'Super ridotta (:rate%)',
        'parking_rate_label'       => 'Parcheggio (:rate%)',
        'vat_percentage_label'     => 'IVA (:rate%)',
        'current_vat_rates'        => 'Aliquote IVA vigenti',
        'need_more_details'        => 'Hai bisogno di maggiori dettagli?',
        'need_more_details_desc'   => 'Scopri tutto sulla conformità IVA, la registrazione e le esenzioni in :country.',
        'view_vat_guide'           => 'Visualizza la guida IVA di :country',
        'country_heading'          => 'Calcolatore IVA :country',
        'european_heading'         => 'Calcolatore IVA europeo',
        'country_subtitle'         => 'Calcola facilmente l\'IVA per le transazioni in :country. L\'aliquota ordinaria attuale è del :rate%.',
        'generic_subtitle'         => 'Calcola rapidamente gli importi IVA per uno qualsiasi dei 27 Stati membri dell\'Unione Europea.',
        'breadcrumb_label'         => 'Calcolatore IVA',
    ],
    'nl' => [
        'heading'                  => 'BTW-calculator',
        'standard_rate_label'      => 'Standaard (:rate%)',
        'reduced_rate_label'       => 'Verlaagd (:rate%)',
        'super_reduced_rate_label' => 'Super verlaagd (:rate%)',
        'parking_rate_label'       => 'Parkeertarief (:rate%)',
        'vat_percentage_label'     => 'BTW (:rate%)',
        'current_vat_rates'        => 'Huidige BTW-tarieven',
        'need_more_details'        => 'Meer informatie nodig?',
        'need_more_details_desc'   => 'Leer alles over BTW-naleving, registratie en uitzonderingen in :country.',
        'view_vat_guide'           => 'Bekijk de BTW-gids van :country',
        'country_heading'          => ':country BTW-calculator',
        'european_heading'         => 'Europese BTW-calculator',
        'country_subtitle'         => 'Bereken eenvoudig de BTW voor transacties in :country. Het huidige standaardtarief is :rate%.',
        'generic_subtitle'         => 'Bereken snel BTW-bedragen voor elk van de 27 lidstaten van de Europese Unie.',
        'breadcrumb_label'         => 'BTW-calculator',
    ],
    'pl' => [
        'heading'                  => 'Kalkulator VAT',
        'standard_rate_label'      => 'Standardowa (:rate%)',
        'reduced_rate_label'       => 'Obniżona (:rate%)',
        'super_reduced_rate_label' => 'Super obniżona (:rate%)',
        'parking_rate_label'       => 'Parkingowa (:rate%)',
        'vat_percentage_label'     => 'VAT (:rate%)',
        'current_vat_rates'        => 'Aktualne stawki VAT',
        'need_more_details'        => 'Potrzebujesz więcej informacji?',
        'need_more_details_desc'   => 'Dowiedz się wszystkiego o zgodności z VAT, rejestracji i wyjątkach w :country.',
        'view_vat_guide'           => 'Zobacz przewodnik VAT dla :country',
        'country_heading'          => 'Kalkulator VAT :country',
        'european_heading'         => 'Europejski kalkulator VAT',
        'country_subtitle'         => 'Łatwo oblicz VAT dla transakcji w :country. Aktualna stawka standardowa wynosi :rate%.',
        'generic_subtitle'         => 'Szybko obliczaj kwoty VAT dla dowolnego z 27 państw członkowskich Unii Europejskiej.',
        'breadcrumb_label'         => 'Kalkulator VAT',
    ],
    'pt' => [
        'heading'                  => 'Calculadora de IVA',
        'standard_rate_label'      => 'Normal (:rate%)',
        'reduced_rate_label'       => 'Reduzida (:rate%)',
        'super_reduced_rate_label' => 'Super Reduzida (:rate%)',
        'parking_rate_label'       => 'Intermédia (:rate%)',
        'vat_percentage_label'     => 'IVA (:rate%)',
        'current_vat_rates'        => 'Taxas de IVA atuais',
        'need_more_details'        => 'Precisa de mais informações?',
        'need_more_details_desc'   => 'Aprenda tudo sobre conformidade com o IVA, registro e exceções em :country.',
        'view_vat_guide'           => 'Ver guia de IVA de :country',
        'country_heading'          => 'Calculadora de IVA de :country',
        'european_heading'         => 'Calculadora Europeia de IVA',
        'country_subtitle'         => 'Calcule facilmente o IVA para transações em :country. A taxa normal atual é de :rate%.',
        'generic_subtitle'         => 'Calcule rapidamente montantes de IVA para qualquer um dos 27 Estados-Membros da União Europeia.',
        'breadcrumb_label'         => 'Calculadora de IVA',
    ],
    'ro' => [
        'heading'                  => 'Calculator TVA',
        'standard_rate_label'      => 'Standard (:rate%)',
        'reduced_rate_label'       => 'Redusă (:rate%)',
        'super_reduced_rate_label' => 'Super redusă (:rate%)',
        'parking_rate_label'       => 'Parcare (:rate%)',
        'vat_percentage_label'     => 'TVA (:rate%)',
        'current_vat_rates'        => 'Cotele TVA actuale',
        'need_more_details'        => 'Aveți nevoie de mai multe detalii?',
        'need_more_details_desc'   => 'Aflați totul despre conformitatea TVA, înregistrarea și excepțiile în :country.',
        'view_vat_guide'           => 'Vizualizați ghidul TVA pentru :country',
        'country_heading'          => 'Calculator TVA :country',
        'european_heading'         => 'Calculator European de TVA',
        'country_subtitle'         => 'Calculați ușor TVA pentru tranzacțiile din :country. Cota standard actuală este de :rate%.',
        'generic_subtitle'         => 'Calculați rapid sumele TVA pentru oricare din cele 27 state membre ale Uniunii Europene.',
        'breadcrumb_label'         => 'Calculator TVA',
    ],
    'cs' => [
        'heading'                  => 'Kalkulačka DPH',
        'standard_rate_label'      => 'Standardní (:rate%)',
        'reduced_rate_label'       => 'Snížená (:rate%)',
        'super_reduced_rate_label' => 'Supersnížená (:rate%)',
        'parking_rate_label'       => 'Parkovací (:rate%)',
        'vat_percentage_label'     => 'DPH (:rate%)',
        'current_vat_rates'        => 'Aktuální sazby DPH',
        'need_more_details'        => 'Potřebujete více podrobností?',
        'need_more_details_desc'   => 'Zjistěte vše o souladu s DPH, registraci a výjimkách v :country.',
        'view_vat_guide'           => 'Zobrazit průvodce DPH pro :country',
        'country_heading'          => 'Kalkulačka DPH :country',
        'european_heading'         => 'Evropská kalkulačka DPH',
        'country_subtitle'         => 'Snadno vypočítejte DPH pro transakce v :country. Aktuální standardní sazba je :rate%.',
        'generic_subtitle'         => 'Rychle vypočítejte výše DPH pro kterýkoli ze 27 členských států Evropské unie.',
        'breadcrumb_label'         => 'Kalkulačka DPH',
    ],
    'sk' => [
        'heading'                  => 'Kalkulačka DPH',
        'standard_rate_label'      => 'Štandardná (:rate%)',
        'reduced_rate_label'       => 'Znížená (:rate%)',
        'super_reduced_rate_label' => 'Super znížená (:rate%)',
        'parking_rate_label'       => 'Parkovacia (:rate%)',
        'vat_percentage_label'     => 'DPH (:rate%)',
        'current_vat_rates'        => 'Aktuálne sadzby DPH',
        'need_more_details'        => 'Potrebujete viac podrobností?',
        'need_more_details_desc'   => 'Dozviete sa všetko o súlade s DPH, registrácii a výnimkách v :country.',
        'view_vat_guide'           => 'Zobraziť sprievodcu DPH pre :country',
        'country_heading'          => 'Kalkulačka DPH :country',
        'european_heading'         => 'Európska kalkulačka DPH',
        'country_subtitle'         => 'Jednoducho vypočítajte DPH pre transakcie v :country. Aktuálna štandardná sadzba je :rate%.',
        'generic_subtitle'         => 'Rýchlo vypočítajte sumy DPH pre ktorýkoľvek z 27 členských štátov Európskej únie.',
        'breadcrumb_label'         => 'Kalkulačka DPH',
    ],
    'sl' => [
        'heading'                  => 'Kalkulator DDV',
        'standard_rate_label'      => 'Splošna (:rate%)',
        'reduced_rate_label'       => 'Znižana (:rate%)',
        'super_reduced_rate_label' => 'Super znižana (:rate%)',
        'parking_rate_label'       => 'Parkirna (:rate%)',
        'vat_percentage_label'     => 'DDV (:rate%)',
        'current_vat_rates'        => 'Veljavne stopnje DDV',
        'need_more_details'        => 'Potrebujete več podrobnosti?',
        'need_more_details_desc'   => 'Izvejte vse o skladnosti z DDV, registraciji in izjemah v :country.',
        'view_vat_guide'           => 'Oglejte si vodnik DDV za :country',
        'country_heading'          => 'Kalkulator DDV :country',
        'european_heading'         => 'Evropski kalkulator DDV',
        'country_subtitle'         => 'Enostavno izračunajte DDV za transakcije v :country. Trenutna splošna stopnja je :rate%.',
        'generic_subtitle'         => 'Hitro izračunajte zneske DDV za katero koli od 27 držav članic Evropske unije.',
        'breadcrumb_label'         => 'Kalkulator DDV',
    ],
    'hr' => [
        'heading'                  => 'Kalkulator PDV-a',
        'standard_rate_label'      => 'Standardna (:rate%)',
        'reduced_rate_label'       => 'Snižena (:rate%)',
        'super_reduced_rate_label' => 'Super snižena (:rate%)',
        'parking_rate_label'       => 'Parkirna (:rate%)',
        'vat_percentage_label'     => 'PDV (:rate%)',
        'current_vat_rates'        => 'Trenutne stope PDV-a',
        'need_more_details'        => 'Trebate više pojedinosti?',
        'need_more_details_desc'   => 'Saznajte sve o usklađenosti s PDV-om, registraciji i iznimkama u :country.',
        'view_vat_guide'           => 'Pogledajte vodič PDV-a za :country',
        'country_heading'          => 'Kalkulator PDV-a :country',
        'european_heading'         => 'Europski kalkulator PDV-a',
        'country_subtitle'         => 'Jednostavno izračunajte PDV za transakcije u :country. Trenutna standardna stopa je :rate%.',
        'generic_subtitle'         => 'Brzo izračunajte iznose PDV-a za bilo koju od 27 država članica Europske unije.',
        'breadcrumb_label'         => 'Kalkulator PDV-a',
    ],
    'hu' => [
        'heading'                  => 'ÁFA-kalkulátor',
        'standard_rate_label'      => 'Általános (:rate%)',
        'reduced_rate_label'       => 'Kedvezményes (:rate%)',
        'super_reduced_rate_label' => 'Szuperkedvezményes (:rate%)',
        'parking_rate_label'       => 'Parkolási (:rate%)',
        'vat_percentage_label'     => 'ÁFA (:rate%)',
        'current_vat_rates'        => 'Jelenlegi ÁFA-kulcsok',
        'need_more_details'        => 'Több információra van szüksége?',
        'need_more_details_desc'   => 'Tudjon meg mindent az ÁFA-megfelelőségről, a regisztrációról és a kivételekről :country esetén.',
        'view_vat_guide'           => ':country ÁFA-útmutató megtekintése',
        'country_heading'          => ':country ÁFA-kalkulátor',
        'european_heading'         => 'Európai ÁFA-kalkulátor',
        'country_subtitle'         => 'Számítsa ki könnyen az ÁFÁ-t a(z) :country-ban zajló tranzakciókhoz. A jelenlegi általános kulcs :rate%.',
        'generic_subtitle'         => 'Gyorsan számítsa ki az ÁFA összegeket az Európai Unió bármely 27 tagállamára.',
        'breadcrumb_label'         => 'ÁFA-kalkulátor',
    ],
    'bg' => [
        'heading'                  => 'Калкулатор за ДДС',
        'standard_rate_label'      => 'Стандартна (:rate%)',
        'reduced_rate_label'       => 'Намалена (:rate%)',
        'super_reduced_rate_label' => 'Свръхнамалена (:rate%)',
        'parking_rate_label'       => 'Паркинг (:rate%)',
        'vat_percentage_label'     => 'ДДС (:rate%)',
        'current_vat_rates'        => 'Текущи ставки на ДДС',
        'need_more_details'        => 'Нужни ли са ви повече подробности?',
        'need_more_details_desc'   => 'Научете всичко за съответствие с ДДС, регистрация и изключения в :country.',
        'view_vat_guide'           => 'Вижте ръководството за ДДС на :country',
        'country_heading'          => 'Калкулатор за ДДС на :country',
        'european_heading'         => 'Европейски калкулатор за ДДС',
        'country_subtitle'         => 'Лесно изчислявайте ДДС за транзакции в :country. Текущата стандартна ставка е :rate%.',
        'generic_subtitle'         => 'Бързо изчислявайте суми на ДДС за всяка от 27-те държави членки на Европейския съюз.',
        'breadcrumb_label'         => 'Калкулатор за ДДС',
    ],
    'el' => [
        'heading'                  => 'Υπολογιστής ΦΠΑ',
        'standard_rate_label'      => 'Κανονικός (:rate%)',
        'reduced_rate_label'       => 'Μειωμένος (:rate%)',
        'super_reduced_rate_label' => 'Υπερμειωμένος (:rate%)',
        'parking_rate_label'       => 'Στάθμευσης (:rate%)',
        'vat_percentage_label'     => 'ΦΠΑ (:rate%)',
        'current_vat_rates'        => 'Τρέχοντες συντελεστές ΦΠΑ',
        'need_more_details'        => 'Χρειάζεστε περισσότερες λεπτομέρειες;',
        'need_more_details_desc'   => 'Μάθετε τα πάντα για τη συμμόρφωση με τον ΦΠΑ, την εγγραφή και τις εξαιρέσεις στη/στο :country.',
        'view_vat_guide'           => 'Προβολή οδηγού ΦΠΑ για :country',
        'country_heading'          => 'Υπολογιστής ΦΠΑ :country',
        'european_heading'         => 'Ευρωπαϊκός υπολογιστής ΦΠΑ',
        'country_subtitle'         => 'Υπολογίστε εύκολα τον ΦΠΑ για συναλλαγές στη/στο :country. Ο τρέχων κανονικός συντελεστής είναι :rate%.',
        'generic_subtitle'         => 'Υπολογίστε γρήγορα ποσά ΦΠΑ για οποιοδήποτε από τα 27 κράτη μέλη της Ευρωπαϊκής Ένωσης.',
        'breadcrumb_label'         => 'Υπολογιστής ΦΠΑ',
    ],
    'et' => [
        'heading'                  => 'Käibemaksukalkulaator',
        'standard_rate_label'      => 'Tavamäär (:rate%)',
        'reduced_rate_label'       => 'Vähendatud (:rate%)',
        'super_reduced_rate_label' => 'Ülivähendatud (:rate%)',
        'parking_rate_label'       => 'Parkimismäär (:rate%)',
        'vat_percentage_label'     => 'KM (:rate%)',
        'current_vat_rates'        => 'Praegused käibemaksumäärad',
        'need_more_details'        => 'Vajate rohkem üksikasju?',
        'need_more_details_desc'   => 'Tutvuge kõigega käibemaksu vastavuse, registreerimise ja erandite kohta riigis :country.',
        'view_vat_guide'           => 'Vaata :country käibemaksu juhendit',
        'country_heading'          => ':country käibemaksukalkulaator',
        'european_heading'         => 'Euroopa käibemaksukalkulaator',
        'country_subtitle'         => 'Arvutage hõlpsalt :country tehingute käibemaks. Praegune üldmäär on :rate%.',
        'generic_subtitle'         => 'Arvutage kiiresti käibemaksu summad mis tahes Euroopa Liidu 27 liikmesriigi jaoks.',
        'breadcrumb_label'         => 'Käibemaksukalkulaator',
    ],
    'fi' => [
        'heading'                  => 'ALV-laskuri',
        'standard_rate_label'      => 'Yleinen (:rate%)',
        'reduced_rate_label'       => 'Alennettu (:rate%)',
        'super_reduced_rate_label' => 'Erityisen alennettu (:rate%)',
        'parking_rate_label'       => 'Pysäköinti (:rate%)',
        'vat_percentage_label'     => 'ALV (:rate%)',
        'current_vat_rates'        => 'Nykyiset ALV-kannat',
        'need_more_details'        => 'Tarvitsetko lisätietoja?',
        'need_more_details_desc'   => 'Opi kaikki ALV-vaatimustenmukaisuudesta, rekisteröinnistä ja poikkeuksista maassa :country.',
        'view_vat_guide'           => 'Katso :country ALV-opas',
        'country_heading'          => ':country ALV-laskuri',
        'european_heading'         => 'Eurooppalainen ALV-laskuri',
        'country_subtitle'         => 'Laske helposti ALV :country tapahtumille. Nykyinen yleinen verokanta on :rate%.',
        'generic_subtitle'         => 'Laske nopeasti ALV-summat mille tahansa Euroopan unionin 27 jäsenvaltiosta.',
        'breadcrumb_label'         => 'ALV-laskuri',
    ],
    'lt' => [
        'heading'                  => 'PVM skaičiuoklė',
        'standard_rate_label'      => 'Standartinis (:rate%)',
        'reduced_rate_label'       => 'Sumažintas (:rate%)',
        'super_reduced_rate_label' => 'Ypač sumažintas (:rate%)',
        'parking_rate_label'       => 'Parkavimo (:rate%)',
        'vat_percentage_label'     => 'PVM (:rate%)',
        'current_vat_rates'        => 'Dabartiniai PVM tarifai',
        'need_more_details'        => 'Reikia daugiau detalių?',
        'need_more_details_desc'   => 'Sužinokite viską apie PVM atitiktį, registraciją ir išimtis šalyje :country.',
        'view_vat_guide'           => 'Peržiūrėti :country PVM vadovą',
        'country_heading'          => ':country PVM skaičiuoklė',
        'european_heading'         => 'Europos PVM skaičiuoklė',
        'country_subtitle'         => 'Lengvai apskaičiuokite PVM sandoriams :country. Dabartinis standartinis tarifas yra :rate%.',
        'generic_subtitle'         => 'Greitai apskaičiuokite PVM sumas bet kurioje iš 27 Europos Sąjungos valstybių narių.',
        'breadcrumb_label'         => 'PVM skaičiuoklė',
    ],
    'lv' => [
        'heading'                  => 'PVN kalkulators',
        'standard_rate_label'      => 'Standarta (:rate%)',
        'reduced_rate_label'       => 'Samazinātā (:rate%)',
        'super_reduced_rate_label' => 'Īpaši samazinātā (:rate%)',
        'parking_rate_label'       => 'Stāvvietas (:rate%)',
        'vat_percentage_label'     => 'PVN (:rate%)',
        'current_vat_rates'        => 'Pašreizējās PVN likmes',
        'need_more_details'        => 'Nepieciešama sīkāka informācija?',
        'need_more_details_desc'   => 'Uzziniet visu par PVN atbilstību, reģistrāciju un izņēmumiem valstī :country.',
        'view_vat_guide'           => 'Skatīt :country PVN rokasgrāmatu',
        'country_heading'          => ':country PVN kalkulators',
        'european_heading'         => 'Eiropas PVN kalkulators',
        'country_subtitle'         => 'Viegli aprēķiniet PVN darījumiem valstī :country. Pašreizējā standarta likme ir :rate%.',
        'generic_subtitle'         => 'Ātri aprēķiniet PVN summas jebkurai no Eiropas Savienības 27 dalībvalstīm.',
        'breadcrumb_label'         => 'PVN kalkulators',
    ],
    'da' => [
        'heading'                  => 'Momsberegner',
        'standard_rate_label'      => 'Standard (:rate%)',
        'reduced_rate_label'       => 'Reduceret (:rate%)',
        'super_reduced_rate_label' => 'Superreduceret (:rate%)',
        'parking_rate_label'       => 'Parkeringssats (:rate%)',
        'vat_percentage_label'     => 'Moms (:rate%)',
        'current_vat_rates'        => 'Aktuelle momssatser',
        'need_more_details'        => 'Har du brug for flere detaljer?',
        'need_more_details_desc'   => 'Lær alt om momsoverholdelse, registrering og undtagelser i :country.',
        'view_vat_guide'           => 'Se momsvejledning for :country',
        'country_heading'          => ':country momsberegner',
        'european_heading'         => 'Europæisk momsberegner',
        'country_subtitle'         => 'Beregn nemt moms for transaktioner i :country. Den aktuelle standardsats er :rate%.',
        'generic_subtitle'         => 'Beregn hurtigt momsbeløb for et af de 27 EU-medlemslande.',
        'breadcrumb_label'         => 'Momsberegner',
    ],
    'sv' => [
        'heading'                  => 'Momsräknare',
        'standard_rate_label'      => 'Normal (:rate%)',
        'reduced_rate_label'       => 'Reducerad (:rate%)',
        'super_reduced_rate_label' => 'Superreducerad (:rate%)',
        'parking_rate_label'       => 'Parkeringsskatt (:rate%)',
        'vat_percentage_label'     => 'Moms (:rate%)',
        'current_vat_rates'        => 'Aktuella momssatser',
        'need_more_details'        => 'Behöver du mer information?',
        'need_more_details_desc'   => 'Lär dig allt om momsefterlevnad, registrering och undantag i :country.',
        'view_vat_guide'           => 'Visa momsguide för :country',
        'country_heading'          => ':country momsräknare',
        'european_heading'         => 'Europeisk momsräknare',
        'country_subtitle'         => 'Beräkna enkelt moms för transaktioner i :country. Aktuell normalsats är :rate%.',
        'generic_subtitle'         => 'Beräkna snabbt momsbelopp för något av Europeiska unionens 27 medlemsländer.',
        'breadcrumb_label'         => 'Momsräknare',
    ],
    'ga' => [
        'heading'                  => 'Áireamhán CBL',
        'standard_rate_label'      => 'Caighdeánach (:rate%)',
        'reduced_rate_label'       => 'Laghdaithe (:rate%)',
        'super_reduced_rate_label' => 'Sárlaghdaithe (:rate%)',
        'parking_rate_label'       => 'Páirceála (:rate%)',
        'vat_percentage_label'     => 'CBL (:rate%)',
        'current_vat_rates'        => 'Rátaí CBL reatha',
        'need_more_details'        => 'Teastaíonn níos mó sonraí uait?',
        'need_more_details_desc'   => 'Foghlaim gach rud faoi chomhlíonadh CBL, clárúchán agus eisceachtaí in :country.',
        'view_vat_guide'           => 'Féach ar threoir CBL :country',
        'country_heading'          => 'Áireamhán CBL :country',
        'european_heading'         => 'Áireamhán CBL Eorpach',
        'country_subtitle'         => 'Ríomh CBL go héasca do idirbhearta in :country. Is é :rate% an ráta caighdeánach reatha.',
        'generic_subtitle'         => 'Ríomh méideanna CBL go tapa do cheann ar bith de 27 mballstát an Aontais Eorpaigh.',
        'breadcrumb_label'         => 'Áireamhán CBL',
    ],
    'mt' => [
        'heading'                  => 'Kalkulatur tal-VAT',
        'standard_rate_label'      => 'Standard (:rate%)',
        'reduced_rate_label'       => 'Imnaqqas (:rate%)',
        'super_reduced_rate_label' => 'Super Imnaqqas (:rate%)',
        'parking_rate_label'       => 'Parkeġġ (:rate%)',
        'vat_percentage_label'     => 'VAT (:rate%)',
        'current_vat_rates'        => 'Rati tal-VAT attwali',
        'need_more_details'        => 'Trid aktar dettalji?',
        'need_more_details_desc'   => 'Tgħallem dwar il-konformità tal-VAT, ir-reġistrazzjoni u l-eċċezzjonijiet f\':country.',
        'view_vat_guide'           => 'Ara l-gwida tal-VAT ta\' :country',
        'country_heading'          => 'Kalkulatur tal-VAT ta\' :country',
        'european_heading'         => 'Kalkulatur Ewropew tal-VAT',
        'country_subtitle'         => 'Kalkula l-VAT b\'faċilità għat-tranżazzjonijiet f\':country. Ir-rata standard attwali hija :rate%.',
        'generic_subtitle'         => 'Kalkula malajr l-ammonti tal-VAT għal kwalunkwe wieħed mill-27 Stat Membru tal-Unjoni Ewropea.',
        'breadcrumb_label'         => 'Kalkulatur tal-VAT',
    ],
];

$breadcrumbAdditions = [
    'de' => ['tools' => 'Tools & Ressourcen',    'vat_navigator' => 'MwSt.-Navigator',         'countries' => 'Länder'],
    'fr' => ['tools' => 'Outils et ressources',  'vat_navigator' => 'Navigateur TVA',           'countries' => 'Pays'],
    'es' => ['tools' => 'Herramientas y recursos','vat_navigator' => 'Navegador de IVA',         'countries' => 'Países'],
    'it' => ['tools' => 'Strumenti e risorse',   'vat_navigator' => 'Navigatore IVA',           'countries' => 'Paesi'],
    'nl' => ['tools' => 'Tools en bronnen',       'vat_navigator' => 'BTW-navigator',            'countries' => 'Landen'],
    'pl' => ['tools' => 'Narzędzia i zasoby',     'vat_navigator' => 'Nawigator VAT',            'countries' => 'Kraje'],
    'pt' => ['tools' => 'Ferramentas e recursos', 'vat_navigator' => 'Navegador de IVA',         'countries' => 'Países'],
    'ro' => ['tools' => 'Instrumente și resurse', 'vat_navigator' => 'Navigatorul TVA',          'countries' => 'Țări'],
    'cs' => ['tools' => 'Nástroje a zdroje',      'vat_navigator' => 'Navigátor DPH',            'countries' => 'Země'],
    'sk' => ['tools' => 'Nástroje a zdroje',      'vat_navigator' => 'Navigátor DPH',            'countries' => 'Krajiny'],
    'sl' => ['tools' => 'Orodja in viri',          'vat_navigator' => 'Navigátor DDV',            'countries' => 'Države'],
    'hr' => ['tools' => 'Alati i resursi',         'vat_navigator' => 'PDV navigator',            'countries' => 'Zemlje'],
    'hu' => ['tools' => 'Eszközök és erőforrások', 'vat_navigator' => 'ÁFA-navigátor',           'countries' => 'Országok'],
    'bg' => ['tools' => 'Инструменти и ресурси',  'vat_navigator' => 'Навигатор по ДДС',         'countries' => 'Държави'],
    'el' => ['tools' => 'Εργαλεία και πόροι',     'vat_navigator' => 'Πλοηγός ΦΠΑ',             'countries' => 'Χώρες'],
    'et' => ['tools' => 'Tööriistad ja ressursid', 'vat_navigator' => 'Käibemaksu navigaator',   'countries' => 'Riigid'],
    'fi' => ['tools' => 'Työkalut ja resurssit',  'vat_navigator' => 'ALV-navigaattori',         'countries' => 'Maat'],
    'lt' => ['tools' => 'Priemonės ir ištekliai', 'vat_navigator' => 'PVM navigatorius',         'countries' => 'Šalys'],
    'lv' => ['tools' => 'Rīki un resursi',        'vat_navigator' => 'PVN navigators',           'countries' => 'Valstis'],
    'da' => ['tools' => 'Værktøjer og ressourcer','vat_navigator' => 'Momsnavigator',            'countries' => 'Lande'],
    'sv' => ['tools' => 'Verktyg och resurser',   'vat_navigator' => 'Momsnavigator',            'countries' => 'Länder'],
    'ga' => ['tools' => 'Uirlisí agus acmhainní', 'vat_navigator' => 'Nascleanúint CBL',         'countries' => 'Tíortha'],
    'mt' => ['tools' => 'Għodod u riżorsi',        'vat_navigator' => 'Navigatur tal-VAT',        'countries' => 'Pajjiżi'],
];

/**
 * Build a PHP key-value line: "        'key' => 'value',\n"
 */
function phpLine(string $key, string $value): string
{
    // Escape single quotes in the value
    $escaped = str_replace("'", "\\'", $value);
    return "        '{$key}' => '{$escaped}',\n";
}

$locales = array_keys($calculatorAdditions);

foreach ($locales as $locale) {
    $filePath = __DIR__ . '/../lang/' . $locale . '/ui.php';

    if (!file_exists($filePath)) {
        echo "SKIP (file not found): $locale\n";
        continue;
    }

    $content = file_get_contents($filePath);
    $modified = false;

    // ── 1. Insert calculator keys after 'total_to_pay' ────────────────────────
    $calcKeys = $calculatorAdditions[$locale] ?? [];
    if (!empty($calcKeys)) {
        // Find the 'total_to_pay' => '...' line and insert new keys after it
        $pattern = "/('total_to_pay'\s*=>\s*'[^']*',)\n(\s*\],)/";
        if (preg_match($pattern, $content)) {
            $insertion = '';
            foreach ($calcKeys as $key => $value) {
                // Only insert if key not already present
                if (strpos($content, "'{$key}'") === false) {
                    $insertion .= phpLine($key, $value);
                }
            }
            if ($insertion !== '') {
                $content = preg_replace($pattern, "$1\n{$insertion}$2", $content);
                $modified = true;
            }
        } else {
            echo "WARN: 'total_to_pay' pattern not found in $locale\n";
        }
    }

    // ── 2. Insert breadcrumb keys after 'sitemap' in breadcrumbs section ──────
    // The breadcrumbs section has 'vat_changelog' before 'sitemap', making it unique
    $bcKeys = $breadcrumbAdditions[$locale] ?? [];
    if (!empty($bcKeys)) {
        // Match: 'sitemap' => '...', followed by newline and closing ],
        // We anchor to the breadcrumbs context by requiring 'vat_changelog' earlier
        // Use a pattern that matches 'sitemap' => '...' followed immediately by ],
        $bcPattern = "/('sitemap'\s*=>\s*'[^']*',)\n(\s*\],\n\s*\/\/\s*── HTML Sitemap)/";
        if (preg_match($bcPattern, $content)) {
            $insertion = '';
            foreach ($bcKeys as $key => $value) {
                if (strpos($content, "        '{$key}' =>") === false) {
                    $insertion .= phpLine($key, $value);
                }
            }
            if ($insertion !== '') {
                $content = preg_replace($bcPattern, "$1\n{$insertion}$2", $content);
                $modified = true;
            }
        } else {
            echo "WARN: breadcrumbs 'sitemap' pattern not found in $locale\n";
        }
    }

    if ($modified) {
        file_put_contents($filePath, $content);
        echo "UPDATED: $locale\n";
    } else {
        echo "NO CHANGE: $locale (keys may already exist)\n";
    }
}

echo "\nDone.\n";


$translations = [
    'de' => [
        'calculator' => [
            'heading'                  => 'MwSt.-Rechner',
            'standard_rate_label'      => 'Regelsatz (:rate%)',
            'reduced_rate_label'       => 'Ermäßigt (:rate%)',
            'super_reduced_rate_label' => 'Stark ermäßigt (:rate%)',
            'parking_rate_label'       => 'Zwischensatz (:rate%)',
            'vat_percentage_label'     => 'MwSt. (:rate%)',
            'current_vat_rates'        => 'Aktuelle MwSt.-Sätze',
            'need_more_details'        => 'Mehr Details benötigt?',
            'need_more_details_desc'   => 'Erfahren Sie alles über MwSt.-Konformität, Registrierung und Ausnahmen in :country.',
            'view_vat_guide'           => 'MwSt.-Leitfaden für :country anzeigen',
            'country_heading'          => ':country MwSt.-Rechner',
            'european_heading'         => 'Europäischer MwSt.-Rechner',
            'country_subtitle'         => 'Berechnen Sie die Mehrwertsteuer für Transaktionen in :country einfach. Der aktuelle Regelsteuersatz beträgt :rate %.',
            'generic_subtitle'         => 'Berechnen Sie MwSt.-Beträge schnell für jeden der 27 Mitgliedstaaten der Europäischen Union.',
            'breadcrumb_label'         => 'MwSt.-Rechner',
        ],
        'breadcrumbs' => [
            'tools'         => 'Tools & Ressourcen',
            'vat_navigator' => 'MwSt.-Navigator',
            'countries'     => 'Länder',
        ],
    ],
    'fr' => [
        'calculator' => [
            'heading'                  => 'Calculateur de TVA',
            'standard_rate_label'      => 'Standard (:rate%)',
            'reduced_rate_label'       => 'Réduit (:rate%)',
            'super_reduced_rate_label' => 'Super réduit (:rate%)',
            'parking_rate_label'       => 'Parking (:rate%)',
            'vat_percentage_label'     => 'TVA (:rate%)',
            'current_vat_rates'        => 'Taux de TVA actuels',
            'need_more_details'        => 'Besoin de plus de détails ?',
            'need_more_details_desc'   => 'Apprenez tout sur la conformité TVA, l\'enregistrement et les exceptions en :country.',
            'view_vat_guide'           => 'Voir le guide TVA de :country',
            'country_heading'          => 'Calculateur TVA :country',
            'european_heading'         => 'Calculateur de TVA européen',
            'country_subtitle'         => 'Calculez facilement la TVA pour les transactions en :country. Le taux normal actuel est de :rate %.',
            'generic_subtitle'         => 'Calculez rapidement les montants de TVA pour les 27 États membres de l\'Union européenne.',
            'breadcrumb_label'         => 'Calculateur de TVA',
        ],
        'breadcrumbs' => [
            'tools'         => 'Outils et ressources',
            'vat_navigator' => 'Navigateur TVA',
            'countries'     => 'Pays',
        ],
    ],
    'es' => [
        'calculator' => [
            'heading'                  => 'Calculadora de IVA',
            'standard_rate_label'      => 'Estándar (:rate%)',
            'reduced_rate_label'       => 'Reducido (:rate%)',
            'super_reduced_rate_label' => 'Superreducido (:rate%)',
            'parking_rate_label'       => 'Estacionamiento (:rate%)',
            'vat_percentage_label'     => 'IVA (:rate%)',
            'current_vat_rates'        => 'Tipos de IVA actuales',
            'need_more_details'        => '¿Necesita más detalles?',
            'need_more_details_desc'   => 'Aprenda todo sobre el cumplimiento del IVA, el registro y las excepciones en :country.',
            'view_vat_guide'           => 'Ver la guía de IVA de :country',
            'country_heading'          => 'Calculadora de IVA de :country',
            'european_heading'         => 'Calculadora de IVA europea',
            'country_subtitle'         => 'Calcule fácilmente el IVA para transacciones en :country. El tipo general actual es del :rate %.',
            'generic_subtitle'         => 'Calcule rápidamente los importes del IVA para cualquiera de los 27 Estados miembros de la Unión Europea.',
            'breadcrumb_label'         => 'Calculadora de IVA',
        ],
        'breadcrumbs' => [
            'tools'         => 'Herramientas y recursos',
            'vat_navigator' => 'Navegador de IVA',
            'countries'     => 'Países',
        ],
    ],
    'it' => [
        'calculator' => [
            'heading'                  => 'Calcolatore IVA',
            'standard_rate_label'      => 'Standard (:rate%)',
            'reduced_rate_label'       => 'Ridotta (:rate%)',
            'super_reduced_rate_label' => 'Super ridotta (:rate%)',
            'parking_rate_label'       => 'Parcheggio (:rate%)',
            'vat_percentage_label'     => 'IVA (:rate%)',
            'current_vat_rates'        => 'Aliquote IVA vigenti',
            'need_more_details'        => 'Hai bisogno di maggiori dettagli?',
            'need_more_details_desc'   => 'Scopri tutto sulla conformità IVA, la registrazione e le esenzioni in :country.',
            'view_vat_guide'           => 'Visualizza la guida IVA di :country',
            'country_heading'          => 'Calcolatore IVA :country',
            'european_heading'         => 'Calcolatore IVA europeo',
            'country_subtitle'         => 'Calcola facilmente l\'IVA per le transazioni in :country. L\'aliquota ordinaria attuale è del :rate%.',
            'generic_subtitle'         => 'Calcola rapidamente gli importi IVA per uno qualsiasi dei 27 Stati membri dell\'Unione Europea.',
            'breadcrumb_label'         => 'Calcolatore IVA',
        ],
        'breadcrumbs' => [
            'tools'         => 'Strumenti e risorse',
            'vat_navigator' => 'Navigatore IVA',
            'countries'     => 'Paesi',
        ],
    ],
    'nl' => [
        'calculator' => [
            'heading'                  => 'BTW-calculator',
            'standard_rate_label'      => 'Standaard (:rate%)',
            'reduced_rate_label'       => 'Verlaagd (:rate%)',
            'super_reduced_rate_label' => 'Super verlaagd (:rate%)',
            'parking_rate_label'       => 'Parkeertarief (:rate%)',
            'vat_percentage_label'     => 'BTW (:rate%)',
            'current_vat_rates'        => 'Huidige BTW-tarieven',
            'need_more_details'        => 'Meer informatie nodig?',
            'need_more_details_desc'   => 'Leer alles over BTW-naleving, registratie en uitzonderingen in :country.',
            'view_vat_guide'           => 'Bekijk de BTW-gids van :country',
            'country_heading'          => ':country BTW-calculator',
            'european_heading'         => 'Europese BTW-calculator',
            'country_subtitle'         => 'Bereken eenvoudig de BTW voor transacties in :country. Het huidige standaardtarief is :rate%.',
            'generic_subtitle'         => 'Bereken snel BTW-bedragen voor elk van de 27 lidstaten van de Europese Unie.',
            'breadcrumb_label'         => 'BTW-calculator',
        ],
        'breadcrumbs' => [
            'tools'         => 'Tools en bronnen',
            'vat_navigator' => 'BTW-navigator',
            'countries'     => 'Landen',
        ],
    ],
    'pl' => [
        'calculator' => [
            'heading'                  => 'Kalkulator VAT',
            'standard_rate_label'      => 'Standardowa (:rate%)',
            'reduced_rate_label'       => 'Obniżona (:rate%)',
            'super_reduced_rate_label' => 'Super obniżona (:rate%)',
            'parking_rate_label'       => 'Parkingowa (:rate%)',
            'vat_percentage_label'     => 'VAT (:rate%)',
            'current_vat_rates'        => 'Aktualne stawki VAT',
            'need_more_details'        => 'Potrzebujesz więcej informacji?',
            'need_more_details_desc'   => 'Dowiedz się wszystkiego o zgodności z VAT, rejestracji i wyjątkach w: :country.',
            'view_vat_guide'           => 'Zobacz przewodnik VAT dla :country',
            'country_heading'          => 'Kalkulator VAT :country',
            'european_heading'         => 'Europejski kalkulator VAT',
            'country_subtitle'         => 'Łatwo oblicz VAT dla transakcji w :country. Aktualna stawka standardowa wynosi :rate%.',
            'generic_subtitle'         => 'Szybko obliczaj kwoty VAT dla dowolnego z 27 państw członkowskich Unii Europejskiej.',
            'breadcrumb_label'         => 'Kalkulator VAT',
        ],
        'breadcrumbs' => [
            'tools'         => 'Narzędzia i zasoby',
            'vat_navigator' => 'Nawigator VAT',
            'countries'     => 'Kraje',
        ],
    ],
    'pt' => [
        'calculator' => [
            'heading'                  => 'Calculadora de IVA',
            'standard_rate_label'      => 'Normal (:rate%)',
            'reduced_rate_label'       => 'Reduzida (:rate%)',
            'super_reduced_rate_label' => 'Super Reduzida (:rate%)',
            'parking_rate_label'       => 'Intermédia (:rate%)',
            'vat_percentage_label'     => 'IVA (:rate%)',
            'current_vat_rates'        => 'Taxas de IVA atuais',
            'need_more_details'        => 'Precisa de mais informações?',
            'need_more_details_desc'   => 'Aprenda tudo sobre conformidade com o IVA, registro e exceções em :country.',
            'view_vat_guide'           => 'Ver guia de IVA de :country',
            'country_heading'          => 'Calculadora de IVA de :country',
            'european_heading'         => 'Calculadora Europeia de IVA',
            'country_subtitle'         => 'Calcule facilmente o IVA para transações em :country. A taxa normal atual é de :rate%.',
            'generic_subtitle'         => 'Calcule rapidamente montantes de IVA para qualquer um dos 27 Estados-Membros da União Europeia.',
            'breadcrumb_label'         => 'Calculadora de IVA',
        ],
        'breadcrumbs' => [
            'tools'         => 'Ferramentas e recursos',
            'vat_navigator' => 'Navegador de IVA',
            'countries'     => 'Países',
        ],
    ],
    'ro' => [
        'calculator' => [
            'heading'                  => 'Calculator TVA',
            'standard_rate_label'      => 'Standard (:rate%)',
            'reduced_rate_label'       => 'Redusă (:rate%)',
            'super_reduced_rate_label' => 'Super redusă (:rate%)',
            'parking_rate_label'       => 'Parcare (:rate%)',
            'vat_percentage_label'     => 'TVA (:rate%)',
            'current_vat_rates'        => 'Cotele TVA actuale',
            'need_more_details'        => 'Aveți nevoie de mai multe detalii?',
            'need_more_details_desc'   => 'Aflați totul despre conformitatea TVA, înregistrarea și excepțiile în :country.',
            'view_vat_guide'           => 'Vizualizați ghidul TVA pentru :country',
            'country_heading'          => 'Calculator TVA :country',
            'european_heading'         => 'Calculator European de TVA',
            'country_subtitle'         => 'Calculați ușor TVA pentru tranzacțiile din :country. Cota standard actuală este de :rate%.',
            'generic_subtitle'         => 'Calculați rapid sumele TVA pentru oricare din cele 27 state membre ale Uniunii Europene.',
            'breadcrumb_label'         => 'Calculator TVA',
        ],
        'breadcrumbs' => [
            'tools'         => 'Instrumente și resurse',
            'vat_navigator' => 'Navigatorul TVA',
            'countries'     => 'Țări',
        ],
    ],
    'cs' => [
        'calculator' => [
            'heading'                  => 'Kalkulačka DPH',
            'standard_rate_label'      => 'Standardní (:rate%)',
            'reduced_rate_label'       => 'Snížená (:rate%)',
            'super_reduced_rate_label' => 'Supersnížená (:rate%)',
            'parking_rate_label'       => 'Parkovací (:rate%)',
            'vat_percentage_label'     => 'DPH (:rate%)',
            'current_vat_rates'        => 'Aktuální sazby DPH',
            'need_more_details'        => 'Potřebujete více podrobností?',
            'need_more_details_desc'   => 'Zjistěte vše o souladu s DPH, registraci a výjimkách v :country.',
            'view_vat_guide'           => 'Zobrazit průvodce DPH pro :country',
            'country_heading'          => 'Kalkulačka DPH :country',
            'european_heading'         => 'Evropská kalkulačka DPH',
            'country_subtitle'         => 'Snadno vypočítejte DPH pro transakce v :country. Aktuální standardní sazba je :rate %.',
            'generic_subtitle'         => 'Rychle vypočítejte výše DPH pro kterýkoli ze 27 členských států Evropské unie.',
            'breadcrumb_label'         => 'Kalkulačka DPH',
        ],
        'breadcrumbs' => [
            'tools'         => 'Nástroje a zdroje',
            'vat_navigator' => 'Navigátor DPH',
            'countries'     => 'Země',
        ],
    ],
    'sk' => [
        'calculator' => [
            'heading'                  => 'Kalkulačka DPH',
            'standard_rate_label'      => 'Štandardná (:rate%)',
            'reduced_rate_label'       => 'Znížená (:rate%)',
            'super_reduced_rate_label' => 'Super znížená (:rate%)',
            'parking_rate_label'       => 'Parkovacia (:rate%)',
            'vat_percentage_label'     => 'DPH (:rate%)',
            'current_vat_rates'        => 'Aktuálne sadzby DPH',
            'need_more_details'        => 'Potrebujete viac podrobností?',
            'need_more_details_desc'   => 'Dozviete sa všetko o súlade s DPH, registrácii a výnimkách v :country.',
            'view_vat_guide'           => 'Zobraziť sprievodcu DPH pre :country',
            'country_heading'          => 'Kalkulačka DPH :country',
            'european_heading'         => 'Európska kalkulačka DPH',
            'country_subtitle'         => 'Jednoducho vypočítajte DPH pre transakcie v :country. Aktuálna štandardná sadzba je :rate %.',
            'generic_subtitle'         => 'Rýchlo vypočítajte sumy DPH pre ktorýkoľvek z 27 členských štátov Európskej únie.',
            'breadcrumb_label'         => 'Kalkulačka DPH',
        ],
        'breadcrumbs' => [
            'tools'         => 'Nástroje a zdroje',
            'vat_navigator' => 'Navigátor DPH',
            'countries'     => 'Krajiny',
        ],
    ],
    'sl' => [
        'calculator' => [
            'heading'                  => 'Kalkulator DDV',
            'standard_rate_label'      => 'Splošna (:rate%)',
            'reduced_rate_label'       => 'Znižana (:rate%)',
            'super_reduced_rate_label' => 'Super znižana (:rate%)',
            'parking_rate_label'       => 'Parkirna (:rate%)',
            'vat_percentage_label'     => 'DDV (:rate%)',
            'current_vat_rates'        => 'Veljavne stopnje DDV',
            'need_more_details'        => 'Potrebujete več podrobnosti?',
            'need_more_details_desc'   => 'Izvejte vse o skladnosti z DDV, registraciji in izjemah v :country.',
            'view_vat_guide'           => 'Oglejte si vodnik DDV za :country',
            'country_heading'          => 'Kalkulator DDV :country',
            'european_heading'         => 'Evropski kalkulator DDV',
            'country_subtitle'         => 'Enostavno izračunajte DDV za transakcije v :country. Trenutna splošna stopnja je :rate%.',
            'generic_subtitle'         => 'Hitro izračunajte zneske DDV za katero koli od 27 držav članic Evropske unije.',
            'breadcrumb_label'         => 'Kalkulator DDV',
        ],
        'breadcrumbs' => [
            'tools'         => 'Orodja in viri',
            'vat_navigator' => 'Navigátor DDV',
            'countries'     => 'Države',
        ],
    ],
    'hr' => [
        'calculator' => [
            'heading'                  => 'Kalkulator PDV-a',
            'standard_rate_label'      => 'Standardna (:rate%)',
            'reduced_rate_label'       => 'Snižena (:rate%)',
            'super_reduced_rate_label' => 'Super snižena (:rate%)',
            'parking_rate_label'       => 'Parkirna (:rate%)',
            'vat_percentage_label'     => 'PDV (:rate%)',
            'current_vat_rates'        => 'Trenutne stope PDV-a',
            'need_more_details'        => 'Trebate više pojedinosti?',
            'need_more_details_desc'   => 'Saznajte sve o usklađenosti s PDV-om, registraciji i iznimkama u :country.',
            'view_vat_guide'           => 'Pogledajte vodič PDV-a za :country',
            'country_heading'          => 'Kalkulator PDV-a :country',
            'european_heading'         => 'Europski kalkulator PDV-a',
            'country_subtitle'         => 'Jednostavno izračunajte PDV za transakcije u :country. Trenutna standardna stopa je :rate%.',
            'generic_subtitle'         => 'Brzo izračunajte iznose PDV-a za bilo koju od 27 država članica Europske unije.',
            'breadcrumb_label'         => 'Kalkulator PDV-a',
        ],
        'breadcrumbs' => [
            'tools'         => 'Alati i resursi',
            'vat_navigator' => 'PDV navigator',
            'countries'     => 'Zemlje',
        ],
    ],
    'hu' => [
        'calculator' => [
            'heading'                  => 'ÁFA-kalkulátor',
            'standard_rate_label'      => 'Általános (:rate%)',
            'reduced_rate_label'       => 'Kedvezményes (:rate%)',
            'super_reduced_rate_label' => 'Szuperkedvezményes (:rate%)',
            'parking_rate_label'       => 'Parkolási (:rate%)',
            'vat_percentage_label'     => 'ÁFA (:rate%)',
            'current_vat_rates'        => 'Jelenlegi ÁFA-kulcsok',
            'need_more_details'        => 'Több információra van szüksége?',
            'need_more_details_desc'   => 'Tudjon meg mindent az ÁFA-megfelelőségről, a regisztrációról és a kivételekről :country esetén.',
            'view_vat_guide'           => ':country ÁFA-útmutató megtekintése',
            'country_heading'          => ':country ÁFA-kalkulátor',
            'european_heading'         => 'Európai ÁFA-kalkulátor',
            'country_subtitle'         => 'Számítsa ki könnyen az ÁFÁ-t az :country-ban folytatott tranzakciókhoz. A jelenlegi általános kulcs :rate%.',
            'generic_subtitle'         => 'Gyorsan számítsa ki az ÁFA összegeket az Európai Unió bármely 27 tagállamára.',
            'breadcrumb_label'         => 'ÁFA-kalkulátor',
        ],
        'breadcrumbs' => [
            'tools'         => 'Eszközök és erőforrások',
            'vat_navigator' => 'ÁFA-navigátor',
            'countries'     => 'Országok',
        ],
    ],
    'bg' => [
        'calculator' => [
            'heading'                  => 'Калкулатор за ДДС',
            'standard_rate_label'      => 'Стандартна (:rate%)',
            'reduced_rate_label'       => 'Намалена (:rate%)',
            'super_reduced_rate_label' => 'Свръхнамалена (:rate%)',
            'parking_rate_label'       => 'Паркинг (:rate%)',
            'vat_percentage_label'     => 'ДДС (:rate%)',
            'current_vat_rates'        => 'Текущи ставки на ДДС',
            'need_more_details'        => 'Нужни ли са ви повече подробности?',
            'need_more_details_desc'   => 'Научете всичко за съответствие с ДДС, регистрация и изключения в :country.',
            'view_vat_guide'           => 'Вижте ръководството за ДДС на :country',
            'country_heading'          => 'Калкулатор за ДДС на :country',
            'european_heading'         => 'Европейски калкулатор за ДДС',
            'country_subtitle'         => 'Лесно изчислявайте ДДС за транзакции в :country. Текущата стандартна ставка е :rate%.',
            'generic_subtitle'         => 'Бързо изчислявайте суми на ДДС за всяка от 27-те държави членки на Европейския съюз.',
            'breadcrumb_label'         => 'Калкулатор за ДДС',
        ],
        'breadcrumbs' => [
            'tools'         => 'Инструменти и ресурси',
            'vat_navigator' => 'Навигатор по ДДС',
            'countries'     => 'Държави',
        ],
    ],
    'el' => [
        'calculator' => [
            'heading'                  => 'Υπολογιστής ΦΠΑ',
            'standard_rate_label'      => 'Κανονικός (:rate%)',
            'reduced_rate_label'       => 'Μειωμένος (:rate%)',
            'super_reduced_rate_label' => 'Υπερμειωμένος (:rate%)',
            'parking_rate_label'       => 'Στάθμευσης (:rate%)',
            'vat_percentage_label'     => 'ΦΠΑ (:rate%)',
            'current_vat_rates'        => 'Τρέχοντες συντελεστές ΦΠΑ',
            'need_more_details'        => 'Χρειάζεστε περισσότερες λεπτομέρειες;',
            'need_more_details_desc'   => 'Μάθετε τα πάντα για τη συμμόρφωση με τον ΦΠΑ, την εγγραφή και τις εξαιρέσεις στη/στο :country.',
            'view_vat_guide'           => 'Προβολή οδηγού ΦΠΑ για :country',
            'country_heading'          => 'Υπολογιστής ΦΠΑ :country',
            'european_heading'         => 'Ευρωπαϊκός υπολογιστής ΦΠΑ',
            'country_subtitle'         => 'Υπολογίστε εύκολα τον ΦΠΑ για συναλλαγές στη/στο :country. Ο τρέχων κανονικός συντελεστής είναι :rate%.',
            'generic_subtitle'         => 'Υπολογίστε γρήγορα ποσά ΦΠΑ για οποιοδήποτε από τα 27 κράτη μέλη της Ευρωπαϊκής Ένωσης.',
            'breadcrumb_label'         => 'Υπολογιστής ΦΠΑ',
        ],
        'breadcrumbs' => [
            'tools'         => 'Εργαλεία και πόροι',
            'vat_navigator' => 'Πλοηγός ΦΠΑ',
            'countries'     => 'Χώρες',
        ],
    ],
    'et' => [
        'calculator' => [
            'heading'                  => 'Käibemaksukalkulaator',
            'standard_rate_label'      => 'Tavamäär (:rate%)',
            'reduced_rate_label'       => 'Vähendatud (:rate%)',
            'super_reduced_rate_label' => 'Ülivähendatud (:rate%)',
            'parking_rate_label'       => 'Parkimismäär (:rate%)',
            'vat_percentage_label'     => 'KM (:rate%)',
            'current_vat_rates'        => 'Praegused käibemaksumäärad',
            'need_more_details'        => 'Vajate rohkem üksikasju?',
            'need_more_details_desc'   => 'Tutvuge kõigega käibemaksu vastavuse, registreerimise ja erandite kohta riigis :country.',
            'view_vat_guide'           => 'Vaata :country käibemaksu juhendit',
            'country_heading'          => ':country käibemaksukalkulaator',
            'european_heading'         => 'Euroopa käibemaksukalkulaator',
            'country_subtitle'         => 'Arvutage hõlpsalt :country tehingute käibemaks. Praegune üldmäär on :rate%.',
            'generic_subtitle'         => 'Arvutage kiiresti käibemaksu summad mis tahes Euroopa Liidu 27 liikmesriigi jaoks.',
            'breadcrumb_label'         => 'Käibemaksukalkulaator',
        ],
        'breadcrumbs' => [
            'tools'         => 'Tööriistad ja ressursid',
            'vat_navigator' => 'Käibemaksu navigaator',
            'countries'     => 'Riigid',
        ],
    ],
    'fi' => [
        'calculator' => [
            'heading'                  => 'ALV-laskuri',
            'standard_rate_label'      => 'Yleinen (:rate%)',
            'reduced_rate_label'       => 'Alennettu (:rate%)',
            'super_reduced_rate_label' => 'Erityisen alennettu (:rate%)',
            'parking_rate_label'       => 'Pysäköinti (:rate%)',
            'vat_percentage_label'     => 'ALV (:rate%)',
            'current_vat_rates'        => 'Nykyiset ALV-kannat',
            'need_more_details'        => 'Tarvitsetko lisätietoja?',
            'need_more_details_desc'   => 'Opi kaikki ALV-vaatimustenmukaisuudesta, rekisteröinnistä ja poikkeuksista maassa :country.',
            'view_vat_guide'           => 'Katso :country ALV-opas',
            'country_heading'          => ':country ALV-laskuri',
            'european_heading'         => 'Eurooppalainen ALV-laskuri',
            'country_subtitle'         => 'Laske helposti ALV :country tapahtumille. Nykyinen yleinen verokanta on :rate%.',
            'generic_subtitle'         => 'Laske nopeasti ALV-summat mille tahansa Euroopan unionin 27 jäsenvaltiosta.',
            'breadcrumb_label'         => 'ALV-laskuri',
        ],
        'breadcrumbs' => [
            'tools'         => 'Työkalut ja resurssit',
            'vat_navigator' => 'ALV-navigaattori',
            'countries'     => 'Maat',
        ],
    ],
    'lt' => [
        'calculator' => [
            'heading'                  => 'PVM skaičiuoklė',
            'standard_rate_label'      => 'Standartinis (:rate%)',
            'reduced_rate_label'       => 'Sumažintas (:rate%)',
            'super_reduced_rate_label' => 'Ypač sumažintas (:rate%)',
            'parking_rate_label'       => 'Parkavimo (:rate%)',
            'vat_percentage_label'     => 'PVM (:rate%)',
            'current_vat_rates'        => 'Dabartiniai PVM tarifai',
            'need_more_details'        => 'Reikia daugiau detalių?',
            'need_more_details_desc'   => 'Sužinokite viską apie PVM atitiktį, registraciją ir išimtis šalyje :country.',
            'view_vat_guide'           => 'Peržiūrėti :country PVM vadovą',
            'country_heading'          => ':country PVM skaičiuoklė',
            'european_heading'         => 'Europos PVM skaičiuoklė',
            'country_subtitle'         => 'Lengvai apskaičiuokite PVM sandoriams :country. Dabartinis standartinis tarifas yra :rate%.',
            'generic_subtitle'         => 'Greitai apskaičiuokite PVM sumas bet kurioje iš 27 Europos Sąjungos valstybių narių.',
            'breadcrumb_label'         => 'PVM skaičiuoklė',
        ],
        'breadcrumbs' => [
            'tools'         => 'Priemonės ir ištekliai',
            'vat_navigator' => 'PVM navigatorius',
            'countries'     => 'Šalys',
        ],
    ],
    'lv' => [
        'calculator' => [
            'heading'                  => 'PVN kalkulators',
            'standard_rate_label'      => 'Standarta (:rate%)',
            'reduced_rate_label'       => 'Samazinātā (:rate%)',
            'super_reduced_rate_label' => 'Īpaši samazinātā (:rate%)',
            'parking_rate_label'       => 'Stāvvietas (:rate%)',
            'vat_percentage_label'     => 'PVN (:rate%)',
            'current_vat_rates'        => 'Pašreizējās PVN likmes',
            'need_more_details'        => 'Nepieciešama sīkāka informācija?',
            'need_more_details_desc'   => 'Uzziniet visu par PVN atbilstību, reģistrāciju un izņēmumiem valstī :country.',
            'view_vat_guide'           => 'Skatīt :country PVN rokasgrāmatu',
            'country_heading'          => ':country PVN kalkulators',
            'european_heading'         => 'Eiropas PVN kalkulators',
            'country_subtitle'         => 'Viegli aprēķiniet PVN darījumiem valstī :country. Pašreizējā standarta likme ir :rate%.',
            'generic_subtitle'         => 'Ātri aprēķiniet PVN summas jebkurai no Eiropas Savienības 27 dalībvalstīm.',
            'breadcrumb_label'         => 'PVN kalkulators',
        ],
        'breadcrumbs' => [
            'tools'         => 'Rīki un resursi',
            'vat_navigator' => 'PVN navigators',
            'countries'     => 'Valstis',
        ],
    ],
    'da' => [
        'calculator' => [
            'heading'                  => 'Momsberegner',
            'standard_rate_label'      => 'Standard (:rate%)',
            'reduced_rate_label'       => 'Reduceret (:rate%)',
            'super_reduced_rate_label' => 'Superreduceret (:rate%)',
            'parking_rate_label'       => 'Parkeringssats (:rate%)',
            'vat_percentage_label'     => 'Moms (:rate%)',
            'current_vat_rates'        => 'Aktuelle momssatser',
            'need_more_details'        => 'Har du brug for flere detaljer?',
            'need_more_details_desc'   => 'Lær alt om momsoverholdelse, registrering og undtagelser i :country.',
            'view_vat_guide'           => 'Se momsvejledning for :country',
            'country_heading'          => ':country momsberegner',
            'european_heading'         => 'Europæisk momsberegner',
            'country_subtitle'         => 'Beregn nemt moms for transaktioner i :country. Den aktuelle standardsats er :rate%.',
            'generic_subtitle'         => 'Beregn hurtigt momsbeløb for et af de 27 EU-medlemslande.',
            'breadcrumb_label'         => 'Momsberegner',
        ],
        'breadcrumbs' => [
            'tools'         => 'Værktøjer og ressourcer',
            'vat_navigator' => 'Momsnavigator',
            'countries'     => 'Lande',
        ],
    ],
    'sv' => [
        'calculator' => [
            'heading'                  => 'Momsräknare',
            'standard_rate_label'      => 'Normal (:rate%)',
            'reduced_rate_label'       => 'Reducerad (:rate%)',
            'super_reduced_rate_label' => 'Superreducerad (:rate%)',
            'parking_rate_label'       => 'Parkeringsskatt (:rate%)',
            'vat_percentage_label'     => 'Moms (:rate%)',
            'current_vat_rates'        => 'Aktuella momssatser',
            'need_more_details'        => 'Behöver du mer information?',
            'need_more_details_desc'   => 'Lär dig allt om momsefterlevnad, registrering och undantag i :country.',
            'view_vat_guide'           => 'Visa momsguide för :country',
            'country_heading'          => ':country momsräknare',
            'european_heading'         => 'Europeisk momsräknare',
            'country_subtitle'         => 'Beräkna enkelt moms för transaktioner i :country. Aktuell normalsats är :rate%.',
            'generic_subtitle'         => 'Beräkna snabbt momsbelopp för något av Europeiska unionens 27 medlemsländer.',
            'breadcrumb_label'         => 'Momsräknare',
        ],
        'breadcrumbs' => [
            'tools'         => 'Verktyg och resurser',
            'vat_navigator' => 'Momsnavigator',
            'countries'     => 'Länder',
        ],
    ],
    'ga' => [
        'calculator' => [
            'heading'                  => 'Áireamhán CBL',
            'standard_rate_label'      => 'Caighdeánach (:rate%)',
            'reduced_rate_label'       => 'Laghdaithe (:rate%)',
            'super_reduced_rate_label' => 'Sárlaghdaithe (:rate%)',
            'parking_rate_label'       => 'Páirceála (:rate%)',
            'vat_percentage_label'     => 'CBL (:rate%)',
            'current_vat_rates'        => 'Rátaí CBL reatha',
            'need_more_details'        => 'Teastaíonn níos mó sonraí uait?',
            'need_more_details_desc'   => 'Foghlaim gach rud faoi chomhlíonadh CBL, clárúcháin agus eisceachtaí in :country.',
            'view_vat_guide'           => 'Féach ar threoir CBL :country',
            'country_heading'          => 'Áireamhán CBL :country',
            'european_heading'         => 'Áireamhán CBL Eorpach',
            'country_subtitle'         => 'Ríomh CBL go héasca do idirbhearta in :country. Is é :rate% an ráta caighdeánach reatha.',
            'generic_subtitle'         => 'Ríomh méideanna CBL go tapa do cheann ar bith de 27 mballstát an Aontais Eorpaigh.',
            'breadcrumb_label'         => 'Áireamhán CBL',
        ],
        'breadcrumbs' => [
            'tools'         => 'Uirlisí agus acmhainní',
            'vat_navigator' => 'Nascleanúint CBL',
            'countries'     => 'Tíortha',
        ],
    ],
    'mt' => [
        'calculator' => [
            'heading'                  => 'Kalkulatur tal-VAT',
            'standard_rate_label'      => 'Standard (:rate%)',
            'reduced_rate_label'       => 'Imnaqqas (:rate%)',
            'super_reduced_rate_label' => 'Super Imnaqqas (:rate%)',
            'parking_rate_label'       => 'Parkeġġ (:rate%)',
            'vat_percentage_label'     => 'VAT (:rate%)',
            'current_vat_rates'        => 'Rati tal-VAT attwali',
            'need_more_details'        => 'Trid aktar dettalji?',
            'need_more_details_desc'   => 'Tgħallem dwar il-konformità tal-VAT, ir-reġistrazzjoni u l-eċċezzjonijiet f\':country.',
            'view_vat_guide'           => 'Ara l-gwida tal-VAT ta\' :country',
            'country_heading'          => 'Kalkulatur tal-VAT ta\' :country',
            'european_heading'         => 'Kalkulatur Ewropew tal-VAT',
            'country_subtitle'         => 'Kalkula l-VAT b\'faċilità għat-tranżazzjonijiet f\':country. Ir-rata standard attwali hija :rate%.',
            'generic_subtitle'         => 'Kalkula malajr l-ammonti tal-VAT għal kwalunkwe wieħed mill-27 Stat Membru tal-Unjoni Ewropea.',
            'breadcrumb_label'         => 'Kalkulatur tal-VAT',
        ],
        'breadcrumbs' => [
            'tools'         => 'Għodod u riżorsi',
            'vat_navigator' => 'Navigatur tal-VAT',
            'countries'     => 'Pajjiżi',
        ],
    ],
];

// Write keys into each locale file
foreach ($translations as $locale => $newKeys) {
    $filePath = __DIR__ . '/../lang/' . $locale . '/ui.php';

    if (!file_exists($filePath)) {
        echo "SKIP (missing): $locale\n";
        continue;
    }

    $existing = require $filePath;

    foreach ($newKeys as $section => $keys) {
        foreach ($keys as $key => $value) {
            if (!isset($existing[$section][$key])) {
                $existing[$section][$key] = $value;
            }
        }
    }

    // Re-write the PHP file
    $output = "<?php\n\nreturn " . var_export($existing, true) . ";\n";

    // Prettify: convert single quotes with array ( to [
    // Actually var_export produces valid PHP, just write it
    file_put_contents($filePath, $output);
    echo "UPDATED: $locale\n";
}

echo "Done.\n";
