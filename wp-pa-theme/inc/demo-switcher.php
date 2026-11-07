<?php
/**
 * Barra "demo" per passare da un sito all'altro della rete multisite.
 * Si attiva con l'opzione di rete `dci_demo_switcher` (wp network meta update 1 dci_demo_switcher 1)
 * ed e' pensata solo per le installazioni dimostrative.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_body_open', function () {
	if ( ! is_multisite() || ! get_site_option( 'dci_demo_switcher' ) || is_main_site() ) {
		return;
	}
	$current = get_current_blog_id();
	$labels  = array( 'comuni' => 'Comuni', 'asl' => 'ASL', 'scuole' => 'Scuole' );
	echo '<nav class="dci-demo-bar" aria-label="' . esc_attr__( 'Cambia demo', 'wp-digital-italia' ) . '"><div class="dci-demo-bar__in"><a class="dci-demo-bar__hub" href="' . esc_url( network_home_url( '/' ) ) . '">&larr; ' . esc_html__( 'Tutte le demo', 'wp-digital-italia' ) . '</a><ul>';
	foreach ( get_sites( array( 'public' => 1, 'orderby' => 'path', 'number' => 20 ) ) as $site ) {
		if ( (int) $site->blog_id === (int) get_main_site_id() ) {
			continue;
		}
		$slug  = trim( $site->path, '/' );
		$label = $labels[ $slug ] ?? get_blog_details( $site->blog_id )->blogname;
		printf(
			'<li><a href="%s"%s>%s</a></li>',
			esc_url( get_home_url( (int) $site->blog_id, '/' ) ),
			(int) $site->blog_id === $current ? ' aria-current="page" class="is-current"' : '',
			esc_html( $label )
		);
	}
	echo '</ul></div></nav>';
} );
