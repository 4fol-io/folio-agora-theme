<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package AgoraFolio
 */

Use AgoraFolio\Pagination;

get_header();
?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php get_template_part( 'template-parts/content', 'navbar' ); ?>

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title h2">
					<?php
					/* translators: %s: search query. */
					printf( esc_html__('%1$s results were found for: %2$s', 'agora-folio'), $wp_query->found_posts , '<em class="search-term">#'.get_search_query().'</em>' );
					?>
				</h1>
			</header><!-- .page-header -->

			<div id="agora-view" class="view-row agora-view" data-view="list">

			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'search' );

			endwhile;

			?>

			</div><!-- .agora-view -->

			<?php

			//the_posts_navigation();
			Pagination\pagination();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
