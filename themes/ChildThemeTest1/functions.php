<?php
add_action( 'wp_enqueue_scripts', 'ChildThemeTest1_enqueue_child_theme_styles', PHP_INT_MAX);

function ChildThemeTest1_enqueue_child_theme_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri().'/style.css', array('parent-style') );
}

?>