<?php
/**
 * Customizer functions
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Registers Customizer functionality.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function super_awesome_theme_customize_register( $wp_customize ) {

	/* Core Adjustments */

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector'        => '.site-title a',
		'render_callback' => 'super_awesome_theme_customize_partial_blogname',
	) );
	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector'        => '.site-description',
		'render_callback' => 'super_awesome_theme_customize_partial_blogdescription',
	) );

	/* Colors */

	$wp_customize->add_setting( 'text_color', array(
		'default'              => '#404040',
		'transport'            => 'postMessage',
		'sanitize_callback'    => 'maybe_hash_hex_color',
		'sanitize_js_callback' => 'maybe_hash_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'text_color', array(
		'section' => 'colors',
		'label'   => __( 'Text Color', 'super-awesome-theme' ),
	) ) );

	$wp_customize->add_setting( 'link_color', array(
		'default'              => '#21759b',
		'transport'            => 'postMessage',
		'sanitize_callback'    => 'maybe_hash_hex_color',
		'sanitize_js_callback' => 'maybe_hash_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_color', array(
		'section' => 'colors',
		'label'   => __( 'Link Color', 'super-awesome-theme' ),
	) ) );

	$wp_customize->add_setting( 'wrap_background_color', array(
		'default'              => '',
		'transport'            => 'postMessage',
		'sanitize_callback'    => 'maybe_hash_hex_color',
		'sanitize_js_callback' => 'maybe_hash_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'wrap_background_color', array(
		'section'         => 'colors',
		'label'           => __( 'Wrap Background Color', 'super-awesome-theme' ),
		'active_callback' => 'super_awesome_theme_use_wrapped_layout',
	) ) );

	$wp_customize->add_setting( 'button_text_color', array(
		'default'              => '#404040',
		'transport'            => 'postMessage',
		'sanitize_callback'    => 'maybe_hash_hex_color',
		'sanitize_js_callback' => 'maybe_hash_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'button_text_color', array(
		'section' => 'colors',
		'label'   => __( 'Button Text Color', 'super-awesome-theme' ),
	) ) );

	$wp_customize->add_setting( 'button_background_color', array(
		'default'              => '#e6e6e6',
		'transport'            => 'postMessage',
		'sanitize_callback'    => 'maybe_hash_hex_color',
		'sanitize_js_callback' => 'maybe_hash_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'button_background_color', array(
		'section' => 'colors',
		'label'   => __( 'Button Background Color', 'super-awesome-theme' ),
	) ) );

	$wp_customize->add_setting( 'button_primary_text_color', array(
		'default'              => '#ffffff',
		'transport'            => 'postMessage',
		'sanitize_callback'    => 'maybe_hash_hex_color',
		'sanitize_js_callback' => 'maybe_hash_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'button_primary_text_color', array(
		'section' => 'colors',
		'label'   => __( 'Primary Button Text Color', 'super-awesome-theme' ),
	) ) );

	$wp_customize->add_setting( 'button_primary_background_color', array(
		'default'              => '#21759b',
		'transport'            => 'postMessage',
		'sanitize_callback'    => 'maybe_hash_hex_color',
		'sanitize_js_callback' => 'maybe_hash_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'button_primary_background_color', array(
		'section' => 'colors',
		'label'   => __( 'Primary Button Background Color', 'super-awesome-theme' ),
	) ) );

	/* Sidebar Settings */

	$wp_customize->add_section( 'sidebars', array(
		'title'           => __( 'Sidebars', 'super-awesome-theme' ),
		'priority'        => 105,
		'active_callback' => 'super_awesome_theme_allow_display_sidebar',
	) );

	$wp_customize->add_setting( 'sidebar_mode', array(
		'default'           => 'right-sidebar',
		'transport'         => 'postMessage',
		'validate_callback' => 'super_awesome_theme_customize_validate_sidebar_mode',
	) );
	$wp_customize->add_control( 'sidebar_mode', array(
		'section'     => 'sidebars',
		'label'       => __( 'Sidebar Mode', 'super-awesome-theme' ),
		'description' => __( 'Specify if and how the sidebar should be displayed.', 'super-awesome-theme' ),
		'type'        => 'radio',
		'choices'     => super_awesome_theme_customize_get_sidebar_mode_choices(),
	) );

	$wp_customize->add_setting( 'sidebar_size', array(
		'default'           => 'medium',
		'transport'         => 'postMessage',
		'validate_callback' => 'super_awesome_theme_customize_validate_sidebar_size',
	) );
	$wp_customize->add_control( 'sidebar_size', array(
		'section'     => 'sidebars',
		'label'       => __( 'Sidebar Size', 'super-awesome-theme' ),
		'description' => __( 'Specify the width of the sidebar.', 'super-awesome-theme' ),
		'type'        => 'radio',
		'choices'     => super_awesome_theme_customize_get_sidebar_size_choices(),
	) );

	$wp_customize->add_setting( 'blog_sidebar_enabled', array(
		'default'           => '',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'blog_sidebar_enabled', array(
		'section'         => 'sidebars',
		'label'           => __( 'Enable Blog Sidebar?', 'super-awesome-theme' ),
		'description'     => __( 'If you enable the blog sidebar, it will be shown beside your blog and single post content instead of the primary sidebar.', 'super-awesome-theme' ),
		'type'            => 'checkbox',
		'active_callback' => 'super_awesome_theme_allow_display_blog_sidebar',
	) );
	$wp_customize->selective_refresh->add_partial( 'blog_sidebar_enabled', array(
		'selector'            => '#sidebar',
		'render_callback'     => 'get_sidebar',
		'container_inclusive' => true,
	) );

	/* Content Type Settings */

	$wp_customize->add_panel( 'content_types', array(
		'title'    => __( 'Content Types', 'super-awesome-theme' ),
		'priority' => 140,
	) );

	$public_post_types = get_post_types( array( 'public' => true ), 'objects' );
	foreach ( $public_post_types as $post_type ) {
		$wp_customize->add_section( 'content_type_' . $post_type->name, array(
			'panel'    => 'content_types',
			'title'    => $post_type->label,
		) );

		$wp_customize->add_setting( $post_type->name . '_show_date', array(
			'default'           => in_array( $post_type->name, array( 'post', 'attachment' ), true ) ? '1' : '',
			'transport'         => 'postMessage',
		) );
		$wp_customize->add_control( $post_type->name . '_show_date', array(
			'section' => 'content_type_' . $post_type->name,
			'label'   => __( 'Show Date?', 'super-awesome-theme' ),
			'type'    => 'checkbox',
		) );
		$wp_customize->selective_refresh->add_partial( $post_type->name . '_show_date', array(
			'selector'            => '.type-' . $post_type->name . ' .entry-meta',
			'render_callback'     => 'super_awesome_theme_customize_partial_entry_meta',
			'container_inclusive' => true,
			'type'                => 'SuperAwesomeThemePostPartial',
		) );

		if ( post_type_supports( $post_type->name, 'author' ) ) {
			$wp_customize->add_setting( $post_type->name . '_show_author', array(
				'default'           => in_array( $post_type->name, array( 'post', 'attachment' ), true ) ? '1' : '',
				'transport'         => 'postMessage',
			) );
			$wp_customize->add_control( $post_type->name . '_show_author', array(
				'section' => 'content_type_' . $post_type->name,
				'label'   => __( 'Show Author Name?', 'super-awesome-theme' ),
				'type'    => 'checkbox',
			) );
			$wp_customize->selective_refresh->add_partial( $post_type->name . '_show_author', array(
				'selector'            => '.type-' . $post_type->name . ' .entry-meta',
				'render_callback'     => 'super_awesome_theme_customize_partial_entry_meta',
				'container_inclusive' => true,
				'type'                => 'SuperAwesomeThemePostPartial',
			) );
		}

		if ( 'attachment' === $post_type->name ) {
			foreach ( super_awesome_theme_get_attachment_metadata_fields() as $field => $label ) {
				$wp_customize->add_setting( 'attachment_show_metadata_' . $field, array(
					'default'           => '1',
					'transport'         => 'postMessage',
				) );
				$wp_customize->add_control( 'attachment_show_metadata_' . $field, array(
					'section' => 'content_type_' . $post_type->name,
					/* translators: %s: metadata field label */
					'label'   => sprintf( __( 'Show %s?', 'super-awesome-theme' ), $label ),
					'type'    => 'checkbox',
				) );
				$wp_customize->selective_refresh->add_partial( 'attachment_show_metadata_' . $field, array(
					'selector'            => '.type-' . $post_type->name . ' .entry-attachment-meta',
					'render_callback'     => 'super_awesome_theme_customize_partial_entry_attachment_meta',
					'container_inclusive' => true,
					'type'                => 'SuperAwesomeThemePostPartial',
				) );
			}
		}

		$public_taxonomies = wp_list_filter( get_object_taxonomies( $post_type->name, 'objects' ), array(
			'public' => true,
		) );
		foreach ( $public_taxonomies as $taxonomy ) {
			$wp_customize->add_setting( $post_type->name . '_show_terms_' . $taxonomy->name, array(
				'default'           => '1',
				'transport'         => 'postMessage',
			) );
			$wp_customize->add_control( $post_type->name . '_show_terms_' . $taxonomy->name, array(
				'section' => 'content_type_' . $post_type->name,
				/* translators: %s: taxonomy plural label */
				'label'   => sprintf( _x( 'Show %s?', 'taxonomy', 'super-awesome-theme' ), $taxonomy->label ),
				'type'    => 'checkbox',
			) );
			$wp_customize->selective_refresh->add_partial( $post_type->name . '_show_terms_' . $taxonomy->name, array(
				'selector'            => '.type-' . $post_type->name . ' .entry-terms',
				'render_callback'     => 'super_awesome_theme_customize_partial_entry_terms',
				'container_inclusive' => true,
				'type'                => 'SuperAwesomeThemePostPartial',
			) );
		}

		if ( post_type_supports( $post_type->name, 'author' ) ) {
			$wp_customize->add_setting( $post_type->name . '_show_authorbox', array(
				'default'           => 'post' === $post_type->name ? '1' : '',
				'transport'         => 'postMessage',
			) );
			$wp_customize->add_control( $post_type->name . '_show_authorbox', array(
				'section' => 'content_type_' . $post_type->name,
				'label'   => __( 'Show Author Box?', 'super-awesome-theme' ),
				'type'    => 'checkbox',
			) );
			$wp_customize->selective_refresh->add_partial( $post_type->name . '_show_authorbox', array(
				'selector'            => '.type-' . $post_type->name . ' .entry-authorbox',
				'render_callback'     => 'super_awesome_theme_customize_partial_entry_authorbox',
				'container_inclusive' => true,
				'type'                => 'SuperAwesomeThemePostPartial',
			) );
		}
	}

	/* Customizer-generated CSS */

	$wp_customize->selective_refresh->add_partial( 'super_awesome_theme_customizer_styles', array(
		'settings'            => array(
			'text_color',
			'link_color',
			'wrap_background_color',
			'button_text_color',
			'button_background_color',
			'button_primary_text_color',
			'button_primary_background_color',
		),
		'selector'            => '#super-awesome-theme-customizer-styles',
		'render_callback'     => 'super_awesome_theme_customize_partial_styles',
		'container_inclusive' => false,
		'fallback_refresh'    => false,
	) );
}
add_action( 'customize_register', 'super_awesome_theme_customize_register' );

