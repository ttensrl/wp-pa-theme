<?php
/**
 * Sidebar sinistra a box colorati (stile portale sanitario).
 * Box: navigazione di sezione, contatti, "Scopri come fare per", guida ai servizi, strutture, widget.
 *
 * @package digital-italia
 */

[ $nav_title, $nav_items ] = dci_sidebar_nav();
$phone       = get_theme_mod( 'site_contact_phone' );
$hours       = array_filter( array_map( 'trim', explode( "\n", (string) get_theme_mod( 'dci_sidebar_hours', '' ) ) ) );
$contact_ttl = get_theme_mod( 'dci_sidebar_contact_title' ) ?: __( 'Contattaci', 'wp-digital-italia' );
$tiles       = dci_quick_links();
$servizi     = get_posts( array( 'post_type' => 'servizio', 'numberposts' => 20, 'orderby' => 'title', 'order' => 'ASC' ) );
$strutture   = get_posts( array( 'post_type' => 'dipartimento', 'post_parent' => 0, 'numberposts' => 20, 'orderby' => 'menu_order title', 'order' => 'ASC' ) );
?>
<aside id="secondary" class="dci-sidebar" aria-label="<?php esc_attr_e( 'Menu laterale', 'wp-digital-italia' ); ?>">

	<?php if ( $nav_items ) : ?>
		<nav class="dci-box dci-box--nav" aria-labelledby="sb-nav-title">
			<h2 id="sb-nav-title" class="dci-box__title"><?php echo esc_html( $nav_title ); ?></h2>
			<ul class="dci-box__links">
				<?php foreach ( $nav_items as [ $label, $url, $current ] ) : ?>
					<li<?php echo $current ? ' class="is-current"' : ''; ?>><a href="<?php echo esc_url( $url ); ?>"<?php echo $current ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $label ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</nav>
	<?php endif; ?>

	<?php if ( $phone ) : ?>
		<section class="dci-box dci-box--contact" aria-labelledby="sb-contact-title">
			<h2 id="sb-contact-title" class="dci-box__title"><?php echo esc_html( $contact_ttl ); ?></h2>
			<p class="dci-box__phone"><?php echo dci_icon( 'telephone', 'icon icon-lg icon-white' ); ?> <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></p>
			<?php if ( $hours ) : ?>
				<ul class="dci-box__hours">
					<?php foreach ( $hours as $h ) : ?><li><?php echo esc_html( $h ); ?></li><?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</section>
	<?php endif; ?>

	<?php if ( $tiles ) : ?>
		<section class="dci-box dci-box--tiles" aria-labelledby="sb-tiles-title">
			<h2 id="sb-tiles-title" class="dci-box__title"><?php esc_html_e( 'Scopri come fare per', 'wp-digital-italia' ); ?></h2>
			<ul class="dci-box__tiles">
				<?php foreach ( $tiles as [ $label, $icon, $url ] ) : ?>
					<li><a href="<?php echo esc_url( $url ); ?>"><?php echo dci_icon( $icon, 'icon icon-lg icon-white' ); ?><span><?php echo esc_html( $label ); ?></span></a></li>
				<?php endforeach; ?>
			</ul>
		</section>
	<?php endif; ?>

	<?php
	$accordions = array(
		'servizi'   => array( __( 'Guida ai servizi', 'wp-digital-italia' ), $servizi, 'dci-box--acc-1' ),
		'strutture' => array( __( 'Strutture', 'wp-digital-italia' ), $strutture, 'dci-box--acc-2' ),
	);
	foreach ( $accordions as $key => [ $label, $posts, $cls ] ) :
		if ( ! $posts ) { continue; }
		?>
		<section class="dci-box dci-box--acc <?php echo esc_attr( $cls ); ?>">
			<h2 class="dci-box__title dci-box__title--acc">
				<button class="dci-box__toggle collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sb-acc-<?php echo esc_attr( $key ); ?>" aria-expanded="false" aria-controls="sb-acc-<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?><?php echo dci_icon( 'expand', 'icon icon-sm dci-box__chev' ); ?></button>
			</h2>
			<div id="sb-acc-<?php echo esc_attr( $key ); ?>" class="collapse">
				<ul class="dci-box__links">
					<?php foreach ( $posts as $p ) : ?><li><a href="<?php echo esc_url( get_permalink( $p ) ); ?>"><?php echo esc_html( get_the_title( $p ) ); ?></a></li><?php endforeach; ?>
				</ul>
			</div>
		</section>
	<?php endforeach; ?>

	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
		<div class="dci-box dci-box--widgets"><?php dynamic_sidebar( 'sidebar-1' ); ?></div>
	<?php endif; ?>
</aside><!-- #secondary -->
