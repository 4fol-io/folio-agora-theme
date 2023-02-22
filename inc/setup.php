<?php
/**
 * Agora Folio theme initialization setup
 *
 * @package AgoraFolio
 */
namespace AgoraFolio\Setup;

use AgoraFolio\Assets\AssetResolver;

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 */
	load_theme_textdomain( 'agora-folio', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Body open hook
	add_theme_support( 'body-open' );

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
	//set_post_thumbnail_size( 1180, 9999 );
	/*add_image_size( 'featured-large', 1180, 700, true );
	add_image_size( 'featured-medium', 744 );
	add_image_size( 'featured-small', 468 );*/

	

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary-menu' => esc_html__( 'Primary menu', 'agora-folio' ),
    ) );


	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output validW HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	/*add_theme_support( 'custom-background', apply_filters( 'agora_folio_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );*/

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support( 'custom-logo', array(
		'height'      => 188,
		'width'       => 188,
		//'flex-width'  => true,
		//'flex-height' => true,
		'header-text' => array( 'site-title', 'site-description' ),
	) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Add support for full and wide align images.
	add_theme_support( 'align-wide' );

	// Add support for editor styles.
	add_theme_support( 'editor-styles' );

	// Custom stylesheet for visual editor
	add_editor_style( AssetResolver::resolve( 'css/editor-styles.css' ) );

	// Add support for responsive embedded content.
	add_theme_support( 'responsive-embeds' );

	// Disable custom font sizes
	//add_theme_support( 'disable-custom-font-sizes' );


}

add_action( 'after_setup_theme', __NAMESPACE__ . '\\setup' );


/**
 * Set default widgets on theme activation
 */
/*function theme_activation ($old_theme, $WP_theme = null) {
  $widgets = array (
    'sidebar-primary' => array (
      'search-1',
      'categories-1',
      'tag_cloud-1'
    )
  );
  update_option('widget_search', array( 1 => array('title' => '') ));
  update_option('widget_categories', array( 1 => array('title' => '') ));
  update_option('widget_tag_cloud', array( 1 => array('title' => '') ));
  update_option('sidebars_widgets', $widgets);
}

add_action('after_switch_theme', __NAMESPACE__ . '\\theme_activation', 10, 2);*/


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( __NAMESPACE__ . '\\content_width', 1200 );
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\\content_width', 0 );


/**
 * Sets up theme custom colors support
 *
 * Note this function is hooked into init hook
 * to access cpt taxonomies
 */
function init() {

	// Disable Custom Colors
	//add_theme_support( 'disable-custom-colors' );
	
	// Editor Color Palette

	$primary = '#000078';
	$secondary = '#73EDFF';

	add_theme_support( 'editor-color-palette', array(
		array(
			'name'  => __( 'Primary', 'agora-folio' ),
			'slug'  => 'primary',
			'color'	=> $primary,
		),
		array(
			'name'  => __( 'Secondary', 'agora-folio' ),
			'slug'  => 'secondary',
			'color' => $secondary,
		),
		array(
			'name'  => __( 'Gray', 'agora-folio' ),
			'slug'  => 'gray',
			'color' => '#A0A0A0',
		),
		array(
			'name'  => __( 'White', 'agora-folio' ),
			'slug'  => 'white',
			'color' => '#FFFFFF',
		),
	) );

}

add_action( 'init', __NAMESPACE__ . '\\init' );


/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function widgets_init() {

	register_sidebar([
		'id'            => 'footer',
		'name'          => 	__('Footer', 'agora-folio'),
		'description'   =>  __( 'Add widgets here to appear in your footer site.', 'agora-folio' ),
		'before_widget' => '<section class="widget %1$s %2$s col-md-6 col-xl-4">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title ruler ruler--primary">',
		'after_title'   => '</h2>'
	]);

}
add_action( 'widgets_init', __NAMESPACE__ . '\\widgets_init' );


/**
 * Enqueue scripts and styles.
 */
