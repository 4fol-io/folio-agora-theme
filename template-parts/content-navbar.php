<?php
/**
 * Template part for displaying page heading (breadcrumbs, filters, ...)
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package AgoraFolio
 */

use AgoraFolio\Utils;
Use AgoraFolio\Data;


$controls = !(is_single() || is_page() || is_search());

if ($controls) {

    global $wp;
    $action = add_query_arg( $wp->query_vars, home_url( $wp->request ) );

    $orderby = get_query_var('orderby') ? get_query_var('orderby') : 'date';
    $order = get_query_var('order') ? get_query_var('order') : 'DESC';
    $view = Data\get_agora_view();
    
    $sort_icon = $order === 'DESC' ? 'icon--arrow-drop-down' : 'icon--arrow-drop-up';
    $order_by_lbl = '';
    $order_lbl = $order === 'DESC' ? __( "Descending", "agora-folio" ) : __( "Ascending", "agora-folio" );

    switch($orderby){
        case 'date':
            $order_by_lbl = __( "Date", "agora-folio" );
            break;
        case 'title':
            $order_by_lbl = __( "Title", "agora-folio" );
            break;
        case 'firstname':
            $order_by_lbl = __( "Name", "agora-folio" );
            break;
        case 'lastname':
            $order_by_lbl = __( "Surname", "agora-folio" );
            break;
        case 'evaluable':
            $order_by_lbl = __( "Evaluable", "agora-folio" );
            break;
        case 'activity':
            $order_by_lbl = __( "Activity", "agora-folio" );
            break;
        /*case 'new':
            $order_by_lbl = __( "Recent", "agora-folio" );
            break;*/
    }
    
}

$show_assessment = false;
if (function_exists('portafolis_uoc_rac_instantiate')) {
    $portafolis_uoc_rac_instantiate = portafolis_uoc_rac_instantiate();
	$show_assessment = $portafolis_uoc_rac_instantiate->get_is_teacher();
}

?>

