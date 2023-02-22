<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package AgoraFolio
 */

use AgoraFolio\Templates;
use AgoraFolio\Utils;
use AgoraFolio\Data;

$ruler = 'ruler--primary';
$status = '';
$status_act = null;

if (get_post_type() === 'post'){	
	$role = Data\uoc_get_current_role();
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
}

ob_start();
Templates\post_thumbnail('large');
$thumbnail = ob_get_contents();
ob_end_clean();

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(['view-col', $status]); ?>>

	<div class="entry-article">
	
		<header class="entry-header d-sm-flex ruler  <?php echo $ruler ?>">

			<?php echo $thumbnail; ?>

			<div class="entry-summary d-flex flex-column <?php echo $thumbnail ? 'with-thumb' : 'no-thumb' ?>">

				<div class="entry-summary-wrap d-flex">

					<div class="entry-summary-head">

					<?php Templates\posted_by_avatar(); ?>

					<div class="entry-summary-head-content">

					<?php
						the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" class="btnlink" rel="bookmark">', '</a></h2>');
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

				</div><!-- .entry-summary-wrap -->
				

				<div class="entry-excerpt excerpt-long flex-fill">
					<div class="mb-3"><?php echo Utils\get_excerpt(48); ?></div>
				</div>

			</div><!-- .entry-summary -->

		</header><!-- .entry-header -->

	</div>

</article><!-- #post-<?php the_ID(); ?> -->
