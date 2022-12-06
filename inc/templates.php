<?php
/**
 * Agora Folio templates utilities
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package AgoraFolio
 */

namespace AgoraFolio\Templates;

use AgoraFolio\Assets\AssetResolver;
use AgoraFolio\Data;
use AgoraFolio\Images;


// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


/**
 * Prints page links for paginated posts (i.e. including the <!--nextpage--> quicktag)
 */
function link_pages() {
	wp_link_pages( array(
		'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'agora-folio' ),
		'after'  => '</div>',
	) );
}


/**
 * Print the customized post navigation for desktop
 */
function post_navigation() {
	the_post_navigation( array(
		'prev_text' => '<span class="visually-hidden">' . __( 'Previous Post',
				'agora-folio' ) . '</span><span class="btnlink"><span aria-hidden="true" class="icon icon--arrow-left icon--xsmall icon--before"></span>%title</span>',
		'next_text' => '<span class="visually-hidden">' . __( 'Next Post',
				'agora-folio' ) . '</span><span class="btnlink">%title<span aria-hidden="true" class="icon icon--arrow-right icon--xsmall icon--after"></span></span>',
	) );
}

/**
 * Print the customized post navigation for mobile and tablet devices
 */
function post_navigation_mobile() {
	the_post_navigation( array(
		'prev_text' => '<span class="btnlink"><span aria-hidden="true" class="icon icon--arrow-left icon--xsmall icon--before"></span>' . __( 'Previous',
				'agora-folio' ) . '<span class="visually-hidden">: %title</span></span>',
		'next_text' => '<span class="btnlink">' . __( 'Next',
				'agora-folio' ) . '<span class="visually-hidden">: %title</span><span aria-hidden="true" class="icon icon--arrow-right icon--xsmall icon--after"></span></span>',
	) );
}

/**
 * Comments link button
 */
function comments_link() {
	if ( /*! is_single() && */ ! post_password_required() && ( comments_open() || get_comments_number() ) ) {

		$num     = number_format_i18n( get_comments_number() );
		$cls     = $num > 0 ? "btn btn--lower btn--primary btn--debate" : "btn btn--lower btn--secondary btn--debate no-comments";
		$allowed = array(
			'span' => array(
				'class' => array(),
			)
		);

		$debate = '<span class="sr-only-sm">' . __( 'Debate', 'agora-folio' ) . '</span>';
		$debate .= '<span class="icon icon--after icon--before icon-svg icon-svg--debate" aria-hidden="true"></span>';
		$debate .= '<span class="icon-alt" aria-hidden="true">%2$s </span>%3$s';
		/* translators: %1$s: post title */
		$debate .= '<span class="visually-hidden">' . __( 'on %1$s', 'agora-folio' ) . '</span>';

		comments_popup_link(
			sprintf( wp_kses( $debate, $allowed ), get_the_title(), __( 'contributions' ),
				'<span class="num zero">' . $num . '</span>' ),
			sprintf( wp_kses( $debate, $allowed ), get_the_title(), __( 'contribution' ),
				'<span class="num">' . $num . '</span>' ),
			sprintf( wp_kses( $debate, $allowed ), get_the_title(), __( 'contributions' ),
				'<span class="num">' . $num . '</span>' ),
			$cls
		);

	}
}


/**
 * Comments link button
 */
