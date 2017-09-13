<?php

defined('ABSPATH') or die;

/*
 * 
 * Require the framework class before doing anything else, so we can use the defined urls and dirs
 *
 */
require_once( dirname( __FILE__ ) . '/options/options.php' );

/*
 * 
 * Add support tab
 *
 */
if ( ! defined('MTS_THEME_WHITE_LABEL') || ! MTS_THEME_WHITE_LABEL ) {
	require_once( dirname( __FILE__ ) . '/options/support.php' );
	$mts_options_tab_support = MTS_Options_Tab_Support::get_instance();
}

/*
 * 
 * Custom function for filtering the sections array given by theme, good for child themes to override or add to the sections.
 * Simply include this function in the child themes functions.php file.
 *
 * NOTE: the defined constansts for urls, and dir will NOT be available at this point in a child theme, so you must use
 * get_template_directory_uri() if you want to use any of the built in icons
 *
 */
function add_another_section($sections){
	
	//$sections = array();
	$sections[] = array(
		'title' => __('A Section added by hook', 'myportfolio' ),
		'desc' => '<p class="description">' . __('This is a section created by adding a filter to the sections array, great to allow child themes, to add/remove sections from the options.', 'myportfolio' ) . '</p>',
		//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
		//You dont have to though, leave it blank for default.
		'icon' => trailingslashit(get_template_directory_uri()).'options/img/glyphicons/glyphicons_062_attach.png',
		//Lets leave this as a blank section, no options just some intro text set above.
		'fields' => array()
	);
	
	return $sections;
	
}//function
//add_filter('nhp-opts-sections-twenty_eleven', 'add_another_section');


/*
 * 
 * Custom function for filtering the args array given by theme, good for child themes to override or add to the args array.
 *
 */
function change_framework_args($args){
	
	//$args['dev_mode'] = false;
	
	return $args;
	
}//function
//add_filter('nhp-opts-args-twenty_eleven', 'change_framework_args');

/*
 * This is the meat of creating the optons page
 *
 * Override some of the default values, uncomment the args and change the values
 * - no $args are required, but there there to be over ridden if needed.
 *
 *
 */

