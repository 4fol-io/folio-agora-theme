<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package AgoraFolio
 */

use AgoraFolio\Data;
use AgoraFolio\Utils;

require_once dirname(__FILE__) .'/inc/data.php';
require_once dirname(__FILE__) .'/inc/utils.php';

get_header();
?>
	<section class="error-404 not-found-alert align-wrap align-wrap-full" role="banner">
		<div class="alignfull">
			<div class="container">
				<h1 class="not-found-title">
					<span class="visually-hidden">Error </span>4<span class="icon icon--error-server" aria-hidden="true"></span><span class="visually-hidden">0</span>4
				</h1>
			</div>
		</div>
	</section>
	<section class="error-404 not-found">
		<div class="container container--expand">
			<div class="col-sm-7 col-sm-offset-5 col-md-6 col-md-offset-6 col-lg-5 col-lg-offset-7">
				<!--
				<h2 class="h1 h1--large"><?php _e( 'Oops!', 'agora-folio' ); ?></h2>
				<h3 class="h5 h5--large"><?php _e( 'Page not found', 'agora-folio' ); ?></h3>
				<h4 class="h5 h5--large"><?php _e( 'What can you do?', 'agora-folio' ); ?></h3>
				<a href="<?php echo Data\get_folio_url(); ?>" class="btn btn--call-to-action btn--block m-bottom-5y"><?php _e( 'Visit the Folio Learning Space', 'agora-folio' ); ?></a>
				-->
				 <?php
					$pots_status = false;
					$url         = $_SERVER['REQUEST_URI'];
					$slug        = basename( $url );
					$post        = get_page_by_path( $slug, OBJECT, 'post' );
					if ( $post ) {
						$post_id      = $post->ID;
						$post_type    = $post->post_type;
						$pots_status  = $post->post_status;
						$meta_accesss = get_post_meta( $post_id, PORTAFOLIS_UOC_META_KEY, true );
					}
					/**
						1) 404 pagina no existe
						2) Contenido sólo disponible para miembros del campus / Si eres usuario/a de Folio haz login aquí para ver el contenido. 
						3) Contenido sólo visible si formas parte de esta asignatura / Si eres compañero/a de aula o profesorado, accede aquí  (login)
						4) Contenido sólo visible para profesorado. / Si eres parte del profesorado de esta actividad, accede aquí  (login)
						5) Contenido privado, sólo visible para los autores de este post. / Si eres el/la autor/a accede aquí.
					**/
				 $current_page_link = Utils\get_current_page_link();
				 if ( 'private' === $pots_status && $meta_accesss ) {


					 switch ( $meta_accesss ) {
						 case PORTAFOLIS_UOC_ACCESS_UOC:
							 $sentence1 = __( 'Content available to the UOC community', 'agora-folio' );
							 $sentence2 = sprintf( __( 'This page has publications that are only visible to members of the UOC community. To view the content, log in with your %1$sCampus user%2$s.',
								 'agora-folio' ), '<a href="' . wp_login_url( $current_page_link ) . '">', '</a>' );
							 break;
						 case PORTAFOLIS_UOC_ACCESS_SUBJECT:
							 $sentence1 = __( 'Content available for classmates',
								 'agora-folio' );
							 if (!is_user_logged_in()) {
								 $sentence2 = sprintf( __( 'This page has publications that are only visible to classmates in this subject. If you are part of it and want to see the content, log in with %1$syour Campus user%2$s.',
									 'agora-folio' ), '<a href="' . wp_login_url( $current_page_link ) . '">',
									 '</a>' );
							 } else {
								 $sentence2  = __('This page has publications that are only visible to classmates in this subject.', 'agora-folio');
							 }
							 break;
						 case PORTAFOLIS_UOC_ACCESS_MY_TEACHERS:
							 $sentence1 = __( 'Content available for teachers of the subject', 'agora-folio' );
							 if (!is_user_logged_in()) {
								 $sentence2 = sprintf( __( 'This page has publications that are only visible to the teachers of the subject. If you are a teacher and want to see the content, log in with your %1$sCampus user%2$s.',
									 'agora-folio' ), '<a href="' . wp_login_url( $current_page_link ) . '">',
									 '</a>' );
							 } else {
								 $sentence2  = __('This page has publications that are only visible to the teachers of the subject.', 'agora-folio');
							 }
							 break;
						 case PORTAFOLIS_UOC_ACCESS_PRIVATE:
							 $sentence1 = __( 'Content available from the author of the publication',
								 'agora-folio' );
							 if (!is_user_logged_in()) {
								 $sentence2 = sprintf( __( 'This page has posts that are only visible to the person who created the content. If you are the author, log in with your %1$sFolio user%2$s.',
									 'agora-folio' ), '<a href="' . wp_login_url( $current_page_link ) . '">', '</a>' );
							 } else {
								 $sentence2  = __('This page has posts that are only visible to the person who created the content.', 'agora-folio');
							 }
							 break;
					 }
					 $gotohomepage = sprintf( __( 'Do you want to go to the %1$shomepage%2$s?',
						 'agora-folio' ), '<a href="' . home_url(  ) . '">', '</a>' );

					 echo '<h2 class="h1 h1--large">' . $sentence1 . '</h2>';
					 echo '<h3 class="h5 h5--large">' . $sentence2 . '</h3>';
					 echo '<h3 class="h5 h5--large">' . $gotohomepage . '</h3>';
				 } else {
					 ?>
                     <h2 class="h1 h1--large"><?php _e( 'Page not found', 'agora-folio' ); ?></h2>
					 <?php
				 $str = sprintf( __( 'The page you are looking for does not exist. Do you want to go to the %1$shomepage%2$s?',
					 'agora-folio' ), '<a href="' . home_url(  ) . '">', '</a>' )
					 ?>
                     <h3 class="h5 h5--large"><?php echo $str ?></h3>
					 <?php if (! is_user_logged_in() ) {
						 $str = sprintf( __( 'If you have Folio, we recommend that you log in %1$swith your user%2$s.',
							 'agora-folio' ), '<a href="' . wp_login_url( $current_page_link ) . '">', '</a>' )
						 ?>
                         <h4 class="h5 h5--large"><?php echo $str; ?></h4>
					 <?php }
				 }
				?>
			</div>
		</div>
	</section>

<?php
get_footer();
