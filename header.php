<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package AgoraFolio
 */

use AgoraFolio\Assets\AssetResolver;
use AgoraFolio\Data;

$header_img = get_theme_mod('header_image') ? get_theme_mod('header_image') : AssetResolver::resolve( 'images/image-semestre-aula.png' );

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
    <meta name="monitoritzacio" content="nagios7x24">
	<?php wp_head(); ?>

  <?php if( !get_option( 'site_icon' ) ) : ?>
		<link rel="apple-touch-icon" sizes="180x180" href="<?php echo AssetResolver::resolve( 'images/apple-touch-icon.png' ) ?>">
		<link rel="icon" type="image/png" sizes="32x32" href="<?php echo AssetResolver::resolve( 'images/favicon-32x32.png' ) ?>">
		<link rel="icon" type="image/png" sizes="16x16" href="<?php echo AssetResolver::resolve( 'images/favicon-16x16.png' ) ?>">
    <!--[if IE]>
      <link rel="shortcut icon" href="<?php echo AssetResolver::resolve( 'images/favicon.ico' ) ?>">
    <![endif]-->
		<link rel="manifest" href="<?php echo get_stylesheet_directory_uri() ?>/site.webmanifest">
	<?php endif; ?>
</head>

<body <?php body_class(); ?>>
<?php
if ( function_exists( 'wp_body_open' ) ) {
	wp_body_open();
}
?>
<div id="page" class="site">

  <a href="#content" class="skip-link sr-only sr-only-focusable"><?php esc_html_e( 'Skip to content', 'agora-folio' ); ?></a>

  <header id="masthead" role="banner" class="site-header">

    <div class="container">

      <div class="header brand-header-light">

        <div class="header-container clearfix">
          <div class="row">
            <div class="col-md-8 col-lg-9">
              <span class="top-logo">
                  <?php
                  if( has_custom_logo() ) :
                    the_custom_logo();
                  else :
                  ?>
                    <span class="icon icon-svg icon-svg--agora" aria-hidden="true"></span>
                    <span class="icon-alt">Logo Ágora</span>
                    <?php /*<img src="<?php echo AssetResolver::resolve( 'images/logo-uoc-default.png' ) ?>" alt="Logo UOC" /> */ ?>
                  <?php endif; ?>
              </span>
              <div class="top-title-wrapper ruler ruler--secondary">
                <?php
                if ( is_front_page() && is_home() ) : ?>
                  <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                <?php else : ?>
                  <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
                <?php
                endif;
                /*$site_description = get_bloginfo( 'description', 'display' );
                if (function_exists('uoc_create_site_is_classroom_blog') ) {
                  $classroomId = uoc_create_site_is_classroom_blog();
                  if ($classroomId) {
                    $site_description = Data\get_semester();
                  }
                }
                if ( $site_description || is_customize_preview() ) :
				        ?>
				          <p class="site-description"><?php echo $site_description; ?></p>
			          <?php endif;*/ ?>
              </div>

              <button class="btn btn-menu-toggle collapsed" type="button" data-toggle="collapse" data-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Menu">
                  <span class="icon icon-menu-toggle" aria-hidden="true"></span>
              </button>

            </div>

            <div class="col-md-4 col-lg-3 hidden-xs hidden-sm">
              <div class="top-featured ruler ruler--secondary">
                <div class="top-featured-img <?php echo is_user_logged_in() ? 'logged-in' : 'not-logged-in' ?>" style="background-image: url('<?php echo $header_img; ?>');" ></div>
                <?php /*echo '<p class="h5 font-weight-bold mb-0">' . Data\get_semester() . '<br />' . Data\get_classroom() . '</p>';^*/ ?>
                <?php 
                 if (is_user_logged_in()){
                  echo '<a href="' . Data\get_folio_url() . '" class="cta-folio" target="_blank">'. __( 'My folio', 'agora-folio' ) .'<span class="icon icon--normal icon--after icon--external-link" aria-hidden="true"></span><span class="icon-alt">'. __( '(opens in new window)', 'agora-folio' ) .'</span></a>';
                } 
                ?>
              </div>
            </div>

          </div>
        </div>

      </div>

    </div>

  </header><!-- .site-header -->

  <nav id="menu" class="site-menu collapse" role="navigation" aria-label="<?php esc_html_e( 'Main Menu', 'agora-folio' ); ?>">
      <div class="container">
        <?php
          wp_nav_menu( array(
            'theme_location'    => 'primary-menu',
            'depth'             => 2, // 1 = no dropdowns, 2 = with dropdowns.
            'container'         => 'div',
            'container_class'   => 'navbar',
            'container_id'      => 'primary-menu',
            'menu_class'        => 'navbar-nav nav',
            'fallback_cb'       => 'AgoraFolio\Nav\WP_Bootstrap_Navwalker::fallback',
            'walker'            => new AgoraFolio\Nav\WP_Bootstrap_Navwalker(),
          ) );
				?>
      </div>
  </nav><!-- .site-menu -->

  <div id="site-container" class="site-container">

    <div class="container">

      <div class="top-featured px-3 py-2 mt-2 visible-xs visible-sm">
          <div class="top-featured-img <?php echo is_user_logged_in() ? 'logged-in' : 'not-logged-in' ?>" style="background-image: url('<?php echo $header_img; ?>');" ></div>
          <?php /*echo '<p class="h5 font-weight-bold mb-0">' . Data\get_semester() . '<br />' . Data\get_classroom() . '</p>';^*/ ?>
          <?php 
            if (is_user_logged_in()){
              echo '<a href="' . Data\get_folio_url() . '" class="cta-folio" target="_blank">'. __( 'My folio', 'agora-folio' ) .'<span class="icon icon--normal icon--after icon--external-link" aria-hidden="true"></span><span class="icon-alt">'. __( '(opens in new window)', 'agora-folio' ) .'</span></a>';
            } 
          ?>
      </div>

      <div class="site-content mb-3">
        <a class="anchor" name="content"></a>
