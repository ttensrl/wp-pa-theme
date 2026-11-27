<?php
/**
 * Archivi di notizie (categoria, tag, data, autore): stessa grafica della lista ASL Comunica.
 *
 * @package digital-italia
 */

get_header();

$lead   = get_the_archive_description();
$page   = (int) get_option( 'page_for_posts' );
$is_tag = is_tag();
$title  = $is_tag ? single_tag_title( '', false ) : wp_strip_all_tags( get_the_archive_title() );
if ( $is_tag && ! $lead ) {
	/* translators: %s: nome del tag (destinatario) */
	$lead = sprintf( __( 'Servizi, strutture e novità per: %s', 'wp-digital-italia-asl' ), $title );
}
?>
<main id="primary" class="asl-list">
	<?php
	get_template_part( 'template-parts/list/hero', null, array(
		'title'  => $title,
		'lead'   => wp_strip_all_tags( $lead ),
		'crumbs' => ( $page && ! $is_tag ) ? array( array( get_the_title( $page ), get_permalink( $page ) ) ) : array(),
	) );
	?>

	<section class="asl-section asl-section--white asl-news-grid" aria-label="<?php esc_attr_e( 'Elenco dei contenuti', 'wp-digital-italia-asl' ); ?>">
		<div class="container">
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

	<?php if ( ! $is_tag ) { get_template_part( 'template-parts/news/explore' ); } ?>
</main>
<?php
get_footer();
