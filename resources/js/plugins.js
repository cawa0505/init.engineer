/**
 * Allows you to add data-method="METHOD to links to automatically inject a form
 * with the method on click
 *
 * Example: <a href="{{route('customers.destroy', $customer->id)}}"
 * data-method="delete" name="delete_item">Delete</a>
 *
 * Injects a form with that's fired on click of the link with a DELETE request.
 * Good because you don't have to dirty your HTML with delete forms everywhere.
 */
function addDeleteForms() {
  $('[data-method]').append(function () {
    var length = $(this).find('form').length > 0;
    if (!length) {
      return "\n<form action='" + $(this).attr('href') + "' method='POST' name='"+$(this).attr('data-method')+"_item' style='display:none'>\n" +
        "<input type='hidden' name='_method' value='" + $(this).attr('data-method') + "'>\n" +
        "<input type='hidden' name='_token' value='" + $('meta[name="csrf-token"]').attr('content') + "'>\n" +
        "</form>\n";
    } else { return ''; }
  })
    .attr('href', '#')
    .attr('style', 'cursor:pointer;')
    .attr('onclick', '$(this).find("form").submit();');
}

/**
 * Place any jQuery/helper plugins in here.
 */
$(function () {
  /**
   * Add the data-method="delete" forms to all delete links
   */
  addDeleteForms();

  /**
   * Disable all submit buttons once clicked
   */
  $('form').on('submit', function () {
    $(this).find('input[type="submit"]').attr('disabled', true);
    $(this).find('button[type="submit"]').attr('disabled', true);
    return true;
  });

  /**
   * Generic confirm form delete using Sweet Alert
   */
  $('body').on('submit', 'form[name=delete_item]', function (e) {
    e.preventDefault();

    const form = this;
    const link = $('a[data-method="delete"]');
    const cancel = (link.attr('data-trans-button-cancel')) ? link.attr('data-trans-button-cancel') : '取消';
    const confirm = (link.attr('data-trans-button-confirm')) ? link.attr('data-trans-button-confirm') : '是的，刪除它。';
    const title = (link.attr('data-trans-title')) ? link.attr('data-trans-title') : 'A你確定要刪除這個項目嗎？';

    Swal.fire({
      title: title,
      showCancelButton: true,
      confirmButtonText: confirm,
      cancelButtonText: cancel,
      type: 'warning'
    }).then((result) => {
      result.value && form.submit();
    });
  }).on('click', 'a[name=confirm_item]', function (e) {
    /**
     * Generic 'are you sure' confirm box
     */
    e.preventDefault();

    const link = $(this);
    const title = (link.attr('data-trans-title')) ? link.attr('data-trans-title') : '您確定要這樣做嗎？';
    const cancel = (link.attr('data-trans-button-cancel')) ? link.attr('data-trans-button-cancel') : '取消';
    const confirm = (link.attr('data-trans-button-confirm')) ? link.attr('data-trans-button-confirm') : '繼續';

    Swal.fire({
      title: title,
      showCancelButton: true,
      confirmButtonText: confirm,
      cancelButtonText: cancel,
      type: 'info'
    }).then((result) => {
      result.value && window.location.assign(link.attr('href'));
    });
  });

  $('[data-toggle="tooltip"]').tooltip();
});
