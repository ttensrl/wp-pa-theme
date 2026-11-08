<?php
/**
 * Header, footer e navigazione: helper condivisi dal parent e varianti per ente.
 *
 * Il parent fornisce lo scheletro (head, cookie bar, #page) e delega header e
 * footer a template-parts/header/site-{variante}.php e
 * template-parts/footer/site-{variante}.php. Ogni child sceglie la propria
 * variante con i filtri dci_header_variant / dci_footer_variant.
 *
 * @package digital-italia
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Variante header attiva (default: 'default'). */
function dci_header_variant(): string {
	return sanitize_key( (string) apply_filters( 'dci_header_variant', 'default' ) );
}

/** Variante footer attiva (default: 'default'). */
function dci_footer_variant(): string {
	return sanitize_key( (string) apply_filters( 'dci_footer_variant', 'default' ) );
}

/** Legge un theme mod restituendo una stringa pulita. */
function dci_mod( string $key, string $default = '' ): string {
	$value = get_theme_mod( $key, $default );
	return is_scalar( $value ) ? (string) $value : '';
}

/**
 * Dati dell'ente di appartenenza mostrati nella fascia alta dell'header.
 *
 * @return array{name:string,url:string}
 */
function dci_parent_entity(): array {
	$defaults = array(
		'name' => dci_mod( 'site_parent_entity_name' ),
		'url'  => dci_mod( 'site_parent_entity_url' ),
	);
	return (array) apply_filters( 'dci_parent_entity', $defaults );
}

/**
 * Enti mostrati nella fascia alta (es. Regione + Città metropolitana).
 *
 * @return array<int,array{name:string,url:string}>
 */
function dci_parent_entities(): array {
	$primary = dci_parent_entity();
	$list    = array();
	if ( ! empty( $primary['name'] ) ) {
		$list[] = $primary;
	}
	return (array) apply_filters( 'dci_parent_entities', $list );
}

/**
 * Area personale / area riservata.
 *
 * @return array{label:string,url:string}
 */
function dci_area_personale(): array {
	$defaults = array(
		'label' => dci_mod( 'site_area_personale_label', __( 'Area personale', 'wp-digital-italia' ) ),
		'url'   => dci_mod( 'site_area_personale_url' ),
	);
	return (array) apply_filters( 'dci_area_personale', $defaults );
}

/** Email istituzionale del sito. */
function dci_contact_email(): string {
	return dci_mod( 'site_contact_email' );
}

/** PEC del sito. */
function dci_contact_pec(): string {
	return dci_mod( 'site_contact_pec' );
}

/** Indirizzo completo della sede, senza ripetere la città se già presente. */
function dci_address_line( string $separator = ', ' ): string {
	$address = trim( dci_mod( 'site_contact_address' ) );
	$city    = trim( dci_mod( 'site_contact_city' ) );

	if ( ! $address ) {
		return $city;
	}
	if ( $city && false === stripos( $address, $city ) ) {
		return $address . $separator . $city;
	}
	return $address;
}

/**
 * Social attivi, in ordine di visualizzazione.
 *
 * @return array<int,array{key:string,label:string,url:string,icon:string}>
 */
function dci_social_links(): array {
	$map = array(
		'facebook'  => array( 'Facebook', 'it-facebook' ),
		'twitter'   => array( 'X (Twitter)', 'it-twitter' ),
		'instagram' => array( 'Instagram', 'it-instagram' ),
		'linkedin'  => array( 'LinkedIn', 'it-linkedin' ),
		'youtube'   => array( 'YouTube', 'it-youtube' ),
	);
	$links = array();
	foreach ( $map as $key => $meta ) {
		$url = dci_mod( 'site_socials_' . $key );
		if ( $url ) {
			$links[] = array(
				'key'   => $key,
				'label' => $meta[0],
				'url'   => $url,
				'icon'  => $meta[1],
			);
		}
	}
	return (array) apply_filters( 'dci_social_links', $links );
}

/**
 * Scompone il nome del sito in sottotitolo, titolo e tagline del marchio.
 *
 * @return array{prefix:string,name:string,tagline:string}
 */