<div class="row mb-3">

    <div class="<?php echo $controls ? 'col-md-7 col-lg-8' : 'col-md-12' ?>">
        <nav class="nav-breadcrumb d-flex align-items-center mt-1" aria-label="<?php esc_html_e('You are here', 'agora-folio' ); ?>">
            <?php Utils\the_breadcrumb(); ?>
            <a 
                href="#" 
                role="button"
                data-toggle="collapse" 
                data-target="#search-agoras-collapse"
                aria-expanded="false" 
                class="btnlink btnlink--regular btn-collapse-search collapsed ml-auto mt-1 <?php echo $controls ? 'visible-xs visible-sm' : '' ?>" 
                id="search-agoras-toggle-nav"
                title="<?php esc_html_e('Search', 'agora-folio'); ?>"
                aria-label="<?php esc_html_e('Search', 'agora-folio'); ?>">
                <span class="icon icon--small icon--search-full ml-1" aria-hidden="true"></span>
            </a>
        </nav>
    </div>

    <?php if ($controls) : ?>
    <div class="col-md-5 col-lg-4 hidden-xs hidden-sm">
        <nav class="nav-actions" aria-label="<?php esc_html_e('Order and visualization options', 'agora-folio' ); ?>">
            <ul class="list--unstyled list--inline d-flex align-items-center">
                <li class="dropdown-sort ml-auto">
                    <a 
                        href="#" 
                        role="button"
                        data-toggle="dropdown" 
                        data-placement="bottom"
                        data-offset="-40,20"
                        aria-haspopup="true" 
                        aria-expanded="false" 
                        class="btnlink btnlink--regular dropdown-toggle" 
                        id="dropdown-sort-agoras-toggle"
                        aria-label="<?php esc_html_e('Order menu', 'agora-folio'); ?>">
                        <?php _e('Order', 'agora-folio' ); ?>: <strong class="current-order-by"><?php echo $order_by_lbl ?></strong>
                        <?php /*<span class="icon icon--xsmall <?php echo $sort_icon ?> icon--after" aria-hidden="true"></span> */ ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdown-sort-agoras-toggle">
                        <div class="dropdown-triangle"></div>
                        <form method="get" action="<?php echo esc_url($action); ?>" 
                            class="form-sort form-sort-agoras"
                            data-orderby="<?php echo esc_attr($orderby) ?>" data-order="<?php echo esc_attr($order) ?>">
                            <fieldset>
                                <div class="form-radio m-0 px-1 pb-2">
                                    <label for="agoras_orderby_date" <?php if ($orderby === 'date'): ?>class="active"<?php endif; ?>>
                                        <input id="agoras_orderby_date" name="orderby" type="radio" value="date" <?php if ($orderby === 'date'): ?>checked<?php endif; ?>>
                                        <span aria-hidden="true" class="icon icon--radio-button-off icon--small"></span> <?php _e( "Date", "agora-folio" ); ?>
                                    </label>
                                </div>
                                <div class="form-radio ruler ruler--thin m-0 px-1 py-2">
                                    <label for="agoras_orderby_title" <?php if ($orderby === 'title'): ?>class="active"<?php endif; ?>>
                                        <input id="agoras_orderby_title" name="orderby" type="radio" value="title" <?php if ($orderby === 'title'): ?>checked<?php endif; ?>>
                                        <span aria-hidden="true" class="icon icon--radio-button-off icon--small"></span> <?php _e( "Title", "agora-folio" ); ?>
                                    </label>
                                </div>
                                <div class="form-radio ruler ruler--thin m-0 px-1 py-2">
                                    <label for="agoras_orderby_name" <?php if ($orderby === 'firstname'): ?>class="active"<?php endif; ?>>
                                        <input id="agoras_orderby_name" name="orderby" type="radio" value="firstname" <?php if ($orderby === 'firstname'): ?>checked<?php endif; ?>>
                                        <span aria-hidden="true" class="icon icon--radio-button-off icon--small"></span> <?php _e( "Name", "agora-folio" ); ?>
                                    </label>
                                </div>
                                <div class="form-radio ruler ruler--thin m-0 px-1 py-2">
                                    <label for="agoras_orderby_surname" <?php if ($orderby === 'lastname'): ?>class="active"<?php endif; ?>>
                                        <input id="agoras_orderby_surname" name="orderby" type="radio" value="lastname" <?php if ($orderby === 'lastname'): ?>checked<?php endif; ?>>
                                        <span aria-hidden="true" class="icon icon--radio-button-off icon--small"></span> <?php _e( "Surname", "agora-folio" ); ?>
                                    </label>
                                </div>
                                <?php /*
                                <?php if ($show_assessment) : ?>
                                <div class="form-radio ruler ruler--thin m-0 px-1 py-2">
                                    <label for="agoras_orderby_evaluable" <?php if ($orderby === 'evaluable'): ?>class="active"<?php endif; ?>>
                                        <input id="agoras_orderby_evaluable" name="orderby" type="radio" value="evaluable" <?php if ($orderby === 'evaluable'): ?>checked<?php endif; ?>>
                                        <span aria-hidden="true" class="icon icon--radio-button-off icon--small"></span> <?php _e( "Evaluable", "agora-folio" ); ?>
                                    </label>
                                </div>
                                <?php endif; ?>
                                <div class="form-radio ruler ruler--thin m-0 px-1 py-2">
                                    <label for="agoras_orderby_activity" <?php if ($orderby === 'activity'): ?>class="active"<?php endif; ?>>
                                        <input id="agoras_orderby_activity" name="orderby" type="radio" value="activity" <?php if ($orderby === 'activity'): ?>checked<?php endif; ?>>
                                        <span aria-hidden="true" class="icon icon--radio-button-off icon--small"></span> <?php _e( "Activity", "agora-folio" ); ?>
                                    </label>
                                </div>
                                <div class="form-radio ruler ruler--thin m-0 px-1 py-2">
                                    <label for="agoras_orderby_new" <?php if ($orderby === 'new'): ?>class="active"<?php endif; ?>>
                                        <input id="agoras_orderby_new" name="orderby" type="radio" value="new" <?php if ($orderby === 'new'): ?>checked<?php endif; ?>>
                                        <span aria-hidden="true" class="icon icon--radio-button-off icon--small"></span> <?php _e( "Recent", "agora-folio" ); ?>
                                    </label>
                                </div>
                                */ ?>
                            </fieldset>
                            <div class="visually-hidden">
                                <input type="hidden" name="order" class="agoras_order" value="<?php echo $order ?>">
                                <button type="submit"><?php _e( "Apply", "agora-folio" ); ?></button>
                            </div>
                        </form>
                    </div>
                    <button class="btn btn--order" type="button" data-order="<?php echo esc_attr($order) ?>">
                        <span class="btn--order__message visually-hidden"><?php esc_html_e('Order', 'agora-folio'); ?>: <span class="current-order"><?php echo $order_lbl ?></span></span>
                        <span class="btn--order_content"><span aria-hidden="true" class="icon icon--smal icon--arrow-drop-up"></span></span>
                        <span class="btn--order_content"><span aria-hidden="true" class="icon icon--smal icon--arrow-drop-down"></span></span>
                    </button>
                </li>
                <li class="ml-3">
                    <a 
                        href="<?php echo esc_url( add_query_arg( 'view', 'grid', $action ) ); ?>" 
                        role="button"
                        data-view="grid"
                        class="btnlink btnlink--regular js-change-agora-view <?php if ($view === 'grid'): ?>active<?php endif ?>" 
                        title="<?php esc_html_e('Grid view', 'agora-folio'); ?>"
                        aria-label="<?php esc_html_e('Grid view', 'agora-folio'); ?>"
                        <?php if ($view === 'grid'): ?>aria-current="true"<?php endif ?>>
                        <span class="icon icon-svg icon-svg--grid" aria-hidden="true"></span>
                    </a>
                </li>
                <li>
                    <a 
                        href="<?php echo esc_url( add_query_arg( 'view', 'list', $action ) ); ?>" 
                        role="button"
                        data-view="list"
                        class="btnlink btnlink--regular js-change-agora-view <?php if ($view === 'list'): ?>active<?php endif ?>" 
                        title="<?php esc_html_e('List view', 'agora-folio'); ?>"
                        aria-label="<?php esc_html_e('List view', 'agora-folio'); ?>"
                        <?php if ($view === 'list'): ?>aria-current="true"<?php endif ?>>
                        <span class="icon icon-svg icon-svg--list" aria-hidden="true"></span>
                    </a>
                </li>
                <?php /*<li>
                    <a 
                        href="<?php echo esc_url( add_query_arg( 'view', 'full', $action ) ); ?>" 
                        role="button"
                        data-view="full"
                        class="btnlink btnlink--regular js-change-agora-view <?php if ($view === 'full'): ?>active<?php endif ?>" 
                        title="<?php esc_html_e('Expanded view', 'agora-folio'); ?>"
                        aria-label="<?php esc_html_e('Expanded view', 'agora-folio'); ?>"
                        <?php if ($view === 'full'): ?>aria-current="true"<?php endif ?>>
                        <span class="icon icon-svg icon-svg--full" aria-hidden="true"></span>
                    </a>
                </li>*/ ?>
                <li>
                    <a 
                        href="<?php echo esc_url( add_query_arg( 'view', 'comm', $action ) ) ?>" 
                        role="button"
                        data-view="comm"
                        class="btnlink btnlink--regular js-change-agora-view <?php if ($view === 'comm'): ?>active<?php endif ?>" 
                        title="<?php esc_html_e('Comments view', 'agora-folio'); ?>"
                        aria-label="<?php esc_html_e('Comments view', 'agora-folio'); ?>"
                        <?php if ($view === 'comm'): ?>aria-current="true"<?php endif ?>>
                        <span class="icon icon-svg icon-svg--comm" aria-hidden="true"></span>
                    </a>
                </li>
                <li class="ml-3">
                    <a 
                        href="#" 
                        role="button"
                        data-toggle="collapse" 
                        data-target="#search-agoras-collapse"
                        aria-expanded="false" 
                        class="btnlink btnlink--regular btn-collapse-search collapsed" 
                        id="search-agoras-toggle"
                        title="<?php esc_html_e('Search', 'agora-folio'); ?>"
                        aria-label="<?php esc_html_e('Search', 'agora-folio'); ?>">
                        <span class="icon icon--small icon--search-full" aria-hidden="true"></span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <?php endif; ?>
