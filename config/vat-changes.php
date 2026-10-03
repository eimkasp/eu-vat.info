<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Change ledger
    |--------------------------------------------------------------------------
    | CSV of VAT rate changes confirmed by official sources. `vat-changes:import`
    | publishes it to the vat_rate_changes table; docs/vat-change-updates.md
    | describes the columns and the weekly review.
    */
    'ledger' => base_path('data/vat_changes.csv'),

    /*
    |--------------------------------------------------------------------------
    | European Commission TEDB
    |--------------------------------------------------------------------------
    | Taxes in Europe Database web service that `vat-changes:audit` compares the
    | stored rates with.
    */
    'tedb' => [
        'endpoint' => env('TEDB_ENDPOINT', 'https://ec.europa.eu/taxation_customs/tedb/ws/'),
        'timeout' => 90,
    ],

    /*
    |--------------------------------------------------------------------------
    | Failure alerts
    |--------------------------------------------------------------------------
    | Address that receives the output of a scheduled import or audit that fails.
    */
    'alert_email' => env('VAT_CHANGES_ALERT_EMAIL'),

    'audit' => [

        /*
        | Values removed from both sides before comparing, per country and rate type.
        | They are real rates that the site deliberately does not list as that type:
        | single-category rates the Commission files under another type, and regional rates.
        */
        'ignore' => [
            'AT' => ['parking' => [13]],
            'ES' => ['standard' => [7]],
            'GR' => ['super_reduced' => [4], 'parking' => [13]],
            'IE' => ['super_reduced' => [4.8], 'parking' => [13.5]],
            'LU' => ['super_reduced' => [8]],
            'PL' => ['super_reduced' => [8]],
            'PT' => ['super_reduced' => [6]],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Official hosts
    |--------------------------------------------------------------------------
    | Host suffixes a ledger `source_url` may point to. A new official publisher is
    | added here in the same change that first cites it.
    */
    'official_hosts' => [
        'europa.eu',

        'bka.gv.at', 'bmf.gv.at', 'parlament.gv.at', 'bundeskanzleramt.gv.at', 'oesterreich.gv.at', 'usp.gv.at', 'finanzonline.at',
        'bundesfinanzministerium.de', 'bundesregierung.de', 'bundestag.de', 'bundesrat.de', 'bgbl.de', 'recht.bund.de', 'gesetze-im-internet.de', 'bundesanzeiger.de',
        'belastingdienst.nl', 'rijksoverheid.nl', 'overheid.nl', 'officielebekendmakingen.nl', 'tweedekamer.nl', 'eerstekamer.nl',
        'fin.belgium.be', 'belgium.be', 'fgov.be', 'ejustice.just.fgov.be', 'dekamer.be', 'lachambre.be',
        'public.lu', 'gouvernement.lu', 'legilux.public.lu', 'guichet.lu', 'etat.lu',
        'vero.fi', 'finlex.fi', 'eduskunta.fi', 'valtioneuvosto.fi', 'vm.fi',
        'skatteverket.se', 'regeringen.se', 'riksdagen.se', 'svenskforfattningssamling.se',
        'skm.dk', 'skat.dk', 'retsinformation.dk', 'ft.dk', 'regeringen.dk', 'borger.dk', 'skatteministeriet.dk', 'erhvervsstyrelsen.dk',
        'emta.ee', 'riigiteataja.ee', 'fin.ee', 'riigikogu.ee', 'valitsus.ee',
        'vid.gov.lv', 'likumi.lv', 'saeima.lv', 'fm.gov.lv', 'mk.gov.lv', 'gov.lv',
        'vmi.lt', 'e-tar.lt', 'lrs.lt', 'lrv.lt', 'finmin.lrv.lt', 'e-seimas.lrs.lt', 'lrp.lt',
        'gov.pl', 'sejm.gov.pl', 'senat.gov.pl', 'dziennikustaw.gov.pl', 'isap.sejm.gov.pl', 'podatki.gov.pl', 'prezydent.pl',
        'gov.cz', 'mfcr.cz', 'financnisprava.cz', 'e-sbirka.cz', 'psp.cz', 'vlada.cz', 'senat.cz',
        'financnasprava.sk', 'mfsr.sk', 'slov-lex.sk', 'nrsr.sk', 'gov.sk', 'vlada.gov.sk',
        'nav.gov.hu', 'magyarkozlony.hu', 'parlament.hu', 'kormany.hu', 'njt.hu', 'mnb.hu',
        'anaf.ro', 'mfinante.gov.ro', 'monitoruloficial.ro', 'cdep.ro', 'senat.ro', 'gov.ro', 'guv.ro',
        'nra.bg', 'minfin.bg', 'parliament.bg', 'government.bg', 'dv.parliament.bg',
        'aade.gr', 'minfin.gr', 'gov.gr', 'et.gr', 'hellenicparliament.gr', 'e-nomothesia.gr',
        'mof.gov.cy', 'tax.gov.cy', 'gov.cy', 'cylaw.org', 'parliament.cy', 'pio.gov.cy',
        'porezna-uprava.hr', 'porezna-uprava.gov.hr', 'narodne-novine.nn.hr', 'nn.hr', 'sabor.hr', 'vlada.gov.hr', 'mfin.gov.hr', 'gov.hr',
        'fu.gov.si', 'pisrs.si', 'uradni-list.si', 'gov.si', 'dz-rs.si', 'vlada.si',
        'revenue.ie', 'gov.ie', 'irishstatutebook.ie', 'oireachtas.ie', 'budget.gov.ie',
        'gouv.fr', 'legifrance.gouv.fr', 'impots.gouv.fr', 'economie.gouv.fr', 'assemblee-nationale.fr', 'senat.fr', 'service-public.fr', 'conseil-constitutionnel.fr',
        'boe.es', 'gob.es', 'agenciatributaria.es', 'agenciatributaria.gob.es', 'hacienda.gob.es', 'lamoncloa.gob.es', 'congreso.es', 'senado.es',
        'dre.pt', 'diariodarepublica.pt', 'files.diariodarepublica.pt', 'portaldasfinancas.gov.pt', 'gov.pt', 'parlamento.pt', 'at.gov.pt',
        'gazzettaufficiale.it', 'agenziaentrate.gov.it', 'mef.gov.it', 'finanze.gov.it', 'governo.it', 'normattiva.it', 'camera.it', 'senato.it', 'gov.it',
        'cfr.gov.mt', 'gov.mt', 'legislation.mt', 'parlament.mt', 'mfin.gov.mt',
    ],
];
