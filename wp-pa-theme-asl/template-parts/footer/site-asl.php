<?php
/**
 * Footer del profilo ASL, modellato su aslroma1.it:
 * fondo grigio chiaro con logo, recapiti, link di servizio e ritorno in alto.
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
?>
<footer class="it-footer dci-asl-footer">
	<div class="dci-asl-footer__main">
		<div class="container">
			<div class="row g-4 align-items-start">
				<div class="col-lg-3 col-md-4">
					<?php dci_render_brand( array( 'class' => 'dci-asl-footer__brand' ) ); ?>
				</div>

				<div class="col-lg-6 col-md-8">
					<div class="dci-asl-footer__info">
						<?php if ( $address || $city ) : ?>
							<p class="dci-asl-footer__address"><?php echo esc_html( dci_address_line( ' - ' ) ); ?></p>
						<?php endif; ?>
						<?php if ( $vat ) : ?>
							<p><?php printf( esc_html__( 'P.IVA %s', 'wp-digital-italia' ), esc_html( $vat ) ); ?></p>
						<?php endif; ?>
						<?php if ( $phone ) : ?>
							<p><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></p>
						<?php endif; ?>

						<ul class="dci-asl-footer__links">
							<?php if ( $email ) : ?>
								<li><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></li>
							<?php endif; ?>
							<?php if ( $pec ) : ?>
								<li><a href="mailto:<?php echo esc_attr( $pec ); ?>"><?php echo esc_html( $pec ); ?></a></li>
							<?php endif; ?>
							<?php if ( $trasp ) : ?>
								<li><a href="<?php echo esc_url( $trasp ); ?>"><?php esc_html_e( 'Amministrazione trasparente', 'wp-digital-italia' ); ?></a></li>
							<?php endif; ?>
							<?php if ( $urp ) : ?>
								<li><a href="<?php echo esc_url( $urp ); ?>"><?php esc_html_e( 'URP', 'wp-digital-italia' ); ?></a></li>
							<?php endif; ?>
						</ul>
					</div>
				</div>

				<div class="col-lg-3 text-lg-end">
					<a class="dci-asl-footer__top" href="#" data-attribute="back-to-top">
						<span><?php esc_html_e( 'Torna su', 'wp-digital-italia' ); ?></span>
						<?php echo dci_icon( 'arrow-up', 'icon icon-sm' ); ?>
					</a>
				</div>
			</div>
		</div>
	</div>

	<div class="dci-asl-footer__bottom">
		<div class="container dci-asl-footer__bottom-inner">
			<div class="dci-asl-footer__prints">
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
</footer>
