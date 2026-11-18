<?php
/**
 * Dettaglio struttura (prototipo AGID [D] Struttura).
 *
 * @package digital-italia
 */

get_header();

while ( have_posts() ) :
	the_post();
	$id        = get_the_ID();
	$email     = get_post_meta( $id, '_dci_dipartimento_email', true );
	$tel       = get_post_meta( $id, '_dci_dipartimento_telefono', true );
	$addr      = get_post_meta( $id, '_dci_dipartimento_indirizzo', true );
	$lat       = get_post_meta( $id, '_dci_dipartimento_latitudine', true );
	$lng       = get_post_meta( $id, '_dci_dipartimento_longitudine', true );
	$resp_id   = (int) get_post_meta( $id, '_dci_dipartimento_responsabile', true );
	$org       = get_post_meta( $id, '_dci_dipartimento_organigramma', true );
	$org       = is_array( $org ) ? array_filter( $org, fn( $e ) => ! empty( $e['persona_id'] ) && get_post( $e['persona_id'] ) ) : array();
	$children  = get_posts( array( 'post_type' => 'dipartimento', 'post_parent' => $id, 'numberposts' => -1, 'orderby' => 'menu_order title', 'order' => 'ASC' ) );
	$srv_ids   = get_post_meta( $id, '_dci_dipartimento_servizi', true );
	$servizi   = is_array( $srv_ids ) ? array_filter( array_map( 'get_post', $srv_ids ) ) : array();
	$parent    = $post->post_parent ? get_post( $post->post_parent ) : null;
	$has_body  = '' !== trim( get_the_content() );
	$img       = get_the_post_thumbnail_url( $id, 'full' );

	$index = array();
	if ( $has_body ) {
		$index[] = array( __( 'Descrizione', 'wp-digital-italia-asl' ), 'descrizione' );
	}
	if ( $addr ) {
		$index[] = array( __( 'Dove', 'wp-digital-italia-asl' ), 'dove' );
	}
	if ( $tel || $email ) {
		$index[] = array( __( 'Contatti', 'wp-digital-italia-asl' ), 'contatti' );
	}
	if ( $resp_id ) {
		$index[] = array( __( 'Responsabile', 'wp-digital-italia-asl' ), 'responsabile' );
	}
	if ( $org ) {
		$index[] = array( __( 'Organigramma', 'wp-digital-italia-asl' ), 'organigramma' );
	}
	if ( $children ) {
		$index[] = array( __( 'Unità operative', 'wp-digital-italia-asl' ), 'unita' );
	}
	if ( $servizi ) {
		$index[] = array( __( 'Servizi e prestazioni', 'wp-digital-italia-asl' ), 'servizi' );
	}
	asl_set_page_index( $index );

	$crumbs = array( array( __( 'Strutture', 'wp-digital-italia-asl' ), get_post_type_archive_link( 'dipartimento' ) ) );
	if ( $parent ) {
		$crumbs[] = array( get_the_title( $parent ), get_permalink( $parent ) );
	}
	get_template_part( 'template-parts/detail/head', null, array(
		'crumbs'  => $crumbs,
		'title'   => get_the_title(),
		'no_rule' => (bool) $img,
	) );
	?>
	<?php if ( $img ) : ?>
		<figure class="asl-detail-hero"><img src="<?php echo esc_url( $img ); ?>" alt=""></figure>
	<?php endif; ?>

	<main id="primary" class="asl-detail<?php echo $img ? ' has-hero' : ''; ?>">
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

					<?php if ( $addr ) : ?>
						<section id="dove" class="asl-detail-section">
							<h2><?php esc_html_e( 'Dove', 'wp-digital-italia-asl' ); ?></h2>
							<p class="asl-prose"><?php echo nl2br( esc_html( $addr ) ); ?></p>
							<a class="asl-link-ext" href="<?php echo esc_url( asl_map_url( $addr, $lat, $lng ) ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Apri in mappa', 'wp-digital-italia-asl' ); ?> <?php echo asl_external_icon(); // phpcs:ignore ?></a>
						</section>
					<?php endif; ?>

					<?php if ( $tel || $email ) : ?>
						<section id="contatti" class="asl-detail-section">
							<h2><?php esc_html_e( 'Contatti', 'wp-digital-italia-asl' ); ?></h2>
							<dl class="asl-contacts">
								<?php if ( $tel ) : ?>
									<dt><?php esc_html_e( 'Telefono', 'wp-digital-italia-asl' ); ?></dt>
									<dd><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $tel ) ); ?>"><?php echo esc_html( $tel ); ?></a></dd>
								<?php endif; ?>
								<?php if ( $email ) : ?>
									<dt><?php esc_html_e( 'Email', 'wp-digital-italia-asl' ); ?></dt>
									<dd><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></dd>
								<?php endif; ?>
							</dl>
						</section>
					<?php endif; ?>

					<?php if ( $resp_id && get_post( $resp_id ) ) : ?>
						<section id="responsabile" class="asl-detail-section">
							<h2><?php esc_html_e( 'Responsabile', 'wp-digital-italia-asl' ); ?></h2>
							<p class="asl-prose"><a href="<?php echo esc_url( get_permalink( $resp_id ) ); ?>"><?php echo esc_html( dci_persona_nome( $resp_id ) ); ?></a></p>
						</section>
					<?php endif; ?>

					<?php if ( $org ) : ?>
						<section id="organigramma" class="asl-detail-section">
							<h2><?php esc_html_e( 'Organigramma', 'wp-digital-italia-asl' ); ?></h2>
							<dl class="asl-contacts">
								<?php foreach ( $org as $e ) : ?>
									<dt><?php echo esc_html( $e['ruolo'] ?? '' ); ?></dt>
									<dd><a href="<?php echo esc_url( get_permalink( $e['persona_id'] ) ); ?>"><?php echo esc_html( dci_persona_nome( (int) $e['persona_id'] ) ); ?></a></dd>
								<?php endforeach; ?>
							</dl>
						</section>
					<?php endif; ?>

					<?php if ( $children ) : ?>
						<section id="unita" class="asl-detail-section">
							<h2><?php esc_html_e( 'Unità operative', 'wp-digital-italia-asl' ); ?></h2>
							<div class="row g-4">
								<?php foreach ( $children as $c ) : ?>
									<div class="col-md-6">
										<article class="asl-service-card">
											<div>
												<h3><a href="<?php echo esc_url( get_permalink( $c ) ); ?>"><?php echo esc_html( get_the_title( $c ) ); ?></a></h3>
												<p><?php echo esc_html( wp_trim_words( wp_strip_all_tags( $c->post_content ), 18 ) ); ?></p>
											</div>
											<span class="asl-tag"><?php esc_html_e( 'Unità operativa', 'wp-digital-italia-asl' ); ?></span>
										</article>
									</div>
								<?php endforeach; ?>
							</div>
						</section>
					<?php endif; ?>

					<?php if ( $servizi ) : ?>
						<section id="servizi" class="asl-detail-section">
							<h2><?php esc_html_e( 'Servizi e prestazioni', 'wp-digital-italia-asl' ); ?></h2>
							<div class="row g-4">
								<?php foreach ( $servizi as $s ) : ?>
									<div class="col-md-6">
										<article class="asl-service-card">
											<div>
												<h3><a href="<?php echo esc_url( get_permalink( $s ) ); ?>"><?php echo esc_html( get_the_title( $s ) ); ?></a></h3>
												<p><?php echo esc_html( wp_trim_words( wp_strip_all_tags( $s->post_content ), 18 ) ); ?></p>
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
