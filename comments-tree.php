<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package AgoraFolio
 */

use AgoraFolio\Utils;
use AgoraFolio\Pagination;
use AgoraFolio\Templates;

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

$comments_count = get_comments_number();

if ( AGORA_FOLIO_LIST_COMMENTS && !( comments_open() || $comments_count ) ) {
	return;
}


//$anchor_name = is_single() || is_page() ? 'comments' : 'comments_' . get_the_ID();
$avatars = get_option('show_avatars', 0) ? 'with-avatars' : 'no-avatars';
$paginated = get_option( 'page_comments' );
$per_page = (int) get_option('comments_per_page');
$order = get_option('comment_order');
$direction = get_option('default_comments_page');
$cpage = 1;
$tpages = 0;

if ( $paginated && $comments_count ){

	
	$threaded = get_option( 'thread_comments' );
	$tpages = ceil($comments_count / $per_page);
	
	if ( $threaded ) {
		$thread_count = Utils\get_top_level_comments_number();
		$tpages = ceil($thread_count / $per_page);
	}
			
	if ( $direction === 'newest' ) {
		$cpage = $tpages;
	}
}
?>
<ul class="comment-list tree-list comments-area list--unstyled collapse show <?php echo $avatars ?>" 
	role="region" 
	id="node_list_<?php echo get_the_ID() ?>" 
	aria-labelledby="node_toggle_<?php echo get_the_ID() ?>">	
<?php

	if ( $comments_count ) :

		set_query_var( 'cpage', $cpage );
		set_query_var( 'comments_per_page', $per_page );

		wp_list_comments( array(
			'page' => $cpage,
			'walker'            => new AgoraFolio\Walker\Tree_Walker_Comment(),
			'style'      => 'ul',
			'avatar_size' => 70,
			'short_ping' => true,
			'type' => 'comment',
			'callback' => 'AgoraFolio\Templates\comment_tree_item'
		));

		if( $paginated && $tpages > 1 ) :
			Pagination\ajax_comments_pagination( array (
				'page' => $cpage,
				'pages' => $tpages,
				'order' => $order,
				'dir' => $direction,
				'post-id' => get_the_ID()
			), 'tree' );
		endif;

	endif; // Check for have_comments().
	?>

	<?php

	

	/*if ( comments_open() && is_user_logged_in() ) :
	?>
		<li class="tree-item open-node"  data-tree-id="add_<?php the_ID() ?>" data-tree-title="<?php esc_attr_e( 'Leave a comment', 'agora-folio' ); ?>">
			<div class="tree-node">
				<div class="entry-header">
					<button type="button" class="btn btn--primary btn--lower btn-comment-list mt-3" data-id="<?php echo get_the_ID() ?>">
						<?php esc_html_e( 'Leave a comment', 'agora-folio' ); ?><span class="icon icon--after icon-svg icon-svg--debate"></span>
					</button>
				</div>
			</div>
		</li>
	<?php
	endif;*/
	?>

</ul><!-- .comment-list -->
