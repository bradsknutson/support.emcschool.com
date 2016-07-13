<?php 
/**
 * Functions
 *
 * @package EMC Support
 * @author Brad Knutson
 * @copyright Copyright (c) 2011, EMC School
 * @license http://opensource.org/licenses/gpl-2.0.php GNU Public License
 *
*/
/**
 * Theme Setup
 *
 * This setup function attaches all of the site-wide functions
 * to the correct actions and filters. All the functions themselves
 * are defined below this setup function.
 *
*/


//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'EMC Support' );
define( 'CHILD_THEME_VERSION', '1.0.0' );

//* Enqueue Google Fonts
add_action( 'wp_enqueue_scripts', 'genesis_sample_google_fonts' );
function genesis_sample_google_fonts() {

	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Lato:300,400,700', array(), CHILD_THEME_VERSION );
    wp_enqueue_style('fontawesome', 'http:////netdna.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.css', '', '4.5.0', 'all');

}

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

//* Add Accessibility support
add_theme_support( 'genesis-accessibility', array( 'headings', 'drop-down-menu',  'search-form', 'skip-links', 'rems' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

add_action( 'init', 'create_custom_post_type' );

function fontawesome_dashboard() {
   wp_enqueue_style('fontawesome', 'http:////netdna.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.css', '', '4.5.0', 'all');
}

add_action('admin_init', 'fontawesome_dashboard');

add_action( 'init', 'create_video_cat_tax' );

function create_video_cat_tax() {
	register_taxonomy(
		'video_cat',
		'training_videos',
		array(
			'label' => __( 'Video Categories' ),
			'rewrite' => array( 'slug' => 'video-category' ),
			'hierarchical' => false,
		)
	);
}

function create_custom_post_type() {

    $tv_labels = array(
        'name' => __( 'Training Videos' ),
        'singular_name' => __( 'Training Video' ),
        'all_items' => __('All Training Videos'),
        'add_new' => _x('Add new Training Video', 'Training Videos'),
        'add_new_item' => __('Add new Training Video'),
        'edit_item' => __('Edit Training Video'),
        'new_item' => __('New Training Video'),
        'view_item' => __('View Training Video'),
        'search_items' => __('Search in Training Videos'),
        'not_found' =>  __('No Training Videos found'),
        'not_found_in_trash' => __('No Training Videos found in trash'),
        'parent_item_colon' => ''
    );

    $tv_args = array(
        'labels' => $tv_labels,
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-format-video',
        'rewrite' => array('slug' => 'videos'),
        'taxonomies' => array( 'product', 'video_cat' ),
        'supports' => array( 'title', 'editor', 'page-attributes' ),
    );

    $p_labels = array(
        'name' => __( 'Product Pages' ),
        'singular_name' => __( 'Product Page' ),
        'all_items' => __('All Product Pages'),
        'add_new' => _x('Add new Product Page', 'Product Pages'),
        'add_new_item' => __('Add new Product Page'),
        'edit_item' => __('Edit Product Page'),
        'new_item' => __('New Product Page'),
        'view_item' => __('View Product Page'),
        'search_items' => __('Search in TProduct Pages'),
        'not_found' =>  __('No Product Pages found'),
        'not_found_in_trash' => __('No Product Pages found in trash'),
        'parent_item_colon' => ''
    );

    $p_args = array(
        'labels' => $p_labels,
        'public' => true,
        'has_archive' => false,
        'menu_icon' => 'dashicons-welcome-learn-more',
        'rewrite' => array('slug' => 'product'),
        'supports' => array( 'title', 'editor', 'page-attributes', 'thumbnail' ),
    );

  register_post_type( 'training_videos', $tv_args);
  register_post_type( 'products', $p_args);
    
}   

    
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_before_header', 'genesis_do_nav' );

/* Code to Display Featured Image on top of the post */
add_action( 'genesis_after_header', 'featured_post_image', 8 );
function featured_post_image() {
  if ( is_singular( 'products' ) ) {
	the_post_thumbnail('post-image');
  }
}

//* Front Page Hero
add_action( 'genesis_after_header', 'front_page_hero', 8 );
function front_page_hero() {
  if ( is_front_page() ) {
      echo '<div class="home-hero"><div class="home-hero-title">'. get_the_title() .'</div>'. the_post_thumbnail('post-image') .'</div>';
  }
}

//* Change the footer text
add_filter('genesis_footer_creds_text', 'sp_footer_creds_filter');
function sp_footer_creds_filter( $creds ) {
	$creds = '[footer_copyright] &middot; <a href="http://www.emcp.com">EMC School</a>';
	return $creds;
}