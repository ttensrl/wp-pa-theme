<?php
/**
 * Footer del profilo Scuola, modellato su federicocaffe.edu.it:
 * fondo scuro con marchio, recapiti della scuola, menu di servizio
 * e fascia finale con link di trasparenza.
 *
 * @package digital-italia
 */
$city    = dci_mod( 'site_contact_city' );
$address = dci_mod( 'site_contact_address' );
$phone   = dci_mod( 'site_contact_phone' );
$email   = dci_contact_email();
$pec     = dci_contact_pec();
$vat     = dci_mod( 'site_contact_vat' );
$urp     = dci_mod( 'site_contact_urp' );
$trasp   = dci_mod( 'site_contact_administration_transparent' );
$menus   = array( 'footer-one', 'footer-two', 'footer-three', 'footer-four' );
?>
<footer class="dci-scuola-footer">
	<div class="container-fluid">
		<div class="container">
			<div class="row align-items-center dci-scuola-footer__brand-row">
				<div class="col-12 col-lg-8">
					<?php dci_render_brand( array( 'tone' => 'light', 'class' => 'dci-scuola-footer__brand' ) ); ?>
				</div>
				<div class="col-12 col-lg-4">
					<div class="dci-scuola-footer__logos">
						<a href="https://www.miur.gov.it/" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'MIUR', 'wp-digital-italia' ); ?></a>
						<a href="https://www.istruzione.it/pnrr/" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'PNRR', 'wp-digital-italia' ); ?></a>
					</div>
				</div>
			</div>

			<div class="row dci-scuola-footer__center">
				<div class="col-12 col-md-6 col-lg-4 dci-scuola-footer__section">
					<h2 class="dci-scuola-footer__title"><?php esc_html_e( 'Contatti scuola', 'wp-digital-italia' ); ?></h2>
					<hr>
					<ul class="dci-scuola-footer__contacts">
						<?php if ( dci_address_line() ) : ?>
							<li><?php echo esc_html( dci_address_line() ); ?></li>
						<?php endif; ?>
						<?php if ( $phone ) : ?>
							<li><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></li>
						<?php endif; ?>
						<?php if ( $email ) : ?>
							<li><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></li>
						<?php endif; ?>
						<?php if ( $pec ) : ?>
							<li><a href="mailto:<?php echo esc_attr( $pec ); ?>">PEC: <?php echo esc_html( $pec ); ?></a></li>
						<?php endif; ?>
						<?php if ( $vat ) : ?>
							<li><?php printf( esc_html__( 'Codice fiscale: %s', 'wp-digital-italia' ), esc_html( $vat ) ); ?></li>
						<?php endif; ?>
					</ul>
				</div>

				<?php foreach ( array_filter( $menus, 'dci_has_menu' ) as $location ) : ?>
					<div class="col-12 col-md-6 col-lg-4 dci-scuola-footer__section">
						<h2 class="dci-scuola-footer__title"><?php echo esc_html( wp_get_nav_menu_name( $location ) ); ?></h2>
						<hr>
						<?php
						wp_nav_menu(
							array(
								'theme_location' => $location,
								'container'      => false,
								'fallback_cb'    => '__return_false',
								'items_wrap'     => '<ul id="%1$s" class="dci-scuola-footer__menu %2$s">%3$s</ul>',
								'depth'          => 1,
								'walker'         => new bootstrap_5_wp_simple_menu_walker(),
							)
						);
						?>
					</div>
				<?php endforeach; ?>

				<div class="col-12 col-md-6 col-lg-4 dci-scuola-footer__section">
					<h2 class="dci-scuola-footer__title"><?php esc_html_e( 'Link utili', 'wp-digital-italia' ); ?></h2>
					<hr>
					<ul class="dci-scuola-footer__menu">
						<?php if ( $trasp ) : ?>
							<li><a href="<?php echo esc_url( $trasp ); ?>"><?php esc_html_e( 'Amministrazione trasparente', 'wp-digital-italia' ); ?></a></li>
						<?php endif; ?>
						<?php if ( $urp ) : ?>
							<li><a href="<?php echo esc_url( $urp ); ?>"><?php esc_html_e( 'URP', 'wp-digital-italia' ); ?></a></li>
						<?php endif; ?>
						<li><a href="<?php echo esc_url( wp_login_url() ); ?>"><?php esc_html_e( 'Area riservata', 'wp-digital-italia' ); ?></a></li>
					</ul>
				</div>
			</div>

			<div class="dci-scuola-footer__bottom">
				<div class="row align-items-center">
					<div class="col-12 col-md-6">
						<?php dci_render_footer_prints( array( 'list_class' => 'dci-scuola-footer__prints' ) ); ?>
					</div>
					<div class="col-12 col-md-6">
						<div class="dci-scuola-footer__socials">
							<?php dci_render_socials( array( 'label' => __( 'Seguici su', 'wp-digital-italia' ) ) ); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>
