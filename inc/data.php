<?php
/**
 * Agora Folio data access utilities
 *
 * @package AgoraFolio
 */

namespace AgoraFolio\Data;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

use Edu\Uoc\Te\Uocapi\Model\Vo\Classroom;

/**
 * Get RAC/Canvas evaluation url
 */
function get_lms_evaluation_url() {
	$proxyUrl = '';
	$classroom = ucs_get_classroom_cur_blog();

	if ($classroom != null) {
		switch ($classroom->getInstitution()) {
			case Classroom::INSTITUTION_UOC_API:
				global $openIDUOC;

				if ( $openIDUOC ) {
					$rac_url     = 'https://[HOST]/UOC/rac/consultor.html?domainId=[DOMAINID]';
			
					$patterns = array( '/\[DOMAINID\]/' );
					$replaces = array( $classroom != null ? $classroom->getId() : '' );
			
					$url      = preg_replace( $patterns, $replaces, $rac_url );
					$proxyUrl = $openIDUOC->get_uoc_url_session_refresh( $url );
				}
			break;
			case Classroom::INSTITUTION_CANVAS:
				$gradebook_url = 'https://uoc.test.instructure.com/courses/{classroom_id}/gradebook';
				
				if ( str_starts_with(CVAPI_BASE_URL, 'https://platin.uoc.edu') ) {
					$gradebook_url = 'https://uoc.instructure.com/courses/{classroom_id}/gradebook';
				}

				$proxyUrl = str_replace('{classroom_id}', $classroom->getId(), $gradebook_url);
			break;
			default:
				throw new \BadMethodCallException('Not implemented');
			break;
		}
	}

	return $proxyUrl;
}

/**
 * Checks if use external RAC evaluation (depreciated)
 * 
 * @return bool
 */
function use_external_rac() {
	global $portafolis_uoc_rac;
	if( $portafolis_uoc_rac ){
		return $portafolis_uoc_rac->use_external_rac();
	}
	return false;
}

/**
 * Get folio url for breadcrumbs
 */
function get_folio_url() {
	$blog_id = 1;
	if ( is_user_logged_in() && function_exists( 'uoc_create_site_get_full_domain' ) ) {
		$user   = get_user_by( 'ID', get_current_user_id() );
		$domain = uoc_create_site_get_full_domain( $user );
		$path   = '/';

		$blog_id = domain_exists( $domain, $path );

	}

	return get_home_url( $blog_id );
}

/**
 * Get semester title
 */
function get_semester() {
	$semester = get_option( 'folio_classroom_semester', '' );
	if ( empty( $semester ) && function_exists( 'ucs_get_classroom_cur_blog' ) ) {
		$classroom = ucs_get_classroom_cur_blog();
		if ( $classroom != null ) {
			$semester = uoc_get_semester_from_classroom( $classroom );
			if ( $semester ) {
				add_option( 'folio_classroom_semester', $semester );
			}
		}
	}

	return sprintf( __( 'Semester %s', 'agora-folio' ), $semester );
}


/**
 * Get classroom title
 */
function get_classroom() {
	$classroom_number = get_option( 'folio_classroom_number', '' );
	if ( empty( $classroom_number ) && function_exists( 'ucs_get_classroom_cur_blog' ) ) {
		$classroom = ucs_get_classroom_cur_blog();
		if ( $classroom != null ) {
			$classroom_row = uoc_create_site_get_classroom_by_id( $classroom );
			if ( $classroom_row ) {
				$code      = $classroom_row->code;
				$classroom_number = intval( preg_replace( "/.*\_(\d+)(\.[\w\d]+)?$/", "$1", $code ) );
				if ( is_int( $classroom_number ) ) {
					add_option( 'folio_classroom_number', $classroom_number );
				}
			}
		}
	}

	return sprintf( __( 'Classroom %s', 'agora-folio' ), $classroom_number );
}


/**
 * Get agora display view from cookie if set
 * Updated (16/01/2023): unified list and full views
 */
