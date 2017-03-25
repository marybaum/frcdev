<?php

/**
 * Template name: single
 *
 */

 //add foundation markup to loop


add_action('genesis_before_loop', 'rpsingle_before_loop');

function rpsingle_before_loop(){
	echo '<div class="row"><div class="small-12 large-9 large-centered columns">';
}

add_action('genesis_after_loop', 'rpsingle_after_loop');

function rpsingle_after_loop (){
	echo "</div></div>";
}

//add opt-in widget after post
add_action('genesis_before_comments' , 'gyf_optin_before_comments');

function gyf_optin_before_comments () {

	if ( is_active_sidebar( 'optin-after-entry' ) ) {

			echo '<div class="row">';

	genesis_widget_area( 'optin-after-entry', array(
		'before' => '<div class="optin widget-area"><div class="small-12 columns">',
		'after'  => '</div></div>',
	) );

echo '</div>';
	}
}

genesis();