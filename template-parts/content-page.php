<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package AgoraFolio
 */

use AgoraFolio\Templates;

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-article expanded">

		<header class="page-header entry-header d-sm-flex ruler ruler--primary">

			<?php Templates\post_thumbnail('large'); ?>

			<div class="entry-summary d-flex flex-column">

				<div class="entry-summary-wrap d-flex">

					<div class="entry-summary-head">

						<?php echo the_title( '<h1 class="page-title h2">', '</h1>', false ); ?>

					</div><!-- .entry-summary-head -->

				</div><!-- .entry-summary-wrap -->

				<div class="entry-meta mb-2">
					<?php Templates\visibility_inline(); ?> - <?php Templates\posted_on('human'); ?>
				</div>

			</div><!-- .entry-summary -->

		</header><!-- .entry-header -->

		<div class="entry-body clearfix ruler ruler--half">
			<?php the_content(); ?>
			<?php Templates\link_pages(); ?>
		</div><!-- .entry-body -->

		<footer class="entry-footer"><?php Templates\edit_link(); ?></footer><!-- .entry-footer -->

	</div>
	
</article><!-- #post-<?php the_ID(); ?> -->
