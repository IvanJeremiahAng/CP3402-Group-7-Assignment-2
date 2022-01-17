<?php // phpcs:ignore WordPress.Files.FileName.NotHyphenatedLowercase
/**
 * Scripts service.
 *
 * @package PressBook_Grid_Blogs
 */

/**
 * Enqueue theme styles and scripts.
 */
class PressBook_Grid_Blogs_Scripts extends PressBook\Scripts {
	/**
	 * Register service features.
	 */
	public function register() {
		parent::register();

		// Remove parent theme inline stlyes.
		add_action( 'wp_print_styles', array( $this, 'print_styles' ) );

		if ( is_admin() && isset( $GLOBALS['pagenow'] ) && in_array( $GLOBALS['pagenow'], array( 'widgets.php', 'nav-menus.php' ), true ) ) {
			add_action( 'wp_print_styles', array( $this, 'remove_dynamic_styles' ) );
		}
	}

	/**
	 * Enqueue styles and scripts.
	 */
	public function enqueue_scripts() {
		// Enqueue child theme fonts.
		wp_enqueue_style( 'pressbook-grid-blogs-fonts', static::fonts_url(), array(), null ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion

		// Enqueue parent theme styles and scripts.
		parent::enqueue_scripts();

		// Dequeue parent theme fonts.
		wp_dequeue_style( 'pressbook-fonts' );

		// Enqueue child theme stylesheet.
		wp_enqueue_style( 'pressbook-grid-blogs-style', get_stylesheet_directory_uri() . '/style.min.css', array(), PRESSBOOK_GRID_BLOGS_VERSION );
		wp_style_add_data( 'pressbook-grid-blogs-style', 'rtl', 'replace' );

		// Add output of customizer settings as inline style.
		wp_add_inline_style( 'pressbook-grid-blogs-style', PressBook_Grid_Blogs_CSSRules::output() );
	}

	/**
	 * Add preconnect for Google fonts.
	 *
	 * @param array  $urls           URLs to print for resource hints.
	 * @param string $relation_type  The relation type the URLs are printed.
	 * @return array $urls           URLs to print for resource hints.
	 */
	public function resource_hints( $urls, $relation_type ) {
		if ( wp_style_is( 'pressbook-grid-blogs-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
			$urls[] = array(
				'href' => 'https://fonts.gstatic.com',
				'crossorigin',
			);
		}

		return $urls;
	}

	/**
	 * Get fonts URL.
	 */
	public static function fonts_url() {
		$fonts_url = '';

		$font_families = array();

		$query_params = array();

		/* translators: If there are characters in your language that are not supported by IBM Plex Serif, translate this to 'off'. Do not translate into your own language. */
		$ibm_plex_serif = _x( 'on', 'IBM Plex Serif font: on or off', 'pressbook-grid-blogs' );
		if ( 'off' !== $ibm_plex_serif ) {
			array_push( $font_families, 'IBM+Plex+Serif:ital,wght@0,400;0,600;1,400;1,600' );
		}

		/* translators: If there are characters in your language that are not supported by Source Serif Pro, translate this to 'off'. Do not translate into your own language. */
		$source_serif_pro = _x( 'on', 'Source Serif Pro font: on or off', 'pressbook-grid-blogs' );
		if ( 'off' !== $source_serif_pro ) {
			array_push( $font_families, 'Source+Serif+Pro:ital,wght@0,400;0,600;1,400;1,600' );
		}

		if ( count( $font_families ) > 0 ) {
			foreach ( $font_families as $font_family ) {
				array_push( $query_params, ( 'family=' . $font_family ) );
			}

			array_push( $query_params, 'display=swap' );

			$fonts_url = ( 'https://fonts.googleapis.com/css2?' . implode( '&#038;', $query_params ) );
		}

		$fonts_url = apply_filters( 'pressbook_grid_blogs_fonts_url', $fonts_url );

		return esc_url_raw( $fonts_url );
	}

	/**
	 * Remove parent theme inline style.
	 */
	public function print_styles() {
		if ( wp_style_is( 'pressbook-style', 'enqueued' ) ) {
			wp_style_add_data( 'pressbook-style', 'after', '' );
		}
	}

	/**
	 * Remove theme inline style.
	 */
	public function remove_dynamic_styles() {
		if ( wp_style_is( 'pressbook-grid-blogs-style', 'enqueued' ) ) {
			wp_style_add_data( 'pressbook-grid-blogs-style', 'after', '' );
		}
	}
}
