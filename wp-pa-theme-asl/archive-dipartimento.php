<?php
/**
 * Lista "Strutture" (prototipo AGID [D] Lista | Strutture).
 *
 * @package digital-italia
 */

get_header();

$top   = get_posts( array( 'post_type' => 'dipartimento', 'post_parent' => 0, 'numberposts' => -1, 'orderby' => 'menu_order title', 'order' => 'ASC' ) );
$arrow = '<svg viewBox="0 0 24 24" width="28" height="28" aria-hidden="true"><path d="M9 4l8 8-8 8" fill="none" stroke="currentColor" stroke-width="1.5"/></svg>';
?>
<main id="primary" class="asl-list">
	<?php
	get_template_part( 'template-parts/list/hero', null, array(
		'title' => __( 'Strutture', 'wp-digital-italia-asl' ),
		'lead'  => __( "Tutte le strutture dell'ASL dove svolgere visite, esami, prestazioni e richiedere supporto", 'wp-digital-italia-asl' ),
	) );
	?>

	<?php if ( $top ) : ?>
		<section class="asl-section asl-section--white" aria-labelledby="str-feat-title">
			<div class="container">
				<h2 id="str-feat-title" class="asl-section__title"><?php esc_html_e( 'In evidenza', 'wp-digital-italia-asl' ); ?></h2>
				<div class="row g-4">
					<?php
					foreach ( $top as $i => $s ) :
						$img = get_the_post_thumbnail_url( $s, 'large' );
						$tel = get_post_meta( $s->ID, '_dci_dipartimento_telefono', true );
						?>
						<div class="col-md-6 col-lg-4">
							<article class="asl-news">
								<div class="asl-news__media<?php echo $img ? '' : ' is-placeholder is-v' . ( $i % 3 ); ?>">
									<?php if ( $img ) : ?><img src="<?php echo esc_url( $img ); ?>" alt="" loading="lazy"><?php endif; ?>
								</div>
								<div class="asl-news__body">
									<h3><a href="<?php echo esc_url( get_permalink( $s ) ); ?>"><?php echo esc_html( get_the_title( $s ) ); ?></a></h3>
									<p><?php echo esc_html( wp_trim_words( wp_strip_all_tags( $s->post_content ) ?: get_the_excerpt( $s ), 24 ) ); ?></p>
									<div class="asl-news__meta">
										<span class="asl-tag"><?php esc_html_e( 'Struttura', 'wp-digital-italia-asl' ); ?></span>
										<?php if ( $tel ) : ?><span class="asl-news__phone"><?php echo esc_html( $tel ); ?></span><?php endif; ?>
									</div>
								</div>
							</article>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<?php
		$units = get_posts( array( 'post_type' => 'dipartimento', 'post_parent__in' => wp_list_pluck( $top, 'ID' ), 'numberposts' => -1, 'orderby' => 'menu_order title', 'order' => 'ASC' ) );
		if ( $units ) :
			?>
			<section class="asl-section" aria-labelledby="str-units-title">
				<div class="container">
					<h2 id="str-units-title" class="asl-section__title"><?php esc_html_e( 'Unità operative', 'wp-digital-italia-asl' ); ?></h2>
					<div class="row g-5 asl-ghost-row">
						<?php foreach ( $units as $u ) : ?>
							<div class="col-md-4">
								<article class="asl-ghost">
									<h3><a href="<?php echo esc_url( get_permalink( $u ) ); ?>"><span><?php echo esc_html( get_the_title( $u ) ); ?></span><?php echo $arrow; // phpcs:ignore ?></a></h3>
									<p><?php echo esc_html( sprintf( /* translators: %s: struttura di appartenenza */ __( 'Afferisce a: %s', 'wp-digital-italia-asl' ), get_the_title( $u->post_parent ) ) ); ?></p>
								</article>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</section>
		<?php endif; ?>
	<?php else : ?>
		<section class="asl-section"><div class="container"><p><?php esc_html_e( 'Nessuna struttura disponibile.', 'wp-digital-italia-asl' ); ?></p></div></section>
	<?php endif; ?>
</main>
<?php
get_footer();