function setup_framework_options(){
	$args = array();

	//Set it to dev mode to view the class settings/info in the form - default is false
	$args['dev_mode'] = false;
	//Remove the default stylesheet? make sure you enqueue another one all the page will look whack!
	//$args['stylesheet_override'] = true;

	//Add HTML before the form
	//$args['intro_text'] = __('<p>This is the HTML which can be displayed before the form, it isnt required, but more info is always better. Anything goes in terms of markup here, any HTML.</p>', 'myportfolio' );

	if ( ! MTS_THEME_WHITE_LABEL ) {
		//Setup custom links in the footer for share icons
		$args['share_icons']['twitter'] = array(
			'link' => 'http://twitter.com/mythemeshopteam',
			'title' => __( 'Follow Us on Twitter', 'myportfolio' ),
			'img' => 'fa fa-twitter-square'
		);
		$args['share_icons']['facebook'] = array(
			'link' => 'http://www.facebook.com/mythemeshop',
			'title' => __( 'Like us on Facebook', 'myportfolio' ),
			'img' => 'fa fa-facebook-square'
		);
	}

	//Choose to disable the import/export feature
	//$args['show_import_export'] = false;

	//Choose a custom option name for your theme options, the default is the theme name in lowercase with spaces replaced by underscores
	$args['opt_name'] = MTS_THEME_NAME;

	//Custom menu icon
	//$args['menu_icon'] = '';

	//Custom menu title for options page - default is "Options"
	$args['menu_title'] = __('Theme Options', 'myportfolio' );

	//Custom Page Title for options page - default is "Options"
	$args['page_title'] = __('Theme Options', 'myportfolio' );

	//Custom page slug for options page (wp-admin/themes.php?page=***) - default is "nhp_theme_options"
	$args['page_slug'] = 'theme_options';

	//Custom page capability - default is set to "manage_options"
	//$args['page_cap'] = 'manage_options';

	//page type - "menu" (adds a top menu section) or "submenu" (adds a submenu) - default is set to "menu"
	//$args['page_type'] = 'submenu';

	//parent menu - default is set to "themes.php" (Appearance)
	//the list of available parent menus is available here: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
	//$args['page_parent'] = 'themes.php';

	//custom page location - default 100 - must be unique or will override other items
	$args['page_position'] = 62;

	//Custom page icon class (used to override the page icon next to heading)
	//$args['page_icon'] = 'icon-themes';

	if ( ! MTS_THEME_WHITE_LABEL ) {
		//Set ANY custom page help tabs - displayed using the new help tab API, show in order of definition
		$args['help_tabs'][] = array(
			'id' => 'nhp-opts-1',
			'title' => __('Support', 'myportfolio' ),
			'content' => '<p>' . sprintf( __('If you are facing any problem with our theme or theme option panel, head over to our %s.', 'myportfolio' ), '<a href="http://community.mythemeshop.com/">'. __( 'Support Forums', 'myportfolio' ) . '</a>' ) . '</p>'
		);
		$args['help_tabs'][] = array(
			'id' => 'nhp-opts-2',
			'title' => __('Earn Money', 'myportfolio' ),
			'content' => '<p>' . sprintf( __('Earn 70%% commision on every sale by refering your friends and readers. Join our %s.', 'myportfolio' ), '<a href="http://mythemeshop.com/affiliate-program/">' . __( 'Affiliate Program', 'myportfolio' ) . '</a>' ) . '</p>'
		);
	}

	//Set the Help Sidebar for the options page - no sidebar by default										
	//$args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'myportfolio' );

	$mts_patterns = array(
		'nobg' => array('img' => NHP_OPTIONS_URL.'img/patterns/nobg.png'),
		'pattern0' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern0.png'),
		'pattern1' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern1.png'),
		'pattern2' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern2.png'),
		'pattern3' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern3.png'),
		'pattern4' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern4.png'),
		'pattern5' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern5.png'),
		'pattern6' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern6.png'),
		'pattern7' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern7.png'),
		'pattern8' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern8.png'),
		'pattern9' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern9.png'),
		'pattern10' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern10.png'),
		'pattern11' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern11.png'),
		'pattern12' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern12.png'),
		'pattern13' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern13.png'),
		'pattern14' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern14.png'),
		'pattern15' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern15.png'),
		'pattern16' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern16.png'),
		'pattern17' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern17.png'),
		'pattern18' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern18.png'),
		'pattern19' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern19.png'),
		'pattern20' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern20.png'),
		'pattern21' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern21.png'),
		'pattern22' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern22.png'),
		'pattern23' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern23.png'),
		'pattern24' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern24.png'),
		'pattern25' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern25.png'),
		'pattern26' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern26.png'),
		'pattern27' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern27.png'),
		'pattern28' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern28.png'),
		'pattern29' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern29.png'),
		'pattern30' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern30.png'),
		'pattern31' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern31.png'),
		'pattern32' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern32.png'),
		'pattern33' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern33.png'),
		'pattern34' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern34.png'),
		'pattern35' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern35.png'),
		'pattern36' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern36.png'),
		'pattern37' => array('img' => NHP_OPTIONS_URL.'img/patterns/pattern37.png'),
		'hbg' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg.png'),
		'hbg2' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg2.png'),
		'hbg3' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg3.png'),
		'hbg4' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg4.png'),
		'hbg5' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg5.png'),
		'hbg6' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg6.png'),
		'hbg7' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg7.png'),
		'hbg8' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg8.png'),
		'hbg9' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg9.png'),
		'hbg10' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg10.png'),
		'hbg11' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg11.png'),
		'hbg12' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg12.png'),
		'hbg13' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg13.png'),
		'hbg14' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg14.png'),
		'hbg15' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg15.png'),
		'hbg16' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg16.png'),
		'hbg17' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg17.png'),
		'hbg18' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg18.png'),
		'hbg19' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg19.png'),
		'hbg20' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg20.png'),
		'hbg21' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg21.png'),
		'hbg22' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg22.png'),
		'hbg23' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg23.png'),
		'hbg24' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg24.png'),
		'hbg25' => array('img' => NHP_OPTIONS_URL.'img/patterns/hbg25.png')
	);

	$sections = array();

	$sections[] = array(
		'icon' => 'fa fa-cogs',
		'title' => __('General Settings', 'myportfolio' ),
		'desc' => '<p class="description">' . __('This tab contains common setting options which will be applied to the whole theme.', 'myportfolio' ) . '</p>',
		'fields' => array(
			array(
				'id' => 'mts_logo',
				'type' => 'upload',
				'title' => __('Logo Image', 'myportfolio' ),
				'sub_desc' => __('Upload your logo using the Upload Button or insert image URL.', 'myportfolio' )
			),
			array(
				'id' => 'mts_favicon',
				'type' => 'upload',
				'title' => __('Favicon', 'myportfolio' ),
				'sub_desc' => sprintf( __('Upload a %s image that will represent your website\'s favicon.', 'myportfolio' ), '<strong>32 x 32 px</strong>' )
			),
			array(
				'id' => 'mts_touch_icon',
				'type' => 'upload',
				'title' => __('Touch icon', 'myportfolio' ),
				'sub_desc' => sprintf( __('Upload a %s image that will represent your website\'s touch icon for iOS 2.0+ and Android 2.1+ devices.', 'myportfolio' ), '<strong>152 x 152 px</strong>' )
			),
			array(
				'id' => 'mts_metro_icon',
				'type' => 'upload',
				'title' => __('Metro icon', 'myportfolio' ),
				'sub_desc' => sprintf( __('Upload a %s image that will represent your website\'s IE 10 Metro tile icon.', 'myportfolio' ), '<strong>144 x 144 px</strong>' )
			),
			array(
				'id' => 'mts_twitter_username',
				'type' => 'text',
				'title' => __('Twitter Username', 'myportfolio' ),
				'sub_desc' => __('Enter your Username here.', 'myportfolio' ),
			),
			array(
				'id' => 'mts_feedburner',
				'type' => 'text',
				'title' => __('FeedBurner URL', 'myportfolio' ),
				'sub_desc' => sprintf( __('Enter your FeedBurner\'s URL here, ex: %s and your main feed (http://example.com/feed) will get redirected to the FeedBurner ID entered here.)', 'myportfolio' ), '<strong>http://feeds.feedburner.com/mythemeshop</strong>' ),
				'validate' => 'url'
			),
			array(
				'id' => 'mts_header_code',
				'type' => 'textarea',
				'title' => __('Header Code', 'myportfolio' ),
				'sub_desc' => wp_kses( __('Enter the code which you need to place <strong>before closing &lt;/head&gt; tag</strong>. (ex: Google Webmaster Tools verification, Bing Webmaster Center, BuySellAds Script, Alexa verification etc.)', 'myportfolio' ), array( 'strong' => '' ) )
			),
			array(
				'id' => 'mts_analytics_code',
				'type' => 'textarea',
				'title' => __('Footer Code', 'myportfolio' ),
				'sub_desc' => wp_kses( __('Enter the codes which you need to place in your footer. <strong>(ex: Google Analytics, Clicky, STATCOUNTER, Woopra, Histats, etc.)</strong>.', 'myportfolio' ), array( 'strong' => '' ) )
			),
			array(
				'id' => 'mts_ajax_search',
				'type' => 'button_set',
				'title' => __('AJAX Quick search', 'myportfolio' ),
				'options' => array( '0' => __( 'Off', 'myportfolio' ), '1' => __( 'On', 'myportfolio' ) ),
				'sub_desc' => __('Enable or disable search results appearing instantly below the search form', 'myportfolio' ),
				'std' => '0'
			),
			array(
				'id' => 'mts_responsive',
				'type' => 'button_set',
				'title' => __('Responsiveness', 'myportfolio' ),
				'options' => array( '0' => __( 'Off', 'myportfolio' ), '1' => __( 'On', 'myportfolio' ) ),
				'sub_desc' => __('MyThemeShop themes are responsive, which means they adapt to tablet and mobile devices, ensuring that your content is always displayed beautifully no matter what device visitors are using. Enable or disable responsiveness using this option.', 'myportfolio' ),
				'std' => '1'
				),
			array(
				'id' => 'mts_shop_products',
				'type' => 'text',
				'title' => __('No. of Products', 'myportfolio' ),
				'sub_desc' => __('Enter the total number of products which you want to show on shop page (WooCommerce plugin must be enabled).', 'myportfolio' ),
				'validate' => 'numeric',
				'std' => '9',
				'class' => 'small-text'
			),
		)
	);
	$sections[] = array(
		'icon' => 'fa fa-bolt',
		'title' => __('Performance', 'myportfolio' ),
		'desc' => '<p class="description">' . __('This tab contains performance-related options which can help speed up your website.', 'myportfolio' ) . '</p>',
		'fields' => array(
			array(
				'id' => 'mts_prefetching',
				'type' => 'button_set',
				'title' => __('Prefetching', 'myportfolio' ),
				'options' => array( '0' => __( 'Off', 'myportfolio' ), '1' => __( 'On', 'myportfolio' ) ),
				'sub_desc' => __('Enable or disable prefetching. If user is on homepage, then single page will load faster and if user is on single page, homepage will load faster in modern browsers.', 'myportfolio' ),
				'std' => '0'
			),
			array(
				'id' => 'mts_lazy_load',
				'type' => 'button_set_hide_below',
				'title' => __('Lazy Load', 'myportfolio' ),
				'options' => array( '0' => __( 'Off', 'myportfolio' ), '1' => __( 'On', 'myportfolio' ) ),
				'sub_desc' => __('Delay loading of images outside of viewport, until user scrolls to them.', 'myportfolio' ),
				'std' => '0',
				'args' => array('hide' => 2)
			),
			array(
				'id' => 'mts_lazy_load_thumbs',
				'type' => 'button_set',
				'title' => __('Lazy load featured images', 'myportfolio' ),
				'options' => array( '0' => __( 'Off', 'myportfolio' ), '1' => __( 'On', 'myportfolio' ) ),
				'sub_desc' => __('Enable or disable Lazy load of featured images across site.', 'myportfolio' ),
				'std' => '0'
			),
			array(
				'id' => 'mts_lazy_load_content',
				'type' => 'button_set',
				'title' => __('Lazy load post content images', 'myportfolio' ),
				'options' => array( '0' => __( 'Off', 'myportfolio' ), '1' => __( 'On', 'myportfolio' ) ),
				'sub_desc' => __('Enable or disable Lazy load of images inside post/page content.', 'myportfolio' ),
				'std' => '0'
			),
			array(
				'id' => 'mts_async_js',
				'type' => 'button_set',
				'title' => __('Async JavaScript', 'myportfolio' ),
				'options' => array( '0' => __( 'Off', 'myportfolio' ), '1' => __( 'On', 'myportfolio' ) ),
				'sub_desc' => sprintf( __('Add %s attribute to script tags to improve page download speed.', 'myportfolio' ), '<code>async</code>' ),
				'std' => '1',
			),
			array(
				'id' => 'mts_remove_ver_params',
				'type' => 'button_set',
				'title' => __('Remove ver parameters', 'myportfolio' ),
				'options' => array( '0' => __( 'Off', 'myportfolio' ), '1' => __( 'On', 'myportfolio' ) ),
				'sub_desc' => sprintf( __('Remove %s parameter from CSS and JS file calls. It may improve speed in some browsers which do not cache files having the parameter.', 'myportfolio' ), '<code>ver</code>' ),
				'std' => '1',
			),
			array(
				'id' => 'mts_optimize_wc',
				'type' => 'button_set',
				'title' => __('Optimize WooCommerce scripts', 'myportfolio' ),
				'options' => array( '0' => __( 'Off', 'myportfolio' ), '1' => __( 'On', 'myportfolio' ) ),
				'sub_desc' => __('Load WooCommerce scripts and styles only on WooCommerce pages (WooCommerce plugin must be enabled).', 'myportfolio' ),
				'std' => '1'
			),
			'cache_message' => array(
				'id' => 'mts_cache_message',
				'type' => 'info',
				'title' => __('Use Cache', 'myportfolio' ),
				// Translators: %1$s = popup link to W3 Total Cache, %2$s = popup link to WP Super Cache
				'desc' => sprintf(
					__('A cache plugin can increase page download speed dramatically. We recommend using %1$s or %2$s.', 'myportfolio' ),
					'<a href="https://community.mythemeshop.com/tutorials/article/8-make-your-website-load-faster-using-w3-total-cache-plugin/" target="_blank" title="W3 Total Cache">W3 Total Cache</a>',
					'<a href="'.admin_url( 'plugin-install.php?tab=plugin-information&plugin=wp-super-cache&TB_iframe=true&width=772&height=574' ).'" class="thickbox" title="WP Super Cache">WP Super Cache</a>'
				),
			),
		)
	);

	// Hide cache message on multisite or if a chache plugin is active already
	if ( is_multisite() || strstr( join( ';', get_option( 'active_plugins' ) ), 'cache' ) ) {
		unset( $sections[1]['fields']['cache_message'] );
	}

	$sections[] = array(
		'icon' => 'fa fa-adjust',
		'title' => __('Styling Options', 'myportfolio' ),
		'desc' => '<p class="description">' . __('Control the visual appearance of your theme, such as colors, layout and patterns, from here.', 'myportfolio' ) . '</p>',
		'fields' => array(
			array(
				'id' => 'mts_color_scheme',
				'type' => 'color',
				'title' => __('Color Scheme 1', 'myportfolio' ),
				'sub_desc' => __('The theme comes with unlimited color schemes for your theme\'s styling.', 'myportfolio' ),
				'std' => '#e64344'
			),
			array(
				'id' => 'mts_color_scheme2',
				'type' => 'color',
				'title' => __('Color Scheme 2', 'myportfolio' ),
				'sub_desc' => __('The theme comes with unlimited color schemes for your theme\'s styling.', 'myportfolio' ),
				'std' => '#00aced'
			),
			array(
				'id' => 'mts_color_scheme3',
				'type' => 'color',
				'title' => __('Color Scheme 3', 'myportfolio' ),
				'sub_desc' => __('The theme comes with unlimited color schemes for your theme\'s styling.', 'myportfolio' ),
				'std' => '#ce8d66'
			),
			array(
				'id' => 'mts_layout',
				'type' => 'radio_img',
				'title' => __('Layout Style', 'myportfolio' ),
				'sub_desc' => wp_kses( __('Choose the <strong>default sidebar position</strong> for your site. The position of the sidebar for individual posts can be set in the post editor.', 'myportfolio' ), array( 'strong' => '' ) ),
				'options' => array(
					'cslayout' => array('img' => NHP_OPTIONS_URL.'img/layouts/cs.png'),
					'sclayout' => array('img' => NHP_OPTIONS_URL.'img/layouts/sc.png')
				),
				'std' => 'cslayout'
			),
			array(
				'id' => 'mts_background',
				'type' => 'background',
				'title' => __('Site Background', 'myportfolio' ),
				'sub_desc' => __('Set background color, pattern and image from here.', 'myportfolio' ),
				'options' => array(
					'color'		 => '',
					'image_pattern' => $mts_patterns,
					'image_upload'  => '',
					'repeat'		=> array(),
					'attachment'	=> array(),
					'position'	  => array(),
					'size'		  => array(),
					'gradient'	  => '',
					'parallax'	  => array(),
				),
				'std' => array(
					'color'		 => '#f9f8f8',
					'use'		   => 'pattern',
					'image_pattern' => 'nobg',
					'image_upload'  => '',
					'repeat'		=> 'repeat',
					'attachment'	=> 'scroll',
					'position'	  => 'left top',
					'size'		  => 'cover',
					'gradient'	  => array('from' => '#ffffff', 'to' => '#000000', 'direction' => 'horizontal' ),
					'parallax'	  => '0',
				)
			),
			array(
				'id' => 'mts_custom_css',
				'type' => 'textarea',
				'title' => __('Custom CSS', 'myportfolio' ),
				'sub_desc' => __('You can enter custom CSS code here to further customize your theme. This will override the default CSS used on your site.', 'myportfolio' )
			),
			array(
				'id' => 'mts_loading',
				'type' => 'button_set',
				'title' => __('Loading Effects', 'myportfolio' ),
				'options' => array( '0' => __( 'Off', 'myportfolio' ), '1' => __( 'On', 'myportfolio' ) ),
				'sub_desc' => __('Enable or disable loading effect on homepage, single portfolio view, blog archives and posts.', 'myportfolio' ),
				'std' => '1'
			),
		)
	);

	$sections[] = array(
		'icon' => 'fa fa-camera',
		'title' => __('Portfolio', 'myportfolio' ),
		'desc' => '<p class="description">' . __('From here, you can control the elements of the Portfolio.', 'myportfolio' ) . '</p>',
		'fields' => array(
			array(
				'id' => 'mts_portfolio_postsnum',
				'type' => 'text',
				'class' => 'small-text',
				'title' => __('Number of Portfolio Posts', 'myportfolio' ) ,
				'sub_desc' => __('Enter the number of posts.', 'myportfolio' ) ,
				'std' => '12',
				'args' => array(
					'type' => 'number'
				)
			),
			array(
				'id' => 'mts_lightbox',
				'type' => 'button_set',
				'title' => __('Lightbox', 'myportfolio' ),
				'options' => array( '0' => __( 'Off', 'myportfolio' ), '1' => __( 'On', 'myportfolio' ) ),
				'sub_desc' => __('A lightbox is a stylized pop-up that allows your visitors to view larger versions of images without leaving the current page. You can enable or disable the lightbox here.', 'myportfolio' ),
				'std' => '1'
			),
			array(
				'id' => 'mts_pagenavigation_type',
				'type' => 'radio',
				'title' => __('Pagination Type', 'myportfolio' ),
				'sub_desc' => __('Select pagination type.', 'myportfolio' ),
				'options' => array(
					'0'=> __('Default (Next / Previous)', 'myportfolio' ),
					'1' => __('Numbered (1 2 3 4...)', 'myportfolio' ),
					'2' => __( 'AJAX (Load More Button)', 'myportfolio' ),
					'3' => __( 'AJAX (Auto Infinite Scroll)', 'myportfolio' )
				),
				'std' => '1'
			),
			array(
				'id' => 'mts_similar_projects_section',
				'type' => 'button_set',
				'title' => __('Similar Projects Section', 'myportfolio'),
				'sub_desc' => __('You can enable/disable Similar Projects section in single Portfolio page from here.', 'myportfolio'),
				'options' => array('0' => 'Off','1' => 'On'),
				'std' => '1'
			),
			array(
				'id' => 'mts_about_author_buttons',
				'title' => __('About Author Widget Buttons', 'myportfolio'), 
				'sub_desc' => __( 'Add Buttons in the About Author Widget.', 'myportfolio' ),
				'type' => 'group',
				'groupname' => __('About Author Buttons', 'myportfolio'), // Group name
				'subfields' => 
					array(
						array(
							'id' => 'mts_about_author_buttons_text',
							'type' => 'text',
							'title' => __('Title', 'myportfolio'), 
						),
						array(
							'id' => 'mts_about_author_buttons_icon',
							'type' => 'icon_select',
							'title' => __('Icon', 'myportfolio')
						),
						array(
							'id' => 'mts_about_author_buttons_link',
							'type' => 'text',
							'title' => __('URL', 'myportfolio'), 
						),
						array(
							'id' => 'mts_about_author_buttons_bg',
							'type' => 'color',
							'title' => __('Background Color', 'myportfolio'), 
						),
					),
				'std' => array(
					'full_bio' => array(
						'group_title' => 'Full Bio',
						'group_sort' => '1',
						'mts_about_author_buttons_icon' => '',
						'mts_about_author_buttons_text' => 'Full Bio',
						'mts_about_author_buttons_link' => '#',
						'mts_about_author_buttons_bg' => '#ce8d66',
					),
					'contact' => array(
						'group_title' => 'Contact',
						'group_sort' => '2',
						'mts_about_author_buttons_icon' => '',
						'mts_about_author_buttons_text' => 'Contact',
						'mts_about_author_buttons_link' => '#',
						'mts_about_author_buttons_bg' => '#e64344',
					)
				)
			),
		)
	);

	$sections[] = array(
		'icon' => 'fa fa-credit-card',
		'title' => __('Header', 'myportfolio' ),
		'desc' => '<p class="description">' . __('From here, you can control the elements of header section.', 'myportfolio' ) . '</p>',
		'fields' => array(
			array(
				'id' => 'mts_header_background',
				'type' => 'background',
				'title' => __('Header Background', 'myportfolio' ),
				'sub_desc' => __('Set background color, pattern and image from here.', 'myportfolio' ),
				'options' => array(
					'color'		 => '',
					'image_pattern' => $mts_patterns,
					'image_upload'  => '',
					'repeat'		=> array(),
					'attachment'	=> array(),
					'position'	  => array(),
					'size'		  => array(),
					'gradient'	  => '',
					'parallax'	  => array(),
				),
				'std' => array(
					'color'		 => '#272731',
					'use'		   => 'pattern',
					'image_pattern' => 'nobg',
					'image_upload'  => '',
					'repeat'		=> 'repeat',
					'attachment'	=> 'scroll',
					'position'	  => 'left top',
					'size'		  => 'cover',
					'gradient'	  => array('from' => '#ffffff', 'to' => '#000000', 'direction' => 'horizontal' ),
					'parallax'	  => '0',
				)
			),
			array(
				'id' => 'mts_show_primary_nav',
				'type' => 'button_set',
				'title' => __('Show Primary Menu', 'myportfolio' ),
				'options' => array( '0' => __( 'Off', 'myportfolio' ), '1' => __( 'On', 'myportfolio' ) ),
				'sub_desc' => sprintf( __('Use this button to enable %s.', 'myportfolio' ), '<strong>' . __( 'Primary Navigation Menu', 'myportfolio' ) . '</strong>' ),
				'std' => '1'
			),
			array(
				'id' => 'mts_header_section2',
				'type' => 'button_set',
				'title' => __('Show Logo', 'myportfolio' ),
				'options' => array( '0' => __( 'Off', 'myportfolio' ), '1' => __( 'On', 'myportfolio' ) ),
				'sub_desc' => wp_kses( __('Use this button to Show or Hide the <strong>Logo</strong> completely.', 'myportfolio' ), array( 'strong' => '' ) ),
				'std' => '1'
			),
			array(
				'id' => 'mts_social_icon_head',
				'type' => 'button_set_hide_below',
				'title' => __('Social Icons', 'myportfolio'),
				'sub_desc' => __('You can control social icon links from <strong>Blog Settings > Social Buttons</strong> Tab.', 'myportfolio'),
				'options' => array('0' => 'Off','1' => 'On'),
				'std' => '1'
			),
			array(
				'id' => 'mts_header_social',
				'title' => __('Header Social Icons', 'myportfolio'), 
				'sub_desc' => __( 'Add Social Media icons in header.', 'myportfolio' ),
				'type' => 'group',
				'groupname' => __('Header Icons', 'myportfolio'), // Group name
				'subfields' => 
					array(
						array(
							'id' => 'mts_header_icon_title',
							'type' => 'text',
							'title' => __('Title', 'myportfolio'), 
							),
						array(
							'id' => 'mts_header_icon',
							'type' => 'icon_select',
							'title' => __('Icon', 'myportfolio')
							),
						array(
							'id' => 'mts_header_icon_link',
							'type' => 'text',
							'title' => __('URL', 'myportfolio'), 
							),
						),
				'std' => array(
					'facebook' => array(
						'group_title' => 'Facebook',
						'group_sort' => '1',
						'mts_header_icon_title' => 'Facebook',
						'mts_header_icon' => 'facebook',
						'mts_header_icon_link' => '#',
					),
					'twitter' => array(
						'group_title' => 'Twitter',
						'group_sort' => '2',
						'mts_header_icon_title' => 'Twitter',
						'mts_header_icon' => 'twitter',
						'mts_header_icon_link' => '#',
					),
					'gplus' => array(
						'group_title' => 'Google Plus',
						'group_sort' => '3',
						'mts_header_icon_title' => 'Google Plus',
						'mts_header_icon' => 'google-plus',
						'mts_header_icon_link' => '#',
					),
					'youtube' => array(
						'group_title' => 'YouTube',
						'group_sort' => '4',
						'mts_header_icon_title' => 'YouTube',
						'mts_header_icon' => 'youtube-play',
						'mts_header_icon_link' => '#',
					),
					'dribbble' => array(
						'group_title' => 'Dribbble',
						'group_sort' => '5',
						'mts_header_icon_title' => 'Dribbble',
						'mts_header_icon' => 'dribbble',
						'mts_header_icon_link' => '#',
					)
				)
			),
		)
	);

	$sections[] = array(
		'icon' => 'fa fa-table',
		'title' => __('Footer', 'myportfolio' ),
		'desc' => '<p class="description">' . __('From here, you can control the elements of Footer section.', 'myportfolio' ) . '</p>',
		'fields' => array(
			array(
				'id' => 'mts_footer_background',
				'type' => 'background',
				'title' => __('Footer Background', 'myportfolio' ),
				'sub_desc' => __('Set background color, pattern and image from here.', 'myportfolio' ),
				'options' => array(
					'color'		 => '',
					'image_pattern' => $mts_patterns,
					'image_upload'  => '',
					'repeat'		=> array(),
					'attachment'	=> array(),
					'position'	  => array(),
					'size'		  => array(),
					'gradient'	  => '',
					'parallax'	  => array(),
				),
				'std' => array(
					'color'		 => '#24242c',
					'use'		   => 'pattern',
					'image_pattern' => 'nobg',
					'image_upload'  => '',
					'repeat'		=> 'repeat',
					'attachment'	=> 'scroll',
					'position'	  => 'left top',
					'size'		  => 'cover',
					'gradient'	  => array('from' => '#ffffff', 'to' => '#000000', 'direction' => 'horizontal' ),
					'parallax'	  => '0',
				)
			),
			array(
				'id' => 'mts_myclients_section',
				'type' => 'button_set_hide_below',
				'title' => __('My Clients', 'myportfolio'),
				'sub_desc' => __('You can control My Clients section from here.', 'myportfolio'),
				'options' => array('0' => 'Off','1' => 'On'),
				'std' => '0',
				'args' => array('hide' => 4)
				),
				array(
					'id' => 'mts_myclients_background',
					'type' => 'color',
					'title' => __('My Clients Background Color', 'myportfolio' ),
					'sub_desc' => __('Choose background color for My Clients Section.', 'myportfolio' ),
					'std' => '#ffffff'
				),
				array(
					'id' => 'mts_myclients_heading',
					'type' => 'text',
					'title' => __('My Clients Heading', 'myportfolio' ),
					'sub_desc' => __('Add heading for the My Clients Section.', 'myportfolio' ),
					'std' => 'My Clients'
				),
				array(
					'id' => 'mts_myclients_text',
					'type' => 'text',
					'title' => __('My Clients Description', 'myportfolio' ),
					'sub_desc' => __('Description for the My Clients section.', 'myportfolio' ),
					'std' => 'I\'m glad to have worked with these clients.'
				),
				array(
					'id' => 'mts_myclients_images',
					'title' => __('Client Logos', 'myportfolio'), 
					'sub_desc' => __( 'Add Client logo images', 'myportfolio' ),
					'type' => 'group',
					'groupname' => __('Logo image', 'myportfolio'), // Group name
					'subfields' => 
						array(
							array(
								'id' => 'mts_myclients_title',
								'type' => 'text',
								'title' => __('Title', 'myportfolio')
							),
							array(
								'id' => 'mts_myclients_image',
								'type' => 'upload',
								'title' => __('Image', 'myportfolio')
							),
							array(
								'id' => 'mts_myclients_link',
								'type' => 'text',
								'title' => __('URL', 'myportfolio'),
								'std' => '#'
							),
						),
					'std' => ''
				),
			array(
				'id' => 'mts_show_footer_nav',
				'type' => 'button_set',
				'title' => __('Show Footer menu', 'myportfolio'), 
				'options' => array('0' => 'Off','1' => 'On'),
				'sub_desc' => __('Use this button to enable <strong>Footer Navigation Menu</strong>.', 'myportfolio'),
				'std' => '1'
			),
			array(
				'id' => 'mts_copyrights',
				'type' => 'textarea',
				'title' => __('Copyrights Text', 'myportfolio' ),
				'sub_desc' => __( 'You can change or remove our link from footer and use your own custom text.', 'myportfolio' ) . ( MTS_THEME_WHITE_LABEL ? '' : wp_kses( __('(You can also use your affiliate link to <strong>earn 70% of sales</strong>. Ex: <a href="https://mythemeshop.com/go/aff/aff" target="_blank">https://mythemeshop.com/?ref=username</a>)', 'myportfolio' ), array( 'strong' => '', 'a' => array( 'href' => array(), 'target' => array() ) ) ) ),
				'std' => MTS_THEME_WHITE_LABEL ? null : sprintf( __( 'Theme by %s', 'myportfolio' ), '<a href="http://mythemeshop.com/" rel="nofollow">MyThemeShop</a>' )
			),
		)
	);

	$sections[] = array(
		'icon' => 'fa fa-list-ul',
		'title' => __('Blog', 'myportfolio' ),
		'desc' => '<p class="description">' . __('From here, you can control the elements of the Blog.', 'myportfolio' ) . '</p>',
		'fields' => array(
			array(
				'id'		=> 'mts_featured_categories',
				'type'	  => 'group',
				'title'	 => __('Featured Categories', 'myportfolio' ),
				'sub_desc'  => __('Select categories appearing on the homepage.', 'myportfolio' ),
				'groupname' => __('Section', 'myportfolio' ), // Group name
				'subfields' => 
					array(
						array(
							'id' => 'mts_featured_category',
							'type' => 'cats_select',
							'title' => __('Category', 'myportfolio' ),
							'sub_desc' => __('Select a category or the latest posts for this section', 'myportfolio' ),
							'std' => 'latest',
							'args' => array('include_latest' => 1, 'hide_empty' => 0),
						),
						array(
							'id' => 'mts_featured_category_postsnum',
							'type' => 'text',
							'class' => 'small-text',
							'title' => __('Number of posts', 'myportfolio' ),
							'sub_desc' => sprintf( wp_kses_post( __('Enter the number of posts to show in this section.<br/><strong>For Latest Posts</strong>, this setting will be ignored, and number set in <a href="%s" target="_blank">Settings&nbsp;&gt;&nbsp;Reading</a> will be used instead.', 'myportfolio' ) ), admin_url('options-reading.php')),
							'std' => '3',
							'args' => array('type' => 'number')
						),
					),
				'std' => array(
					'1' => array(
						'group_title' => '',
						'group_sort' => '1',
						'mts_featured_category' => 'latest',
						'mts_featured_category_postsnum' => get_option('posts_per_page')
					)
				)
			),
			array(
				'id'	   => 'mts_home_headline_meta_info',
				'type'	 => 'layout',
				'title'	=> __('Blog Page Post Meta Info', 'myportfolio' ),
				'sub_desc' => __('Organize how you want the post meta info to appear on the homepage', 'myportfolio' ),
				'options'  => array(
					'enabled'  => array(
						'date'	 => __('Date', 'myportfolio' ),
						'readmore'  => __('Full Article Link', 'myportfolio' )
					),
					'disabled' => array(
						'author'   => __('Author Name', 'myportfolio' ),
						'comment'  => __('Comment Count', 'myportfolio' ),
						'category' => __('Categories', 'myportfolio' )
					)
				),
				'std'  => array(
					'enabled'  => array(
						'date'	 => __('Date', 'myportfolio' ),
						'readmore'  => __('Full Article Link', 'myportfolio' )
					),
					'disabled' => array(
						'comment'  => __('Comment Count', 'myportfolio' ),
						'author'   => __('Author Name', 'myportfolio' ),
						'category' => __('Categories', 'myportfolio' )
					)
				)
			),
			array(
				'id' => 'mts_blog_pagenavigation_type',
				'type' => 'radio',
				'title' => __('Pagination Type - Blog page', 'myportfolio'),
				'sub_desc' => __('Select pagination type for blog page.', 'myportfolio'),
				'options' => array(
					'0'=> __('Default (Next / Previous)', 'myportfolio'),
					'1' => __('Numbered (1 2 3 4...)', 'myportfolio'),
					'2' => __( 'AJAX (Load More Button)', 'myportfolio' ),
					'3' => __( 'AJAX (Auto Infinite Scroll)', 'myportfolio' )
				),
				'std' => '2'
			),
		)
	);

	$sections[] = array(
		'icon' => 'fa fa-file-text',
		'title' => __('Single Posts', 'myportfolio' ),
		'desc' => '<p class="description">' . __('From here, you can control the appearance and functionality of your single posts page.', 'myportfolio' ) . '</p>',
		'fields' => array(
			array(
				'id'	   => 'mts_single_post_layout',
				'type'	 => 'layout2',
				'title'	=> __('Single Post Layout', 'myportfolio' ),
				'sub_desc' => __('Customize the look of single posts', 'myportfolio' ),
				'options'  => array(
					'enabled'  => array(
						'content'   => array(
							'label'	=> __('Post Content', 'myportfolio' ),
							'subfields'	=> array(
							)
						),
						'author'   => array(
							'label'	=> __('Author Box', 'myportfolio' ),
							'subfields'	=> array()
						),
					),
					'disabled' => array(
						'tags'   => array(
							'label'	=> __('Tags', 'myportfolio' ),
							'subfields'	=> array()
						),
					)
				)
			),
			array(
				'id'	   => 'mts_single_headline_meta_info',
				'type'	 => 'layout',
				'title'	=> __('Meta Info to Show', 'myportfolio' ),
				'sub_desc' => __('Organize how you want the post meta info to appear', 'myportfolio' ),
				'options'  => array(
					'enabled'  => array(
						'author'   => __('Author Name', 'myportfolio' ),
						'date'	 => __('Date', 'myportfolio' ),
						'category' => __('Categories', 'myportfolio' ),
						'comment'  => __('Comment Count', 'myportfolio' )
					),
					'disabled' => array()
				),
				'std'  => array(
					'enabled'  => array(
						'author'   => __('Author Name', 'myportfolio' ),
						'date'	 => __('Date', 'myportfolio' ),
						'category' => __('Categories', 'myportfolio' ),
						'comment'  => __('Comment Count', 'myportfolio' )
					),
					'disabled' => array()
				)
			),
			array(
				'id' => 'mts_breadcrumb',
				'type' => 'button_set',
				'title' => __('Breadcrumbs', 'myportfolio' ),
				'options' => array( '0' => __( 'Off', 'myportfolio' ), '1' => __( 'On', 'myportfolio' ) ),
				'sub_desc' => __('Breadcrumbs are a great way to make your site more user-friendly. You can enable them by checking this box.', 'myportfolio' ),
				'std' => '1'
			),
			array(
				'id' => 'mts_prev_next_background',
				'type' => 'background',
				'title' => __('Previous/Next Background', 'myportfolio' ),
				'sub_desc' => __('Set background color, pattern and image from here.', 'myportfolio' ),
				'options' => array(
					'color'		 => '',
					'image_pattern' => $mts_patterns,
					'image_upload'  => '',
					'repeat'		=> array(),
					'attachment'	=> array(),
					'position'	  => array(),
					'size'		  => array(),
					'gradient'	  => '',
					'parallax'	  => false,
				),
				'std' => array(
					'color'		 => '#24242c',
					'use'		   => 'upload',
					'image_pattern' => 'nobg',
					'image_upload'  => get_stylesheet_directory_uri().'/images/next-prev-bg.jpg',
					'repeat'		=> 'repeat',
					'attachment'	=> 'scroll',
					'position'	  => 'left top',
					'size'		  => 'cover',
					'gradient'	  => array('from' => '#ffffff', 'to' => '#000000', 'direction' => 'horizontal' ),
					'parallax'	  => false,
				)
			),
			array(
				'id' => 'mts_author_comment',
				'type' => 'button_set',
				'title' => __('Highlight Author Comment', 'myportfolio' ),
				'options' => array( '0' => __( 'Off', 'myportfolio' ), '1' => __( 'On', 'myportfolio' ) ),
				'sub_desc' => __('Use this button to highlight author comments.', 'myportfolio' ),
				'std' => '1'
			),
			array(
				'id' => 'mts_comment_date',
				'type' => 'button_set',
				'title' => __('Date in Comments', 'myportfolio' ),
				'options' => array( '0' => __( 'Off', 'myportfolio' ), '1' => __( 'On', 'myportfolio' ) ),
				'sub_desc' => __('Use this button to show the date for comments.', 'myportfolio' ),
				'std' => '1'
			),
			array(
				'id' => 'mts_related_posts',
				'type' => 'button_set_hide_below',
				'title' => __('Related Posts', 'myportfolio' ),
				'options' => array( '0' => __( 'Off', 'myportfolio' ), '1' => __( 'On', 'myportfolio' ) ),
				'sub_desc' => __('You can enable them by checking this box.', 'myportfolio' ),
				'std' => '1',
				'args' => array('hide' => 2)
			),
			array(
				'id' => 'mts_related_posts_taxonomy',
				'type' => 'button_set',
				'title' => __('Related Posts Taxonomy', 'myportfolio' ) ,
				'options' => array(
					'tags' => __( 'Tags', 'myportfolio' ),
					'categories' => __( 'Categories', 'myportfolio' )
				) ,
				'class' => 'green',
				'sub_desc' => __('Related Posts based on tags or categories.', 'myportfolio' ) ,
				'std' => 'categories'
			),
			array(
				'id' => 'mts_related_postsnum',
				'type' => 'text',
				'class' => 'small-text',
				'title' => __('Number of related posts', 'myportfolio' ) ,
				'sub_desc' => __('Enter the number of posts to show in the related posts section.', 'myportfolio' ) ,
				'std' => '3',
				'args' => array(
					'type' => 'number'
				)
			),
		)
	);

	$sections[] = array(
		'icon' => 'fa fa-group',
		'title' => __('Social Buttons', 'myportfolio' ),
		'desc' => '<p class="description">' . __('Enable or disable social sharing buttons on single posts using these buttons.', 'myportfolio' ) . '</p>',
		'fields' => array(
			array(
				'id' => 'mts_social_button_position',
				'type' => 'button_set',
				'title' => __('Social Sharing Buttons Position', 'myportfolio' ),
				'options' => array('top' => __('Above Content', 'myportfolio' ), 'bottom' => __('Below Content', 'myportfolio' )),
				'sub_desc' => __('Choose position for Social Sharing Buttons.', 'myportfolio' ),
				'std' => 'bottom',
				'class' => 'green'
			),
			array(
				'id' => 'mts_social_buttons_on_pages',
				'type' => 'button_set',
				'title' => __('Social Sharing Buttons on Pages', 'myportfolio' ),
				'options' => array('0' => __('Off', 'myportfolio' ), '1' => __('On', 'myportfolio' )),
				'sub_desc' => __('Enable the sharing buttons for pages too, not just posts.', 'myportfolio' ),
				'std' => '0',
			),
			array(
				'id'	=> 'mts_social_buttons',
				'type'	=> 'layout',
				'title'	=> __('Social Media Buttons', 'myportfolio' ),
				'sub_desc' => __('Organize how you want the social sharing buttons to appear on single posts', 'myportfolio' ),
				'options'  => array(
					'enabled'  => array(
						'facebookshare'   => __('Facebook Share', 'myportfolio' ),
						'facebook'  => __('Facebook Like', 'myportfolio' ),
						'twitter'   => __('Twitter', 'myportfolio' ),
						'gplus'	 => __('Google Plus', 'myportfolio' ),
						'pinterest' => __('Pinterest', 'myportfolio' ),
					),
					'disabled' => array(
						'linkedin'  => __('LinkedIn', 'myportfolio' ),
						'stumble'   => __('StumbleUpon', 'myportfolio' ),
					)
				),
				'std'  => array(
					'enabled'  => array(
						'facebookshare'   => __('Facebook Share', 'myportfolio' ),
						'facebook'  => __('Facebook Like', 'myportfolio' ),
						'twitter'   => __('Twitter', 'myportfolio' ),
						'gplus'	 => __('Google Plus', 'myportfolio' ),
						'pinterest' => __('Pinterest', 'myportfolio' ),
					),
					'disabled' => array(
						'linkedin'  => __('LinkedIn', 'myportfolio' ),
						'stumble'   => __('StumbleUpon', 'myportfolio' ),
					)
				)
			),
		)
	);

	$sections[] = array(
		'icon' => 'fa fa-bar-chart-o',
		'title' => __('Ad Management', 'myportfolio' ),
		'desc' => '<p class="description">' . __('Now, ad management is easy with our options panel. You can control everything from here, without using separate plugins.', 'myportfolio' ) . '</p>',
		'fields' => array(
			array(
				'id' => 'mts_posttop_adcode',
				'type' => 'textarea',
				'title' => __('Below Post Title', 'myportfolio' ),
				'sub_desc' => __('Paste your Adsense, BSA or other ad code here to show ads below your article title on single posts.', 'myportfolio' )
			),
			array(
				'id' => 'mts_posttop_adcode_time',
				'type' => 'text',
				'title' => __('Show After X Days', 'myportfolio' ),
				'sub_desc' => __('Enter the number of days after which you want to show the Below Post Title Ad. Enter 0 to disable this feature.', 'myportfolio' ),
				'validate' => 'numeric',
				'std' => '0',
				'class' => 'small-text',
				'args' => array('type' => 'number')
			),
			array(
				'id' => 'mts_postend_adcode',
				'type' => 'textarea',
				'title' => __('Below Post Content', 'myportfolio' ),
				'sub_desc' => __('Paste your Adsense, BSA or other ad code here to show ads below the post content on single posts.', 'myportfolio' )
			),
			array(
				'id' => 'mts_postend_adcode_time',
				'type' => 'text',
				'title' => __('Show After X Days', 'myportfolio' ),
				'sub_desc' => __('Enter the number of days after which you want to show the Below Post Title Ad. Enter 0 to disable this feature.', 'myportfolio' ),
				'validate' => 'numeric',
				'std' => '0',
				'class' => 'small-text',
				'args' => array('type' => 'number')
			),
		)
	);

	$sections[] = array(
		'icon' => 'fa fa-columns',
		'title' => __('Sidebars', 'myportfolio' ),
		'desc' => '<p class="description">' . __('Now you have full control over the sidebars. Here you can manage sidebars and select one for each section of your site, or select a custom sidebar on a per-post basis in the post editor.', 'myportfolio' ) . '<br></p>',
		'fields' => array(
			array(
				'id'		=> 'mts_custom_sidebars',
				'type'	  => 'group', //doesn't need to be called for callback fields
				'title'	 => __('Custom Sidebars', 'myportfolio' ),
				'sub_desc'  => wp_kses( __('Add custom sidebars. <strong style="font-weight: 800;">You need to save the changes to use the sidebars in the dropdowns below.</strong><br />You can add content to the sidebars in Appearance &gt; Widgets.', 'myportfolio' ), array( 'strong' => '', 'br' => '' ) ),
				'groupname' => __('Sidebar', 'myportfolio' ), // Group name
				'subfields' => 
					array(
						array(
							'id' => 'mts_custom_sidebar_name',
							'type' => 'text',
							'title' => __('Name', 'myportfolio' ),
							'sub_desc' => __('Example: Homepage Sidebar', 'myportfolio' )
						),	
						array(
							'id' => 'mts_custom_sidebar_id',
							'type' => 'text',
							'title' => __('ID', 'myportfolio' ),
							'sub_desc' => __('Enter a unique ID for the sidebar. Use only alphanumeric characters, underscores (_) and dashes (-), eg. "sidebar-home"', 'myportfolio' ),
							'std' => 'sidebar-'
						),
					),
			),
			array(
				'id' => 'mts_sidebar_for_post',
				'type' => 'sidebars_select',
				'title' => __('Single Post', 'myportfolio' ),
				'sub_desc' => __('Select a sidebar for the single posts. If a post has a custom sidebar set, it will override this.', 'myportfolio' ),
				'args' => array('exclude' => array('sidebar', 'portfolio-sidebar', 'footer-first', 'footer-first-2', 'footer-first-3', 'footer-first-4', 'footer-second', 'footer-second-2', 'footer-second-3', 'footer-second-4', 'widget-header','shop-sidebar', 'product-sidebar')),
				'std' => ''
			),
			array(
				'id' => 'mts_sidebar_for_portfolio_post',
				'type' => 'sidebars_select',
				'title' => __('Single Portfolio Post', 'myportfolio' ),
				'sub_desc' => __('Select a sidebar for the single portfolio posts. If a post has a custom sidebar set, it will override this.', 'myportfolio' ),
				'args' => array('exclude' => array('sidebar', 'portfolio-sidebar', 'footer-first', 'footer-first-2', 'footer-first-3', 'footer-first-4', 'footer-second', 'footer-second-2', 'footer-second-3', 'footer-second-4', 'widget-header','shop-sidebar', 'product-sidebar')),
				'std' => 'portfolio-sidebar'
			),
			array(
				'id' => 'mts_sidebar_for_page',
				'type' => 'sidebars_select',
				'title' => __('Single Page', 'myportfolio' ),
				'sub_desc' => __('Select a sidebar for the single pages. If a page has a custom sidebar set, it will override this.', 'myportfolio' ),
				'args' => array('exclude' => array('sidebar', 'portfolio-sidebar', 'footer-first', 'footer-first-2', 'footer-first-3', 'footer-first-4', 'footer-second', 'footer-second-2', 'footer-second-3', 'footer-second-4', 'widget-header','shop-sidebar', 'product-sidebar')),
				'std' => ''
			),
			array(
				'id' => 'mts_sidebar_for_archive',
				'type' => 'sidebars_select',
				'title' => __('Archive', 'myportfolio' ),
				'sub_desc' => __('Select a sidebar for the archives. Specific archive sidebars will override this setting (see below).', 'myportfolio' ),
				'args' => array('allow_nosidebar' => false, 'exclude' => array('sidebar', 'portfolio-sidebar', 'footer-first', 'footer-first-2', 'footer-first-3', 'footer-first-4', 'footer-second', 'footer-second-2', 'footer-second-3', 'footer-second-4', 'widget-header','shop-sidebar', 'product-sidebar')),
				'std' => ''
			),
			array(
				'id' => 'mts_sidebar_for_category',
				'type' => 'sidebars_select',
				'title' => __('Category Archive', 'myportfolio' ),
				'sub_desc' => __('Select a sidebar for the category archives.', 'myportfolio' ),
				'args' => array('allow_nosidebar' => false, 'exclude' => array('sidebar', 'portfolio-sidebar', 'footer-first', 'footer-first-2', 'footer-first-3', 'footer-first-4', 'footer-second', 'footer-second-2', 'footer-second-3', 'footer-second-4', 'widget-header','shop-sidebar', 'product-sidebar')),
				'std' => ''
			),
			array(
				'id' => 'mts_sidebar_for_tag',
				'type' => 'sidebars_select',
				'title' => __('Tag Archive', 'myportfolio' ),
				'sub_desc' => __('Select a sidebar for the tag archives.', 'myportfolio' ),
				'args' => array('allow_nosidebar' => false, 'exclude' => array('sidebar', 'portfolio-sidebar', 'footer-first', 'footer-first-2', 'footer-first-3', 'footer-first-4', 'footer-second', 'footer-second-2', 'footer-second-3', 'footer-second-4', 'widget-header','shop-sidebar', 'product-sidebar')),
				'std' => ''
			),
			array(
				'id' => 'mts_sidebar_for_date',
				'type' => 'sidebars_select',
				'title' => __('Date Archive', 'myportfolio' ),
				'sub_desc' => __('Select a sidebar for the date archives.', 'myportfolio' ),
				'args' => array('allow_nosidebar' => false, 'exclude' => array('sidebar', 'portfolio-sidebar', 'footer-first', 'footer-first-2', 'footer-first-3', 'footer-first-4', 'footer-second', 'footer-second-2', 'footer-second-3', 'footer-second-4', 'widget-header','shop-sidebar', 'product-sidebar')),
				'std' => ''
			),
			array(
				'id' => 'mts_sidebar_for_author',
				'type' => 'sidebars_select',
				'title' => __('Author Archive', 'myportfolio' ),
				'sub_desc' => __('Select a sidebar for the author archives.', 'myportfolio' ),
				'args' => array('allow_nosidebar' => false, 'exclude' => array('sidebar', 'portfolio-sidebar', 'footer-first', 'footer-first-2', 'footer-first-3', 'footer-first-4', 'footer-second', 'footer-second-2', 'footer-second-3', 'footer-second-4', 'widget-header','shop-sidebar', 'product-sidebar')),
				'std' => ''
			),
			array(
				'id' => 'mts_sidebar_for_search',
				'type' => 'sidebars_select',
				'title' => __('Search', 'myportfolio' ),
				'sub_desc' => __('Select a sidebar for the search results.', 'myportfolio' ),
				'args' => array('allow_nosidebar' => false, 'exclude' => array('sidebar', 'portfolio-sidebar', 'footer-first', 'footer-first-2', 'footer-first-3', 'footer-first-4', 'footer-second', 'footer-second-2', 'footer-second-3', 'footer-second-4', 'widget-header','shop-sidebar', 'product-sidebar')),
				'std' => ''
			),
			array(
				'id' => 'mts_sidebar_for_notfound',
				'type' => 'sidebars_select',
				'title' => __('404 Error', 'myportfolio' ),
				'sub_desc' => __('Select a sidebar for the 404 Not found pages.', 'myportfolio' ),
				'args' => array('allow_nosidebar' => false, 'exclude' => array('sidebar', 'portfolio-sidebar', 'footer-first', 'footer-first-2', 'footer-first-3', 'footer-first-4', 'footer-second', 'footer-second-2', 'footer-second-3', 'footer-second-4', 'widget-header','shop-sidebar', 'product-sidebar')),
				'std' => ''
			),
			array(
				'id' => 'mts_sidebar_for_shop',
				'type' => 'sidebars_select',
				'title' => __('Shop Pages', 'myportfolio' ),
				'sub_desc' => wp_kses( __('Select a sidebar for Shop main page and product archive pages (WooCommerce plugin must be enabled). Default is <strong>Shop Page Sidebar</strong>.', 'myportfolio' ), array( 'strong' => '' ) ),
				'args' => array('allow_nosidebar' => false, 'exclude' => array('sidebar', 'portfolio-sidebar', 'footer-first', 'footer-first-2', 'footer-first-3', 'footer-first-4', 'footer-second', 'footer-second-2', 'footer-second-3', 'footer-second-4', 'widget-header','shop-sidebar', 'product-sidebar')),
				'std' => 'shop-sidebar'
			),
			array(
				'id' => 'mts_sidebar_for_product',
				'type' => 'sidebars_select',
				'title' => __('Single Product', 'myportfolio' ),
				'sub_desc' => wp_kses( __('Select a sidebar for single products (WooCommerce plugin must be enabled). Default is <strong>Single Product Sidebar</strong>.', 'myportfolio' ), array( 'strong' => '' ) ),
				'args' => array('allow_nosidebar' => false, 'exclude' => array('sidebar', 'portfolio-sidebar', 'footer-first', 'footer-first-2', 'footer-first-3', 'footer-first-4', 'footer-second', 'footer-second-2', 'footer-second-3', 'footer-second-4', 'widget-header','shop-sidebar', 'product-sidebar')),
				'std' => 'product-sidebar'
			),
		),
	);

	$sections[] = array(
		'icon' => 'fa fa-list-alt',
		'title' => __('Navigation', 'myportfolio' ),
		'desc' => '<p class="description"><div class="controls">' . sprintf( __('Navigation settings can now be modified from the %s.', 'myportfolio' ), '<a href="nav-menus.php"><b>' . __( 'Menus Section', 'myportfolio' ) . '</b></a>' ) . '<br></div></p>'
	);

					
	$tabs = array();

	$args['presets'] = array();
	$args['show_translate'] = false;
	include('theme-presets.php');

	global $NHP_Options;
	$NHP_Options = new NHP_Options($sections, $args, $tabs);

}//function

