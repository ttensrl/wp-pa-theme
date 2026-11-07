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

/** Stato di un bando: 'attivo' | 'scaduto' | ''. */
function dci_bando_stato( int $post_id ): string {
	$scadenza = get_post_meta( $post_id, '_dci_bando_data_scadenza', true );
	if ( empty( $scadenza ) ) {
		return '';
	}
	return strtotime( $scadenza . ' 23:59:59' ) < current_time( 'timestamp' ) ? 'scaduto' : 'attivo';
}

/** Nome completo di una persona (CPT persona). */
function dci_persona_nome( int $persona_id ): string {
	$nome    = get_post_meta( $persona_id, '_dci_persona_nome', true );
	$cognome = get_post_meta( $persona_id, '_dci_persona_cognome', true );
	$full    = trim( $nome . ' ' . $cognome );
	return $full ?: get_the_title( $persona_id );
}

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style(
		'dci-layouts',
		get_template_directory_uri() . '/assets/css/layouts.css',
		array( 'theme-dist-style' ),
		_S_VERSION
	);
}, 15 );
