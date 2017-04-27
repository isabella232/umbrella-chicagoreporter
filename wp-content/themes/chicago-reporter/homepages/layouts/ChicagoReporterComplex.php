<?php
/**
 * The homepage layout for The Chicago Reporter
 *
 * @since April 2017
 */
include_once get_template_directory() . '/homepages/homepage-class.php';

/**
 * This is called the "Complex" layout as opposed to the other layout, which is simple
 *
 * @since Largo 0.5.5.3
 */
class ChicagoReporterComplex extends Homepage {
	function __construct( $options = array() ) {
		// for css minification purposes
		$suffix = (LARGO_DEBUG)? '' : '.min';

		// this is the configuration for this homepage
		$defaults = array(
			'name' => __( 'Chicago Reporter, Complex', 'cr' ),
			'type' => 'chicagoreporter-complex',
			'description' => __( 'A complex multi-zone layout with a top story, two featured stories, and multiple widget areas.', 'cr' ),
			'template' => get_stylesheet_directory() . '/homepages/templates/chicagoreporter-complex.php',
			'assets' => array(
				array(
					'cr-complex-homepage',
					get_stylesheet_directory_uri() . '/homepages/assets/css/cr-complex-homepage' . $suffix . '.css',
					array()
				),
			),
			'prominenceTerms' => array(
				array(
					'name' => __( 'Homepage Top Story', 'largo' ),
					'description' => __( 'If you are using a "Big story" homepage layout, add this label to a post to make it the top story on the homepage', 'largo' ),
					'slug' => 'top-story'
				),
				array(
					'name' 			=> __( 'Homepage Featured', 'largo' ),
					'description' 	=> __( 'If you are using the Newspaper or Carousel optional homepage layout, add this label to posts to display them in the featured area on the homepage.', 'largo' ),
					'slug' 			=> 'homepage-featured'
				),
			),
		);
		$options = array_merge( $options, $defaults );
		$this->init( $options );
		$this->load( $options );
	}

	/**
	 * This gets called by the HomepageLayoutFactory class
	 * That's why you don't see it getting called here.
	 *
	 * @uses ChicagoReporterComplex::registerSidebars
	 * @uses ChicagoReporterComplex::register_menu
	 * @uses ChicagoReporterComplex::setRightRail
	 * @see ChicagoReporterComplex::enqueueAssets
	 */
	public function register() {
		$this->registerSidebars();
		$this->register_menu();
		$this->setRightRail();
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueueAssets' ), 100 );
	}

	/**
	 * Register the menu used for the Beats output
	 */
	public function register_menu() {
		register_nav_menu(
			'beats_menu',
			__( 'Homepage Beats Menu', 'cr' )
		);
	}

	/**
	 * register our sidebars, with some homepage-specific before_title markup
	 */
	public function registerSidebars() {
		$sidebars = array(
			array(
				'name' => 'Homepage Top Sidebar',
				'id' => 'homepage-top-sidebar',
				'description' => __('You should put one Recent Posts widget here.', 'rns'),
				'before_widget' => '<aside id="%1$s" class="%2$s clearfix">',
				'after_widget' => '</aside>',
				'before_title' => '<h3 class="bar-above">',
				'after_title' => '</h3>',
			),
			array(
				'name' => 'Homepage Middle Image',
				'id' => 'homepage-middle-image',
				'description' => __('You should put one Image widget here.', 'rns'),
				'before_widget' => '<aside id="%1$s" class="%2$s clearfix">',
				'after_widget' => '</aside>',
				'before_title' => '<h3 class="bar-above">',
				'after_title' => '</h3>',
			)
		);
		foreach ($sidebars as $sidebar) {
			register_sidebar($sidebar);
		}
	}

	/**
	 * Display the Beats menu
	 *
	 * This is the row of (hopefully) four items in the middle of the homepage
	 */
	public function beatsMenu() {
		return wp_nav_menu( array(
			'menu' => 'meats_menu',
			'menu_id' => 'beats_menu',
			'fallback_cb' => false,
			'echo' => false,
			'depth' => 1,
			'theme_location' => 'beats_menu',
			'items_wrap' => '%3$s',
			'walker' => new Beats_Menu_Walker,
			'link_before' => '<span>',
			'link_after' => '</span>',
		) );
	}

