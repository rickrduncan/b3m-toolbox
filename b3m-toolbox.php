<?php
/**
 * 	Plugin Name: 	B3M Toolbox
 * 	Plugin URI: 	http://rickrduncan.com/wordpress-plugins
 * 	Description: 	A toolbox of goodies to use with WordPress.
 *	Author: 		Rick R. Duncan - B3Marketing, LLC
 *	Author URI: 	https://rickrduncan.com
 *
 *
 * 	Version: 		1.0.0
 * 	License: 		GPLv3
 *
 *
 */


/**
* Set a CONSTANT equal to plugin folder path
*
* @since 1.0.0
*/
if ( ! defined( 'B3M_TB_PLUGIN_DIR' ) )
	define( 'B3M_TB_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
	

/**
* Set a CONSTANT equal to plugin URL
*
* @since 1.0.0
*/
if ( ! defined( 'B3M_TB_PLUGIN_URL' ) )
	define( 'B3M_TB_PLUGIN_URL', plugin_dir_url( __FILE__ ) );


/**
* Include required files
*
* @since 1.0.0
*/
require_once B3M_TB_PLUGIN_DIR . 'includes/shortcodes.php';


/**
* Enqueue our files
*
* @since 1.0.0
*/
function b3m_tb_enqueue_scripts() {

	wp_enqueue_script( 'b3m-scripts', B3M_TB_PLUGIN_URL . 'js/b3m-toolbox.js', array( 'jquery' ) );
	wp_enqueue_style( 'b3m-style', B3M_TB_PLUGIN_URL . 'css/b3m-style.css', array() );

}
add_action( 'wp_enqueue_scripts', 'b3m_tb_enqueue_scripts' );


/**
* Remove 'Editor' from 'Appearance' Menu. 
* This stops users from being able to edit files from within WordPress. 
*
* @since 1.0.0
*/
if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
	define( 'DISALLOW_FILE_EDIT', true );
}


/**
* Add the ability to use shortcodes in widgets
*
* @since 1.0.0
*/
add_filter( 'widget_text', 'do_shortcode' ); 


/**
* Prevent WordPress from compressing images
*
* @since 1.0.0
*/
add_filter( 'jpeg_quality', create_function( '', 'return 100;' ) );


/**
* Limit the number of post revisions to keep
*
* @since 1.0.0
*/
function b3m_tb_set_revision_max( $num, $post ) {     
    $num = 5; //change 5 to match your preferred number of revisions to keep
	return $num; 
}
add_filter( 'wp_revisions_to_keep', 'b3m_tb_set_revision_max', 10, 2 );


/**
* Remove silly-ass emoji code
*
* Source code credit: http://ottopress.com/
*
* @since 1.0.0
*/
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );   
remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );     
remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );


/**
* Remove items from the <head> section
*
* @since 1.0.0
*/
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );	//* Remove previous/next post links
remove_action( 'wp_head', 'feed_links', 2 );							//* Remove application/rss+xml feed links
remove_action( 'wp_head', 'feed_links_extra', 3 );						//* Remove application/rss+xml comment feed links
remove_action( 'wp_head', 'rsd_link' );									//* Remove rsd_link
remove_action( 'wp_head', 'wlwmanifest_link' );							//* Remove wlwmanifest_link
remove_action( 'wp_head', 'wp_generator' );								//* Remove WP Version number
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );				//* Remove shortlink


/**
* Remove clutter from main dasboard screen 
*
* @since 1.0.0
*/
function b3m_tb_remove_dashboard_widgets() {
	
	//remove_meta_box('dashboard_right_now', 'dashboard', 'normal'); 		// right now
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal'); 	// recent comments
    remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal'); 	// incoming links
    remove_meta_box('dashboard_plugins', 'dashboard', 'normal'); 			// plugins
    remove_meta_box('dashboard_quick_press', 'dashboard', 'normal'); 		// quick press
    remove_meta_box('dashboard_recent_drafts', 'dashboard', 'normal'); 		// recent drafts
    remove_meta_box('dashboard_primary', 'dashboard', 'normal'); 			// wordpress blog
    remove_meta_box('dashboard_secondary', 'dashboard', 'normal'); 			// other wordpress news
}
add_action( 'admin_init', 'b3m_tb_remove_dashboard_widgets' );


