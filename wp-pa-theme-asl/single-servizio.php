<?php
/**
 * Dettaglio servizio (prototipo AGID [D] Servizio).
 *
 * @package digital-italia
 */

get_header();

while ( have_posts() ) :
	the_post();
	$id        = get_the_ID();
	$bookable  = '1' === get_post_meta( $id, '_swb_slots_enabled', true );
	$strutture = asl_servizio_strutture( $id );
	$correlati = get_posts( array( 'post_type' => 'servizio', 'numberposts' => 3, 'post__not_in' => array( $id ), 'orderby' => 'title', 'order' => 'ASC' ) );
	$has_body  = '' !== trim( get_the_content() );

	$index = array();
	if ( $has_body ) {
		$index[] = array( __( 'Descrizione', 'wp-digital-italia-asl' ), 'descrizione' );
	}
	if ( $bookable ) {
		$index[] = array( __( 'Accedi al servizio', 'wp-digital-italia-asl' ), 'accedi' );
	}
	if ( $strutture ) {
		$index[] = array( __( 'Dove', 'wp-digital-italia-asl' ), 'dove' );
	}
	if ( $correlati ) {
		$index[] = array( __( 'Servizi e prestazioni correlati', 'wp-digital-italia-asl' ), 'correlati' );
	}
	asl_set_page_index( $index );

	get_template_part( 'template-parts/detail/head', null, array(
		'crumbs'     => array( array( __( 'Servizi e prestazioni', 'wp-digital-italia-asl' ), get_post_type_archive_link( 'servizio' ) ) ),
		'title'      => get_the_title(),
		'badge'      => $bookable ? __( 'Servizio attivo', 'wp-digital-italia-asl' ) : '',
		'badge_text' => $bookable ? __( 'Servizio disponibile e prenotabile', 'wp-digital-italia-asl' ) : '',
	) );
	?>
	<main id="primary" class="asl-detail">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 order-lg-1"><?php get_sidebar(); ?></div>
				<div class="col-lg-8 offset-lg-1 order-lg-2">

					<?php if ( $has_body ) : ?>
						<section id="descrizione" class="asl-detail-section">
							<h2><?php esc_html_e( 'Descrizione', 'wp-digital-italia-asl' ); ?></h2>
							<div class="asl-prose"><?php the_content(); ?></div>
						</section>
					<?php endif; ?>

					<?php if ( $bookable ) : ?>
						<section id="accedi" class="asl-detail-section">
							<h2><?php esc_html_e( 'Accedi al servizio', 'wp-digital-italia-asl' ); ?></h2>
							<p class="asl-prose"><?php esc_html_e( 'Prenota il servizio online scegliendo giorno e orario disponibili.', 'wp-digital-italia-asl' ); ?></p>
							<a href="#" class="asl-btn swb-booking-button" data-post-id="<?php echo esc_attr( $id ); ?>"><?php esc_html_e( 'Prenota online', 'wp-digital-italia-asl' ); ?></a>
						</section>
					<?php endif; ?>

					<?php if ( $strutture ) : ?>
						<section id="dove" class="asl-detail-section">
							<h2><?php esc_html_e( 'Dove', 'wp-digital-italia-asl' ); ?></h2>
							<div class="row g-4">
								<?php foreach ( $strutture as $s ) : ?>
									<?php
									$addr = get_post_meta( $s->ID, '_dci_dipartimento_indirizzo', true );
									$map  = asl_map_url( (string) $addr, get_post_meta( $s->ID, '_dci_dipartimento_latitudine', true ), get_post_meta( $s->ID, '_dci_dipartimento_longitudine', true ) );
									?>
									<div class="col-md-6">
										<article class="asl-place">
											<h3><a href="<?php echo esc_url( get_permalink( $s ) ); ?>"><?php echo esc_html( get_the_title( $s ) ); ?></a></h3>
											<?php if ( $addr ) : ?><p><?php echo esc_html( sprintf( /* translators: %s: indirizzo */ __( 'Indirizzo: %s', 'wp-digital-italia-asl' ), $addr ) ); ?></p><?php endif; ?>
											<span class="asl-tag"><?php esc_html_e( 'Struttura', 'wp-digital-italia-asl' ); ?></span>
											<?php if ( $addr ) : ?><a class="asl-place__map" href="<?php echo esc_url( $map ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Apri in mappa', 'wp-digital-italia-asl' ); ?> <?php echo asl_external_icon(); // phpcs:ignore ?></a><?php endif; ?>
										</article>
									</div>
								<?php endforeach; ?>
							</div>
						</section>
					<?php endif; ?>

					<?php if ( $correlati ) : ?>
						<section id="correlati" class="asl-detail-section">
							<h2><?php esc_html_e( 'Servizi e prestazioni correlati', 'wp-digital-italia-asl' ); ?></h2>
							<div class="row g-4">
								<?php foreach ( $correlati as $c ) : ?>
									<div class="col-md-6">
										<article class="asl-service-card">
											<div>
												<h3><a href="<?php echo esc_url( get_permalink( $c ) ); ?>"><?php echo esc_html( get_the_title( $c ) ); ?></a></h3>
												<p><?php echo esc_html( wp_trim_words( wp_strip_all_tags( $c->post_content ), 18 ) ); ?></p>
											</div>
											<span class="asl-tag"><?php esc_html_e( 'Servizio', 'wp-digital-italia-asl' ); ?></span>
										</article>
									</div>
								<?php endforeach; ?>
							</div>
						</section>
					<?php endif; ?>

				</div>
			</div>
		</div>
	</main>
	<?php
endwhile;

get_footer();
