<?php
/**
 * Footer generico (fallback per i child che non definiscono una variante).
 *
 * @package digital-italia
 */
$white_logo            = dci_mod( 'white_logo' );
$city                  = dci_mod( 'site_contact_city' );
$phone                 = dci_mod( 'site_contact_phone' );
$address               = dci_mod( 'site_contact_address' );
$urp_url               = dci_mod( 'site_contact_urp' );
$admin_transparent_url = dci_mod( 'site_contact_administration_transparent' );
$footer_menus          = array( 'footer-one', 'footer-two', 'footer-three', 'footer-four' );
?>
<footer class="it-footer">
	<div class="it-footer-main">
		<div class="container-fluid">
			<section class="p-3">
				<div class="d-flex flex-column flex-sm-row align-items-center gap-4">
					<?php if ( $white_logo ) : ?>
						<div class="it-brand-wrapper flex-shrink-0">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
								<div class="it-brand-text pe-0">
									<img src="<?php echo esc_url( $white_logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" height="120">
								</div>
							</a>
						</div>
					<?php endif; ?>
					<div class="d-flex flex-column flex-sm-row flex-wrap gap-4 w-100">
						<?php foreach ( $footer_menus as $location ) : ?>
							<?php if ( dci_has_menu( $location ) ) : ?>
								<div class="pb-2">
									<h4 class="h6 text-uppercase"><?php echo esc_html( wp_get_nav_menu_name( $location ) ); ?></h4>
									<div class="link-list-wrapper">
										<?php
										wp_nav_menu(
											array(
												'theme_location' => $location,
												'container'      => false,
												'fallback_cb'    => '__return_false',
												'items_wrap'     => '<ul id="%1$s" class="footer-list link-list clearfix %2$s">%3$s</ul>',
												'depth'          => 1,
												'walker'         => new bootstrap_5_wp_simple_menu_walker(),
											)
										);
										?>
									</div>
								</div>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				</div>
			</section>
			<div class="px-3">
				<section class="py-4 px-0 border-white border-top">
					<div class="row">
						<div class="col-lg-4 col-md-4 pb-2">
							<h4>
								<a href="<?php echo esc_url( $admin_transparent_url ?: '#' ); ?>" title="<?php esc_attr_e( 'Vai alla pagina: Amministrazione trasparente', 'wp-digital-italia' ); ?>"><?php esc_html_e( 'Amministrazione trasparente', 'wp-digital-italia' ); ?></a>
							</h4>
							<p><?php esc_html_e( 'I dati personali pubblicati sono riutilizzabili solo alle condizioni previste dalla direttiva comunitaria 2003/98/CE e dal d.lgs. 36/2006.', 'wp-digital-italia' ); ?></p>
						</div>
						<div class="col-lg-4 col-md-4 offset-lg-1 pb-2">
							<p>
								<strong><?php echo esc_html( $city ); ?></strong><br>
								<?php echo esc_html( $address ); ?><?php echo $phone ? ' - ' . esc_html( $phone ) : ''; ?>
							</p>
							<div class="link-list-wrapper">
								<ul class="footer-list link-list clearfix">
									<?php if ( $urp_url ) : ?>
										<li><a class="list-item" href="<?php echo esc_url( $urp_url ); ?>"><?php esc_html_e( 'URP - Ufficio Relazioni con il Pubblico', 'wp-digital-italia' ); ?></a></li>
									<?php endif; ?>
									<?php if ( $admin_transparent_url ) : ?>
										<li><a class="list-item" href="<?php echo esc_url( $admin_transparent_url ); ?>"><?php esc_html_e( 'Amministrazione Trasparente', 'wp-digital-italia' ); ?></a></li>
									<?php endif; ?>
								</ul>
							</div>
						</div>
						<?php if ( dci_social_links() ) : ?>
							<div class="col-md-auto ms-md-auto pb-2">
								<h4><a href="#" title="<?php esc_attr_e( 'Vai alla pagina: Seguici su', 'wp-digital-italia' ); ?>"><?php esc_html_e( 'Seguici su', 'wp-digital-italia' ); ?></a></h4>
								<?php dci_render_socials( array( 'label' => '', 'icon_class' => 'icon icon-sm' ) ); ?>
							</div>
						<?php endif; ?>
					</div>
				</section>
			</div>
		</div>
	</div>
	<div class="it-footer-small-prints clearfix py-3">
		<div class="container-fluid">
			<h3 class="visually-hidden"><?php echo esc_html( wp_get_nav_menu_name( 'footer-bottom' ) ); ?></h3>
			<div class="d-flex justify-content-between flex-wrap">
				<ul class="it-footer-small-prints-list list-inline mb-0">
					<?php
					if ( dci_has_menu( 'footer-bottom' ) ) {
						wp_nav_menu(
							array(
								'theme_location' => 'footer-bottom',
								'container'      => false,
								'menu_class'     => 'list-inline-item',
								'fallback_cb'    => '__return_false',
								'items_wrap'     => '<ul id="%1$s" class="footer-list link-list clearfix %2$s">%3$s</ul>',
								'depth'          => 1,
								'walker'         => new bootstrap_5_wp_inline_menu_walker(),
							)
						);
					}
					?>
				</ul>
				<div class="credit text-white">
					<a class="d-inline-flex align-items-center text-white fw-normal text-nowrap" href="https://github.com/ttensrl/wp-digital-italia" target="_blank" rel="noopener">
						<?php esc_html_e( 'Realizzato con il Tema', 'wp-digital-italia' ); ?>
						<span class="strong fw-bold ms-2"><?php esc_html_e( 'Digital Italia', 'wp-digital-italia' ); ?></span>
						<?php echo dci_icon( 'github', 'icon icon-sm icon-white align-top ms-2' ); ?>
						<span class="visually-hidden"> (GitHub)</span>
					</a>
				</div>
			</div>
		</div>
	</div>
</footer>
