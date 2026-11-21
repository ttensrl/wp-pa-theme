<?php
/**
 * Footer del profilo Scuola (modello Design Scuole): marchio, quattro colonne di link,
 * link legali con "Seguici su", dati dell'istituto e credito a Designers Italia.
 *
 * @package digital-italia
 */
$parts   = dci_brand_parts();
$logo    = scuola_logo_url();
$address = dci_address_line( ' - ' );
$phone   = dci_mod( 'site_contact_phone' );
$email   = dci_contact_email();
$pec     = dci_contact_pec();
$mecc    = dci_mod( 'scuola_codice_meccanografico' );
$ipa     = dci_mod( 'scuola_ipa' );
$cf      = dci_mod( 'site_contact_vat' );
$cuf     = dci_mod( 'scuola_cuf' );
$news    = (int) get_option( 'page_for_posts' );
$privacy = get_page_by_path( 'privacy' );
$access  = get_page_by_path( 'accessibilita' );
$trasp   = dci_mod( 'site_contact_administration_transparent' );
$albo    = get_post_type_archive_link( 'bando' );
$about   = scuola_page_url( 'chi-siamo' );
$org     = scuola_page_url( 'organigramma' );

$cols = apply_filters( 'scuola_footer_columns', array(
	__( 'Collegamenti esterni', 'wp-digital-italia' ) => array(
		array( __( 'Ministero dell\'Istruzione e del Merito', 'wp-digital-italia' ), 'https://www.mim.gov.it/' ),
		array( __( 'Scuola in Chiaro', 'wp-digital-italia' ), 'https://cercalatuascuola.istruzione.it/' ),
		array( __( 'Iscrizioni On Line', 'wp-digital-italia' ), 'https://www.istruzione.it/iscrizionionline/' ),
		array( __( 'Pago in Rete', 'wp-digital-italia' ), 'https://www.istruzione.it/pagoinrete/' ),
		array( __( 'Invalsi', 'wp-digital-italia' ), 'https://www.invalsi.it/' ),
		array( __( 'Erasmus+', 'wp-digital-italia' ), 'https://erasmus-plus.ec.europa.eu/it' ),
	),
	__( 'Scuola', 'wp-digital-italia' ) => array(
		array( __( 'Presentazione', 'wp-digital-italia' ), $about ),
		array( __( 'Organizzazione', 'wp-digital-italia' ), $org ),
		array( __( 'Le strutture', 'wp-digital-italia' ), get_post_type_archive_link( 'dipartimento' ) ),
		array( __( 'Le persone', 'wp-digital-italia' ), get_post_type_archive_link( 'persona' ) ),
	),
	__( 'Servizi', 'wp-digital-italia' ) => array(
		array( __( 'Servizi della scuola', 'wp-digital-italia' ), home_url( '/#servizi' ) ),
		array( __( 'Famiglie e studenti', 'wp-digital-italia' ), home_url( '/#servizi' ) ),
		array( __( 'Personale scolastico', 'wp-digital-italia' ), home_url( '/#servizi' ) ),
	),
	__( 'Novità', 'wp-digital-italia' ) => array(
		array( __( 'Le notizie', 'wp-digital-italia' ), $news ? get_permalink( $news ) : home_url( '/' ) ),
		array( __( 'Albo online', 'wp-digital-italia' ), $albo ),
		array( __( 'Offerta formativa', 'wp-digital-italia' ), home_url( '/#didattica' ) ),
	),
) );
$legal = array_filter( array(
	array( __( 'Note legali', 'wp-digital-italia' ), $privacy ? get_permalink( $privacy ) : '' ),
	array( __( 'Amministrazione Trasparente', 'wp-digital-italia' ), $trasp ?: $albo ),
	array( __( 'Albo online', 'wp-digital-italia' ), $albo ),
	array( __( 'Privacy Policy', 'wp-digital-italia' ), $privacy ? get_permalink( $privacy ) : '' ),
	array( __( 'Dichiarazione di accessibilità', 'wp-digital-italia' ), $access ? get_permalink( $access ) : '' ),
), fn( $l ) => ! empty( $l[1] ) );
?>
<footer class="it-footer sc-footer" id="footer-wrapper">
	<div class="container">
		<a class="sc-footer__brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<?php if ( $logo ) : ?><img src="<?php echo esc_url( $logo ); ?>" alt="" width="64" height="72"><?php endif; ?>
			<span>
				<?php if ( $parts['prefix'] ) : ?><span><?php echo esc_html( $parts['prefix'] ); ?></span><?php endif; ?>
				<strong><?php echo esc_html( $parts['name'] ); ?></strong>
				<?php if ( get_bloginfo( 'description' ) ) : ?><span><?php bloginfo( 'description' ); ?></span><?php endif; ?>
			</span>
		</a>

		<div class="row g-4 sc-footer__cols">
			<?php foreach ( $cols as $title => $links ) : ?>
				<div class="col-sm-6 col-lg-3">
					<h2 class="sc-footer__title"><?php echo esc_html( $title ); ?></h2>
					<ul class="sc-footer__list">
						<?php foreach ( $links as [ $label, $url ] ) : ?>
							<?php if ( $url ) : ?><li><a href="<?php echo esc_url( $url ); ?>"<?php echo 0 === strpos( $url, 'http' ) && false === strpos( $url, home_url() ) ? ' target="_blank" rel="noopener"' : ''; ?>><?php echo esc_html( $label ); ?></a></li><?php endif; ?>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endforeach; ?>
		</div>

		<div class="sc-footer__legal">
			<ul>
				<?php foreach ( $legal as [ $label, $url ] ) : ?>
					<li><a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $label ); ?></a></li>
				<?php endforeach; ?>
			</ul>
			<?php dci_render_socials( array( 'label' => __( 'Seguici su:', 'wp-digital-italia' ), 'class' => 'sc-footer__socials', 'icon_class' => 'icon icon-white' ) ); ?>
		</div>

		<div class="sc-footer__info">
			<p>
				<?php
				$line1 = array_filter( array(
					$address,
					$phone ? sprintf( /* translators: %s: telefono */ __( 'Telefono: %s', 'wp-digital-italia' ), $phone ) : '',
					$email ? sprintf( /* translators: %s: email */ __( 'Email: %s', 'wp-digital-italia' ), $email ) : '',
					$pec ? sprintf( /* translators: %s: PEC */ __( 'Posta elettronica certificata (PEC): %s', 'wp-digital-italia' ), $pec ) : '',
				) );
				echo esc_html( implode( ' - ', $line1 ) );
				?>
			</p>
			<p>
				<?php
				$line2 = array_filter( array(
					$mecc ? sprintf( /* translators: %s: codice */ __( 'Codice meccanografico: %s', 'wp-digital-italia' ), $mecc ) : '',
					$ipa ? sprintf( /* translators: %s: codice IPA */ __( 'Codice Indice delle Pubbliche Amministrazioni (IPA): %s', 'wp-digital-italia' ), $ipa ) : '',
					$cf ? sprintf( /* translators: %s: codice fiscale */ __( 'Codice fiscale: %s', 'wp-digital-italia' ), $cf ) : '',
					$cuf ? sprintf( /* translators: %s: codice CUF */ __( 'Codice univoco fatturazione elettronica (CUF): %s', 'wp-digital-italia' ), $cuf ) : '',
				) );
				echo esc_html( implode( ' - ', $line2 ) );
				?>
			</p>
		</div>

		<p class="sc-footer__credit"><a href="https://designers.italia.it/" target="_blank" rel="noopener"><?php esc_html_e( 'Idea e progetto di Designers Italia', 'wp-digital-italia' ); ?></a></p>
	</div>
</footer>
