/**
 * Main Agora Folio Application Script
 */


/**
 * Boostrap dependencies
 * NOTE: Popover, dropdowns and tooltip require popper and util modules. Popovers also require tooltip
 */
import 'popper.js';
//import 'bootstrap';
import 'bootstrap/js/dist/util';
import 'bootstrap/js/dist/alert';
//import 'bootstrap/js/dist/button';
import 'bootstrap/js/dist/collapse';
import 'bootstrap/js/dist/dropdown';
import 'bootstrap/js/dist/modal';
//import 'bootstrap/js/dist/popover';
//import 'bootstrap/js/dist/scrollspy';
//import 'bootstrap/js/dist/tab';
//import 'bootstrap/js/dist/toast';
import 'bootstrap/js/dist/tooltip';


/**
 * Another Dependencies
 */
import Cookies from 'js-cookie';                    // manage cookies
import objectFitImages from 'object-fit-images';    // object-fit polyfill
import shave from 'shave';

/**
 * App modules
 */
import { debounce, isMobile, goTo, replaceUrlParam } from './modules/utils.js';
import { setupWidgets } from './modules/widgets.js';
//import { setupTree } from './modules/tree.js';



(function ($, themeData) {

  'use strict';

  // Expose jquery to modules
  window.jQuery = $;
  window.$ = $;

  // Aux constants
  const $body = $('body');
  const $win = $(window);
  const $doc = $(document);
  const $goup = $('.sticky-scroll');
  const breakpoint = 768;
  const isSingle = $body.hasClass('single');

  const SINGLE_VIEW = 'single';
  const GRID_VIEW = 'grid';
  const LIST_VIEW = 'list';
  const FULL_VIEW = 'full';
  const TREE_VIEW = 'tree';
  const COMM_VIEW = 'comm';

  const DIR_NEW = 'newest';
  const DIR_OLD = 'oldest';

  // Aux variables
  let ww = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
  let currentView = '';

  /**
   * On resize event handler (debounced)
   */
  const onResize = debounce(() => {
    ww = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
    if (ww > breakpoint) {
      $body.removeClass('device-sm');
    } else {
      $body.addClass('device-sm');
    }
    truncate()

    $(".img-cover.fade.show").each(function () {
      fitThumb(this);
    });

  }, 50, false);


  /**
   * On scroll event handler (debounced)
   */
  const onScroll = debounce(() => {
    if ($win.scrollTop() > 340) {
      $goup.removeClass('off');
    } else {
      $goup.addClass('off');
    }
  }, 100, true)


  /**
   * Append external icon to item
   * @param {object} item dom element
   */
  const appendExternalIcon = function (item) {
    var $item = $(item);
    if (!$item.find('.icon--external-link').length) {
      $item.append(`<span aria-hidden="true" class="icon icon--small icon--external-link"></span><span class="icon-alt">${themeData.t.externalLink}</span>`);
    }
  }

  /**
   * Sum fixed elements to offset
   */
  const getOffset = function (offset) {
    const $header = $('.site-header');
    const $menu = $('.site-menu');
    offset = offset || 0;

    if ($header.length) {
      offset += $header.height();
    }

    if ($menu.length && !$body.hasClass('device-sm')) {
      offset += $menu.height();
    }

    if ($('body').hasClass('admin-bar')) {
      offset += $('#wpadminbar').height();
    }

    return offset;
  }

  /**
   * Truncate texts
   */
  const truncate = function () {
    const $truncate = $('.truncate');
    $truncate.each(function () {
      const $this = $(this);

      if (!$this.data('text')) {
        $this.data('text', this.textContent);
      }

      if (!$this.data('height')) {
        $this.data('height', $this.height())
      }

      const t = $this.data('text');
      this.textContent = t;

      shave(this, $this.data('height'));

      if ($this.find('.js-shave').length) {
        $this.attr('title', t);
      } else {
        $this.removeAttr('title');
      }

      if ($this.attr('target') === '_blank') {
        appendExternalIcon(this);
      }

      if ($this.data('mega-indicator') && !$this.find('.mega-indicator').length) {
        $this.append($this.data('mega-indicator'));
      }

    })
  }


  /**
   * Setup main menu
   */
  const setupMenu = function () {

    // Megamenu accessibility
    if (themeData.megamenu === '1') {
      $('.mega-menu-wrap').each(function () {
        var $this = $(this);
        var $menu = $this.find('.mega-menu');
        var $toggle = $this.find('.mega-menu-toggle button');

        if ($menu.length && $toggle.length) {
          var cls = '';
          $toggle.attr('aria-controls', $menu.attr('id'));
          if ($menu.data('effect-mobile') == 'slide_left') cls = 'slide-left';
          if ($menu.data('effect-mobile') == 'slide_right') cls = 'slide-right';
          if (cls !== '') {
            $this.append(`<button class="btn btn-menu-close ${cls}" type="button" aria-controls="${$menu.attr('id')}" aria-label="${themeData.t.closeMenu}"><span class="icon icon--close" aria-hidden="true"></span></button>`);
          }
        }
      });

      $("ul#mega-menu-primary-menu").on("mmm:showMobileMenu", function () {
        $(this).parent().find('.btn-menu-close').addClass('open');
      });

      $("ul#mega-menu-primary-menu").on("mmm:hideMobileMenu", function () {
        $(this).parent().find('.btn-menu-close').removeClass('open');
      });
    }

    // Truncate items
    const $truncate = $('.site-menu ul.navbar-nav > li > a.nav-link, .site-menu .mega-menu > .mega-menu-item > .mega-menu-link');
    $truncate.addClass('truncate');
    $truncate.each(function () {
      const $this = $(this);
      const t = this.textContent;
      $this.data('text', t).data('height', 68).attr('aria-label', t);
      if ($this.find('.mega-indicator').length) $this.data('mega-indicator', $this.find('.mega-indicator'));
    })

    // Add External links
    const $external = $('.site-menu ul.navbar-nav a[target=_blank], .site-menu .mega-menu-link[target=_blank], .site-menu .list--menu a[target=_blank]');
    $external.each(function () {
      appendExternalIcon(this);
    })

  }

  /**
   * Setup agora sort forms
   */
  const setupSort = function () {

    $doc.on('click', '.dropdown-sort .dropdown-menu', function (e) {
      e.stopPropagation();
    });

    $doc.on('change', '.dropdown-sort input[type="radio"]', function (e) {
      $(this).closest('.form-sort').trigger('submit');
      setTimeout(function(){
        $('.dropdown-sort .dropdown-toggle').dropdown('hide');
      }, 100);
    });

    $doc.on('hide.bs.dropdown', '.dropdown-sort', function () {
      $(this).find('.form-sort').trigger('submit');
    });

    $doc.on('click', '.btn-modal-sort', function () {
      const $modal = $(this).closest('.modal');
      $modal.modal('hide');
      $modal.find('.form-sort').trigger('submit');
    });

    $doc.on('click', '.dropdown-sort .btn--order', function (e) {
      const $this = $(this);
      const $form = $this.parent().find('.form-sort-agoras');
      const _order = $form.data('order') === 'DESC' ? 'ASC' : 'DESC';
      $form.find('input[name="order"]').val(_order);
      $form.trigger('submit');
    });

    $doc.on('submit', '.form-sort-agoras', function (e) {
      const $this = $(this);
      if($this.find('input.agoras_order').length){
        if ($this.data('orderby') === $this.find('input[name="orderby"]:checked').val() && $this.data('order') === $this.find('input[name="order"]').val()) {
          e.preventDefault();
        }
      }else{
        if ($this.data('orderby') === $this.find('input[name="orderby"]:checked').val() && $this.data('order') === $this.find('input[name="order"]:checked').val()) {
          e.preventDefault();
        }
      }
    });

  }

  /**
   * 
   * @param {object} e event
   * @param {object} $anchor  collapse jquery anchor
   */
  const scrollToArea = function (e, $anchor, offset) {
    offset = offset || 0;
    const $collapse = $anchor.closest('.entry-article').find('.entry-collapse');
    if ($collapse.length) {
      e.preventDefault();
      const delay = $collapse.hasClass('show') ? 0 : 500;
      $collapse.collapse('show');
      if ($anchor.length) {
        setTimeout(function () {
          goTo($anchor[0], 'smooth', offset, function () {
            const x = window.scrollX, y = window.scrollY;
            $anchor.parent()[0].focus();
            if (isSingle) window.location.hash = $anchor.attr('name');
            window.scrollTo(x, y);
          });
        }, delay);
      }
    } else if ($anchor.length) {
      e.preventDefault();
      goTo($anchor[0], 'smooth', offset, function () {
        const x = window.scrollX, y = window.scrollY;
        $anchor.parent()[0].focus();
        if (isSingle) window.location.hash = $anchor.attr('name');
        window.scrollTo(x, y);
      });
    }
  };


  /**
   * Setup agora view modes
   */
  const setupView = function () {

    if (!$('.nav-actions').length || $('.agora-view').data('view') === SINGLE_VIEW) {
      return false;
    }

    const $collapsible = $('.entry-collapse');

    $collapsible.on('show.bs.collapse', function () {
      $(this).parent().addClass('expanded');
      if (themeData.listAjax === '1') {
        loadContent($(this));
      }
    })

    $collapsible.on('hide.bs.collapse', function () {
      $(this).parent().removeClass('expanded');
    })

    const view = $('.js-change-agora-view.active').data('view') || Cookies.get('agora-view', view) || GRID_VIEW;
    setView(view);

    $doc.on('click', '.js-change-agora-view', function (e) {
      const view = $(this).data('view') || GRID_VIEW;
      if (currentView !== TREE_VIEW && view !== TREE_VIEW && currentView !== COMM_VIEW && view !== COMM_VIEW ) {
        e.preventDefault();
        setView(view);
        replaceUrlParam(window.location.href, 'view', view);
        // This is to add this information on datamart
        $.post(themeData.ajaxurl, {
          _ajax_nonce: themeData.nonce,
          action: "change_agora_view",
          view: view
        })
      }
    });

  }


  /**
   * Set agora view mode
   * @param {string} view view mode
   */
  const setView = function (view) {

    view = view === FULL_VIEW ? LIST_VIEW : view;

    currentView = view;

    $('.js-change-agora-view.active').removeClass('active').removeAttr('aria-current');
    $(`.js-change-agora-view[data-view=${view}]`).addClass('active').attr('aria-current', true);
    $('.agora-view.view-row').attr('data-view', view);

    const $collapsible = $('.entry-collapse');

    if (view === LIST_VIEW) {
      $collapsible.collapse('show');
    } else {
      $collapsible.collapse('hide');
    }

    if (themeData.cookies === '1') {
      Cookies.set('agora-view', view, { expires: 7 });
    } else {
      Cookies.set('agora-view', view);
    }

  }

  /**
   * Reset tinymce comment editor if enabled
   */
  const resetCommentEditor = function (){
    if (typeof (tinyMCE) !== 'undefined') {
      const editor = tinymce.get('comment');
      const editor_switch = typeof (window.switchEditors) !== 'undefied' && typeof (window.switchEditors.go) !== 'undefined';
      const editor_hidden = editor && editor_switch && editor.isHidden();
      if (editor){
        $('textarea#comment').height(editor.settings.height || 240);
        if(editor_switch && editor_hidden){
          window.switchEditors.go('comment','tmce'); 
        }
        tinymce.EditorManager.execCommand('mceRemoveEditor', true, 'comment');
        tinymce.EditorManager.execCommand('mceAddEditor', true, 'comment'); 
      }
    }
  }

  /**
   * Setup generic events
   */
  const setupEvents = function () {

    // Resize event
    $win.on('resize', function () {
      onResize();
    });

    // Scroll event
    $win.on('scroll', function () {
      onScroll();
    });

    // Go to top scroll
    $goup.on('click', function () {
      window.scrollTo({ top: 0, behavior: 'smooth' });
      return false;
    });

    // Debate
    $doc.on('click', '.btn--debate', function (e) {
      if (currentView !== GRID_VIEW && (isSingle || themeData.listComments === '1')) {
        e.preventDefault();
        const $this = $(this);
        const $anchor = $this.closest('.entry-article').find('.entry-comments > .anchor');
        scrollToArea(e, $anchor, 100);
        if($this.hasClass('no-comments')){
            $this.closest('.entry-article').find('.btn-comment-list').trigger('click');
        }
      }
    });

    // Evaluation anchor link
    $doc.on('click', '.btn--evaluable', function (e) {
      if (currentView !== GRID_VIEW && currentView !== COMM_VIEW) {
        e.preventDefault();
        const $anchor = $(this).closest('.entry-article').find('.evaluation-area > .anchor');
        scrollToArea(e, $anchor, 100);
      }
    });

    // Manage comments form in lists if enabled or tree
    if (themeData.listComments === '1') {

      $doc.on('click', '.btn-comment-list', function (e) {
        e.preventDefault();

        const $this = $(this);
        const $parent = $this.parent();
        const $respond = $('#respond');
        const $reply = $respond.find('#reply-title');

        $respond.find('#comment_post_ID').val($this.data('id'));
        $respond.find('#comment_parent').val(0);
        if ($reply.length > 0) {
          $reply[0].firstChild.textContent = themeData.t.leaveReply;
        }
        $respond.find('#cancel-comment-reply-link').hide();
        $parent.find('#wp-temp-form-div').remove();
        $parent.prepend($respond);

        resetCommentEditor();

        const $elm = $respond.find('input:not(:hidden):not(:disabled), select:not(:hidden):not(:disabled), textarea:not(:hidden):not(:disabled)').first();
        if ($elm.length) $elm.trigger('focus');

        $(document).trigger( "folio-comment-access:reset" );

      });


      $doc.on('click', '.agora-view .view-col .load-more-comments-js', function (e) {
        e.preventDefault();
        var $this = $(this);
        if (!$this.hasClass('disabled')) {
          loadMoreComments($this);
        }
        return false;
      });


      // reposition comment form placeholder in comments lists
      if ( typeof addComment !== 'undefined' ) {

        addComment._agora_folio_theme_moveForm = addComment.moveForm;

        addComment.moveForm = function ( commId, parentId, respondId, postId ) {
            var returnValue = addComment._agora_folio_theme_moveForm( commId, parentId, respondId, postId );

            var $place = $('#post-' + postId + ' .entry-comment-list');
            if($place.length > 0){
              $('#wp-temp-form-div').prependTo($place);
            }

            return returnValue;
        };
      }


    }

    // Fetch all the forms we want to apply custom validation styles to
    $doc.on('submit', '.needs-validation', function (e) {
      if (!this.checkValidity()) {
        e.preventDefault();
        e.stopPropagation();
        const el = document.querySelector('.needs-validation :invalid');
        if (el) {
          goTo(el, 'smooth', getOffset(100), function () {
            el.focus();
          });
        }
      }
      $(this).addClass('was-validated');
    });


    // Tooltips
    $('[data-toggle="tooltip"]').tooltip({
      animated: 'fade'
    });

  }


  /**
   * Setup evaluation form
   */
  const setupEvaluation = function () {

    if (!$('.evaluation-area').length) return false;

    $doc.on('click', '.publish-grade-submit', function (e) {
      e.preventDefault();

      const $this = $(this);
      const id = $this.data('id');
      const activityId = $this.data('submissionid');
      const grade = $('.radio-options-inline-grade-' + id + ':checked').val();
      const feedback = evaluation_tinymce_get_content('evaluation-textarea-' + id);
      const visibility = $('.publish-grade-radio-' + id + ':checked').val();
      const result_holder = $('#result-uoc-rac-box-' + id);
      const ok_icon = '<span class="icon icon--checkmark icon--normal icon--after" aria-hidden="true"></span>';
      const ko_icon = '<span class="icon icon--alert icon--normal icon--after" aria-hidden="true"></span>';

      $this.attr("disabled", true);
      result_holder.show();
      result_holder.removeClass('alert--icon-before alert--icon-after alert--success-alternative alert--error-alternative');
      result_holder.html('<div class="loading">' + themeData.t.saving + '</div>');
      if (result_holder.length) {
        goTo(result_holder[0], 'smooth', getOffset(100), function () {
          result_holder[0].focus();
        });
      }

      $.ajax({
        type: 'POST',
        url: themeData.ajaxurl,
        data: {
          'action': themeData.setGradeAction,
          'id': activityId,
          'postid': id,
          'grade': grade,
          'feedback': feedback,
          'visibility': visibility
        },
        success: function (response) {
          if (response && 'undefined' !== typeof response) {
            if (response.success) {
              result_holder.html(ok_icon + themeData.t.success);
              result_holder.addClass('alert--icon-after alert--success-alternative');
              const $btn = $("#btn-evaluable-" + id);
              $btn.children('.lbl').text(themeData.t.evaluated);
              $btn.children('.grade').html(grade);
              $(".evaluation-status-" + id).text(themeData.t.evaluated);
              $this.closest('.evaluation-box').removeClass('pending').addClass('sent');
            } else {
              result_holder.addClass('alert--icon-after alert--error-alternative');
              result_holder.html(ko_icon + response.data.message);
            }
          } else {
            result_holder.addClass('alert--icon-after alert--error-alternative');
            result_holder.html(ko_icon + themeData.t.error_saving_grade);
          }
        }
      }).fail(function () {
        result_holder.addClass('alert--icon-after alert--error-alternative');
        result_holder.html(ko_icon + themeData.t.error_saving_grade);
      });

    });


    $doc.on('change', '.radio-grade-select', function () {
      const id = $(this).data('id');
      evaluation_enable_publish(id);
      evaluation_set_grade_select(id, $(this));
    });

    $doc.on('change', '.publish-grade-radio', function () {
      const id = $(this).data('id');
      evaluation_enable_publish(id);
      evaluation_show_help_information($(this).val(), id);
    });

    $doc.on('click', '.btn-delete-grade', function (e) {
      e.preventDefault();
      const id = $(this).data('id');
      $('.radio-options-inline-grade-' + id).prop("checked", false);
      evaluation_enable_publish(id);
      evaluation_set_grade_select(id, false);
    });


    $doc.on('click', '.btn--evaluate-agora', function () {
      const $box = $(this).closest('.evaluation-box').find('.teacher-evaluation-box');
      const id = $box.data('id');
      const activityid = $box.data('activityid');
      evaluation_disable_publish(id);
      evaluation_load_grade_feedback(activityid, id, $box);
    });

    /*if ($('.teacher-evaluation-box').length > 0) {
      $('.teacher-evaluation-box').each(function() {
        const id = $(this).data('id');
        const activityid = $(this).data('activityid');
        evaluation_disable_publish(id);
        evaluation_load_grade_feedback(activityid, id, $(this));
      });
    }*/

  }

  /**
   * Enable evaluation publish
   */
  const evaluation_enable_publish = function (id) {
    $('#result-uoc-rac-box-' + id).slideUp('fast');
    $('#publish-grade-submit-' + id).attr("disabled", false);
  }

  /**
   * Disable evaluation publish
   */
  const evaluation_disable_publish = function (id) {
    $('#publish-grade-submit-' + id).attr("disabled", true);
  }

  /**
   * Load evaluation grade feedback
   */
  const evaluation_load_grade_feedback = function (activityid, id, $box) {
    const $loading = $box.closest('.evaluation-box').find('.evaluation-loading');
    $loading.show();
    $box.hide();

    $.ajax({
      type: 'GET',
      url: themeData.ajaxurl,
      data: {
        'action': themeData.getFeedbackGradeAction,
        'id': activityid
      },
      success: function (response) {
        if (response && 'undefined' !== typeof response) {
          if (response.success) {
            var grade = response.data.grade;
            var feedback = response.data.feedback;
            var content = feedback && feedback.text ? feedback.text : '';
            var publish_grade = grade.publish_grade;

            evaluation_mark_grade(id, grade.grade);
            evaluation_publish_grade(publish_grade, id);
            evaluation_tinymce_set_content(content, id, 'evaluation-textarea-' + id);

          } else {
            if (response && response.data) {
              $box.html(response.data.message);
            } else {
              $box.html(themeData.t.error_loading_grade);
            }
          }
        }
      }
    }).fail(function () {
      $box.html(themeData.t.error_loading_grade);
    }).always(function () {
      $loading.hide();
      $box.show();
    });
  }


  /**
   * Aux method evaluation mark grade
   */
  const evaluation_mark_grade = function (id, grade) {
    if (grade == null) {
      grade = "";
    }
    grade = grade.replace('+', 'plus');
    $('#radio-options-inline-grade-' + grade + '-' + id).prop("checked", true);
    evaluation_set_grade_select(id, $('#radio-options-inline-grade-' + grade + '-' + id));
  }

  /**
   * Aux method evaluation set grade
   */
  const evaluation_set_grade_select = function (id, elem) {
    $('.label-grade-select-' + id).removeClass('selected-grade');
    if (elem) {
      $(elem).parent().addClass('selected-grade');
    }
  }

  /**
   * Aux method to set tinymce content
   */
  const evaluation_tinymce_set_content = function (content, id, editor_id, textarea_id) {
    if (typeof editor_id == 'undefined') editor_id = wpActiveEditor;
    if (typeof textarea_id == 'undefined') textarea_id = editor_id;
    const $textarea = $('#' + textarea_id);

    if ($('#wp-' + editor_id + '-wrap').hasClass('tmce-active')) {
      const $editor = tinyMCE.get(editor_id);
      $editor.setContent(content);
      $editor.on('input change', function () {
        evaluation_enable_publish(id);
      });
    } else {
      $textarea.val(content);
    }

    $textarea.on('input change', function () {
      evaluation_enable_publish(id);
    });
  }

  /**
   * Aux method evaluation grade
   */
  const evaluation_publish_grade = function (val, id) {
    $('.publish-grade-radio-' + id).prop("checked", false);
    $('#publish-grade-radio-' + id + '-' + val).prop("checked", true);
    evaluation_show_help_information(val, id);
  }

  /**
   * Aux method display evaluation help info
   */
  const evaluation_show_help_information = function (val, id) {
    if (val == 'now') {
      $('#info_publish_grade_now_' + id).show();
      $('#info_program_publish_grade_' + id).hide();
    } else {
      $('#info_publish_grade_now_' + id).hide();
      $('#info_program_publish_grade_' + id).show();
    }
  }

  /**
   * Aux method to get tinymce content
   */
  const evaluation_tinymce_get_content = function (editor_id, textarea_id) {
    if (typeof editor_id == 'undefined') editor_id = wpActiveEditor;
    if (typeof textarea_id == 'undefined') textarea_id = editor_id;

    if ($('#wp-' + editor_id + '-wrap').hasClass('tmce-active') && tinyMCE.get(editor_id)) {
      return tinyMCE.get(editor_id).getContent();
    } else {
      return $('#' + textarea_id).val();
    }
  }

  /**
   * Load post content vía ajax in lists
   * @param {object} $container jquery element
   */
  const loadContent = function ($container) {
    const _post_id = $container.data('post-id');
    if (_post_id && !$container.hasClass('loaded')) {
      $container.children('.entry-body').html('<div class="loading mb-3">' + themeData.t.loading + '</div>');
      $.post(themeData.ajaxurl, {
        _ajax_nonce: themeData.nonce,
        action: "get_ajax_agora_post",
        post_id: _post_id
      })
        .done(function (data) {
          $container.find('.loading').remove();
          if (data.result) {
            $container.addClass('loaded');
            $container.children('.entry-body').html(data.result);
            if (typeof ($.fn.pdfEmbedder) != 'undefined') {
              $container.find('.pdfemb-viewer').pdfEmbedder();
            }
            if (data.pdf_url) {
              $container.find('a.dkpdf-button').attr('href', data.pdf_url);
            }
          }
        })
        .fail(function () {
          $container.find('.loading').remove();
        });
    }
  }


  /**
   * Load post content vía ajax in lists
   * @param {object} $item jquery element
   */
  const loadMoreComments = function ($item) {

    const _post_id = $item.data('post-id');
    const _dir = $item.data('dir');
    const _pages = parseInt($item.data('pages'), 10);
    const $more = $item.closest('.load-more');

    let _page = parseInt($item.data('page'), 10);

    if (_post_id) {

      if (_dir === DIR_NEW) {
        _page -= 1;
      } else {
        _page += 1;
      }

      $.post({
        url: agoraFolioData.ajaxurl,
        data: {
          _ajax_nonce: agoraFolioData.nonce,
          action: "load_more_comments_list_ajax",
          post_id: _post_id,
          page: _page,
        },
        beforeSend: function () {
          $item.addClass('disabled');
          $item.find('.label').text(agoraFolioData.t.loading);
          $item.find('.icon').addClass('loading');
        }
      })
        .done(function (data) {
          if (data.result) {
            const $result = $(data.result);
            $more.closest('.view-col').find('.comment-list').append($result);
            $item.removeClass('disabled');
            $item.find('.label').text(agoraFolioData.t.loadMore);
            $item.find('.icon').removeClass('loading');
            $item.data('page', _page).attr('data-page', _page);
            if ((_dir === DIR_NEW && _page === 1) || _dir === DIR_OLD && _page === _pages) {
              $more.remove();
            }
            if (typeof ($.fn.pdfEmbedder) != 'undefined') {
              $result.find('.pdfemb-viewer').pdfEmbedder();
            }
          } else {
            $more.remove();
          }
        })
        .fail(function () {
          $more.remove();
        });

    }
  };

  /**
   * Set object fit image 
   * @param {object} img image object
   * @returns 
   */
  const fitThumb = function (img) {

    if (!img) return false;

    const $img = $(img);
    const w = img.naturalWidth;
    const h = img.naturalHeight;

    $img.addClass('show');

    if (!w || !h) return false;

    if (w < $img.parent().width() || h < $img.parent().height()) {
      $img.addClass('contain');
    } else {
      $img.removeClass('contain');
    }

  }

  /**
   * Position and Fade In image thumbnails after load complete
   */
  const preloadThumbs = function () {
    $(".img-cover.fade:not(.show)").on("load", function () {
      fitThumb(this);
    }).each(function () {
      // lanzamos el evento load si no se ejecuta para imágenes almacenadas en caché
      if (this.complete) $(this).trigger("load");
    });
  };


  /**
   * Initialize application
   */
  $(function () {
    console.log('🚀 AgoraFolio is ready!');
    if (isMobile.any()) $body.addClass('device-touch');
    preloadThumbs();
    objectFitImages('img.img-cover');
    setupMenu();
    setupView();
    setupSort();
    setupEvents();
    //setupTree();
    setupWidgets();
    setupEvaluation();
    onResize();
  })

})(jQuery, typeof agoraFolioData !== 'undefined' ? agoraFolioData : {});