</div>

<div class="search-agoras collapse" id="search-agoras-collapse" aria-labelledby="search-agoras-toggle search-agoras-toggle-nav">
    <?php get_search_form(); ?>
</div>


<?php if ($controls) : ?>
<div class="nav-actions-mobile visible-xs visible-sm">
    <div class="container">
        <nav class="nav-actions" aria-label="<?php esc_html_e('Order and visualization options', 'agora-folio' ); ?>">
            <ul class="list--unstyled list--inline d-flex align-items-center justify-content-between">
                <li class="align-center">
                    <a 
                        href="#" 
                        role="button"
                        data-order="<?php echo esc_attr($order) ?>"
                        data-toggle="modal" 
                        data-target="#modal-sort-agoras"
                        class="btnlink modal-toggle d-inline-block px-1 py-2" 
                        id="modal-sort-agoras-toggle"
                        aria-label="<?php esc_html_e('Order menu', 'agora-folio'); ?>">
                        <span class="icon icon-svg icon-svg--order-asc" aria-hidden="true"></span>
                        <span class="icon icon-svg icon-svg--order-desc" aria-hidden="true"></span>
                    </a>
                </li>
                <?php /*
                <li class="align-center">
                    <a 
                        href="<?php echo esc_url( add_query_arg( 'view', 'list', $action ) ) ?>" 
                        role="button"
                        data-view="list"
                        class="btnlink js-change-agora-view d-inline-block px-3 py-2 <?php if ($view === 'list' || $view === 'grid'): ?>active<?php endif ?>" 
                        aria-label="<?php esc_html_e('List view', 'agora-folio'); ?>"
                        <?php if ($view === 'list' || $view === 'grid'): ?>aria-current="true"<?php endif ?>>
                        <span class="icon icon-svg icon-svg--list" aria-hidden="true"></span>
                    </a>
                </li>
                <li class="align-center">
                    <a 
                        href="<?php echo esc_url( add_query_arg( 'view', 'full', $action ) ) ?>" 
                        role="button"
                        data-view="full"
                        class="btnlink btnlink--regular js-change-agora-view d-inline-block px-3 py-2 <?php if ($view === 'full'): ?>active<?php endif ?>" 
                        aria-label="<?php esc_html_e('Expanded view', 'agora-folio'); ?>"
                        <?php if ($view === 'full'): ?>aria-current="true"<?php endif ?>>
                        <span class="icon icon-svg icon-svg--full" aria-hidden="true"></span>
                    </a>
                </li>
                */ ?>
                <li class="align-center">
                    <a 
                        href="<?php echo esc_url( add_query_arg( 'view', 'grid', $action ) ) ?>" 
                        role="button"
                        data-view="grid"
                        class="btnlink js-change-agora-view d-inline-block px-3 py-2 <?php if ($view === 'grid'): ?>active<?php endif ?>" 
                        aria-label="<?php esc_html_e('Grid view', 'agora-folio'); ?>"
                        <?php if ($view === 'grid'): ?>aria-current="true"<?php endif ?>>
                        <span class="icon icon-svg icon-svg--grid" aria-hidden="true"></span>
                    </a>
                </li>
                <li class="align-center">
                    <a 
                        href="<?php echo esc_url( add_query_arg( 'view', 'list', $action ) ) ?>" 
                        role="button"
                        data-view="list"
                        class="btnlink btnlink--regular js-change-agora-view d-inline-block px-3 py-2 <?php if ($view === 'list'): ?>active<?php endif ?>" 
                        aria-label="<?php esc_html_e('List view', 'agora-folio'); ?>"
                        <?php if ($view === 'list'): ?>aria-current="true"<?php endif ?>>
                        <span class="icon icon-svg icon-svg--list" aria-hidden="true"></span>
                    </a>
                </li>
                <li class="align-center">
                    <a 
                        href="<?php echo esc_url( add_query_arg( 'view', 'comm', $action ) ) ?>" 
                        role="button"
                        data-view="comm"
                        class="btnlink btnlink--regular js-change-agora-view d-inline-block px-3 py-2 <?php if ($view === 'comm'): ?>active<?php endif ?>" 
                        aria-label="<?php esc_html_e('Comments view', 'agora-folio'); ?>"
                        <?php if ($view === 'comm'): ?>aria-current="true"<?php endif ?>>
                        <span class="icon icon-svg icon-svg--comm" aria-hidden="true"></span>
                    </a>
                </li>
                <li class="align-center">
                    <a  href="#page" 
                        role="button" 
                        class="btnlink sticky-scroll off d-inline-block px-3 py-2"
                        aria-label="<?php esc_html_e('Go to top', 'agora-folio'); ?>">
                        <span class="icon icon-svg icon-svg--scroll" aria-hidden="true"></span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>

