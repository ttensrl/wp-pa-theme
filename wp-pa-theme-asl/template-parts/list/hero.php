<?php
/**
 * Breadcrumb + hero delle pagine lista (prototipo AGID).
 *
 * @param array $args { title, lead, crumbs: [ [label, url], ... ] }
 * @package digital-italia
 */
$title = $args['title'] ?? '';
$lead  = $args['lead'] ?? '';
$crumbs = $args['crumbs'] ?? array();
?>
<div class="asl-list-head">
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
		<h1 class="asl-list-head__title"><?php echo esc_html( $title ); ?></h1>
		<?php if ( $lead ) : ?><p class="asl-list-head__lead"><?php echo esc_html( $lead ); ?></p><?php endif; ?>
	</div>
</div>
