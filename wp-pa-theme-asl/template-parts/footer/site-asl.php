<?php
/**
 * Footer del profilo ASL, modellato sul prototipo AGID:
 * fondo scuro con logo, aree tematiche (informativa, istituzionale, trasparenza),
 * contatti, social e link di utilità in fondo.
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
<section class="asl-rating" aria-labelledby="asl-rating-title">
	<div class="container">
		<div class="asl-rating__box">
			<h2 id="asl-rating-title"><?php esc_html_e( 'Quanto sono chiare le informazioni su questa pagina?', 'wp-digital-italia-asl' ); ?></h2>
			<ul class="asl-rating__stars">
				<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
					<li><button type="button" aria-label="<?php echo esc_attr( sprintf( _n( '%d stella su 5', '%d stelle su 5', $i, 'wp-digital-italia-asl' ), $i ) ); ?>"><span aria-hidden="true">&#9733;</span></button></li>
				<?php endfor; ?>
			</ul>
		</div>
	</div>
</section>
<footer class="it-footer dci-asl-footer">
	<?php
	/* ------------------------------------------------------------------ *
	 *  Corpo del footer: brand + aree tematiche su tre colonne.
	 * ------------------------------------------------------------------ */
	?>
	<div class="dci-asl-footer__main">
		<div class="container">
			<div class="row g-4 g-lg-5 align-items-start">

				<?php
				/* Colonna 1: Marchio dell'ente. */
				?>
				<div class="col-lg-3 col-md-4">
					<?php dci_render_brand( array( 'class' => 'dci-asl-footer__brand' ) ); ?>
					<p class="dci-asl-footer__portal mt-3">
						<?php echo esc_html__( 'Portale Sanitario Regionale', 'wp-digital-italia-asl' ); ?>
					</p>
				</div>

				<?php
				/* Colonna 2: Area Informativa. */
				?>
				<div class="col-lg-3 col-md-4">
					<h6 class="dci-asl-footer__section-title"><?php esc_html_e( 'Area Informativa', 'wp-digital-italia-asl' ); ?></h6>
					<ul class="dci-asl-footer__section-list">
						<li><a href="<?php echo esc_url( home_url( '/servizi-e-prestazioni/' ) ); ?>"><?php esc_html_e( 'Servizi e prestazioni', 'wp-digital-italia-asl' ); ?></a></li>
						<li><a href="<?php echo esc_url( get_post_type_archive_link( 'dipartimento' ) ); ?>"><?php esc_html_e( 'Strutture', 'wp-digital-italia-asl' ); ?></a></li>
						<li><a href="<?php echo esc_url( get_permalink( (int) get_option( 'page_for_posts' ) ?: home_url( '/asl-comunica/' ) ) ); ?>"><?php esc_html_e( 'ASL Comunica', 'wp-digital-italia-asl' ); ?></a></li>
					</ul>
				</div>

				<?php
				/* Colonna 3: Area Istituzionale. */
				?>
				<div class="col-lg-3 col-md-4">
					<h6 class="dci-asl-footer__section-title"><?php esc_html_e( 'Area Istituzionale', 'wp-digital-italia-asl' ); ?></h6>
					<ul class="dci-asl-footer__section-list">
						<li><a href="<?php echo esc_url( home_url( '/organizzazione/' ) ); ?>"><?php esc_html_e( 'Organizzazione', 'wp-digital-italia-asl' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/documenti/' ) ); ?>"><?php esc_html_e( 'Documenti', 'wp-digital-italia-asl' ); ?></a></li>
						<li><a href="<?php echo esc_url( get_post_type_archive_link( 'persona' ) ); ?>"><?php esc_html_e( 'Persone', 'wp-digital-italia-asl' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/lavora-con-noi/' ) ); ?>"><?php esc_html_e( 'Lavora con noi', 'wp-digital-italia-asl' ); ?></a></li>
						<?php if ( $urp ) : ?>
							<li><a href="<?php echo esc_url( $urp ); ?>"><?php esc_html_e( 'Ufficio Relazioni con il Pubblico (URP)', 'wp-digital-italia-asl' ); ?></a></li>
						<?php endif; ?>
						<li><a href="<?php echo esc_url( home_url( '/cup/' ) ); ?>"><?php esc_html_e( 'Centro Unico Prenotazioni (CUP)', 'wp-digital-italia-asl' ); ?></a></li>
					</ul>
				</div>

				<?php
				/* Colonna 4: Trasparenza. */
				?>
				<div class="col-lg-3">
					<h6 class="dci-asl-footer__section-title"><?php esc_html_e( 'Trasparenza', 'wp-digital-italia-asl' ); ?></h6>
					<ul class="dci-asl-footer__section-list">
						<?php if ( $trasp ) : ?>
							<li><a href="<?php echo esc_url( $trasp ); ?>"><?php esc_html_e( 'Amministrazione trasparente', 'wp-digital-italia-asl' ); ?></a></li>
						<?php else : ?>
							<li><a href="<?php echo esc_url( home_url( '/amministrazione-trasparente/' ) ); ?>"><?php esc_html_e( 'Amministrazione trasparente', 'wp-digital-italia-asl' ); ?></a></li>
						<?php endif; ?>
						<li><a href="<?php echo esc_url( home_url( '/albo-pretorio/' ) ); ?>"><?php esc_html_e( 'Albo pretorio', 'wp-digital-italia-asl' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/carta-dei-servizi/' ) ); ?>"><?php esc_html_e( 'Carta dei servizi', 'wp-digital-italia-asl' ); ?></a></li>
					</ul>
				</div>

			</div>
		</div>
	</div>

	<?php
	/* ------------------------------------------------------------------ *
	 *  Fascia contatti e social.
	 * ------------------------------------------------------------------ */
	?>
	<div class="dci-asl-footer__contacts">
		<div class="container">
			<div class="row g-4 align-items-center">
				<?php if ( $address || $city || $phone || $email || $pec || $vat ) : ?>
					<div class="col-lg-4 col-md-6">
						<h6 class="dci-asl-footer__section-title"><?php esc_html_e( 'Contatti', 'wp-digital-italia-asl' ); ?></h6>
						<div class="dci-asl-footer__info">
							<?php if ( $address || $city ) : ?>
								<p class="dci-asl-footer__address"><?php echo esc_html( dci_address_line( ' - ' ) ); ?></p>
							<?php endif; ?>
							<?php if ( $vat ) : ?>
								<p><?php printf( esc_html__( 'P.IVA %s', 'wp-digital-italia' ), esc_html( $vat ) ); ?></p>
							<?php endif; ?>
							<?php if ( $phone ) : ?>
								<p><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><?php echo dci_icon( 'telephone', 'icon icon-sm icon-white me-1' ); ?><?php echo esc_html( $phone ); ?></a></p>
							<?php endif; ?>
							<?php if ( $email ) : ?>
								<p><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo dci_icon( 'mail', 'icon icon-sm icon-white me-1' ); ?><?php echo esc_html( $email ); ?></a></p>
							<?php endif; ?>
							<?php if ( $pec ) : ?>
								<p><a href="mailto:<?php echo esc_attr( $pec ); ?>"><?php echo dci_icon( 'mail', 'icon icon-sm icon-white me-1' ); ?><?php esc_html_e( 'PEC', 'wp-digital-italia-asl' ); ?> <?php echo esc_html( $pec ); ?></a></p>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>

				<?php
				$socials = dci_social_links();
				if ( $socials ) : ?>
					<div class="col-lg-4 col-md-6 text-lg-end">
						<h6 class="dci-asl-footer__section-title"><?php esc_html_e( 'Seguici su', 'wp-digital-italia-asl' ); ?></h6>
						<?php dci_render_socials( array( 'label' => '', 'class' => 'dci-asl-footer__socials', 'icon_class' => 'icon icon-sm icon-white' ) ); ?>
					</div>
				<?php endif; ?>

				<?php if ( $urp ) : ?>
					<div class="col-lg-4 text-lg-end">
						<a class="dci-asl-footer__top" href="<?php echo esc_url( $urp ); ?>">
							<span><?php esc_html_e( 'URP', 'wp-digital-italia-asl' ); ?></span>
							<?php echo dci_icon( 'arrow-up', 'icon icon-sm icon-white' ); ?>
						</a>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<?php
	/* ------------------------------------------------------------------ *
	 *  Fascia finale: link di utilità + credit.
	 * ------------------------------------------------------------------ */
	?>
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
