<?php
/**
 * Child theme Musei civici di WP Digital Italia (wp-pa-theme).
 *
 * Il parent carica gia' dist/css/main.css e lo style.css del tema attivo;
 * qui si aggiunge il profilo grafico dei Musei e i tipi di contenuto del museo.
 *
 * @package digital-italia
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'MUSEI_CHILD_VERSION', wp_get_theme()->get( 'Version' ) );

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style(
		'musei-profile',
		get_stylesheet_directory_uri() . '/assets/css/musei.css',
		array( 'theme-dist-style', 'digital-italia-style' ),
		MUSEI_CHILD_VERSION
	);
	wp_enqueue_script(
		'musei-home',
		get_stylesheet_directory_uri() . '/assets/js/musei.js',
		array(),
		MUSEI_CHILD_VERSION,
		true
	);
}, 20 );

require_once __DIR__ . '/inc/post-types.php';

/** Varianti header/footer del profilo Musei. */
add_filter( 'dci_header_variant', fn() => 'musei' );
add_filter( 'dci_footer_variant', fn() => 'musei' );

/** Ente di appartenenza mostrato nella fascia alta ("Comune/Aggregatore"). */
add_filter( 'dci_parent_entities', function ( array $entities ): array {
	if ( $entities ) {
		return $entities;
	}
	return array( array( 'name' => 'Comune di Montesole', 'url' => home_url( '/' ) ) );
} );

/** Selezione lingua della fascia alta. */
add_filter( 'dci_topbar_language', fn() => 'ITA' );

/** Default del Customizer per il profilo Musei (usati finche' non si salva un valore). */
add_filter( 'theme_mod_site_contact_city', fn( $v ) => $v ?: 'Montesole' );
add_filter( 'theme_mod_site_contact_address', fn( $v ) => $v ?: 'Via San Vito 21, 01234 Montesole (RM)' );
add_filter( 'theme_mod_site_contact_phone', fn( $v ) => $v ?: '06 1234 5678' );
add_filter( 'theme_mod_site_contact_vat', fn( $v ) => $v ?: '01234567890' );

/** Testo dell'avviso sotto l'header (vuoto = nessun avviso). Modificabile con il Customizer o il filtro. */
function musei_alert_text(): string {
	$text = (string) get_theme_mod( 'musei_alert_text', '' );
	return (string) apply_filters( 'musei_alert_text', $text );
}

/** Data in italiano con il mese minuscolo, come nel prototipo ("25 settembre 2022"). */
function musei_format_date( $date ): string {
	$ts = is_numeric( $date ) ? (int) $date : strtotime( (string) $date );
	return mb_strtolower( wp_date( 'j F Y', $ts ) );
}

/** Intervallo di date di una mostra o di un evento, in italiano. */
function musei_date_range( int $post_id ): string {
	$dal = (string) get_post_meta( $post_id, '_mu_mostra_dal', true );
	$al  = (string) get_post_meta( $post_id, '_mu_mostra_al', true );
	if ( ! $dal ) {
		return '';
	}
	$fmt = static fn( string $d ): string => musei_format_date( $d );
	if ( ! $al || $al === $dal ) {
		return $fmt( $dal );
	}
	/* translators: 1: data iniziale, 2: data finale */
	return sprintf( __( 'Dal %1$s al %2$s', 'wp-digital-italia-musei' ), $fmt( $dal ), $fmt( $al ) );
}

/** Icona "segnaposto immagine" usata quando un contenuto non ha l'immagine in evidenza. */
function musei_placeholder_icon( int $size = 56 ): string {
	return '<svg class="mu-ph-icon" viewBox="0 0 108 56" width="' . $size * 2 . '" height="' . $size . '" aria-hidden="true"><path d="M0 51a5 5 0 0 1 5-5h10l28-33a4 4 0 0 1 6 0l15 17 9-9a3 3 0 0 1 5 0l30 25a5 5 0 0 1-3 9H5a5 5 0 0 1-5-4z" fill="currentColor"/><circle cx="85" cy="10" r="8" fill="currentColor"/></svg>';
}
