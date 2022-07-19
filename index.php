<?php
  // Revamped the User Interface; Refactored the code
  // connect to DB
  require_once( 'src/db/connect.php' );
  // variables
  include "src/components/_shared/pathVariables.php";
  // cookie functions
  include("src/components/_shared/cookie_functions.php");
  // custom functions
  include "src/components/_shared/functions.php";
  // scripts
  include "src/components/_shared/scripts.php";
  // stylesheets
  include "src/components/_shared/stylesheets.php";
  // navigation
  include "src/components/header/header.php";

  // homepage
  if( $nav_selected === '' ) {
    include "src/components/pages/homepage/homepage.php";
  }
?>

<!DOCTYPE html>
<html>
  <body>
    <div id="root"></div>

    <script>
      // chatbot integration (see _shared scripts.php for import)
      window.botpressWebChat.init({
          host: 'http://localhost:3000',
          botId: 'helper-bot',
      });
    </script>
  </body>
</html>
