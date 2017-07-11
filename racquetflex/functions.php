<?php
/**
 * RacquetFlex.
 *
 * This file adds functions to the RacquetFlex Theme.
 *
 * @package RacquetFlex
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://www.studiopress.com/
 */

// Start the engine.
include_once(get_template_directory() . '/lib/init.php');

// Setup Theme.
include_once(get_stylesheet_directory() . '/lib/theme-defaults.php');

// Set Localization (do not remove).
add_action('after_setup_theme', 'rflex_localization_setup');
function rflex_localization_setup()
{
    load_child_theme_textdomain('racquetflex', get_stylesheet_directory() . '/languages');
}

// Add the helper functions.
include_once(get_stylesheet_directory() . '/lib/helper-functions.php');

// Add Image upload and Color select to WordPress Theme Customizer.
require_once(get_stylesheet_directory() . '/lib/customize.php');

// Include Customizer CSS.
include_once(get_stylesheet_directory() . '/lib/output.php');

// Add WooCommerce support.
include_once(get_stylesheet_directory() . '/lib/woocommerce/woocommerce-setup.php');

// Add the required WooCommerce styles and Customizer CSS.
include_once(get_stylesheet_directory() . '/lib/woocommerce/woocommerce-output.php');

// Add the Genesis Connect WooCommerce notice.
include_once(get_stylesheet_directory() . '/lib/woocommerce/woocommerce-notice.php');

// Child theme (do not remove).
define('CHILD_THEME_NAME', 'RacquetFlex');
define('CHILD_THEME_URL', 'http://www.github.com/marybaum');
define('CHILD_THEME_VERSION', '2.3.0');

// Enqueue Scripts and Styles.
add_action('wp_enqueue_scripts', 'rflex_enqueue_scripts_styles');
function rflex_enqueue_scripts_styles()
{

    wp_enqueue_style('racquetflex-fonts', '//fonts.googleapis.com/css?family=Montserrat:200,300,400,600,800', array(), CHILD_THEME_VERSION);
    wp_enqueue_style('dashicons');

    $suffix = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min';
    wp_enqueue_script('racquetflex-responsive-menu', get_stylesheet_directory_uri() . "/js/responsive-menus{$suffix}.js", array('jquery'), CHILD_THEME_VERSION, true);
    wp_localize_script(
        'racquetflex-responsive-menu',
        'genesis_responsive_menu',
        rflex_responsive_menu_settings()
    );

}

// Define our responsive menu settings.
function rflex_responsive_menu_settings()
{

    $settings = array(
        'mainMenu' => __('Menu', 'racquetflex'),
        'menuIconClass' => 'dashicons-before dashicons-menu',
        'subMenu' => __('Submenu', 'racquetflex'),
        'subMenuIconsClass' => 'dashicons-before dashicons-arrow-down-alt2',
        'menuClasses' => array(
            'combine' => array(
                '.nav-primary',
                '.nav-header',
            ),
            'others' => array(),
        ),
    );

    return $settings;

}

// Add HTML5 markup structure.
add_theme_support('html5', array('caption', 'comment-form', 'comment-list', 'gallery', 'search-form'));

// Add Accessibility support.
add_theme_support('genesis-accessibility', array('404-page', 'drop-down-menu', 'headings', 'rems', 'search-form', 'skip-links'));

// Add viewport meta tag for mobile browsers.
add_theme_support('genesis-responsive-viewport');

// Add support for custom header.
add_theme_support('custom-header', array(
    'width' => 600,
    'height' => 160,
    'header-selector' => '.site-title a',
    'header-text' => false,
    'flex-height' => true,
));

// Add support for custom background.
add_theme_support('custom-background');

// Add support for after entry widget.
add_theme_support('genesis-after-entry-widget-area');

// Add support for 3-column footer widgets.
add_theme_support('genesis-footer-widgets', 3);

// Add Image Sizes.
add_image_size('featured', 720, 400, TRUE);
add_image_size('giant', 1500, 600, false);
add_image_size('medium', 750, 0, false);
add_image_size('square', 600, 600, true);
add_image_size('small', 300, 300, TRUE);


// Rename primary and secondary navigation menus.
add_theme_support('genesis-menus', array('primary' => __('After Header Menu', 'racquetflex'), 'secondary' => __('Footer Menu', 'racquetflex')));

// Reposition the secondary navigation menu.
remove_action('genesis_after_header', 'genesis_do_subnav');
add_action('genesis_footer', 'genesis_do_subnav', 5);

// Reduce the secondary navigation menu to one level depth.
add_filter('wp_nav_menu_args', 'rflex_secondary_menu_args');
function rflex_secondary_menu_args($args)
{

    if ('secondary' != $args['theme_location']) {
        return $args;
    }

    $args['depth'] = 1;

    return $args;

}

