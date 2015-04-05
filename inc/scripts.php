<?php
/**
 * Scripts and stylesheets
 */
function sprig_scripts() {
	/**
	* The build task in Gulp renames production assets with a hash
	* Read the asset names from assets-manifest.json
	*/
	$assets = array(
		'css'             => '/build/assets/css/main.css',
		'js'              => '/build/assets/js/main.js'
	);

	wp_enqueue_style('sprig_css', get_template_directory_uri() . $assets['css'], false, 
		filemtime( get_template_directory() . $assets['css']));
	wp_enqueue_script('sprig_js', get_template_directory_uri() . $assets['js'], array(), null, true);

	if (is_single() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}

}
add_action('wp_enqueue_scripts', 'sprig_scripts', 100);
