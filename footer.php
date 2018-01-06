<?php
/**
 * The template for displaying the footer
 *
 * @package Super_Awesome_Theme
 * @license GPL-3.0
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

?>

	<footer id="footer" class="site-footer">
		<?php get_template_part( 'template-parts/footer/footer-widgets' ); ?>

		<?php get_template_part( 'template-parts/footer/social-navigation' ); ?>

		<?php get_template_part( 'template-parts/footer/footer-navigation' ); ?>

		<?php get_template_part( 'template-parts/footer/site-info' ); ?>
	</footer><!-- #footer -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
