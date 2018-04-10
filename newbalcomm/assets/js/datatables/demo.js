+function ($) { "use strict";
  $(document).ready( function () {
    $('#data_table').DataTable({
      "bProcessing": true,
      "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
      "sPaginationType": "full_numbers"
    });
} );
}(window.jQuery);