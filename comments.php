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

$comment_count = get_comments_number();
$anchor_name = is_single() || is_page() ? 'comments' : 'comments_' . get_the_ID();
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
		?>
		<h2 class="pb-2 mb-0 h5 comments-title ruler ruler--primary ruler--bottom">
      	<?php
      	
		if ( '1' === $comment_count ) {
			printf( $debate, get_the_title(), __( 'contribution' ), '<span class="num">' . $comment_count . '</span>' );
		} else {
			printf( $debate, get_the_title(), __( 'contributions' ), '<span class="num">' . $comment_count . '</span>' );
      	}
		?>
		</h2><!-- .comments-title -->

		<ol class="comment-list">
			<?php
			wp_list_comments( array(
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
		Pagination\comments_pagination();
		
	elseif ( is_single() || AGORA_FOLIO_LIST_COMMENTS ):
	?>
	<h2 class="pb-2 mb-0 h5 comments-title ruler ruler--primary ruler--bottom">
	<?php
		printf( $debate, get_the_title(), __( 'contribution' ), '<span class="visually-hidden">0</span>' );
	?>
	</h2><!-- .comments-title -->

	<?php
	endif; // Check for have_comments().

	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() ) : ?>
		<p class="ml-3 mt-3 no-comments"><?php esc_html_e( 'Debates are closed.', 'agora-folio' ); ?></p>
	<?php endif;

	if( is_single() ){
		//comment_form();
		Templates\comments_form();
	}
	?>

</div><!-- #comments -->