function dci_brand_parts(): array {
	$name    = trim( (string) get_bloginfo( 'name' ) );
	$prefix  = '';
	$brand   = $name;
	$tagline = '';

	$known = array(
		'Comune di '                 => __( 'Comune di', 'wp-digital-italia' ),
		'Città di '                  => __( 'Città di', 'wp-digital-italia' ),
		'Citta di '                  => __( 'Città di', 'wp-digital-italia' ),
		'IC '                        => __( 'Istituto Comprensivo', 'wp-digital-italia' ),
		'I.C. '                      => __( 'Istituto Comprensivo', 'wp-digital-italia' ),
		'Istituto Comprensivo '      => __( 'Istituto Comprensivo', 'wp-digital-italia' ),
		'ASL '                       => __( 'ASL', 'wp-digital-italia' ),
	);
	foreach ( $known as $needle => $label ) {
		if ( 0 === strpos( $name, $needle ) ) {
			$prefix = $label;
			$brand  = trim( substr( $name, strlen( $needle ) ) );
			break;
		}
	}

	$parts = array(
		'prefix'  => $prefix,
		'name'    => $brand ?: $name,
		'tagline' => $tagline,
	);
	return (array) apply_filters( 'dci_brand_parts', $parts );
}

/** URL del logo da usare nell'header/footer. */
function dci_logo_url( string $tone = 'auto' ): string {
	$custom = (int) get_theme_mod( 'custom_logo' );
	$url    = $custom ? (string) wp_get_attachment_image_url( $custom, 'full' ) : '';

	if ( 'light' === $tone ) {
		$url = dci_mod( 'white_logo' ) ?: $url;
	}
	if ( ! $url ) {
		$url = dci_mod( 'belong_administration_logo' );
	}
	return $url;
}

/**
 * Marchio del sito: logo (se presente) + testo scomposto.
 *
 * @param array{logo?:string,tone?:string,class?:string,tagline?:bool} $args Opzioni.
 */
function dci_render_brand( array $args = array() ): void {
	$args = wp_parse_args(
		$args,
		array(
			'logo'    => 'auto',
			'tone'    => 'auto',
			'class'   => '',
			'tagline' => true,
		)
	);
	$parts = dci_brand_parts();
	$logo  = 'none' === $args['logo'] ? '' : dci_logo_url( $args['tone'] );
	?>
	<div class="it-brand-wrapper <?php echo esc_attr( $args['class'] ); ?>">
		<a class="dci-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<?php if ( $logo ) : ?>
				<img class="dci-brand__logo" src="<?php echo esc_url( $logo ); ?>" alt="" decoding="async">
			<?php endif; ?>
			<div class="it-brand-text">
				<?php if ( ! empty( $parts['prefix'] ) ) : ?>
					<div class="it-brand-subtitle"><?php echo esc_html( $parts['prefix'] ); ?></div>
				<?php endif; ?>
				<div class="it-brand-title"><?php echo esc_html( $parts['name'] ); ?></div>
				<?php if ( $args['tagline'] && ! empty( $parts['tagline'] ) ) : ?>
					<div class="it-brand-tagline d-block"><?php echo esc_html( $parts['tagline'] ); ?></div>
				<?php endif; ?>
			</div>
		</a>
	</div>
	<?php
}

/**
 * Elenco social in stile Bootstrap Italia.
 *
 * @param array{label?:string,class?:string,icon_class?:string} $args Opzioni.
 */
function dci_render_socials( array $args = array() ): void {
	$args  = wp_parse_args(
		$args,
		array(
			'label'      => __( 'Seguici su', 'wp-digital-italia' ),
			'class'      => '',
			'icon_class' => 'icon',
		)
	);
	$links = dci_social_links();
	if ( ! $links ) {
		return;
	}
	?>
	<div class="it-socials dci-socials <?php echo esc_attr( $args['class'] ); ?>">
		<?php if ( $args['label'] ) : ?><span><?php echo esc_html( $args['label'] ); ?></span><?php endif; ?>
		<ul>
			<?php foreach ( $links as $link ) : ?>
				<li>
					<a href="<?php echo esc_url( $link['url'] ); ?>" aria-label="<?php echo esc_attr( $link['label'] ); ?>" target="_blank" rel="noopener noreferrer">
						<?php echo dci_icon( str_replace( 'it-', '', $link['icon'] ), $args['icon_class'] ); ?>
						<span class="visually-hidden"><?php echo esc_html( $link['label'] ); ?></span>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php
}

