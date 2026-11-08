<?php
/**
 * Header generico (fallback per i child che non definiscono una variante).
 *
 * @package digital-italia
 */
$belong_administration_logo = get_theme_mod( 'belong_administration_logo' );
?>
<header class="it-header-wrapper">
	<div class="it-header-slim-wrapper">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<div class="it-header-slim-wrapper-content">
						<?php if ( $belong_administration_logo ) : ?>
							<a class="d-none d-lg-block navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
								<img src="<?php echo esc_url( $belong_administration_logo ); ?>" alt="<?php esc_attr_e( 'Logo amministrazione', 'wp-digital-italia' ); ?>" height="30">
							</a>
						<?php endif; ?>
						<div class="nav-mobile">
							<nav aria-label="<?php esc_attr_e( 'Navigazione accessoria', 'wp-digital-italia' ); ?>">
								<a class="it-opener d-lg-none" data-bs-toggle="collapse" href="#menu1a" role="button" aria-expanded="false" aria-controls="menu1a">
									<span><?php esc_html_e( 'Ente appartenenza', 'wp-digital-italia' ); ?></span>
									<?php echo dci_icon( 'expand', 'icon' ); ?>
								</a>
								<div class="link-list-wrapper collapse" id="menu1a">
									<?php
									if ( dci_has_menu( 'top-menu' ) ) {
										wp_nav_menu(
											array(
												'theme_location' => 'top-menu',
												'container'      => false,
												'menu_class'     => 'list-item',
												'fallback_cb'    => '__return_false',
												'items_wrap'     => '<ul id="%1$s" class="link-list %2$s">%3$s</ul>',
												'depth'          => 1,
												'walker'         => new bootstrap_5_wp_simple_menu_walker(),
											)
										);
									}
									?>
								</div>
							</nav>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="it-nav-wrapper">
		<div class="it-header-center-wrapper theme-light">
			<div class="container-fluid">
				<div class="row">
					<div class="col-12">
						<div class="it-header-center-content-wrapper">
							<?php dci_render_brand(); ?>
							<div class="it-right-zone">
								<?php dci_render_socials(); ?>
								<div class="it-search-wrapper no-print">
									<span class="d-none d-md-block"><?php esc_html_e( 'Cerca', 'wp-digital-italia' ); ?></span>
									<a href="#" class="search-link rounded-icon" data-bs-toggle="modal" data-bs-target="#search-modal" aria-label="<?php esc_attr_e( 'Mostra ricerca', 'wp-digital-italia' ); ?>">
										<?php echo dci_icon( 'search', 'icon' ); ?>
										<span class="visually-hidden"><?php esc_html_e( 'Mostra ricerca', 'wp-digital-italia' ); ?></span>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="it-header-navbar-wrapper">
			<div class="container-fluid">
				<div class="row">
					<div class="col-12">
						<?php dci_render_navbar( array( 'id' => 'nav1' ) ); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>
<?php dci_render_search_modal(); ?>
