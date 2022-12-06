<?php

/**
 * DEMO Widgets to emulate Participants and Actifolio widgets in development + Adminbar custom menus
 * Disable this file in functions.php in production
 *
 * @package AgoraFolio
 */

use AgoraFolio\Assets\AssetResolver;

/**
 * Define plugin portafolis-uoc-access constants if not defined
 */ 
defined('PORTAFOLIS_UOC_ACCESS_WORLD') or define( 'PORTAFOLIS_UOC_ACCESS_WORLD', 'public' );
defined('PORTAFOLIS_UOC_ACCESS_UOC') or define( 'PORTAFOLIS_UOC_ACCESS_UOC', 'uoc' );
defined('PORTAFOLIS_UOC_ACCESS_SUBJECT') or define( 'PORTAFOLIS_UOC_ACCESS_SUBJECT', 'subject' );
defined('PORTAFOLIS_UOC_ACCESS_MY_TEACHERS') or define( 'PORTAFOLIS_UOC_ACCESS_MY_TEACHERS', 'teachers' );
defined('PORTAFOLIS_UOC_ACCESS_MY_BLOG_DEPRECATED') or define( 'PORTAFOLIS_UOC_ACCESS_MY_BLOG_DEPRECATED', 'blog' );
defined('PORTAFOLIS_UOC_ACCESS_PRIVATE') or define( 'PORTAFOLIS_UOC_ACCESS_PRIVATE', 'private' );
defined('PORTAFOLIS_UOC_ACCESS_PASSWORD') or define( 'PORTAFOLIS_UOC_ACCESS_PASSWORD', 'password' );
defined('PORTAFOLIS_UOC_META_KEY') or define( 'PORTAFOLIS_UOC_META_KEY', 'portafolis_uoc_access' );


class Demo_Agora_Participans_Widget extends \WP_Widget {
  
    function __construct() {
        parent::__construct(
            'demo_agora_participants_widget', 
            'Participants DEMO', 
            array( 'description' => 'DEMO Widget Àgora Participants') 
        );
    }

