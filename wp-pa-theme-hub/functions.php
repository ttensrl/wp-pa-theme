<?php
/**
 * Hub demo: landing di presentazione e accesso ai siti demo della rete multisite.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'hub-style', get_stylesheet_directory_uri() . '/assets/css/hub.css', array( 'theme-dist-style' ), wp_get_theme()->get( 'Version' ) );
}, 20 );

/** Demo disponibili: slug del sito nella rete => dati di presentazione. */
function hub_demos(): array {
	return array(
		'comuni' => array(
			'title' => 'Comuni',
			'tag'   => 'Enti locali',
			'color' => '#00796b',
			'text'  => 'Il portale del cittadino: uffici e servizi comunali, albo e bandi, notizie dal territorio.',
			'items' => array( 'Servizi anagrafici e tributi', 'Organigramma: Sindaco, Giunta, uffici', 'Avvisi, gare e concorsi' ),
		),
		'asl'    => array(
			'title' => 'ASL',
			'tag'   => 'Sanità',
			'color' => '#0066cc',
			'text'  => 'Il portale dell\'azienda sanitaria: strutture, prenotazioni, bandi e news per i pazienti.',
			'items' => array( 'Dipartimenti, distretti e presidi', 'Guida ai servizi e prenotazioni', 'Bandi di gara e concorsi' ),
		),
		'scuole' => array(
			'title' => 'Scuole',
			'tag'   => 'Istruzione',
			'color' => '#6a3fa0',
			'text'  => 'Il sito dell\'istituto: plessi, segreteria, circolari e avvisi per famiglie e studenti.',
			'items' => array( 'Plessi e uffici di segreteria', 'Iscrizioni, mensa, registro elettronico', 'Avvisi, PON e gare' ),
		),
	);
}

/** URL della home di un sito demo, o stringa vuota se il sito non esiste. */
function hub_demo_url( string $slug ): string {
	$site = get_site_by_path( get_network()->domain, get_network()->path . $slug . '/' );
	return $site ? get_home_url( (int) $site->blog_id, '/' ) : '';
}
