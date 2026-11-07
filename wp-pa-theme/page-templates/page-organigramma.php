<?php
/**
 * Template Name: Organigramma
 * Organigramma aziendale: accordion per struttura di primo livello,
 * con persone/ruoli e unita' collegate (sotto-strutture).
 *
 * @package digital-italia
 */

get_header();

$top = get_posts( array( 'post_type' => 'dipartimento', 'post_parent' => 0, 'numberposts' => -1, 'orderby' => 'menu_order title', 'order' => 'ASC' ) );
?>
<main id="main-content">
	<header class="page-header bg-white mb-4 py-4">
		<div class="container-fluid"><h1 class="mb-2"><?php the_title(); ?></h1></div>
	</header>

	<div class="container-fluid pb-5">
		<div class="row g-4">
			<div class="col-lg-9 order-lg-2">
				<?php while ( have_posts() ) : the_post(); ?>
					<div class="entry-content mb-4"><?php the_content(); ?></div>
				<?php endwhile; ?>

				<div class="accordion" id="accordion-organigramma">
					<?php foreach ( $top as $i => $s ) :
						$people   = (array) get_post_meta( $s->ID, '_dci_dipartimento_organigramma', true );
						$children = get_posts( array( 'post_type' => 'dipartimento', 'post_parent' => $s->ID, 'numberposts' => -1, 'orderby' => 'menu_order title', 'order' => 'ASC' ) );
						?>
						<div class="accordion-item">
							<h2 class="accordion-header" id="org-h-<?php echo (int) $i; ?>">
								<button class="accordion-button<?php echo $i ? ' collapsed' : ''; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#org-<?php echo (int) $i; ?>" aria-expanded="<?php echo $i ? 'false' : 'true'; ?>" aria-controls="org-<?php echo (int) $i; ?>"><?php echo esc_html( get_the_title( $s ) ); ?></button>
							</h2>
							<div id="org-<?php echo (int) $i; ?>" class="accordion-collapse collapse<?php echo $i ? '' : ' show'; ?>" aria-labelledby="org-h-<?php echo (int) $i; ?>">
								<div class="accordion-body">
									<?php if ( array_filter( $people ) ) : ?>
										<ul class="dci-org__people">
											<?php foreach ( $people as $p ) :
												if ( empty( $p['persona_id'] ) ) { continue; } ?>
												<li><a href="<?php echo esc_url( get_permalink( (int) $p['persona_id'] ) ); ?>"><?php echo esc_html( dci_persona_nome( (int) $p['persona_id'] ) ); ?></a>
													<span class="dci-org__role"><?php echo esc_html( $p['ruolo'] ?? '' ); ?></span></li>
											<?php endforeach; ?>
										</ul>
									<?php endif; ?>
									<?php if ( $children ) : ?>
										<h3 class="h6"><?php esc_html_e( 'Unità collegate', 'wp-digital-italia' ); ?></h3>
										<ul>
											<?php foreach ( $children as $c ) : ?>
												<li><a href="<?php echo esc_url( get_permalink( $c ) ); ?>"><?php echo esc_html( get_the_title( $c ) ); ?></a></li>
											<?php endforeach; ?>
										</ul>
									<?php endif; ?>
									<a href="<?php echo esc_url( get_permalink( $s ) ); ?>"><?php esc_html_e( 'Scheda completa', 'wp-digital-italia' ); ?> <?php echo dci_icon( 'arrow-right' ); ?></a>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="col-lg-3 order-lg-1"><?php get_sidebar(); ?></div>
		</div>
	</div>
</main>
<?php
get_footer();