/**
 * Prints styles generated through the Customizer.
 *
 * @since 1.0.0
 */
function super_awesome_theme_print_customizer_styles() {
	$text_color                            = get_theme_mod( 'text_color', '#404040' );
	$text_focus_color                      = super_awesome_theme_darken_color( $text_color, 25 );
	$text_light_color                      = super_awesome_theme_lighten_color( $text_color, 100 );
	$link_color                            = get_theme_mod( 'link_color', '#21759b' );
	$link_focus_color                      = super_awesome_theme_darken_color( $link_color, 25 );
	$wrap_background_color                 = get_theme_mod( 'wrap_background_color', '' );
	$button_text_color                     = get_theme_mod( 'button_text_color', '#404040' );
	$button_background_color               = get_theme_mod( 'button_background_color', '#e6e6e6' );
	$button_background_focus_color         = super_awesome_theme_darken_color( $button_background_color, 25 );
	$button_primary_text_color             = get_theme_mod( 'button_primary_text_color', '#ffffff' );
	$button_primary_background_color       = get_theme_mod( 'button_primary_background_color', '#21759b' );
	$button_primary_background_focus_color = super_awesome_theme_darken_color( $button_primary_background_color, 25 );

	?>
	<style id="super-awesome-theme-customizer-styles" type="text/css">
		<?php if ( ! empty( $text_color ) && ! empty( $text_focus_color ) && ! empty( $text_light_color ) ) : ?>
			body,
			button,
			input,
			select,
			textarea {
				color: <?php echo esc_attr( $text_color ); ?>;
			}

			input[type="text"],
			input[type="email"],
			input[type="url"],
			input[type="password"],
			input[type="search"],
			input[type="number"],
			input[type="tel"],
			input[type="range"],
			input[type="date"],
			input[type="month"],
			input[type="week"],
			input[type="time"],
			input[type="datetime"],
			input[type="datetime-local"],
			input[type="color"],
			textarea {
				color: <?php echo esc_attr( $text_color ); ?>;
			}

			input[type="text"]:focus,
			input[type="email"]:focus,
			input[type="url"]:focus,
			input[type="password"]:focus,
			input[type="search"]:focus,
			input[type="number"]:focus,
			input[type="tel"]:focus,
			input[type="range"]:focus,
			input[type="date"]:focus,
			input[type="month"]:focus,
			input[type="week"]:focus,
			input[type="time"]:focus,
			input[type="datetime"]:focus,
			input[type="datetime-local"]:focus,
			input[type="color"]:focus,
			textarea:focus {
				color: <?php echo esc_attr( $text_focus_color ); ?>;
			}

			::-webkit-input-placeholder {
				color: <?php echo esc_attr( $text_light_color ); ?>;
			}

			:-moz-placeholder {
				color: <?php echo esc_attr( $text_light_color ); ?>;
			}

			::-moz-placeholder {
				color: <?php echo esc_attr( $text_light_color ); ?>;
			}

			:-ms-input-placeholder {
				color: <?php echo esc_attr( $text_light_color ); ?>;
			}

			abbr,
			acronym {
				border-bottom-color: <?php echo esc_attr( $text_color ); ?>;
			}

			hr,
			.wp-block-separator {
				border-bottom-color: <?php echo esc_attr( $text_light_color ); ?>;
			}

			tr {
				border-bottom-color: <?php echo esc_attr( $text_light_color ); ?>;
			}

			blockquote {
				color: <?php echo esc_attr( $text_color ); ?>;
				border-left-color: <?php echo esc_attr( $text_color ); ?>;
			}

			.wp-block-pullquote {
				border-top-color: <?php echo esc_attr( $text_color ); ?>;
				border-bottom-color: <?php echo esc_attr( $text_color ); ?>;
			}

			blockquote cite,
			blockquote footer,
			.wp-block-quote cite,
			.wp-block-quote footer,
			.wp-block-pullquote cite,
			.wp-block-pullquote footer {
				color: <?php echo esc_attr( $text_light_color ); ?>;
			}
		<?php endif; ?>
		<?php if ( ! empty( $link_color ) && ! empty( $link_focus_color ) ) : ?>
			a,
			a:visited {
				color: <?php echo esc_attr( $link_color ); ?>;
			}

			a:hover,
			a:focus,
			a:active {
				color: <?php echo esc_attr( $link_focus_color ); ?>;
			}

			button.button-link,
			input[type="button"].button-link,
			input[type="reset"].button-link,
			input[type="submit"].button-link,
			.button.button-link {
				color: <?php echo esc_attr( $link_color ); ?>;
			}

			button.button-link:hover,
			button.button-link:focus,
			input[type="button"].button-link:hover,
			input[type="button"].button-link:focus,
			input[type="reset"].button-link:hover,
			input[type="reset"].button-link:focus,
			input[type="submit"].button-link:hover,
			input[type="submit"].button-link:focus,
			.button.button-link:hover,
			.button.button-link:focus {
				color: <?php echo esc_attr( $link_focus_color ); ?>;
			}
		<?php endif; ?>
		<?php if ( super_awesome_theme_use_wrapped_layout() && ! empty( $wrap_background_color ) ) : ?>
			.site {
				background-color: <?php echo esc_attr( $wrap_background_color ); ?>;
			}
		<?php endif; ?>
		<?php if ( ! empty( $button_text_color ) && ! empty( $button_background_color ) && ! empty( $button_background_focus_color ) ) : ?>
			button,
			input[type="button"],
			input[type="reset"],
			input[type="submit"],
			.button {
				color: <?php echo esc_attr( $button_text_color ); ?>;
				background-color: <?php echo esc_attr( $button_background_color ); ?>;
			}

			button:hover,
			button:focus,
			input[type="button"]:hover,
			input[type="button"]:focus,
			input[type="reset"]:hover,
			input[type="reset"]:focus,
			input[type="submit"]:hover,
			input[type="submit"]:focus,
			.button:hover,
			.button:focus {
				background-color: <?php echo esc_attr( $button_background_focus_color ); ?>;
			}

			.wp-block-button .wp-block-button__link {
				color: <?php echo esc_attr( $button_text_color ); ?>;
				background-color: <?php echo esc_attr( $button_background_color ); ?>;
			}

			.wp-block-button .wp-block-button__link:hover,
			.wp-block-button .wp-block-button__link:focus {
				color: <?php echo esc_attr( $button_text_color ); ?>;
				background-color: <?php echo esc_attr( $button_background_focus_color ); ?>;
			}
		<?php endif; ?>
		<?php if ( ! empty( $button_primary_text_color ) && ! empty( $button_primary_background_color ) && ! empty( $button_primary_background_focus_color ) ) : ?>
			button.button-primary,
			input[type="button"].button-primary,
			input[type="reset"].button-primary,
			input[type="submit"].button-primary,
			.button.button-primary {
				color: <?php echo esc_attr( $button_primary_text_color ); ?>;
				background-color: <?php echo esc_attr( $button_primary_background_color ); ?>;
			}

			button.button-primary:hover,
			button.button-primary:focus,
			input[type="button"].button-primary:hover,
			input[type="button"].button-primary:focus,
			input[type="reset"].button-primary:hover,
			input[type="reset"].button-primary:focus,
			input[type="submit"].button-primary:hover,
			input[type="submit"].button-primary:focus,
			.button.button-primary:hover,
			.button.button-primary:focus {
				background-color: <?php echo esc_attr( $button_primary_background_focus_color ); ?>;
			}

			.wp-block-button.button-primary .wp-block-button__link {
				color: <?php echo esc_attr( $button_primary_text_color ); ?>;
				background-color: <?php echo esc_attr( $button_primary_background_color ); ?>;
			}

			.wp-block-button.button-primary .wp-block-button__link:hover,
			.wp-block-button.button-primary .wp-block-button__link:focus {
				color: <?php echo esc_attr( $button_primary_text_color ); ?>;
				background-color: <?php echo esc_attr( $button_primary_background_focus_color ); ?>;
			}
		<?php endif; ?>
	</style>
	<?php
}
add_action( 'wp_head', 'super_awesome_theme_print_customizer_styles' );