function assets() {

	// Dequeue portafolis-uoc-access & portafolis-uoc-rac plugins stylesheets
	wp_dequeue_style( 'portafolis-uoc-access-css-front' );
	//wp_dequeue_style( 'portafolis-uoc-rac-front-css' );
	

	// Register jQuery in footer
	if( ! is_admin() && ! is_customize_preview() ) {
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', includes_url( '/js/jquery/jquery.js' ), false, NULL, true );
	}

	$dependencies = ['jquery'];
	$megamenu = 0;
	if ( function_exists('max_mega_menu_is_enabled') && max_mega_menu_is_enabled('primary-menu') ) {
		$dependencies[] = 'megamenu';
		$megamenu = 1;
	}

	// registers scripts and stylesheets
	wp_register_style  ( 'agora-folio-style', AssetResolver::resolve( 'css/style.css' ), [], NULL );
	wp_register_script ( 'agora-folio-manifest', AssetResolver::resolve( 'js/manifest.js' ), [], NULL, true );
	wp_register_script ( 'agora-folio-vendor', AssetResolver::resolve( 'js/vendor.js' ), [], NULL, true );
	wp_register_script ( 'agora-folio-app', AssetResolver::resolve( 'js/app.js' ), $dependencies, NULL, true );

	// enqueue global assets
	wp_enqueue_style  ( 'agora-folio-style' );
	wp_enqueue_script ( 'jquery' );
	wp_enqueue_script ( 'agora-folio-manifest' );
	wp_enqueue_script ( 'agora-folio-vendor' );
	wp_enqueue_script ( 'agora-folio-app' );

	if ( AGORA_FOLIO_DEMO_MODE ) {
		wp_enqueue_style  ( 'agora-folio-adminbar-style', AssetResolver::resolve( 'css/adminbar.css' ), [], NULL); // adminbar styles
		//pdfembPDFEmbedderMobile()->insert_scripts();
	}

	// localization data
	wp_localize_script( 'agora-folio-app', 'agoraFolioData', array (
		'ajaxurl' => admin_url( 'admin-ajax.php' ),			// ajax url
		'nonce' => wp_create_nonce( 'agora_folio_theme' ),	// ajax nonce
		'megamenu' => $megamenu,							// megamenu (true: enabled | false: disabled)
		'cookies' => true, 									// cookies (true: expire time | false: session)
		'setGradeAction' => AGORA_FOLIO_DEMO_MODE ? 'portfolio_uoc_rac_set_grade_demo' : 'portfolio_uoc_rac_set_grade',
		'getFeedbackGradeAction' => AGORA_FOLIO_DEMO_MODE ? 'portfolio_uoc_rac_get_feedbacks_and_grade_demo' : 'portfolio_uoc_rac_get_feedbacks_and_grade',
		'listAjax' => AGORA_FOLIO_LIST_AJAX, 				// Enabled lists ajax content ?
		'listComments' => AGORA_FOLIO_LIST_COMMENTS,		// Enabled comments in lists ?
 		't' => array(										// translations array
			'externalLink'			 => __( '(opens in new window)', 'agora-folio' ),
			'closeMenu'				 => __( 'Close menu', 'agora-folio' ),
			'leaveReply'			 => __( 'Leave a comment', 'agora-folio' ),
			'loading'                => __( 'Loading', 'agora-folio' ),
			'saving'                 => __( 'Saving', 'agora-folio' ),
			'sent'					 => __( 'Sent', 'agora-folio' ),
			'evaluated'				 => __( 'Evaluated', 'agora-folio' ),
			'success'                => __( 'Success stored grade and feedback', 'agora-folio' ),
			'error_saving_grade'     => __( 'Error saving grade', 'agora-folio' ),
			'error_loading_feedback' => __( 'Error loading feedback', 'agora-folio' ),
			'error_loading_grade'    => __( 'Error loading grade', 'agora-folio' ),
			'expandCollapse'		 => __( "expand / collapse", "agora-folio" ),
			'loadMore'                => __( 'Load more', 'agora-folio' )
		)
	) );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ||
		AGORA_FOLIO_LIST_COMMENTS && (is_home() || is_category() || is_archive()) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\assets' );


/**
 * Enqueue editor blocks styles and scripts
 */
function block_editor_assets() {

	// registers stylesheet
	wp_register_style( 'agora-folio-editor-blocks-styles', AssetResolver::resolve( 'css/editor-blocks.css' ), [], NULL );

	// enqueue
	wp_enqueue_style( 'agora-folio-editor-blocks-styles' );

}
add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\\block_editor_assets' );


/*
 *  Admin styles
 */
function admin_styles() {

	if ( is_admin() ) {
		wp_enqueue_style("agora-folio-admin-styles", AssetResolver::resolve( 'css/admin.css' ), [], NULL);
		
		if ( AGORA_FOLIO_DEMO_MODE ) {
			wp_enqueue_style ( 'agora-folio-adminbar-style', AssetResolver::resolve( 'css/adminbar.css' ), [], NULL); // adminbar styles
		}	
	}
}
add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\\admin_styles' );
  


function filter_login_head() {
	$image = AssetResolver::resolve( 'images/logo-uoc-default.png' );
	$width = 122;
	$height = 91;
    if ( has_custom_logo() ) {
		$custom = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' );
		$image = $custom[0];
		$width = $custom[1];
		$height = $custom[2];
	}
    ?>
    <style type="text/css">
        .login h1 a {
            background-image: url(<?php echo esc_url( $image ); ?>);
			background-size: contain;
			background-position: center;
			width: <?php echo absint( $width ) ?>px;
			height: <?php echo absint( $height ) ?>px;
			max-width: 100%;
        }
    </style>
	<?php
}
add_action( 'login_head', __NAMESPACE__ . '\\filter_login_head', 100 );


/**
 * Changing the logo link from wordpress.org to your site
 */
function login_url() {  return home_url('/'); }
add_filter('login_headerurl', __NAMESPACE__ . '\\login_url');


/**
 * Changing the alt text on the logo to show your site name
 */
function login_title() { return get_option('blogname'); }
add_filter('login_headertext', __NAMESPACE__ . '\\login_title');


/**
 * Adds custom classes to the array of body classes.
 * Adds a class of hfeed to non-singular pages.
 * 
 * @param array $classes Classes for the body element.
 * @return array
 */
function body_classes( $classes ) {
	if (is_single() || is_page() && !is_front_page()) {
		if (!in_array('page-' . basename(get_permalink()), $classes)) {
		$classes[] = 'page-' . basename(get_permalink());
		}
	}

	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class',  __NAMESPACE__ . '\\body_classes' );


/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
// add_action( 'wp_head',  __NAMESPACE__ . '\\pingback_header' );


/**
 * Admin notices
 */
/*
function show_admin_notices() {
	$plugin_messages = array();

	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

  	// Required BLOGA Plugin
	if(!is_plugin_active( 'agora-folio-plugin/agora-folio.php' )){
		$plugin_messages[] = __('This theme requires you to install the AGORA FOLIO UOC Companion Plugin.', 'agora-folio');
  	}

	if(count($plugin_messages) > 0){
		echo '<div id="message" class="error">';
		foreach($plugin_messages as $message){
			echo '<p><strong>'.$message.'</strong></p>';
		}
		echo '</div>';
	}

}
add_action('admin_notices',  __NAMESPACE__ . '\\show_admin_notices');
*/