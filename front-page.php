<?php

//* frc custom body class
function frc_add_body_class( $classes ) {
	$classes[] = 'frc';
		return $classes;
}

//* Add widget support for homepage if widgets are being used
add_action( 'genesis_meta', 'frc_front_page_genesis_meta' );
function frc_front_page_genesis_meta() {

	if ( is_home() ) {
		
		//* Force full width content layout
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
		
		//* Remove site header elements
		remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
		remove_action( 'genesis_header', 'genesis_do_header' );
		remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );
		
		//* Remove navigation
		remove_action( 'genesis_after_header', 'genesis_do_nav', 15 );
		remove_action( 'genesis_footer', 'genesis_do_subnav', 7 );
		
		//* Remove Minimum after header
		remove_action( 'genesis_after_header', 'minimum_site_tagline' );
		
		//* Remove breadcrumbs
		remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

		//* Remove entry meta in entry footer and Genesis loop
		remove_action( 'genesis_loop', 'genesis_do_loop' );
		
		//* Remove entry footer functions
		remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
		remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
		remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
		
		//* Force full width content layout
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

	}

	if ( is_active_sidebar( 'home-featured-left' ) || 	is_active_sidebar( 'home-featured-middle' ) || is_active_sidebar( 'home-featured-right' ) ) {

		//* Add Home featured Widget areas
		add_action( 'genesis_before_content_sidebar_wrap', 'frc_home_featured', 15 );

	}
}

//* Add markup for homepage widgets
function frc_home_featured() {
			
		//add home-featured containing div for the ball
		echo '<div class="home-featured">';

		genesis_widget_area( 'home-featured-left', array(
			'before'=> '<div class="home-featured-left">',
			'after'	=> '</div>',
		) );

		genesis_widget_area( 'home-featured-middle', array(
			'before'=> '<div class="home-featured-middle">',
			'after'	=> '</div>',
		) );

		genesis_widget_area( 'home-featured-right', array(
			'before'=> '<div class="home-featured-right">',
			'after'	=> '</div>',
		) );

	echo '</div>'; //* end .home-featured

}



//* Run the Genesis loop
genesis();
