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
Use AgoraFolio\Pagination;
Use AgoraFolio\Templates;

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

$comments_count = get_comments_number();

if ( !AGORA_FOLIO_LIST_COMMENTS /*|| !( comments_open() || $comments_count )*/ ) {
	return;
}

$anchor_name = is_single() || is_page() ? 'comments' : 'comments_' . get_the_ID();
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

<div class="entry-comments comments-area <?php echo get_option('show_avatars', 0) ? 'with-avatars' : 'no-avatars'; ?>" tabindex="-1">

	<a class="anchor" name="<?php echo $anchor_name; ?>"></a>

  	<?php
	// You can start editing here -- including this comment!

	$debate =  esc_html__( 'Debate', 'agora-folio' );
	$debate .= '<span class="icon icon--before icon--after icon-svg icon-svg--debate" aria-hidden="true"></span>';
	$debate .= '<span class="icon-alt" aria-hidden="true">%2$s </span>%3$s';
	/* translators: %1$s: post title */
	$debate .= '<span class="visually-hidden">'. esc_html__( 'on %1$s', 'agora-folio' ) . '</span>';

  	if ( have_comments() ) :
	//if ( $comments_count ) :

		set_query_var( 'cpage', $cpage );
		set_query_var( 'comments_per_page', $per_page );

		?>
		<h2 class="pb-2 mb-0 h5 comments-title ruler ruler--primary ruler--bottom">
      	<?php
      	
		if ( '1' === $comments_count ) {
			printf( $debate, get_the_title(), __( 'contribution' ), '<span class="num">' . $comments_count . '</span>' );
		} else {
			printf( $debate, get_the_title(), __( 'contributions' ), '<span class="num">' . $comments_count . '</span>' );
      	}
		?>
		</h2><!-- .comments-title -->

		<ol class="comment-list">
			<?php
			wp_list_comments( array(
				'page' => $cpage,
				'style'      => 'ol',
				'avatar_size' => 70,
				'short_ping' => true,
				'type' => 'comment',
				'callback' => 'AgoraFolio\Templates\comment_item'
			));
			?>
		</ol><!-- .comment-list -->

   		<?php
		//the_comments_navigation();
		//Pagination\comments_pagination();

		if( $paginated && $tpages > 1 ) :
			Pagination\ajax_comments_pagination( array (
				'page' => $cpage,
				'pages' => $tpages,
				'order' => $order,
				'dir' => $direction,
				'post-id' => get_the_ID()
			), 'list' );
		endif;

	elseif ( is_single() || AGORA_FOLIO_LIST_COMMENTS ):
	?>
	<h2 class="pb-2 mb-0 h5 comments-title ruler ruler--primary ruler--bottom">
	<?php
		printf( $debate, get_the_title(), __( 'contribution' ), '<span class="visually-hidden">0</span>' );
	?>
	</h2><!-- .comments-title -->

	<p class="no-comments mt-3"><?php esc_html_e( 'There are no comments.', 'agora-folio' ); ?></p>

	<?php
	endif; // Check for have_comments().

	// No comments
	if ( ! comments_open() ) : ?>
		<p class="no-comments mt-3"><?php esc_html_e( 'Debates are closed.', 'agora-folio' ); ?></p>
	<?php endif;

	if( is_single() ){
		//comment_form();
		Templates\comments_form();
	} else if ( comments_open() && is_user_logged_in() ){

	?>
		<div class="entry-comment-list mb-2">
			<button type="button" class="btn btn--primary btn--lower btn-comment-list" data-id="<?php echo get_the_ID() ?>">
				<?php esc_html_e( 'Leave a comment', 'agora-folio' ); ?><span class="icon icon--after icon-svg icon-svg--debate"></span>
			</button>
		</div>
	<?php
	} else if ( ! is_user_logged_in() ){
		printf(
			'<p class="must-log-in">%s</p>',
			sprintf(
				/* translators: %s: Login URL. */
				__( 'You must be <a href="%s">logged in</a> to post a comment.' ),
				/** This filter is documented in wp-includes/link-template.php */
				wp_login_url( apply_filters( 'the_permalink', get_permalink( get_the_ID() ), get_the_ID() ) )
			)
		);
	}

	?>

</div><!-- #comments -->