function comments_link_inline() {
	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {

		$num     = number_format_i18n( get_comments_number() );
		$cls     = $num > 0 ? "has-comments" : "no-comments";
		
		comments_popup_link(
			sprintf(
				wp_kses(
					/* translators: %s: post title */
					__( 'Debate', 'agora-folio' ) . '<span class="sr-only"> ' . __( 'on %1$s', 'agora-folio' ) .'</span>',
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			)
		);

	}
}


/**
 * Contact link button
 */
function contact_link( &$user ) {
	if ( ! $user ) {
		$id   = get_the_author_meta( "ID" );
		$user = get_user_by( "ID", $id );
	}
	if ( ! $user ) {
		return;
	}
	$session                                = get_folio_campus_session();
	$url_to_send_email                      = 'https://api.uoc.edu/adalogin/mailto/to/' . urldecode( $user->user_email ) . '?s=' . $session;
	$extra_js = get_folio_contact_extra_js_alert($session);
	?>
    <a class="btnlink btnlink--regular btn--contact" href="<?php echo $url_to_send_email ?>" target="_blank"
       title="<?php esc_attr_e( "Send message to author", "agora-folio" ) ?>" <?php echo $extra_js ?>>
        <span class="icon icon--small icon--send-mail" aria-hidden="true"></span>
        <span class="icon-alt"><?php echo __( "Send message to author", "agora-folio" ); ?></span>
    </a>
	<?php
}


function get_folio_contact_extra_js_alert($session) {
	if (empty($session)){
		return 'onclick="alert(\''.__('You have to reauthenticate, will open in a new window, after that you can refresh current window', 'portafolis-uoc-access').'\'); return true;"';
	}
	return '';
}

function get_folio_campus_session() {
	$session = '';
	global $openIDUOC;
	if ( $openIDUOC ) {
		$uocApi = $openIDUOC->getUocAPI();
		$session = $uocApi->getCampusSession( get_current_user_id() );
		if (!$session) {
			$session = '';
		}
	}
	if (empty($session)) {
		$openid_connect_generic_last_user_claim = get_user_meta( get_current_user_id(),
			'openid-connect-generic-last-user-claim', true );
		$session                                = isset( $openid_connect_generic_last_user_claim['sessionId'] ) ? $openid_connect_generic_last_user_claim['sessionId'] : '';
	}
	return $session;
}


/**
 * Lint to author folio page
 */
function author_folio_link( &$user ) {
	if ( ! $user ) {
		$id   = get_the_author_meta( "ID" );
		$user = get_user_by( "ID", $id );
	}
	if ( ! $user ) {
		return;
	}
	$student_url = str_replace( 'https://', 'https://' . str_replace( '_', '-', $user->user_login ) . '.',
		network_site_url( '' ) );
	$visit_with  = sprintf( __( "Visit %s's Folio", "agora-folio" ), $user->display_name );
	?>
    <a class="btnlink btnlink--regular btn--folio" href="<?php echo $student_url ?>" target="_blank"
       title="<?php esc_attr_e( $visit_with ) ?>" aria-label="<?php esc_attr_e( $visit_with ) ?>">
        <span class="icon icon--small icon-svg icon-svg--folio" aria-hidden="true"></span>
        <span class="icon-alt"><?php echo __( 'Visit Folio', 'agora-folio' ); ?> <?php echo __('(opens in new window)', 'agora-folio' ) ?></span>
    </a>
	<?php
}

/**
 * Lint to author folio page
 */
function author_links() {
	$id   = get_the_author_meta( "ID" );
	$user = get_user_by( "ID", $id );
	if ( ! $user ) {
		return;
	}
	?>
    <div class="entry-author-links">
		<?php contact_link( $user ); ?>
		<?php author_folio_link( $user ); ?>
    </div>
	<?php
}


/**
 * Evaluation link
 * TODO: review for production
 */
function evaluation_link( $role, $status_act ) {

	if ( $role !== '' ) {
		$status = $status_act['status'];
	}

	if ( ! empty( $status ) ) :

		$grade = '-';
		$eval_link_toggle = get_permalink() . '#evaluation';

		if ( $status == 'sent' ) {
			$grade = $status_act['activity']->grade;
		}

		if ( $role === 'teacher' ) :
			if ( $status === 'pending' ) {
				$lbl = __( 'Evaluable', 'agora-folio' );
			} else {
				$lbl = __( 'Evaluated', 'agora-folio' );
			}
			?>
            <a href="<?php echo $eval_link_toggle; ?>"
               class="btn btn--lower btn--secondary-alt btn--evaluable <?php echo $status ?>" id="btn-evaluable-<?php the_ID(); ?>">
                <span class="lbl sr-only-sm"><?php echo $lbl; ?></span>
                <span class="icon icon--before icon--after icon-svg icon-svg--evaluable" aria-hidden="true"></span>
                <span class="grade"><?php echo $grade; ?></span>
            </a>
		<?php else: // role = 'student' ???
			if ( $status === 'pending' ) {
				?>
                <a href="<?php echo $eval_link_toggle; ?>"
                   class="btn btn--lower alert--warning-alternative btn--evaluable <?php echo $status ?>"
                   title="<?php esc_attr_e( 'Pending evaluation', 'agora-folio' ) ?>"
                   aria-label="<?php esc_attr_e( 'Pending evaluation', 'agora-folio' ) ?>">
                    <span class="lbl sr-only-sm"><?php echo __( 'Evaluation', 'agora-folio' ) ?></span>
                    <span class="icon icon--after icon--clock-full" aria-hidden="true"></span>
                    <span class="icon-alt"><?php echo __( 'Pending', 'agora-folio' ) ?></span>
                </a>
			<?php } else { ?>
                <a href="<?php echo $eval_link_toggle; ?>"
                   class="btn btn--lower btn--secondary-alt btn--evaluable <?php echo $status ?>">
                    <span class="grade"><span class="lbl sr-only-sm"><?php echo __( 'Grade','agora-folio' ) ?>: </span><?php echo $grade; ?></span>
                </a>
			<?php }
		endif; // if ($role === 'teacher')
		?>

	<?php endif; //if (!empty($status))
}


/**
 * Evaluation area
 */
function evaluation_area( $role, $status_act ) {

	if ( $role !== '' ) {
		$status = $status_act['status'];
	}

	if ( ! empty( $status ) ) :
		$user_id = get_the_author_meta( "ID" );
		$user = get_user_by( "ID", $user_id );
		$user_avatar = $user_id ? get_avatar( $user_id, 70 ) : '<span class="avatar"></span>';

		$content    = '';
		$public_url = '#';
		$grade      = '-';
		$lbl        = __( 'Evaluation Pending', 'agora-folio' );
		$tip		= __( 'Evaluate inside the Agora to leave comments and notes. If you want to attach PDFs, videos or high quality files, please open the Evaluate option in the RAC', 'agora-folio');

		if ( $status == 'sent' ) {
			$lbl        = __( 'Evaluated', 'agora-folio' );
			$content    = $status_act['activity']->feedback;
			$public_url = $status_act['activity']->public_url;
			$grade      = $status_act['activity']->grade;
		}

		$anchor_name = is_single() || is_page() ? 'evaluation' : 'evaluation_' . get_the_ID();

		$acc_id = 'acc-evaluation-' . get_the_ID();
		$read_area_id = 'read-evaluation-' . get_the_ID();
		$edit_area_id = 'edit-evaluation-' . get_the_ID();

		$acc_class = 'accordion';
		$read_class ='collapse show';

		$eval_link_rac = Data\get_rac_evaluation_url();
		$eval_link_agora =  get_permalink() . '#evaluation';
		$eval_link_rac_attrs = 'target="_blank"';
		$eval_link_agora_attrs = 'role="button" data-toggle="collapse" data-target="#' . $edit_area_id . '" aria-controls="' . $edit_area_id . '" aria-expanded="false"';
		?>
		<div class="evaluation-area" tabindex="-1">

			<a class="anchor" name="<?php echo $anchor_name; ?>"></a>

			<h2 class="pb-2 mb-0 h5 evaluation-title ruler ruler--primary ruler--bottom">
				<span class="status evaluation-status-<?php the_ID() ?>"><?php echo $lbl ?></span>
			</h2>

			<div class="evaluation-box p-3 <?php echo $status; ?>">

				<?php if ( $role === 'teacher' ) :
					$submissonId = $status_act['submissonId'];
				?>

					<div class="d-lg-flex justify-content-between <?php echo $acc_class ?>" id="<?php echo $acc_id; ?>">

						<?php if ( $user ): ?>
							<div class="student mr-4 mb-4 mb-lg-2 mr-lg-5">
								<div class="student-profile d-flex align-items-center justify-content-between">
									<?php echo $user_avatar; ?>
									<div class="fn"><?php echo $user->display_name; ?></div>
								</div>
							</div>
						<?php endif; ?>

						<div class="flex-fill">

							<div id="<?php echo $read_area_id; ?>" class="read-evaluation <?php echo $read_class; ?>" data-parent="#<?php echo $acc_id; ?>">

								<?php
								if ( $status === 'pending' ) {
								?>
									<div class="note">
										<span class="icon icon--before icon--clock-full icon--small" aria-hidden="true"></span>
										<p class="mb-0"><?php _e( 'The user is not evaluated', 'agora-folio' ) ?></p>
									</div>
									<div class="my-3">
										<a href="<?php echo $eval_link_agora; ?>" class="btn btn--lower btn--primary btn--evaluate btn--evaluate-agora mr-2" <?php echo $eval_link_agora_attrs; ?>>
											<?php _e( 'Evaluate here', "agora-folio" ); ?>
											<span class="icon icon--after icon-svg icon-svg--evaluable" aria-hidden="true"></span>
										</a>
										<a href="<?php echo $eval_link_rac; ?>" class="btn btn--lower btn--primary btn--evaluate btn--evaluate-rac mr-2" <?php echo $eval_link_rac_attrs; ?>>
											<?php _e( 'Evaluate in RAC', "agora-folio" ); ?>
											<span class="icon icon--after icon--external-link" aria-hidden="true"></span>
											<span class="icon-alt"><?php _e( '(opens in new window)', 'agora-folio' ) ?></span>
										</a>
										<button type="button" class="btn--unstyled btn--infotip" aria-label="Info" title="<?php echo esc_attr($tip); ?>" data-toggle="tooltip" data-trigger="hover focus" data-container="body">
											<span class="icon icon--info-full icon--normal" aria-hidden="true"></span>
										</button>
									</div>
								<?php } else { ?>
									<div class="grade">
										<div class="grade-grade h5"><strong><?php _e( 'Grade', 'agora-folio' ) ?>: </span><?php echo $grade; ?></strong></div>
										<div class="comment-grade mb-3">
											<?php echo $content; ?>
										</div>
										<div class="mb-3">
											<a href="<?php echo $eval_link_agora; ?>" class="btn btn--lower btn--primary btn--evaluate btn--evaluate-agora mr-2" <?php echo $eval_link_agora_attrs; ?>>
												<?php _e( 'Modify evaluation here', "agora-folio" ); ?>
												<span class="icon icon--after icon-svg icon-svg--evaluable" aria-hidden="true"></span>
											</a>
											<a href="<?php echo $eval_link_rac; ?>" class="btn btn--lower btn--primary btn--evaluate btn--evaluate-rac mr-2" <?php echo $eval_link_rac_attrs; ?>>
												<?php _e( 'Modify evaluation in RAC', "agora-folio" ); ?>
												<span class="icon icon--after icon--external-link" aria-hidden="true"></span>
												<span class="icon-alt"><?php _e( '(opens in new window)', 'agora-folio' ) ?></span>
											</a>
											<button type="button" class="btn--unstyled btn--infotip" aria-label="Info" title="<?php echo esc_attr ($tip); ?>" data-toggle="tooltip" data-trigger="hover focus" data-container="body">
												<span class="icon icon--info-full icon--normal" aria-hidden="true"></span>
											</button>
										</div>
									</div>
								<?php } ?>

							</div><!-- /.read-area -->

							<div id="<?php echo $edit_area_id; ?>" class="edit-evaluation collapse" data-parent="#<?php echo $acc_id; ?>">

									<div id="result-uoc-rac-box-<?php the_ID() ?>" class="alert mt-n2 mb-3" role="alert"
										aria-live="polite" tabindex="-1" style="display:none;"></div>
									
									<div class="loading evaluation-loading"><?php _e( 'Loading information', "agora-folio" ) ?></div>

									<div class="teacher-evaluation-box" data-id="<?php the_ID(); ?>"
										data-activityid="<?php echo $submissonId; ?>" style="display:none;">

										<fieldset class="form-group form-inline-radio">

											<legend><?php echo __( "Choose a grade", "agora-folio" ); ?></legend>

											<div class="grades-box">

												<?php
												$gradesAvailable = [ 'A', 'B', 'C+', 'C-', 'D', 'N' ];
												foreach ( $gradesAvailable as $gradeAvailable ) { ?>
												<label for="radio-options-inline-grade-<?php echo str_replace( '+', 'plus', $gradeAvailable ) ?>-<?php the_ID(); ?>"
														class="<?php echo $grade == $gradeAvailable ? 'selected-grade' : '' ?> label-grade-select-<?php the_ID(); ?>">
													<input type="radio"
															class="radio-grade-select radio-options-inline-grade-<?php the_ID(); ?>"
															data-id="<?php the_ID(); ?>"
															name="radio-options-inline-grade-<?php the_ID(); ?>"
															id="radio-options-inline-grade-<?php echo str_replace( '+',
															'plus', $gradeAvailable ) ?>-<?php the_ID(); ?>"
															value="<?php echo $gradeAvailable ?>"
															role="radio" <?php echo $grade == $gradeAvailable ? 'checked' : '' ?>>
													<span class="lbl"><?php echo $gradeAvailable ?></span>
												</label>
												<?php
												}
												?>

												<a href="#" role="button" class="btn btn-delete-grade" data-id="<?php the_ID() ?>">
													<span class="icon icon--delete-note" aria-hidden="true"></span>
													<span class="icon-alt"><?php echo __( "Delete grade", "agora-folio" ); ?></span>
												</a>

											</div>

										</fieldset>

										<fieldset class="form-group">

											<legend><?php echo __( "Write a comment: ", "agora-folio" ); ?></legend>

											<?php
											$editor_id       = 'evaluation-textarea-' . get_the_ID();
											$editor_settings = array(
												'media_buttons' => false,
												'quicktags'     => true,
												'editor_height' => 225,
												'tinymce'       => array(
												'plugins'     => 'charmap hr lists link wplink tabfocus textcolor fullscreen wordpress wpautoresize wptextpattern',
												'toolbar1'    => 'formatselect | bold,italic,underline,strikethrough | bullist,numlist,blockquote,hr | alignleft,aligncenter,alignright,alignjustify | link | cut paste copy undo,redo',
												'toolbar2'    => '',
												'toolbar3'    => '',
												'toolbar4'    => '',
												'statusbar'   => true,
												'elementpath' => false,
												'content_css' => AssetResolver::resolve( 'css/editor-styles.css' )
												)
											);
											wp_editor( $content, $editor_id, $editor_settings );
											//wp_editor( $content, $editor_id );
											?>

										</fieldset>

										<fieldset class="form-group form-inline-radio">

											<legend><?php echo __( 'Publish options:', 'agora-folio' ) ?></legend>

											<label class="publish-options"
												for="publish-grade-radio-<?php the_ID() ?>-scheduled">
												<input type="radio" id="publish-grade-radio-<?php the_ID() ?>-scheduled"
													class="publish-grade-radio publish-grade-radio-<?php the_ID() ?>"
													name="publish-grade-radio-<?php the_ID() ?>" data-id="<?php the_ID() ?>"
													value="scheduled" checked>
												<span aria-hidden="true" class="icon icon--radio-button-off icon--small"></span>
																	<?php echo __( 'Scheduled', 'agora-folio' ) ?>
											</label>
											<label class="publish-options" for="publish-grade-radio-<?php the_ID() ?>-now">
												<input type="radio" id="publish-grade-radio-<?php the_ID() ?>-now"
													class="publish-grade-radio publish-grade-radio-<?php the_ID() ?>"
													name="publish-grade-radio-<?php the_ID() ?>" data-id="<?php the_ID() ?>"
													value="now">
												<span aria-hidden="true" class="icon icon--radio-button-off icon--small"></span>
																	<?php echo __( 'Now', 'agora-folio' ) ?>
											</label>

										</fieldset>

										<button class="publish-grade btn btn--primary publish-grade-submit px-5"
											id="publish-grade-submit-<?php the_ID() ?>" data-id="<?php the_ID() ?>"
											data-submissionid="<?php echo $submissonId ?>">
											<?php echo __( "Publish", "agora-folio" ); ?>
										</button>

										<div class="note" id="info_program_publish_grade_<?php the_ID() ?>">
											<span class="icon icon--before icon--info-full icon--small"
												aria-hidden="true"></span>
											<strong><?php echo __( "The student won't see the grade nor the comment until the date of publishing grades.", "agora-folio" ); ?></strong>
											<?php echo __( "Meanwhile you will be able to edit both the grade and the comment.", "agora-folio" ); ?>
										</div>

										<div class="note" id="info_publish_grade_now_<?php the_ID() ?>" style="display:none;">
											<span class="icon icon--before icon--info-full icon--small"
												aria-hidden="true"></span>
											<strong><?php echo __( "The student will see the grade and the comment as soon you save it.", "agora-folio" ); ?></strong>
										</div>

									</div>

							</div><!-- /.edit-area -->

						</div>

					</div>

				<?php
					else: // role='student'
				?>
					<div class="student-evaluation-box">
						<div class="d-lg-flex justify-content-between">

						<?php if ( $user ): ?>
							<div class="student mr-4 mb-4 mb-lg-2 mr-lg-5">
								<div class="student-profile d-flex align-items-center justify-content-between">
									<?php echo $user_avatar ?>
									<div class="fn"><?php echo $user->first_name . " " . $user->last_name; ?></div>
								</div>
							</div>
						<?php endif; ?>

							<div class="read-evaluation flex-fill">

							<?php
								if ( $status === 'pending' ) {
							?>
								<div class="note">
									<span class="icon icon--before icon--clock-full icon--small" aria-hidden="true"></span>
									<p class="mb-0"><?php echo __( 'Evaluation in process.', 'agora-folio' ) ?></p>
								</div>
							<?php } else { ?>
								<div class="grade">
									<div class="grade-grade h5"><strong><?php echo __( 'Grade', 'agora-folio' ) ?>: </span><?php echo $grade; ?></strong></div>
									<div class="comment-grade mb-3">
										<?php echo $content; ?>
									</div>
									<div class="mb-3">
										<a class="btn btn--lower btn--primary" href="<?php echo $public_url ?>" target="_blank">
											<?php echo __( 'View assessed delivery', 'agora-folio' ) ?>
											<span class="icon icon--after icon--external-link" aria-hidden="true"></span>
											<span class="icon-alt"><?php echo __( '(opens in new window)', 'agora-folio' ) ?></span>
										</a>
									</div>
								</div>
							<?php } ?>

							</div>

						</div>
					</div>
				<?php
				endif; // if ($role === 'teacher')
				?>

			</div><!-- /.evaluation-box -->
		</div><!-- /evaluation-area -->
	<?php endif; //if (!empty($status))
}


