<?php
/** Strutture di primo livello come card. */
$strutture = get_posts( array( 'post_type' => 'dipartimento', 'post_parent' => 0, 'numberposts' => 6, 'orderby' => 'menu_order title', 'order' => 'ASC' ) );
if ( ! $strutture ) {
	return;
}
?>
<section class="dci-section" aria-labelledby="strutture-title">
	<div class="container-fluid">
		<h2 id="strutture-title" class="dci-section__title"><?php esc_html_e( 'Strutture', 'wp-digital-italia' ); ?></h2>
		<div class="row g-4">
			<?php foreach ( $strutture as $s ) : ?>
				<div class="col-md-6 col-lg-3">
					<article class="card card-bg h-100 border-bottom-card">
						<div class="card-body text-center">
							<h3 class="card-title h5"><a class="text-decoration-none" href="<?php echo esc_url( get_permalink( $s ) ); ?>"><?php echo esc_html( get_the_title( $s ) ); ?></a></h3>
							<p class="card-text small"><?php echo esc_html( wp_trim_words( wp_strip_all_tags( $s->post_content ), 18 ) ); ?></p>
						</div>
					</article>
				</div>
			<?php endforeach; ?>
		</div>
		<p class="mt-4 text-center"><a class="dci-section__more d-inline-block" href="<?php echo esc_url( get_post_type_archive_link( 'dipartimento' ) ); ?>"><?php esc_html_e( 'Tutte le strutture', 'wp-digital-italia' ); ?> <?php echo dci_icon( 'arrow-right' ); ?></a></p>
	</div>
</section>
