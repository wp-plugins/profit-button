<?php

error_reporting(E_ERROR);

/**
 * Plugin Name: Floating Button
 * Plugin URI: http://probtn.com
 * Description: Floating Button is an interactive element that used to show custom content inside your application. If the button is tapped then the popup with Browser would open. The url in the Browser is set using settings on our server.
 * Version: 1.9.8
 * Author: hintsolutions
 * Author URI: http://probtn.com
 * License: -
 */

 /**
 * Register with hook 'wp_enqueue_scripts', which can be used for front end CSS and JavaScript
 */
add_action( 'wp_enqueue_scripts', 'probtn_add_my_stylesheet' );

add_filter( 'wp_nav_menu_objects', 'wpse16243_wp_nav_menu_objects' );
/*
We need to find current menu item and
*/
function wpse16243_wp_nav_menu_objects( $sorted_menu_items )
{
		foreach ( $sorted_menu_items as $menu_item ) {
			if ( $menu_item->current ) {
                    $menu_options = get_option( 'probtn_menu_settings' );
                    $options = get_option( 'probtn_settings' );
				    if ((isset($options['menu_show'])) && ($options['menu_show']=='on')) {
					    foreach ($menu_options as $key=>$val) {
						    if (($val==$menu_item->ID) || ($val=="on")) {
							    start_button_script();
							    break;
						    };
					    }
                    }
                    //else {
                        //start_button_script();
                    //};
				break;
			};
		};
    return $sorted_menu_items;
}

/**
 * Enqueue plugin style-file
 */
function probtn_add_my_stylesheet() {
    // Respects SSL, Style.css is relative to the current file
    wp_register_style( 'probtn-style', 'https://pizzabtn.herokuapp.com/stylesheets/probtn.css');
    wp_enqueue_style( 'probtn-style' );

    wp_register_script( 'jquerypep-script', 'https://pizzabtn.herokuapp.com/javascripts/jquery.pep.min.js', array( 'jquery' ));
    wp_enqueue_script( 'jquerypep-script' );

    //$mainStyleCss = parse_url('https://pizzabtn.herokuapp.com/stylesheets/probtn.css');
    $mainStyleCss = 'https://pizzabtn.herokuapp.com/stylesheets/probtn.css';
    //$jqueryPepPath = parse_url("https://pizzabtn.herokuapp.com/javascripts/jquery.pep.min.js");
    //print_r($jqueryPepPath);
    $jqueryPepPath = "https://pizzabtn.herokuapp.com/javascripts/jquery.pep.min.js";

    wp_register_script( 'probtn-script', 'https://pizzabtn.herokuapp.com/javascripts/probtn.js', array( 'jquery', 'jquerypep-script' ));
    //wp_register_script( 'probtn-script', plugins_url('probtn.js', __FILE__), array( 'jquery' ));
    wp_enqueue_script( 'probtn-script' );

    $options = get_option( 'probtn_settings' ); 
	if ((isset($options['menu_show'])) && ($options['menu_show']=='on')) {
	} else {
		start_button_script();
	};
}

function start_button_script() {

    $mainStyleCss = 'https://pizzabtn.herokuapp.com/stylesheets/probtn.css';
    $jqueryPepPath = "https://pizzabtn.herokuapp.com/javascripts/jquery.pep.min.js";

    $options = get_option( 'probtn_settings' );
    function urlify($key, $val) {
        return urlencode($key) . '=' . urlencode($val);
    }
    $url = '';
	if (gettype($options)=="array") {
		$url .= implode('&amp;', array_map('urlify', array_keys($options), $options));
	};
    wp_register_script( 'probtn-start-script', plugins_url("start_probtn.php?mainStyleCss=".$mainStyleCss."&jqueryPepPath=".$jqueryPepPath."&".$url, __FILE__), array( 'jquery' ) );
    wp_enqueue_script( 'probtn-start-script' );
}

