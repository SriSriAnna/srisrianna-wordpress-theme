<?php
/**
 * Sprig includes
 *
 * The $sprig_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 */
$sprig_includes = array(
	'inc/utils.php',                  // Utility functions
	'inc/init.php',                   // Initial theme setup and constants
	'inc/config.php',                 // Configuration
	'inc/activation.php',             // Theme activation
	'inc/titles.php',                 // Page titles
	'inc/wp_foundation_navwalker.php', // Foundation Nav Walker
	'inc/gallery.php',                // Custom [gallery] modifications
	'inc/comments.php',               // Custom comments modifications
	'inc/scripts.php',                // Scripts and stylesheets
	'inc/twigpress.php',                   // Load TwigPress Engine
	'inc/extras.php',                  // Custom functions
	'inc/paging.php'
);

foreach ($sprig_includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf(__('Error locating %s for inclusion', 'sprig'), $file), E_USER_ERROR);
  }

  require_once $filepath;
}
add_image_size( 'wpsf-featured', 450, 200, true);
add_image_size( 'wpsf-post-featured', 638, 250, true);

remove_action( 'wp_head', 'wp_generator' ) ;
remove_action( 'wp_head', 'wlwmanifest_link' ) ;
remove_action( 'wp_head', 'rsd_link' ) ;
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'feed_links_extra', 3 );
function no_wordpress_errors(){
  return 'GET OFF MY LAWN !! RIGHT NOW !!';
}
add_filter( 'login_errors', 'no_wordpress_errors' );
add_filter('redirect_canonical', 'stop_guessing');
add_filter('show_admin_bar', '__return_false');
add_filter( 'auth_cookie_expiration', 'stay_logged_in_for_1_year' );
function stay_logged_in_for_1_year( $expire ) {
  return 31556926; // 1 year in seconds
}

function stop_guessing($url) {
 if (is_404()) {
   return false;
 }
 return $url;
}
//define( 'WP_POST_REVISIONS', 3);
//define( 'AUTOSAVE_INTERVAL', 120 );
//define( 'DISALLOW_FILE_EDIT', true );

unset($file, $filepath);