function get_agora_view() {
	// $views = [ 'grid', 'list', 'full', 'tree' ];
	$views = [ 'grid', 'list', 'comm'];

	$view  = get_query_var( 'view' );

	if ( $view && in_array( $view, $views ) ) {
		return $view;
	}

	$view = isset( $_COOKIE['agora-view'] ) ? $_COOKIE['agora-view'] : '';
	if ( $view && in_array( $view, $views ) ) {
		return $view;
	}

	return 'grid';
}


/**
 * Returns the actifolio menu for tree view
 */
function get_actifolio_tree_view_menu_items( $term_id = false ) {

	$parsed = array();
	$items  = array();

	$actiUocs = get_terms( 'actiuoc', array( 'hide_empty' => false ) );

	if ( ! empty( $actiUocs ) && ! is_wp_error( $actiUocs ) ) {

		if ( uoc_create_site_is_student_blog() ) {

			$tmp = array();

			foreach ( $actiUocs as $term ) {
				// Is activity Add hierarchy
				if ( $term->parent > 0 ) {
					if ( ! isset( $tmp[ $term->parent ] ) ) {
						$parent_term = get_term( $term->parent );
						if ( $parent_term ) {
							if ( ! isset( $parent_term->children ) ) {
								$parent_term->children = array();
							}
							$parent_term->children[] = $term;
							if ( $parent_term->parent != 0 ) {
								$grandfather_term = get_term( $parent_term->parent );
								if ( $parent_term ) {
									if ( ! isset( $grandfather_term->children ) ) {
										$grandfather_term->children = array();
									}
									$grandfather_term->children[] = $parent_term;
									$tmp[ $parent_term->parent ]  = $grandfather_term;
								}
							} else {
								$tmp[ $term->parent ] = $parent_term;
							}
						}
					}
				} else {
					$term->children        = array();
					$tmp[ $term->term_id ] = $term;
				}
			}

			foreach ( $tmp as $actiFolio ) {
				$parsed[] = $actiFolio;
				if ( count( $actiFolio->children ) > 0 ) {
					foreach ( $actiFolio->children as $child ) {
						$parsed[] = $child;
						if ( count( $child->children ) > 0 ) {
							foreach ( $child->children as $grandchild ) {
								$parsed[] = $grandchild;
							}
						}
					}
				}
			}

		} else {

			foreach ( $actiUocs as $term ) {
				// Is activity.
				if ( strpos( $term->slug, 'activity-' ) === 0 ) {
					$parsed[] = $term;
				}
			}

		}
	}

	foreach ( $parsed as $term ) {

		$posts_array = get_posts(
			array(
				'posts_per_page' => - 1,
				'post_status'    => array( 'publish', 'private' ),
				'tax_query'      => array(
					array(
						'taxonomy' => 'actiuoc',
						'field'    => 'term_id',
						'terms'    => $term->term_id,
					),
				),
			)
		);

		if ( count( $posts_array ) > 0 ) {
			$items[] = (object) array(
				'term'   => $term,
				'count'  => count( $posts_array ),
				'active' => $term->term_id === $term_id
			);
		}

	}

	return $items;
}



/*** IMPORTED METHODS FROM VISADES THEME ***/


function uoc_modify_archive_actiuoc_title( $title ) {
	$term  = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
	$title = single_cat_title( '', false );

	return $title;
}

add_filter( 'get_the_archive_title', __NAMESPACE__ . '\\uoc_modify_archive_actiuoc_title' );


function uoc_create_site_footer_actions() {
	$post = get_post();
	if ( $post->ID ) {
		$extra_content = '';
		$actiuoc       = wp_get_post_terms( $post->ID, 'actiuoc' );
		$actiuoc_links = array();

		if ( count( $actiuoc ) > 0 ) {

			$extra_content .= '<div class="actiuocs-box">';
			for ( $i = 1; $i <= count( $actiuoc ); $i ++ ) {
				$link = get_term_link( $actiuoc[ $i - 1 ]->term_id );
				array_push( $actiuoc_links, $link );
				$extra_content .= '<a href=' . $actiuoc_links[ $i - 1 ] . '>';
				$extra_content .= $actiuoc[ $i - 1 ]->name . " </span></a><br>";
			}

			$extra_content .= "</div>";

		}
		$content = $extra_content;
	}
	echo $content;
}

