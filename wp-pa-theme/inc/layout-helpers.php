<?php
/**
 * Helper per i layout "portale sanitario" (home, strutture, organigramma, bandi).
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Icona dallo sprite Bootstrap Italia. */
function dci_icon( string $name, string $class = 'icon icon-sm' ): string {
	return sprintf(
		'<svg class="%s" aria-hidden="true"><use href="%s/dist/images/sprites.svg#it-%s"></use></svg>',
		esc_attr( $class ),
		esc_url( get_template_directory_uri() ),
		esc_attr( $name )
	);
}

/** Nome completo di una persona (CPT persona). */
function dci_persona_nome( int $persona_id ): string {
	$nome    = get_post_meta( $persona_id, '_dci_persona_nome', true );
	$cognome = get_post_meta( $persona_id, '_dci_persona_cognome', true );
	$full    = trim( $nome . ' ' . $cognome );
	return $full ?: get_the_title( $persona_id );
}

/** Collegamenti rapidi (fascia "Scopri come fare per" e box in sidebar): [label, icona, url]. */
function dci_quick_links(): array {
	$org = dci_get_template_page_url( 'page-templates/page-organigramma.php' );
	$all = array(
		array( __( 'Strutture', 'wp-digital-italia' ), 'pa', get_post_type_archive_link( 'dipartimento' ) ),
		array( __( 'Organigramma', 'wp-digital-italia' ), 'user', $org ),
		array( __( 'Bandi e concorsi', 'wp-digital-italia' ), 'files', dci_bandi_url() ),
		array( __( 'Notizie', 'wp-digital-italia' ), 'calendar', get_permalink( (int) get_option( 'page_for_posts' ) ) ?: '' ),
		array( __( 'Persone', 'wp-digital-italia' ), 'user', get_post_type_archive_link( 'persona' ) ),
	);
	return array_values( array_filter( $all, fn( $t ) => ! empty( $t[2] ) ) );
}

/**
 * Voci del box di navigazione della sidebar, in base al contesto.
 *
 * @return array{0:string,1:array<int,array{0:string,1:string,2:bool}>} [titolo, [[label, url, corrente], ...]]
 */
function dci_sidebar_nav(): array {
	$items = array();
	$title = __( 'Esplora', 'wp-digital-italia' );
	$here  = get_queried_object_id();

	if ( is_page() ) {
		$root     = array_slice( array_reverse( get_post_ancestors( $here ) ), 0, 1 );
		$root_id  = $root ? (int) $root[0] : $here;
		$children = get_pages( array( 'child_of' => $root_id, 'sort_column' => 'menu_order,post_title' ) );
		if ( $children ) {
			$title = get_the_title( $root_id );
			foreach ( $children as $c ) {
				$items[] = array( get_the_title( $c ), get_permalink( $c ), (int) $c->ID === $here );
			}
		}
	} elseif ( is_post_type_archive( 'dipartimento' ) || is_singular( 'dipartimento' ) ) {
		$title = __( 'Strutture', 'wp-digital-italia' );
		foreach ( get_posts( array( 'post_type' => 'dipartimento', 'post_parent' => 0, 'numberposts' => -1, 'orderby' => 'menu_order title', 'order' => 'ASC' ) ) as $d ) {
			$items[] = array( get_the_title( $d ), get_permalink( $d ), (int) $d->ID === $here );
		}
	} elseif ( is_home() || is_singular( 'post' ) || is_category() || is_search() || is_archive() ) {
		$title = __( 'Notizie', 'wp-digital-italia' );
		foreach ( get_categories( array( 'hide_empty' => true, 'exclude' => array( (int) get_option( 'default_category' ) ) ) ) as $c ) {
			$items[] = array( $c->name, get_category_link( $c ), is_category( $c->term_id ) );
		}
	}

	if ( ! $items ) {
		// Fallback: voci di primo livello del menu principale.
		$locations = get_nav_menu_locations();
		if ( ! empty( $locations['main-menu'] ) ) {
			foreach ( (array) wp_get_nav_menu_items( $locations['main-menu'] ) as $m ) {
				if ( 0 === (int) $m->menu_item_parent ) {
					$items[] = array( $m->title, $m->url, (bool) $m->current );
				}
			}
		}
	}
	return array( $title, $items );
}

/** Data breve in maiuscolo, es. "6 NOV 2026". */
function dci_short_date( $post = null ): string {
	return mb_strtoupper( get_the_date( 'j M Y', $post ) );
}

/** Immagine di un articolo: URL della thumbnail o stringa vuota (la card mostra il placeholder). */
function dci_post_image_url( $post = null, string $size = 'large' ): string {
	return has_post_thumbnail( $post ) ? (string) get_the_post_thumbnail_url( $post, $size ) : '';
}

/** Ultimi articoli come WP_Query. */
function dci_latest_posts( int $n = 6, int $offset = 0 ): WP_Query {
	return new WP_Query( array(
		'posts_per_page'      => $n,
		'offset'              => $offset,
		'post_status'         => 'publish',
		'ignore_sticky_posts' => true,
	) );
}

/** URL dei bandi: la gestione dei bandi e' del plugin amministrazione-trasparente. */
function dci_bandi_url(): string {
	return function_exists( 'at_bandi_url' ) ? at_bandi_url() : '';
}

/** Ultimi bandi (plugin amministrazione-trasparente); query vuota se il plugin non e' attivo. */
function dci_latest_bandi( int $n = 5 ): WP_Query {
	if ( function_exists( 'at_bandi_ultimi' ) ) {
		return at_bandi_ultimi( $n );
	}
	return new WP_Query( array( 'post__in' => array( 0 ) ) );
}

/**
 * Integrazione con il plugin amministrazione-trasparente (gestione dei bandi):
 * breadcrumb e menu laterale li disegna il tema, il plugin produce solo contenuto ed elenco.
 */
add_filter(
	'at_bandi_layout',
	static function ( array $layout ): array {
		$layout['breadcrumb'] = false;
		$layout['sidebar']    = false;
		$layout['title']      = false;
		return $layout;
	}
);