/** Vero se la posizione menu contiene almeno una voce. */
function dci_has_menu( string $location ): bool {
	$locations = get_nav_menu_locations();
	return ! empty( $locations[ $location ] ) && (bool) wp_get_nav_menu_items( $locations[ $location ] );
}

/**
 * Link di utilità della fascia finale del footer.
 *
 * Se il menu "footer-bottom" non è popolato si usano le pagine di Privacy e
 * Accessibilità del sito, così la fascia non resta vuota.
 *
 * @return array<int,array{url:string,label:string}>
 */
function dci_footer_utility_links(): array {
	$links = array();

	$privacy_id = (int) get_option( 'wp_page_for_privacy_policy' );
	if ( $privacy_id ) {
		$links[] = array(
			'url'   => get_permalink( $privacy_id ),
			'label' => __( 'Privacy', 'wp-digital-italia' ),
		);
	} else {
		$privacy_page = get_page_by_path( 'privacy' );
		if ( $privacy_page instanceof WP_Post && 'publish' === $privacy_page->post_status ) {
			$links[] = array(
				'url'   => get_permalink( $privacy_page ),
				'label' => __( 'Privacy', 'wp-digital-italia' ),
			);
		}
	}

	$fallbacks = array(
		'accessibilita' => __( 'Accessibilità', 'wp-digital-italia' ),
		'note-legali'   => __( 'Note legali', 'wp-digital-italia' ),
	);

	foreach ( $fallbacks as $slug => $label ) {
		$page = get_page_by_path( $slug );
		if ( $page instanceof WP_Post && 'publish' === $page->post_status ) {
			$links[] = array(
				'url'   => get_permalink( $page ),
				'label' => $label,
			);
		}
	}

	return (array) apply_filters( 'dci_footer_utility_links', $links );
}

/**
 * Fascia finale del footer: menu "footer-bottom" o, in mancanza, i link di
 * utilità del sito.
 *
 * @param array<string,mixed> $args Opzioni: list_class, item_class.
 */
function dci_render_footer_prints( array $args = array() ): void {
	$args = wp_parse_args(
		$args,
		array(
			'list_class' => 'it-footer-small-prints-list list-inline mb-0',
			'item_class' => 'list-inline-item',
		)
	);

	if ( dci_has_menu( 'footer-bottom' ) ) {
		wp_nav_menu(
			array(
				'theme_location' => 'footer-bottom',
				'container'      => false,
				'fallback_cb'    => '__return_false',
				'menu_class'     => $args['item_class'],
				'items_wrap'     => '<ul id="%1$s" class="' . esc_attr( $args['list_class'] ) . ' %2$s">%3$s</ul>',
				'depth'          => 1,
				'walker'         => new bootstrap_5_wp_inline_menu_walker(),
			)
		);
		return;
	}

	$links = dci_footer_utility_links();
	if ( ! $links ) {
		return;
	}

	printf( '<ul class="%s">', esc_attr( $args['list_class'] ) );
	foreach ( $links as $link ) {
		printf(
			'<li class="%1$s"><a href="%2$s">%3$s</a></li>',
			esc_attr( $args['item_class'] ),
			esc_url( $link['url'] ),
			esc_html( $link['label'] )
		);
	}
	echo '</ul>';
}

/**
 * Menu di navigazione con il walker Bootstrap Italia.
 *
 * @param string               $location Posizione menu registrata.
 * @param array<string,mixed>  $args     Opzioni wp_nav_menu.
 */
