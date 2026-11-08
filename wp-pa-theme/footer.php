<?php
/**
 * The template for displaying the footer
 *
 * Lo scheletro resta nel parent; il contenuto del footer dipende dalla
 * variante scelta dal child theme (filtro dci_footer_variant) e vive in
 * template-parts/footer/site-{variante}.php.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package digital-italia
 */

get_template_part( 'template-parts/footer/site', dci_footer_variant() );
?>

<a href="#" aria-hidden="true" tabindex="-1" data-attribute="back-to-top" class="back-to-top">
	<svg class="icon icon-light">
		<use xlink:href="<?php echo esc_url( get_template_directory_uri() ); ?>/dist/images/sprites.svg#it-arrow-up"></use>
	</svg>
</a>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
