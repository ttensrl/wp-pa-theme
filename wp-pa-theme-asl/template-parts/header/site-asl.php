<?php
/**
 * Header del profilo ASL, modellato su aslroma1.it:
 * fascia istituzionale, riga del logo con area personale e social,
 * barra di navigazione chiara.
 *
 * @package digital-italia
 */
$area = dci_area_personale();
?>
<header class="it-header-wrapper dci-asl-header">
	<div class="dci-asl-topbar">
		<div class="container dci-asl-topbar__inner">
			<span class="dci-asl-topbar__ente"><?php echo esc_html( get_bloginfo( 'description' ) ); ?></span>
			<?php foreach ( dci_parent_entities() as $ente ) : ?>
				<a class="dci-asl-topbar__link" href="<?php echo esc_url( $ente['url'] ?: home_url( '/' ) ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $ente['name'] ); ?></a>
			<?php endforeach; ?>
		</div>
	</div>

	<div class="dci-asl-masthead">
		<div class="container">
			<div class="dci-asl-masthead__inner">
				<?php dci_render_brand( array( 'class' => 'dci-asl-brand' ) ); ?>

				<div class="dci-asl-tools">
					<?php if ( ! empty( $area['url'] ) ) : ?>
						<a class="dci-asl-areapersonale" href="<?php echo esc_url( $area['url'] ); ?>" title="<?php esc_attr_e( 'Accedi con SPID o CIE', 'wp-digital-italia' ); ?>">
							<span class="dci-asl-areapersonale__label"><?php echo esc_html( $area['label'] ); ?></span>
							<span class="dci-asl-areapersonale__ids">
								<img class="dci-asl-id dci-asl-id--spid" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/identity/spid-bianco.svg' ); ?>" alt="SPID" height="26">
								<img class="dci-asl-id dci-asl-id--cie" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/identity/cie-bianco.svg' ); ?>" alt="CIE" height="30">
							</span>
						</a>
					<?php endif; ?>

					<?php dci_render_socials( array( 'label' => '', 'class' => 'dci-asl-socials' ) ); ?>

					<button class="dci-asl-search-toggle" type="button" data-bs-toggle="modal" data-bs-target="#search-modal" aria-label="<?php esc_attr_e( 'Apri la ricerca', 'wp-digital-italia' ); ?>">
						<?php echo dci_icon( 'search', 'icon' ); ?>
					</button>
				</div>
			</div>
		</div>
	</div>

	<div class="dci-asl-nav">
		<div class="container">
			<?php
			dci_render_navbar(
				array(
					'id'           => 'asl-nav',
					'class'        => 'dci-asl-navbar',
					'menu_class'   => 'dci-asl-menu',
					'mobile_brand' => true,
					'depth'        => 2,
				)
			);
			?>
		</div>
	</div>
</header>
<?php dci_render_search_modal(); ?>
