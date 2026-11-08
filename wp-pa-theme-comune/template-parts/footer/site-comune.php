<?php
/**
 * Footer del profilo Comune, modellato su comune.sandonatomilanese.mi.it:
 * blocco blu notte con marchio, menu di servizio e recapiti,
 * fascia finale più scura con link di utilità.
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
<footer class="it-footer dci-comune-footer">
	<div class="it-footer-main">
		<div class="container">
			<section class="pb-3">
				<?php dci_render_brand( array( 'tone' => 'light', 'class' => 'dci-comune-footer__brand' ) ); ?>
			</section>

			<?php
			$visible_menus = array_filter( $menus, 'dci_has_menu' );
			if ( $visible_menus ) :
				?>
				<section>
					<div class="row">
						<?php foreach ( $visible_menus as $location ) : ?>
							<div class="pb-4 col-sm-6 col-md-3">
								<h4><a href="#" class="underlined"><?php echo esc_html( wp_get_nav_menu_name( $location ) ); ?></a></h4>
								<div class="link-list-wrapper">
									<?php
									wp_nav_menu(
										array(
											'theme_location' => $location,
											'container'      => false,
											'fallback_cb'    => '__return_false',
											'items_wrap'     => '<ul id="%1$s" class="footer-list clearfix link-list %2$s">%3$s</ul>',
											'depth'          => 1,
											'walker'         => new bootstrap_5_wp_simple_menu_walker(),
										)
									);
									?>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</section>
			<?php endif; ?>

			<section class="pt-2 pb-4">
				<div class="row g-4">
					<div class="col-md-7">
						<?php if ( dci_address_line() ) : ?>
							<p class="mb-1"><?php echo esc_html( dci_address_line() ); ?></p>
						<?php endif; ?>
						<ul class="dci-comune-footer__contacts">
							<?php if ( $phone ) : ?>
								<li><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><?php echo dci_icon( 'telephone', 'icon icon-sm' ); ?><span><?php echo esc_html( $phone ); ?></span></a></li>
							<?php endif; ?>
							<?php if ( $email ) : ?>
								<li><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo dci_icon( 'mail', 'icon icon-sm' ); ?><span><?php echo esc_html( $email ); ?></span></a></li>
							<?php endif; ?>
							<?php if ( $pec ) : ?>
								<li><a href="mailto:<?php echo esc_attr( $pec ); ?>"><?php echo dci_icon( 'mail', 'icon icon-sm' ); ?><span>PEC <?php echo esc_html( $pec ); ?></span></a></li>
							<?php endif; ?>
							<?php if ( $vat ) : ?>
								<li><span><?php printf( esc_html__( 'P.IVA %s', 'wp-digital-italia' ), esc_html( $vat ) ); ?></span></li>
							<?php endif; ?>
						</ul>
					</div>
					<div class="col-md-5">
						<h4><?php esc_html_e( 'Link utili', 'wp-digital-italia' ); ?></h4>
						<ul class="dci-comune-footer__links">
							<?php if ( $trasp ) : ?>
								<li><a href="<?php echo esc_url( $trasp ); ?>"><?php esc_html_e( 'Amministrazione trasparente', 'wp-digital-italia' ); ?></a></li>
							<?php endif; ?>
							<?php if ( $urp ) : ?>
								<li><a href="<?php echo esc_url( $urp ); ?>"><?php esc_html_e( 'URP - Ufficio Relazioni con il Pubblico', 'wp-digital-italia' ); ?></a></li>
							<?php endif; ?>
							<li><a href="<?php echo esc_url( wp_login_url() ); ?>"><?php esc_html_e( 'Area personale', 'wp-digital-italia' ); ?></a></li>
						</ul>
						<?php dci_render_socials( array( 'label' => __( 'Seguici su', 'wp-digital-italia' ), 'class' => 'dci-comune-footer__socials' ) ); ?>
					</div>
				</div>
			</section>
		</div>
	</div>

	<div class="it-footer-small-prints clearfix">
		<div class="container">
			<div class="d-flex justify-content-between flex-wrap align-items-center">
				<div class="dci-comune-footer__prints">
					<?php dci_render_footer_prints(); ?>
				</div>
				<div class="credit">
					<a href="https://github.com/ttensrl/wp-digital-italia" target="_blank" rel="noopener">
						<?php esc_html_e( 'Realizzato con il Tema', 'wp-digital-italia' ); ?>
						<span class="strong"><?php esc_html_e( 'Digital Italia', 'wp-digital-italia' ); ?></span>
					</a>
				</div>
			</div>
		</div>
	</div>
</footer>
