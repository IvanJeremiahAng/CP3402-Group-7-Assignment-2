<?php
/**
 * This is the child theme for PressBook theme.
 *
 * (See https://developer.wordpress.org/themes/advanced-topics/child-themes/#how-to-create-a-child-theme)
 *
 * @package PressBook_Grid_Blogs
 */

defined( 'ABSPATH' ) || die();

define( 'PRESSBOOK_GRID_BLOGS_VERSION', '1.0.2' );

/**
 * Load child theme text domain.
 */
function pressbook_grid_blogs_setup() {
	load_child_theme_textdomain( 'pressbook-grid-blogs', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'pressbook_grid_blogs_setup', 11 );

/**
 * Load child theme services.
 *
 * @param  array $services Parent theme services.
 * @return array
 */
function pressbook_grid_blogs_services( $services ) {
	require get_stylesheet_directory() . '/classes/class-pressbook-grid-blogs-cssrules.php';
	require get_stylesheet_directory() . '/classes/class-pressbook-grid-blogs-scripts.php';
	require get_stylesheet_directory() . '/classes/class-pressbook-grid-blogs-editor.php';
	require get_stylesheet_directory() . '/classes/class-pressbook-grid-blogs-primarynavbar.php';
	require get_stylesheet_directory() . '/classes/class-pressbook-grid-blogs-related-posts.php';
	require get_stylesheet_directory() . '/classes/class-pressbook-grid-blogs-options.php';
	require get_stylesheet_directory() . '/classes/class-pressbook-grid-blogs-jetpack.php';

	foreach ( $services as $key => $service ) {
		if ( 'PressBook\Editor' === $service ) {
			$services[ $key ] = PressBook_Grid_Blogs_Editor::class;
		} elseif ( 'PressBook\Scripts' === $service ) {
			$services[ $key ] = PressBook_Grid_Blogs_Scripts::class;
		} elseif ( 'PressBook\Jetpack' === $service ) {
			$services[ $key ] = PressBook_Grid_Blogs_Jetpack::class;
		}
	}

	array_push( $services, PressBook_Grid_Blogs_PrimaryNavbar::class );
	array_push( $services, PressBook_Grid_Blogs_Related_Posts::class );
	array_push( $services, PressBook_Grid_Blogs_Options::class );

	return $services;
}
add_filter( 'pressbook_services', 'pressbook_grid_blogs_services' );

/**
 * Change default styles.
 *
 * @param  array $styles Default sttyles.
 * @return array
 */
function pressbook_grid_blogs_default_styles( $styles ) {
	$styles['top_navbar_bg_color_1']         = '#586cff';
	$styles['top_navbar_bg_color_2']         = '#455cff';
	$styles['primary_navbar_bg_color']       = '#1c1c21';
	$styles['primary_navbar_hover_bg_color'] = '#ff3955';
	$styles['button_bg_color_1']             = '#455cff';
	$styles['button_bg_color_2']             = '#586cff';
	$styles['footer_bg_color']               = '#0e0e11';
	$styles['footer_credit_link_color']      = '#3369e5';

	return $styles;
}
add_filter( 'pressbook_default_styles', 'pressbook_grid_blogs_default_styles' );

/**
 * Change welcome page title.
 *
 * @param  string $page_title Welcome page title.
 * @return string
 */
function pressbook_grid_blogs_welcome_page_title( $page_title ) {
	return esc_html_x( 'PressBook Grid Blogs', 'page title', 'pressbook-grid-blogs' );
}
add_filter( 'pressbook_welcome_page_title', 'pressbook_grid_blogs_welcome_page_title' );

/**
 * Change welcome menu title.
 *
 * @param  string $menu_title Welcome menu title.
 * @return string
 */
function pressbook_grid_blogs_welcome_menu_title( $menu_title ) {
	return esc_html_x( 'PressBook Grid', 'menu title', 'pressbook-grid-blogs' );
}
add_filter( 'pressbook_welcome_menu_title', 'pressbook_grid_blogs_welcome_menu_title' );

/**
 * Recommended plugins.
 */
require get_stylesheet_directory() . '/inc/recommended-plugins.php';
