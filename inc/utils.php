<?php
/**
 * Agora Folio utilities
 *
 * @package AgoraFolio
 */

namespace AgoraFolio\Utils;

use AgoraFolio\Assets\AssetResolver;
use AgoraFolio\Data;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Tell WordPress to use searchform.php from the templates/ directory
 */
function get_search_form() {
  $form = '';
  locate_template('/template-parts/searchform.php', true, false);
  return $form;
}
add_filter('get_search_form', __NAMESPACE__ . '\\get_search_form');


/**
 * Filter search to only Posts
 */
function search_filter($query) {
  if ($query->is_search && !is_admin() ) {
    $query->set('post_type',array('post'));
  }
}
// add_filter('pre_get_posts',__NAMESPACE__ . '\\search_filter');


/**
 * Change custom logo default class
 */
function change_logo_class( $html ) {
  //$html = str_replace( 'custom-logo-link', 'navbar-brand', $html );
  $html = str_replace( 'custom-logo', 'img-fluid', $html );
  return $html;
}
// add_filter( 'get_custom_logo', __NAMESPACE__ . '\\change_logo_class' );


/**
 * Add No-JS Class.
 * If we're missing JavaScript support, the HTML element will have a no-js class.
 */
function toggle_js_class() {
	?>
	<script>document.documentElement.className = document.documentElement.className.replace( 'no-js', 'js' );</script>
	<?php
}

add_action( 'wp_head', __NAMESPACE__ . '\\toggle_js_class' );


/**
 * Fix skip link focus in IE11.
 *
 * This does not enqueue the script because it is tiny and because it is only for IE11,
 * thus it does not warrant having an entire dedicated blocking script being loaded.
 *
 * @link https://git.io/vWdr2
 */
function skip_link_focus_fix() {
	// The following is minified via `terser --compress --mangle -- assets/js/skip-link-focus-fix.js`.
	?>
	<script>
	/(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())},!1);
	</script>
	<?php
}
add_action( 'wp_print_footer_scripts', __NAMESPACE__ . '\\skip_link_focus_fix' );


/**
 * Clean up the_excerpt()
 */
