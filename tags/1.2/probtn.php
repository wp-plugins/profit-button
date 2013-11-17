<?php
/**
 * Plugin Name: Profit Button
 * Plugin URI: http://probtn.com
 * Description: Profit Button is an interactive element that used to show custom content inside your application. If the button is tapped then the popup with Browser would open. The url in the Browser is set using settings on our server.
 * Version: 1.1
 * Author: hintsolutions
 * Author URI: http://probtn.com
 * License: -
 */
 
 /**
 * Register with hook 'wp_enqueue_scripts', which can be used for front end CSS and JavaScript
 */
add_action( 'wp_enqueue_scripts', 'probtn_add_my_stylesheet' );

/**
 * Enqueue plugin style-file
 */
function probtn_add_my_stylesheet() {
    // Respects SSL, Style.css is relative to the current file
    wp_register_style( 'probtn-style', 'https://pizzabtn.herokuapp.com/stylesheets/probtn.css');
    wp_enqueue_style( 'probtn-style' );
	
	wp_register_script( 'probtn-script', 'https://pizzabtn.herokuapp.com/javascripts/probtn.js');
	wp_enqueue_script( 'probtn-script' );
	
	//wp_register_script( 'jquerypep-script', plugins_url('https://pizzabtn.herokuapp.com/javascripts/jquery.pep.min.js', __FILE__) );
	wp_register_script( 'jquerypep-script', 'https://pizzabtn.herokuapp.com/javascripts/jquery.pep.min.js');
	wp_enqueue_script( 'jquerypep-script' );
	
	$mainStyleCss = parse_url('https://pizzabtn.herokuapp.com/stylesheets/probtn.css');
	$jqueryPepPath = parse_url(plugins_url('libs/jquery.pep.min.js', __FILE__));
	
	wp_register_script( 'probtn-start-script', plugins_url("start_probtn.php?mainStyleCss=".$mainStyleCss["path"]."&jqueryPepPath=".$jqueryPepPath["path"]."", __FILE__) );
	wp_enqueue_script( 'probtn-start-script' );
}


/** Step 2 (from text above). */
add_action( 'admin_menu', 'probtn_menu' );

/** Step 1. */
function probtn_menu() {
	add_options_page( 'Profit Button options', 'Profit Button', 'manage_options', 'probtn-identifier1', 'probtn_options' );
}

/** Step 3. */
function probtn_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	?>
	<div class="wrap">
	<h2>Description:</h2>
	<p>Profit button is a new way to add survey, ads or some other additional content without adding any changes to your design.</p>
	<p>Functionality is implemented like floating button above your site, and after clicking on button would be opened additional modal window with nessesary content.</p>
	<p>For better usability users can use admin panel with settings and button targeting, and also some detailed statistics and analytics.</p>
	<h2>Admin panel:</h2>
	<a href="http://admin.probtn.com" target="_blank">Open admin panel (in new tab)</a>
	</div>
	<?php
}
?>
