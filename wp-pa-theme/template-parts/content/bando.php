<?php
/**
 * Riga bando negli elenchi/archivi.
 *
 * @package digital-italia
 */
$id            = get_the_ID();
$tipo          = get_post_meta( $id, '_dci_bando_tipo', true ) ?: __( 'Bando', 'wp-digital-italia' );
$data_publish  = get_post_meta( $id, '_dci_bando_data_publish', true );
$data_scadenza = get_post_meta( $id, '_dci_bando_data_scadenza', true );
$importo       = get_post_meta( $id, '_dci_bando_importo', true );
$cig           = get_post_meta( $id, '_dci_bando_cig', true );
$stato         = dci_bando_stato( $id );
?>
<li id="post-<?php the_ID(); ?>" <?php post_class( 'dci-list__item' ); ?>>
	<h2 class="dci-list__title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
	<?php if ( $stato ) : ?>
		<span class="dci-badge dci-badge--<?php echo esc_attr( $stato ); ?>"><?php echo 'attivo' === $stato ? esc_html__( 'In corso', 'wp-digital-italia' ) : esc_html__( 'Scaduto', 'wp-digital-italia' ); ?></span>
	<?php endif; ?>
	<span class="dci-list__meta">
		<span><?php echo esc_html( $tipo ); ?></span>
		<?php if ( $data_publish ) : ?><span><?php esc_html_e( 'Pubblicato il', 'wp-digital-italia' ); ?> <time datetime="<?php echo esc_attr( $data_publish ); ?>"><?php echo esc_html( date_i18n( 'd/m/Y', strtotime( $data_publish ) ) ); ?></time></span><?php endif; ?>
		<?php if ( $data_scadenza ) : ?><span><?php esc_html_e( 'Scadenza', 'wp-digital-italia' ); ?> <time datetime="<?php echo esc_attr( $data_scadenza ); ?>"><?php echo esc_html( date_i18n( 'd/m/Y', strtotime( $data_scadenza ) ) ); ?></time></span><?php endif; ?>
		<?php if ( $cig ) : ?><span>CIG <?php echo esc_html( $cig ); ?></span><?php endif; ?>
		<?php if ( $importo ) : ?><span><?php esc_html_e( 'Importo', 'wp-digital-italia' ); ?> € <?php echo esc_html( number_format_i18n( (float) $importo ) ); ?></span><?php endif; ?>
	</span>
</li>