function excerpt_more() {
  /*if ( ! is_single() ) {
    return sprintf( '<a class="read-more" href="%1$s">%2$s</a>', get_permalink( get_the_ID() ), '<strong>+</strong>' );
  }*/
  return ' &hellip;';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');


/**
 * Customize excerpt length
 */
function excerpt_length( $length ) {
  return 90;
}
add_filter( 'excerpt_length', __NAMESPACE__ . '\\excerpt_length', 999 );


/**
 * Remove the excerpt shortcodes
 */
function remove_the_excerpt_shortcodes(){
  return strip_shortcodes(get_the_excerpt());
}
add_filter('the_excerpt', __NAMESPACE__ . '\\remove_the_excerpt_shortcodes');


/**
 * Custom excerpt length
 */
function get_excerpt($limit = 70) {
  $excerpt = wp_trim_words(strip_shortcodes(get_the_excerpt()), $limit);
  return apply_filters( 'highlight_excerpt', $excerpt );
}


/**
 * Custom avatar
 */
function gef_gravatar ($avatar_defaults) {
  $avatar = AssetResolver::resolve( 'images/avatar.png' );
  $avatar_defaults[$avatar] = "UOC Folio";
  return $avatar_defaults;
}
add_filter( 'avatar_defaults', __NAMESPACE__ . '\\gef_gravatar' );


/**
 * (depreciated)
 * Enable comments form in lists (agoras view)
 * (not works if latest post in list has comments closed, resolved in lists)
 */
function filter_comments_open( $open, $post_id ){
  if (AGORA_FOLIO_LIST_COMMENTS && (is_home() || is_category() || is_archive()) && !$post_id) {
    return true;
  }
	return $open;
}
//add_filter( 'comments_open', __NAMESPACE__ . '\\filter_comments_open', 10, 2 );

/**
 * Breadcrumbs
 */
function the_breadcrumb() {


    echo '<ol class="breadcrumb">';

    // Folio base url (not home)
    /*if (is_user_logged_in()){
      echo '<li class="breadcrumb-item"><a href="' . Data\get_folio_url() . '"><span class="mr-2 icon icon-svg icon-svg--folio" aria-hidden="true"></span> <strong>'. __( 'My folio', 'agora-folio' ) .'</strong></a></li>';
    }*/

    if (!is_front_page()) {

	      // Start the breadcrumb with a link to your homepage
        //echo '<li class="breadcrumb-item"><a href="' . get_option('home') . '">'. __( 'Home', 'agora-folio' ) .'</a></li>';
        echo '<li class="breadcrumb-item"><a href="' . get_option('home') . '">' . Data\get_semester() . ' - ' . Data\get_classroom() .'</a></li>';

	      // Check if the current page is a category, an archive or a single page. If so show the category or archive name.
        if (is_category() /*|| is_single()*/ ){
          //wp_list_categories('title_li=0');
          $cats = array_reverse(get_the_category());
          foreach($cats as $cat){
            echo '<li class="breadcrumb-item">'. $cat->cat_name . '</li>';
          }
        } elseif (is_archive() /*|| is_single()*/ ){
            if ( is_day() ) {
              printf( __( '<li class="breadcrumb-item">%s</li>', 'agora-folio' ), ucwords( get_the_date( 'j F, Y' ) ) );
            } elseif ( is_month() ) {
              printf( __( '<li class="breadcrumb-item">%s</li>', 'agora-folio' ), ucwords( get_the_date( _x( 'F Y', 'monthly archives date format', 'agora-folio' ) ) ) );
            } elseif ( is_year() ) {
              printf( __( '<li class="breadcrumb-item">%s</li>', 'agora-folio' ), get_the_date( _x( 'Y', 'yearly archives date format', 'agora-folio' ) ) );
            }elseif ( is_author() ) {
              printf( __('<li class="breadcrumb-item">%s</li>', 'agora-folio'), get_the_author() );
            } else {
              printf( __( '<li class="breadcrumb-item">%s</li>', 'agora-folio' ), get_the_archive_title() );
            } 
        } elseif ( is_search() ) {
          printf( __('<li class="breadcrumb-item">Search: %s</li>', 'agora-folio'), '#'.get_search_query() );
        }

	      // If the current page is a single post, show its title with the separator
        if (is_single()) {
          the_title('<li class="breadcrumb-item">', '</li>');
        }

	      // If the current page is a static page, show its title.
        if (is_page()) {
          the_title('<li class="breadcrumb-item">', '</li>');
        }

         

	      // if you have a static page assigned to be you posts list page. It will find the title of the static page and display it. i.e Home >> Blog
        if (is_home()){
            global $post;
            $page_for_posts_id = get_option('page_for_posts');
            if ( $page_for_posts_id ) {
                $post = get_page($page_for_posts_id);
                setup_postdata($post);
                the_title('<li class="breadcrumb-item">', '</li>');
                rewind_posts();
            }
        }

    } else {

      //echo '<li class="breadcrumb-item">'. __( 'Home', 'agora-folio' ) .'</li>';
      echo '<li class="breadcrumb-item">' . Data\get_semester() . ' - ' . Data\get_classroom() .'</li>';

    }

    echo '</ol>';
}

/**
 * Add a title to posts and pages that are missing titles.
 */
function untitled($title) {
		return '' === $title ? esc_html_x( 'Untitled', 'Added to posts and pages that are missing titles', 'agora-folio' ) : $title;
}
add_filter('the_title', __NAMESPACE__ . '\\untitled');


/**
 * Remove view query arg in paginate links
 */
function filter_paginate_links ( $link ) {
  return remove_query_arg( 'view', $link );
}
add_filter( 'paginate_links',  __NAMESPACE__ . '\\filter_paginate_links' );


/**
 * Returns the number of top level comments for a specific post (or the current one if no id is given)
 */
function get_top_level_comments_number( $post_id = 0, $onlyapproved = true ) {
  global $wpdb, $post;
  $post_id = $post_id ? $post_id : $post->ID;
  $sql = "SELECT COUNT(*) FROM $wpdb->comments WHERE comment_parent = 0 AND comment_post_ID = $post_id";
  if( $onlyapproved ) $sql .= " AND comment_approved='1'";
  return (int) $wpdb->get_var( $sql );
}

/**
 * Highligtht coincidences for searched term or tag in archive
 */
function highlight_results($text){
  if( in_the_loop() && !is_admin() ){
    if( is_search() ){
      $sr = get_query_var('s');
      $keys = explode(" ",$sr);
      $keys = array_filter($keys);
      $text = preg_replace('/('.implode('|', $keys) .')/iu', '<mark>\0</mark>', $text);
    }else if(is_tag()){
      $text = preg_replace('/('. single_tag_title('', false) .')/iu', '<mark>\0</mark>', $text);
    }
  }
  return $text;
}
add_filter('the_title', __NAMESPACE__ . '\\highlight_results');
add_filter('the_excerpt', __NAMESPACE__ . '\\highlight_results');
add_filter('highlight_excerpt', __NAMESPACE__ . '\\highlight_results');


/**
 * Remove tag cloud size styles
 */
function remove_tag_cloud_styles($tag_string){
  return preg_replace('/style=("|\')(.*?)("|\')/','',$tag_string);
}
add_filter('wp_generate_tag_cloud',  __NAMESPACE__ . '\\remove_tag_cloud_styles',10,1);


/**
 * Display tag cloud widget as list
 */
function custom_tag_cloud_widget($args) {
  //$args['format'] = 'list';
  $args['largest']  = 2;
  $args['smallest'] = .9;
  $args['unit']     = 'rem';
  return $args;
}
add_filter( 'widget_tag_cloud_args',  __NAMESPACE__ . '\\custom_tag_cloud_widget' );


/**
 * Remove rel nofollow for links in comments
 */
function remove_rel_nofollow_attribute( $comment_text ) {
  $comment_text = str_ireplace(' rel="nofollow"', '', $comment_text );
  return $comment_text;
}
// add_filter( 'comment_text', 'remove_rel_nofollow_attribute' );


/**
 * Remove the comment reply button from it's default location
 */
function remove_comment_reply_link($link) {
  return '';
}
// add_filter('cancel_comment_reply_link',  __NAMESPACE__ . '\\remove_comment_reply_link', 10);


/**
 * Add the comment reply button to the end of the comment form.
 * Remove the remove_comment_reply_link filter first so that it will actually output something.
 */
function after_comment_form($post_id) {
  remove_filter('cancel_comment_reply_link',  __NAMESPACE__ . '\\remove_comment_reply_link', 10);
  cancel_comment_reply_link( __( 'Cancel', 'agora-folio' ) );
}
// add_action('comment_form',  __NAMESPACE__ . '\\after_comment_form', 99);


/**
 * Hide admin bar
 */
function remove_admin_bar(){
  if ( ! is_admin() && ! is_customize_preview() ) {
    show_admin_bar(false);
  }
}
// add_action('after_setup_theme',  __NAMESPACE__ . '\\remove_admin_bar');



/**
 *  Disable Gutenberg Editor
 */ 
// add_filter( 'use_block_editor_for_post', '__return_false' );


/**
 * Localization (from UOC BLOGA Theme)
 */
/*
function localize_theme( $lang ) {
  $current_user = wp_get_current_user();
  if(get_option("GlobaLocale")!=null){
    $lang = get_option("GlobaLocale");
  }else{
    $ulang = get_option("Locale_.".$current_user->user_email);
    if($ulang != null && $ulang != '') $lang = str_replace("-", "_" ,$ulang);
  }
  return $lang;
}
add_filter( 'locale', __NAMESPACE__ . '\\localize_theme' );
*/


/**
 * Aux Method to get WPML current lang
 */
function current_language() {
	if (function_exists('icl_get_languages')) {
	  return ICL_LANGUAGE_CODE;
	}
	return 'CA';
}
  

/**
 * Aux method to get WPML language menu
 */
function language_selector() {
	if (function_exists('icl_get_languages')) {
	  $languages = icl_get_languages('skip_missing=0&orderby=custom');
	  if(!empty($languages)){
      foreach($languages as $l){
        if($l['active']) { echo '<li class="active switch-lang">'; }
        else { echo '<li class="switch-lang">'; }
        echo '<a href="'.$l['url'].'" role="menuitem" class="dropdown-item">';
        echo '<span class="lang-name">'.$l['native_name'].'</span>';
        echo '</a>';
        echo '</li>';
      }
	  }
	}
}


function archive_title ($title) {
  if ( is_year() ) {
    $title = get_the_date( 'Y' );
  } elseif ( is_month() ) {
    $title = ucwords ( get_the_date( 'F Y' ) );
  } elseif ( is_day() ) {
    $title = ucwords ( get_the_date( 'j F, Y' ) );
  } elseif ( is_author() ) {
    $title = get_the_author();
  }
  return $title;
}

add_action('get_the_archive_title',  __NAMESPACE__ . '\\archive_title');


function comment_form_default_fields($fields) {

  //var_dump($fields);

  $commenter     = wp_get_current_commenter();
	$req       = get_option( 'require_name_email' );
	$aria_req  = ( $req ? 'required aria-required="true"' : '' );
	$req_name  = $req ? '<div class="invalid-feedback">' . __( 'Please enter the name', 'agora-folio' ) . '</div>' : '';
	$req_email = $req ? '<div class="invalid-feedback">' . __( 'Please enter a valid email', 'agora-folio' ) . '</div>' : '';

	$fields['author'] = '<div class="form-group comment-form-author">' . 
                      '<label id="lbl-author" for="author" class="visually-hidden">' . __( 'Name', 'agora-folio' ) . '</label> ' .
		                  '<input class="form-item" placeholder="' . __( 'Name' ) . '" id="author" name="author" type="text" value="' . 
                      esc_attr( $commenter['comment_author'] ) . '" ' . $aria_req . ' />' . $req_name . '</div>';
      
	$fields['email']  = '<div class="form-group comment-form-email">' .
                      '<label id="lbl-email" for="email" class="visually-hidden">' . __( 'Your email' ) . '</label> ' .
		                  '<input class="form-item" placeholder="' . __( 'Your email' ) . '"id="email" name="email" type="email" value="' . 
                      esc_attr( $commenter['comment_author_email'] ) . '" ' . $aria_req . ' />' . $req_email . '</div>';

	$fields['url']    = '<div class="form-group comment-form-url">'. 
                      '<label id="lbl-url" for="url" class="visually-hidden">' . __( 'Website' ) . '</label>' .
		                  '<input class="form-item" placeholder="' . __( 'Website' ) . '" id="url" name="url" type="url" value="' . 
                      esc_attr( $commenter['comment_author_url'] ) . '" /></div>';

	if ( has_action( 'set_comment_cookies', 'wp_set_comment_cookies' ) && get_option( 'show_comments_cookies_opt_in' ) ) {
		$consent           = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';
		$fields['cookies'] = '<div class="form-group comment-form-cookies-consent"><div class="form-check">' .
		                     '<label for="wp-comment-cookies-consent">' .
		                     '<input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes" ' . $consent . '  />' .
		                     '<span class="icon icon--checkbox-off icon--small" aria-hidden="true"></span>' .
		                     __( 'Save my name, email, and website in this browser for the next time I comment.' ) . '</label></div></div>';
	}

  // change comment textarea order
  /*$comment_field = $fields['comment'];
  unset( $fields['comment'] );
  $fields['comment'] = $comment_field;*/

  return $fields;

}

add_filter('comment_form_fields',  __NAMESPACE__ . '\\comment_form_default_fields');



/**
 * Aux method to forma date
 */
function format_date($date){
	if($date) return date('d.m.Y', strtotime($date));
	return $date;
}


/**
 * Aux method to format date timestamp
 */
function format_date_timestamp($date){
	if($date) return date('u', strtotime($date));
	return $date;
}


/**
 * Helper function to compare URL against relative URL
 */
function url_compare($url, $rel) {
  $url = trailingslashit($url);
  $rel = trailingslashit($rel);
  return ((strcasecmp($url, $rel) === 0) || root_relative_url($url) == $rel);
}


/**
 * Helper function to test if an array key exists.
 *
 * @param     array     $array The array to test against.
 * @param     array     $keys An array of keys to look for.
 * @return    bool
 */
function array_keys_exists( $array, $keys ) {
  foreach( $keys as $k )
    if ( isset( $array[$k] ) )
      return true;

  return false;
}


/**
 * Pretty Printing
 *
 * @param mixed $obj
 * @param string $label
 * @return null
 */
function pp( $obj, $label = '' ) {
	$data = json_encode( print_r( $obj,true ) );
	?>
	<style type="text/css">
		#agora-folio-logger {
      position: absolute;
      top: 0;
      right: 0;
      bottom:0;
      border-left: 4px solid #bbb;
      padding: 1rem;
      background: white;
      color: #444;
      z-index: 999;
      font-size: 1rem;
      width: 25%;
      height: 100%;
      overflow: scroll;
		}
	</style>
	<script type="text/javascript">
		var doStuff = function(){
			var obj = <?php echo $data; ?>;
			var logger = document.getElementById('agora-folio-logger');
			if (!logger) {
				logger = document.createElement('div');
				logger.id = 'agora-folio-logger';
				document.body.appendChild(logger);
			}
			// console.log(obj);
			var pre = document.createElement('pre');
			var h2 = document.createElement('h2');
			pre.innerHTML = obj;
			h2.innerHTML = '<?php echo addslashes($label); ?>';
			logger.appendChild(h2);
			logger.appendChild(pre);
		};
		window.addEventListener ("DOMContentLoaded", doStuff, false);
	</script>
	<?php
}


/**
 * Display Post Blocks 
 */
function display_post_blocks() {
	global $post;
	pp( esc_html( $post->post_content ) );
}
// add_action( 'wp_footer', __NAMESPACE__ . '\\display_post_blocks' );