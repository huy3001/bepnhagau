<?php
// make sure to not include translations
$args['presets']['default'] = array(
	'title' => 'Default',
	'demo' => 'http://demo.mythemeshop.com/myportfolio/',
	'thumbnail' => get_template_directory_uri().'/options/demo-importer/demo-files/default/thumb.jpg',
	'menus' => array( 'primary-menu' => 'Menu', 'footer-menu' => 'Footer Menu', 'mobile' => ''),
	'options' => array( 'show_on_front' => 'posts', 'posts_per_page' => 9 ),
);

$args['presets']['demo-1'] = array(
	'title' => 'Blog',
	'demo' => 'http://demo.mythemeshop.com/myportfolio/blog/',
	'thumbnail' => get_template_directory_uri().'/options/demo-importer/demo-files/blog/thumb.jpg',
	'menus' => array( 'primary-menu' => 'Menu', 'footer-menu' => 'Footer Menu', 'mobile' => ''),
	'options' => array( 'show_on_front' => 'page', 'page_on_front' => '383'),
);

global $mts_presets;
$mts_presets = $args['presets'];