/**
* Remove unwanted core widgets
*
* @since 1.0.0
*/
function b3m_tb_remove_default_widgets() {
	//unregister_widget('WP_Widget_Pages');
    //unregister_widget('WP_Widget_Search');
    //unregister_widget('WP_Widget_Text');
    //unregister_widget('WP_Widget_Categories');
    //unregister_widget('WP_Widget_Recent_Posts');
    //unregister_widget('WP_Nav_Menu_Widget');
    unregister_widget('WP_Widget_Calendar');
    unregister_widget('WP_Widget_Archives');
    unregister_widget('WP_Widget_Links');
    unregister_widget('WP_Widget_Meta');
    unregister_widget('WP_Widget_Recent_Comments');
    unregister_widget('WP_Widget_RSS');
    //unregister_widget('WP_Widget_Tag_Cloud');
    unregister_widget('Twenty_Eleven_Ephemera_Widget');
}
add_action( 'widgets_init', 'b3m_tb_remove_default_widgets', 11 );


/**
* Add superscript and subscript to Tiny MCE editor
*
* @since 1.0.0
*/
function b3m_tb_mce_buttons_2($buttons) {
	/*** Add in a core button that's disabled by default*/
	$buttons[] = 'superscript';
	$buttons[] = 'subscript';
	
	return $buttons;
}
add_filter('mce_buttons_2', 'b3m_tb_mce_buttons_2');


/**
* STEP 1: Callback function to insert 'styleselect' into the $buttons array
*
* @since 1.0.0
*/
function b3m_tb_mce_buttons_3( $buttons ) {
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}
add_filter( 'mce_buttons_3', 'b3m_tb_mce_buttons_3' );


/**
* STEP 2: Callback function to filter the MCE settings which adds our new style select drown down box on row 3
*
* @since 1.0.0
*/
function b3m_tb_mce_before_init_insert_formats( $init_array ) {  
	// Define the style_formats array
	$style_formats = array(  
		// Each array child is a format with it's own settings
		array(  
			'title' => 'Content Block - Blue',  
			'block' => 'div',  
			'classes' => 'content-box-blue',
			'wrapper' => true,
			
		),
		array(  
			'title' => 'Content Block - Red',  
			'block' => 'div',  
			'classes' => 'content-box-red',
			'wrapper' => true,
			
		), 
		array(  
			'title' => 'Content Block - Yellow',  
			'block' => 'div',  
			'classes' => 'content-box-yellow',
			'wrapper' => true,
			
		), 
	);  
	// Insert the array, JSON ENCODED, into 'style_formats'
	$init_array['style_formats'] = json_encode( $style_formats );  
	
	return $init_array;  
  
} 
// Attach callback to 'tiny_mce_before_init' 
add_filter( 'tiny_mce_before_init', 'b3m_tb_mce_before_init_insert_formats' );  



/**
* Don't Update Theme
* @author Mark Jaquith
* @link http://markjaquith.wordpress.com/2009/12/14/excluding-your-plugin-or-theme-from-update-checks/
*
* @since 1.0.0
*/
function b3m_tb_dont_update_theme( $r, $url ) {
	
	if ( 0 !== strpos( $url, 'http://api.wordpress.org/themes/update-check' ) )
		return $r; // Not a theme update request. Bail immediately.
	$themes = unserialize( $r['body']['themes'] );
	unset( $themes[ get_option( 'template' ) ] );
	unset( $themes[ get_option( 'stylesheet' ) ] );
	$r['body']['themes'] = serialize( $themes );
	
	return $r;
}
add_filter( 'http_request_args', 'b3m_tb_dont_update_theme', 5, 2 );