    public function widget( $args, $instance ) {

        $title = apply_filters( 'widget_title', $instance['title'] );
        $wid = $args['widget_id'];

        echo $args['before_widget'];

        if ( ! empty( $title ) )
            echo '<div class="visually-hidden">' . $args['before_title'] . $title . $args['after_title'] . '</div>';

        ?>
        <div class="block block--mega block--participants" data-orderby="surname" data-order="ASC">

            <div class="block-filters">
                <fieldset aria-labelledby="participants_filters_legend_<?php echo $wid?>" class="row">

                    <div class="col-md-4 col-lg-3 sr-only-sm">
                        <legend class="py-3 pl-1 pl-md-3" id="participants_filters_legend_<?php echo $wid?>"><strong>56</strong> participantes, ordenar por:</legend>
                    </div>

                    <div class="col-md-4 col-lg-3 d-flex d-block-md align-items-center justify-content-between">
                        <div class="form-inline-radio py-3 pl-md-2">
                            <label for="participants_orderby_name_<?php echo $wid?>">
                                <input class="participants-orderby" id="participants_orderby_name_<?php echo $wid?>" name="participants_orderby_<?php echo $wid?>" type="radio" value="name" data-label="Nombre">
                                <span aria-hidden="true" class="icon icon--radio-button-off icon--small"></span> Nombre
                            </label>

                            <label for="participants_orderby_surname_<?php echo $wid?>">
                                <input class="participants-orderby" id="participants_orderby_surname_<?php echo $wid?>" name="participants_orderby_<?php echo $wid?>" type="radio" value="surname" data-label="Apellidos" checked>
                                <span aria-hidden="true" class="icon icon--radio-button-off icon--small"></span> Apellidos
                            </label>
                        </div>
                        <div class="block--participants-sort visible-xs visible-sm">
                            <a href="#" role="button" class="btn btn--secondary px-2 btn-participants-sort">
                                <span class="icon icon-svg icon-svg--order" aria-hidden="true"></span>
                                <span class="icon-alt" aria-hidden="true">Orden: <span class="lbl">Ascencente</span></span>
                            </a>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-6 hidden-xs hidden-sm">
                        <div class="form-inline-radio py-3">
                            <label for="participants_order_asc_<?php echo $wid?>">
                                <input class="participants-order" id="participants_order_asc_<?php echo $wid?>" name="participants_order_<?php echo $wid?>" type="radio" value="ASC" data-label="Ascendente" checked>
                                <span aria-hidden="true" class="icon icon--radio-button-off icon--small"></span> Ascendente
                            </label>

                            <label for="participants_order_desc_<?php echo $wid?>">
                                <input class="participants-order" id="participants_order_desc_<?php echo $wid?>" name="participants_order_<?php echo $wid?>" type="radio" value="DESC" data-label="Descendente">
                                <span aria-hidden="true" class="icon icon--radio-button-off icon--small"></span> Descendente
                            </label>
                        </div>
                    </div>

                </fieldset>
                
            </div>

            <div class="block-content">
                <ul class="list list--participants row">
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Laura" data-surname="Pujol Estela">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo" style="background-image:url('http://wp.local/wp-content/uploads/2021/03/lpujole.jpg')"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Laura Pujol Estela">Laura Pujol Estela</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Laura Pujol Estela"
                                        aria-label="Contacta con Laura Pujol Estela">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact" title="Visita Folio de Laura Pujol Estela"
                                        aria-label="Visita Laura Pujol Estela">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Marina" data-surname="Roda Moya">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo" style="background-image:url('http://wp.local/wp-content/uploads/2021/03/soclamina.jpg')"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Marina Roda Moya">Marina Roda Moya (2)</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Marina Roda Moya"
                                        aria-label="Contacta con Marina Roda Moya">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact" title="Visita Folio de Marina Roda Moya"
                                        aria-label="Visita Marina Roda Moya">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Juan Jose" data-surname="Pons López">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo" style="background-image:url('http://wp.local/wp-content/uploads/2021/03/jjpons.jpg')"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Juan Jose Pons López">Juan Jose Pons López (3)</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Juan Jose Pons López"
                                        aria-label="Contacta con Juan Jose Pons López">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact" title="Visita Folio de Juan Jose Pons López"
                                        aria-label="Visita Juan Jose Pons López">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Jordi" data-surname="Sanz Rios">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo" style="background-image:url('http://wp.local/wp-content/uploads/2021/03/jsanzri.jpg')"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Jordi Sanz Rios">Jordi Sanz Rios (1)</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Jordi Sanz Rios"
                                        aria-label="Contacta con Jordi Sanz Rios">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact" title="Visita Folio de Jordi Sanz Rios"
                                        aria-label="Visita Jordi Sanz Rios">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="jdreisbach" data-surname="">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo" style="background-image:url('http://wp.local/wp-content/uploads/2021/03/jdreisbach.jpg')"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de jdreisbach">jdreisbach</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con jdreisbach"
                                        aria-label="Contacta con jdreisbach">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de jdreisbach" aria-label="Visita jdreisbach">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Oriol" data-surname="Sardà Sanabra">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Oriol Sardà Sanabra">Oriol Sardà Sanabra</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Oriol Sardà Sanabra"
                                        aria-label="Contacta con Oriol Sardà Sanabra">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Oriol Sardà Sanabra" aria-label="Visita Oriol Sardà Sanabra">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Andreu" data-surname="Abad López">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Andreu Abad López">Andreu Abad López</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Andreu Abad López"
                                        aria-label="Contacta con Andreu Abad López">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Andreu Abad López" aria-label="Visita Andreu Abad López">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Elvira" data-surname="Abaurrea Ruiz">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Elvira Abaurrea Ruiz">Elvira Abaurrea Ruiz</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Elvira Abaurrea Ruiz"
                                        aria-label="Contacta con Elvira Abaurrea Ruiz">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Elvira Abaurrea Ruiz" aria-label="Visita Elvira Abaurrea Ruiz">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Cristina" data-surname="Alcoba Corominas">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Cristina Alcoba Corominas">Cristina Alcoba Corominas</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Cristina Alcoba Corominas"
                                        aria-label="Contacta con Cristina Alcoba Corominas">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Cristina Alcoba Corominas" aria-label="Visita Cristina Alcoba Corominas">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Laia" data-surname="Arnó Blasi">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Laia Arnó Blasi">Laia Arnó Blasi</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Laia Arnó Blasi"
                                        aria-label="Contacta con Laia Arnó Blasi">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Laia Arnó Blasi" aria-label="Visita Laia Arnó Blasi">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Andrea" data-surname="Arroyo Gomez">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Andrea Arroyo Gomez">Andrea Arroyo Gomez</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Andrea Arroyo Gomez"
                                        aria-label="Contacta con Andrea Arroyo Gomez">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Andrea Arroyo Gomez" aria-label="Visita Andrea Arroyo Gomez">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Paula" data-surname="Balcells Falgueras">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Paula Balcells Falgueras">Paula Balcells Falgueras</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Paula Balcells Falgueras"
                                        aria-label="Contacta con Paula Balcells Falgueras">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Paula Balcells Falgueras" aria-label="Visita Paula Balcells Falgueras">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Francisco Javier" data-surname="Balderas Cejudo">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Francisco Javier Balderas Cejudo">Francisco Javier Balderas Cejudo</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Francisco Javier Balderas Cejudo"
                                        aria-label="Contacta con Francisco Javier Balderas Cejudo"><span
                                            class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Francisco Javier Balderas Cejudo" aria-label="Visita Francisco Javier Balderas Cejudo">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Josep" data-surname="Balliu Rodríguez">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Josep Balliu Rodríguez">Josep Balliu Rodríguez</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Josep Balliu Rodríguez"
                                        aria-label="Contacta con Josep Balliu Rodríguez">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Josep Balliu Rodríguez" aria-label="Visita Josep Balliu Rodríguez">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Gloria" data-surname="Barea Egea">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Gloria Barea Egea">Gloria Barea Egea</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Gloria Barea Egea"
                                        aria-label="Contacta con Gloria Barea Egea">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Gloria Barea Egea" aria-label="Visita Gloria Barea Egea">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Carla" data-surname="Bastús Ruiz">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Carla Bastús Ruiz">Carla Bastús Ruiz</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Carla Bastús Ruiz"
                                        aria-label="Contacta con Carla Bastús Ruiz">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Carla Bastús Ruiz" aria-label="Visita Carla Bastús Ruiz">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Gillem Ignasi" data-surname="Bauzà Cabot">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Guillem Ignasi Bauzà Cabot">Guillem Ignasi Bauzà Cabot</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Guillem Ignasi Bauzà Cabot"
                                        aria-label="Contacta con Guillem Ignasi Bauzà Cabot">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Guillem Ignasi Bauzà Cabot" aria-label="Visita Guillem Ignasi Bauzà Cabot">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Georgina" data-surname="Belles Cuella">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Georgina Belles Cuella">Georgina Belles Cuella</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Georgina Belles Cuella"
                                        aria-label="Contacta con Georgina Belles Cuella">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Georgina Belles Cuella" aria-label="Visita Georgina Belles Cuella">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Miquel" data-surname="Boneu Molina">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Miquel Boneu Molina">Miquel Boneu Molina</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Miquel Boneu Molina"
                                        aria-label="Contacta con Miquel Boneu Molina">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Miquel Boneu Molina" aria-label="Visita Miquel Boneu Molina">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Roger" data-surname="Borniquel Villagrasa">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Roger Borniquel Villagrasa">Roger Borniquel Villagrasa</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Roger Borniquel Villagrasa"
                                        aria-label="Contacta con Roger Borniquel Villagrasa">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Roger Borniquel Villagrasa" aria-label="Visita Roger Borniquel Villagrasa">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Albert" data-surname="Borràs Civil">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Albert Borràs Civil">Albert Borràs Civil</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Albert Borràs Civil"
                                        aria-label="Contacta con Albert Borràs Civil">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Albert Borràs Civil" aria-label="Visita Albert Borràs Civil">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Albert" data-surname="Bou Pinar">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Albert Bou Pinar">Albert Bou Pinar</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Albert Bou Pinar"
                                        aria-label="Contacta con Albert Bou Pinar">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Albert Bou Pinar" aria-label="Visita Albert Bou Pinar">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Ignasi" data-surname="Boza Palacín">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Ignasi Boza Palacín">Ignasi Boza Palacín</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Ignasi Boza Palacín"
                                        aria-label="Contacta con Ignasi Boza Palacín">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Ignasi Boza Palacín" aria-label="Visita Ignasi Boza Palacín">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Mònica" data-surname="Busquets Renart">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Mònica Busquets Renart">Mònica Busquets Renart</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Mònica Busquets Renart"
                                        aria-label="Contacta con Mònica Busquets Renart">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Mònica Busquets Renart" aria-label="Visita Mònica Busquets Renart">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="M. Montserrat" data-surname="Butxaca Fernández">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de M. Montserrat Butxaca Fernández">M. Montserrat Butxaca Fernández</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a hred="#" target="_blank" class="lnk-contact" title="Contacta con M. Montserrat Butxaca Fernández"
                                        aria-label="Contacta con M. Montserrat Butxaca Fernández">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de M. Montserrat Butxaca Fernández" aria-label="Visita M. Montserrat Butxaca Fernández">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Eva" data-surname="Cano Chinchilla">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Eva Cano Chinchilla">Eva Cano Chinchilla</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Eva Cano Chinchilla"
                                        aria-label="Contacta con Eva Cano Chinchilla">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Eva Cano Chinchilla" aria-label="Visita Eva Cano Chinchilla">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Claudia" data-surname="Canovas Mañas">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Claudia Canovas Mañas">Claudia Canovas Mañas</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Claudia Canovas Mañas"
                                        aria-label="Contacta con Claudia Canovas Mañas">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Claudia Canovas Mañas" aria-label="Visita Claudia Canovas Mañas">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Monica" data-surname="Cantalejo Gomez">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Monica Cantalejo Gomez">Monica Cantalejo Gomez</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Monica Cantalejo Gomez"
                                        aria-label="Contacta con Monica Cantalejo Gomez">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Monica Cantalejo Gomez" aria-label="Visita Monica Cantalejo Gomez">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Estel" data-surname="Capdevila Blanquera">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Estel Capdevila Blanquera">Estel Capdevila Blanquera</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Estel Capdevila Blanquera"
                                        aria-label="Contacta con Estel Capdevila Blanquera">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Estel Capdevila Blanquera" aria-label="Visita Estel Capdevila Blanquera">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Gerard" data-surname="Carreras Catala">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Gerard Carreras Catala">Gerard Carreras Catala</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Gerard Carreras Catala"
                                        aria-label="Contacta con Gerard Carreras Catala">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Gerard Carreras Catala" aria-label="Visita Gerard Carreras Catala">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Azahara" data-surname="Carreras León">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Azahara Carreras León">Azahara Carreras León</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Azahara Carreras León"
                                        aria-label="Contacta con Azahara Carreras León">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Azahara Carreras León" aria-label="Visita Azahara Carreras León">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Annia" data-surname="Casals Rodríguez">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Annia Casals Rodríguez">Annia Casals Rodríguez</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Annia Casals Rodríguez"
                                        aria-label="Contacta con Annia Casals Rodríguez">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Annia Casals Rodríguez" aria-label="Visita Annia Casals Rodríguez">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Eric" data-surname="Cid Menjibar">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Eric Cid Menjibar">Eric Cid Menjibar</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Eric Cid Menjibar"
                                        aria-label="Contacta con Eric Cid Menjibar">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Eric Cid Menjibar" aria-label="Visita Eric Cid Menjibar">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Esteve" data-surname="Cirerol Aguilar">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Esteve Cirerol Aguilar">Esteve Cirerol Aguilar</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Esteve Cirerol Aguilar"
                                        aria-label="Contacta con Esteve Cirerol Aguilar">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Esteve Cirerol Aguilar" aria-label="Visita Esteve Cirerol Aguilar">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Carme" data-surname="Conesa Escarre">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Carme Conesa Escarre">Carme Conesa Escarre</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Carme Conesa Escarre"
                                        aria-label="Contacta con Carme Conesa Escarre">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Carme Conesa Escarre" aria-label="Visita Carme Conesa Escarre">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Nil" data-surname="Costa Rengel">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Nil Costa Rengel">Nil Costa Rengel</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Nil Costa Rengel"
                                        aria-label="Contacta con Nil Costa Rengel">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Nil Costa Rengel" aria-label="Visita Nil Costa Rengel">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Yvonne" data-surname="Cox Ballester">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Yvonne Cox Ballester">Yvonne Cox Ballester</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Yvonne Cox Ballester"
                                        aria-label="Contacta con Yvonne Cox Ballester">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Yvonne Cox Ballester" aria-label="Visita Yvonne Cox Ballester">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Marta" data-surname="Cuscó Valls">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Marta Cuscó Valls">Marta Cuscó Valls</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Marta Cuscó Valls"
                                        aria-label="Contacta con Marta Cuscó Valls">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Marta Cuscó Valls" aria-label="Visita Marta Cuscó Valls">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Paula" data-surname="Danés Ramió">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Paula Danés Ramió">Paula Danés Ramió</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Paula Danés Ramió"
                                        aria-label="Contacta con Paula Danés Ramió">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Paula Danés Ramió" aria-label="Visita Paula Danés Ramió">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Vicente" data-surname="Domingo Sanchis">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Vicente Domingo Sanchis">Vicente Domingo Sanchis</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Vicente Domingo Sanchis"
                                        aria-label="Contacta con Vicente Domingo Sanchis">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Vicente Domingo Sanchis" aria-label="Visita Vicente Domingo Sanchis">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Natàlia" data-surname="Espelta Morral">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Natàlia Espelta Morral">Natàlia Espelta Morral</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Natàlia Espelta Morral"
                                        aria-label="Contacta con Natàlia Espelta Morral">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Natàlia Espelta Morral" aria-label="Visita Natàlia Espelta Morral">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Daniel" data-surname="Fernandez Cuenca">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Daniel Fernandez Cuenca">Daniel Fernandez Cuenca</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Daniel Fernandez Cuenca"
                                        aria-label="Contacta con Daniel Fernandez Cuenca">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Daniel Fernandez Cuenca" aria-label="Visita Daniel Fernandez Cuenca">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Josep Xavier" data-surname="Fernandez Gascon">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Josep Xavier Fernandez Gascon">Josep Xavier Fernandez Gascon</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Josep Xavier Fernandez Gascon"
                                        aria-label="Contacta con Josep Xavier Fernandez Gascon">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Josep Xavier Fernandez Gascon" aria-label="Visita Josep Xavier Fernandez Gascon">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Cristina" data-surname="Fernandez Jimenez">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Cristina Fernandez Jimenez">Cristina Fernandez Jimenez</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Cristina Fernandez Jimenez"
                                        aria-label="Contacta con Cristina Fernandez Jimenez">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Cristina Fernandez Jimenez" aria-label="Visita Cristina Fernandez Jimenez">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Maria del Carmen" data-surname="Fernández Bueno">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Maria del Carmen Fernández Bueno">Maria del Carmen Fernández Bueno</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Maria del Carmen Fernández Bueno"
                                        aria-label="Contacta con Maria del Carmen Fernández Bueno"><span
                                            class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Maria del Carmen Fernández Bueno" aria-label="Visita Maria del Carmen Fernández Bueno">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Mar" data-surname="Fibla Capilla">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Mar Fibla Capilla">Mar Fibla Capilla</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Mar Fibla Capilla"
                                        aria-label="Contacta con Mar Fibla Capilla">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Mar Fibla Capilla" aria-label="Visita Mar Fibla Capilla">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Pau" data-surname="Font Manzano">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Pau Font Manzano">Pau Font Manzano</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Pau Font Manzano"
                                        aria-label="Contacta con Pau Font Manzano">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Pau Font Manzano" aria-label="Visita Pau Font Manzano">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Maria" data-surname="Font Sabaté">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Marta Font Sabaté">Marta Font Sabaté</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Marta Font Sabaté"
                                        aria-label="Contacta con Marta Font Sabaté">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Marta Font Sabaté" aria-label="Visita Marta Font Sabaté">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Estefania" data-surname="Gallardo Perez">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Estefania Gallardo Perez">Estefania Gallardo Perez</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Estefania Gallardo Perez"
                                        aria-label="Contacta con Estefania Gallardo Perez">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Estefania Gallardo Perez" aria-label="Visita Estefania Gallardo Perez">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Raul" data-surname="Garcia Castilla">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Raul Garcia Castilla">Raul Garcia Castilla</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Raul Garcia Castilla"
                                        aria-label="Contacta con Raul Garcia Castilla">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Raul Garcia Castilla" aria-label="Visita Raul Garcia Castilla">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Lola" data-surname="Garcia Tàpias">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Lola Garcia Tàpias">Lola Garcia Tàpias</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Lola Garcia Tàpias"
                                        aria-label="Contacta con Lola Garcia Tàpias">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Lola Garcia Tàpias" aria-label="Visita Lola Garcia Tàpias">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Helena" data-surname="Garcia del Pino">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Helena Garcia del Pino">Helena Garcia del Pino</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Helena Garcia del Pino"
                                        aria-label="Contacta con Helena Garcia del Pino">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Helena Garcia del Pino" aria-label="Visita Helena Garcia del Pino">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Alba" data-surname="Garrido Martínez">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Alba Garrido Martínez">Alba Garrido Martínez</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Alba Garrido Martínez"
                                        aria-label="Contacta con Alba Garrido Martínez">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Alba Garrido Martínez" aria-label="Visita Alba Garrido Martínez">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Montserrat" data-surname="Gerez Esteban">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Montserrat Gerez Esteban">Montserrat Gerez Esteban</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Montserrat Gerez Esteban"
                                        aria-label="Contacta con Montserrat Gerez Esteban">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Montserrat Gerez Esteban" aria-label="Visita Montserrat Gerez Esteban">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Artur" data-surname="Golart Martinez">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Artur Golart Martinez">Artur Golart Martinez</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Artur Golart Martinez"
                                        aria-label="Contacta con Artur Golart Martinez">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Artur Golart Martinez" aria-label="Visita Artur Golart Martinez">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="col-md-4 col-lg-3" role="presentation" data-name="Elena" data-surname="Gonzalez Oviedo">
                        <div class="media media--profile">
                            <div class="media__left">
                                <span class="media__thumb photo"></span>
                            </div>
                            <div class="media__body details d-flex d-md-block align-items-center">
                                <div class="user_folio_widget">
                                    <a href="#" class="user_folio" title="Ver perfil de Elena Gonzalez Oviedo">Elena Gonzalez Oviedo</a>
                                </div>
                                <div class="user_folio_actions d-flex d-md-block">
                                    <a href="#" target="_blank" class="lnk-contact" title="Contacta con Elena Gonzalez Oviedo"
                                        aria-label="Contacta con Elena Gonzalez Oviedo">
                                        <span class="icon icon--send-mail icon--small" aria-hidden="true"></span><span class="lbl">Contactar</span>
                                    </a>
                                    <a href="#" target="_self" class="lnk-contact"
                                        title="Visita Folio de Elena Gonzalez Oviedo" aria-label="Visita Elena Gonzalez Oviedo">
                                        <span class="icon icon--user icon--small" aria-hidden="true"></span><span class="lbl">Visita Folio</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <?php

        echo $args['after_widget'];
    }

    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }else {
            $title = 'Participants DEMO';
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <?php 
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }
     
} 
     