add_filter( 'add_actiuocs', __NAMESPACE__ . '\\uoc_create_site_footer_actions' );


function uoc_get_rac_status_activity( $role = '' ) {

	if ( AGORA_FOLIO_DEMO_MODE ) {
		$rnd = rand( 0, 5 );
		if ( $rnd ) {
			return [
				'status'      => rand( 0, 1 ) === 0 ? 'pending' : 'sent',
				'activity'    => (object) [
					'grade'      => 'C+',
					'feedback'   => 'Fake feedback DEMO phasellus tempus. Etiam iaculis nunc ac metus. In hac habitasse platea dictumst. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Suspendisse potenti.',
					'public_url' => '#'
				],
				'submissonId' => '0'
			];
		} else {
			return [
				'status'      => '',
				'activity'    => null,
				'submissonId' => null
			];
		}
	}

	global $portafolis_uoc_rac;
	$status       = '';
	$activity_ret = null;
	$submissonId  = null;
	$activities   = $portafolis_uoc_rac->get_if_is_submitted( get_the_ID() );
	if ( count( $activities ) > 0 ) {
		$status = 'pending';
		foreach ( $activities as $activity ) {
			// TODO: Comentar con @antoni: Duda
			// Por que hace esto? es un poco raro...
			$submissonId = $submissonId == null || $submissonId < $activity->id ? $activity->id : $submissonId;
			if ( $activity->grade != null && ! empty( $activity->grade ) ) {
				$status = 'sent';
				\switch_to_blog( $activity->blogId );
				$activity->public_url = $portafolis_uoc_rac->get_permalink( $activity->postId );
				\restore_current_blog();
				$activity_ret = $activity;

				if ( $role == 'student' ) {
					$rac_delivery = $portafolis_uoc_rac->get_rac_delivery( $submissonId );

					$activityId = $rac_delivery->activityId;
					if ( $rac_delivery->visibility == 0 ) {
						// Check if has to show
						$qualification_date = $portafolis_uoc_rac->get_activity_qualification_date( $activityId );
						if ( $qualification_date != null ) {
							if ( \DateTime::createFromFormat( 'Y-m-d h:i:s',
									$qualification_date )->getTimestamp() > time() ) {
								$status = 'pending';
							}
						}
					}

				}
				break;
			}
		}
	}

	return [
		'status'      => $status,
		'activity'    => $activity_ret,
		'submissonId' => $submissonId
	];
}

function uoc_can_access_to_assessment() {

	if ( AGORA_FOLIO_DEMO_MODE ) {
		return rand( 0, 1 );
	}

	if ( ! function_exists( 'ucs_is_classroom_blog' ) ) {
		return 0;
	}

	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

	$enable_grade = is_plugin_active( 'portafolis-uoc-rac/portafolis-uoc-rac.php' );
	global $portafolis_uoc_rac;

	return $enable_grade && isset( $portafolis_uoc_rac ) && $portafolis_uoc_rac != null &&
	       ( ucs_is_classroom_blog() || uoc_create_site_is_current_student_blog() );

}

function uoc_get_current_role() {

	if ( AGORA_FOLIO_DEMO_MODE ) {
		return rand( 0, 1 ) === 0 ? 'student' : 'teacher';
	}

	$role = '';
	if ( uoc_can_access_to_assessment() ) {
		global $portafolis_uoc_rac;
		$role =
			$portafolis_uoc_rac->get_is_teacher() ? "teacher" :
				( get_current_user_id() == get_the_author_meta( 'ID' ) ? 'student' : '' );

	}

	return $role;

}


/*** END IMPORTED METHODS FROM VISADES THEME ***/


/**
 * Add custom query vars
 */
function add_query_vars( $vars ) {
	$vars[] = 'view';

	return $vars;
}

add_filter( 'query_vars', __NAMESPACE__ . '\\add_query_vars' );



/**
 * Setup custom order by
 */