	/**
	 * This zone outputs the top story on the homepage
	 *
	 * @return String HTML content
	 */
	function topStory() {
		$bigStoryPost = largo_home_single_top();
		global $shown_ids;
		$shown_ids[] = $bigStoryPost->ID;

		ob_start();
		?>
			<article class="top-story">
				<div class="is-image">
					<a href="<?php echo get_permalink($bigStoryPost->ID); ?>"><?php echo get_the_post_thumbnail( $bigStoryPost->ID, 'large' ); ?></a>
				</div>
				<div class="text">
					<h2><a href="<?php echo get_permalink($bigStoryPost->ID); ?>"><?php echo $bigStoryPost->post_title; ?></a></h2>
						<!-- the byline class here isn't showing the byline? -->
					<h5 class="byline"><?php largo_byline(true, false, $bigStoryPost); ?></h5>
				</div>
			</article>
		<?php
		wp_reset_postdata();
		$ret = ob_get_contents();
		ob_end_clean();
		return $ret;
	}

	/**
	 * This needs to output two div.span4s
	 *
	 * @return String HTML content
	 */
	function featStories() {
		$featured_stories = largo_home_featured_stories( 2 );
		global $shown_ids;

		ob_start();
		foreach ( $featured_stories as $featured ) {
			$shown_ids[] = $featured->ID;

		?>
			<div class="span4 sub-stories">
				<article <?php post_class( $featured->ID ); ?> ?>
					<a href="<?php echo get_permalink( $featured->ID ); ?>"><?php echo get_the_post_thumbnail( $featured->ID, 'large' ); ?></a>
					<?php largo_maybe_top_term( array( 'post'=> $featured->ID ) ); ?>
					<h3><a href="<?php echo get_permalink( $featured->ID ); ?>"><?php echo $featured->post_title; ?></a></h3>
					<h5 class="byline"><?php largo_byline( true, true, $featured ); ?></h5>
					<?php
						largo_excerpt( $featured, 2, null, null, true, false );
					?>
				</article>
			</div>
		<?php
		}
		wp_reset_postdata();
		$ret = ob_get_contents();
		ob_end_clean();
		return $ret;
	}
}

/**
 * Register this layout
 * @since Largo 0.5.5.3
 */
function cr_complex_homepage_layout() {
	register_homepage_layout( 'ChicagoReporterComplex' );
}
add_action( 'init', 'cr_complex_homepage_layout' );

/**
 * The Largo function that's supposed to do this in the homepage class doesn't quite do it, for some reason
 *
 * @since Largo 0.5.5.3
 */
function cr_complex_homepage_terms() {
	$terms = array(
		array(
			'name' 			=> __( 'Homepage Bottom', 'largo' ),
			'description' 	=> __( 'Posts with this term can appear in the bottom of the homepage.', 'largo' ),
			'slug' 			=> 'homepage-bottom'
		)
	);
	foreach ( $terms as $term ) {
		if ( ! term_exists( $term['slug'], 'prominence' ) ) {
			wp_insert_term(
				$term['name'],
				'prominence',
				$term
			);
		}
	}
}
add_action( 'init', 'cr_complex_homepage_terms', 100);


/**
 * Custom nav walker class so we can put term featured media on the links
 *
 * @link https://developer.wordpress.org/reference/functions/wp_nav_menu/#comment-207
 * @since WordPress 4.7.3
 */
class Beats_Menu_Walker extends Walker_Nav_Menu {
	/**
	 * Start the element output.
	 *
	 * Adds main/sub-classes to the list items and links.
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Menu item data object.
	 * @param int	$depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 * @param int	$id	 Current item ID.
	 */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		global $wp_query;
		$indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

		// Depth-dependent classes.
		$depth_classes = array(
			( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
			( $depth >=2 ? 'sub-sub-menu-item' : '' ),
			( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
			'menu-item-depth-' . $depth
		);
		$depth_class_names = esc_attr( implode( ' ', $depth_classes ) );

		// Passed classes.
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		// get the featured media image for the category
		if ( isset ( $item->object ) && $item->object === 'category' ) {
			$post_id = largo_get_term_meta_post( $item->object, $item->object_id );
			$image = get_the_post_thumbnail( $post_id, 'large' );

			if ( ! empty( $image ) ) {
				$classes[] = 'has-image';
			}
		}

		$class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

		// Build HTML.
		$output .= $indent . '<div id="nav-menu-item-'. $item->ID . '" class="span3 ' . $depth_class_names . ' ' . $class_names . '">';

		// Link attributes.
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )	 ? ' target="' . esc_attr( $item->target	 ) .'"' : '';
		$attributes .= ! empty( $item->xfn )		? ' rel="'	. esc_attr( $item->xfn		) .'"' : '';
		$attributes .= ! empty( $item->url )		? ' href="'   . esc_attr( $item->url		) .'"' : '';
		$attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';

		// Build HTML output and pass through the proper filter.
		$item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
			$args->before,
			$attributes,
			// the image comes before link_before, so here we alter the effective link_before parameter
			$image . $args->link_before,
			apply_filters( 'the_title', $item->title, $item->ID ),
			$args->link_after,
			$args->after
		);
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		$output .= '</div>';
	}
}
