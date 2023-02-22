<?php

/**
 * Template part for displaying posts focused on comments
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

  <div class="entry-article comm-article ruler <?php echo $ruler ?>">

    <div class="row">

      <div class="col-sm-4 col-lg-3">

        <header class="entry-header">

          <?php echo $thumbnail; ?>

          <div class="entry-summary <?php echo $thumbnail ? 'with-thumb' : 'no-thumb' ?>">

            <div class="entry-summary-head">

              <?php Templates\posted_by_avatar(); ?>

              <div class="entry-summary-head-content flex-fill">

                <?php
                if (is_singular()) :
                  the_title('<h1 class="entry-title">', '</h1>');
                else :
                  the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" class="btnlink" rel="bookmark">', '</a></h2>');
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

            <div class="entry-meta ml-5 mt-2 mb-2">
              <?php Templates\evaluation_link($role, $status_act); ?>
            </div>


          </div><!-- .entry-summary -->

        </header><!-- .entry-header -->

      </div>

      <div class="col-sm-8 col-lg-9">
          <div class="entry-comments-wrapper">
            <?php if (AGORA_FOLIO_LIST_COMMENTS /*&& (comments_open() || get_comments_number())*/) :
              comments_template('/comments-list.php');
            endif; ?>
          </div>
      </div>

    </div>

  </div>

</article><!-- #post-<?php the_ID(); ?> -->