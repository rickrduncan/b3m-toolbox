<?php
/**
 * Shortcodes
 *
 * @since	1.0
 */


/**
* Toggle shortcode
*
* [toggle title="my title goes here" color="white"]content goes here[/toggle]
* [toggle title="my title goes here" color="gray"]content goes here[/toggle]
*
* @since 1.0.0
*/
function b3m_tb_toggle_shortcode( $atts, $content = null ) {
	
	extract( shortcode_atts( array( 'title' => 'Click To Open', 'color' => 'white' ),	$atts ) );
	
 	return '<h3 class="trigger toggle-'.$color.'"><a href="#">'. $title .'</a></h3><div class="toggle_container">' . do_shortcode($content) . '</div>';
}
add_shortcode( 'toggle', 'b3m_tb_toggle_shortcode' );


/**
 * Hide email from Spam Bots using a shortcode. [email]enter email here[/email]
 *
 * @param array  $atts    Shortcode attributes. Not used.
 * @param string $content The shortcode content. Should be an email address.
 *
 * @return string The obfuscated email address. 
 *
 * @since 1.0.0
 */
function b3m_tb_hide_email_shortcode( $atts , $content = null ) {
	if ( ! is_email( $content ) ) {
		return;
	}
	return '<a href="mailto:' . antispambot( $content ) . '">' . antispambot( $content ) . '</a>';
}
add_shortcode( 'email', 'b3m_tb_hide_email_shortcode' );