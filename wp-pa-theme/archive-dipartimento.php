<?php
/**
 * Archivio strutture: elenco gerarchico con responsabile e contatti.
 *
 * @package digital-italia
 */

get_header();

$top = get_posts( array( 'post_type' => 'dipartimento', 'post_parent' => 0, 'numberposts' => -1, 'orderby' => 'menu_order title', 'order' => 'ASC' ) );
$org = dci_get_template_page_url( 'page-templates/page-organigramma.php' );
?>
<main id="main-content">
	<header class="page-header bg-white mb-4 py-4">
		<div class="container-fluid"><h1 class="mb-2"><?php esc_html_e( 'Strutture', 'wp-digital-italia' ); ?></h1></div>
	</header>
	<div class="container-fluid pb-5">
		<div class="row g-4">
			<aside class="col-lg-3" aria-label="<?php esc_attr_e( 'Indice strutture', 'wp-digital-italia' ); ?>">
				<nav class="dci-sidenav">
					<ul>
						<?php foreach ( $top as $s ) : ?>
							<li><a href="#struttura-<?php echo (int) $s->ID; ?>"><?php echo esc_html( get_the_title( $s ) ); ?></a></li>
						<?php endforeach; ?>
						<?php if ( $org ) : ?><li><a href="<?php echo esc_url( $org ); ?>"><?php esc_html_e( 'Organigramma', 'wp-digital-italia' ); ?></a></li><?php endif; ?>
					</ul>
				</nav>
			</aside>
			<div class="col-lg-9">
				<ul class="dci-list">
					<?php foreach ( $top as $s ) :
						$resp_id  = (int) get_post_meta( $s->ID, '_dci_dipartimento_responsabile', true );
						$tel      = get_post_meta( $s->ID, '_dci_dipartimento_telefono', true );
						$email    = get_post_meta( $s->ID, '_dci_dipartimento_email', true );
						$children = get_posts( array( 'post_type' => 'dipartimento', 'post_parent' => $s->ID, 'numberposts' => -1, 'orderby' => 'menu_order title', 'order' => 'ASC' ) );
						?>
						<li class="dci-list__item" id="struttura-<?php echo (int) $s->ID; ?>">
							<h2 class="dci-list__title"><a href="<?php echo esc_url( get_permalink( $s ) ); ?>"><?php echo esc_html( get_the_title( $s ) ); ?></a></h2>
							<span class="dci-list__meta">
								<?php if ( $resp_id ) : ?><span><?php esc_html_e( 'Responsabile:', 'wp-digital-italia' ); ?> <?php echo esc_html( dci_persona_nome( $resp_id ) ); ?></span><?php endif; ?>
								<?php if ( $tel ) : ?><span><?php echo esc_html( $tel ); ?></span><?php endif; ?>
								<?php if ( $email ) : ?><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a><?php endif; ?>
							</span>
							<?php if ( $children ) : ?>
								<ul class="dci-list__meta list-unstyled">
									<?php foreach ( $children as $c ) : ?><li><a href="<?php echo esc_url( get_permalink( $c ) ); ?>"><?php echo esc_html( get_the_title( $c ) ); ?></a></li><?php endforeach; ?>
								</ul>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
</main>
<?php
get_footer();
