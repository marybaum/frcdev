<?php

 /**
  * Template Name: Page
  * @author MHB
  * @package  Customizations
	*
	**/




//add foundation markup to loop

add_action( 'genesis_after_header' , 'gyf_do_loop'  );
function gyf_do_loop() {


add_action('genesis_before_loop', 'gyf_before_loop');

function gyf_before_loop(){
	echo '<div class="row">
				<ul class="small-block-grid-3 medium-block-grid-3 large-block-grid-3">';
}

add_action('genesis_before_entry', 'gyf_before_entry');

function gyf_before_entry(){
	echo '<li class="post">';
}

add_action('genesis_after_entry', 'gyf_after_entry');

function gyf_after_entry(){
	echo "</li>";
}

add_action('genesis_after_loop', 'gyf_after_loop');

function gyf_after_loop (){
	echo "</ul></div>";
}
}

//* Customize the entry meta in the entry header (requires HTML5 theme support)
add_filter( 'genesis_post_info', 'sp_post_info_filter' );
function sp_post_info_filter($post_info) {
	$post_info = '[post_date] by [post_author_posts_link] [post_comments] [post_edit]';
	return $post_info;
}

//* Remove the entry meta in the entry footer (requires HTML5 theme support)
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );



genesis();













