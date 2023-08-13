  <!--TAG IT-->
  <link rel="stylesheet" type="text/css" href="js/tag-it/jquery.tagit.css">
  <script type="text/javascript" src="js/tag-it/tag-it.js" type="text/javascript"></script>
  <?php
  $sql = "select tag from tag where allocation='$table'";
  $stmt = connect()->query($sql);
  $tags = $stmt->fetchAll(PDO::FETCH_ASSOC);
  ?>
  <script>
    $(function() {
      $('#tag').tagit({
        singleField: true,
        availableTags: [<?php foreach ($tags as $tag) {
                          print "'$tag[tag]',";
                        } ?> 'OTHER']
      });
    });
  </script>
