<?php
/*
Plugin Name: Fake Folders
Plugin URI: https://github.com/dannysummerlin/yourls-fake-folders
Description: Converts forward slashes (/) into underscores (_) to match public URLs that look like folders to Short URLs with underscores (eg https://sh.ort/event/invite maps to a Short URL of event_invite)
Version: 1.0
Author: Danny Summerlin
*/

if( !defined( 'YOURLS_ABSPATH' ) ) die();

define('FAKE_FOLDER_PATTERN','/\/([\w-]+)$/');
yourls_add_filter( 'get_shorturl_charset', 'fakeFolder_addUnderscore' );
function fakeFolder_addUnderscore($in) { return $in.'_'; }

yourls_add_action('loader_failed','fakeFolder_checkForFakeFolder');
function fakeFolder_checkForFakeFolder($args) {
	if(preg_match(FAKE_FOLDER_PATTERN,$args[0])) {
		yourls_add_filter('redirect_location', 'fakeFolder_useFakeFolder');
		include( YOURLS_ABSPATH.'/yourls-go.php' );
		exit;
	}
}
function fakeFolder_useFakeFolder($url, $statusCode) {
	$currentLink = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	if($currentLink[-1] == '/')
		$currentLink = substr($currentLink, 0, -1);
	return preg_replace('/\/([\w-]+)$/',"_$1",$currentLink);
}
