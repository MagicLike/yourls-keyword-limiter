<?php
/*
Plugin Name: keyword check
Plugin URI: https://github.com/adigitalife/yourls-limit-keyword-length/
Description: This plugin check for blacklisted keywords.
Version: 1.0
Author: RER
Author URI: http://adigitalife.net/
*/

// Hook our custom function into the 'shunt_add_new_link' filter
yourls_add_filter( 'shunt_add_new_link', 'keyword_check' );

// Check the keyword
function keyword_check( $too_long, $url, $keyword ) {
	$max_length = 20;
	$pattern = "/(?<!\d)\d{5,6}(?!\d)/";
        $kwlist = array('theft', 'fridge', 'porn', 'accesscontrol', 'rfid', 'refrigerator',
                        'growkit', 'freeze', 'lossprevention', 'gacor', 'retail', 'sex',
                        'ledh', 'smartshelf', 'goldenteacher', 'mattress', 'ledh', 'ledp',
                        'construction', 'building', 'tools');

	if ( strlen($keyword) > $max_length ) {
		$return['status']   = 'fail';
		$return['code']     = 'error:keyword';
		$return['message']  = "Sorry, the keyword is too long. It can't be more than " . $max_length . " characters.";
		return yourls_apply_filter( 'add_new_link_keyword_too_long', $return );
	}
	elseif ( preg_match($pattern, $keyword ) > 0 ) {
		$return['status']   = 'fail';
		$return['code']     = 'error:keyword';
		$return['message']  = "Sorry, the keyword is forbidden.";
		return yourls_apply_filter( 'add_new_link_number', $return );
	}
	else {
		foreach ($kwlist as $kw) {
			if ( strpos( $keyword, $kw ) !== false ) {
				$return['status']   = 'fail';
				$return['code']     = 'error:keyword';
				$return['message']  = "Sorry, the keyword contains blaclisted keywords.";
				return yourls_apply_filter( 'add_new_link_blacklisted_keyword', $return );
				break;
			}
		}
	}
	return false;
}
