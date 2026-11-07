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
