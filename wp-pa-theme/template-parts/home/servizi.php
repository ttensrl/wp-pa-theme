<?php
/** Guida ai servizi: accordion. */
$servizi = get_posts( array( 'post_type' => 'servizio', 'numberposts' => 8, 'orderby' => 'title', 'order' => 'ASC' ) );
if ( ! $servizi ) {
	return;
}
?>
<section class="dci-section dci-section--alt" aria-labelledby="servizi-title">
	<div class="container-fluid">
		<h2 id="servizi-title" class="dci-section__title"><?php esc_html_e( 'Guida ai servizi', 'wp-digital-italia' ); ?></h2>
		<div class="accordion" id="accordion-servizi">
			<?php foreach ( $servizi as $i => $s ) : ?>
				<div class="accordion-item">
					<h3 class="accordion-header" id="srv-h-<?php echo (int) $i; ?>">
						<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#srv-<?php echo (int) $i; ?>" aria-expanded="false" aria-controls="srv-<?php echo (int) $i; ?>"><?php echo esc_html( get_the_title( $s ) ); ?></button>
					</h3>
					<div id="srv-<?php echo (int) $i; ?>" class="accordion-collapse collapse" aria-labelledby="srv-h-<?php echo (int) $i; ?>">
						<div class="accordion-body">
							<?php echo wp_kses_post( wpautop( $s->post_content ) ); ?>
							<a href="<?php echo esc_url( get_permalink( $s ) ); ?>"><?php esc_html_e( 'Vai alla scheda', 'wp-digital-italia' ); ?></a>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
