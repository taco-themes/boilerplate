<?php
/**
 * The template for displaying the footer navigation
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

if ( ! has_nav_menu( 'footer' ) ) {
	return;
}

?>
<nav class="footer-navigation site-component" aria-label="<?php esc_attr_e( 'Footer Menu', 'super-awesome-theme' ); ?>">
	<div class="site-component-inner">
		<?php
		wp_nav_menu( array(
			'theme_location' => 'footer',
			'menu_class'     => 'footer-menu',
			'depth'          => 1,
			'container'      => false,
		) );
		?>
	</div>
</nav><!-- .footer-navigation -->
