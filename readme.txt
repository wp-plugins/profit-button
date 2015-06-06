=== Floating button ===
Contributors: hintsolutions
Donate link: -
Tags: widget, profit button, floating button, interctive element, custom, plugin, servey, advertising, monetization, probtn, button, feedback, analytics, vote, voting, content, feed, marketing
Requires at least: 3.3
Tested up to: 3.5.1
Stable tag: 1.9.11
License: Licenced under LGPL
License URI: http://opensource.org/licenses/LGPL-3.0

Floating button for you site or blog, which can give you opportunity to make a survey, show ads and collect some statistics about user.

== Description ==

Floating Button is a new way to add survey, ads or some other additional content without adding any changes to your design.

Functionality is implemented like floating button above your site, and after clicking on button would be opened additional modal window with nessesary content.

For better usability users can use admin panel with settings and button targeting, and also some detailed statistics and analytics.

Shortcode to insert plugin - [floating_button]

== Installation ==

1. Upload `profit-button` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Register or login at http://admin.probtn.com/ and add your site in apps list, to get opportunity to set params for floating button.

== FAQ ==

= How can I use Local Settings? =

Local Settings source allows you to create a basic Floating button without the need to create an account on admin.probtn.com.
Settings will be saved locally in Wordpress. In this mode available settings include Content URL, Hint Text and Button Image.


= How to change Content Size? =

You can change Content Size only if you are using probtn.com as Button settings source
and you have already created an account and application on admin.probtn.com
Open your application and scroll down to Button Settings box.
There you find Content Size W(idth) and H(eight) settings. These values are set in pixels.

= How to make button visible if it is being opened in iframe or through another button? =

By default when a button is viewed via another button or iframe, it is hidden to prevent recursion.
You can change this option only if you are using full account (signed up on admin.probtn.com).
In this case, open your application, scroll down to "Button settings" box, open "Fine tuning tab" and search for "Hide in frame" parameter.
Change its value to "false" and click Save.

== Frequently asked questions ==

= How can I use Local Settings? =
Local Settings source allows you to create a basic Floating button without the need to create an account on admin.probtn.com.
Settings will be saved locally in Wordpress. In this mode available settings include Content URL, Hint Text and Button Image.

= How to change Content Size? =
You can change Content Size only if you are using probtn.com as Button settings source
and you have already created an account and application on admin.probtn.com
Open your application and scroll down to Button Settings box.
There you find Content Size W(idth) and H(eight) settings. These values are set in pixels.

= How to make button visible if it is being opened in iframe or through another button? =

By default when a button is viewed via another button or iframe, it is hidden to prevent recursion.
You can change this option only if you are using full account (signed up on admin.probtn.com).
In this case, open your application, scroll down to "Button settings" box, open "Fine tuning tab" and search for "Hide in frame" parameter.
Change its value to "false" and click Save.

= How to show button only on some nessesary pages? =

You need to set "Button state" to off and add shortcode [floating_button] at nessesary pages, where you'd like to see button.

== Screenshots ==

1. Gif example
2. Button at page
3. Opened content after clicking on button
4. Close area when we move button


== Changelog ==

= 1.9.10=
Fixed address in description

= 1.9.9=
Updated pathes for probtn script and styles

= 1.9.8=
Added options check

= 1.9.7=
Fixed jquery.pep.js path for start_button init script

= 1.9.6 =
Fixed shortcode problems - [floating_button]

= 1.9.5 =
Added shortcode [floating_button] (require button state set to off) to add button only on nessesary pages.

= 1.9.4 =
Menu settings are shown and for local, and for remote settings.

= 1.9.3 =
Added timeout before button would be shown to prevent some conflicts with other users plugins.

= 1.9.2 =
Updated order of the scripts (dependence of probtn.js from jquery.pep.js) 

= 1.9.1 =
Fixed issue - button isn't showing on site which hasn't menu

= 1.9 =
Added possibility to show button only on specified menu pages (or at all pages).

= 1.8 =
Gather usage statistics

= 1.7 =
Hide button if shown inside another button.

= 1.6 =
Redesign of settings menu

= 1.5 =
Added automatic account creation on probtn.com

Added base functionality of floating button.

== Upgrade notice ==

= 1.6 =
Redesign of settings menu

= 1.5 =
Added automatic account creation on probtn.com

== Arbitrary section 1 ==

