<?php
/**
 * Header del profilo Musei (prototipo AGID "Musei civici"):
 * fascia ente + lingua, testata con logo/social/ricerca, navigazione con
 * "Acquista biglietti" e avviso chiudibile.
 *
 * @package digital-italia
 */
$entities = dci_parent_entities();
$entity   = $entities[0] ?? array( 'name' => '', 'url' => home_url( '/' ) );
$lang     = apply_filters( 'dci_topbar_language', 'ITA' );
$tickets  = (string) get_theme_mod( 'musei_tickets_url', '#biglietti' );
$alert    = musei_alert_text();
$desc     = get_bloginfo( 'description' );
?>
<header class="it-header-wrapper mu-header">
	<div class="mu-slim">
		<div class="container mu-slim__in">
			<?php if ( ! empty( $entity['name'] ) ) : ?>
				<a class="mu-slim__ente" href="<?php echo esc_url( $entity['url'] ?: home_url( '/' ) ); ?>"><?php echo esc_html( $entity['name'] ); ?></a>
			<?php else : ?>
				<span></span>
			<?php endif; ?>
			<?php if ( $lang ) : ?>
				<span class="mu-slim__lang"><?php echo esc_html( $lang ); ?><?php echo dci_icon( 'chevron-down', 'icon icon-sm' ); ?></span>
			<?php endif; ?>
		</div>
	</div>

	<div class="mu-masthead">
		<div class="container mu-masthead__in">
			<a class="mu-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<?php if ( has_custom_logo() ) : ?>
					<?php echo wp_get_attachment_image( (int) get_theme_mod( 'custom_logo' ), 'full', false, array( 'class' => 'mu-brand__logo', 'alt' => '' ) ); ?>
				<?php else : ?>
					<img class="mu-brand__logo" src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/museo.svg' ); ?>" alt="" width="44" height="40">
				<?php endif; ?>
				<span class="mu-brand__text">
					<span class="mu-brand__title"><?php bloginfo( 'name' ); ?></span>
					<?php if ( $desc ) : ?><span class="mu-brand__sub"><?php echo esc_html( $desc ); ?></span><?php endif; ?>
				</span>
			</a>
			<div class="mu-tools">
				<?php dci_render_socials( array( 'class' => 'mu-socials' ) ); ?>
				<button class="mu-search-toggle" type="button" data-bs-toggle="modal" data-bs-target="#search-modal">
					<span><?php esc_html_e( 'Cerca', 'wp-digital-italia-musei' ); ?></span>
					<?php echo dci_icon( 'search', 'icon icon-sm' ); ?>
				</button>
			</div>
		</div>
	</div>

	<div class="mu-nav">
		<div class="container mu-nav__in">
			<?php
			dci_render_navbar(
				array(
					'id'           => 'mu-nav',
					'class'        => 'mu-navbar',
					'menu_class'   => 'mu-menu',
					'mobile_brand' => true,
					'depth'        => 2,
				)
			);
			?>
			<a class="mu-btn mu-btn--sm mu-nav__cta" href="<?php echo esc_url( $tickets ); ?>"><?php esc_html_e( 'Acquista biglietti', 'wp-digital-italia-musei' ); ?></a>
		</div>
	</div>

	<?php if ( $alert ) : ?>
		<div class="mu-alert" role="region" aria-label="<?php esc_attr_e( 'Avviso', 'wp-digital-italia-musei' ); ?>" data-mu-alert="<?php echo esc_attr( md5( $alert ) ); ?>">
			<div class="container mu-alert__in">
				<p><strong><?php esc_html_e( 'Avviso', 'wp-digital-italia-musei' ); ?></strong> <?php echo esc_html( $alert ); ?></p>
				<button type="button" class="mu-alert__close" aria-label="<?php esc_attr_e( 'Chiudi l\'avviso', 'wp-digital-italia-musei' ); ?>">
					<svg viewBox="0 0 24 24" width="22" height="22" aria-hidden="true"><path d="M5 5l14 14M19 5L5 19" stroke="currentColor" stroke-width="2" fill="none"/></svg>
				</button>
			</div>
		</div>
	<?php endif; ?>
</header>
<?php dci_render_search_modal(); ?>
