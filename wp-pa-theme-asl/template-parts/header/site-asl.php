<?php
/**
 * Header del profilo ASL, modellato sul prototipo AGID:
 * fascia istituzionale con selettore lingua e area personale,
 * riga del logo con social e ricerca,
 * fascia info/contatti con CUP e URP (nessuna barra menu principale).
 *
 * @package digital-italia
 */
$area = dci_area_personale();
$lang = apply_filters( 'dci_topbar_language', 'ITA' );
?>
<header class="it-header-wrapper dci-asl-header">
	<!-- Fascia alta (topbar): selettore lingua + area personale -->
	<div class="dci-asl-topbar">
		<div class="container dci-asl-topbar__inner">
			<span class="dci-asl-topbar__link">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php echo esc_html( get_bloginfo( 'description' ) ?: 'Link al portale sanitario regionale' ); ?>
				</a>
			</span>

			<div class="dci-asl-topbar__actions">
				<?php if ( ! empty( $lang ) ) : ?>
					<div class="dci-asl-language">
						<?php echo esc_html( $lang ); ?>
						<?php echo dci_icon( 'chevron-down', 'icon icon-sm' ); ?>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $area['url'] ) ) : ?>
					<a class="dci-asl-areapersonale" href="<?php echo esc_url( $area['url'] ); ?>" title="<?php esc_attr_e( 'Accedi con SPID o CIE', 'wp-digital-italia' ); ?>">
						<?php echo dci_icon( 'user', 'icon icon-sm' ); ?>
						<span><?php echo esc_html( $area['label'] ); ?></span>
					</a>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<!-- Testata (masthead): logo + social + ricerca -->
	<div class="dci-asl-masthead">
		<div class="container">
			<div class="dci-asl-masthead__inner">
				<?php dci_render_brand( array( 'class' => 'dci-asl-brand' ) ); ?>

				<div class="dci-asl-tools">
					<?php dci_render_socials( array( 'label' => '', 'class' => 'dci-asl-socials' ) ); ?>

					<button class="dci-asl-search-toggle" type="button" data-bs-toggle="modal" data-bs-target="#search-modal" aria-label="<?php esc_attr_e( 'Apri la ricerca', 'wp-digital-italia' ); ?>">
						<?php echo dci_icon( 'search', 'icon' ); ?>
					</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Navigazione principale -->
	<div class="dci-asl-nav">
		<div class="container">
			<?php
			dci_render_navbar(
				array(
					'id'           => 'asl-nav',
					'class'        => 'dci-asl-navbar',
					'menu_class'   => 'dci-asl-menu',
					'mobile_brand' => true,
					'depth'        => 1,
				)
			);
			?>
		</div>
	</div>

	<!-- Fascia info/contatti sotto la nav (prenotazioni, CUP, segnalazioni, URP) -->
	<div class="dci-asl-info-strip">
		<div class="container dci-asl-info-strip__inner">
			<?php
			$phone = dci_mod( 'site_contact_phone' );
			$pec   = dci_contact_pec();
			$email = dci_contact_email();
			$urp   = dci_mod( 'site_contact_urp' );
			?>
			<div class="dci-asl-info-strip__item">
				<a href="<?php echo esc_url( home_url( '/prenota/' ) ); ?>">
					<?php echo dci_icon( 'calendar', 'icon icon-sm' ); ?>
					<?php esc_html_e( 'Prenota servizi e prestazioni', 'wp-digital-italia-asl' ); ?>
				</a>
			</div>
			<?php if ( $phone ) : ?>
				<div class="dci-asl-info-strip__item">
					<span class="dci-asl-info-strip__label">
						<?php echo dci_icon( 'telephone', 'icon icon-sm' ); ?>
						CUP <?php echo esc_html( $phone ); ?>
					</span>
				</div>
			<?php endif; ?>
			<div class="dci-asl-info-strip__item">
				<a href="<?php echo esc_url( $urp ?: home_url( '/contatti/' ) ); ?>">
					<?php echo dci_icon( 'mail', 'icon icon-sm' ); ?>
					<?php esc_html_e( 'Richiedi informazioni o fai una segnalazione', 'wp-digital-italia-asl' ); ?>
				</a>
			</div>
			<?php if ( $phone ) : ?>
				<div class="dci-asl-info-strip__item">
					<span class="dci-asl-info-strip__label">
						<?php echo dci_icon( 'telephone', 'icon icon-sm' ); ?>
						URP <?php echo esc_html( $phone ); ?>
					</span>
				</div>
			<?php endif; ?>
		</div>
	</div>
</header>
<?php dci_render_search_modal(); ?>