/**
 * Renders the Customizer styles for the selective refresh partial.
 *
 * @since 1.0.0
 */
function super_awesome_theme_customize_partial_styles() {
	ob_start();
	super_awesome_theme_print_customizer_styles();
	$output = ob_get_clean();

	echo preg_replace( '#<style[^>]*>(.*)</style>#is', '$1', $output ); // WPCS: XSS OK.
}

/**
 * Renders the site title for the selective refresh partial.
 *
 * @since 1.0.0
 */
function super_awesome_theme_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Renders the site tagline for the selective refresh partial.
 *
 * @since 1.0.0
 */
function super_awesome_theme_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Validates the 'sidebar_mode' customizer setting.
 *
 * @since 1.0.0
 *
 * @param WP_Error $validity Error object to add possible errors to.
 * @param mixed    $value    Value to validate.
 * @return WP_Error Possibly modified error object.
 */
function super_awesome_theme_customize_validate_sidebar_mode( $validity, $value ) {
	$choices = super_awesome_theme_customize_get_sidebar_mode_choices();

	if ( ! isset( $choices[ $value ] ) ) {
		$validity->add( 'invalid_choice', __( 'Invalid choice.', 'super-awesome-theme' ) );
	}

	return $validity;
}

/**
 * Gets the available choices for the 'sidebar_mode' customizer setting.
 *
 * @since 1.0.0
 *
 * @return array Array where values are the keys, and labels are the values.
 */
