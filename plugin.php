<?php
/*
Plugin Name: Fake Folders
Plugin URI: https://github.com/dannysummerlin/yourls-fake-folders
Description: Converts forward slashes (/) into underscores (_) to match public URLs that look like folders to Short URLs with underscores (eg https://sh.ort/event/invite maps to a Short URL of event_invite)
Version: 1.0
Author: Danny Summerlin
*/

if( !defined( 'YOURLS_ABSPATH' ) ) die();

function fakeFolder_addUnderscore($in) { return $in.'_'; }
yourls_add_filter( 'get_shorturl_charset', 'fakeFolder_addUnderscore' );

function fakeFolder_useFakeFolder($keyword) {
	if(strstr($keyword,'/')) {
		if($keyword[-1] == '/')
			$keyword = substr($keyword, 0, -1);
		if($keyword[0] == '/')
			$keyword = substr($keyword, 1);
		return str_replace('/','_',$keyword);
	} else
		return $keyword;
}
yourls_add_filter('get_request', 'fakeFolder_useFakeFolder');