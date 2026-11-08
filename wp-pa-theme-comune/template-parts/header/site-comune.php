<?php
/**
 * Header del profilo Comune, modellato su comune.sandonatomilanese.mi.it:
 * fascia enti + area personale, testata blu notte con logo/social/ricerca,
 * navigazione principale e secondaria sullo stesso blu.
 *
 * @package digital-italia
 */
$area = dci_area_personale();
$enti = dci_parent_entities();
?>
<header class="it-header-wrapper dci-comune-header">
	<div class="it-header-slim-wrapper" role="navigation">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="it-header-slim-wrapper-content">
						<div class="d-flex align-items-center flex-wrap dci-comune-enti">
							<?php foreach ( $enti as $index => $ente ) : ?>
								<?php if ( $index > 0 ) : ?><span class="navbar-brand mx-1" aria-hidden="true">-</span><?php endif; ?>
								<a href="<?php echo esc_url( $ente['url'] ?: home_url( '/' ) ); ?>" target="_blank" rel="noopener noreferrer" class="d-lg-block navbar-brand"><?php echo esc_html( $ente['name'] ); ?></a>
							<?php endforeach; ?>
						</div>

						<?php if ( ! empty( $area['url'] ) ) : ?>
							<div class="it-header-slim-right-zone header-slim-right-zone">
								<a href="<?php echo esc_url( $area['url'] ); ?>" class="btn-icon login-button btn btn-primary btn-full dci-comune-login">
									<span class="rounded-icon"><?php echo dci_icon( 'user', 'icon icon-primary' ); ?></span>
									<span class="d-none d-lg-block"><?php echo esc_html( $area['label'] ); ?></span>
								</a>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="it-nav-wrapper">
		<div class="it-header-center-wrapper">
			<div class="container">
				<div class="row">
					<div class="col">
						<div class="it-header-center-content-wrapper">
							<?php dci_render_brand( array( 'tone' => 'light', 'class' => 'dci-comune-brand' ) ); ?>
							<div class="it-right-zone">
								<?php dci_render_socials( array( 'label' => __( 'Seguici su', 'wp-digital-italia' ), 'class' => 'd-none d-md-flex dci-comune-socials' ) ); ?>
								<div class="it-search-wrapper">
									<span class="d-none d-md-block"><?php esc_html_e( 'Cerca', 'wp-digital-italia' ); ?></span>
									<button type="button" class="search-link rounded-icon" data-bs-toggle="modal" data-bs-target="#search-modal" aria-label="<?php esc_attr_e( 'Cerca nel sito', 'wp-digital-italia' ); ?>">
										<?php echo dci_icon( 'search', 'icon' ); ?>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="it-header-navbar-wrapper">
			<div class="container">
				<div class="row">
					<div class="col">
						<?php
						dci_render_navbar(
							array(
								'id'           => 'comune-navigation',
								'class'        => 'dci-comune-navbar',
								'menu_class'   => 'dci-comune-menu',
								'secondary'    => 'secondary-menu',
								'mobile_brand' => true,
								'depth'        => 2,
							)
						);
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>
<?php dci_render_search_modal(); ?>
