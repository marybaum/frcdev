<?php

 /**
  * Template Name: Index
  * @author MHB
  * @package  Customizations
	*
	**/

//add foundation markup to loop

add_action('genesis_after_header' , 'rp_custom_loop');

function rp_custom_loop() {


add_action('genesis_before_loop', 'rp_before_loop');

function rp_before_loop(){
	echo '<div class="row">
	        <div class="small-12 medium-10 medium-centered columns">
				<ul class="small-block-grid-1 medium-block-grid-2 large-block-grid-3 xlarge-block-grid-6">';
}

add_action('genesis_before_entry', 'rp_before_entry');

function rp_before_entry(){
	echo '<li class="post">';
}

add_action('genesis_after_entry', 'rp_after_entry');

function rp_after_entry(){
	echo "</li>";
}

add_action('genesis_after_loop', 'rp_after_loop');

function rp_after_loop (){
	echo "</ul></div></div>";
}}

//* Customize the entry meta in the entry header (requires HTML5 theme support)
add_filter( 'genesis_post_info', 'rp_post_info_filter' );
function rp_post_info_filter($post_info) {
	$post_info = '[post_edit]';
	return $post_info;
}

//* Remove the entry meta in the entry footer (requires HTML5 theme support)
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

genesis();