add_action( 'pre_get_posts', function( $query ) {
	if ( ! $query->is_main_query() || is_admin() ) {
        return;
    }
	if ('firstname' === $query->get( 'orderby' ) ){
		add_filter( 'posts_clauses', __NAMESPACE__ . '\\orderby_first_name', 10, 2 );
	}

	if ('lastname' === $query->get( 'orderby' ) ){
		add_filter( 'posts_clauses', __NAMESPACE__ . '\\orderby_last_name', 10, 2 );
	}
} );
 
/**
 * Custom order by author first name
 */
function orderby_first_name( $clauses, $query ) {
    global $wpdb;

	$clauses = add_clauses_agora($clauses);
	$clauses['join'] .= 'LEFT JOIN ' . $wpdb->usermeta . ' AS author ON ( ' . $wpdb->posts . '.post_author = author.user_id and author.meta_key = "first_name" ) ';
    $clauses['orderby'] = 'author.meta_value ' . $query->get( 'order' );
 
    return $clauses;
}

function add_clauses_agora( $clauses ) {

	if (!isset($clauses['join'])) {
		$clauses['join'] = '';
	}
	return $clauses;
}

/**
 * Custom order by author last name
 */
function orderby_last_name( $clauses, $query ) {
    global $wpdb;

	$clauses = add_clauses_agora($clauses);

    $clauses['join'] .= ' LEFT JOIN ' . $wpdb->usermeta . ' AS author ON ( ' . $wpdb->posts . '.post_author = author.user_id and author.meta_key = "last_name" ) ';
	$clauses['orderby'] = 'author.meta_value ' . $query->get( 'order' );
 
    return $clauses;
}

/**
 * Custom order by author nice name
 */
function orderby_nicename( $clauses, $query ) {
    global $wpdb;

	$clauses = add_clauses_agora($clauses);

    $clauses['join'] .= 'LEFT JOIN ' . $wpdb->users . ' AS author ON ( ' . $wpdb->posts . '.post_author = author.ID)';
    $clauses['orderby'] = 'author.user_nicename ' . $query->get( 'order' );
	
    return $clauses;
}



/**
 * Get an associative array of term names, keyed by term ID
 */
function get_terms_assoc( $tax, $hide_empty = true, $order = 'ASC', $exclude = array() ) {
	return get_terms( array(
		'taxonomy'   => $tax,
		'exclude'    => $exclude,
		'order'      => $order,
		'orderby'    => 'name',
		'hide_empty' => $hide_empty,
		'fields'     => 'id=>name',
	) );
}


/**
 * Get terms list without links
 */
function get_the_terms_list_raw( $id, $tax ) {
	$terms = get_the_terms( $id, $tax );
	if ( ! is_wp_error( $terms ) ) {
		return implode( " / ", wp_list_pluck( $terms, 'name' ) );
	}

	return '';
}


/**
 * Get hierarchical terms ordered with links
 */
function get_the_terms_list_ordered( $id, $tax ) {
	$terms = wp_get_post_terms( $id, $tax, array( "fields" => "ids" ) );
	if ( $terms ) {
		$terms  = trim( implode( ',', (array) $terms ), ' ,' );
		$output = wp_list_categories( array(
			'title_li'  => '',
			'style'     => 'none',
			'echo'      => false,
			'separator' => ' / ',
			'taxonomy'  => $tax,
			'include'   => $terms
		) );

		return preg_replace( '@\s/\s\n$@', '', $output );
	}

	return '';
}


/**
 * Get related posts ($params['ids']: array of related post ids)
 */
function get_related( $params ) {
	$args  = array(
		'post_type'       => array( 'post', 'page' ),
		'posts_per_page'  => - 1,
		'orderby'         => 'post__in',
		'order'           => 'ASC',
		'supress_filters' => true
	);
	$ids   = $params['ids'];
	$posts = [];
	if ( ! empty( $ids ) ) {
		$args['include'] = $ids;
		$posts           = get_posts( $args );
	}

	return $posts;
}


/**
 * Ajax get post content
 */
