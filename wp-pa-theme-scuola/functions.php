<?php
/**
 * WP Digital Italia - Scuole (child di wp-pa-theme), allineato al modello Design Scuole
 * di Designers Italia (https://italia.github.io/design-scuole-pagine-statiche/).
 *
 * @package digital-italia
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SCUOLA_CHILD_VERSION', wp_get_theme()->get( 'Version' ) );

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style(
		'wp-pa-theme-scuola-profile',
		get_stylesheet_directory_uri() . '/assets/css/scuola.css',
		array( 'theme-dist-style', 'digital-italia-style' ),
		SCUOLA_CHILD_VERSION
	);
}, 20 );

/** Varianti header/footer del profilo Scuola. */
add_filter( 'dci_header_variant', fn() => 'scuola' );
add_filter( 'dci_footer_variant', fn() => 'scuola' );

/** Fascia alta: Ministero come ente di appartenenza. */
add_filter( 'dci_parent_entities', function ( array $entities ): array {
	if ( $entities ) {
		return $entities;
	}
	return array(
		array(
			'name' => 'Ministero dell\'Istruzione e del Merito',
			'url'  => 'https://www.mim.gov.it/',
		),
	);
} );

/** Area riservata: se il sito non ha una pagina dedicata si usa il login. */
add_filter( 'dci_area_personale', function ( array $area ): array {
	if ( empty( $area['url'] ) ) {
		$area['url'] = wp_login_url();
	}
	$area['label'] = dci_mod( 'site_area_personale_label' ) ?: __( 'Accedi', 'wp-digital-italia' );
	return $area;
} );

/** Valori di default del Customizer per il profilo Scuola. */
add_filter( 'theme_mod_site_contact_city', fn( $v ) => $v ?: 'Montesole' );
add_filter( 'theme_mod_site_contact_address', fn( $v ) => $v ?: 'Via della Scuola 5' );

/** Anno scolastico corrente, nel formato del modello ("A.S. 2026 / 2027"). */
function scuola_school_year(): string {
	$y = (int) wp_date( 'Y' );
	$m = (int) wp_date( 'n' );
	$start = $m >= 9 ? $y : $y - 1;
	return sprintf( 'A.S. %d / %d', $start, $start + 1 );
}

/**
 * Argomenti della fascia in alto a destra: le categorie piu' usate (esclusa quella di default).
 * Modificabili con il filtro `scuola_topics` (array di [ etichetta, url ]).
 */
function scuola_topics( int $max = 3 ): array {
	$out = array();
	foreach ( get_categories( array( 'orderby' => 'count', 'order' => 'DESC', 'number' => $max, 'hide_empty' => true, 'exclude' => array( (int) get_option( 'default_category' ) ) ) ) as $c ) {
		$out[] = array( $c->name, get_category_link( $c ) );
	}
	return (array) apply_filters( 'scuola_topics', $out );
}

/** Stemma/logo della scuola, se configurato. */
function scuola_logo_url(): string {
	return dci_logo_url( 'dark' );
}

/** Pagina "La scuola" e archivio notizie, usati come destinazioni dei pulsanti principali. */
function scuola_page_url( string $slug ): string {
	$page = get_page_by_path( $slug );
	return $page ? (string) get_permalink( $page ) : home_url( '/' );
}