/**
 * Agora visibility

 */
function visibility() {
	$visibility = class_exists('PortafolisUocAccess') ? \PortafolisUocAccess::get_post_visibility(get_the_ID()) : '';
	$help = class_exists('PortafolisUocAccess') ? \PortafolisUocAccess::return_help_information_state($visibility) : '';
	switch ( $visibility ) {
		case PORTAFOLIS_UOC_ACCESS_UOC:
			?>
            <span class="visibility post-visibility"><span class="sr-only"><?php _e('Visibility:', 'portafolis-uoc-access') ?> </span><strong><?php _e( 'Campus', 'portafolis-uoc-access' ) ?></strong> <img
                        src="<?php echo site_url()?>/wp-content/plugins/portafolis-uoc-access/img/uoc.png"
                        class="visibility-icon"
                        title="<?php echo $help?>"></span>
			<?php
			break;
		case PORTAFOLIS_UOC_ACCESS_SUBJECT:
			?>
            <span class="visibility post-visibility"><span class="sr-only"><?php _e('Visibility:', 'portafolis-uoc-access') ?> </span><strong><?php _e( 'Classroom', 'portafolis-uoc-access' ) ?></strong> <img
                        src="<?php echo site_url()?>/wp-content/plugins/portafolis-uoc-access/img/classroom.png"
                        class="visibility-icon"
                        title="<?php echo $help?>"></span>
			<?php
			break;
		case PORTAFOLIS_UOC_ACCESS_MY_TEACHERS:
			?>
            <span class="visibility post-visibility"><span class="sr-only"><?php _e('Visibility:', 'portafolis-uoc-access') ?> </span><strong><?php _e( 'Instructors', 'portafolis-uoc-access' ) ?></strong> <img
                        src="<?php echo site_url()?>/wp-content/plugins/portafolis-uoc-access/img/teachers.png"
                        class="visibility-icon"
                        title="<?php echo $help?>"></span>
			<?php
			break;
		case PORTAFOLIS_UOC_ACCESS_PRIVATE:
			?>
            <span class="visibility post-visibility"><span class="sr-only"><?php _e('Visibility:', 'portafolis-uoc-access') ?> </span><strong><?php _e( 'Private', 'portafolis-uoc-access' ) ?></strong> <img
                        src="<?php echo site_url()?>/wp-content/plugins/portafolis-uoc-access/img/private.png"
                        class="visibility-icon"
                        title="<?php echo $help?>"></span>
			<?php
			break;
		case PORTAFOLIS_UOC_ACCESS_PASSWORD:
			?>
            <span class="visibility post-visibility"><span class="sr-only"><?php _e('Visibility:', 'portafolis-uoc-access') ?> </span><strong><?php _e( 'with Password', 'portafolis-uoc-access' ) ?></strong> <img
                        src="<?php echo site_url()?>/wp-content/plugins/portafolis-uoc-access/img/lock.png"
                        class="visibility-icon"
                        title="<?php echo $help?>"></span>
			<?php
			break;
		default:
			?>
            <span class="visibility post-visibility"><span class="sr-only"><?php _e('Visibility:', 'portafolis-uoc-access') ?> </span><strong><?php _e( 'Public', 'portafolis-uoc-access' ) ?></strong> <img
                        src="<?php echo site_url()?>/wp-content/plugins/portafolis-uoc-access/img/world.png"
                        class="visibility-icon"
                        title="<?php echo $help?>"></span>
		<?php
	}
	echo apply_filters( 'agora_folio_visibility', '');
}

