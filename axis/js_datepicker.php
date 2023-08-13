  <!-- カレンダー -->
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

  <script>
    $(function() {
      $(".datepicker").datepicker({
        format: 'yyyy-mm-dd'
      });
    });
  </script>