function super_awesome_theme_customize_get_sidebar_mode_choices() {
	return array(
		'no-sidebar'    => __( 'No Sidebar', 'super-awesome-theme' ),
		'left-sidebar'  => __( 'Left Sidebar', 'super-awesome-theme' ),
		'right-sidebar' => __( 'Right Sidebar', 'super-awesome-theme' ),
	);
}

/**
 * Validates the 'sidebar_size' customizer setting.
 *
 * @since 1.0.0
 *
 * @param WP_Error $validity Error object to add possible errors to.
 * @param mixed    $value    Value to validate.
 * @return WP_Error Possibly modified error object.
 */
function super_awesome_theme_customize_validate_sidebar_size( $validity, $value ) {
	$choices = super_awesome_theme_customize_get_sidebar_size_choices();

	if ( ! isset( $choices[ $value ] ) ) {
		$validity->add( 'invalid_choice', __( 'Invalid choice.', 'super-awesome-theme' ) );
	}

	return $validity;
}

/**
 * Gets the available choices for the 'sidebar_size' customizer setting.
 *
 * @since 1.0.0
 *
 * @return array Array where values are the keys, and labels are the values.
 */
function super_awesome_theme_customize_get_sidebar_size_choices() {
	return array(
		'small'  => __( 'Small', 'super-awesome-theme' ),
		'medium' => __( 'Medium', 'super-awesome-theme' ),
		'large'  => __( 'Large', 'super-awesome-theme' ),
	);
}