function dci_render_menu( string $location, array $args = array() ): void {
	if ( ! dci_has_menu( $location ) ) {
		return;
	}
	$depth  = isset( $args['depth'] ) ? (int) $args['depth'] : 2;
	$walker = 2 === $depth ? new bootstrap_5_wp_main_menu_walker() : new bootstrap_5_wp_simple_menu_walker();

	wp_nav_menu(
		wp_parse_args(
			$args,
			array(
				'theme_location' => $location,
				'container'      => false,
				'fallback_cb'    => '__return_false',
				'items_wrap'     => '<ul id="%1$s" class="navbar-nav %2$s">%3$s</ul>',
				'depth'          => $depth,
				'walker'         => $walker,
			)
		)
	);
}

/**
 * Contatti (telefono, email, PEC) come dropdown o riga di link.
 *
 * @param array{style?:string,class?:string} $args Opzioni.
 */
function dci_render_contacts( array $args = array() ): void {
	$args  = wp_parse_args( $args, array( 'style' => 'dropdown', 'class' => '' ) );
	$phone = dci_mod( 'site_contact_phone' );
	$email = dci_contact_email();
	$pec   = dci_contact_pec();

	if ( ! $phone && ! $email && ! $pec ) {
		return;
	}

	if ( 'inline' === $args['style'] ) : ?>
		<ul class="dci-contacts-inline <?php echo esc_attr( $args['class'] ); ?>">
			<?php if ( $phone ) : ?>
				<li><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><?php echo dci_icon( 'telephone' ); ?><span><?php echo esc_html( $phone ); ?></span></a></li>
			<?php endif; ?>
			<?php if ( $email ) : ?>
				<li><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo dci_icon( 'mail' ); ?><span><?php echo esc_html( $email ); ?></span></a></li>
			<?php endif; ?>
			<?php if ( $pec ) : ?>
				<li><a href="mailto:<?php echo esc_attr( $pec ); ?>"><?php echo dci_icon( 'mail' ); ?><span>PEC <?php echo esc_html( $pec ); ?></span></a></li>
			<?php endif; ?>
		</ul>
		<?php
		return;
	endif;
	?>
	<div class="dci-contacts-dropdown <?php echo esc_attr( $args['class'] ); ?>">
		<?php if ( $phone ) : ?>
			<div class="btn-group dci-contact" data-bs-toggle="tooltip" title="<?php esc_attr_e( 'Apri contatti telefonici', 'wp-digital-italia' ); ?>">
				<button type="button" class="dci-contact__toggle dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
					<span class="dci-contact__icon"><?php echo dci_icon( 'telephone', 'icon' ); ?></span>
					<span class="visually-hidden"><?php esc_html_e( 'Contatti telefonici', 'wp-digital-italia' ); ?></span>
				</button>
				<div class="dropdown-menu dci-contact__menu">
					<div class="link-list-wrapper">
						<ul class="link-list">
							<li class="list-item">
								<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>">
									<span class="dci-contact__icon"><?php echo dci_icon( 'telephone', 'icon' ); ?></span>
									<span><?php echo esc_html( $phone ); ?></span>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		<?php endif; ?>
		<?php if ( $email || $pec ) : ?>
			<div class="btn-group dci-contact" data-bs-toggle="tooltip" title="<?php esc_attr_e( 'Apri contatti email', 'wp-digital-italia' ); ?>">
				<button type="button" class="dci-contact__toggle dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
					<span class="dci-contact__icon"><?php echo dci_icon( 'mail', 'icon' ); ?></span>
					<span class="visually-hidden"><?php esc_html_e( 'Contatti email', 'wp-digital-italia' ); ?></span>
				</button>
				<div class="dropdown-menu dci-contact__menu">
					<div class="link-list-wrapper">
						<ul class="link-list">
							<?php if ( $email ) : ?>
								<li class="list-item"><a href="mailto:<?php echo esc_attr( $email ); ?>"><span class="dci-contact__icon"><?php echo dci_icon( 'mail', 'icon' ); ?></span><span><?php echo esc_html( $email ); ?></span></a></li>
							<?php endif; ?>
							<?php if ( $pec ) : ?>
								<li class="list-item"><a href="mailto:<?php echo esc_attr( $pec ); ?>"><span class="dci-contact__icon"><?php echo dci_icon( 'mail', 'icon' ); ?></span><span>PEC <?php echo esc_html( $pec ); ?></span></a></li>
							<?php endif; ?>
						</ul>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
	<?php
}