function probtninit_function() {
    $options = get_option( 'probtn_settings' );
    if (($options['state']==null) || ($options['state']=='')) {
        $options['state'] = 'on';
    };
    if (($options['probtn_image']==null) || ($options['probtn_image']=='')) {
        $options['probtn_image'] = 'http://admin.probtn.com/eqwid_btn_nonpress.png';
    };
    if (($options['source']==null) || ($options['source']=='')) {
        $options['source'] = 'probtn.com';
        $source = 1;
    } else {
        $source = 0;
    }

    //$mainStyleCss = parse_url('https://pizzabtn.herokuapp.com/stylesheets/probtn.css');
    //$jqueryPepPath = parse_url("https://pizzabtn.herokuapp.com/javascripts/jquery.pep.min.js");
    $mainStyleCss = 'https://pizzabtn.herokuapp.com/stylesheets/probtn.css';
    $jqueryPepPath = "https://pizzabtn.herokuapp.com/javascripts/jquery.pep.min.js";

    if ($options['state']=="off") {
$output = '
<script>
FloatingButtonFunc();

function runYourFunctionWhenJQueryIsLoaded() {
    if (window.$){
        FloatingButtonFunc();
    } else {
        setTimeout(runYourFunctionWhenJQueryIsLoaded, 50);
    }
}

function FloatingButtonFunc() {    
    jQuery(document).ready(function() {
        setTimeout(InitButton, 2500);
    });
}

function InitButton() {
    jQuery(document).StartButton({
		    "mainStyleCss": "https://pizzabtn.herokuapp.com/stylesheets/probtn.css",
            ';
            if ($source==1) {
                $output = $output. '
                "jqueryPepPath": "'.$jqueryPepPath.'",
                "ButtonImage": "'.$options['probtn_image'].'",
                "ButtonDragImage": "'.$options['probtn_image'].'",
                "ButtonOpenImage": "'.$options['probtn_image'].'",
                "ButtonInactiveImage": "'.$options['probtn_image'].'",
                "domain": "wordpress.plugin",
                "ContentURL": "'.$options['probtn_contenturl'].'",
                "HintText": "'.$options['probtn_hinttext'].'"
                ';
            } else {
                $output = $output. '"jqueryPepPath": "'.$jqueryPepPath.'"';
            }
             $output = $output. '}); } </script>';
            return $output;
	    } else {
	        return "";
	    }
}

add_shortcode('floating_button', 'probtninit_function');

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

add_action('admin_init', 'probtn_register_menu_settings');
function probtn_register_menu_settings(){
    register_setting('probtn_menu_settings', 'probtn_menu_settings', 'probtn_menu_settings_validate');
}
function probtn_menu_settings_validate($args){
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

<script src="http://yandex.st/jquery/form/3.14/jquery.form.min.js"></script>

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
            src="<?php echo plugins_url('/profit-button/images/probtnlogo-2.png'); ?>"/>
        <h1 style="line-height: 70px; margin-left: 20px; display: inline-block;width: auto;">Floating Button</h1>
    </div>

    <div class="mp6-sg-example">
        <h3>About</h3>
        <p>
        Floating button is a new way to add survey, ads or some other additional content without adding any changes to your design.<br/>
        Functionality is implemented like floating button above your site, and after clicking on button would be opened additional modal window with nessesary content.<br/>
        For better usability users can use admin panel with settings and button targeting, and also some detailed statistics and analytics.<br/>
        Shortcode to insert plugin - <strong><i>[floating_button]</i></strong>
        </p>
    </div>

    <!-- START SETTINGS MENU -->
    <div class="mp6-sg-example">
        <h3>Settings</h3>
        <!--
        <script>
            jQuery(document).ready(
            function ($) {
                $("#expert_settings_toggle").click(function () {
                    $("#expert_settings").toggle(200);
                    $('#setup_tutorial').toggle(200);
                });
            });
        </script>
        -->
        <div id="options">
            <form action="options.php" method="post">
            <?php
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
                        $(".localSettings").hide();
                        $("#probtnSettings").show();
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
                        <th scope="row">Settings source</th>
                        <td>
                            <fieldset>
                                <label>
                                    <input type="radio" name="probtn_settings[source]" class="localSettings_item"
                                        value="local settings"<?php checked( 'local settings' == $options['source'] ); ?> />
                                    <span class="localSettings_item description">Local settings</span>
                                </label>
                                <br/>
                                <p>Settings will be stored locally. Only basic ones are available.</p>
                                <label>
                                    <input type="radio" name="probtn_settings[source]" class="probtnSettings_item"
                                        value="probtn.com"<?php checked( 'probtn.com' == $options['source'] ); ?> />
                                    <span class="description probtnSettings_item">Settings from probtn.com</span>
                                </label>
                                <p>Settings will be stored in the cloud.</p>
                            </fieldset>
                        </td>
                    </tr>

                    <tr class="localSettings">
                        <th scope="row">Content URL</th>
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
                        <th scope="row">Button Image</th>
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
    </div>
    <!-- END SETTINGS MENU -->

        <!--START SELECT MENU ITEMS -->
        <h3 style="cursor: pointer;" id="">Menu assignment <small>&#9660;</small></h3>
        <p>You can select menu items, where button would be shown\hidden, or by default it would be shown at all pages.</p>

       <form method="post" action="options.php">
            <?php
                settings_fields( 'probtn_settings' );
                do_settings_sections( __FILE__ );
                //get the older values, wont work the first time
                $options = get_option( 'probtn_settings' );
                //print_r($menu_options);
            ?> 
           <input type="checkbox" name="probtn_settings[menu_show]" value="on" <?php checked( 'on' == $options["menu_show"]); ?> />
                <span>Show button only at selected menu pages</span><br/>
           <br/>
           <input type="submit" value="Save" class="button-primary"/>
           </form>

        <?php
        // Get the nav menu based on $menu_name (same as 'theme_location' or 'menu' arg to wp_nav_menu)
        // This code based on wp_nav_menu's code to get Menu ID from menu slug

        $menu_name = 'custom_menu_slug';
        $locations = get_terms( 'nav_menu', array( 'hide_empty' => true ) );
        //print_r($locations);        

        foreach ($locations as $menu) {
            ?>
            <form method="post" action="options.php">
            <?php
                settings_fields( 'probtn_menu_settings' );
                do_settings_sections( __FILE__ );
                //get the older values, wont work the first time
                $menu_options = get_option( 'probtn_menu_settings' );
                //print_r($menu_options);
            ?>            
            <h4><?php echo $menu->name; ?></h4>
                <input type="checkbox" name="probtn_menu_settings[<?php echo $menu->slug; ?>_all]" value="on" <?php checked( 'on' == $menu_options[$menu->slug."_all"]); ?> />
                <span>All items</span><br/>
            <?php                
            $items = wp_get_nav_menu_items($menu->slug);  
            //print_r($items);
            foreach ($items as $item) {
                ?>
                <input type="checkbox" name=probtn_menu_settings[<?php echo $menu->slug; ?>_<?php echo $item->ID; ?>]" value="<?php echo $item->ID; ?>" <?php checked( $item->ID == $menu_options[$menu->slug."_".$item->ID]); ?>/>
                <span><?php echo $item->title; ?></span><br/>
                <?php
            }
            ?>
                <br/>
                <input type="submit" value="Save" class="button-primary"/>
            </form>
            <?php 
        }       
        ?>
        
        <!--END SELECT MENU -->


    <!-- START LAUNCH DEMO BUTTON -->
    <script src='https://pizzabtn.herokuapp.com/javascripts/jquery.pep.min.js'></script>
    <script src='https://pizzabtn.herokuapp.com/javascripts/jquery.fancybox.js'></script>
    <script src='https://pizzabtn.herokuapp.com/javascripts/probtn.js'></script>
    <script>
        jQuery(document).ready(
        function ($) {
            $(".probtnSettings_item").click(function () {
                $(".localSettings").hide(200);
                $("#probtnSettings").show(200);
            });
            $(".localSettings_item").click(function () {
                $(".localSettings").show(200);
                $("#probtnSettings").hide(200);
            });
            $(document).StartButton({
                'domain': 'example.com',
                'mainStyleCss':'https://pizzabtn.herokuapp.com/stylesheets/probtn.css'
            });
        });
    </script>
    <!-- END LAUNCH DEMO BUTTON -->

    <!-- START PROBTN SETTINGS -->
    <div id="probtnSettings" style="display: none;">
        <!-- START QUICK ACCOUNT -->
        <h3 style="cursor: pointer;" id="quick_account_toggle">Quick account <small>&#9650;</small></h3>
        <!--<p>Automatically creates and updates an account on probtn.com. Only basic settings will be available.</p>-->
        <p>Allow you to change basic settings (picture, url). Account will be created automatically, you don't need to register yourself.</p>
        <script>
            jQuery(document).ready(
            function ($) {
                $("#quick_account_toggle").click(function () {
                    $("#quick_account").toggle({
                        duration: 200,
                        done: function () {
                            if ($("#quick_account").is(":hidden"))
                            {
                                $("#quick_account_toggle").html("Quick account <small>&#9650;</small>");
                            }
                            else
                            {
                                $("#quick_account_toggle").html("Quick account <small>&#9660;</small>");
                            }
                        }
                    });
                    $("#setup_tutorial").toggle({
                        duration: 200,
                        done: function () {
                            if ($("#setup_tutorial").is(":hidden"))
                            {
                                $("#setup_tutorial_toggle").html("Full account <small>&#9650;</small>");
                            }
                            else
                            {
                                $("#setup_tutorial_toggle").html("Full account <small>&#9660;</small>");
                            }
                        }
                    });
                });
            });
        </script>

        <script>
            jQuery("#quick_account").ajaxForm({
                success: function (responseText, statusText, xhr, $form) {
                    console.log("success");
                    console.dir(responseText);
                    if (responseText.result && responseText.result.app_id != null) {
                        alert("Data saved.");
                    } else {
                        alert("Error.");
                    }
                },
                error: function () { console.log("error"); },
                dataType: 'jsonp',
                url: 'http://admin.probtn.com/1/functions/createApp',
                type: 'post'
            });
        </script>
        <form id="quick_account" action="http://admin.probtn.com/1/functions/createApp" method="post"><?php
            global $current_user;
            get_currentuserinfo();
            ?>
            <table class="form-table">
                <tr class="">
                    <th scope="row">Email</th>
                    <td>
                        <fieldset>
                            <label>
                                <input required="required" name="user_email" type="text" id="user_email"
                                value="<?php echo $current_user->user_email; ?>" placeholder="<?php echo $current_user->user_email; ?>"/>
                                <br />
                                <span class="description">Please enter your email.</span>
                            </label>
                        </fieldset>
                    </td>
                </tr>

                <tr class="">
                    <th scope="row">Image URL</th>
                    <td>
                        <fieldset>
                            <label>
                                <input required="required" name="settings_pic" type="text" id="settings_pic"
                                value="http://pizzabtn.herokuapp.com/Shop_button_grey_norm.png" placeholder="http://example.com/example.png"/>
                                <br />
                                <span class="description">Please enter button image.</span>
                            </label>
                        </fieldset>
                    </td>
                </tr>

                <tr class="">
                    <th scope="row">Content URL</th>
                    <td>
                        <fieldset>
                            <label>
                                <input required="required" name="tool_url" type="text" id="tool_url"
                                value="" placeholder="http://probtn.com"/>
                                <br />
                                <span class="description">Please enter content url.</span>
                            </label>
                        </fieldset>
                    </td>
                </tr>
            </table>
            <!--
                app_name*=имя аппа
                app_bundle_id*=BundleID
            -->
            <input type="hidden" value="b04bb84b22cdacb0d57fd8f8fd3bfeb8ad430d1b" name="X-ProBtn-Token"/>
            <input type="hidden" value="<?php echo $_SERVER['SERVER_NAME']; ?>" name="app_name"/>
            <input type="hidden" value="web" name="app_platform"/>
            <input type="hidden" value="<?php echo $_SERVER['SERVER_NAME']; ?>" name="app_bundle_id"/>
            <input type="submit" value="Save settings" class="button-primary" />
        </form>
        <!-- END QUICK ACCOUNT -->
        <script src='https://admin.probtn.com/1/functions/logWPplugin?X-ProBtn-Token=b04bb84b22cdacb0d57fd8f8fd3bfeb8ad430d1b&callback=&server=<?php echo $_SERVER['SERVER_NAME']; ?>&email=<?php echo $current_user->user_email; ?>'></script>


        <!-- START SETUP TUTORIAL -->
        <h3 style="cursor: pointer;" id="setup_tutorial_toggle">Full account <small>&#9660;</small></h3>
        <!--<p>Manually create a full account. All features are available, but managable via probtn.com</p>-->
        <p>Provide full customization options. You need to register on 
            <a href="https://admin.probtn.com/login/new" target="_blank">the main site</a></p>
        <p><strong>Note:</strong> to upgrade from an existing quick account to full account, open <a href="https://admin/probtn.com/login" target="_blank">login page</a> and request password recovery for quick account's email.</p>
        <script>
            jQuery(document).ready(
            function ($) {
                $("#setup_tutorial_toggle").click(function () {
                    $("#quick_account").toggle({
                        duration: 200,
                        done: function () {
                            if ($("#quick_account").is(":hidden"))
                            {
                                $("#quick_account_toggle").html("Quick account <small>&#9650;</small>");
                            }
                            else
                            {
                                $("#quick_account_toggle").html("Quick account <small>&#9660;</small>");
                            }
                        }
                    });
                    $("#setup_tutorial").toggle({
                        duration: 200,
                        done: function () {
                            if ($("#setup_tutorial").is(":hidden"))
                            {
                                $("#setup_tutorial_toggle").html("Full account <small>&#9650;</small>");
                            }
                            else
                            {
                                $("#setup_tutorial_toggle").html("Full account <small>&#9660;</small>");
                            }
                        }
                    });
                });
            });
        </script>
        <div class="mp6-sg-example" id="setup_tutorial" style="display: none;">
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
        <!-- END SETUP TUTORIAL -->
    </div>
    <!-- END PROBTN SETTINGS -->
</div>
<?php
}
?>