function get_ajax_agora_post() {
	check_ajax_referer( 'agora_folio_theme' );

	$post_id  = intval( $_POST['post_id'] );
	$response = array();

	if ( $post_id == 0 ) {
		$response['error']  = 'true';
		$response['result'] = 'Invalid input';
	} else {
		global $post;
		$post = get_post( $post_id );
		if ( ! is_object( $post ) ) {
			$response['error']  = 'true';
			$response['result'] = 'Not found';
		} else {
			$response['error']   = 'false';
			$response['pdf_url'] = esc_url( add_query_arg( 'pdf', $post->ID, get_permalink() ) );
			$response['result']  = apply_filters( 'the_content', $post->post_content );
		}
	}

	wp_send_json( $response );
	wp_die();
}

add_action( 'wp_ajax_nopriv_get_ajax_agora_post', __NAMESPACE__ . '\\get_ajax_agora_post' );
add_action( 'wp_ajax_get_ajax_agora_post', __NAMESPACE__ . '\\get_ajax_agora_post' );


/**
 * Ajax Load more comments in lists
 * FIXME: La carga de comentarios vía ajax solo funciona para administradores!!!
 * Bloqueado por plugin press-permit-core > comments-interceptor_pp.php > comments_clauses
 */
function load_more_comments_list_ajax() {

	check_ajax_referer( 'agora_folio_theme' );

	$post_id  = intval( $_POST['post_id'] );
	$page     = intval( $_POST['page'] );
	$response = array();

	if ( $post_id == 0 ) {
		$response['error'] = 'true';
	} else {
		global $post;
		global $withcomments;
		$post = get_post( $post_id );
		setup_postdata( $post );
		$withcomments = 1;
		if ( ! is_object( $post ) ) {
			$response['error'] = 'true';
		} else {
			set_query_var( 'cpage', $page );
			set_query_var( 'comments_per_page', get_option( 'comments_per_page' ) );
			$result             = wp_list_comments( array(
				'page'        => $page,
				'style'       => 'ol',
				'avatar_size' => 70,
				'short_ping'  => true,
				'type'        => 'comment',
				'callback'    => 'AgoraFolio\Templates\comment_item',
				'echo'        => false
			) );
			$response['result'] = $result;
		}
	}

	wp_send_json( $response );
	wp_die();
}

add_action( 'wp_ajax_nopriv_load_more_comments_list_ajax', __NAMESPACE__ . '\\load_more_comments_list_ajax' );
add_action( 'wp_ajax_load_more_comments_list_ajax', __NAMESPACE__ . '\\load_more_comments_list_ajax' );


/**
 * Ajax Load more comments in tree
 * FIXME: La carga de comentarios vía ajax solo funciona para administradores!!!
 * Bloqueado por plugin press-permit-core > comments-interceptor_pp.php > comments_clauses
 */
function load_more_comments_tree_ajax() {

	check_ajax_referer( 'agora_folio_theme' );

	$post_id  = intval( $_POST['post_id'] );
	$page     = intval( $_POST['page'] );
	$response = array();

	if ( $post_id == 0 ) {
		$response['error'] = 'true';
	} else {
		global $post;
		global $withcomments;
		$post = get_post( $post_id );
		setup_postdata( $post );
		$withcomments = 1;
		if ( ! is_object( $post ) ) {
			$response['error'] = 'true';
		} else {
			set_query_var( 'cpage', $page );
			set_query_var( 'comments_per_page', get_option( 'comments_per_page' ) );
			$result             = wp_list_comments( array(
				'page'        => $page,
				'walker'      => new \AgoraFolio\Walker\Tree_Walker_Comment(),
				'style'       => 'ul',
				'avatar_size' => 70,
				'short_ping'  => true,
				'type'        => 'comment',
				'callback'    => 'AgoraFolio\Templates\comment_tree_item',
				'echo'        => false
			) );
			$response['result'] = $result;
		}
	}

	wp_send_json( $response );
	wp_die();
}

add_action( 'wp_ajax_nopriv_load_more_comments_tree_ajax', __NAMESPACE__ . '\\load_more_comments_tree_ajax' );
add_action( 'wp_ajax_load_more_comments_tree_ajax', __NAMESPACE__ . '\\load_more_comments_tree_ajax' );