/** Pulsante area personale / riservata. */
function dci_render_area_personale( array $args = array() ): void {
	$area = dci_area_personale();
	if ( empty( $area['url'] ) ) {
		return;
	}
	$args = wp_parse_args( $args, array( 'class' => 'btn btn-sm btn-primary' ) );
	printf(
		'<a class="%1$s" href="%2$s">%3$s</a>',
		esc_attr( $args['class'] ),
		esc_url( $area['url'] ),
		esc_html( $area['label'] )
	);
}

/**
 * Campi di ricerca per l'header.
 *
 * @param array{id?:string,class?:string,button?:bool} $args Opzioni.
 */
function dci_render_search_form( array $args = array() ): void {
	$args = wp_parse_args(
		$args,
		array(
			'id'     => 'header-search',
			'class'  => '',
			'button' => true,
		)
	);
	?>
	<form class="dci-search-form <?php echo esc_attr( $args['class'] ); ?>" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<label class="visually-hidden" for="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Cerca nel sito', 'wp-digital-italia' ); ?></label>
		<div class="dci-search-form__inner">
			<input type="search" id="<?php echo esc_attr( $args['id'] ); ?>" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Cerca', 'wp-digital-italia' ); ?>">
			<?php if ( $args['button'] ) : ?>
				<button type="submit" class="dci-search-form__btn" aria-label="<?php esc_attr_e( 'Cerca nel sito', 'wp-digital-italia' ); ?>">
					<?php echo dci_icon( 'search', 'icon' ); ?>
				</button>
			<?php endif; ?>
		</div>
	</form>
	<?php
}

