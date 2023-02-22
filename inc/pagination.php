<?php
/**
 * Agora Folio Pagination
 *
 * @package AgoraFolio
 */

namespace AgoraFolio\Pagination;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


/**
 * Adjuns pagination links (screen readers prefix && leading zero)
 */
function pagination_link( $link ) {
  $n = (int)strip_tags($link);
  $before = '';
  if ($n > 0){
    $before = '<span class="visually-hidden">'.__( 'Page', 'agora-folio' ).' </span>';
    if ($n < 10) $before .= '0';
  }
  echo str_replace( 'page-numbers', 'pagination__link', str_replace( '<span class="before"></span>', $before, $link ) );
}


/**
 * Render pagination
 */
function render_pagination( $current = 0, $total = 0, $links = array(), $args = array() ) {

  if(empty($links) || empty($args)) return false;

  $num = count($links);

  $last = $num - 1;
  $rest = 10 - $last;
  if($current == 1 || $current == $total) $rest -= 1;
  if($current == $total) $last += 1;

  ?>
    <nav class="pagination-nav" aria-label="<?php echo $args['screen_reader_text']; ?>">
      <ul class="pagination">
        <?php
        if($current == 1){
        ?>
          <li class="col-md-2 pagination__item pagination__item--prev">
            <span class="prev btn btn--primary disabled"><?php echo __('Previous', 'agora-folio') ?></a>
          </li>
        <?php
        }
        $count = 1;
        foreach ( $links as $key => $link ) {

          if(strpos( $link, 'prev' )){
          ?>
            <li class="col-md-2 pagination__item pagination__item--prev">
              <?php echo str_replace( 'page-numbers', 'btn btn--primary', $link ); ?>
            </li>
          <?php
          } else if(strpos( $link, 'next' )) {
            ?>
            <li class="col-md-2 pagination__item pagination__item--next">
              <?php echo str_replace( 'page-numbers', 'btn btn--primary', $link ); ?>
            </li>
          <?php
          } else {
            $class = $count == $last ? 'col-md-' . $rest : 'col-md-1';
          ?>
          <li class="<?php echo $class; ?> pagination__item <?php echo strpos( $link, 'current' ) ? 'is-active' : '' ?>">
            <?php pagination_link($link); ?>
          </li>
          <?php
          }
          $count++;
        }
        if($current == $total){
        ?>
          <li class="col-md-2 pagination__item pagination__item--next">
            <span class="next btn btn--primary disabled"><?php echo __('Next', 'agora-folio') ?></a>
          </li>
        <?php
        }
        ?>
      </ul>
    </nav>
  <?php
}


/**
 * Posts pagination
 */
function pagination( $args = array() ) {

  $total = $GLOBALS['wp_query']->max_num_pages;
  if ($total <= 1) return;
  $current =  max( 1, get_query_var('paged'));

  $end = 1; $mid = 1;
  if ($current >= $total - 2 || $current < 3) $end = 3;
  if($current == 3 || $current == $total - 2) { $end = 1; $mid = 2; };
  $all = ($total <= 7) ? true : false;

  $args = wp_parse_args( $args, array(
    'end_size'           => $end,
    'mid_size'           => $mid,
    'show_all'           => $all,
    'prev_next'          => true,
    'prev_text'          => __('Previous', 'agora-folio'),
    'next_text'          => __('Next', 'agora-folio'),
    'screen_reader_text' => __('Navigation', 'agora-folio'),
    'type'               => 'array',
    'current'            => $current,
    'before_page_number' => '<span class="before"></span>'
  ) );

  $links = paginate_links($args);

  render_pagination($current, $total, $links, $args);
}



/**
 * Comments pagination
 */
function comments_pagination ( $args = array() ) {
  $total = get_comment_pages_count();

  if ($total <= 1) return;
  $current =  max( 1, get_query_var('cpage'));

  $end = 1; $mid = 1;
  if ($current >= $total - 2 || $current < 3) $end = 3;
  if($current == 3 || $current == $total - 2) { $end = 1; $mid = 2; };
  $all = ($total <= 7) ? true : false;

  $args = wp_parse_args( $args, array(
    'end_size'           => $end,
    'mid_size'           => $mid,
    'prev_next'          => true,
    'prev_text'          => __('Previous', 'agora-folio'),
    'next_text'          => __('Next', 'agora-folio'),
    'screen_reader_text' => __('Debate navigation', 'agora-folio'),
    'type'               => 'array',
    'echo'               => false,
    'current'            => $current,
    'before_page_number' => '<span class="before"></span>'
  ) );

  $links = paginate_comments_links($args);

  render_pagination($current, $total, $links, $args);
}

/**
 * Comments pagination
 */
function ajax_comments_pagination (  $args = array(), $view = 'tree' ) {
  $attr = implode(' ', array_map(function ($k, $v) { return 'data-' . $k . '="'. htmlspecialchars($v) .'"'; }, array_keys($args), $args ));
  if( $view === 'tree'): ?>
  <li class="tree-item tree-item-more tree-item-l0 open-node" role="presentation" data-tree-id="more_<?php the_ID() ?>">
    <div class="tree-node">
      <div class="tree-content pt-3 pb-4">
  <?php else: ?>
  <div class="load-more pb-4">
  <?php endif; ?>
        <a href="#" class="btnlink btnlink--regular btnlink--underline btn-load-more load-more-comments-js" <?php echo $attr ?>>
          <span class="icon icon--plus icon--xsmall icon--before" aria-hidden="true"></span><span class="label"><?php _e('Load more', 'agora-folio') ?></span>
        </a>
  <?php if( $view === 'tree'): ?>
      </div>
    </div>
  </li>
  <?php else: ?>
  </div>
  <?php endif;
}

