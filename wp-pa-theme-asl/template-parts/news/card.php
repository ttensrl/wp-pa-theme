<?php
/**
 * Card notizia (prototipo AGID "Card / News"): immagine, titolo, estratto, categoria e data.
 * Da usare dentro un loop.
 *
 * @param array $args { variant: 0-2, words }
 * @package digital-italia
 */
$variant = (int) ( $args['variant'] ?? 0 ) % 3;
$words   = (int) ( $args['words'] ?? 22 );
$img     = dci_post_image_url();
$cat     = array_values( array_filter( get_the_category(), fn( $c ) => (int) $c->term_id !== (int) get_option( 'default_category' ) ) );
$is_post = 'post' === get_post_type();
$type    = get_post_type_object( get_post_type() );
$label   = $is_post
	? ( $cat ? $cat[0]->name : __( 'Notizia', 'wp-digital-italia-asl' ) )
	: ( $type ? $type->labels->singular_name : '' );
?>
<article class="asl-news">
	<a class="asl-news__media<?php echo $img ? '' : ' is-placeholder is-v' . $variant; ?>" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
		<?php if ( $img ) : ?><img src="<?php echo esc_url( $img ); ?>" alt="" loading="lazy"><?php endif; ?>
	</a>
	<div class="asl-news__body">
		<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), $words ) ); ?></p>
		<div class="asl-news__meta">
			<span class="asl-tag"><?php echo esc_html( $label ); ?></span>
			<?php if ( $is_post ) : ?><time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date( 'j F Y' ) ); ?></time><?php endif; ?>
		</div>
	</div>
</article>
