<?php
/**
 * Twenty Twelve functions and definitions
 *
 * Sets up the theme and provides some helper functions, which are used
 * in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * When using a child theme (see https://codex.wordpress.org/Theme_Development and
 * https://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook.
 *
 * For more information on hooks, actions, and filters, @link https://codex.wordpress.org/Plugin_API
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
include_once 'inc/shortcodes.php';
include_once('inc/custom-widget/happydiary-baidocnhieunhat-widget.php'); 
register_nav_menus( array('user_menu'=>'User menu' )); 
// Set up the content width value based on the theme's design and stylesheet.
if ( ! isset( $content_width ) )
	$content_width = 625;

/**
 * Twenty Twelve setup.
 *
 * Sets up theme defaults and registers the various WordPress features that
 * Twenty Twelve supports.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To add a Visual Editor stylesheet.
 * @uses add_theme_support() To add support for post thumbnails, automatic feed links,
 * 	custom background, and post formats.
 * @uses register_nav_menu() To add support for navigation menus.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Twenty Twelve 1.0
 */
function lottehappytour_setup() {
	/*
	 * Makes Twenty Twelve available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Twenty Twelve, use a find and replace
	 * to change 'lottehappytour' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'lottehappytour', get_template_directory() . '/languages' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// This theme supports a variety of post formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'link', 'quote', 'status' ) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Primary Menu', 'lottehappytour' ) );

	/*
	 * This theme supports custom background color and image,
	 * and here we also set up the default background color.
	 */
	add_theme_support( 'custom-background', array(
		'default-color' => 'e6e6e6',
	) );

	// This theme uses a custom image size for featured images, displayed on "standard" posts.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 624, 9999 ); // Unlimited height, soft crop
}
add_action( 'after_setup_theme', 'lottehappytour_setup' );

/**
 * Add support for a custom header image.
 */
require( get_template_directory() . '/inc/custom-header.php' );

/**
 * Return the Google font stylesheet URL if available.
 *
 * The use of Open Sans by default is localized. For languages that use
 * characters not supported by the font, the font can be disabled.
 *
 * @since Twenty Twelve 1.2
 *
 * @return string Font stylesheet or empty string if disabled.
 */
function lottehappytour_get_font_url() {
	$font_url = '';

	/* translators: If there are characters in your language that are not supported
	 * by Open Sans, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'lottehappytour' ) ) {
		$subsets = 'latin,latin-ext';

		/* translators: To add an additional Open Sans character subset specific to your language,
		 * translate this to 'greek', 'cyrillic' or 'vietnamese'. Do not translate into your own language.
		 */
		$subset = _x( 'no-subset', 'Open Sans font: add new subset (greek, cyrillic, vietnamese)', 'lottehappytour' );

		if ( 'cyrillic' == $subset )
			$subsets .= ',cyrillic,cyrillic-ext';
		elseif ( 'greek' == $subset )
			$subsets .= ',greek,greek-ext';
		elseif ( 'vietnamese' == $subset )
			$subsets .= ',vietnamese';

		$protocol = is_ssl() ? 'https' : 'http';
		$query_args = array(
			'family' => 'Open+Sans:400italic,700italic,400,700',
			'subset' => $subsets,
		);
		$font_url = add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" );
	}

	return $font_url;
}

/**
 * Enqueue scripts and styles for front-end.
 *
 * @since Twenty Twelve 1.0
 */
