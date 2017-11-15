<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Super_Awesome_Theme
 * @license GPL-3.0
 * @link    https://www.taco-themes.com/themes/super-awesome-theme/
 */

get_header();

?>

	<main id="main" class="site-main">

		<header class="page-header">
			<h1><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'super-awesome-theme' ); ?></h1>
		</header><!-- .page-header -->

		<div class="404-content">
			<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'super-awesome-theme' ); ?></p>

			<?php get_search_form(); ?>

			<div class="widget widget_categories">
				<h2 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'super-awesome-theme' ); ?></h2>
				<ul>
				<?php
					wp_list_categories( array(
						'orderby'    => 'count',
						'order'      => 'DESC',
						'show_count' => 1,
						'title_li'   => '',
						'number'     => 10,
					) );
				?>
				</ul>
			</div><!-- .widget -->

		</div><!-- .404-content -->

	</main><!-- #main -->

<?php

get_sidebar();
get_footer();
