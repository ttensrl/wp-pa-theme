<?php
/**
 * Card news con immagine (o placeholder generato dal colore primario), data, titolo ed estratto.
 * Va usata dentro un loop: args['variant'] 0-2 sceglie la forma del placeholder.
 */
$variant = (int) ( $args['variant'] ?? 0 ) % 3;
$img     = dci_post_image_url();
$cat     = array_values( array_filter( get_the_category(), fn( $c ) => (int) $c->term_id !== (int) get_option( 'default_category' ) ) );
?>
<article class="dci-newscard">
	<a class="dci-newscard__media<?php echo $img ? '' : ' dci-ph dci-ph--v' . $variant; ?>" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
		<?php if ( $img ) : ?><img src="<?php echo esc_url( $img ); ?>" alt="" loading="lazy"><?php endif; ?>
	</a>
	<div class="dci-newscard__body">
		<p class="dci-newscard__meta"><?php echo dci_icon( 'file', 'icon icon-sm' ); ?><span><?php echo $cat ? esc_html( $cat[0]->name ) . ' &middot; ' : ''; ?><time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( dci_short_date() ); ?></time></span></p>
		<h3 class="dci-newscard__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<p class="dci-newscard__text"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24 ) ); ?></p>
	</div>
</article>