function lottehappytour_scripts_styles() {
	global $wp_styles;

	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
//	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
//		wp_enqueue_script( 'comment-reply' );

	// Adds JavaScript for handling the navigation menu hide-and-show behavior.
//	wp_enqueue_script( 'lottehappytour-navigation', get_template_directory_uri() . '/js/navigation.js', array( 'jquery' ), '20140711', true );
	wp_enqueue_script( 'lottehappytour-jcarousel-min', get_template_directory_uri() . '/libs/jcarousel/jquery.jcarousel.min.js', array( 'jquery' ), '20152807', false );
	wp_enqueue_script( 'lottehappytour-jcarousel-responsive', get_template_directory_uri() . '/libs/jcarousel/responsive/jcarousel.responsive.js', array( 'jquery' ), '20152807', false );
	wp_enqueue_script( 'lottehappytour-jcarousel-basic', get_template_directory_uri() . '/libs/jcarousel/base/jcarousel.basic.js', array( 'jquery' ), '20152807', false );
	wp_enqueue_script( 'lottehappytour-js-custom', get_template_directory_uri() . '/js/js.js', array( 'jquery' ), '20152807', false );

	$font_url = lottehappytour_get_font_url();
	if ( ! empty( $font_url ) )
		wp_enqueue_style( 'lottehappytour-fonts', esc_url_raw( $font_url ), array(), null );

	// Loads our main stylesheet.
	wp_enqueue_style( 'lottehappytour-style-tupo', get_template_directory_uri().'/css/typo.css' );
	wp_enqueue_style( 'jcarousel-responsive-style', get_template_directory_uri().'/libs/jcarousel/responsive/jcarousel.responsive.css' );
	wp_enqueue_style( 'jcarousel-basic-style', get_template_directory_uri().'/libs/jcarousel/base/jcarousel.basic.css' );
	wp_enqueue_style( 'lottehappytour-style', get_template_directory_uri().'/css/style.css' );

	// Loads the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'lottehappytour-ie', get_template_directory_uri() . '/css/ie.css', array( 'lottehappytour-style' ), '20121010' );
	$wp_styles->add_data( 'lottehappytour-ie', 'conditional', 'lt IE 9' );
	
	wp_enqueue_style( 'lottehappytour-reponsive', get_template_directory_uri().'/css/reponsive.css' );
}
add_action( 'wp_enqueue_scripts', 'lottehappytour_scripts_styles' );

/**
 * Filter TinyMCE CSS path to include Google Fonts.
 *
 * Adds additional stylesheets to the TinyMCE editor if needed.
 *
 * @uses lottehappytour_get_font_url() To get the Google Font stylesheet URL.
 *
 * @since Twenty Twelve 1.2
 *
 * @param string $mce_css CSS path to load in TinyMCE.
 * @return string Filtered CSS path.
 */
function lottehappytour_mce_css( $mce_css ) {
	$font_url = lottehappytour_get_font_url();

	if ( empty( $font_url ) )
		return $mce_css;

	if ( ! empty( $mce_css ) )
		$mce_css .= ',';

	$mce_css .= esc_url_raw( str_replace( ',', '%2C', $font_url ) );

	return $mce_css;
}
add_filter( 'mce_css', 'lottehappytour_mce_css' );

/**
 * Filter the page title.
 *
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 *
 * @since Twenty Twelve 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string Filtered title.
 */
function lottehappytour_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name', 'display' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'lottehappytour' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'lottehappytour_wp_title', 10, 2 );

/**
 * Filter the page menu arguments.
 *
 * Makes our wp_nav_menu() fallback -- wp_page_menu() -- show a home link.
 *
 * @since Twenty Twelve 1.0
 */
function lottehappytour_page_menu_args( $args ) {
	if ( ! isset( $args['show_home'] ) )
		$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'lottehappytour_page_menu_args' );

/**
 * Register sidebars.
 *
 * Registers our main widget area and the front page widget areas.
 *
 * @since Twenty Twelve 1.0
 */
function lottehappytour_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Main Sidebar', 'lottehappytour' ),
		'id' => 'sidebar-1',
		'description' => __( 'Appears on posts and pages except the optional Front Page template, which has its own widgets', 'lottehappytour' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'First Front Page Widget Area', 'lottehappytour' ),
		'id' => 'sidebar-2',
		'description' => __( 'Appears when using the optional Front Page template with a page set as Static Front Page', 'lottehappytour' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Second Front Page Widget Area', 'lottehappytour' ),
		'id' => 'sidebar-3',
		'description' => __( 'Appears when using the optional Front Page template with a page set as Static Front Page', 'lottehappytour' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Happy Diary Facebook Comment', 'lottehappytour' ),
		'id' => 'sidebar-4',
		'description' => __( 'Appears when using the optional Happy Diary Single template', 'lottehappytour' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'lottehappytour_widgets_init' );

if ( ! function_exists( 'lottehappytour_content_nav' ) ) :
/**
 * Displays navigation to next/previous pages when applicable.
 *
 * @since Twenty Twelve 1.0
 */
function lottehappytour_content_nav( $html_id ) {
	global $wp_query;

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo esc_attr( $html_id ); ?>" class="navigation" role="navigation">
			<h3 class="assistive-text"><?php _e( 'Post navigation', 'lottehappytour' ); ?></h3>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'lottehappytour' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'lottehappytour' ) ); ?></div>
		</nav><!-- .navigation -->
	<?php endif;
}
endif;

