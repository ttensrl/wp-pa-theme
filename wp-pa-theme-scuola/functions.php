<?php
/**
 * WP Digital Italia - Scuole (child di wp-pa-theme): carica il profilo cromatico dopo gli stili del parent.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style(
		'wp-pa-theme-scuola-profile',
		get_stylesheet_directory_uri() . '/assets/css/profile.css',
		array( 'theme-dist-style', 'digital-italia-style' ),
		wp_get_theme()->get( 'Version' )
	);
}, 20 );

/**
 * Varianti header/footer del profilo Scuola.
 */
add_filter( 'dci_header_variant', fn() => 'scuola' );
add_filter( 'dci_footer_variant', fn() => 'scuola' );

/**
 * Pre-header: Ministero come ente di appartenenza.
 */
add_filter( 'dci_parent_entities', function ( array $entities ): array {
	if ( $entities ) {
		return $entities;
	}
	return array(
		array(
			'name' => 'Ministero dell\'Istruzione e del Merito',
			'url'  => 'https://www.miur.gov.it/',
		),
	);
} );

/**
 * Area riservata: se il sito non ha una pagina dedicata si usa il login.
 */
add_filter( 'dci_area_personale', function ( array $area ): array {
	if ( empty( $area['url'] ) ) {
		$area['url'] = wp_login_url();
	}
	$area['label'] = $area['label'] ?: __( 'Area riservata', 'wp-digital-italia' );
	return $area;
} );

/**
 * Valori di default del Customizer per il profilo Scuola.
 */
add_filter( 'theme_mod_site_contact_city', fn( $v ) => $v ?: 'Montesole' );
add_filter( 'theme_mod_site_contact_address', fn( $v ) => $v ?: 'Via della Scuola 5' );