//* Reposition the breadcrumbs
function rflex_move_crumbs() {

	if(is_single('post' ))  {
		remove_action('genesis_before_loop', 'genesis_do_breadcrumbs', 2);
		add_action( 'genesis_entry_header', 'genesis_do_breadcrumbs' , 6 );
	}
	else    {
		remove_action('genesis_before_loop', 'genesis_do_breadcrumbs');
		add_action('genesis_after_header', 'genesis_do_breadcrumbs');
	}
}
//* Custom breadcrumbs arguments
add_filter('genesis_breadcrumb_args', 'rflex_breadcrumb_args');
function rflex_breadcrumb_args($args) {
    $args['sep'] = ' &raquo; ';
    $args['list_sep'] = ', ';
    // Genesis 1.5 and later
    $args['display'] = true;
    $args['labels']['prefix'] = __('You are here: ', 'rflex');
    $args['labels']['author'] = __(' ', 'rflex');
    $args['labels']['category'] = __(' ', 'rflex');
    // Genesis 1.6 and later
    $args['labels']['tag'] = __(' ', 'rflex');
    $args['labels']['date'] = __(' ', 'rflex');
    $args['labels']['search'] = __('Find ', 'rflex');
    $args['labels']['tax'] = __(' ', 'rflex');
    $args['labels']['post_type'] = __(' ', 'rflex');
    $args['labels']['404'] = __('404', 'rflex');
    // Genesis 1.5 and later
    return $args;
}

//* Nuke the site description
remove_action('genesis_site_description', 'genesis_seo_site_description');

//* Nuke most of the entry meta in the entry header (requires HTML5 theme support)
add_filter('genesis_post_info', 'sp_post_info_filter');
function sp_post_info_filter($post_info)
{
    $post_info = '[post_edit]';
    return $post_info;
}
//* Remove the entry meta in the entry footer (requires HTML5 theme support)
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

//* Force full-width-content layout setting
add_filter('genesis_pre_get_option_site_layout', '__genesis_return_full_width_content');

function rflex_body_class_add_categories($classes)
{

    // Get the categories that are assigned to this post
    $categories = get_the_category();

    // Loop over each category in the $categories array
    foreach ($categories as $current_category) {

        // Add the current category's slug to the $body_classes array
        $classes[] = $current_category->slug;

    }

    // Return the $body_classes array
    return $classes;
}

add_filter('body_class', 'rflex_body_class_add_categories');


add_filter('body_class', 'tf_featured_img_body_class');
/**
 * Add body class for single Posts and static Pages with Featured images...
 *
 * @return array
 */
function tf_featured_img_body_class($classes)
{

    if (is_singular(array('post')) && has_post_thumbnail()) {
        $classes[] = 'haspic';
    }
    return $classes;
}

//And without.
add_filter('body_class', 'tf_nopic');

/**
 * @param $classes
 *
 * @return array
 */
function tf_nopic($classes)
{
    if (!has_post_thumbnail() && is_singular('post' || 'page')) {
        $classes[] = 'nopic';
    }
    return $classes;
}

// Add the featured image under the header if a post has one,

add_action('genesis_before_loop', 'rflex_featured_img', 9);
function rflex_featured_img()
{
    if (is_singular(array('post' || 'page')) && has_post_thumbnail()) {
        echo '<div class = "hero-pic">' .  genesis_get_image(array('size' => 'giant' )) .  '</div>';
    } else {
        return;
    }
}


// Change size of the Gravatar in the author box.
add_filter('genesis_author_box_gravatar_size', 'rflex_author_box_gravatar');
function rflex_author_box_gravatar($size)
{
    return 90;
}

// Change the Gravatar size in the entry comments.
add_filter('genesis_comment_list_args', 'rflex_comments_gravatar');
function rflex_comments_gravatar($args)
{

    $args['avatar_size'] = 60;

    return $args;

}

// In Pros category, add the meetpros widget.
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

add_action( 'genesis_entry_footer', 'frc_meetpros');
function frc_meetpros() {
	if ( is_singular ( 'post' ) && in_category ( 'Pros') )
		genesis_widget_area( 'meetpros', array(
			'before' => '<div class="meetpros">',
			'after' => '</div>',
		) );
}

//* Change the speak-your-mind title in comments
add_filter('comment_form_defaults', 'sp_comment_form_defaults');
function sp_comment_form_defaults($defaults) {
	$defaults['title_reply'] = __('Your serve.');
    return $defaults;
}

// Register widgeted areas

genesis_register_sidebar(array(
    'id' => 'home-featured-left',
    'name' => __('Home Featured Left', 'frc'),
    'description' => __('This is the featured left area on the homepage.', 'frc'),
    'before_title' => '<h3 class="widgettitle">',
    'after_title' => "</h3>\n",
));

genesis_register_sidebar(array(
    'id' => 'home-featured-middle',
    'name' => __('Home Featured Middle', 'frc'),
    'description' => __('This is the featured middle area on the homepage.', 'frc'),
    'before_title' => '<h1 class="widgettitle">',
    'after_title' => "</h1>\n",
));

genesis_register_sidebar(array(
    'id' => 'home-featured-right',
    'name' => __('Home Featured Right', 'frc'),
    'description' => __('This is the featured right area on the homepage.', 'frc'),
));

genesis_register_sidebar(array(
    'id' => 'optin-after-entry',
    'name' => __('Opt-in After Entry', 'racquetpress'),
    'description' => __('This is the opt-in form after a single entry.', 'racquetpress'),
    'before_title' => __('<h4>', 'racquetpress'),
    'after_title' => __('</h4>', 'racquetpress'),
));
genesis_register_sidebar( array(
	'id'            => 'meetpros',
	'name'          => __( 'meetpros', 'frc' ),
	'description'   => __( 'Meetpros widget', 'frc' ),
	'before'         => '<div class="meetpros">',
	'after'          => '</div>\n',
) );
