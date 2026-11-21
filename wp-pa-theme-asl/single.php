<?php
/**
 * Dettaglio notizia. Nel Figma esiste solo il template foglia mobile: la pagina desktop
 * ne deriva il contenuto e riprende l'impianto di servizi e strutture
 * (testata con "Condividi", indice della pagina a sinistra, sezioni a destra).
 *
 * @package digital-italia
 */

get_header();

while ( have_posts() ) :
	the_post();
	$id    = get_the_ID();
	$page  = (int) get_option( 'page_for_posts' );
	$cat   = array_values( array_filter( get_the_category(), fn( $c ) => (int) $c->term_id !== (int) get_option( 'default_category' ) ) );
	$img   = get_the_post_thumbnail_url( $id, 'full' );
	$lead  = has_excerpt() ? get_the_excerpt() : '';
	$tags  = get_the_tags();

	/* Il contenuto va elaborato prima della sidebar: il filtro raccoglie i titoli h2 per l'indice. */
	$GLOBALS['asl_content_headings'] = array();
	$body = apply_filters( 'the_content', get_the_content() );
	$body = str_replace( ']]>', ']]&gt;', $body );

	$altre = get_posts( array( 'numberposts' => 2, 'post__not_in' => array( $id ), 'category__in' => wp_get_post_categories( $id ) ) );
	if ( count( $altre ) < 2 ) {
		$altre = get_posts( array( 'numberposts' => 2, 'post__not_in' => array( $id ) ) );
	}

	$index = $GLOBALS['asl_content_headings'];
	if ( $altre ) {
		$index[] = array( __( 'Altre notizie', 'wp-digital-italia-asl' ), 'altre' );
	}
	asl_set_page_index( $index );

	$meta = '<time datetime="' . esc_attr( get_the_date( 'c' ) ) . '">' . esc_html( get_the_date( 'j F Y' ) ) . '</time>';
	if ( $cat ) {
		$meta = '<span class="asl-tag">' . esc_html( $cat[0]->name ) . '</span> ' . $meta;
	}
	if ( get_the_modified_date( 'Ymd' ) !== get_the_date( 'Ymd' ) ) {
		$meta .= ' <span class="asl-detail-head__upd">' . esc_html( sprintf( /* translators: %s: data */ __( 'Aggiornato il %s', 'wp-digital-italia-asl' ), get_the_modified_date( 'j F Y' ) ) ) . '</span>';
	}

	get_template_part( 'template-parts/detail/head', null, array(
		'crumbs'  => $page ? array( array( get_the_title( $page ), get_permalink( $page ) ) ) : array(),
		'title'   => get_the_title(),
		'lead'    => $lead,
		'meta'    => $meta,
		'no_rule' => (bool) $img,
	) );
	?>
	<?php if ( $img ) : ?>
		<figure class="asl-detail-hero"><img src="<?php echo esc_url( $img ); ?>" alt=""></figure>
	<?php endif; ?>

	<main id="primary" class="asl-detail asl-detail--news<?php echo $img ? ' has-hero' : ''; ?>">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 order-lg-1"><?php get_sidebar(); ?></div>
				<div class="col-lg-8 offset-lg-1 order-lg-2">

					<div class="asl-prose asl-article"><?php echo $body; // phpcs:ignore ?></div>

					<?php if ( $tags ) : ?>
						<ul class="asl-chips asl-chips--article" aria-label="<?php esc_attr_e( 'Argomenti', 'wp-digital-italia-asl' ); ?>">
							<?php foreach ( $tags as $t ) : ?>
								<li><a href="<?php echo esc_url( get_tag_link( $t ) ); ?>"><?php echo esc_html( $t->name ); ?></a></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>

					<?php if ( $altre ) : ?>
						<section id="altre" class="asl-detail-section asl-detail-section--more">
							<h2><?php esc_html_e( 'Altre notizie', 'wp-digital-italia-asl' ); ?></h2>
							<div class="row g-4">
								<?php
								global $post;
								foreach ( $altre as $i => $post ) :
									setup_postdata( $post );
									?>
									<div class="col-md-6">
										<?php get_template_part( 'template-parts/news/card', null, array( 'variant' => $i, 'words' => 16 ) ); ?>
									</div>
									<?php
								endforeach;
								wp_reset_postdata();
								?>
							</div>
						</section>
					<?php endif; ?>

					<?php
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
					?>

				</div>
			</div>
		</div>
	</main>
	<?php
endwhile;

get_footer();
