<?php

/**
 * Lightbox functions
 * @package package sellphotos
 * @since sellphotos 1.0
 */

// Add AJAX actions
add_action('wp_ajax_sellphotos_lightbox_ajax', 'sellphotos_add_to_lightbox');
add_action('wp_ajax_nopriv_sellphotos_lightbox_ajax', 'sellphotos_add_to_lightbox');

function sellphotos_add_to_lightbox() {
	$blogname = get_site_url();
	$blogname = str_replace( array(':','.','/','-'), '', $blogname);
	
	// get post ID
	$id = $_POST['id'];
	$cookie_name = '_sellphotos_lightbox_' . $blogname;
	if( isset($_COOKIE[$cookie_name]) ) {

		$cookie=  $_COOKIE[$cookie_name];
		$lightbox=explode(',',$cookie);

		if(!in_array($id,$lightbox)) {
			$cookie=$cookie.','.$id;
			$status = true;
		} else {
		// not in array
		// text will not update when clicked
		}

	} else {
		$cookie=$id;
		$status = true;
    }
	// set lightbox cookie
	setcookie($cookie_name, $cookie ,time()+3600*24*365,'/');

	// generate the response
	$response = json_encode(
		array(
			'success' => $status,
			'postID' => $id
		)
	);
	// JSON header
	header('Content-type: application/json');
	echo $response;
	die();
}

// Add AJAX actions
add_action('wp_ajax_sellphotos_lightbox_remove_ajax', 'sellphotos_remove_from_lightbox');
add_action('wp_ajax_nopriv_sellphotos_lightbox_remove_ajax', 'sellphotos_remove_from_lightbox');

function sellphotos_remove_from_lightbox() {
	$blogname = get_site_url();
	$blogname = str_replace( array(':','.','/','-'), '', $blogname);
	
	// get post ID
	$id = $_POST['id'];
	$cookie_name = '_sellphotos_lightbox_' . $blogname;

	if( isset($_COOKIE[$cookie_name]) ) {

		$cookie=  $_COOKIE[$cookie_name];
		$lightbox=explode(',', $cookie);

		// remove post ID from lightbox cookie
		unset($lightbox[array_search($id, $lightbox)]);
		$lightbox = implode(',', $lightbox);
		$cookie = $lightbox;
		$status = true;

    }
	// set lightbox cookie
	setcookie($cookie_name, $cookie ,time()+3600*24*365,'/');

	// generate the response
	$response = json_encode(
		array(
			'success' => $status,
			'postID' => $id
		)
	);
	// JSON header
	header('Content-type: application/json');
	echo $response;
	die();
}

function sellphotos_in_lightbox() {
	$blogname = get_site_url();
	$blogname = str_replace( array(':','.','/','-'), '', $blogname);
	
	global $post;
	$cookie_name = '_sellphotos_lightbox_' . $blogname;
	$lightbox=array();
	if(isset($_COOKIE[$cookie_name])) {
		$cookie= $_COOKIE[$cookie_name];
		$lightbox=explode(',', $cookie);
	}
	if(in_array($post->ID,$lightbox))
		return true;
}