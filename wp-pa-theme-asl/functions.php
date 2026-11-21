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
 * Selezione lingua per la fascia alta (default ITA).
 * I child theme possono sovrascrivere questo valore tramite il filtro.
 */
add_filter( 'dci_topbar_language', function (): string {
	return 'ITA';
} );

/**
 * Valori di default del Customizer per il profilo ASL
 * (usati solo finche' l'utente non salva un proprio valore).
 */
add_filter( 'theme_mod_site_contact_city', fn( $v ) => $v ?: 'Roma' );
add_filter( 'theme_mod_site_contact_address', fn( $v ) => $v ?: 'Via della Salute 1, 00100 Roma' );

/**
 * Il post type "servizio" del parent non ha archivio: lo si attiva qui,
 * cosi' esiste la lista "Servizi e prestazioni" (/servizio/) prevista dal prototipo.
 */
add_filter( 'register_post_type_args', function ( array $args, string $post_type ): array {
	if ( 'servizio' === $post_type ) {
		$args['has_archive'] = true;
	}
	return $args;
}, 10, 2 );

/* ------------------------------------------------------------------ *
 *  Pagine di dettaglio e sidebar unificata (prototipo AGID)
 * ------------------------------------------------------------------ */

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_script(
		'asl-detail',
		get_stylesheet_directory_uri() . '/assets/js/asl.js',
		array(),
		ASL_CHILD_VERSION,
		true
	);
}, 20 );

/**
 * Voci dell'indice della pagina: array di [ etichetta, id ].
 * Le pagine di dettaglio lo valorizzano esplicitamente; per gli altri contenuti
 * viene ricavato dai titoli h2 del contenuto (che ricevono un id).
 */
function asl_set_page_index( array $items ): void {
	$GLOBALS['asl_page_index'] = $items;
}

add_filter( 'the_content', function ( string $content ): string {
	if ( ! is_singular() || ! in_the_loop() || ! is_main_query() ) {
		return $content;
	}
	return preg_replace_callback(
		'#<h2([^>]*)>(.*?)</h2>#is',
		function ( array $m ): string {
			$label = trim( wp_strip_all_tags( $m[2] ) );
			if ( '' === $label ) {
				return $m[0];
			}
			if ( preg_match( '#\sid=["\']([^"\']+)["\']#', $m[1], $id ) ) {
				$anchor = $id[1];
				$attrs  = $m[1];
			} else {
				$anchor = sanitize_title( $label );
				$attrs  = $m[1] . ' id="' . esc_attr( $anchor ) . '"';
			}
			$GLOBALS['asl_content_headings'][] = array( $label, $anchor );
			return '<h2' . $attrs . '>' . $m[2] . '</h2>';
		},
		$content
	);
}, 9 );

/** URL "Apri in mappa" da coordinate o indirizzo. */
function asl_map_url( string $address, $lat = '', $lng = '' ): string {
	if ( $lat && $lng ) {
		return 'https://www.openstreetmap.org/?mlat=' . rawurlencode( $lat ) . '&mlon=' . rawurlencode( $lng ) . '#map=17/' . rawurlencode( $lat ) . '/' . rawurlencode( $lng );
	}
	return 'https://www.openstreetmap.org/search?query=' . rawurlencode( $address );
}

/** Icona "link esterno" usata dai link alla mappa. */
function asl_external_icon(): string {
	return '<svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true"><path d="M14 4h6v6M20 4l-9 9M18 14v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h5" fill="none" stroke="currentColor" stroke-width="1.5"/></svg>';
}

/** Strutture che erogano un servizio (campo "Servizi erogati" del dipartimento). */
function asl_servizio_strutture( int $servizio_id ): array {
	$out = array();
	foreach ( get_posts( array( 'post_type' => 'dipartimento', 'numberposts' => -1, 'orderby' => 'title', 'order' => 'ASC' ) ) as $d ) {
		$ids = get_post_meta( $d->ID, '_dci_dipartimento_servizi', true );
		if ( is_array( $ids ) && in_array( (string) $servizio_id, array_map( 'strval', $ids ), true ) ) {
			$out[] = $d;
		}
	}
	return $out;
}

/* ------------------------------------------------------------------ *
 *  "Tutto per": tag trasversali a tutti i tipi di contenuto
 * ------------------------------------------------------------------ */

/** Tipi di contenuto che possono avere i tag (oltre agli articoli). */
function asl_tag_post_types(): array {
	return apply_filters( 'asl_tag_post_types', array( 'post', 'page', 'servizio', 'dipartimento', 'bando', 'persona' ) );
}

add_action( 'init', function () {
	foreach ( asl_tag_post_types() as $pt ) {
		if ( post_type_exists( $pt ) ) {
			register_taxonomy_for_object_type( 'post_tag', $pt );
		}
	}
}, 20 );

/** L'archivio di un tag elenca tutti i tipi di contenuto che lo usano. */
add_action( 'pre_get_posts', function ( WP_Query $q ) {
	if ( ! is_admin() && $q->is_main_query() && $q->is_tag() ) {
		$q->set( 'post_type', array_values( array_filter( asl_tag_post_types(), 'post_type_exists' ) ) );
	}
} );

/** Destinatari della sezione "Tutto per": ognuno corrisponde a un tag. */
function asl_targets(): array {
	return apply_filters( 'asl_targets', array(
		'Donne', 'Bambini', 'Prestatori di cura (caregiver)', 'Anziani',
		'Persone con disabilità', 'Animali', 'Imprese', 'Cittadini stranieri',
	) );
}

function asl_target_url( string $name ): string {
	$term = get_term_by( 'name', $name, 'post_tag' );
	if ( $term && ! is_wp_error( $term ) ) {
		return (string) get_term_link( $term );
	}
	return add_query_arg( 'tag', sanitize_title( $name ), home_url( '/' ) );
}

/** Crea i tag dei destinatari se mancano (all'attivazione del tema). */
function asl_ensure_target_tags(): void {
	foreach ( asl_targets() as $name ) {
		if ( ! term_exists( $name, 'post_tag' ) ) {
			wp_insert_term( $name, 'post_tag' );
		}
	}
}
add_action( 'after_switch_theme', 'asl_ensure_target_tags' );