/**
 * Agora visibility

 */
function visibility_inline() {
	$visibility = class_exists('PortafolisUocAccess') ? \PortafolisUocAccess::get_post_visibility(get_the_ID()) : '';
	$help = class_exists('PortafolisUocAccess') ? \PortafolisUocAccess::return_help_information_state($visibility) : '';
	switch ( $visibility ) {
		case PORTAFOLIS_UOC_ACCESS_UOC:
			?><span class="visibility post-visibility" title="<?php echo $help?>"><span class="sr-only"><?php _e('Visibility:', 'portafolis-uoc-access') ?> </span><?php echo trim(__( 'Campus', 'portafolis-uoc-access' )) ?></span><?php
			break;
		case PORTAFOLIS_UOC_ACCESS_SUBJECT:
			?><span class="visibility post-visibility" title="<?php echo $help?>"><span class="sr-only"><?php _e('Visibility:', 'portafolis-uoc-access') ?> </span><?php echo trim(__( 'Classroom', 'portafolis-uoc-access' )) ?></span><?php
			break;
		case PORTAFOLIS_UOC_ACCESS_MY_TEACHERS:
			?><span class="visibility post-visibility" title="<?php echo $help?>"><span class="sr-only"><?php _e('Visibility:', 'portafolis-uoc-access') ?> </span><?php echo trim(__( 'Instructors', 'portafolis-uoc-access' )) ?></span><?php
			break;
		case PORTAFOLIS_UOC_ACCESS_PRIVATE:
			?><span class="visibility post-visibility" title="<?php echo $help?>"><span class="sr-only"><?php _e('Visibility:', 'portafolis-uoc-access') ?> </span><?php echo trim(__( 'Private', 'portafolis-uoc-access' )) ?></strong><?php
			break;
		case PORTAFOLIS_UOC_ACCESS_PASSWORD:
			?><span class="visibility post-visibility" title="<?php echo $help?>"><span class="sr-only"><?php _e('Visibility:', 'portafolis-uoc-access') ?> </span><?php echo trim(__( 'with Password', 'portafolis-uoc-access' )) ?></strong><?php
			break;
		default:
			?><span class="visibility post-visibility" title="<?php echo $help?>"><span class="sr-only"><?php _e('Visibility:', 'portafolis-uoc-access') ?> </span><?php echo trim(__( 'Public', 'portafolis-uoc-access' )) ?></strong><?php
	}
	echo apply_filters( 'agora_folio_visibility', '');
}

