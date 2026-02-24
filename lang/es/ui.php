<?php

/*
|--------------------------------------------------------------------------
| UI Translations – Spanish (Español)
|--------------------------------------------------------------------------
| All translatable static strings used across blade templates.
| Organised by component / page for easy maintenance.
*/

return [

    // ── Global / Shared ──────────────────────────────────────────────────
    'site_name'           => 'EU VAT Info',
    'home'                => 'Inicio',
    'all_countries'       => 'Todos los países',
    'details'             => 'Detalles',
    'actions'             => 'Acciones',
    'filters'             => 'Filtros',
    'search'              => 'Buscar',
    'save'                => 'Guardar',
    'calculate'           => 'Calcular',
    'loading'             => 'Cargando...',
    'all_rights_reserved' => 'Todos los derechos reservados.',
    'data_updated_daily'  => 'Datos actualizados diariamente',
    'country'             => 'País',
    'countries'           => 'Países',
    'rate'                => 'Tipo',
    'type'                => 'Tipo',
    'language'            => 'Idioma',
    'back_to_home'        => 'Volver al inicio',

    // ── Navigation ──────────────────────────────────────────────────────
    'nav' => [
        'all_countries'  => 'Todos los países',
        'vat_calculator' => 'Calculadora de IVA',
        'vat_widget'     => 'Widget de IVA',
        'vat_map'        => 'Mapa del IVA',
        'vat_history'    => 'Historial del IVA',
    ],

    // ── Footer ──────────────────────────────────────────────────────────
    'footer' => [
        'description'      => 'Tu fuente de confianza para tipos de IVA actualizados, cálculos e información sobre cumplimiento en los 27 estados miembros de la Unión Europea. Actualizado diariamente con los últimos tipos.',
        'vat_tools'        => 'Herramientas de IVA',
        'resources'        => 'Recursos',
        'partner_tools'    => 'Herramientas de socios',
        'vat_calculator'   => 'Calculadora de IVA',
        'interactive_map'  => 'Mapa interactivo del IVA',
        'vat_rate_history' => 'Historial de tipos de IVA',
        'embed_widget'     => 'Widget de IVA integrable',
        'sitemap'          => 'Mapa del sitio',
        'llms_data'        => 'llms.txt - Datos para IA/LLM',
        'vat_rates_api'    => 'API de tipos de IVA (JSON)',
        'xml_sitemap'      => 'Mapa del sitio XML',
        'pdf_tools'        => 'Herramientas PDF - BusinessPress',
        'eu_vies'          => 'Validación VIES de la UE',
        'eu_vat_guide'     => 'Guía del IVA de la UE',
    ],

    // ── Home Page ───────────────────────────────────────────────────────
    'home_page' => [
        'title'          => 'EU VAT Info - Calculadora de tipos de IVA e información para todos los países de la UE',
        'meta_desc'      => 'Tipos de IVA actualizados para los 27 países de la UE. Calculadora en línea gratuita, datos históricos desde 2000, alertas de cambios de tipos y guías de cumplimiento. Actualizado diariamente.',
        'heading'        => 'Tipos de IVA en la',
        'heading_accent' => 'Unión Europea',
        'subtitle'       => 'Tipos de IVA estándar, tipos reducidos y calculadora para los 27 estados miembros de la UE. Actualizado diariamente.',
        'search_placeholder' => 'Buscar un país...',
        'th_country'     => 'País',
        'th_standard'    => 'Tipo estándar',
        'th_reduced'     => 'Reducido',
        'th_actions'     => 'Acciones',
        'view_full'      => 'Ver calculadora completa e historial',
    ],

    // ── VAT Calculator ──────────────────────────────────────────────────
    'calculator' => [
        'title'              => 'Calculadora de IVA',
        'calculate_instantly' => 'Calcula los tipos de IVA al instante',
        'amount'             => 'Importe',
        'vat_rate'           => 'Tipo de IVA',
        'custom_rate'        => 'Tipo personalizado',
        'any_percent'        => 'Cualquier %',
        'enter_custom'       => 'Introduce cualquier porcentaje de IVA del 0% al 100%',
        'custom_desc'        => 'Introduce cualquier porcentaje de IVA para tu cálculo',
        'calculation_mode'   => 'Modo de cálculo',
        'includes_vat'       => 'IVA incluido',
        'excludes_vat'       => 'IVA no incluido',
        'extract_vat'        => 'Extraer IVA del total',
        'add_vat'            => 'Añadir IVA al importe neto',
        'net_amount'         => 'Importe neto',
        'total_to_pay'       => 'Total a pagar',
    ],

    // ── VAT Map ─────────────────────────────────────────────────────────
    'map' => [
        'title'            => 'Mapa de tipos de IVA europeos',
        'subtitle'         => 'Mapa interactivo que muestra los tipos de IVA estándar actuales en los 27 estados miembros de la UE. Pasa el cursor sobre cualquier país para ver su tipo, o haz clic para ver todos los detalles y acceder a la calculadora.',
        'all_rates'        => 'Todos los tipos de IVA de la UE de un vistazo',
        'th_country'       => 'País',
        'th_standard'      => 'Estándar',
        'th_reduced'       => 'Reducido',
        'th_super_reduced' => 'Superreducido',
        'th_actions'       => 'Acciones',
        'calculator_link'  => 'Calculadora',
        'understanding'    => 'Comprender los tipos de IVA de la UE',
        'understanding_desc' => 'La UE exige a los estados miembros aplicar un tipo de IVA estándar de al menos el 15%. Los tipos oscilan entre el 17% (Luxemburgo) y el 27% (Hungría).',
        'standard_range'   => 'Tipos estándar: 17% – 27%',
        'reduced_essentials' => 'Tipos reducidos para productos esenciales',
        'special_schemes'  => 'Regímenes especiales para territorios',
        'using_calculator' => 'Uso de la calculadora de IVA',
        'using_calc_desc'  => 'Haz clic en cualquier país del mapa o utiliza la tabla para acceder a las herramientas de IVA:',
        'calc_inclusive'   => 'Calcular IVA incluido/excluido',
        'view_rate_types'  => 'Ver todos los tipos aplicables',
        'validate_vat'     => 'Validar números de IVA a través del VIES',
    ],

    // ── VAT History / Changes ───────────────────────────────────────────
    'history' => [
        'title'            => 'Historial de cambios en los tipos de IVA',
        'meta_title'       => 'Historial de cambios en los tipos de IVA - Países de la UE | EU VAT Info',
        'meta_desc'        => 'Historial completo de los cambios en los tipos de IVA en todos los países de la UE desde 2000. Seguimiento de modificaciones en tipos estándar y reducidos con indicadores de estabilidad por país.',
        'subtitle'         => 'Seguimiento de todas las modificaciones de tipos de IVA en los países de la UE durante la última década',
        'stability_title'  => 'Indicadores de estabilidad por país',
        'stability_desc'   => 'Los países con menos cambios en los tipos de IVA indican entornos fiscales más estables',
        'changes'          => 'cambios',
        'excellent'        => 'Excelente',
        'good'             => 'Bueno',
        'moderate'         => 'Moderado',
        'frequent'         => 'Frecuente',
        'all_countries'    => 'Todos los países',
        'rate_type'        => 'Tipo de gravamen',
        'all_types'        => 'Todos los tipos',
        'standard_rate'    => 'Tipo estándar',
        'reduced_rate'     => 'Tipo reducido',
        'super_reduced_rate' => 'Tipo superreducido',
        'parking_rate'     => 'Tipo de estacionamiento',
        'all_changes'      => 'Todos los cambios (últimos 10 años)',
        'effective_from'   => 'en vigor desde :date',
        'valid_until'      => 'Válido hasta: :date',
        'currently_active' => 'Actualmente vigente',
        'view_calculator'  => 'Ver calculadora',
        'no_changes'       => 'No se encontraron cambios en los tipos de IVA que coincidan con tus criterios',
    ],

    // ── VAT Rate Changes Widget ─────────────────────────────────────────
    'rate_changes' => [
        'title'            => 'Cambios en los tipos de IVA',
        'upcoming'         => 'Próximos cambios',
        'recent'           => 'Cambios recientes',
        'no_changes'       => 'No hay cambios recientes o próximos en los tipos de IVA',
        'full_history'     => 'Historial completo del IVA',
        'explore_map'      => 'Explorar mapa del IVA',
    ],

    // ── Country Page ────────────────────────────────────────────────────
    'country_page' => [
        'vat_rates'       => 'Tipos de IVA',
        'standard_rate'   => 'Tipo estándar',
        'reduced_rate'    => 'Tipo reducido',
        'super_reduced'   => 'Tipo superreducido',
        'parking_rate'    => 'Tipo de estacionamiento',
        'zero_rate'       => 'Tipo cero',
        'vat_calculator'  => 'Calculadora de IVA',
        'vat_validator'   => 'Validador de IVA',
        'vat_history'     => 'Historial del IVA',
        'vat_guide'       => 'Guía del IVA',
        'related'         => 'Países relacionados',
    ],

    // ── Breadcrumbs ─────────────────────────────────────────────────────
    'breadcrumbs' => [
        'home'           => 'Inicio',
        'vat_calculator' => 'Calculadora de IVA',
        'vat_map'        => 'Mapa del IVA',
        'vat_changelog'  => 'Registro de cambios del IVA',
        'sitemap'        => 'Mapa del sitio',
    ],

    // ── HTML Sitemap ────────────────────────────────────────────────────
    'sitemap' => [
        'title'           => 'Mapa del sitio',
        'subtitle'        => 'Explora todas las páginas de EU VAT Info. Encuentra calculadoras de IVA, guías por país, validadores de tipos y herramientas para los 27 estados miembros de la Unión Europea.',
        'main_pages'      => 'Páginas principales',
        'api_data'        => 'API y datos',
        'country_pages'   => 'Páginas por país',
        'home_all'        => 'Inicio - Todos los países de la UE',
        'home_desc'       => 'Resumen de los tipos de IVA de los 27 estados miembros de la UE',
        'calculator'      => 'Calculadora de IVA',
        'calculator_desc' => 'Calcula importes de IVA para cualquier país de la UE con tipos personalizados',
        'map'             => 'Mapa interactivo del IVA',
        'map_desc'        => 'Mapa de calor visual de los tipos de IVA estándar en Europa',
        'embed'           => 'Widget de IVA integrable',
        'embed_desc'      => 'Integra la calculadora de IVA en tu propio sitio web',
        'history'               => 'Historial de tipos de IVA',
        'history_desc'          => 'Historial completo de los cambios en los tipos de IVA en todos los países de la UE',
        'heading'               => 'Mapa del',
        'heading_accent'        => 'Sitio',
        'meta_title'            => 'Mapa del sitio HTML – Todas las páginas de IVA UE | EU VAT Info',
        'meta_desc'             => 'Mapa del sitio completo de EU VAT Info. Explore todas las páginas, incluyendo calculadoras de IVA, guías de países, validadores y herramientas para los 27 estados miembros de la UE.',
        'schema_name'           => 'EU VAT Info – Mapa del sitio completo',
        'schema_desc'           => 'Explore todas las páginas de EU VAT Info, incluyendo calculadoras de IVA por país, validadores, guías y herramientas.',
        'external_resources'    => 'Recursos externos',
        'all_country_pages'     => 'Todas las páginas de IVA por país de la UE',
        'country_pages_desc'    => 'Explore información de IVA, calculadoras y validadores para cada estado miembro de la UE.',
        'standard_rate_label'   => 'Tipo general:',
        'overview_guide'        => ':country – Visión general y guía del IVA',
        'country_calculator'    => ':country – Calculadora de IVA',
        'validate_numbers'      => 'Validar números de IVA de :country',
        'standalone_calculator' => ':country – Calculadora independiente',
        'llms_txt'              => 'llms.txt – Documentación IA/LLM',
        'llms_txt_desc'         => 'Datos estructurados para agentes de IA y modelos de lenguaje',
        'full_vat_rates'        => 'Todos los tipos de IVA (Markdown)',
        'full_vat_rates_desc'   => 'Tabla Markdown completa de todos los tipos de IVA de la UE',
        'json_api'              => 'API JSON para IA/RAG',
        'json_api_desc'         => 'Endpoint JSON optimizado para RAG y recuperación de contexto LLM',
        'xml_sitemap'           => 'XML Sitemap',
        'xml_sitemap_desc'      => 'Mapa del sitio legible por máquina para motores de búsqueda',
        'vies_validation'       => 'Validación IVA VIES UE',
        'vies_desc'             => 'Verificación oficial de números de IVA de la Comisión Europea',
        'europe_guide'          => 'Your Europe – Guía del IVA',
        'europe_guide_desc'     => 'Guía oficial de la UE sobre el IVA para empresas',
        'pdf_tools'             => 'Herramientas PDF de BusinessPress',
        'pdf_tools_desc'        => 'Herramientas PDF en línea gratuitas para facturas y documentos',
        'github_repo'           => 'GitHub Repository',
        'github_desc'           => 'Código fuente abierto de EU VAT Info',
        'about_title'           => 'Acerca de EU VAT Info',
        'about_p1'              => 'EU VAT Info proporciona información completa y actualizada diariamente sobre el IVA para los 27 estados miembros de la Unión Europea. Utilice nuestra :calculator_link para calcular importes de IVA al instante, explore el :map_link para visualizar los tipos en toda Europa, o consulte las 27 páginas de países a continuación para guías detalladas del IVA y validadores.',
        'about_p2'              => 'Cada página de país incluye una guía detallada del IVA, una calculadora específica del país con soporte de tipos personalizados, y un validador de números de IVA con tecnología VIES. Los desarrolladores y agentes de IA pueden acceder a nuestros datos a través del estándar :llms_link o la :api_link.',
        'about_llms_label'      => 'llms.txt',
        'about_api_label'       => 'JSON API',
    ],

    // ── 404 Page ────────────────────────────────────────────────────────
    'error_404' => [
        'title'             => 'Página no encontrada',
        'meta_title'        => 'Página no encontrada - EU VAT Info',
        'meta_desc'         => 'La página que buscabas no se pudo encontrar. Consulta tipos de IVA, calculadoras y guías de países de los 27 Estados miembros de la UE.',
        'heading'           => '¡Vaya! Página no encontrada',
        'message'           => 'La página que buscas no existe o ha sido movida. No te preocupes — hay mucha información útil sobre el IVA para explorar.',
        'back'              => 'Volver al inicio',
        'search_hint'       => 'Prueba uno de estos:',
        'popular_tools'     => 'Herramientas de IVA',
        'popular_countries' => 'Países UE populares',
        'all_countries_cta' => 'Ver los 27 países de la UE',
        'explore_resources' => 'Recursos y datos',
        'tool_calculator'      => 'Calculadora de IVA',
        'tool_calculator_desc' => 'Calcula el IVA al instante para cualquier país de la UE con tipos estándar o personalizados.',
        'tool_map'             => 'Mapa interactivo del IVA',
        'tool_map_desc'        => 'Visualiza y compara los tipos de IVA en todos los Estados miembros de la UE.',
        'tool_history'         => 'Historial de tipos de IVA',
        'tool_history_desc'    => 'Sigue los cambios de tipos de IVA en Europa desde 2000.',
        'tool_validator'       => 'Validador de número de IVA',
        'tool_validator_desc'  => 'Verifica números de IVA de la UE a través del sistema VIES oficial.',
        'resource_api'         => 'API de tipos de IVA (JSON)',
        'resource_api_desc'    => 'Accede a los datos de tipos de IVA de la UE mediante nuestro endpoint JSON.',
        'resource_llms'        => 'llms.txt - Datos IA/LLM',
        'resource_llms_desc'   => 'Datos de IVA estructurados para agentes de IA y modelos de lenguaje.',
        'resource_sitemap'     => 'Mapa del sitio completo',
        'resource_sitemap_desc' => 'Explora todas las páginas de EU VAT Info.',
        'resource_github'      => 'Repositorio GitHub',
        'resource_github_desc' => 'Código fuente abierto detrás de EU VAT Info.',
    ],

    // ── Bottom Navigation ───────────────────────────────────────────────
    'bottom_nav' => [
        'home'       => 'Inicio',
        'calculator' => 'Calculadora',
        'map'        => 'Mapa',
        'history'    => 'Historial',
    ],

    // ── Country Stats ───────────────────────────────────────────────────
    'stats' => [
        'standard_rate'    => 'Tipo estándar',
        'reduced_rate'     => 'Tipo reducido',
        'super_reduced'    => 'Superreducido',
        'parking_rate'     => 'Tipo de estacionamiento',
        'eu_rank'          => 'Posición en la UE',
        'currency'         => 'Moneda',
        'last_updated'     => 'Última actualización',
    ],

    // ── Useful Links ────────────────────────────────────────────────────
    'useful_links' => [
        'title'          => 'Recursos útiles',
        'eu_commission'  => 'Comisión Europea – IVA',
        'vies_service'   => 'Validación del IVA VIES',
        'your_europe'    => 'Tu Europa – IVA',
        'tax_authority'  => 'Autoridad tributaria nacional',
    ],

    // ── Validator ───────────────────────────────────────────────────────
    'validator' => [
        'title'           => 'Validador de número de IVA',
        'subtitle'        => 'Valida números de IVA de la UE a través del sistema VIES',
        'enter_number'    => 'Introduce el número de IVA',
        'validate'        => 'Validar',
        'valid'           => 'Válido',
        'invalid'         => 'No válido',
        'company_name'    => 'Nombre de la empresa',
        'company_address' => 'Dirección de la empresa',
        'request_date'    => 'Fecha de consulta',
    ],

    // ── Language Switcher ───────────────────────────────────────────────
    'language_switcher' => [
        'label'    => 'Idioma',
        'current'  => 'Idioma actual: :name',
    ],
];
