<?php
/*
Plugin Name: keyword-check
Plugin URI: https://github.com/za22061991/yourls-keyword-limiter/
Description: This plugin check for blacklisted keywords.
Version: 1.0
Author: RER
Author URI: https://github.com/za22061991/
*/

// No direct call
if( !defined( 'YOURLS_ABSPATH' ) ) die();

// Register our plugin admin page
yourls_add_action( 'plugins_loaded', 'keyword_check_add_page' );

function keyword_check_add_page() {
	yourls_register_plugin_page( 'kwcheck_page', 'Keyword Check', 'keyword_check_do_page' );

	if( yourls_get_option( 'max_length_opt' ) == '' ) {
		yourls_update_option( 'max_length_opt', 20);
	}
}

// Display admin page
function keyword_check_do_page() {

	// Check if a form was submitted
	if( isset( $_POST['max_length_opt'] ) ) {
		// Check nonce
		yourls_verify_nonce( 'kwcheck_page' );

		// Process form
		keyword_check_update_option();
	}

	// Get value from database
	$max_length = yourls_get_option( 'max_length_opt' );
	$pattern = yourls_get_option( 'pattern_opt' );
	$pattern_enable = yourls_get_option( 'pattern_enable' );

	// Create nonce
	$nonce = yourls_create_nonce( 'kwcheck_page' );

	echo <<<HTML
		<h2>Keyword Check Administration Page</h2>
		<form method="post">
		<input type="hidden" name="nonce" value="$nonce" />
		<p><label for="max_length_opt">Maximum keyword length</label> <input type="text" id="max_length_opt" name="max_length_opt" value="$max_length" /></p>
		<p><input type="checkbox" id="pattern_enable" name="pattern_enable" onclick="document.getElementById('pattern_opt').disabled=!this.checked;" value="enable">
			<label for="pattern_opt">Enable RegEx pattern limiter</label>
			<input type="text" id="pattern_opt" name="pattern_opt" value="$pattern" /></p>
		<p><input type="submit" value="Update value"/></p>
		</form>

HTML;

	if( $pattern_enable ) {
	echo <<<HTML
		<script>
			document.getElementById("pattern_enable").checked = true;
			document.getElementById("pattern_opt").disabled = false;
		</script>
HTML;
	}
	else {
	echo <<<HTML
		<script>
			document.getElementById("pattern_enable").checked = false;
			document.getElementById("pattern_opt").disabled = true;
		</script>
HTML;
	}
}

//Update option
function keyword_check_update_option() {
	$max_length_in = $_POST['max_length_opt'];

	if( $max_length_in ) {
		$max_length_in = intval($max_length_in);
		yourls_update_option( 'max_length_opt', $max_length_in );
	}

	if( isset( $_POST['pattern_enable'] ) && $_POST['pattern_enable'] == "enable") {
		$regex = strval($_POST['pattern_opt']);
		yourls_update_option( 'pattern_opt', $regex );
		yourls_update_option( 'pattern_enable', TRUE );
	}
	else {
		yourls_update_option( 'pattern_enable', FALSE);
	}
}

// Hook our custom function into the 'shunt_add_new_link' filter
yourls_add_filter( 'shunt_add_new_link', 'keyword_check' );

// Check the keyword
function keyword_check( $too_long, $url, $keyword ) {
	$max_length = yourls_get_option( 'max_length_opt' );
	$pattern_enable = yourls_get_option( 'pattern_enable' );
	$pattern = yourls_get_option( 'pattern_opt' );
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
	elseif ( $pattern_enable && preg_match( $pattern, $keyword ) > 0 ) {
		$return['status']   = 'fail';
		$return['code']     = 'error:keyword';
		$return['message']  = "Sorry, the keyword pattern is forbidden.";
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