<!-- Modal Sort Agoras -->
<div class="modal fade" id="modal-sort-agoras" tabindex="-1" aria-labelledby="modal-sort-agoras-title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title ml-1" id="modal-sort-agoras-title"><?php _e('Order', 'agora-folio' ); ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label=""<?php esc_html_e('Close', 'agora-folio'); ?>">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body pt-3 pb-1">
            <form method="get" action="<?php echo esc_url($action); ?>" 
                class="form-sort form-sort-agoras"
                data-orderby="<?php echo esc_attr($orderby) ?>" data-order="<?php echo esc_attr($order) ?>">
                <fieldset>
                    <div class="form-radio ruler ruler--thin m-0 px-1 py-2">
                        <label for="agoras_orderby_date_modal" <?php if ($orderby === 'date'): ?>class="active"<?php endif; ?>>
                            <input id="agoras_orderby_date_modal" name="orderby" type="radio" value="date" <?php if ($orderby === 'date'): ?>checked<?php endif; ?>>
                            <span aria-hidden="true" class="icon icon--radio-button-off icon--small"></span> <?php _e( "Date", "agora-folio" ); ?>
                        </label>
                    </div>
                    <div class="form-radio ruler ruler--thin m-0 px-1 py-2">
                        <label for="agoras_orderby_title_modal" <?php if ($orderby === 'title'): ?>class="active"<?php endif; ?>>
                            <input id="agoras_orderby_title_modal" name="orderby" type="radio" value="title" <?php if ($orderby === 'title'): ?>checked<?php endif; ?>>
                            <span aria-hidden="true" class="icon icon--radio-button-off icon--small"></span> <?php _e( "Title", "agora-folio" ); ?>
                        </label>
                    </div>
                    <div class="form-radio ruler ruler--thin m-0 px-1 py-2">
                        <label for="agoras_orderby_name_modal" <?php if ($orderby === 'firstname'): ?>class="active"<?php endif; ?>>
                            <input id="agoras_orderby_name_modal" name="orderby" type="radio" value="firstname" <?php if ($orderby === 'firstname'): ?>checked<?php endif; ?>>
                            <span aria-hidden="true" class="icon icon--radio-button-off icon--small"></span> <?php _e( "Name", "agora-folio" ); ?>
                        </label>
                    </div>
                    <div class="form-radio ruler ruler--thin m-0 px-1 py-2">
                        <label for="agoras_orderby_surname_modal" <?php if ($orderby === 'lastname'): ?>class="active"<?php endif; ?>>
                            <input id="agoras_orderby_surname_modal" name="orderby" type="radio" value="lastname" <?php if ($orderby === 'lastname'): ?>checked<?php endif; ?>>
                            <span aria-hidden="true" class="icon icon--radio-button-off icon--small"></span> <?php _e( "Surname", "agora-folio" ); ?>
                        </label>
                    </div>
                    <?php /*
                    <div class="form-radio ruler ruler--thin m-0 px-1 py-2">
                        <label for="agoras_orderby_evaluable_modal" <?php if ($orderby === 'evaluable'): ?>class="active"<?php endif; ?>>
                            <input id="agoras_orderby_evaluable_modal" name="orderby" type="radio" value="evaluable" <?php if ($orderby === 'evaluable'): ?>checked<?php endif; ?>>
                            <span aria-hidden="true" class="icon icon--radio-button-off icon--small"></span> <?php _e( "Evaluable", "agora-folio" ); ?>
                        </label>
                    </div>
                    <div class="form-radio ruler ruler--thin m-0 px-1 py-2">
                        <label for="agoras_orderby_activity_modal" <?php if ($orderby === 'activity'): ?>class="active"<?php endif; ?>>
                            <input id="agoras_orderby_activity_modal" name="orderby" type="radio" value="activity" <?php if ($orderby === 'activity'): ?>checked<?php endif; ?>>
                            <span aria-hidden="true" class="icon icon--radio-button-off icon--small"></span> <?php _e( "Activity", "agora-folio" ); ?>
                        </label>
                    </div>
                    <div class="form-radio ruler ruler--thin m-0 px-1 py-2">
                        <label for="agoras_orderby_new_modal" <?php if ($orderby === 'new'): ?>class="active"<?php endif; ?>>
                            <input id="agoras_orderby_new_modal" name="orderby" type="radio" value="new" <?php if ($orderby === 'new'): ?>checked<?php endif; ?>>
                            <span aria-hidden="true" class="icon icon--radio-button-off icon--small"></span> <?php _e( "Recent", "agora-folio" ); ?>
                        </label>
                    </div>
                    */ ?>
                </fieldset>
                <fieldset>
                    <div class="form-radio ruler ruler--half m-0 px-1 py-2 ruler--primary">
                        <label for="agoras_order_asc_modal" <?php if ($order === 'ASC'): ?>class="active"<?php endif; ?>>
                            <input id="agoras_order_asc_modal" name="order" type="radio" value="ASC" <?php if ($order === 'ASC'): ?>checked<?php endif; ?>>
                            <span aria-hidden="true" class="icon icon--radio-button-off icon--small"></span> <?php _e( "Ascending", "agora-folio" ); ?>
                        </label>
                    </div>
                    <div class="form-radio ruler ruler--double ruler--thin m-0 px-1 py-2">
                        <label for="agoras_order_desc_modal" <?php if ($order === 'DESC'): ?>class="active"<?php endif; ?>>
                            <input id="agoras_order_desc_modal" name="order" type="radio" value="DESC" <?php if ($order === 'DESC'): ?>checked<?php endif; ?>>
                             <span aria-hidden="true" class="icon icon--radio-button-off icon--small"></span> <?php _e( "Descending", "agora-folio" ); ?>
                        </label>
                    </div>
                </fieldset>
            </form>
        </div>
        <div class="modal-footer pb-3">
            <button type="button" class="btn btn--secondary px-5" data-dismiss="modal"><?php _e( "Cancel", "agora-folio" ); ?></button>
            <button type="button" class="btn btn--primary px-5 btn-modal-sort"><?php _e( "Apply", "agora-folio" ); ?></button>
        </div>
    </div>
  </div>
</div>

<?php endif; ?>