if ( ! function_exists( 'lottehappytour_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own lottehappytour_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Twenty Twelve 1.0
 */
function lottehappytour_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'lottehappytour' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'lottehappytour' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<header class="comment-meta comment-author vcard">
				<?php
					echo get_avatar( $comment, 44 );
					printf( '<cite><b class="fn">%1$s</b> %2$s</cite>',
						get_comment_author_link(),
						// If current post author is also comment author, make it known visually.
						( $comment->user_id === $post->post_author ) ? '<span>' . __( 'Post author', 'lottehappytour' ) . '</span>' : ''
					);
					printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						/* translators: 1: date, 2: time */
						sprintf( __( '%1$s at %2$s', 'lottehappytour' ), get_comment_date(), get_comment_time() )
					);
				?>
			</header><!-- .comment-meta -->

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'lottehappytour' ); ?></p>
			<?php endif; ?>

			<section class="comment-content comment">
				<?php comment_text(); ?>
				<?php edit_comment_link( __( 'Edit', 'lottehappytour' ), '<p class="edit-link">', '</p>' ); ?>
			</section><!-- .comment-content -->

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'lottehappytour' ), 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
endif;

if ( ! function_exists( 'lottehappytour_entry_meta' ) ) :
/**
 * Set up post entry meta.
 *
 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
 *
 * Create your own lottehappytour_entry_meta() to override in a child theme.
 *
 * @since Twenty Twelve 1.0
 */
function lottehappytour_entry_meta() {
	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( __( ', ', 'lottehappytour' ) );

	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', __( ', ', 'lottehappytour' ) );

	$date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	$author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'lottehappytour' ), get_the_author() ) ),
		get_the_author()
	);

	// Translators: 1 is category, 2 is tag, 3 is the date and 4 is the author's name.
	if ( $tag_list ) {
		$utility_text = __( 'This entry was posted in %1$s and tagged %2$s on %3$s<span class="by-author"> by %4$s</span>.', 'lottehappytour' );
	} elseif ( $categories_list ) {
		$utility_text = __( 'This entry was posted in %1$s on %3$s<span class="by-author"> by %4$s</span>.', 'lottehappytour' );
	} else {
		$utility_text = __( 'This entry was posted on %3$s<span class="by-author"> by %4$s</span>.', 'lottehappytour' );
	}

	printf(
		$utility_text,
		$categories_list,
		$tag_list,
		$date,
		$author
	);
}
endif;

/**
 * Extend the default WordPress body classes.
 *
 * Extends the default WordPress body class to denote:
 * 1. Using a full-width layout, when no active widgets in the sidebar
 *    or full-width template.
 * 2. Front Page template: thumbnail in use and number of sidebars for
 *    widget areas.
 * 3. White or empty background color to change the layout and spacing.
 * 4. Custom fonts enabled.
 * 5. Single or multiple authors.
 *
 * @since Twenty Twelve 1.0
 *
 * @param array $classes Existing class values.
 * @return array Filtered class values.
 */
function lottehappytour_body_class( $classes ) {
	$background_color = get_background_color();
	$background_image = get_background_image();

	if ( ! is_active_sidebar( 'sidebar-1' ) || is_page_template( 'page-templates/full-width.php' ) )
		$classes[] = 'full-width';

	if ( is_page_template( 'page-templates/front-page.php' ) ) {
		$classes[] = 'template-front-page';
		if ( has_post_thumbnail() )
			$classes[] = 'has-post-thumbnail';
		if ( is_active_sidebar( 'sidebar-2' ) && is_active_sidebar( 'sidebar-3' ) )
			$classes[] = 'two-sidebars';
	}

	if ( empty( $background_image ) ) {
		if ( empty( $background_color ) )
			$classes[] = 'custom-background-empty';
		elseif ( in_array( $background_color, array( 'fff', 'ffffff' ) ) )
			$classes[] = 'custom-background-white';
	}

	// Enable custom font class only if the font CSS is queued to load.
	if ( wp_style_is( 'lottehappytour-fonts', 'queue' ) )
		$classes[] = 'custom-font-enabled';

	if ( ! is_multi_author() )
		$classes[] = 'single-author';

	return $classes;
}
add_filter( 'body_class', 'lottehappytour_body_class' );

