<?php
/**
 * Plugin Name: Profit Button
 * Plugin URI: http://probtn.com
 * Description: Profit Button is an interactive element that used to show custom content inside your application. If the button is tapped then the popup with Browser would open. The url in the Browser is set using settings on our server.
 * Version: 1.2
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
	
	wp_register_script( 'probtn-script', 'https://pizzabtn.herokuapp.com/javascripts/probtn.js', array( 'jquery' ));
    //wp_register_script( 'probtn-script', plugins_url('probtn.js', __FILE__), array( 'jquery' ));
	wp_enqueue_script( 'probtn-script' );
	
	//wp_register_script( 'jquerypep-script', plugins_url('https://pizzabtn.herokuapp.com/javascripts/jquery.pep.min.js', __FILE__) );
	wp_register_script( 'jquerypep-script', 'https://pizzabtn.herokuapp.com/javascripts/jquery.pep.min.js', array( 'jquery' ));
	wp_enqueue_script( 'jquerypep-script' );
	
	$mainStyleCss = parse_url('https://pizzabtn.herokuapp.com/stylesheets/probtn.css');
	//$jqueryPepPath = parse_url(plugins_url('libs/jquery.pep.min.js', __FILE__));
    $jqueryPepPath = "https://pizzabtn.herokuapp.com/javascripts/jquery.pep.min.js";
	
    $options = get_option( 'probtn_settings' ); 

    function urlify($key, $val) {
        return urlencode($key) . '=' . urlencode($val);
    }

    $url = '';
    $url .= implode('&amp;', array_map('urlify', array_keys($options), $options));

	wp_register_script( 'probtn-start-script', plugins_url("start_probtn.php?mainStyleCss=".$mainStyleCss["path"]."&jqueryPepPath=".$jqueryPepPath["path"]."&".$url, __FILE__), array( 'jquery' ) );
	wp_enqueue_script( 'probtn-start-script' );
}


add_action('admin_init', 'probtn_register_settings');

function probtn_register_settings(){
    //this will save the option in the wp_options table as 'wpse61431_settings'
    //the third parameter is a function that will validate your input values
    register_setting('probtn_settings', 'probtn_settings', 'probtn_settings_validate');
}

function probtn_settings_validate($args){
    //$args will contain the values posted in your settings form, you can validate them as no spaces allowed, no special chars allowed or validate emails etc.
    //if(!isset($args['probtn_email']) || !is_email($args['probtn_email'])){
        //add a settings error because the email is invalid and make the form field blank, so that the user can enter again
        //$args['probtn_email'] = '';
        //add_settings_error('probtn_settings', 'probtn_invalid_email', 'Please enter a valid email!', $type = 'error');   
    //}
    //make sure you return the args
    return $args;
}

/** Step 2 (from text above). */
add_action( 'admin_menu', 'probtn_menu' );

/** Step 1. */
function probtn_menu() {    
    add_menu_page( 'Floating Button', 'Floating Button', 'manage_options', 'profit_button_page', 
    'probtn_options', plugins_url( 'profit-button/images/profit_button_icon_3_1.png' ), 166 ); 
}

add_action('admin_notices', 'probtn_admin_notices');
function probtn_admin_notices(){
   settings_errors();
}



/** Step 3. */
function probtn_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	?>

<style>
    #wpfooter {
        display: none;
    }
    
    .mp6-sg-example {
	padding: 1em;
	margin: 10px 0 20px;
	background: white;

	-webkit-box-shadow: 0px 1px 1px 0px rgba(0,0,0,0.1);
	box-shadow: 0px 1px 1px 0px rgba(0,0,0,0.1);
}

.mp6-sg-example h3 {
	margin-top: 0;
}

.mp6-table {
	width: 100%;
}

.mp6-table th, .mp6-table td {
	border-bottom: 1px solid #eee;
}

.mp6-table .sg-example-code {
	width: 25%;
}
.mp6-table .sg-example-descrip {
	width: 75%;
}

