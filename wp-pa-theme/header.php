<?php
/**
 * The header for our theme
 *
 * Scheletro comune a tutti gli enti: head, skip link, cookie bar e apertura
 * di #page. L'header vero e proprio dipende dalla variante scelta dal child
 * theme (filtro dci_header_variant) e vive in
 * template-parts/header/site-{variante}.php.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package digital-italia
 */
?>
<!doctype html>
<html lang="<?php language_attributes(); ?>">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php get_template_part( 'template-parts/common/skiplink' ); ?>
<?php get_template_part( 'template-parts/cookie-bar' ); ?>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<?php get_template_part( 'template-parts/header/site', dci_header_variant() ); ?>
	<?php get_template_part( 'template-parts/common/breadcrumb' ); ?>
