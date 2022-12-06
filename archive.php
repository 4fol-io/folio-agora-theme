<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package AgoraFolio
 */

Use AgoraFolio\Pagination;
Use AgoraFolio\Data;
Use AgoraFolio\Templates;

get_header();

if( AGORA_FOLIO_LIST_COMMENTS ) {
	global $withcomments;
	$withcomments = 1;
}

$view = Data\get_agora_view();
$term_id = get_queried_object_id();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php get_template_part( 'template-parts/content', 'navbar' ); ?>

		<?php if ( have_posts() ) : ?>

			<?php 
			if( $view == 'tree' ) : 
				$view_cls = 'view-tree';
				$items = Data\get_actifolio_tree_view_menu_items($term_id);
				$col_menu_cls = count($items) > 0 ? 'col-lg-3' : 'col-lg-12';
				$col_view_cls = count($items) > 0 ? 'col-lg-9' : 'col-lg-12';
			?>
				<div class="row d-lg-flex">
					<div class="<?php echo $col_menu_cls ?>">
						<?php Templates\actifolio_tree_view_menu($items) ?>
					</div>
					<div class="<?php echo $col_view_cls ?>">
			<?php
			else:
				$view_cls = 'view-row';
			?>
				<header class="page-header">
					<?php
					the_archive_title( '<h1 class="page-title h2">', '</h1>' );
					//the_archive_description( '<div class="archive-description">', '</div>' );
					?>
				</header><!-- .page-header -->
			<?php
			endif; 
			?>

				<div id="agora-view" class="agora-view <?php echo $view_cls ?>" data-view="<?php echo $view ?>">

				<?php
				if ( $view == 'tree' ) :
				?>
					<ul class="agora-view-tree tree-list list--unstyled" role="presentation">
				<?php
				endif;

				/* Start the Loop */
				while ( have_posts() ) :

					the_post();

					if( $view == 'tree' ){
						/*
						 * Include the tree content template
						 */
						get_template_part( 'template-parts/content', 'tree' );
					}else{
						/*
						* Include the Post-Type-specific template for the content.
						* If you want to override this in a child theme, then include a file
						* called content-___.php (where ___ is the Post Type name) and that will be used instead.
						*/
						get_template_part( 'template-parts/content', get_post_type() );
					}

				endwhile;

				if ( $view == 'tree' ) :
					?>
						</ul>
					<?php
					endif;

				?>

				</div><!-- .agora-view -->

			<?php
			
			if( $view == 'tree' ) : 
				Pagination\pagination();
			?>
					</div>
				</div>
			<?php
			else:
				Pagination\pagination();
			endif; 
			?>

			<div class="hidden-comment-area hidden">
				<?php 
				if( AGORA_FOLIO_LIST_COMMENTS ) {
					add_filter( 'comments_open', '__return_true' );
					Templates\comments_form(); 
					add_filter( 'comments_open', '__return_false' );
				}
				?>
			</div>

			<?php

			if (AGORA_FOLIO_LIST_AJAX):
				Templates\dummy_pdf();
			endif;

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
