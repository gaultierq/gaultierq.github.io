<?php
/**
* List of theme support functions
*/
// Check if the function exist
if ( function_exists( 'add_theme_support' ) ){

	// Add post thumbnail feature
	add_theme_support( 'post-thumbnails' );
	add_image_size('blog-image', 879, 496, true); // blog image
	add_image_size('small-thumb', 215, 125, true); // small thumbnail
	add_image_size('carousel-image', 290, 200, true); // carousel image
	
	// Add WordPress navigation menus
	add_theme_support('nav-menus');
	register_nav_menus( array(
		'main-menu' => __( 'Main Menu', 'grateful' ),
	) );

	// Add WordPress post format
	add_theme_support( 'post-formats', array( 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video', 'audio' )); 

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Add custom background feature 
	add_theme_support( 'custom-background' );
}

// Theme Localization
load_theme_textdomain('grateful', get_template_directory().'/lang');

// Set maximum image width displayed in a single post or page
if ( ! isset( $content_width ) ) {
	$content_width = 720;
}
?>