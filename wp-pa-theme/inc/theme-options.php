<?php
/**
 * Opzioni tema (Customizer): layout boxed/full e hero slider della home.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function dci_layout_mode(): string {
	$mode = get_theme_mod( 'dci_layout_mode', 'boxed' );
	return 'full' === $mode ? 'full' : 'boxed';
}

add_action( 'customize_register', function ( WP_Customize_Manager $wp ) {
	$wp->add_section( 'dci_layout', array(
		'title'    => __( 'Layout e Home', 'wp-digital-italia' ),
		'priority' => 30,
	) );

	$wp->add_setting( 'dci_layout_mode', array(
		'default'           => 'boxed',
		'sanitize_callback' => fn( $v ) => 'full' === $v ? 'full' : 'boxed',
	) );
	$wp->add_control( 'dci_layout_mode', array(
		'section' => 'dci_layout',
		'label'   => __( 'Larghezza del sito', 'wp-digital-italia' ),
		'type'    => 'radio',
		'choices' => array(
			'boxed' => __( 'Boxed (contenuto centrato, con margini)', 'wp-digital-italia' ),
			'full'  => __( 'Full width (a tutta larghezza)', 'wp-digital-italia' ),
		),
	) );

	$wp->add_setting( 'dci_hero_enabled', array( 'default' => true, 'sanitize_callback' => 'rest_sanitize_boolean' ) );
	$wp->add_control( 'dci_hero_enabled', array(
		'section' => 'dci_layout',
		'label'   => __( 'Mostra lo slider delle news in home', 'wp-digital-italia' ),
		'type'    => 'checkbox',
	) );

	$wp->add_setting( 'dci_hero_count', array( 'default' => 5, 'sanitize_callback' => fn( $v ) => max( 1, min( 10, (int) $v ) ) ) );
	$wp->add_control( 'dci_hero_count', array(
		'section'     => 'dci_layout',
		'label'       => __( 'Numero di news nello slider', 'wp-digital-italia' ),
		'type'        => 'number',
		'input_attrs' => array( 'min' => 1, 'max' => 10 ),
	) );

	$wp->add_setting( 'dci_hero_autoplay', array( 'default' => true, 'sanitize_callback' => 'rest_sanitize_boolean' ) );
	$wp->add_control( 'dci_hero_autoplay', array(
		'section' => 'dci_layout',
		'label'   => __( 'Scorrimento automatico (con pulsante pausa)', 'wp-digital-italia' ),
		'type'    => 'checkbox',
	) );

	$wp->add_setting( 'dci_hero_category', array( 'default' => 0, 'sanitize_callback' => 'absint' ) );
	$wp->add_control( 'dci_hero_category', array(
		'section' => 'dci_layout',
		'label'   => __( 'Categoria delle news (vuoto = tutte)', 'wp-digital-italia' ),
		'type'    => 'select',
		'choices' => array( 0 => __( 'Tutte', 'wp-digital-italia' ) ) + wp_list_pluck( get_categories( array( 'hide_empty' => false ) ), 'name', 'term_id' ),
	) );
} );

add_filter( 'body_class', function ( array $classes ): array {
	$classes[] = 'layout-' . dci_layout_mode();
	return $classes;
} );

/** URL immagine placeholder (ciclica) per lo slider. */
function dci_hero_placeholder( int $index ): string {
	return get_template_directory_uri() . '/assets/images/hero-placeholder-' . ( $index % 3 + 1 ) . '.svg';
}

/** Senza logo caricato, mostra il nome del sito come marchio testuale. */
add_filter( 'get_custom_logo', function ( $html ) {
	if ( $html ) {
		return $html;
	}
	return sprintf(
		'<a class="dci-brand-text" href="%s" rel="home">%s</a>',
		esc_url( home_url( '/' ) ),
		esc_html( get_bloginfo( 'name' ) )
	);
} );
