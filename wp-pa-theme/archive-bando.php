<?php
/**
 * The template for displaying archive for bando post type
 *
 * @package digital-italia
 */

get_header();

global $wpdb;
$year = get_query_var( 'bando_year' );
?>

	<main id="main-content">

		<header class="page-header bg-white mb-4 py-4">
			<div class="container-fluid">
				<?php
                if ( ! empty( $year ) ) :
					?>
					<h1 class="mb-2"><?php echo esc_html( $year ); ?></h1>
					<?php
				else :
                    the_archive_title( '<h1 class="mb-2">', '</h1>' );
				endif;
				?>
			</div>
		</header>

		<div class="container-fluid pb-5">
			<?php
			$years = $wpdb->get_col( "
				SELECT DISTINCT YEAR( pm.meta_value )
				FROM {$wpdb->posts} p
				INNER JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
				WHERE p.post_type = 'bando'
					AND p.post_status = 'publish'
					AND pm.meta_key = '_dci_bando_data_publish'
					AND pm.meta_value != ''
				ORDER BY YEAR( pm.meta_value ) DESC
			" );
			if ( $years ) : ?>
				<nav class="dci-filters" aria-label="<?php esc_attr_e( 'Filtra per anno di pubblicazione', 'wp-digital-italia' ); ?>">
					<span class="fw-semibold me-2"><?php esc_html_e( 'Anno:', 'wp-digital-italia' ); ?></span>
					<a class="btn btn-sm <?php echo empty( $year ) ? 'btn-primary' : 'btn-outline-primary'; ?>" href="<?php echo esc_url( home_url( '/bandi/' ) ); ?>"<?php echo empty( $year ) ? ' aria-current="page"' : ''; ?>><?php esc_html_e( 'Tutti', 'wp-digital-italia' ); ?></a>
					<?php foreach ( $years as $y ) : ?>
						<a class="btn btn-sm <?php echo (string) $year === (string) $y ? 'btn-primary' : 'btn-outline-primary'; ?>" href="<?php echo esc_url( home_url( '/bandi/' . $y . '/' ) ); ?>"<?php echo (string) $year === (string) $y ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $y ); ?></a>
					<?php endforeach; ?>
				</nav>
			<?php endif; ?>

			<?php if ( have_posts() ) : ?>
				<ul class="dci-list">
					<?php
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/content/bando' );
					endwhile;
					?>
				</ul>
				<?php dci_bootstrap_pagination(); ?>
			<?php else : ?>
				<?php get_template_part( 'template-parts/content', 'none' ); ?>
			<?php endif; ?>
		</div>

	</main>

<?php
get_footer();
