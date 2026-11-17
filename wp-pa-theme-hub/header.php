<?php
/** Header minimale dell'hub. */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'hub' ); ?>>
<?php wp_body_open(); ?>
<a class="visually-hidden-focusable hub-skip" href="#contenuto"><?php esc_html_e( 'Vai al contenuto', 'wp-pa-theme-hub' ); ?></a>
<header class="hub-header">
	<div class="hub-container hub-header__in">
		<a class="hub-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><span class="hub-brand__mark" aria-hidden="true">+</span> Digital Italia <span class="hub-brand__sub">per la PA</span></a>
		<nav aria-label="<?php esc_attr_e( 'Demo', 'wp-pa-theme-hub' ); ?>">
			<ul class="hub-nav">
				<li><a href="<?php echo esc_url( home_url( '/#demo' ) ); ?>">Demo</a></li>
				<li><a href="<?php echo esc_url( home_url( '/#funzioni' ) ); ?>">Funzioni</a></li>
				<li><a href="<?php echo esc_url( home_url( '/#architettura' ) ); ?>">Architettura</a></li>
				<li><a href="<?php echo esc_url( home_url( '/spid-cie/' ) ); ?>"<?php echo is_page( 'spid-cie' ) ? ' aria-current="page"' : ''; ?>>Plugin SPID/CIE</a></li>
			</ul>
		</nav>
	</div>
</header>
