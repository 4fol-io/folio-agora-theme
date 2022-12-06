<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package AgoraFolio
 */

?>

      </div><!-- #content -->

      <?php get_sidebar(); ?>

    </div><!-- .container -->

  </div><!-- #site-container -->


  <!-- GoToTop -->
  <div class="sticky-scroll-foot hidden-xs hidden-sm">
    <a class="sticky-scroll off" role="button" href="#page">
      <span class="icon icon--scroll-to icon--info--small" aria-hidden="true"></span>
      <span class="icon-alt"><?php echo __( "Go to top", "agora-folio" ); ?></span>
    </a>
  </div>

  <?php if ( ! is_user_logged_in() ): ?>
  <!-- Alert overlay -->
  <div class="alert alert-dismissible alert--primary-overlay fade show" role="alert">
    <div class="container">
      <div class="d-md-flex justify-content-between py-1 py-md-3">
          <div class="alert-icon mr-3 mt-md-n1">
            <span class="icon icon--info-full" aria-hidden="true"></span>
            <span class="icon-alt" aria-hidden="true"><?php esc_html_e('Information', 'agora-folio') ?></span>
          </div>
          <div class="alert-content my-2 my-md-0">
            <h4 class="alert-title"><?php esc_html_e('Are you part of the community? Access to see more publications.', 'agora-folio') ?></h4>
            <p class="mb-0 hidden-xs hidden-sm"><?php esc_html_e('This is a personal workspace for a student of the Universitat Oberta de Catalunya. Any content published in this space is the responsibility of its author.', 'agora-folio') ?></p>
          </div>
          <div class="alert-actions ml-md-4">
              <a class="btn btn--white btn--lower px-4 my-3" href="<?php echo esc_url( wp_login_url( home_url() ) ) ?>">
                <span class="icon icon--before icon--user" aria-hidden="true"></span>
                <?php esc_html_e( 'Access', 'agora-folio' ) ?>
              </a>
          </div>
      </div>
    </div>
    <a href="#" role="button" class="close" data-dismiss="alert" aria-label="<?php esc_attr_e( 'Close', 'agora-folio' ) ?>">
      <span aria-hidden="true">&times;</span>
    </a>
  </div>
  <?php endif; ?>

  <!-- Footer -->
  <footer id="colophon" class="site-footer ">
    <div class="container">
      <div class="ruler ruler--primary site-info mt-3 mb-5 pt-1 pb-3">
        <?php	printf( esc_html__( 'Universitat Oberta de Catalunya &copy; %s', 'agora-folio' ), date('Y') ); ?>
      </div>
    </div>
  </footer>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
