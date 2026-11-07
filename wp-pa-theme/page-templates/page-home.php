<?php
/**
 * Template Name: Home
 * Home in stile portale sanitario: hero con ricerca, accesso rapido,
 * "informa" a tab (notizie / bandi), strutture, servizi.
 *
 * @package digital-italia
 */

get_header();

$org_url = dci_get_template_page_url( 'page-templates/page-organigramma.php' );
?>
<main id="primary">

	<?php get_template_part( 'template-parts/home/quick-access', null, array( 'org_url' => $org_url ) ); ?>
	<?php get_template_part( 'template-parts/home/hero-slider' ); ?>

	<section class="dci-section pb-0" aria-label="<?php esc_attr_e( 'Ricerca', 'wp-digital-italia' ); ?>">
		<div class="container-fluid">
			<form class="dci-search" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<label for="home-search" class="visually-hidden"><?php esc_html_e( 'Cerca nel sito', 'wp-digital-italia' ); ?></label>
				<div class="input-group">
					<input id="home-search" type="search" class="form-control" name="s" placeholder="<?php esc_attr_e( 'Cosa stai cercando?', 'wp-digital-italia' ); ?>">
					<button class="btn btn-primary" type="submit"><?php esc_html_e( 'Cerca', 'wp-digital-italia' ); ?></button>
				</div>
			</form>
		</div>
	</section>

	<?php get_template_part( 'template-parts/home/informa' ); ?>
	<?php get_template_part( 'template-parts/home/strutture' ); ?>
	<?php get_template_part( 'template-parts/home/servizi' ); ?>

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
		if ( trim( get_the_content() ) ) : ?>
			<section class="dci-section"><div class="container-fluid entry-content"><?php the_content(); ?></div></section>
		<?php endif;
	endwhile; endif; ?>
</main>
<?php
get_footer();
