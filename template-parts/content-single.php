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

ob_start();
Templates\post_thumbnail('large');
$thumbnail = ob_get_contents();
ob_end_clean();

?>

<article id="post-<?php the_ID(); ?>" <?php post_class($status); ?>>

	<div class="entry-article expanded">

		<header class="entry-header d-sm-flex ruler <?php echo $ruler ?>">

			<?php echo $thumbnail; ?>

			<div class="entry-summary d-flex flex-column <?php echo $thumbnail ? 'with-thumb' : 'no-thumb' ?>">

				<div class="entry-summary-wrap d-flex">

					<div class="entry-summary-head">

						<?php Templates\posted_by_avatar(); ?>

						<div class="entry-summary-head-content">

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
						<?php //Templates\comments_link(); ?>
						<?php //Templates\author_links(); ?>
						<?php Templates\evaluation_link($role, $status_act); ?>
					</div>

				</div><!-- .entry-summary-wrap -->

				<?php /*<div class="entry-meta d-flex align-items-end justify-content-between">
					<?php Templates\posted_on(); ?>
					<?php Templates\visibility(); ?>
				</div>*/ ?>

			</div><!-- .entry-summary -->

		</header><!-- .entry-header -->

		<div class="clearfix entry-body ruler ruler--half">
			<?php //do_action( "add_actiuocs" ); // Nota: el plugin portafolis tools ya añade las actioucs al final del content ?>
			<?php the_content(); ?>
			<?php Templates\link_pages(); ?>
		</div>

		<footer class="entry-footer"><?php Templates\entry_footer(); ?></footer><!-- .entry-footer -->

		<?php Templates\evaluation_area($role, $status_act); ?>

		<?php
		// If comments are open or we have at least one comment, load up the comment template.
		//if ( comments_open() || get_comments_number() ) :
			comments_template();
		//endif;
		?>

	</div>

</article><!-- #post-<?php the_ID(); ?> -->
