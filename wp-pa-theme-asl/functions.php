<?php
/**
 * Child theme ASL di WP Digital Italia (wp-pa-theme).
 *
 * Il parent carica gia' dist/css/main.css e lo style.css del tema attivo
 * (quello di questo child); qui si aggiunge solo il profilo grafico ASL.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ASL_CHILD_VERSION', wp_get_theme()->get( 'Version' ) );

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style(
		'asl-profile',
		get_stylesheet_directory_uri() . '/assets/css/asl.css',
		array( 'theme-dist-style', 'digital-italia-style' ),
		ASL_CHILD_VERSION
	);
}, 20 );

/**
 * Varianti header/footer del profilo ASL.
 */
add_filter( 'dci_header_variant', fn() => 'asl' );
add_filter( 'dci_footer_variant', fn() => 'asl' );

/**
 * Ente di appartenenza mostrato nella fascia alta (Regione Lazio / Salute Lazio).
 */
add_filter( 'dci_parent_entities', function ( array $entities ): array {
	if ( $entities ) {
		return $entities;
	}
	return array(
		array(
			'name' => 'Salute Lazio',
			'url'  => 'https://www.salutelazio.it/',
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
	$area['label'] = $area['label'] ?: __( 'Area personale', 'wp-digital-italia' );
	return $area;
} );

/**
 * Valori di default del Customizer per il profilo ASL
 * (usati solo finche' l'utente non salva un proprio valore).
 */
add_filter( 'theme_mod_site_contact_city', fn( $v ) => $v ?: 'Roma' );
add_filter( 'theme_mod_site_contact_address', fn( $v ) => $v ?: 'Via della Salute 1, 00100 Roma' );