.mp6-table td span {
	display: block;
	padding: 5px 10px;
}

/*jQuery UI demo page css*/
.demoHeaders {
	margin-top: 2em;
	clear: both;
}
#dialog_link {
	padding: .4em 1em .4em 20px;
	text-decoration: none;
	position: relative;
}
#dialog_link span.ui-icon {
	margin: 0 5px 0 0;
	position: absolute;
	left: .2em;
	top: 50%;
	margin-top: -8px;
}
ul#icons {
	margin: 0;
	padding: 0
}
ul#icons li {
	margin: 2px;
	position: relative;
	padding: 4px 0;
	cursor: pointer;
	float: left;
	list-style: none;
}
ul#icons span.ui-icon {
	float: left;
	margin: 0 4px
}
.columnbox {
	height: 150px;
	width: 48%;
	float:left;
	margin-right: 1%;
}
#eq span {
 	height:120px;
 	float:left;
 	margin:15px;
 }
.buttonset {
	margin-bottom: 5px;
}
#toolbar {
	padding: 10px 4px;
}
.ui-widget-overlay {
	position: absolute;
} /* fixed doesn't actually work? */
</style>

	<div class="wrap">
	<div style="clear: both; width: 95%; display: inline-block;
	height: 110px;">
		<img alt="logo" style="width: 100px; height: auto; display: inline-block; float: left;" 
			src="<?php echo plugins_url('/profit-button/images/logo.png'); ?>"/>
		<h1 style="line-height: 70px; margin-left: 20px; display: inline-block;width: auto;">Floating Button</h1>
	</div>
	

    <div class="mp6-sg-example">
		<h3>Button settings</h3>
    <form action="options.php" method="post"><?php
        settings_fields( 'probtn_settings' );
        do_settings_sections( __FILE__ );

        //get the older values, wont work the first time
        $options = get_option( 'probtn_settings' ); 
        if (($options['source']==null) || ($options['source']=='')) {
            $options['source'] = 'probtn.com';
        };

        if (($options['state']==null) || ($options['state']=='')) {
            $options['state'] = 'on';
        };

        if ($options['source'] == 'probtn.com') {
        ?>
        <script>
            jQuery(document).ready(
            function ($) {
                $(".localSettings").hide(200);
            });
        </script>
        <?php
        };
        ?>
        <table class="form-table">

            <tr>
                <th scope="row">Button state</th>
                <td>
                    <fieldset>
                        <label>                          
                            <input type="radio" name="probtn_settings[state]" class=""
                                value="on"<?php checked( 'on' == $options['state'] ); ?> />
                            <span class="localSettings_item description">On</span>
                        </label>
                        <br/>
                        <label>                          
                            <input type="radio" name="probtn_settings[state]" class=""
                                value="off"<?php checked( 'off' == $options['state'] ); ?> />                            
                            <span class="description probtnSettings_item">Off</span>
                        </label>
                    </fieldset>
                </td>
            </tr>

            <tr>
                <th scope="row">Button settings source</th>
                <td>
                    <fieldset>
                        <label>                          
                            <input type="radio" name="probtn_settings[source]" class="localSettings_item"
                                value="local settings"<?php checked( 'local settings' == $options['source'] ); ?> />
                            <span class="localSettings_item description">Local settings</span>
                        </label>
                        <br/>
                        <label>                          
                            <input type="radio" name="probtn_settings[source]" class="probtnSettings_item"
                                value="probtn.com"<?php checked( 'probtn.com' == $options['source'] ); ?> />                            
                            <span class="description probtnSettings_item">Settings from probtn.com</span>
                        </label>
                    </fieldset>
                </td>
            </tr>

            <tr class="localSettings">
                <th scope="row">Content url</th>
                <td>
                    <fieldset>
                        <label>
                            <input name="probtn_settings[probtn_contenturl]" type="text" id="probtn_contenturl" 
                            value="<?php echo (isset($options['probtn_contenturl']) && $options['probtn_contenturl'] != '') ? $options['probtn_contenturl'] : ''; ?>"/>
                            <br />
                            <span class="description">Please enter content url.</span>
                        </label>
                    </fieldset>
                </td>
            </tr>     
            

            <tr class="localSettings">
                <th scope="row">Hint Text</th>
                <td>
                    <fieldset>
                        <label>
                            <input name="probtn_settings[probtn_hinttext]" type="text" id="probtn_hinttext" 
                            value="<?php echo (isset($options['probtn_hinttext']) && $options['probtn_hinttext'] != '') ? $options['probtn_hinttext'] : ''; ?>"/>
                            <br />
                            <span class="description">Please enter button hint text.</span>
                        </label>
                    </fieldset>
                </td>
            </tr>

            <tr class="localSettings">
                <th scope="row">Button image</th>
                <td>
            <div class="controls">
                                        <label class="radio inline">
                                            <input type="radio" name="probtn_settings[probtn_image]" value="http://pizzabtn.herokuapp.com/Shop_button_grey_norm.png"<?php checked( 'http://pizzabtn.herokuapp.com/Shop_button_grey_norm.png' == $options['probtn_image'] ); ?>/>
                                        </label>
                                        <img alt="cart button" src="http://pizzabtn.herokuapp.com/Shop_button_grey_norm.png" width="50">
                                        &nbsp;&nbsp;
                                        <label class="radio inline">
                                            <input onclick="" type="radio" name="probtn_settings[probtn_image]" value="http://itsbeta.com/en/wp-content/uploads/sites/3/2013/08/Chart_button_grey_norm.png"<?php checked( 'http://itsbeta.com/en/wp-content/uploads/sites/3/2013/08/Chart_button_grey_norm.png' == $options['probtn_image'] ); ?>/>
                                        </label>
                                        <img alt="grey button" src="http://itsbeta.com/en/wp-content/uploads/sites/3/2013/08/Chart_button_grey_norm.png" width="50">
                                        &nbsp;&nbsp;
                                        <label class="radio inline">
                                            <input onclick="" type="radio" name="probtn_settings[probtn_image]" value="http://itsbeta.com/wp-content/uploads/2013/08/Shop_button_pizza_norm.png"<?php checked( 'http://itsbeta.com/wp-content/uploads/2013/08/Shop_button_pizza_norm.png' == $options['probtn_image'] ); ?>/>
                                        </label>
                                        <img alt="pizza button" src="http://itsbeta.com/wp-content/uploads/2013/08/Shop_button_pizza_norm.png" width="50">
                                        &nbsp;&nbsp;
                                        <label class="radio inline">
                                            <input onclick="" type="radio" name="probtn_settings[probtn_image]" value="http://admin.probtn.com/eqwid_btn_nonpress.png"<?php checked( 'http://admin.probtn.com/eqwid_btn_nonpress.png' == $options['probtn_image'] ); ?>/>
                                        </label>
                                        <img alt="eqwid" src="http://admin.probtn.com/eqwid_btn_nonpress.png" width="50">
                                        &nbsp;&nbsp;
                                        or
                                        &nbsp;&nbsp;
                                        <label class="radio inline">
                                            <input id="customImageRadioButton" onclick="jQuery('#customImageRadioButton').val(jQuery('#custom_image_text').val());" name="probtn_settings[probtn_image]"  
                                            type="radio" name="button_image_radio" value="<?php echo (isset($options['probtn_custom_image']) && $options['probtn_custom_image'] != '') ? $options['probtn_custom_image'] : ''; ?>"<?php checked( $options['probtn_custom_image'] == $options['probtn_image'] ); ?>>
                                        </label>
                                        &nbsp;&nbsp;
                                        <input onclick="" type="text" id="custom_image_text" name="probtn_settings[probtn_custom_image]" placeholder="Your image URL" value="<?php echo (isset($options['probtn_custom_image']) && $options['probtn_custom_image'] != '') ? $options['probtn_custom_image'] : ''; ?>">
                                    </div>
                    </td>
                </tr>

        </table>
        <input type="submit" value="Save settings" class="button-primary" />
    </form>
    </div>
	
	<script src='https://pizzabtn.herokuapp.com/javascripts/jquery.pep.min.js'></script>
	<script src='https://pizzabtn.herokuapp.com/javascripts/jquery.fancybox.js'></script>
	<script src='https://pizzabtn.herokuapp.com/javascripts/probtn.js'></script>
	<script>
     jQuery(document).ready(
         function ($) {
             $(".probtnSettings_item").click(function () {
                 $(".localSettings").hide(200);
             });
             $(".localSettings_item").click(function () {
                 $(".localSettings").show(200);
             });
             $(document).StartButton(
             {
             'domain': 'example.com',
             'mainStyleCss':'https://pizzabtn.herokuapp.com/stylesheets/probtn.css'
             });
         });
	</script>

    <div class="mp6-sg-example">
		<h3>About</h3>
        <p>Profit button is a new way to add survey, ads or some other additional content without adding any changes to your design.</p>
	    <p>Functionality is implemented like floating button above your site, and after clicking on button would be opened additional modal window with nessesary content.</p>
	    <p>For better usability users can use admin panel with settings and button targeting, and also some detailed statistics and analytics.</p>
    </div>

    <div class="mp6-sg-example" id="">
		<h3>Setup</h3>
	    <a style="margin: 0 auto; text-align: center;" href="http://bit.ly/profitbutton-wordpress" target="_blank"><button>Sign up</button></a><br/>	
        <p>First of all you should open <a href="http://bit.ly/profitbutton-wordpress" target="_blank">http://admin.probtn.com</a> and enter (or sign up if you havn't account).</p>
	    <img alt="step1" style="width: 90%; height: auto;" src="<?php echo plugins_url('/profit-button/images/step1.png'); ?>"/>
	    <p>After your sign in, you can see "create" button in left sidebar.</p>
	    <img alt="step2" style="width: 90%; height: auto;" src="<?php echo plugins_url('/profit-button/images/step2.png'); ?>"/>
	    <p></p>
	    <img alt="step3" style="width: 90%; height: auto;" src="<?php echo plugins_url('/profit-button/images/step3.png'); ?>"/>
	    <img alt="step4" style="width: 90%; height: auto;" src="<?php echo plugins_url('/profit-button/images/step4.png'); ?>"/>
	    <img alt="step5" style="width: 90%; height: auto;" src="<?php echo plugins_url('/profit-button/images/step5.png'); ?>"/>
    </div>

	</div>


	
