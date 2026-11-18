<?php
/**
 * Testata delle pagine di dettaglio: breadcrumb, titolo, sottotitolo, "Condividi", etichette.
 *
 * @param array $args { crumbs: [ [label, url], ... ], title, lead, badge, badge_text }
 * @package digital-italia
 */
$crumbs = $args['crumbs'] ?? array();
$title  = $args['title'] ?? get_the_title();
$lead   = $args['lead'] ?? '';
$badge  = $args['badge'] ?? '';
$note   = $args['badge_text'] ?? '';
$bare   = ! empty( $args['no_rule'] );
?>
<div class="asl-detail-head<?php echo $bare ? ' is-bare' : ''; ?>">
	<div class="container">
		<nav class="asl-breadcrumb" aria-label="<?php esc_attr_e( 'Percorso di navigazione', 'wp-digital-italia-asl' ); ?>">
			<ol>
				<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'wp-digital-italia-asl' ); ?></a></li>
				<?php foreach ( $crumbs as [ $label, $url ] ) : ?>
					<li><a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $label ); ?></a></li>
				<?php endforeach; ?>
				<li aria-current="page"><?php echo esc_html( $title ); ?></li>
			</ol>
		</nav>
		<div class="asl-detail-head__row">
			<h1 class="asl-detail-head__title"><?php echo esc_html( $title ); ?></h1>
			<button type="button" class="asl-share" data-asl-share data-copied="<?php esc_attr_e( 'Link copiato', 'wp-digital-italia-asl' ); ?>">
				<svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true"><circle cx="6" cy="12" r="2.5" fill="none" stroke="currentColor" stroke-width="1.4"/><circle cx="18" cy="5.5" r="2.5" fill="none" stroke="currentColor" stroke-width="1.4"/><circle cx="18" cy="18.5" r="2.5" fill="none" stroke="currentColor" stroke-width="1.4"/><path d="M8.2 10.8l7.6-4M8.2 13.2l7.6 4" stroke="currentColor" stroke-width="1.4"/></svg>
				<span><?php esc_html_e( 'Condividi', 'wp-digital-italia-asl' ); ?></span>
			</button>
		</div>
		<?php if ( $lead ) : ?><p class="asl-detail-head__lead"><?php echo esc_html( $lead ); ?></p><?php endif; ?>
		<?php if ( $badge ) : ?>
			<p class="asl-detail-head__status"><span class="asl-badge"><?php echo esc_html( $badge ); ?></span><?php echo $note ? ' ' . esc_html( $note ) : ''; ?></p>
		<?php endif; ?>
	</div>
</div>
