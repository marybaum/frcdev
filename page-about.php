<?php

/**
 * Template name: page
 *
 */

 //add foundation markup to loop


add_action('genesis_before_loop', 'gyfsinglesingle_before_loop');

function gyfsinglesingle_before_loop(){
	echo '<div class="row large-8 columns">';
}


add_action('genesis_after_loop', 'gyfsingle_after_loop');

function gyfsingle_after_loop (){
	echo "</div></div>";
}

 genesis();
