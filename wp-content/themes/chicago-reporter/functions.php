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
		'/inc/DDCPC.php',
		'/inc/metaboxes.php',
		'/inc/landing-archive-shortcode.php',
		'/inc/series-landing.php',
		'/inc/taxonomies.php',
		'/inc/tax-shortcode.php',
		'/inc/thumb-shortcode.php',
		'/inc/post-tags.php',
		'/inc/photo-header-template.php',
		'/inc/widgets/cr-magazine-widget.php',
		'/homepages/layouts/ChicagoReporter.php',
		'/homepages/layouts/ChicagoReporterComplex.php'
	);

	if ( class_exists( 'WP_CLI_Command' ) ) {
		require __DIR__ . '/inc/cli.php';
		WP_CLI::add_command( 'cr', 'CR_WP_CLI' );
	}


	foreach ($includes as $include ) {
		require_once( get_stylesheet_directory() . $include );
	}
}
add_action( 'after_setup_theme', 'largo_child_require_files', 11 );

// Add OpenSans to the enqued fonts
if( !function_exists( 'cr_scripts') ) {
	function cr_scripts() {
		wp_enqueue_style( 'open-sans-condensed', '//fonts.googleapis.com/css?family=Open+Sans+Condensed:700|Open+Sans:400,700' );
	}

	//if ( is_page_template( 'single-photo-header.php' ) | is_page_template( 'series-landing-photo-header.php' ) ) {
		wp_enqueue_script(
			'series-photo-header',
			get_stylesheet_directory_uri() . '/js/photo-header.js',
			array('jquery'),
			'1.0',
			true
		);
	//}
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
	if ( 
		basename( $template ) === 'single-photo-header.php' ||
		basename( $template ) === 'series-landing-photo-header.php'
	) {
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


// [action-box message="foo-value" ]
function action_func( $atts ) {
    $a = shortcode_atts( array(
        'message' => 'something',
    ), $atts );

    return '<div class="action-box"><div class="action-message">' . "{$a['message']}" . '</div><a href="http://salsa3.salsalabs.com/o/50480/p/salsa/web/common/public/signup?signup_page_KEY=8841">Join</a></div>';
}
add_shortcode( 'action-box', 'action_func' );

function cr_cmb2_fields() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_cr_';

	/**
	 * Initiate the metabox
	 */
	$cmb = new_cmb2_box( array(
		'id'            => 'subhead',
		'title'         => __( 'Subhead', 'largo' ),
		'object_types'  => array( 'cftl-tax-landing', ), // Post type
		'context'       => 'side',
		'priority'      => 'low',
		'show_names'    => false, // Show field names on the left
	) );

	$cmb->add_field( array(
		'name'       => __( 'Subhead', 'largo' ),
		'desc'       => __( '', 'largo' ),
		'id'         => $prefix . 'subhead',
		'type'       => 'text',
		'sanitization_cb' => 'sanitize_text_field', // custom sanitization callback parameter
	) );

}
add_action( 'cmb2_admin_init', 'cr_cmb2_fields' );