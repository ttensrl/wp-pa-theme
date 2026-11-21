<?php
/**
 * Tipi di contenuto del museo: sedi, mostre ed eventi, opere.
 *
 * @package digital-italia
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', function () {
	$common = array(
		'public'       => true,
		'show_in_rest' => true,
		'has_archive'  => true,
		'menu_position' => 6,
	);

	register_post_type( 'sede', $common + array(
		'label'     => __( 'Sedi', 'wp-digital-italia-musei' ),
		'labels'    => array(
			'name'          => __( 'Sedi', 'wp-digital-italia-musei' ),
			'singular_name' => __( 'Sede', 'wp-digital-italia-musei' ),
			'add_new_item'  => __( 'Aggiungi sede', 'wp-digital-italia-musei' ),
			'edit_item'     => __( 'Modifica sede', 'wp-digital-italia-musei' ),
		),
		'menu_icon' => 'dashicons-building',
		'supports'  => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
		'rewrite'   => array( 'slug' => 'sedi' ),
	) );

	register_post_type( 'mostra', $common + array(
		'label'     => __( 'Mostre ed eventi', 'wp-digital-italia-musei' ),
		'labels'    => array(
			'name'          => __( 'Mostre ed eventi', 'wp-digital-italia-musei' ),
			'singular_name' => __( 'Mostra o evento', 'wp-digital-italia-musei' ),
			'add_new_item'  => __( 'Aggiungi mostra o evento', 'wp-digital-italia-musei' ),
			'edit_item'     => __( 'Modifica mostra o evento', 'wp-digital-italia-musei' ),
		),
		'menu_icon' => 'dashicons-calendar-alt',
		'supports'  => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'rewrite'   => array( 'slug' => 'mostre-ed-eventi' ),
	) );

	register_post_type( 'opera', $common + array(
		'label'     => __( 'Opere', 'wp-digital-italia-musei' ),
		'labels'    => array(
			'name'          => __( 'Opere', 'wp-digital-italia-musei' ),
			'singular_name' => __( 'Opera', 'wp-digital-italia-musei' ),
			'add_new_item'  => __( 'Aggiungi opera', 'wp-digital-italia-musei' ),
			'edit_item'     => __( 'Modifica opera', 'wp-digital-italia-musei' ),
		),
		'menu_icon' => 'dashicons-art',
		'supports'  => array( 'title', 'editor', 'thumbnail' ),
		'rewrite'   => array( 'slug' => 'opere' ),
	) );
} );

/** Campi aggiuntivi (CMB2, gia' incluso nel parent). */
add_action( 'cmb2_admin_init', function () {
	if ( ! function_exists( 'new_cmb2_box' ) ) {
		return;
	}

	$sede = new_cmb2_box( array(
		'id'           => '_mu_sede_box',
		'title'        => __( 'Informazioni della sede', 'wp-digital-italia-musei' ),
		'object_types' => array( 'sede' ),
	) );
	$sede->add_field( array( 'id' => '_mu_sede_indirizzo', 'name' => __( 'Indirizzo', 'wp-digital-italia-musei' ), 'type' => 'text' ) );
	$sede->add_field( array( 'id' => '_mu_sede_apre', 'name' => __( 'Apertura (es. 9.00)', 'wp-digital-italia-musei' ), 'type' => 'text_small' ) );
	$sede->add_field( array( 'id' => '_mu_sede_chiude', 'name' => __( 'Chiusura (es. 17.00)', 'wp-digital-italia-musei' ), 'type' => 'text_small' ) );

	$mostra = new_cmb2_box( array(
		'id'           => '_mu_mostra_box',
		'title'        => __( 'Date e tipo', 'wp-digital-italia-musei' ),
		'object_types' => array( 'mostra' ),
	) );
	$mostra->add_field( array(
		'id'      => '_mu_mostra_tipo',
		'name'    => __( 'Tipo', 'wp-digital-italia-musei' ),
		'type'    => 'radio_inline',
		'options' => array( 'mostra' => __( 'Mostra', 'wp-digital-italia-musei' ), 'evento' => __( 'Evento', 'wp-digital-italia-musei' ) ),
		'default' => 'mostra',
	) );
	$mostra->add_field( array( 'id' => '_mu_mostra_dal', 'name' => __( 'Dal', 'wp-digital-italia-musei' ), 'type' => 'text_date', 'date_format' => 'Y-m-d' ) );
	$mostra->add_field( array( 'id' => '_mu_mostra_al', 'name' => __( 'Al (vuoto per un solo giorno)', 'wp-digital-italia-musei' ), 'type' => 'text_date', 'date_format' => 'Y-m-d' ) );

	$opera = new_cmb2_box( array(
		'id'           => '_mu_opera_box',
		'title'        => __( 'Opera', 'wp-digital-italia-musei' ),
		'object_types' => array( 'opera' ),
	) );
	$opera->add_field( array( 'id' => '_mu_opera_artista', 'name' => __( 'Artista', 'wp-digital-italia-musei' ), 'type' => 'text' ) );
} );