class Demo_Agora_Actifolio_Widget extends \WP_Widget {
  
    function __construct() {
        parent::__construct(
            'demo_agora_actifolio_widget', 
            'ActiFolio DEMO', 
            array( 'description' => 'DEMO Widget Àgora ActiFolio') 
        );
    }

    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );

        echo $args['before_widget'];

        if ( ! empty( $title ) )
            echo $args['before_title'] . $title . $args['after_title'];
        ?>
        <div class="block">
          <ul class="list list--menu list--actifolio row" id="actiUOCWidget">
              <li class="col-md-6"><a href="#">Introducció) Presentació de Folio i l'Àgora (2)</a></li>
              <li class="col-md-6"><a href="#">Activitat 1) Visitar l'Àgora (1)</a></li>
              <li class="col-md-6"><a href="#">Activitat 2) Personalitzar el teu espai Folio (7)</a></li>
              <li class="col-md-6"><a href="#">Activitat 3) La teva primera entrada i els permisos (12)</a></li>
              <li class="col-md-6"><a href="#">Activitat 4) Pujar imatges, vídeos, pdf... (7)</a></li>
              <li class="col-md-6"><a href="#">Activitat 5) Usar la teva webcam per a presentar! (1)</a></li>
              <li class="col-md-6"><a href="#">Activitat 6) Comentar en les publicacions (1)</a></li>
              <li class="col-md-6"><a href="#">Activitat 7) Crear una pàgina i entendre els permisos de visibilitat (1)</a></li>
          </ul>
        </div>
        <?php
        echo $args['after_widget'];
    }

    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        } else {
            $title = 'ActiFolio DEMO';
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <?php 
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }
     
} 
     
