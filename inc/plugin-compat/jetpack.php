<?php
/**
 * Jetpack compatibility functions
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Registers support for various Jetpack features.
 *
 * @since 1.0.0
 */
function super_awesome_theme_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'render'    => 'super_awesome_theme_infinite_scroll_render',
		'footer'    => 'page',
	) );

	add_theme_support( 'jetpack-responsive-videos' );
}
add_action( 'after_setup_theme', 'super_awesome_theme_jetpack_setup' );

/**
 * Renders Jetpack infinite scroll content.
 *
 * @since 1.0.0
 */
function super_awesome_theme_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		if ( is_search() ) :
			get_template_part( 'template-parts/content', 'search' );
		else :
			if ( super_awesome_theme_use_post_format_templates() ) :
				get_template_part( 'template-parts/content/content-' . get_post_type(), get_post_format() );
			else :
				get_template_part( 'template-parts/content/content', get_post_type() );
			endif;
		endif;
	}
}
