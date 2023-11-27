<?php
/**
 * AGORA FOLIO functions and definitions
 *
 * @package AgoraFolio
 */

define('AGORA_FOLIO_THEME_VERSION',  '1.0.11');
define('AGORA_FOLIO_DEMO_MODE',      false);  // For DEMO purposes, DISABLE in PRODUCTION
define('AGORA_FOLIO_LIST_COMMENTS',  true);   // Enable comments on lists pages (index, category, archive)
define('AGORA_FOLIO_LIST_AJAX',      false);   // Enable ajax load posts content on lists (index, category, archive)

$agora_includes = array(
  '/clean.php',                           // Clean head, inline styles,...
  '/setup.php',                           // Theme setup and custom theme supports
  '/images.php',                          // Theme image custom utils
  '/assets.php',                          // Assets management
  '/blocks.php',                          // Blocks (alingwide, alignfull) wrapper
  '/data.php',                            // Data access utilities
  '/utils.php',                           // Some general utils, filters, action hooks,...
  '/nav.php',                             // Custom Bootstrap Nav Walker
  '/tree-walker.php',                     // Custom Comment Tree Walker
  '/pagination.php',                      // Custom pagination
  '/templates.php',                       // Custom templates for this theme
  '/customizer.php',                      // Customizer preview
  '/megamenu.php',                        // Megamenu custom theme setup
);

if ( AGORA_FOLIO_DEMO_MODE ) {
	$agora_includes[] = '/demo.php';        // DEMO widgets to emulate Participants and ActiFolio widgets (DISABLE in production)
}

if ( defined( 'JETPACK__VERSION' ) ) {
	$agora_includes[] = '/jetpack.php';     // Load Jetpack compatibility file
}


/**
 * Include theme dependencies
 */
foreach ( $agora_includes as $file ) {
	$filepath = locate_template( '/inc' . $file );
	if ( ! $filepath ) {
		trigger_error( sprintf( 'Error locating /inc%s for inclusion', $file ), E_USER_ERROR );
	}
	require_once $filepath;
}
