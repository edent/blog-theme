<?php
/**
 * edent_simple functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package edent_simple
 */

if ( ! function_exists( 'edent_simple_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function edent_simple_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on edent_simple, use a find and replace
	 * to change 'edent_simple' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'edent_simple', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'edent_simple' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'edent_simple_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'edent_simple_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function edent_simple_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'edent_simple_content_width', 640 );
}
add_action( 'after_setup_theme', 'edent_simple_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function edent_simple_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'edent_simple' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'edent_simple' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'edent_simple_widgets_init' );

/**
 * Filter the "read more" excerpt string link to the post.
 *
 * @param string $more "Read more" excerpt string.
 * @return string (Maybe) modified "read more" excerpt string.
 */
function wpdocs_excerpt_more( $more ) {
    return sprintf( '&nbsp;[…] <a class="read-more" href="%1$s">%2$s</a>',
        get_permalink( get_the_ID() ),
        __( 'Read More', 'textdomain' )
    );
}
add_filter( 'excerpt_more', 'wpdocs_excerpt_more' );

/**
 * Enqueue scripts and styles.
 */
function edent_simple_scripts() {
	wp_enqueue_style( 'edent_simple-style', get_stylesheet_uri() );

	// wp_enqueue_script( 'edent_simple-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	// wp_enqueue_script( 'edent_simple-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	// if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
	// 	wp_enqueue_script( 'comment-reply' );
	// }

	// REMOVE WP EMOJI
	//	http://www.denisbouquet.com/remove-wordpress-emoji-code/
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('wp_print_styles', 'print_emoji_styles');

	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );

	// https://wordpress.org/support/topic/remove-the-new-dns-prefetch-code/
	add_filter( 'emoji_svg_url', '__return_false' );
}
add_action( 'wp_enqueue_scripts', 'edent_simple_scripts' );

function edent_byline() {
	$author = get_the_author();
	$byline =    '<span class="posted-on">'.
                    '<time
                        class="entry-date published updated"
                        datetime="' . get_the_time('Y-m-d') . '" >' .
                        get_the_time(get_option('date_format')) .
                    '</time>'.
                  '</span> by ' .
                  '<span class="vcard author">
							<span class="fn">'. $author .'</span>
						</span>';

	$tags_list = get_the_tag_list( '#', esc_html__( ' #', 'edent_simple' ) );

	if ( $tags_list ) {
		$byline .= sprintf( '<span class="sep"> | </span>
		                     <span class="tags-links">' .
		                        esc_html__( '%1$s', 'edent_simple' ) .
		                     '</span>', $tags_list ); // WPCS: XSS OK.
	}

	$num_comments = get_comments_number(); // get_comments_number returns only a numeric value

	if ( comments_open() ) {
		if ( $num_comments == 0 ) {
			// $comments = 'No Comments';
		} elseif ( $num_comments > 1 ) {
			$comments = $num_comments . ' comments';
		} else {
			$comments = '1 comment';
		}

		if ($num_comments >= 1) {
			$byline .= '<span class="sep"> | </span><a href="' . get_comments_link() .'">'. $comments.'</a>';
		}
	}

	if( function_exists( 'stats_get_csv' ) ) {
		$views = get_post_meta( get_the_ID(), 'jetpack-post-views', true );
		$stats_query = "edent_stats_for_" . get_the_ID();
		if ( false === ( $special_query_results = get_transient( $stats_query ) ) ) {
			$stat_options = "post_id=".get_the_ID()."&days=-1";
			$post_stats = stats_get_csv( 'postviews', $stat_options );
			// It wasn't there, so regenerate the data and save the transient
			$special_query_results = $post_stats[0]["views"];
			set_transient( $stats_query, $special_query_results, 6 * HOUR_IN_SECONDS );
		}
		if (($special_query_results != null) && ($special_query_results > 100))
		{
			$byline .= '<span class="sep"> | </span>Read ~' . number_format($special_query_results) . " times.";
		}
	}

	echo $byline;
}

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
