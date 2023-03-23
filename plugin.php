<?php
/*
Plugin Name: Fake Folders
Plugin URI: https://github.com/jstartorg/yourls-fake-folders
Description: A Yourls plugin that allows you to fake having named links in folders (ie https://sh.ort/help/git where "help" is not a real folder)
Version: 1.0
Author: Danny Summerlin
*/

if( !defined( 'YOURLS_ABSPATH' ) ) die();
// move this to find pattern to use in URLs themselves to gather fake folders
$fakeFolders = array(
	'reports',
	'forms',
	'alumni',
	'cm'
);
yourls_add_action('loader_failed','checkForFakeFolder');
function checkForFakeFolder($args) {
	if( preg_match('!^'. implode($fakeFolders,"|") .'(.*)!', $args[0], $matches) ){
		define('FOLDER_PREFIX', $matches[0]);
		$keyword = substr(yourls_sanitize_keyword( $matches[1] ), 1); // The new keyword, sub trigger
		yourls_add_filter('redirect_location', 'executeRedirect'); // Add our ad-forwarding function
		include( YOURLS_ABSPATH.'/yourls-go.php' ); // Retry forwarding
		exit;
	}
}
function executeRedirect($url, $code) {
	$currentLink = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$pieces = explode('/', $currentLink);
	$shortcode = array_pop($pieces);
	if(in_array($shortcode, [null,'']))
		$shortcode = array_pop($pieces);
	return '//' . $_SERVER['SERVER_NAME'] . "/${FOLDER_PREFIX}-$shortcode";
}