function load_demo_widgets() {
    register_widget( __NAMESPACE__ . '\\Demo_Agora_Participans_Widget' );
    register_widget( __NAMESPACE__ . '\\Demo_Agora_Actifolio_Widget' );
}

add_action( 'widgets_init', __NAMESPACE__ . '\\load_demo_widgets' );


/* AJAX ACTIONS */

function set_portfolio_uoc_rac_grade_demo() {
    $id = isset( $_POST['id'] ) ? $_POST['id'] : false;
    if ( rand(0, 1) ){
        wp_send_json_success( [
            'id'       => $id,
            'grade'    => [
                'id'            => $id,
                'filename'      => 'Nom-de-l-arxiu-adjunt.pdf',
                'grade'         => 'C+',
                'publish_grade' => rand(0, 1) ? 'now' : 'scheduled',
            ],
            'feedback' => 'Fake feedback DEMO phasellus tempus. Etiam iaculis nunc ac metus. In hac habitasse platea dictumst. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Suspendisse potenti.'
        ] );
    }else{
        wp_send_json_error([
            'error'   => 'unknown_message',
            'message' => 'Fake error DEMO lorem ipsum dolor sit amet'
        ]);
    }
}
add_action( 'wp_ajax_portfolio_uoc_rac_set_grade_demo', __NAMESPACE__ . '\\set_portfolio_uoc_rac_grade_demo' );


