<?php
/**
 * Lista "Servizi e prestazioni" (prototipo AGID [D] Lista | Servizi).
 *
 * @package digital-italia
 */

get_header();

$servizi = get_posts( array( 'post_type' => 'servizio', 'numberposts' => -1, 'orderby' => 'title', 'order' => 'ASC' ) );
$feat    = array_slice( $servizi, 0, 3 );
$rest    = array_slice( $servizi, 3 );
$arrow   = '<svg viewBox="0 0 24 24" width="28" height="28" aria-hidden="true"><path d="M9 4l8 8-8 8" fill="none" stroke="currentColor" stroke-width="1.5"/></svg>';
?>
<main id="primary" class="asl-list">
	<?php
	get_template_part( 'template-parts/list/hero', null, array(
		'title' => __( 'Servizi e prestazioni', 'wp-digital-italia-asl' ),
		'lead'  => __( "Scopri e accedi ai servizi dell'ASL, come visite specialistiche, esami, percorsi di cura, referti e certificati", 'wp-digital-italia-asl' ),
	) );
	?>

	<?php if ( $feat ) : ?>
		<section class="asl-section asl-section--white" aria-labelledby="srv-feat-title">
			<div class="container">
				<h2 id="srv-feat-title" class="asl-section__title"><?php esc_html_e( 'In evidenza', 'wp-digital-italia-asl' ); ?></h2>
				<div class="row g-4">
					<?php foreach ( $feat as $s ) : ?>
						<div class="col-md-4">
							<article class="asl-service-card">
								<div>
									<h3><a href="<?php echo esc_url( get_permalink( $s ) ); ?>"><?php echo esc_html( get_the_title( $s ) ); ?></a></h3>
									<p><?php echo esc_html( wp_trim_words( wp_strip_all_tags( $s->post_content ), 22 ) ); ?></p>
								</div>
								<span class="asl-tag"><?php esc_html_e( 'Servizio', 'wp-digital-italia-asl' ); ?></span>
							</article>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( $rest ) : ?>
		<section class="asl-section" aria-labelledby="srv-all-title">
			<div class="container">
				<h2 id="srv-all-title" class="asl-section__title"><?php esc_html_e( 'Tutti i servizi', 'wp-digital-italia-asl' ); ?></h2>
				<div class="row g-5 asl-ghost-row">
					<?php foreach ( $rest as $s ) : ?>
						<div class="col-md-4">
							<article class="asl-ghost">
								<h3><a href="<?php echo esc_url( get_permalink( $s ) ); ?>"><span><?php echo esc_html( get_the_title( $s ) ); ?></span><?php echo $arrow; // phpcs:ignore ?></a></h3>
								<p><?php echo esc_html( wp_trim_words( wp_strip_all_tags( $s->post_content ), 22 ) ); ?></p>
							</article>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( ! $servizi ) : ?>
		<section class="asl-section"><div class="container"><p><?php esc_html_e( 'Nessun servizio disponibile.', 'wp-digital-italia-asl' ); ?></p></div></section>
	<?php endif; ?>
</main>
<?php
get_footer();
