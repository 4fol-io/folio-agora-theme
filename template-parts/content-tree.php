<?php
/**
 * Template part for displaying posts with comments tree
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package AgoraFolio
 */


use AgoraFolio\Data;
use AgoraFolio\Templates;

$role = Data\uoc_get_current_role();
$status = '';
$status_act = null;
$ruler = 'ruler--primary';

if ( $role != '' ) {
  $status_act = Data\uoc_get_rac_status_activity($role);
  $status = $status_act['status'];
}

if(!empty($status)){
  $ruler = 'ruler--secondary';
  if( $status === 'pending' ) {
    $ruler = 'ruler--pending';
  }
}

$anchor_name = 'comments_' . get_the_ID();

?>
<li class="tree-item open-node" role="presentation" data-tree-id="<?php the_ID() ?>" data-tree-title="<?php esc_attr_e( get_the_title() ); ?>">

  <article id="post-<?php the_ID(); ?>" class="entry-article tree-node ruler <?php echo $ruler ?>">

      <header class="entry-header tree-header tree-content d-sm-flex">

        <?php Templates\post_thumbnail('large'); ?>

        <div class="entry-summary d-flex flex-column">

          <div class="entry-summary-wrap d-flex">

            <div class="entry-summary-head">

              <?php Templates\posted_by_avatar(); ?>

              <div class="entry-summary-head-content flex-fill">

                <?php
                if ( is_singular() ) :
                  the_title( '<h1 class="entry-title">', '</h1>' );
                else :
                  the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" class="btnlink" rel="bookmark">', '</a></h2>' );
                endif;
                ?>

                <div class="mb-2 entry-meta-list">
                    <div class="entry-author mb-1"><?php Templates\posted_by(); ?></div>
                    <div class="entry-meta">
                      <?php Templates\visibility_inline(); ?> - <?php Templates\posted_on('human'); ?>
                      <?php if ('post' === get_post_type()) : Templates\comments_link_inline(); endif; ?>
                    </div>
                </div>

              </div>

            </div><!-- .entry-summary-head -->

            <div class="mb-2 entry-actions d-flex align-items-start mb-md-3">
              <?php Templates\evaluation_link($role, $status_act); ?>
            </div>

            <a class="btnlink btn--collapse collapsed" role="button" href="#post-body-<?php the_ID(); ?>" data-toggle="collapse" aria-expanded="false" aria-controls="post-body-<?php the_ID(); ?>">
              <span class="icon icon--small icon--collapse" aria-hidden="true"></span>
              <span class="icon-alt"><?php echo __( "expand / collapse", "agora-folio" ); ?></span>
            </a>

          </div><!-- .entry-summary-wrap -->

        
        </div><!-- .entry-summary -->

      

      </header><!-- .entry-header -->


      <div id="post-body-<?php the_ID(); ?>" class="entry-collapse clearfix collapse" data-post-id="<?php the_ID(); ?>">
        <div class="clearfix entry-body tree-content">
          <?php if(!AGORA_FOLIO_LIST_AJAX) the_content(); ?>
        </div>
        <footer class="entry-footer tree-content"><?php Templates\entry_footer(); ?></footer><!-- .entry-footer -->

        <div class="tree-content">

          <?php Templates\evaluation_area($role, $status_act); ?>

          <?php if ( AGORA_FOLIO_LIST_COMMENTS && comments_open() && is_user_logged_in() ) : ?>

            <div class="entry-comments comments-area <?php echo get_option('show_avatars', 0) ? 'with-avatars' : 'no-avatars'; ?>" tabindex="-1">

              <a class="anchor" name="<?php echo $anchor_name; ?>"></a>

              <?php
              $debate =  esc_html__( 'Debate', 'agora-folio' );
              $debate .= '<span class="icon icon--before icon--after icon-svg icon-svg--debate" aria-hidden="true"></span>';
              $debate .= '<span class="icon-alt" aria-hidden="true">%2$s </span>%3$s';
              /* translators: %1$s: post title */
              $debate .= '<span class="visually-hidden">'. esc_html__( 'on %1$s', 'agora-folio' ) . '</span>';

              $comments_count = get_comments_number();

              if ( $comments_count ) :
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

              <?php else: ?>
                <h2 class="pb-2 mb-0 h5 comments-title ruler ruler--primary ruler--bottom">
                  <?php
                    printf( $debate, get_the_title(), __( 'contribution' ), '<span class="visually-hidden">0</span>' );
                  ?>
                </h2><!-- .comments-title -->
              <?php endif; ?>

             
              <div class="entry-comment-list mb-2">
                  <button type="button" class="btn btn--primary btn--lower btn-comment-list" data-id="<?php echo get_the_ID() ?>">
                      <?php esc_html_e( 'Leave a comment', 'agora-folio' ); ?><span class="icon icon--after icon-svg icon-svg--debate"></span>
                  </button>
              </div>

            </div>
            
          <?php endif; ?>

        </div>
              
      </div>

  </article><!-- #post-<?php the_ID(); ?> -->

  <?php 
  if ( AGORA_FOLIO_LIST_COMMENTS /*&& ( comments_open() || get_comments_number() )*/ ) :
        comments_template('/comments-tree.php');
  endif; 
  ?>

</li>
