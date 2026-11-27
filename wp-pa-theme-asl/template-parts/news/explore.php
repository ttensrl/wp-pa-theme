<?php
/**
 * "Esplora per categoria" e "Parliamo di" delle liste di notizie.
 *
 * @package digital-italia
 */
$arrow = '<svg viewBox="0 0 24 24" width="28" height="28" aria-hidden="true"><path d="M9 4l8 8-8 8" fill="none" stroke="currentColor" stroke-width="1.5"/></svg>';
$items = array();
foreach ( get_categories( array( 'hide_empty' => true, 'exclude' => array( (int) get_option( 'default_category' ) ) ) ) as $c ) {
	$items[] = array(
		$c->name,
		get_category_link( $c ),
		$c->description ?: sprintf( /* translators: %d: numero di contenuti */ _n( '%d contenuto', '%d contenuti', $c->count, 'wp-digital-italia-asl' ), $c->count ),
	);
}
if ( dci_bandi_url() ) {
	$items[] = array( __( 'Bandi e concorsi', 'wp-digital-italia-asl' ), dci_bandi_url(), __( 'Avvisi pubblici, concorsi e selezioni per lavorare in ASL', 'wp-digital-italia-asl' ) );
}
$tags = get_tags( array( 'hide_empty' => true ) );
?>
<?php if ( $items ) : ?>
	<section class="asl-section" aria-labelledby="news-cat-title">
		<div class="container">
			<h2 id="news-cat-title" class="asl-section__title"><?php esc_html_e( 'Esplora per categoria', 'wp-digital-italia-asl' ); ?></h2>
			<div class="row g-5 asl-ghost-row">
				<?php foreach ( $items as [ $label, $url, $text ] ) : ?>
					<div class="col-md-4">
						<article class="asl-ghost">
							<h3><a href="<?php echo esc_url( $url ); ?>"><span><?php echo esc_html( $label ); ?></span><?php echo $arrow; // phpcs:ignore ?></a></h3>
							<p><?php echo esc_html( $text ); ?></p>
						</article>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php if ( $tags && ! is_wp_error( $tags ) ) : ?>
	<section class="asl-section asl-section--white asl-chips-section" aria-labelledby="news-tags-title">
		<div class="container">
			<h2 id="news-tags-title" class="asl-chips-title"><?php esc_html_e( 'Parliamo di', 'wp-digital-italia-asl' ); ?></h2>
			<ul class="asl-chips">
				<?php foreach ( $tags as $t ) : ?>
					<li><a href="<?php echo esc_url( get_tag_link( $t ) ); ?>"><?php echo esc_html( $t->name ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>
<?php endif; ?>
