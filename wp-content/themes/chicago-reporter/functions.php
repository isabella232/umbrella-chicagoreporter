<?php
define( 'INN_MEMBER', TRUE );

/**
 * Include theme files
 *
 * Based off of how Largo loads files: https://github.com/INN/Largo/blob/master/functions.php#L358
 *
 * 1. hook function Largo() on after_setup_theme
 * 2. function Largo() runs Largo::get_instance()
 * 3. Largo::get_instance() runs Largo::require_files()
 *
 * This function is intended to be easily copied between child themes, and for that reason is not prefixed with this child theme's normal prefix.
 *
 * @link https://github.com/INN/Largo/blob/master/functions.php#L145
 */
function largo_child_require_files() {
	$includes = array(
		'/inc/landing-archive-shortcode.php',
		'/inc/series-landing.php',
		'/inc/taxonomies.php',
		'/inc/tax-shortcode.php',
		'/inc/thumb-shortcode.php',
		'/inc/post-tags.php',
		'/inc/widgets/cr-magazine-widget.php',
		'/homepages/layouts/ChicagoReporter.php'
	);

	if ( class_exists( 'WP_CLI_Command' ) ) {
		require __DIR__ . '/inc/cli.php';
		WP_CLI::add_command( 'cr', 'CR_WP_CLI' );
	}


	foreach ($includes as $include ) {
		require_once( get_stylesheet_directory() . $include );
	}
}
add_action( 'after_setup_theme', 'largo_child_require_files' );

// Add OpenSans to the enqued fonts
if( !function_exists( 'cr_scripts') ) {
	function cr_scripts() {
		wp_enqueue_style( 'open-sans-condensed', '//fonts.googleapis.com/css?family=Open+Sans|Open+Sans+Condensed:700,300,300italic' );
	}
}
add_action( 'wp_enqueue_scripts', 'cr_scripts' );

/**
 * Include compiled style.css
 */
function cr_styles_less() {
	wp_dequeue_style( 'largo-child-styles' );
	$suffix = (LARGO_DEBUG)? '' : '.min';
	wp_enqueue_style( 'chicagoreporter', get_stylesheet_directory_uri().'/css/chicagoreporter' . $suffix . '.css' );


	// if the post template uses the photo header, include those styles 
	global $template;
	if ( basename( $template ) === 'single-photo-header.php' ) {
		var_log( "success" );
		wp_enqueue_style( 'chicagoreporter-photo-header', get_stylesheet_directory_uri().'/css/photo-header' . $suffix . '.css' );
	}
}
add_action( 'wp_enqueue_scripts', 'cr_styles_less', 20 );

/**
* Custom image sizes
*/
function cr_image_sizes() {
	// Homepage article list images
	// 220 pixels wide by 150 pixels tall, hard crop mode
	add_image_size( 'list-thumbnail', 220, 150, true );
}
add_action('init', 'cr_image_sizes', 9); // Largo homepage init uses priority 0, CR must init after

/**
 * Swap the grey-text INN logo with the black-text INN logo
 */
	function inn_logo() {
		?>
			<a href="//inn.org/" id="inn-logo-container">
				<img id="inn-logo" src="<?php echo(get_template_directory_uri() . "/img/inn_logo_blue_final.png"); ?>" alt="<?php printf(__("%s is a member of the Institute for Nonprofit News", "largo"), get_bloginfo('name')); ?>" />
			</a>
		<?php
	}