/**
 * Renders the entry metadata for a post.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Partial $partial Partial for which the function is invoked.
 * @param array                $context Context for which to render the entry metadata.
 */
function super_awesome_theme_customize_partial_entry_meta( $partial, $context ) {
	$post_type = null;
	if ( ! empty( $context['post_id'] ) ) {
		$post = get_post( $context['post_id'] );
		if ( $post ) {
			$post_type = $post->post_type;

			$GLOBALS['post'] = $post;
			setup_postdata( $post );
		}
	}

	get_template_part( 'template-parts/content/entry-meta', $post_type );
}

/**
 * Renders the entry attachment metadata for a post.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Partial $partial Partial for which the function is invoked.
 * @param array                $context Context for which to render the entry metadata.
 */
function super_awesome_theme_customize_partial_entry_attachment_meta( $partial, $context ) {
	if ( ! empty( $context['post_id'] ) ) {
		$post = get_post( $context['post_id'] );
		if ( $post ) {
			$GLOBALS['post'] = $post;
			setup_postdata( $post );
		}
	}

	get_template_part( 'template-parts/content/entry-attachment-meta' );
}

/**
 * Renders the entry terms for a post.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Partial $partial Partial for which the function is invoked.
 * @param array                $context Context for which to render the entry terms.
 */
