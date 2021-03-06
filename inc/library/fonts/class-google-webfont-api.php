<?php
/**
 * Super_Awesome_Theme_Google_Webfont_API class
 *
 * @package Super_Awesome_Theme
 * @license GPL-2.0-or-later
 * @link    https://super-awesome-author.org/themes/super-awesome-theme/
 */

/**
 * Class representing the Google web font API.
 *
 * @since 1.0.0
 */
class Super_Awesome_Theme_Google_Webfont_API extends Super_Awesome_Theme_Webfont_API {

	/**
	 * Temporary internal storage to persist the ID attribute to load fonts with in the current request.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	protected $id_attr = '';

	/**
	 * Temporary internal storage to persist the fonts to load in the current request.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	protected $fonts = array();

	/**
	 * Gets the slug of the web font API.
	 *
	 * Font families part of this API will be prefixed with that slug and a colon.
	 *
	 * @since 1.0.0
	 *
	 * @return string API slug.
	 */
	public function get_slug() {
		return 'google';
	}

	/**
	 * Gets the title of the web font API.
	 *
	 * @since 1.0.0
	 *
	 * @return string API title.
	 */
	public function get_title() {
		return __( 'Google Fonts', 'super-awesome-theme' );
	}

	/**
	 * Loads the fonts.
	 *
	 * This enqueues the Google fonts stylesheet and adds a preconnect resource hint for it.
	 * In case of a Customizer partial, the markup needs to be printed directly using a `<link>` tag.
	 *
	 * @since 1.0.0
	 *
	 * @param string $id_attr ID attribute to use for the outer tag to print. This has to be used in order
	 *                        to support a Customizer partial.
	 * @param array  $fonts   List of fonts to load. Each item is an associative arrays containing a `family`
	 *                        key with the font family instance, and a `weight` key with the desired font
	 *                        weight.
	 */
	public function load_fonts( $id_attr, array $fonts ) {
		if ( is_customize_preview() && ! empty( $_POST[ WP_Customize_Selective_Refresh::RENDER_QUERY_VAR ] ) ) { // phpcs:ignore WordPress.CSRF.NonceVerification.NoNonceVerification
			$url = $this->get_fonts_url( $fonts );
			if ( empty( $url ) ) {
				return;
			}

			echo '<link rel="stylesheet" id="' . esc_attr( $id_attr ) . '" href="' . esc_url( $url ) . '" type="text/css" media="all" />'; // phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedStylesheet
			return;
		}

		$this->id_attr = str_replace( '-css', '', $id_attr );
		$this->fonts   = $fonts;
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_fonts' ), 0, 0 );
		add_filter( 'wp_resource_hints', array( $this, 'filter_preconnect_resource_hints' ), 10, 2 );
	}

	/**
	 * Enqueues the stylesheet for loading Google fonts.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_fonts() {
		if ( empty( $this->id_attr ) || empty( $this->fonts ) ) {
			return;
		}

		$url = $this->get_fonts_url( $this->fonts );
		if ( empty( $url ) ) {
			return;
		}

		wp_enqueue_style( $this->id_attr, $url, array(), null );
	}

	/**
	 * Adds preconnect resource hints for Google fonts.
	 *
	 * @since 1.0.0
	 *
	 * @param array  $urls          URLs to print for resource hints.
	 * @param string $relation_type The relation type the URLs are printed.
	 * @return array $urls Filtered URLs.
	 */
	public function filter_preconnect_resource_hints( $urls, $relation_type ) {
		if ( 'preconnect' === $relation_type ) {
			$urls[] = array(
				'href' => 'https://fonts.gstatic.com',
				'crossorigin',
			);
		}

		return $urls;
	}

	/**
	 * Gets the Google Fonts URL to load the given fonts.
	 *
	 * In case of a Customizer preview, a URL is returned even if no fonts need to be loaded,
	 * in order for the Customizer partial to work.
	 *
	 * @since 1.0.0
	 *
	 * @param array $fonts List of fonts to load. Each item is an associative arrays containing a `family`
	 *                     key with the font family instance, and a `weight` key with the desired font weight.
	 * @return string Fonts URL, or empty string if nothing should be loaded.
	 */
	protected function get_fonts_url( array $fonts ) {
		$font_families = array();

		foreach ( $fonts as $font ) {
			if ( ! $font['family'] instanceof Super_Awesome_Theme_Webfont_Family ) {
				continue;
			}

			$family = $font['family']->get_prop( Super_Awesome_Theme_Webfont_Family::PROP_LABEL );
			$files  = $font['family']->get_prop( Super_Awesome_Theme_Webfont_Family::PROP_FILES );

			if ( ! isset( $files[ $font['weight'] ] ) ) {
				continue;
			}

			$variants = array( $font['weight'] );
			if ( isset( $files[ $font['weight'] . 'italic' ] ) ) {
				$variants[] = $font['weight'] . 'i';
			}

			if ( isset( $font_families[ $family ] ) ) {
				if ( ! strpos( $font_families[ $family ], $font['weight'] ) ) {
					$font_families[ $family ] .= ',' . implode( ',', $variants );
				}
				continue;
			}

			$font_families[ $family ] = $family . ':' . implode( ',', $variants );
		}

		if ( empty( $font_families ) && ! is_customize_preview() ) {
			return '';
		}

		return add_query_arg( array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		), 'https://fonts.googleapis.com/css' );
	}

	/**
	 * Fetches the available font families.
	 *
	 * @since 1.0.0
	 *
	 * @return array List of font family data.
	 */
	protected function fetch_families() {
		$filename = get_theme_file_path( 'assets/resources/google-webfonts.json' );
		if ( ! file_exists( $filename ) ) {
			return array();
		}

		$json = json_decode( file_get_contents( $filename ), true );
		if ( ! is_array( $json ) || empty( $json['items'] ) ) {
			return array();
		}

		$families = array();
		foreach ( $json['items'] as $google_family ) {
			if ( empty( $google_family['family'] ) || empty( $google_family['files'] ) ) {
				continue;
			}

			$group    = ! empty( $google_family['category'] ) ? $google_family['category'] : Super_Awesome_Theme_Webfont_Family::GROUP_SANS_SERIF;
			$fallback = in_array( $group, array( 'sans-serif', 'serif', 'monospace' ), true ) ? $group : 'sans-serif';

			$weights = array();
			$files   = array();
			foreach ( $google_family['files'] as $variant => $file ) {
				if ( 'regular' === $variant ) {
					$variant = '400';
				} elseif ( 'italic' === $variant ) {
					$variant = '400italic';
				} else {
					$variant = (string) $variant;
				}

				$files[ $variant ] = $file;

				if ( ! is_numeric( $variant ) ) {
					continue;
				}

				$weights[] = $variant;
			}

			$families[] = array(
				Super_Awesome_Theme_Webfont_Family::PROP_ID      => $google_family['family'],
				Super_Awesome_Theme_Webfont_Family::PROP_LABEL   => $google_family['family'],
				Super_Awesome_Theme_Webfont_Family::PROP_STACK   => array( $google_family['family'], $fallback ),
				Super_Awesome_Theme_Webfont_Family::PROP_WEIGHTS => $weights,
				Super_Awesome_Theme_Webfont_Family::PROP_GROUP   => $group,
				Super_Awesome_Theme_Webfont_Family::PROP_FILES   => $files,
			);
		}

		return $families;
	}
}