/**
 * Edit link
 */
function edit_link() {
	if ( get_edit_post_link() ) :
		edit_post_link(
			sprintf(
				wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit %s', 'agora-folio' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				'<span class="icon icon--edit-pencil icon--after" aria-hidden="true"></span><span class="visually-hidden">' . get_the_title() . '</span>'
			),
			null, null, null, 'btn btn--lower btn--white post-edit-link px-3 mb-2'
		);
	endif;
}


/**
 * Prints HTML with meta information for the current post-date/time.
 */
function posted_on($fmt = 'default') {
	//$time_string = '<span class="icon icon--calendar icon--xsmall icon--before" aria-hidden="true"></span>';
	$format = $fmt === 'grid' ? 'j F' : 'j F, Y';
	$time_string = '';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string .= '<span class="visually-hidden">%5$s </span><time class="entry-date entry-date-'.$fmt.' published" datetime="%1$s">%2$s</time> <time class="updated visually-hidden" datetime="%3$s">%4$s</time>';
	} else {
		$time_string .= '<span class="visually-hidden">%3$s </span><time class="entry-date entry-date-'.$fmt.' published updated" datetime="%1$s">%2$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_html( get_the_date( $format ) ),
		esc_attr( get_the_modified_date( DATE_W3C ) ),
		esc_html( get_the_modified_date() . ' ' . get_the_modified_time() ),
		__( 'Publication date', 'agora-folio' )
	);


	//$posted_on = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';
	$posted_on = '<a href="' . esc_url( get_day_link( get_post_time( 'Y' ), get_post_time( 'm' ),
			get_post_time( 'j' ) ) ) . '" rel="bookmark">' . $time_string . '</a>';

	echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.
}


