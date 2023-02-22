/**
 * Agora Folio Widgets Module
 */

/**
 * Sort participants block
 * @param {object} $block filters block element
 */
export const sortParticipants = function ($block) {

  const orderBy = $block.attr('data-orderby');
  const orderByAlt = orderBy === 'name' ? 'surname' : 'name';
  const order = $block.attr('data-order');
  const $container = $block.find('.list--participants');

  $container.each(function () {
    var $this = $(this);
    $this.children('li').sort(function (a, b) {
      const orderA = $(a).attr('data-' + orderBy).toLowerCase();
      const orderB = $(b).attr('data-' + orderBy).toLowerCase();
      if (orderA === orderB) {
        const orderC = $(a).attr('data-' + orderByAlt);
        const orderD = $(b).attr('data-' + orderByAlt);
        if (order === 'ASC') {
          return (orderC < orderD) ? -1 : (orderC > orderD) ? 1 : 0;
        } else {
          return (orderD < orderC) ? -1 : (orderD > orderC) ? 1 : 0;
        }
      } else {
        if (order === 'ASC') {
          return (orderA < orderB) ? -1 : (orderA > orderB) ? 1 : 0;
        } else {
          return (orderB < orderA) ? -1 : (orderB > orderA) ? 1 : 0;
        }
      }
    }).appendTo($this);
  });
  

}


/**
 * Initialice widgets
 */
export const setupWidgets = function () {

  // Append megamenu superagora modals to body to prevent overlay
  $('.mega-menu .modal').appendTo('body');

  $('.block--participants').each(function () {

    const $block = $(this);
    const $sortbtn = $block.find('.btn-participants-sort');
    const $sortby = $block.find('input.participants-orderby');
    const $sort = $block.find('input.participants-order');

    $sortby.on('change', function () {
      $block.attr('data-orderby', $(this).val());
      sortParticipants($block);
    })

    $sort.on('change', function () {
      $block.attr('data-order', $(this).val());
      $sortbtn.find('.lbl').text($(this).data('label'));
      sortParticipants($block);
    })

    $sortbtn.on('click', function (e) {
      e.preventDefault();
      const order = $block.attr('data-order') === 'ASC' ? 'DESC' : 'ASC';
      $block.attr('data-order', order);
      $block.find('input[value="' + order + '"]').prop('checked', true);
      $(this).find('.lbl').text($block.find('input.participants-order:checked').data('label'));
      sortParticipants($block);
    })

    sortParticipants($block);

  });

}
