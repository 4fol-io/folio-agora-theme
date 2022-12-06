<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package AgoraFolio
 */

if ( ! is_active_sidebar( 'footer' ) ) {
	return;
}

?>

<aside id="secondary" class="widget-area footer-widgets py-3 row">

  <?php if ( is_active_sidebar( 'footer' ) ) : ?>
    <?php dynamic_sidebar( 'footer' ); ?>
  <?php endif; ?>

</aside><!-- #secondary -->
