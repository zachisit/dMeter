<?php
/******************************************************
Plugin Name: Death Meter Plugin
Plugin URI:  http://www.google.com
Description: Plugin description to go here
Version:     0.2
Author:      Zachary Smith
Author URI:  http://URI_Of_The_Plugin_Author
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: my-toolset
******************************************************/

/* create custom menu after plugin is activated */
function add_death_meter_menu() {
    //add menu item to plugin homepage
    add_menu_page (
        'Death Meter Plugin Settings',
        'Death Meter Settings',
        'manage_options',
        'death-meter-plugin-settings',
        'death_meter_admin_page_function',
        plugin_dir_url( __FILE__ ).'icons/my_icon.png',
        '23.56' //hiearchy position of menu
    );
}
//wordpress hooks to trigger settings menu creation
add_action( 'admin_menu', 'add_death_meter_menu' );

/* plugin settings panel */
function death_meter_admin_page_function() 
	{
	//get the content for the admin panel settings
	$content = file_get_contents('/views/admin_panel.html', true);
	
	//output content
	echo $content;
	}

/* register styles */
function death_meter_styles() {
    // Register the style like this for a plugin:
    wp_register_style( 'custom-style', plugins_url( '/css/style.css', __FILE__ ), array(), '20151221', 'all' );
 
	//load up counter.js file
	wp_enqueue_script( 'custom-style', plugins_url( '/js/countup.js', __FILE__ ), array(), '20151222', 'true' );
	
    // enqueue
    wp_enqueue_style( 'custom-style' );
	}
add_action( 'wp_enqueue_scripts', 'death_meter_styles' );

/* one of two shortcodes used in plugin */
function death_meter_one_shortcode() {
	//require file for parser
	include('regression.php');
	
	//assign variable to the output
	$value = \DMRegression\getDisplayModelParams();
	
	//print first value for array
	$shortcode_primary_value = $value[0];
	
	//create var for counter from the array second value
	$counter = $value[1];
	
	//TODO
	//pipe in the increment script to the value
	
	//multiply shortcode value by 5x
	$shortcode_one_multiplied_five = $shortcode_primary_value *5;
	
	//multiply shortcode value by 20x
	$shortcode_one_multiplied_twenty = $shortcode_primary_value *20;	
	
	//multiply shortcode value by 100x
	$shortcode_one_multiplied_hundred = $shortcode_primary_value *100;	
	
	//format all vars into normal english reading
	$shortcode_primary_value = number_format($shortcode_primary_value);
	$shortcode_one_multiplied_five = number_format($shortcode_one_multiplied_five);
	$shortcode_one_multiplied_twenty = number_format($shortcode_one_multiplied_twenty);
	$shortcode_one_multiplied_hundred = number_format($shortcode_one_multiplied_hundred);
	
	//get template
	ob_start();
	include dirname(__FILE__) . '/views/template_one.php';
	$content = ob_get_clean();
	
	//output content with vars
	return $content;
}
//register shortcode function
function death_meter_one_shortcode_register_shortcode() {
    add_shortcode( 'death_meter_one', 'death_meter_one_shortcode' );
}
add_action( 'init', 'death_meter_one_shortcode_register_shortcode' );

/* two of two shortcodes used in plugin */
function death_meter_two_shortcode() {
	//get template
	ob_start();
	include dirname(__FILE__) . '/views/template_two.php';
	$content = ob_get_clean();
	
	//output content with vars
	return $content;
}
//register shortcode function
function death_meter_two_shortcode_register_shortcode() {
    add_shortcode( 'death_meter_two', 'death_meter_two_shortcode' );
}
add_action( 'init', 'death_meter_two_shortcode_register_shortcode' );