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
 * Valori di default del Customizer per il profilo ASL
 * (usati solo finche' l'utente non salva un proprio valore).
 */
add_filter( 'theme_mod_site_contact_city', fn( $v ) => $v ?: 'Roma' );
