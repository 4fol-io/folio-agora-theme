<?php

/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package AgoraFolio
 */


use AgoraFolio\Data;
use AgoraFolio\Utils;
use AgoraFolio\Templates;

$role = Data\uoc_get_current_role();
$status = '';
$status_act = null;
$ruler = 'ruler--primary';

if ($role != '') {
  $status_act = Data\uoc_get_rac_status_activity($role);
  $status = $status_act['status'];
}

if (!empty($status)) {
  $ruler = 'ruler--secondary';
  if( $status === 'pending' ) {
    $ruler = 'ruler--pending';
  }
}

ob_start();
Templates\post_thumbnail('large');
$thumbnail = ob_get_contents();
ob_end_clean();

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(['view-col', $status]); ?>>

  <div class="entry-article <?php if (!AGORA_FOLIO_LIST_AJAX) echo 'expanded'; ?>">

    <header class="entry-header d-sm-flex ruler <?php echo $ruler ?>">

      <div class="entry-summary-head-grid">

        <?php Templates\posted_by_avatar(); ?>

        <div class="entry-summary-head-content">

          <?php
          if (is_singular()) :
            the_title('<h1 class="entry-title">', '</h1>');
          else :
            the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" class="btnlink" rel="bookmark">', '</a></h2>');
          endif;

          ?>

          <div class="entry-meta-grid mb-2">
            <div class="entry-author mb-1"><?php Templates\posted_by(); ?></div>
            <div class="entry-meta">
              <?php Templates\visibility_inline(); ?> - <?php Templates\posted_on('human'); ?>
              <?php if ('post' === get_post_type()) : Templates\comments_link_inline(); endif; ?>
            </div>
          </div>

        </div>

      </div><!-- .entry-summary-head-grid -->

      <?php echo $thumbnail; ?>

      <div class="entry-summary d-flex flex-column <?php echo $thumbnail ? 'with-thumb' : 'no-thumb' ?>">

        <div class="entry-summary-wrap d-flex">

          <div class="entry-summary-head">

            <?php Templates\posted_by_avatar(); ?>

            <div class="entry-summary-head-content">

              <?php
              if (is_singular()) :
                the_title('<h1 class="entry-title">', '</h1>');
              else :
                the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" class="btnlink" rel="bookmark">', '</a></h2>');
              endif;
              ?>

              <div class="entry-meta-list mb-2">
                  <div class="entry-author mb-1"><?php Templates\posted_by(); ?></div>
                  <div class="entry-meta">
                    <?php Templates\visibility_inline(); ?> - <?php Templates\posted_on('human'); ?>
                    <?php if ('post' === get_post_type()) : Templates\comments_link_inline(); endif; ?>
                  </div>
              </div>

            </div>
          
          </div><!-- .entry-summary-head -->


          <div class="mb-1 entry-excerpt excerpt-short">
            <div class="mb-3"><?php echo $thumbnail ? Utils\get_excerpt(22) : Utils\get_excerpt(80); ?></div>
          </div>

          <div class="mb-2 entry-actions d-flex align-items-start mb-md-3">
            <?php Templates\evaluation_link($role, $status_act); ?>
          </div>

          <a class="btnlink btn--collapse <?php if (!AGORA_FOLIO_LIST_AJAX) echo 'collapsed'; ?>" role="button" href="#post-body-<?php the_ID(); ?>" data-toggle="collapse" aria-expanded="<?php echo AGORA_FOLIO_LIST_AJAX ? 'false' : 'true'; ?>" aria-controls="post-body-<?php the_ID(); ?>">
            <span class="icon icon--small icon--collapse" aria-hidden="true"></span>
            <span class="icon-alt"><?php echo __("expand / collapse", "agora-folio"); ?></span>
          </a>

        </div><!-- .entry-summary-wrap -->

        <div class="entry-excerpt excerpt-long mt-auto">
          <div class="mb-3 hidden-sm hidden-md"><?php echo Utils\get_excerpt(48); ?></div>
          <div class="mb-1 visible-sm visible-md"><?php echo Utils\get_excerpt(19); ?></div>
        </div>

        <?php /*<div class="entry-meta d-flex align-items-end justify-content-between">
          <?php Templates\posted_on(); ?>
          <?php Templates\visibility(); ?>
        </div>*/ ?>

        <div class="entry-meta-grid mb-2">
          <?php Templates\evaluation_link($role, $status_act); ?>
        </div>


      </div><!-- .entry-summary -->



    </header><!-- .entry-header -->


    <div id="post-body-<?php the_ID(); ?>" class="entry-collapse clearfix collapse <?php if (!AGORA_FOLIO_LIST_AJAX) echo 'show'; ?>" data-post-id="<?php the_ID(); ?>">
      <div class="clearfix entry-body ruler ruler--half">
        <?php if (!AGORA_FOLIO_LIST_AJAX) the_content(); ?>
      </div>
      <footer class="entry-footer"><?php Templates\entry_footer(); ?></footer><!-- .entry-footer -->

      <?php Templates\evaluation_area($role, $status_act); ?>

      <?php if (AGORA_FOLIO_LIST_COMMENTS /*&& (comments_open() || get_comments_number())*/) :
        comments_template('/comments-list.php');
      endif; ?>
    </div>

  </div>

</article><!-- #post-<?php the_ID(); ?> -->