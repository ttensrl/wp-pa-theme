<?php
/**
 * Header del profilo Scuola, modellato su federicocaffe.edu.it (tema NEWMIUR):
 * pre-header Ministero con contatti e area riservata, testata bianca con
 * marchio scomposto e ricerca, navigazione chiara in maiuscolo.
 *
 * @package digital-italia
 */
$area = dci_area_personale();
?>
<header class="it-header-wrapper dci-scuola-header">
	<div id="pre-header" class="it-header-slim-wrapper">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="it-header-slim-wrapper-content">
						<div class="d-flex align-items-center flex-wrap gap-3">
							<a class="navbar-brand fw-bold mb-0" href="https://www.miur.gov.it/" target="_blank" rel="noopener noreferrer">
								<?php esc_html_e( "Ministero dell'Istruzione e del Merito", 'wp-digital-italia' ); ?>
							</a>
							<?php dci_render_contacts( array( 'style' => 'dropdown', 'class' => 'dci-scuola-contacts d-none d-md-flex' ) ); ?>
						</div>

						<?php if ( ! empty( $area['url'] ) ) : ?>
							<div class="it-header-slim-right-zone">
								<a class="btn btn-sm dci-scuola-area" href="<?php echo esc_url( $area['url'] ); ?>">
									<?php echo esc_html( $area['label'] ); ?>
								</a>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="it-nav-wrapper">
		<div class="it-header-center-wrapper" id="header-center">
			<div class="container">
				<div class="row">
					<div class="col-12 p-0">
						<div class="it-header-center-content-wrapper">
							<?php dci_render_brand( array( 'logo' => 'auto', 'class' => 'dci-scuola-brand' ) ); ?>
							<div class="it-right-zone d-none d-lg-block">
								<?php dci_render_search_form( array( 'id' => 'header-search', 'class' => 'dci-scuola-search' ) ); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="it-header-navbar-wrapper" id="menu-top">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<?php
						dci_render_navbar(
							array(
								'id'           => 'scuola-navigation',
								'class'        => 'dci-scuola-navbar',
								'menu_class'   => 'dci-scuola-menu',
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
