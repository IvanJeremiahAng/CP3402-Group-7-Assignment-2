<?php // phpcs:ignore WordPress.Files.FileName.NotHyphenatedLowercase
/**
 * Customizer blog options service.
 *
 * @package PressBook_Grid_Blogs
 */

/**
 * Blog options service class.
 */
class PressBook_Grid_Blogs_Options extends PressBook\Options {
	/**
	 * Allows to define customizer sections, settings, and controls.
	 */
	public function register() {
		add_filter( 'body_class', array( $this, 'body_classes' ), 15 );

		add_action( 'customize_register', array( $this, 'customize_register' ) );
		add_action( 'customize_preview_init', array( $this, 'customize_preview_scripts' ), 11 );
	}

	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @param array $classes Classes for the body element.
	 * @return array
	 */
	public function body_classes( $classes ) {
		if ( have_posts() ) {
			$classes[] = 'pb-content-grid';

			if ( in_array( 'pb-content-columns pb-content-cover', $classes, true ) ) {
				unset( $classes[ array_search( 'pb-content-columns pb-content-cover', $classes, true ) ] );
			} elseif ( in_array( 'pb-content-columns', $classes, true ) ) {
				unset( $classes[ array_search( 'pb-content-columns', $classes, true ) ] );
			}
		}

		return $classes;
	}

	/**
	 * Add blog options for theme customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function customize_register( $wp_customize ) {
		$this->set_posts_grid_shadow( $wp_customize );
		$this->set_posts_grid_excerpt( $wp_customize );

		$wp_customize->remove_control( 'set_archive_post_layout_lg' );
		$wp_customize->remove_control( 'set_archive_content' );
	}

	/**
	 * Binds JS handlers to make theme customizer preview reload changes asynchronously.
	 */
	public function customize_preview_scripts() {
		wp_localize_script(
			'pressbook-customizer',
			'pressbook',
			array(
				'styles'    => PressBook_Grid_Blogs_CSSRules::output_array(),
				'handle_id' => apply_filters( 'pressbook_grid_blogs_inline_style_handle_id', 'pressbook-grid-blogs-style-inline-css' ),
			)
		);
	}

	/**
	 * Add setting: Post Card Shadow Effect.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function set_posts_grid_shadow( $wp_customize ) {
		$wp_customize->add_setting(
			'set_posts_grid_shadow',
			array(
				'type'              => 'theme_mod',
				'default'           => self::get_posts_grid_shadow( true ),
				'transport'         => 'refresh',
				'sanitize_callback' => array( PressBook\Options\Sanitizer::class, 'sanitize_checkbox' ),
			)
		);

		$wp_customize->add_control(
			'set_posts_grid_shadow',
			array(
				'section'     => 'sec_blog',
				'type'        => 'checkbox',
				'label'       => esc_html__( 'Post Card Shadow Effect', 'pressbook-grid-blogs' ),
				'description' => esc_html__( 'Show shadow effect around the post card.', 'pressbook-grid-blogs' ),
				'priority'    => 8,
			)
		);
	}

	/**
	 * Get setting: Post Card Shadow Effect.
	 *
	 * @param bool $get_default Get default.
	 * @return string
	 */
	public static function get_posts_grid_shadow( $get_default = false ) {
		$default = apply_filters( 'pressbook_default_posts_grid_shadow', true );
		if ( $get_default ) {
			return $default;
		}

		return get_theme_mod( 'set_posts_grid_shadow', $default );
	}

	/**
	 * Add setting: Post Card Summary.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function set_posts_grid_excerpt( $wp_customize ) {
		$wp_customize->add_setting(
			'set_posts_grid_excerpt',
			array(
				'type'              => 'theme_mod',
				'default'           => self::get_posts_grid_excerpt( true ),
				'transport'         => 'refresh',
				'sanitize_callback' => array( PressBook\Options\Sanitizer::class, 'sanitize_select' ),
			)
		);

		$wp_customize->add_control(
			'set_posts_grid_excerpt',
			array(
				'section'     => 'sec_blog',
				'type'        => 'radio',
				'choices'     => array(
					''  => esc_html__( 'Hide summary for all posts in a grid.', 'pressbook-grid-blogs' ),
					'1' => esc_html__( 'Show summary only when there is no featured image.', 'pressbook-grid-blogs' ),
					'2' => esc_html__( 'Show summary even when there is featured image.', 'pressbook-grid-blogs' ),
				),
				'label'       => esc_html__( 'Post Card Summary', 'pressbook-grid-blogs' ),
				'description' => esc_html__( 'Select when to show the post summary in the posts grid.', 'pressbook-grid-blogs' ),
				'priority'    => 8,
			)
		);
	}

	/**
	 * Get setting: Post Card Summary.
	 *
	 * @param bool $get_default Get default.
	 * @return string
	 */
	public static function get_posts_grid_excerpt( $get_default = false ) {
		$default = apply_filters( 'pressbook_default_posts_grid_excerpt', '' );
		if ( $get_default ) {
			return $default;
		}

		return get_theme_mod( 'set_posts_grid_excerpt', $default );
	}

	/**
	 * Get blog site main class.
	 *
	 * @return string
	 */
	public static function blog_site_main_class() {
		$site_main_class = 'site-main';
		if ( have_posts() ) {
			$site_main_class .= ' site-main-grid';
		}

		return apply_filters( 'pressbook_blog_site_main_class', $site_main_class );
	}

	/**
	 * Get grid post row class.
	 *
	 * @return string
	 */
	public static function grid_post_row_class() {
		$grid_post_row_class = 'pb-row pb-grid-post-row';
		if ( self::get_posts_grid_shadow() ) {
			$grid_post_row_class .= ' pb-grid-post-shadow';
		}

		$hide_post_meta = PressBook\Options\Blog::get_hide_post_meta();

		if ( $hide_post_meta['all'] && $hide_post_meta['cat'] ) {
			$grid_post_row_class .= ' pb-grid-post-hide-meta-all';
		} else {
			if ( $hide_post_meta['all'] ) {
				$grid_post_row_class .= ' pb-grid-post-hide-meta';
			}

			if ( $hide_post_meta['cat'] ) {
				$grid_post_row_class .= ' pb-grid-post-hide-cat';
			}
		}

		return apply_filters( 'pressbook_grid_post_row_class', $grid_post_row_class );
	}

	/**
	 * Output the post excerpt in the posts grid.
	 */
	public static function the_grid_post_exceprt() {
		$posts_grid_excerpt = self::get_posts_grid_excerpt();

		if ( ! $posts_grid_excerpt ) {
			return;
		}

		if ( '1' === $posts_grid_excerpt ) {
			if ( ! has_post_thumbnail() && ( '' !== get_the_excerpt() ) ) {
				?>
				<div class="entry-summary"><?php the_excerpt(); ?></div>
				<?php
			}
		} elseif ( '2' === $posts_grid_excerpt ) {
			if ( '' !== get_the_excerpt() ) {
				?>
				<div class="entry-summary"><?php the_excerpt(); ?></div>
				<?php
			}
		}
	}
}
