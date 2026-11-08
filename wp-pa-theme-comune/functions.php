<?php
/**
 * WP Digital Italia - Comuni (child di wp-pa-theme): carica il profilo cromatico dopo gli stili del parent.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style(
		'wp-pa-theme-comune-profile',
		get_stylesheet_directory_uri() . '/assets/css/profile.css',
		array( 'theme-dist-style', 'digital-italia-style' ),
		wp_get_theme()->get( 'Version' )
	);
}, 20 );

/**
 * Varianti header/footer del profilo Comune.
 */
add_filter( 'dci_header_variant', fn() => 'comune' );
add_filter( 'dci_footer_variant', fn() => 'comune' );

/**
 * Enti di appartenenza mostrati nella fascia alta.
 */
add_filter( 'dci_parent_entities', function ( array $entities ): array {
	if ( $entities ) {
		return $entities;
	}
	return array(
		array(
			'name' => 'Regione Lombardia',
			'url'  => 'https://www.regione.lombardia.it/',
		),
		array(
			'name' => 'Città Metropolitana di Milano',
			'url'  => 'https://www.cittametropolitana.mi.it/',
		),
	);
} );

/**
 * Area personale: se il sito non ha una pagina dedicata si usa il login.
 */
add_filter( 'dci_area_personale', function ( array $area ): array {
	if ( empty( $area['url'] ) ) {
		$area['url'] = wp_login_url();
	}
	$area['label'] = $area['label'] ?: __( 'Accedi all\'area personale', 'wp-digital-italia' );
	return $area;
} );

/**
 * Valori di default del Customizer per il profilo Comune.
 */
add_filter( 'theme_mod_site_contact_city', fn( $v ) => $v ?: 'Montesole' );
add_filter( 'theme_mod_site_contact_address', fn( $v ) => $v ?: 'Piazza del Municipio 1' );
