<?php
/**
 * Header del profilo Scuola (modello Design Scuole): fascia del Ministero con "Accedi",
 * testata con marchio a tre righe, ricerca e social, navigazione a colori per sezione
 * e argomenti a destra.
 *
 * @package digital-italia
 */
$area     = dci_area_personale();
$entities = dci_parent_entities();
$entity   = $entities[0] ?? array( 'name' => '', 'url' => '' );
$parts    = dci_brand_parts();
$logo     = scuola_logo_url();
$topics   = scuola_topics();
$news_page = (int) get_option( 'page_for_posts' );
?>
<header class="it-header-wrapper sc-header" id="main-header">
	<div class="sc-slim">
		<div class="container sc-slim__in">
			<?php if ( ! empty( $entity['name'] ) ) : ?>
				<a class="sc-slim__ente" href="<?php echo esc_url( $entity['url'] ?: home_url( '/' ) ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $entity['name'] ); ?></a>
			<?php else : ?>
				<span></span>
			<?php endif; ?>
			<?php if ( ! empty( $area['url'] ) ) : ?>
				<a class="sc-slim__login" href="<?php echo esc_url( $area['url'] ); ?>">
					<span><?php echo esc_html( $area['label'] ); ?></span>
					<svg viewBox="0 0 24 24" width="28" height="28" aria-hidden="true"><circle cx="12" cy="8" r="4.5" fill="none" stroke="currentColor" stroke-width="1.5"/><path d="M3.500 22c.6-4.600 4.200-7.500 8.500-7.500s7.900 2.900 8.500 7.500" fill="none" stroke="currentColor" stroke-width="1.5"/></svg>
				</a>
			<?php endif; ?>
		</div>
	</div>

	<div class="sc-masthead">
		<div class="container sc-masthead__in">
			<a class="sc-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<?php if ( $logo ) : ?><img class="sc-brand__logo" src="<?php echo esc_url( $logo ); ?>" alt="" width="64" height="72"><?php else : ?>
					<svg class="sc-brand__logo sc-brand__logo--ph" viewBox="0 0 64 72" width="64" height="72" aria-hidden="true"><path d="M32 3 6 12v26c0 14 11 25 26 31 15-6 26-17 26-31V12L32 3Z" fill="none" stroke="currentColor" stroke-width="2"/><path d="m32 22 4.200 8.500 9.400 1.400-6.800 6.600 1.600 9.300L32 43.400l-8.400 4.400 1.600-9.300-6.800-6.600 9.400-1.400L32 22Z" fill="none" stroke="currentColor" stroke-width="2"/></svg>
				<?php endif; ?>
				<span class="sc-brand__text">
					<?php if ( $parts['prefix'] ) : ?><span><?php echo esc_html( $parts['prefix'] ); ?></span><?php endif; ?>
					<strong><?php echo esc_html( $parts['name'] ); ?></strong>
					<?php if ( get_bloginfo( 'description' ) ) : ?><span class="sc-brand__tag"><?php bloginfo( 'description' ); ?></span><?php endif; ?>
				</span>
			</a>
			<div class="sc-tools">
				<button class="sc-search-toggle" type="button" data-bs-toggle="modal" data-bs-target="#search-modal">
					<span><?php esc_html_e( 'Cerca', 'wp-digital-italia' ); ?></span>
					<svg viewBox="0 0 24 24" width="24" height="24" aria-hidden="true"><circle cx="10" cy="10" r="6.500" fill="none" stroke="currentColor" stroke-width="1.700"/><path d="M15 15l6 6" stroke="currentColor" stroke-width="1.700"/></svg>
				</button>
				<?php dci_render_socials( array( 'label' => __( 'Seguici su:', 'wp-digital-italia' ), 'class' => 'sc-socials' ) ); ?>
			</div>
		</div>
	</div>

	<div class="sc-nav">
		<div class="container sc-nav__in">
			<?php
			dci_render_navbar(
				array(
					'id'           => 'sc-nav',
					'class'        => 'sc-navbar',
					'menu_class'   => 'sc-menu',
					'mobile_brand' => true,
					'depth'        => 2,
				)
			);
			?>
			<?php if ( $topics ) : ?>
				<nav class="sc-topics" aria-label="<?php esc_attr_e( 'Argomenti', 'wp-digital-italia' ); ?>">
					<ul>
						<?php foreach ( $topics as [ $label, $url ] ) : ?>
							<li><a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $label ); ?></a></li>
						<?php endforeach; ?>
						<?php if ( $news_page ) : ?>
							<li class="sc-topics__all"><a href="<?php echo esc_url( get_permalink( $news_page ) ); ?>"><?php esc_html_e( 'Tutti gli argomenti', 'wp-digital-italia' ); ?></a></li>
						<?php endif; ?>
					</ul>
				</nav>
			<?php endif; ?>
		</div>
	</div>
</header>
<?php dci_render_search_modal(); ?>