function get_portfolio_uoc_rac_get_feedbacks_and_grade_demo() {
    $id = isset( $_GET['id'] ) ? $_GET['id'] : false;
    $grade = [
        'id'            => $id . '_grade',
        'filename'      => 'Nom-de-l-arxiu-adjunt.pdf',
        'grade'         => 'C+',
        'publish_grade' => rand(0, 1) ? 'now' : 'scheduled',
    ];
    $feedback = [
        'id'        => $id . '_feedback',
        'title'     => 'Feedback title?',
        'text'      => 'Fake feedback DEMO phasellus tempus. Etiam iaculis nunc ac metus. In hac habitasse platea dictumst. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Suspendisse potenti.',
        'userId'    => 0,
        'isTeacher' => true
    ];
    if ( rand(0, 100) ){
        wp_send_json_success( [ 'grade' => $grade, 'feedback' => $feedback ] );
    }else{
        wp_send_json_error([
            'error'   => 'unknown_message',
            'message' => 'Fake error DEMO lorem ipsum dolor sit amet'
        ]);
    }
}
add_action( 'wp_ajax_portfolio_uoc_rac_get_feedbacks_and_grade_demo', __NAMESPACE__ . '\\get_portfolio_uoc_rac_get_feedbacks_and_grade_demo' );



