<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package AgoraFolio
 */

Use AgoraFolio\Templates;

get_header();

?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		while ( have_posts() ) :
			the_post();
			get_template_part( 'template-parts/content', 'navbar' );
			?>

			<div class="navigation-mobile visible-xs visible-sm">
				<?php Templates\post_navigation_mobile(); ?>
			</div>

			<div id="agora-view" class="agora-view" data-view="single">

				<?php get_template_part( 'template-parts/content', 'single' ); ?>

			</div><!-- .agora-view -->

			<div class="navigation-desktop hidden-xs hidden-sm">
				<?php Templates\post_navigation(); ?>
			</div>

			<?php

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
