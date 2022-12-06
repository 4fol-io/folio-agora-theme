/**
 * Tree Agora Folio Module Script
 */


/**
 * Nota: Profundidad y visibilidad de las lineas determinada por estilos vía Media Queries
 * Si cambian estos parámetros hay que modificar media queries
 */
const deepXS = 4;			// max threading deep for small displays
const deepSM = 7;			// max threading deep for medium displays
const deepLG = 10;		    // max threading deep for large displays

const DIR_NEW = 'newest';
const DIR_OLD = 'oldest';

let treeCount = 0;
let treePaths = [];
let treeData = [];


/**
 * Setup tree view
 */
export const setupTree = function () {
    setEvents();
    getTreePaths();
    deepClasses();
};

var setEvents = function () {

    const $doc = $(document);

    // Expand collapse tree nodes (manually: due to a bootstrap bug retaining state while redrawing toggle buttons)
    $doc.on('click', '.agora-view-tree .node-toggle', function (e) {
        e.preventDefault();
        var $this = $(this);
        var $target = $($this.attr('href'));
        var $li = $this.closest('li.tree-item');
        $li.toggleClass(['open-node', 'closed-node']);
        if ($this.hasClass('collapsed')) {
            $target.collapse('show');
            $this.removeClass('collapsed').attr('aria-expanded', true);
        } else {
            $target.collapse('hide');
            $this.addClass('collapsed').attr('aria-expanded', false);
        }
        return false;
    });

    // Expand collapse tree nodes (manually: due to a bootstrap bug retaining state while redrawing toggle buttons)
    $doc.on('click', '.agora-view-tree .load-more-comments-js', function (e) {
        e.preventDefault();
        var $this = $(this);
        if (!$this.hasClass('disabled')) {
            loadMoreComments($this);
        }
        return false;
    });

};



/**
 * Calculate tree node paths
 */
var getTreePaths = function () {
    const $items = $('.agora-view-tree .tree-item');
    var j, i, level;

    treeCount = $items.length;

    if (treeCount > 0) {

        $items.each(function (i, item) {
            level = $(item).parents("ul.tree-list").length;
            treePaths[i] = [];
            treeData[i] = {
                id: $(item).data('tree-id'),
                'level': level,
            }
            for (j = 0; j < level; j++) {
                treePaths[i][j] = "blank";
            }
        });

        for (i = treeCount - 1; i >= 0; i--) {
            level = treeData[i].level;
            if (level > 1) {
                getTreeNodePath(i, level);
            }
            getTreeNodeElm(i, level);
        }

        for (i = 0; i < treeCount; i++) {
            renderPath(i);
        }
    }

};


/**
 * Calculate Therading level line node
 * @param {integer} i The message index in array
 * @param {integer} level The message level
 */
var getTreeNodePath = function (i, level) {

    var j;

    if (i > 0 && level > 1) {
        if (treePaths[i][level - 2] !== "node") {
            treePaths[i][level - 2] = "last-node";
        }
        for (j = i - 1; j >= 0; j--) {
            if (treeData[j].level > level) {
                treePaths[j][level - 2] = "vline";
            } else if (treeData[j].level === level) {
                treePaths[j][level - 2] = "node";
            } else {
                break;
            }
        }
    }

};


/**
 * Calculate threading end node element
 * @param {integer} i The message index in array
 * @param {integer} level The message level
 */
var getTreeNodeElm = function (i, level) {

    if (i === treeCount - 1) {
        treePaths[i][level - 1] = "point";
    } else if (treeData[i + 1].level > level) {
        treePaths[i][level - 1] = "toggle";
    } else {
        treePaths[i][level - 1] = "point";
    }

};

/**
 * Render tree line paths and final node elements
 * @param  {integer} idx  The tree item index in array
 * @return {string} The path html code
 */
var renderPath = function (idx) {

    var _l = 0;
    var _s = '';
    var _path = treePaths[idx];
    var _data = treeData[idx];
    var $item = $('.tree-item[data-tree-id="' + _data.id + '"]');
    var _collapsed = $item.hasClass('closed-node');
    var _cls = _collapsed ? 'node-toggle collapsed' : 'node-toggle';

    //console.log($item.attr('id'), _cls);


    $.each(_path, function (i, item) {
        _l = Math.min(i + 1, deepLG);
        //console.log(i, item, level);
        switch (item) {
            case 'vline':
                _s += '<span class="tree-line line-v l' + _l + '"></span>\n';
                break;
            case 'node':
                _s += '<span class="tree-line line-v l' + _l + '"></span>\n';
                if (_l < deepLG) {
                    _s += '<span class="tree-line line-h l' + _l + '"></span>\n';
                }
                break;
            case 'last-node':
                if (_l > 1 && idx < treeCount - 1) {
                    _s += '<span class="tree-line line-h line-h-cut l' + _l + '"></span>\n';
                    _s += '<span class="tree-line line-v line-v-cut l' + _l + '"></span>\n';
                }
                _s += '<span class="tree-line line-v line-v-end l' + _l + '"></span>\n';
                if (_l < deepLG) {
                    _s += '<span class="tree-line line-h l' + _l + '"></span>\n';
                }
                break;
            case 'toggle':
                _s += '<span class="tree-line line-v line-v-ini l' + _l + '"></span>\n';
                _s += '<a id="node_toggle_' + _data.id + '" href="#node_list_' + _data.id + '" class="' + _cls + '" data-target="#node_list_' + _data.id + '" role="button" aria-expanded="' + !_collapsed + '" aria-controls="node_list_' + _data.id + '">\n';
                _s += '<span class="toggle" aria-hidden="true"></span>\n';
                _s += '<span class="sr-only">' + agoraFolioData.t.expandCollapse + ': ' + _data.id + '</span>\n';
                _s += '</a>\n';
                break;
            case 'point':
                _s += '<span class="final-node"></span>\n';
                break;
        }

    });

    var $node = $item.children('.tree-node');
    if ($node) {
        if ($node.children('.tree-draw').length > 0) {
            $node.children('.tree-draw').html(_s);
        } else {
            $node.prepend('<span class="tree-draw">' + _s + '</span>');
        }
    }

};


/**
 * Assign deepest clasess for responsive purposes
 */
var deepClasses = function () {
    var _xs_deep_cls = [];
    var _sm_deep_cls = [];
    var i;

    for (i = deepXS; i < deepSM; i++) {
        _xs_deep_cls.push('.tree-item-l' + i);
    }

    for (i = deepSM; i < deepLG; i++) {
        _sm_deep_cls.push('.tree-item-l' + i);
    }

    $(_xs_deep_cls.join()).last().addClass('deepest-xs');
    $(_sm_deep_cls.join()).last().addClass('deepest-sm');
    $(".tree-item-l" + deepLG).last().addClass('deepest-lg');

};


/**
  * Load post content vía ajax in tree
  * @param {object} $item jquery element
  */
const loadMoreComments = function ($item) {

    const _post_id = $item.data('post-id');
    const _dir = $item.data('dir');
    const _pages = parseInt($item.data('pages'), 10);
    const $more = $item.closest('li.tree-item');

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
                action: "load_more_comments_tree_ajax",
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
                    $more.before($result);
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
            })
            .always(function () {
                getTreePaths();
            });

    }
};