add_action('init', 'setup_framework_options', 0);

/*
 * 
 * Custom function for the callback referenced above
 *
 */
function my_custom_field($field, $value){
	print_r($field);
	print_r($value);

}//function

/*
 * 
 * Custom function for the callback validation referenced above
 *
 */
function validate_callback_function($field, $value, $existing_value){
	
	$error = false;
	$value =  'just testing';
	$return['value'] = $value;
	if($error == true){
		$return['error'] = $field;
	}
	return $return;
	
}//function

/*--------------------------------------------------------------------
 * 
 * Default Font Settings
 *
 --------------------------------------------------------------------*/
if(function_exists('mts_register_typography')) { 
	mts_register_typography(array(
		'logo_font' => array(
			'preview_text' => __( 'Logo Font', 'myportfolio' ),
			'preview_color' => 'dark',
			'font_family' => 'Roboto Slab',
			'font_variant' => 'normal',
			'font_size' => '35px',
			'font_color' => '#ffffff',
			'css_selectors' => '#logo'
		),
		'navigation_font' => array(
			'preview_text' => __( 'Navigation Font', 'myportfolio' ),
			'preview_color' => 'dark',
			'font_family' => 'Roboto',
			'font_variant' => 'normal',
			'font_size' => '14px',
			'font_color' => '#79797f',
			'css_selectors' => '#primary-navigation a',
			'additional_css' => 'text-transform: uppercase;'
		),
		'home_title_font' => array(
			'preview_text' => __( 'Blog Article Title', 'myportfolio' ),
			'preview_color' => 'light',
			'font_family' => 'Roboto Slab',
			'font_size' => '24px',
			'font_variant' => 'normal',
			'font_color' => '#33343d',
			'css_selectors' => '.latestPost .title a'
		),
		'single_title_font' => array(
			'preview_text' => __( 'Single Article Title', 'myportfolio' ),
			'preview_color' => 'light',
			'font_family' => 'Roboto Slab',
			'font_size' => '34px',
			'font_variant' => 'normal',
			'font_color' => '#33343d',
			'css_selectors' => '.single-title'
		),
		'single_posrtfolio_title_font' => array(
			'preview_text' => __( 'Single Portfolio Title', 'myportfolio' ),
			'preview_color' => 'light',
			'font_family' => 'Roboto Slab',
			'font_size' => '28px',
			'font_variant' => 'normal',
			'font_color' => '#33343d',
			'css_selectors' => '.single-portfolio .single-title'
		),
		'content_font' => array(
			'preview_text' => __( 'Content Font', 'myportfolio' ),
			'preview_color' => 'light',
			'font_family' => 'Roboto',
			'font_size' => '16px',
			'font_variant' => 'normal',
			'font_color' => '#696a72',
			'css_selectors' => 'body'
		),
		'sidebar_widget_title_font' => array(
			'preview_text' => __( 'Sidebar Widget Title Font', 'myportfolio' ),
			'preview_color' => 'light',
			'font_family' => 'Roboto',
			'font_variant' => '700',
			'font_size' => '15px',
			'font_color' => '#7f8088',
			'css_selectors' => '.widget h3',
			'additional_css' => 'text-transform: uppercase;'
		),
		'sidebar_widget_subtitle_font' => array(
			'preview_text' => __( 'Sidebar Widget Links', 'myportfolio' ),
			'preview_color' => 'light',
			'font_family' => 'Roboto Slab',
			'font_variant' => 'normal',
			'font_size' => '16px',
			'font_color' => '#7f8088',
			'css_selectors' => '#sidebar .widget li a',
		),
		'sidebar_font' => array(
			'preview_text' => __( 'Sidebar Font', 'myportfolio' ),
			'preview_color' => 'light',
			'font_family' => 'Roboto',
			'font_variant' => 'normal',
			'font_size' => '16px',
			'font_color' => '#999a9f',
			'css_selectors' => '#sidebar .widget'
		),
		'h1_headline' => array(
			'preview_text' => __( 'Content H1', 'myportfolio' ),
			'preview_color' => 'light',
			'font_family' => 'Roboto Slab',
			'font_variant' => 'normal',
			'font_size' => '34px',
			'font_color' => '#33343d',
			'css_selectors' => 'h1'
		),
		'h2_headline' => array(
			'preview_text' => __( 'Content H2', 'myportfolio' ),
			'preview_color' => 'light',
			'font_family' => 'Roboto Slab',
			'font_variant' => 'normal',
			'font_size' => '30px',
			'font_color' => '#33343d',
			'css_selectors' => 'h2'
		),
		'h3_headline' => array(
			'preview_text' => __( 'Content H3', 'myportfolio' ),
			'preview_color' => 'light',
			'font_family' => 'Roboto Slab',
			'font_variant' => 'normal',
			'font_size' => '26px',
			'font_color' => '#33343d',
			'css_selectors' => 'h3'
		),
		'h4_headline' => array(
			'preview_text' => __( 'Content H4', 'myportfolio' ),
			'preview_color' => 'light',
			'font_family' => 'Roboto Slab',
			'font_variant' => 'normal',
			'font_size' => '22px',
			'font_color' => '#33343d',
			'css_selectors' => 'h4'
		),
		'h5_headline' => array(
			'preview_text' => __( 'Content H5', 'myportfolio' ),
			'preview_color' => 'light',
			'font_family' => 'Roboto Slab',
			'font_variant' => 'normal',
			'font_size' => '20px',
			'font_color' => '#33343d',
			'css_selectors' => 'h5'
		),
		'h6_headline' => array(
			'preview_text' => __( 'Content H6', 'myportfolio' ),
			'preview_color' => 'light',
			'font_family' => 'Roboto Slab',
			'font_variant' => 'normal',
			'font_size' => '18px',
			'font_color' => '#33343d',
			'css_selectors' => 'h6'
		)
	));
}