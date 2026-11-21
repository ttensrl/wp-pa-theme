<?php
/**
 * Lista delle notizie "ASL Comunica" (prototipo AGID [D] Lista | ASL Comunica).
 * In evidenza: la prima notizia (solo a pagina 1); Ultime novita': le altre, con paginazione.
 *
 * @package digital-italia
 */

get_header();

$title = ( is_home() && ! is_front_page() ) ? single_post_title( '', false ) : __( 'ASL Comunica', 'wp-digital-italia-asl' );
$paged = max( 1, (int) get_query_var( 'paged' ) );
$arrow = '<svg class="asl-arrow" viewBox="0 0 24 24" width="20" height="20" aria-hidden="true"><path d="M3 12h17M14 6l6 6-6 6" fill="none" stroke="currentColor" stroke-width="1.4"/></svg>';
?>
<main id="primary" class="asl-list">
	<?php
	get_template_part( 'template-parts/list/hero', null, array(
		'title' => $title,
		'lead'  => __( "Tutte le notizie, i comunicati stampa, gli eventi, i bandi e i concorsi dell'ASL", 'wp-digital-italia-asl' ),
	) );

	$featured = null;
	if ( have_posts() && 1 === $paged ) {
		the_post();
		$featured = get_post();
	}
	?>

	<?php if ( $featured ) : ?>
		<?php
		$img = dci_post_image_url( $featured );
		$cat = array_values( array_filter( get_the_category( $featured->ID ), fn( $c ) => (int) $c->term_id !== (int) get_option( 'default_category' ) ) );
		?>
		<section class="asl-section asl-section--white" aria-labelledby="news-feat-title">
			<div class="container">
				<h2 id="news-feat-title" class="asl-section__title"><?php esc_html_e( 'In evidenza', 'wp-digital-italia-asl' ); ?></h2>
				<article class="asl-featured">
					<div class="asl-featured__body">
						<h3 class="asl-featured__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<p class="asl-featured__text"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 34 ) ); ?></p>
						<span class="asl-tag"><?php echo $cat ? esc_html( $cat[0]->name ) : esc_html__( 'Notizia', 'wp-digital-italia-asl' ); ?></span>
					</div>
					<div class="asl-featured__media<?php echo $img ? '' : ' is-placeholder'; ?>">
						<?php if ( $img ) : ?><img src="<?php echo esc_url( $img ); ?>" alt=""><?php endif; ?>
					</div>
				</article>
			</div>
		</section>
	<?php endif; ?>

	<section class="asl-section asl-section--white asl-news-grid" aria-labelledby="news-latest-title">
		<div class="container">
			<h2 id="news-latest-title" class="asl-section__title"><?php esc_html_e( 'Ultime novità', 'wp-digital-italia-asl' ); ?></h2>
			<?php if ( have_posts() ) : ?>
				<div class="row g-4">
					<?php
					$i = 0;
					while ( have_posts() ) :
						the_post();
						?>
						<div class="col-md-6 col-lg-4">
							<?php get_template_part( 'template-parts/news/card', null, array( 'variant' => $i++ ) ); ?>
						</div>
					<?php endwhile; ?>
				</div>
				<?php the_posts_pagination( array( 'mid_size' => 1, 'prev_text' => __( 'Precedenti', 'wp-digital-italia-asl' ), 'next_text' => __( 'Successive', 'wp-digital-italia-asl' ), 'class' => 'asl-pagination' ) ); ?>
			<?php else : ?>
				<p><?php esc_html_e( 'Nessun contenuto disponibile.', 'wp-digital-italia-asl' ); ?></p>
			<?php endif; ?>
		</div>
	</section>

	<?php get_template_part( 'template-parts/news/explore' ); ?>
</main>
<?php
get_footer();