/**
 * Adjust content width in certain contexts.
 *
 * Adjusts content_width value for full-width and single image attachment
 * templates, and when there are no active widgets in the sidebar.
 *
 * @since Twenty Twelve 1.0
 */
function lottehappytour_content_width() {
	if ( is_page_template( 'page-templates/full-width.php' ) || is_attachment() || ! is_active_sidebar( 'sidebar-1' ) ) {
		global $content_width;
		$content_width = 960;
	}
}
add_action( 'template_redirect', 'lottehappytour_content_width' );

/**
 * Register postMessage support.
 *
 * Add postMessage support for site title and description for the Customizer.
 *
 * @since Twenty Twelve 1.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function lottehappytour_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'lottehappytour_customize_register' );

/**
 * Enqueue Javascript postMessage handlers for the Customizer.
 *
 * Binds JS handlers to make the Customizer preview reload changes asynchronously.
 *
 * @since Twenty Twelve 1.0
 */
function lottehappytour_customize_preview_js() {
	wp_enqueue_script( 'lottehappytour-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '20141120', true );
}
add_action( 'customize_preview_init', 'lottehappytour_customize_preview_js' );
function custom_excerpt_length( $length ) {
	return 10;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
function new_excerpt_more( $more ) {
	return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');

add_filter('manage_posts_columns', 'posts_columns', 5);
add_action('manage_posts_custom_column', 'posts_custom_columns', 5, 2);
function posts_columns($defaults){
    $defaults['riv_post_thumbs'] = __('Thumbs');
    return $defaults;
}
function posts_custom_columns($column_name, $id){
        if($column_name === 'riv_post_thumbs'){
        echo the_post_thumbnail( array(60,60) );
    }
}

//META for happy moment
$GLOBALS['video'] = null;
$GLOBALS['videoImage'] = null;
$GLOBALS['photo'] = null;
$GLOBALS['photoImage'] = null;
function getCurentVideo() {
	global $xoouserultra;
	$mainVideo = null;
	if(!empty($GLOBALS['video'])){
		return $GLOBALS['video'];
	}else{
		$listVideos = $xoouserultra->happy_moment_child(null);
		if(isset($_GET['gallery']) && isset($_GET['video'])){			
			foreach ($listVideos['listVideoOfFirst'] as $video) {
				if($_GET['video'] == $video->video_id && !$mainVideo){
					$mainVideo = $video;
					break;
				}
			}
			if($mainVideo){
				$GLOBALS['video'] = $mainVideo;			
			}
		}
	}
	return $mainVideo;
}

function getCurentPhoto() {
	global $xoouserultra;
	$mainPhoto = null;
	if(!empty($GLOBALS['photo'])){
		return $GLOBALS['photo'];
	}else{
		$listPhotos = $xoouserultra->happy_spirit(null);
		if(isset($_GET['gallery']) && isset($_GET['photo'])){			
			foreach ($listPhotos['listPhotoOfFirst'] as $photo) {
				if($_GET['photo'] == $photo->photo_id && !$mainPhoto){
					$mainPhoto = $photo;
					break;
				}
			}
			if($mainPhoto){
				$GLOBALS['photo'] = $mainPhoto;			
			}
		}
	}
	return $mainPhoto;
}

function happy_des($str){
	global $post;
	
	if(is_page()){
		if($post->ID == 53){
			$mainVideo = getCurentVideo();
			if(!empty($mainVideo) && $mainVideo->video_desc){
				return $mainVideo->video_desc;
			}
		}elseif($post->ID == 28){
			$mainPhoto = getCurentPhoto();
			if(!empty($mainPhoto) && $mainPhoto->photo_desc){
				return $mainPhoto->photo_desc;
			}
		}
		
	}
	return $str;
}
add_filter('wpseo_opengraph_desc', 'happy_des');

function happy_title($str){
	global $post;
	if(is_page()){
		if($post->ID == 53){
			$mainVideo = getCurentVideo();
			if(!empty($mainVideo) && $mainVideo->video_name){
				return $mainVideo->video_name.' - '.$str;
			}
		}elseif($post->ID == 28){
			$mainPhoto = getCurentPhoto();
			if(!empty($mainPhoto) && $mainPhoto->photo_name){
				return $mainPhoto->photo_name.' - '.$str;
			}
		}
		
	}
	return $str;
}
add_filter('wpseo_opengraph_title', 'happy_title');

function happy_type($str){
	global $post;
	if(is_page() && $post->ID == 53)
		return 'video';
}
add_filter('wpseo_opengraph_type', 'happy_type');

function happy_url($str){
	global $post,$xoouserultra;
	if(is_page()){		
		if($post->ID == 53){
			$mainVideo = getCurentVideo();
			if(!empty($mainVideo)){
				$url = get_permalink(53);
				$site_url = site_url()."/";	
				$upload_folder =  $xoouserultra->get_option('media_uploading_folder'); 
				$thumb = $site_url.$upload_folder."/".$mainVideo->gallery_user_id."/".$mainVideo->video_image;
				$GLOBALS['videoImage'] = $thumb;
//				$GLOBALS['videoImage'] = $xoouserultra->videogallery->get_video_thumb($mainVideo->gallery_id, $mainVideo->video_id);
				return $url.'?gallery='.$mainVideo->gallery_id.'&video='.$mainVideo->video_id;
			}
		}elseif($post->ID == 28){
			$mainPhoto = getCurentPhoto();
			if(!empty($mainPhoto)){
				$site_url = site_url()."/";	
				$upload_folder =  $xoouserultra->get_option('media_uploading_folder'); 
				$thumb = $site_url.$upload_folder."/".$mainPhoto->gallery_user_id."/".$mainPhoto->photo_large;
				$url = get_permalink(28);
				$GLOBALS['photoImage'] = $thumb;
				return $url.'?gallery='.$mainPhoto->gallery_id.'&photo='.$mainPhoto->photo_id;
			}
		}
	}
	return $str;
}
add_filter('wpseo_opengraph_url', 'happy_url');


function site_opengraph_image_size($val) {
	return 'facebook';
}
add_filter('wpseo_opengraph_image_size', 'site_opengraph_image_size');

function happy_image($image){
	global $post,$xoouserultra;
	if(is_page()){		
		if($post->ID == 53){
			$mainVideo = getCurentVideo();
			if(!empty($mainVideo) && !empty($mainVideo->video_thumb)){
//				$thumb = $xoouserultra->videogallery->get_video_thumb($mainVideo->gallery_id, $mainVideo->video_id);
//				return $thumb;
				$site_url = site_url()."/";	
				$upload_folder =  $xoouserultra->get_option('media_uploading_folder'); 
				$thumb = $site_url.$upload_folder."/".$mainVideo->gallery_user_id."/".$mainVideo->video_image;
				return $thumb;
			}
		}elseif($post->ID == 28){
			$mainPhoto = getCurentPhoto();
			if(!empty($mainPhoto) && !empty($mainPhoto->photo_thumb)){
				$site_url = site_url()."/";	
				$upload_folder =  $xoouserultra->get_option('media_uploading_folder'); 
				$thumb = $site_url.$upload_folder."/".$mainPhoto->gallery_user_id."/".$mainPhoto->photo_large;
				return $thumb;
			}
		}
	}
	return $image;
}
add_filter('wpseo_opengraph_image', 'happy_image');

function happy_canonical($str){
	global $post;
	if(is_page()){		
		if($post->ID == 53){
			$mainVideo = getCurentVideo();
			if(!empty($mainVideo)){
				$url = get_permalink(53);				
				return $url.'?gallery='.$mainVideo->gallery_id.'&video='.$mainVideo->video_id;
			}
		}elseif($post->ID == 28){
			$mainPhoto = getCurentPhoto();
			if(!empty($mainPhoto)){
				$url = get_permalink(28);
				return $url.'?gallery='.$mainPhoto->gallery_id.'&photo='.$mainPhoto->photo_id;
			}
		}
	}
	return $str;
}
add_filter('wpseo_canonical', 'happy_canonical');