/** Modal di ricerca a tutto schermo (versione mobile/tablet). */
function dci_render_search_modal( string $id = 'search-modal' ): void {
	?>
	<div class="modal fade search-modal" id="<?php echo esc_attr( $id ); ?>" tabindex="-1" aria-modal="true" role="dialog" aria-labelledby="<?php echo esc_attr( $id ); ?>-title">
		<div class="modal-dialog modal-fullscreen m-0" role="document">
			<div class="modal-content perfect-scrollbar">
				<div class="modal-body">
					<div class="container">
						<div class="row variable-gutters">
							<div class="col">
								<div class="modal-title">
									<button class="btn btn-link d-md-none d-flex align-items-center px-2 me-2" type="button" data-bs-toggle="modal" data-bs-target="#<?php echo esc_attr( $id ); ?>" aria-label="<?php esc_attr_e( 'Chiudi', 'wp-digital-italia' ); ?>">
										<?php echo dci_icon( 'arrow-left', 'icon icon-sm icon-secondary' ); ?>
									</button>
									<h2 class="mb-0" id="<?php echo esc_attr( $id ); ?>-title"><?php esc_html_e( 'Ricerca', 'wp-digital-italia' ); ?></h2>
									<button class="btn-close search-link d-none d-md-block me-0" type="button" data-bs-toggle="modal" data-bs-target="#<?php echo esc_attr( $id ); ?>" aria-label="<?php esc_attr_e( 'Chiudi', 'wp-digital-italia' ); ?>">
										<?php echo dci_icon( 'close-big', 'icon icon-md icon-secondary' ); ?>
									</button>
								</div>
								<?php get_search_form(); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Struttura navbar Bootstrap Italia usata dalle varianti.
 *
 * @param array<string,mixed> $args Opzioni: id, class, menu_class, depth, label, toggler,
 *                                  secondary (posizione menu secondaria), mobile_brand.
 */
function dci_render_navbar( array $args = array() ): void {
	$args = wp_parse_args(
		$args,
		array(
			'id'           => 'nav1',
			'class'        => '',
			'menu_class'   => '',
			'depth'        => 2,
			'label'        => __( 'Navigazione principale', 'wp-digital-italia' ),
			'toggler'      => true,
			'secondary'    => '',
			'mobile_brand' => false,
		)
	);
	?>
	<nav class="navbar navbar-expand-lg has-megamenu <?php echo esc_attr( $args['class'] ); ?>" aria-label="<?php echo esc_attr( $args['label'] ); ?>">
		<?php if ( $args['toggler'] ) : ?>
			<button class="custom-navbar-toggler" type="button" aria-controls="<?php echo esc_attr( $args['id'] ); ?>" aria-expanded="false" aria-label="<?php esc_attr_e( 'Mostra/Nascondi la navigazione', 'wp-digital-italia' ); ?>" data-bs-toggle="navbarcollapsible" data-bs-target="#<?php echo esc_attr( $args['id'] ); ?>">
				<?php echo dci_icon( 'burger', 'icon bg-override' ); ?>
			</button>
		<?php endif; ?>
		<div class="navbar-collapsable" id="<?php echo esc_attr( $args['id'] ); ?>" style="display: none;">
			<div class="overlay" style="display: none;"></div>
			<div class="close-div">
				<button class="btn close-menu" type="button">
					<span class="visually-hidden"><?php esc_html_e( 'Nascondi la navigazione', 'wp-digital-italia' ); ?></span>
					<?php echo dci_icon( 'close-big', 'icon' ); ?>
				</button>
			</div>
			<div class="menu-wrapper">
				<?php if ( $args['mobile_brand'] ) : ?>
					<div class="it-brand-wrapper d-lg-none">
						<?php dci_render_brand( array( 'tone' => 'light' ) ); ?>
					</div>
				<?php endif; ?>
				<?php
				dci_render_menu(
					'main-menu',
					array(
						'menu_class' => $args['menu_class'],
						'depth'      => (int) $args['depth'],
					)
				);

				if ( $args['secondary'] && dci_has_menu( (string) $args['secondary'] ) ) {
					dci_render_menu(
						(string) $args['secondary'],
						array(
							'menu_class' => 'navbar-secondary',
							'depth'      => 1,
						)
					);
				}
				?>
			</div>
		</div>
	</nav>
	<?php
}

/**
 * Campi aggiuntivi del Customizer usati da header e footer.
 */
add_action(
	'customize_register',
	function ( WP_Customize_Manager $wp_customize ): void {
		$section = 'site_contact';
		if ( ! $wp_customize->get_section( $section ) ) {
			$wp_customize->add_section( $section, array( 'title' => 'Site Contact', 'priority' => 30 ) );
		}

		$fields = array(
			'site_contact_pec'             => array( 'label' => __( 'PEC', 'wp-digital-italia' ), 'sanitize' => 'sanitize_email', 'type' => 'email' ),
			'site_parent_entity_name'      => array( 'label' => __( 'Ente di appartenenza (nome)', 'wp-digital-italia' ), 'sanitize' => 'sanitize_text_field', 'type' => 'text' ),
			'site_parent_entity_url'       => array( 'label' => __( 'Ente di appartenenza (URL)', 'wp-digital-italia' ), 'sanitize' => 'esc_url_raw', 'type' => 'url' ),
			'site_area_personale_label'    => array( 'label' => __( 'Area personale (etichetta)', 'wp-digital-italia' ), 'sanitize' => 'sanitize_text_field', 'type' => 'text' ),
			'site_area_personale_url'      => array( 'label' => __( 'Area personale (URL)', 'wp-digital-italia' ), 'sanitize' => 'esc_url_raw', 'type' => 'url' ),
		);
		foreach ( $fields as $key => $field ) {
			$wp_customize->add_setting( $key, array( 'sanitize_callback' => $field['sanitize'] ) );
			$wp_customize->add_control(
				$key,
				array(
					'label'   => $field['label'],
					'section' => $section,
					'type'    => $field['type'],
				)
			);
		}

		foreach ( array( 'linkedin' => 'LinkedIn', 'youtube' => 'YouTube' ) as $key => $label ) {
			$wp_customize->add_setting( 'site_socials_' . $key, array( 'sanitize_callback' => 'esc_url_raw' ) );
			$wp_customize->add_control(
				'site_socials_' . $key,
				array(
					'label'   => $label,
					'section' => 'site_socials',
					'type'    => 'url',
				)
			);
		}
	}
);
