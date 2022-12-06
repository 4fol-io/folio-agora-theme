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
	}
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(['view-col', $status]); ?>>

	<div class="entry-article">
	
		<header class="entry-header d-sm-flex ruler  <?php echo $ruler ?>">

			<?php Templates\post_thumbnail('large'); ?>

			<div class="entry-summary d-flex flex-column">

				<div class="entry-summary-wrap d-flex">

					<div class="entry-summary-head">

						<?php
						the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" class="btnlink" rel="bookmark">', '</a></h2>' );

						if ( 'post' === get_post_type() ) :
						?>
						<div class="mb-2 entry-meta">
						<?php
						Templates\posted_by();
						?>
						</div>
						<?php endif; ?>

					</div><!-- .entry-summary-head -->

					<?php  if ( 'post' === get_post_type() ) : ?>
					<div class="mb-2 entry-actions d-flex align-items-start mb-md-3">
						<?php Templates\comments_link(); ?>
						<?php Templates\author_links(); ?>
						<?php Templates\evaluation_link($role, $status_act); ?>
					</div>
					<?php endif; ?>

				</div><!-- .entry-summary-wrap -->
				

				<div class="entry-excerpt excerpt-long flex-fill">
					<div class="mb-3"><?php echo Utils\get_excerpt(48); ?></div>
				</div>

				<div class="entry-meta d-flex align-items-end <?php echo 'post' === get_post_type() ? 'justify-content-between' : 'justify-content-end' ?>">
					<?php if ( 'post' === get_post_type() ) : Templates\posted_on(); endif; ?>
					<?php Templates\visibility(); ?>
				</div>

			</div><!-- .entry-summary -->

		</header><!-- .entry-header -->

	</div>

</article><!-- #post-<?php the_ID(); ?> -->