<!--<div id="dashboard-widgets-container" class="ngg-overview">
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
	<a style="margin: 0 auto; text-align: center;" href="http://bit.ly/profitbutton-wordpress" target="_blank">
		<button>Sign up</button>
	</a><br/>
	
<p>First of all you should open <a href="http://bit.ly/profitbutton-wordpress" target="_blank">http://admin.probtn.com</a> and enter (or sign up if you havn't account).</p>
	<img alt="step1" style="width: 90%; height: auto;" src="<?php echo plugins_url('/profit-button/images/step1.png'); ?>"/>
	<p>After your sign in, you can see "create" button in left sidebar.</p>
	<img alt="step2" style="width: 90%; height: auto;" src="<?php echo plugins_url('/profit-button/images/step2.png'); ?>"/>
	<p></p>
	<img alt="step3" style="width: 90%; height: auto;" src="<?php echo plugins_url('/profit-button/images/step3.png'); ?>"/>
	<img alt="step4" style="width: 90%; height: auto;" src="<?php echo plugins_url('/profit-button/images/step4.png'); ?>"/>
	<img alt="step5" style="width: 90%; height: auto;" src="<?php echo plugins_url('/profit-button/images/step5.png'); ?>"/>
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
</div>-->
	
</div>
	
<?php 
}
?>
