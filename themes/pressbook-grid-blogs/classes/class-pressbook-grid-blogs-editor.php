<?php // phpcs:ignore WordPress.Files.FileName.NotHyphenatedLowercase
/**
 * Editor service.
 *
 * @package PressBook_Grid_Blogs
 */

/**
 * Editor setup.
 */
class PressBook_Grid_Blogs_Editor extends PressBook\Editor {
	/**
	 * Enqueue editor assets.
	 */
	public function enqueue_editor_assets() {
		$current_screen = get_current_screen();
		if ( $current_screen && in_array( $current_screen->id, array( 'widgets', 'nav-menus' ), true ) ) {
			return;
		}

		// Enqueue fonts.
		wp_enqueue_style( 'pressbook-grid-blogs-editor-fonts', PressBook_Grid_Blogs_Scripts::fonts_url(), array(), null ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion

		// Add inline style for fonts in the block editor.
		$this->load_editor_fonts_css();

		// Enqueue the block editor stylesheet.
		wp_enqueue_style( 'pressbook-grid-blogs-block-editor-style', get_theme_file_uri( 'assets/css/block-editor.css' ), array(), PRESSBOOK_GRID_BLOGS_VERSION );

		// Add output of customizer settings as inline style.
		wp_add_inline_style( 'pressbook-grid-blogs-block-editor-style', PressBook_Grid_Blogs_CSSRules::output_editor() );
	}

	/**
	 * Add inline style for fonts in the block editor.
	 */
	public function load_editor_fonts_css() {
		$fonts_css = '';

		/* translators: If there are characters in your language that are not supported by IBM Plex Serif, translate this to 'off'. Do not translate into your own language. */
		$ibm_plex_serif = _x( 'on', 'IBM Plex Serif font (in the editor): on or off', 'pressbook-grid-blogs' );
		if ( 'off' !== $ibm_plex_serif ) {
			$fonts_css .= ( '.block-editor-page .editor-styles-wrapper{font-family:\'IBM Plex Serif\', \'Georgia\', \'Times New Roman\', serif;}' );
		}

		/* translators: If there are characters in your language that are not supported by Source Serif Pro, translate this to 'off'. Do not translate into your own language. */
		$source_serif_pro = _x( 'on', 'Source Serif Pro font (in the editor): on or off', 'pressbook-grid-blogs' );
		if ( 'off' !== $source_serif_pro ) {
			$fonts_css .= ( '.editor-styles-wrapper .editor-post-title__input,.editor-styles-wrapper .editor-post-title .editor-post-title__input,.editor-styles-wrapper h1,.editor-styles-wrapper h2,.editor-styles-wrapper h3,.editor-styles-wrapper h4,.editor-styles-wrapper h5,.editor-styles-wrapper h6{font-family:\'Source Serif Pro\', \'Cambria\', sans-serif;}' );
		}

		if ( '' !== $fonts_css ) {
			wp_add_inline_style( 'pressbook-grid-blogs-editor-fonts', $fonts_css );
		}
	}
}