/**
 * Prints HTML with meta information for the current author.
 */
function posted_by() {
	$view_profile = sprintf( __( "Entries by %s published in the Agora", "agora-folio" ), get_the_author() );
	$byline = sprintf(
	/* translators: %s: post author. */
		esc_html_x( '%s', 'post author', 'agora-folio' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . esc_attr( $view_profile ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	$byline = '<span class="visually-hidden">' . __( 'Posted by', 'agora-folio' ) . '</span>' . $byline;

	if ( get_the_author() != '' ) {
		echo '<span class="byline">' . $byline . '</span>'; // WPCS: XSS OK.
	}
}



/**
 * Get classroom user avatar
 */
function get_class_user_avatar($user_id){
	$avatar = '';
	if($user_id){
		$user_info = get_userdata($user_id);
		$parts    = explode( "@", $user_info->user_email );
		$username = $parts[0];
		$avatar = '<img src="https://campus.uoc.edu/UOC/mc-icons/fotos/' . $username . '.jpg">';
	}
	return $avatar;
}


/**
 * Prints HTML with meta information for the current author.
 */
function posted_by_avatar() {
	$view_profile = sprintf( __( "Entries by %s published in the Agora", "agora-folio" ), get_the_author() );
	$author_id = get_the_author_meta( 'ID' ); 
	$avatar = get_class_user_avatar($author_id);

	$byline = sprintf(
		/* translators: %s: post author. */
		esc_html_x( '%s', 'post author', 'agora-folio' ),
		'<a class="author-avatar d-inline-block" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . esc_attr( $view_profile )  . '">' . $avatar . '</a>'
	);

	$byline = '<span class="visually-hidden">' . __( 'Posted by', 'agora-folio' ) . ' </span>' . $byline;

	if ( get_the_author() != '' ) {
		echo '<span class="bybox">' . $byline . '</span>'; // WPCS: XSS OK.
	}
}

/**
 * Displays post tag list
 */
function tags_list() {
	if ( 'post' === get_post_type() ) {
		$tags_list = get_the_tag_list( '<ul class="list--inline-tags" role="list"><li>', '</li><li>', '</li></ul>' );
		if ( $tags_list ) {
			printf( '<div class="entry-tags"><span class="visually-hidden">%1$s </span>%2$s</div>',
				__( 'Tags', 'agora-folio' ),
				$tags_list
			);
		}
	}
}


/**
 * Displays post cats list
 */
function cats_list() {
	//if ( 'post' === get_post_type() ) {
	$categories_list = get_the_category_list();
	if ( $categories_list ) {
		printf( '<div class="entry-cats"><span class="visually-hidden">%1$s </span>%2$s</div>',
			__( 'Categories', 'agora-folio' ),
			$categories_list
		);
	}
	//}
}


/**
 * Prints HTML with meta information for entry footer (tags list, comments link, edit link)
 */
function entry_footer() {
	tags_list();
	//comments_link();
	edit_link();
}


/**
 * Displays an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 */
function post_thumbnail( $size = 'post-thumbnail' ) {
	if ( post_password_required() || is_attachment() ) {
		return;
	}

	if ( ! has_post_thumbnail() ) {
		$catch_image = Images\catch_that_image();
		if ( ! $catch_image ) {
			return;
		}
		if ( ! is_singular() ) :
			?>
            <div class="entry-media catched">
                <a class="post-thumbnail cover-img" href="<?php the_permalink(); ?>">
                    <img src="<?php echo $catch_image ?>" class="img-cover fade" alt="">
                </a>
            </div>
		<?php
		endif;

		return;
	}

	if ( is_singular() ) :
		?>
        <div class="entry-media">
            <div class="post-thumbnail cover-img">
				<?php the_post_thumbnail( $size, array( 'class' => 'img-cover fade', 'sizes' => 'calc(100vw - 30px)' ) ); ?>
            </div>
        </div>
	<?php else : ?>
        <div class="entry-media">
            <a class="post-thumbnail cover-img" href="<?php the_permalink(); ?>">
				<?php
				the_post_thumbnail( $size, array(
					'class' => 'img-cover fade',
					'alt'   => the_title_attribute( array(
						'echo' => false,
					) ),
				) );
				?>
            </a>
        </div>
	<?php
	endif; // End is_singular().
}


/**
 * Custom comments form
 */
function comments_form() {

	$user          = wp_get_current_user();
	$user_identity = $user->exists() ? $user->display_name : '';
	$user_avatar   = $user->exists() ? get_class_user_avatar( $user->ID ) : '';

	$comments_args = array(
		'class_form'           => 'form--inverse comment-form needs-validation',
		'class_submit'         => 'submit btn btn--primary px-3',
		'label_submit'         => __( 'Send comment', 'agora-folio' ),
		'title_reply'          => __( 'Leave a comment', 'agora-folio' ),
		'cancel_reply_link'    => '<span class="icon icon--close icon--xsmall icon--before" aria-hidden="true"></span> <span class="sr-only-sm">' . __( 'Cancel Reply',
				'agora-folio' ) . '</span>',
		'submit_field'         => '<span class="form-submit d-inline-block m-right-2x">%1$s %2$s</span>',
		'comment_notes_before' => '',
		'comment_notes_after'  => '',
		'logged_in_as'         => sprintf(
			'<div class="logged-in-as d-flex align-items-center justify-content-between"><span class="avatar">' . $user_avatar . '</span>%s</div>',
			sprintf(
				'<a href="%1$s" aria-label="%2$s" class="fn btnlink">%3$s</a> <a href="%4$s" class="logout btnlink btnlink--regular"><span class="sr-only-sm">%5$s</span><span class="icon icon-svg icon--after icon-svg--logout" aria-hidden="true"></span></a>',
				get_edit_user_link(),
				/* translators: %s: User name. */
				esc_attr( sprintf( __( 'Logged in as %s. Edit your profile.' ), $user_identity ) ),
				$user_identity,
				wp_logout_url( apply_filters( 'the_permalink', get_permalink() ) ),
				__( 'Log out?', 'agora-folio' )
			)
		),
	);

	comment_form( $comments_args );

}





/**
 * Displays a customized comment item for default views
 */
function comment_item( $comment, $args, $depth ) {

	$comment_text = get_comment_text();

	if ( 'div' === $args['style'] ) {
		$tag       = 'div';
		$add_below = 'comment';
	} else {
		$tag       = 'li';
		$add_below = 'div-comment';
	} ?>
    <<?php echo $tag; ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID() ?>"><?php
	?>
    <article id="div-comment-<?php comment_ID() ?>" class="comment-body">
        <header class="comment-meta">
            <div class="comment-author vcard">
				<?php
				/*if ( $args['avatar_size'] != 0 ) {
					echo get_avatar( $comment, $args['avatar_size'] );
				}*/
				echo '<div class="avatar">' . get_class_user_avatar($comment->user_id) . '</div>';
				printf( __( '<cite class="fn">%s</cite> <span class="visually-hidden">says:</span>' ),
					get_comment_author_link() );
				?>
            </div>
            <div class="comment-metadata">
                <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>"><?php
					/* translators: 1: date, 2: time */
					printf(
						__( '%1$s %2$s' ),
						get_comment_date(),
						get_comment_time()
					); ?>
                </a><?php
				edit_comment_link( __( '(Edit)' ), '  ', '' ); ?>
            </div>
			<?php
			if ( $comment->comment_approved == '0' ) { ?>
                <div class="alert alert--info comment-awaiting-moderation"><?php _e( 'Your contribution is awaiting moderation.' ); ?></div><?php
			} ?>
        </header>

        <div class="comment-content">
			<?php
			echo apply_filters( 'comment_text', $comment_text, $comment );
			?>
        </div>

        <div class="reply reply-custom"><?php
			comment_reply_link(
				array_merge(
					$args,
					array(
						'reply_text' => '<span class="icon icon--respond icon--xsmall icon--before" aria-hidden="true"></span> <span class="sr-only-sm">' . __( 'Reply',
								'agora-folio' ) . '</span>',
						'add_below'  => $add_below,
						'depth'      => $depth,
						'max_depth'  => $args['max_depth']
					)
				)
			); ?>
        </div>
    </article>
	<?php
}

/**
 * Displays a customized comment item for tree view
 */
function comment_tree_item( $comment, $args, $depth ) {

	$comment_text = get_comment_text();

	if ( 'div' === $args['style'] ) {
		$tag       = 'div';
	} else {
		$tag       = 'li';
	} 

	$add_below = 'comment-content';

	$tree_id = get_the_ID() . '_' . get_comment_ID();

	?>

    <<?php echo $tag; ?> class="tree-item comment tree-item-l<?php echo $depth;?> open-node" id="comment-<?php comment_ID() ?>" role="presentation" data-tree-id="<?php echo $tree_id; ?>" data-tree-title="<?php echo esc_attr( 'comment', 'agora-folio' ) . ' ' .  get_comment_ID() ; ?>"><?php
	?>
    <article id="div-comment-<?php comment_ID() ?>" class="tree-node comment-body">
				
        <header class="comment-header tree-header tree-content">
			<div class="comment-meta">
				<div class="comment-author vcard">
					<?php
					/*if ( $args['avatar_size'] != 0 ) {
						echo get_avatar( $comment, $args['avatar_size'] );
					}*/
					echo '<div class="avatar">' . get_class_user_avatar($comment->user_id) . '</div>';
					printf( __( '<cite class="fn">%s</cite> <span class="visually-hidden">says:</span>' ),
						get_comment_author_link() );
					?>
				</div>
				<div class="comment-metadata">
					<a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>"><?php
						/* translators: 1: date, 2: time */
						printf(
							__( '%1$s %2$s' ),
							get_comment_date(),
							get_comment_time()
						); ?>
					</a><?php
					edit_comment_link( __( '(Edit)' ), '  ', '' ); ?>
				</div>
				<?php
				if ( $comment->comment_approved == '0' ) { ?>
					<div class="alert alert--info comment-awaiting-moderation"><?php _e( 'Your contribution is awaiting moderation.' ); ?></div><?php
				} ?>
			</div>
        </header>

        <div class="comment-content tree-content">
			<div id="comment-content-<?php comment_ID() ?>">
				<?php
				echo apply_filters( 'comment_text', $comment_text, $comment );
				?>
			</div>
        </div>

        <div class="reply reply-custom"><?php
			comment_reply_link(
				array_merge(
					$args,
					array(
						'reply_text' => '<span class="icon icon--respond icon--xsmall icon--before" aria-hidden="true"></span> <span class="sr-only-sm">' . __( 'Reply', 'agora-folio' ) . '</span>',
						'add_below'  => $add_below,
						'depth'      => $depth,
						'max_depth'  => $args['max_depth']
					)
				)
			); ?>
        </div>
    </article>
	<?php
}

/**
 * Render actifolio tree view menu
 */
function actifolio_tree_view_menu (&$items) {
	if ( uoc_create_site_is_student_blog() ) {
		$menu = __( 'My activities', 'portafolis-uoc-access' );
	} else {
		$menu = __( 'Filter by ActiFolio', 'portafolis-uoc-access' );
	}
	$title = is_archive() ? get_the_archive_title() : __( 'All' );

	if ( is_array( $items ) && count( $items ) > 0 ) :
	?>
	<nav id="agora-view-menu" class="agora-view-menu" role="navigation" aria-label="<?php echo esc_attr( $menu ) ?>"> 
		<div class="dropdown ruler ruler--primary visible-xs-block visible-sm-block visible-md-block mb-4">
			<a href="#" role="button" class="btnlink btnlink--regular btn--block dropdown-toggle py-2" type="button" id="dropdownMenuButton" data-offset="0,20" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<?php echo $menu; ?>: <strong class="current-actifolio"><?php echo $title; ?></strong>
				<span class="icon icon--xsmall icon--arrow-drop-down icon--after float-right mx-1 mt-1" aria-hidden="true"></span>
			</a>
			<div class="dropdown-menu ruler ruler--primary" aria-labelledby="dropdownMenuButton">
				<div class="dropdown-triangle"></div>
				<ul class="list--unstyled list--compact">
					<?php
					foreach ( $items as $item ) :
						$cls = $item->active ? 'active' : '';
					?>
						<li class="ruler ruler--thin">
							<a href="<?php echo get_term_link( $item->term ) ?>" class="btnlink btnlink--regular d-flex pt-2 pb-4 px-2 <?php echo $cls ?>">
								<span class="label mr-auto"><?php echo $item->term->name; ?></span>
								<?php /*<span class="count ml-2">
									<span class="badge">
										<?php echo $item->count ?> 
										<span class="sr-only"><?php _e( 'posts', 'agora-folio' ); ?></span>
									</span>
								</span> */ ?>
							</a>
						</li>
					<?php
					endforeach;
					?>
				</ul>
			</div>	
		</div>
			
		<ul class="list--unstyled list--compact ruler ruler--primary hidden-xs hidden-sm hidden-md">
			<?php
				foreach ( $items as $item ) :
					$cls = $item->active ? 'active' : '';
				?>
					<li class="ruler ruler--thin">
						<a href="<?php echo get_term_link( $item->term ) ?>" class="btnlink btnlink--regular d-flex pt-2 pb-4 px-2 <?php echo $cls ?>">
							<span class="label mr-auto"><?php echo $item->term->name; ?></span>
							<?php /*<span class="count ml-2">
								<span class="badge">
									<?php echo $item->count ?> 
									<span class="sr-only"><?php _e( 'posts', 'agora-folio' ); ?></span>
								</span>
							</span> */ ?>
						</a>
					</li>
				<?php
				endforeach;
			?>
		</ul>
	</nav>
	<?php
	endif;
}


/**
 * Embeds a dummy_pdf to forze load PDF Embedder styles & scripts
 */
function dummy_pdf() {
	echo '<div class="hidden">' . do_shortcode('[pdf-embedder url="' . get_stylesheet_directory_uri() . '/inc/dummy.pdf"]') . '</div>';
}