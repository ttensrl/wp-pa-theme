<?php
/**
 * Sidebar unica del profilo ASL: "Indice della pagina" (prototipo AGID).
 *
 * - pagine di dettaglio: ancore alle sezioni (impostate con asl_set_page_index()
 *   oppure ricavate dai titoli h2 del contenuto);
 * - archivi, ricerca, pagine senza sezioni: navigazione della sezione corrente.
 *
 * @package digital-italia
 */

$items = array();
$mode  = 'section';
$title = __( 'Indice della pagina', 'wp-digital-italia-asl' );

if ( ! empty( $GLOBALS['asl_page_index'] ) ) {
	$source = $GLOBALS['asl_page_index'];
} elseif ( is_singular() && ! empty( $GLOBALS['asl_content_headings'] ) ) {
	$source = $GLOBALS['asl_content_headings'];
} else {
	$source = array();
}

if ( $source ) {
	$mode = 'anchors';
	foreach ( $source as $n => [ $label, $anchor ] ) {
		$items[] = array( $label, '#' . $anchor, 0 === $n );
	}
} else {
	[ $nav_title, $nav_items ] = dci_sidebar_nav();
	$title = $nav_title;
	$items = $nav_items;
}
?>
<aside id="secondary" class="asl-index-wrap" aria-label="<?php esc_attr_e( 'Menu laterale', 'wp-digital-italia-asl' ); ?>">
	<?php if ( $items ) : ?>
		<nav class="asl-index" data-asl-index="<?php echo esc_attr( $mode ); ?>" aria-labelledby="asl-index-title">
			<h2 id="asl-index-title" class="asl-index__title">
				<?php echo esc_html( $title ); ?>
				<svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true"><path d="M6 15l6-6 6 6" fill="none" stroke="currentColor" stroke-width="1.5"/></svg>
			</h2>
			<ul class="asl-index__list">
				<?php foreach ( $items as [ $label, $url, $current ] ) : ?>
					<li<?php echo $current ? ' class="is-current"' : ''; ?>><a href="<?php echo esc_url( $url ); ?>"<?php echo $current ? ' aria-current="' . ( 'anchors' === $mode ? 'location' : 'page' ) . '"' : ''; ?>><?php echo esc_html( $label ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</nav>
	<?php endif; ?>

	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
		<div class="asl-index-widgets"><?php dynamic_sidebar( 'sidebar-1' ); ?></div>
	<?php endif; ?>
</aside>
