<?php
/**
 * Plugin Name: Profit Button
 * Plugin URI: http://probtn.com
 * Description: Profit Button is an interactive element that used to show custom content inside your application. If the button is tapped then the popup with Browser would open. The url in the Browser is set using settings on our server.
 * Version: 1.0
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

	/*add_submenu_page( 
        'options.php'   //or 'options.php' 
        , 'My Custom Submenu Page' 
        , 'My Custom Submenu Page'
        , 'manage_options'
        , 'my-custom-submenu-page'
        , 'probtn_options'
    );*/
    // http://cs413224.vk.me/v413224656/3f89/2dCXEH-_tGE.jpg
    // plugins_url( 'myplugin/images/icon.png' )
    
    add_menu_page( 'Profit Button', 'Profit Button', 'manage_options', 'prfit_button_page', 
    'probtn_options', plugins_url( 'profit-button/images/profit_button_icon_3_1.png' ), 166 ); 
}

/** Step 3. */
function probtn_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	?>
	
	<script src='https://pizzabtn.herokuapp.com/javascripts/jquery.pep.min.js'></script>
	<script src='https://pizzabtn.herokuapp.com/javascripts/jquery.fancybox.js'></script>
	<script src='https://pizzabtn.herokuapp.com/javascripts/probtn.js'></script>
	<script>
		jQuery(document).ready(
			function($){
				$(document).StartButton(
					{
						'domain': 'example.com',
						'mainStyleCss':'https://pizzabtn.herokuapp.com/stylesheets/probtn.css'});
			});
	</script>
	
	<div class="wrap">
	<div style="clear: both; width: 95%; display: inline-block;
	height: 110px;">
		<img style="width: 100px; height: auto; display: inline-block; float: left;" 
			src="<?php echo plugins_url('/profit-button/images/logo.png'); ?>"/>
		<h1 style="line-height: 70px; margin-left: 20px; display: inline-block;width: auto;">Profit Button description</h1>
	</div>
	
	
<div id="dashboard-widgets-container" class="ngg-overview">
		    <div id="dashboard-widgets" class="metabox-holder">
				<div id="post-body">
					<div id="dashboard-widgets-main-content">

<div class="postbox-container" id="main-container" style="width:75%;">
<div id="left-sortables" class="meta-box-sortables ui-sortable">
<div id="dashboard_right_now" class="postbox ">
<div class="handlediv" title="Нажмите, чтобы переключить"><br></div>
<h3 class="hndle"><span>About</span></h3>
<div class="inside" style="padding-top: 0px !important;">
<p>Profit button is a new way to add survey, ads or some other additional content without adding any changes to your design.</p>
	<p>Functionality is implemented like floating button above your site, and after clicking on button would be opened additional modal window with nessesary content.</p>
	<p>For better usability users can use admin panel with settings and button targeting, and also some detailed statistics and analytics.</p>
</div>
</div>

<div id="dashboard_right_now" class="postbox ">
<div class="handlediv" title="Нажмите, чтобы переключить"><br></div>
<h3 class="hndle"><span>Setup</span></h3>
<div class="inside" style="padding-top: 0px !important;">
	<center><a href="http://bit.ly/profitbutton-wordpress" target="_blank">
		<button>Sign up</button>
	</a></center><br/>
	
<p>First of all you should open <a href="http://bit.ly/profitbutton-wordpress" target="_blank">http://admin.probtn.com</a> and enter (or sign up if you havn't account).</p>
	<img style="width: 90%; height: auto;" src="<?php echo plugins_url('/profit-button/images/step1.png'); ?>"/>
	<p>After your sign in, you can see "create" button in left sidebar.</p>
	<img style="width: 90%; height: auto;" src="<?php echo plugins_url('/profit-button/images/step2.png'); ?>"/>
	<p></p>
	<img style="width: 90%; height: auto;" src="<?php echo plugins_url('/profit-button/images/step3.png'); ?>"/>
	<img style="width: 90%; height: auto;" src="<?php echo plugins_url('/profit-button/images/step4.png'); ?>"/>
	<img style="width: 90%; height: auto;" src="<?php echo plugins_url('/profit-button/images/step5.png'); ?>"/>
</div>
</div>

</div>
</div>




<div class="postbox-container" id="main-container" style="width:24%;">
							<div id="left-sortables" class="meta-box-sortables ui-sortable"><div id="dashboard_right_now" class="postbox ">
<div class="handlediv" title="Нажмите, чтобы переключить"><br></div>
<h3 class="hndle"><span>Video</span></h3>
<div class="inside" style="padding-top: 0px !important;">
</div>
</div>
</div>
</div>





</div>
</div>
</div>
</div>
	
	
	
<?php 
}
?>