/* ADMINBAR */

/**
 * Add Folio to adminbar 
 */
function folio_multiaccess_folio_options($wp_admin_bar) {

    $title = '<span class="folio-ab-icon" aria-hidden="true"></span><span class="folio-ab-label"> ' . __( 'Mi Folio', 'folio-multi-access' ) . '</span>';

    $wp_admin_bar->remove_menu('folio_site_url_info');
    $wp_admin_bar->add_menu(
        array(
            'id'    => 'folio_site_url_info',
            'title' => $title,
            'href'  => is_multisite() ? network_home_url() : home_url(),
            'meta'  => array(
                'class' => 'folio-ab-item',
                'target' => '_blank', // Opens the link with a new tab.
            ),
        )
    );
}
add_action('admin_bar_menu', __NAMESPACE__ . '\\folio_multiaccess_folio_options', 20);


/**
 * Add Folio to adminbar 
 */
function folio_multiaccess_folio_publications($wp_admin_bar) {
    $wp_admin_bar->remove_menu('folio_post_admin_bar-private');
    $wp_admin_bar->remove_menu('folio_post_admin_bar-public');

    $count_total = 150; 
    $count_display = '+150';

    $count_visible = 90;
    $count_invisible = 125;

    $label_info =  __('Why are there "not visible" posts?', 'folio-multi-access');
    $label_publications = sprintf( _n( 'Publication', 'Publications', $count_total, 'folio-multi-access' ) );

    /* translators: %s: number of visible publications */
    $label_visible = sprintf( _n( '%s visible', '%s visible', $count_visible, 'folio-multi-access' ), number_format_i18n( $count_visible ) );

    /* translators: %s: number of invisible publications */
    $label_invisible = sprintf( _n( '%s not visible', '%s not visible', $count_invisible, 'folio-multi-access' ), number_format_i18n( $count_invisible ) );

    

    // Primer nivel 

	$wp_admin_bar->add_menu(
		array(
			'id'     => 'folio_site_publications',
			'title'  => sprintf( '<span class="folio-ab-badge">%s</span><strong class="folio-ab-label"> %s</strong>', $count_display, $label_publications ),
			'meta'   => array(
				'class' => 'folio-ab-item'
			),
			//'parent' => 'top-secondary',
		)
	);

    // Segundo nivel

    $wp_admin_bar->add_node([
        'id' => 'folio_site_publications_visible',
        'title' => sprintf( '<span class="folio-ab-wrapper"><span class="ab-icon ab-subitem-icon dashicons dashicons-visibility"></span> %s</span>',  $label_visible ),
        'parent' => 'folio_site_publications',
        'meta'  => array(
            'class' => 'folio-ab-subitem',
        ),
    ]);

    $wp_admin_bar->add_node([
        'id' => 'folio_site_publications_invisible',
        'title' => sprintf( '<span class="folio-ab-wrapper"><span class="ab-icon ab-subitem-icon dashicons dashicons-hidden"></span> %s</span>',  $label_invisible ),
        'parent' => 'folio_site_publications',
        'meta'  => array(
            'class' => 'folio-ab-subitem'
        ),
    ]);

    

    $wp_admin_bar->add_node([
        'id' => 'folio_site_publications_info',
        'title' => sprintf( '<span class="folio-ab-wrapper"><span class="ab-icon ab-subitem-icon dashicons dashicons-info-outline"></span> %s</span>', $label_info ),
        'parent' => 'folio_site_publications',
        'href'  => is_multisite() ? network_home_url() : home_url(),
        'meta'  => array(
            'class' => 'folio-ab-subitem folio-ab-info',
            'target' => '_blank', // Opens the link with a new tab.
        ),
    ]);

    // Tercer nivel


    $wp_admin_bar->add_node([
        'id' => 'folio_site_publications_visible_detail',
        'title' => '12 publicos<br>68 campus<br>10 aula',
        'parent' => 'folio_site_publications_visible'
    ]);

    $wp_admin_bar->add_node([
        'id' => 'folio_site_publications_invisible_detail',
        'title' => '75 privados<br>50 campus',
        'parent' => 'folio_site_publications_invisible'
    ]);

}
add_action('admin_bar_menu', __NAMESPACE__ . '\\folio_multiaccess_folio_publications', 99);


/**
 * Remove some adminbar items in front
 */
function remove_adminbar_options($wp_admin_bar) {
    if (! is_admin() ) {
        //$wp_admin_bar->remove_node('wp-logo');
        $wp_admin_bar->remove_node('customize');
        $wp_admin_bar->remove_node('my-sites');
        $wp_admin_bar->remove_node('comments');
        $wp_admin_bar->remove_node('updates');
        $wp_admin_bar->remove_node('new-content');
    }
}
add_action('admin_bar_menu', __NAMESPACE__ . '\\remove_adminbar_options', 999);


/**
 * Show admin bar
 */
add_filter('show_admin_bar', '__return_true', 1000);
