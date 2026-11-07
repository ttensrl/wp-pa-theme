<?php
/** Accesso rapido: fascia blu a tutta larghezza con tile a icona tonda. */
$org_url = $args['org_url'] ?? '';
$tiles   = array_filter( array(
	array( 'Strutture', 'pa', get_post_type_archive_link( 'dipartimento' ) ),
	array( 'Organigramma', 'user', $org_url ),
	array( 'Bandi e concorsi', 'files', get_post_type_archive_link( 'bando' ) ),
	array( 'Notizie', 'calendar', get_permalink( (int) get_option( 'page_for_posts' ) ) ?: '' ),
	array( 'Persone', 'user', get_post_type_archive_link( 'persona' ) ),
), fn( $t ) => ! empty( $t[2] ) );
?>
<section class="dci-quick" aria-labelledby="quick-title">
	<div class="container-fluid">
		<h2 id="quick-title" class="dci-quick__title"><?php esc_html_e( 'Scopri come fare per', 'wp-digital-italia' ); ?></h2>
		<ul class="dci-quick__list">
			<?php foreach ( $tiles as $t ) : ?>
				<li><a class="dci-quick__tile" href="<?php echo esc_url( $t[2] ); ?>"><span class="dci-quick__icon"><?php echo dci_icon( $t[1], 'icon icon-lg icon-white' ); ?></span><span><?php echo esc_html( $t[0] ); ?></span></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