function super_awesome_theme_customize_partial_entry_terms( $partial, $context ) {
	$post_type = null;
	if ( ! empty( $context['post_id'] ) ) {
		$post = get_post( $context['post_id'] );
		if ( $post ) {
			$post_type = $post->post_type;

			$GLOBALS['post'] = $post;
			setup_postdata( $post );
		}
	}

	get_template_part( 'template-parts/content/entry-terms', $post_type );
}

/**
 * Renders the entry author box for a post.
 *
 * @since 1.0.0
 *
 * @param WP_Customize_Partial $partial Partial for which the function is invoked.
 * @param array                $context Context for which to render the entry author box.
 */
function super_awesome_theme_customize_partial_entry_authorbox( $partial, $context ) {
	$post_type = null;
	if ( ! empty( $context['post_id'] ) ) {
		$post = get_post( $context['post_id'] );
		if ( $post ) {
			$post_type = $post->post_type;

			$GLOBALS['post'] = $post;
			setup_postdata( $post );
		}
	}

	get_template_part( 'template-parts/content/entry-authorbox', $post_type );
}

/**
 * Enqueues the script for the Customizer controls.
 *
 * @since 1.0.0
 */
function super_awesome_theme_customize_controls_js() {
	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '': '.min';

	wp_enqueue_script( 'super-awesome-theme-customize-controls', get_theme_file_uri( '/assets/dist/js/customize-controls' . $min . '.js' ), array( 'customize-controls' ), SUPER_AWESOME_THEME_VERSION, true );
	wp_localize_script( 'super-awesome-theme-customize-controls', 'themeCustomizeData', array(
		'i18n' => array(
			'blogSidebarEnabledNotice' => __( 'This page doesn&#8217;t support the blog sidebar. Navigate to the blog page or another page that supports it.', 'super-awesome-theme' ),
		),
	) );
}
add_action( 'customize_controls_enqueue_scripts', 'super_awesome_theme_customize_controls_js' );

/**
 * Enqueues the script for the Customizer preview.
 *
 * @since 1.0.0
 */
function super_awesome_theme_customize_preview_js() {
	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '': '.min';

	wp_enqueue_script( 'super-awesome-theme-customize-preview', get_theme_file_uri( '/assets/dist/js/customize-preview' . $min . '.js' ), array( 'customize-preview', 'customize-selective-refresh' ), SUPER_AWESOME_THEME_VERSION, true );
	wp_localize_script( 'super-awesome-theme-customize-preview', 'themeCustomizeData', array(
		'sidebarModeChoices' => super_awesome_theme_customize_get_sidebar_mode_choices(),
		'sidebarSizeChoices' => super_awesome_theme_customize_get_sidebar_size_choices(),
	) );
}
add_action( 'customize_preview_init', 'super_awesome_theme_customize_preview_js' );
