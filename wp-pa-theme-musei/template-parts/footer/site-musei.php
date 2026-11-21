<?php
/**
 * Footer del profilo Musei: scheda di valutazione e footer a colonne su fondo slate.
 *
 * @package digital-italia
 */
$address = dci_mod( 'site_contact_address' );
$phone   = dci_mod( 'site_contact_phone' );
$vat     = dci_mod( 'site_contact_vat' );
$cols    = apply_filters( 'musei_footer_columns', array(
	__( 'Menù principale', 'wp-digital-italia-musei' ) => array(
		array( __( 'Organizza la visita', 'wp-digital-italia-musei' ), home_url( '/#orari' ) ),
		array( __( 'Esplora il Museo', 'wp-digital-italia-musei' ), get_post_type_archive_link( 'sede' ) ),
		array( __( 'Mostre ed eventi', 'wp-digital-italia-musei' ), get_post_type_archive_link( 'mostra' ) ),
		array( __( 'Educazione e ricerca', 'wp-digital-italia-musei' ), '#' ),
	),
	__( 'Organizzazione', 'wp-digital-italia-musei' ) => array(
		array( __( 'Statuto', 'wp-digital-italia-musei' ), '#' ),
		array( __( 'Dirigenti e personale', 'wp-digital-italia-musei' ), '#' ),
		array( __( 'Uffici', 'wp-digital-italia-musei' ), '#' ),
		array( __( 'Supporta il museo', 'wp-digital-italia-musei' ), home_url( '/#supporta' ) ),
		array( __( 'Lavora con noi', 'wp-digital-italia-musei' ), '#' ),
	),
	__( 'Trasparenza', 'wp-digital-italia-musei' ) => array(
		array( __( 'Amministrazione trasparente', 'wp-digital-italia-musei' ), '#' ),
		array( __( 'Regolamento del museo', 'wp-digital-italia-musei' ), '#' ),
		array( __( 'Bandi e gare', 'wp-digital-italia-musei' ), '#' ),
		array( __( 'Bilanci', 'wp-digital-italia-musei' ), '#' ),
		array( __( 'Beni, immobili e patrimoni', 'wp-digital-italia-musei' ), '#' ),
	),
) );
?>
<section class="mu-rating" aria-labelledby="mu-rating-title">
	<div class="container">
		<h2 id="mu-rating-title"><?php esc_html_e( 'Quanto sono chiare le informazioni su questa pagina?', 'wp-digital-italia-musei' ); ?></h2>
		<ul class="mu-rating__stars">
			<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
				<li><button type="button" aria-label="<?php echo esc_attr( sprintf( _n( '%d stella su 5', '%d stelle su 5', $i, 'wp-digital-italia-musei' ), $i ) ); ?>"><span aria-hidden="true">&#9733;</span></button></li>
			<?php endfor; ?>
		</ul>
	</div>
</section>

<footer class="it-footer mu-footer">
	<div class="container">
		<div class="mu-footer__brand">
			<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/museo.svg' ); ?>" alt="" width="40" height="36" class="mu-footer__logo">
			<span><?php bloginfo( 'name' ); ?></span>
		</div>

		<div class="row g-4 mu-footer__cols">
			<?php foreach ( $cols as $title => $links ) : ?>
				<div class="col-md-4">
					<h2 class="mu-footer__title"><?php echo esc_html( $title ); ?></h2>
					<ul class="mu-footer__list">
						<?php foreach ( $links as [ $label, $url ] ) : ?>
							<li><a href="<?php echo esc_url( $url ?: '#' ); ?>"><?php echo esc_html( $label ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endforeach; ?>
			<div class="col-md-4">
				<h2 class="mu-footer__title"><?php esc_html_e( 'Contatti dell\'ente', 'wp-digital-italia-musei' ); ?></h2>
				<ul class="mu-footer__list mu-footer__list--plain">
					<?php if ( $address ) : ?><li><?php echo esc_html( $address ); ?></li><?php endif; ?>
					<?php if ( $phone ) : ?><li><?php echo esc_html( sprintf( /* translators: %s: numero */ __( 'Centralino %s', 'wp-digital-italia-musei' ), $phone ) ); ?></li><?php endif; ?>
					<?php if ( $vat ) : ?><li><?php echo esc_html( sprintf( /* translators: %s: partita IVA */ __( 'P.IVA %s', 'wp-digital-italia-musei' ), $vat ) ); ?></li><?php endif; ?>
					<li><a href="#"><?php esc_html_e( 'Feedback e segnalazioni', 'wp-digital-italia-musei' ); ?></a></li>
					<li><a href="#"><?php esc_html_e( 'Stampa', 'wp-digital-italia-musei' ); ?></a></li>
					<li><a href="#"><?php esc_html_e( 'FAQ', 'wp-digital-italia-musei' ); ?></a></li>
				</ul>
			</div>
			<div class="col-md-4">
				<h2 class="mu-footer__title"><?php esc_html_e( 'Seguici su', 'wp-digital-italia-musei' ); ?></h2>
				<?php dci_render_socials( array( 'label' => '', 'class' => 'mu-footer__socials', 'icon_class' => 'icon icon-white' ) ); ?>
			</div>
		</div>

		<ul class="mu-footer__bottom">
			<?php
			$bottom = dci_footer_utility_links() ?: array(
				array( 'label' => __( 'Dichiarazione di accessibilità', 'wp-digital-italia-musei' ), 'url' => '#' ),
				array( 'label' => __( 'Privacy & cookie policy', 'wp-digital-italia-musei' ), 'url' => '#' ),
				array( 'label' => __( 'Note legali', 'wp-digital-italia-musei' ), 'url' => '#' ),
				array( 'label' => __( 'Carta dei servizi', 'wp-digital-italia-musei' ), 'url' => '#' ),
				array( 'label' => __( 'Mappa del sito', 'wp-digital-italia-musei' ), 'url' => '#' ),
			);
			foreach ( $bottom as $link ) :
			?>
				<li><a href="<?php echo esc_url( $link['url'] ); ?>"><?php echo esc_html( $link['label'] ); ?></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
</footer>
