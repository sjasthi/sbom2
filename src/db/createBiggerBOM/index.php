
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="index.css">
        <link rel="icon" href="../../assets/images/BOM.png" />
        
        <title> Create Bigger BOMS </title>
    </head>

    <body>
        <div id="root">
            <form method="POST" action="./index.php">
                <input type="submit" name="button" value="100"></input>
            </form>

            <form method="POST" action="./index.php">
                <input type="submit" name="button" value="1,000"></input>
            </form>

            <form method="POST" action="./index.php">
                <input type="submit" name="button" value="10,000"></input>
            </form>
        </div>
    </body>
</html>

<?php
    require_once('../connect.php'); // connect to DB
    require_once('php/createSQL.php'); // createSQL()
    require_once('php/grabList.php'); // grabList()
    require_once('php/createNewList.php'); // createNewList()
    require_once('php/createTinyBOM.php'); // createTinyBOM()
    require_once('php/factorOfTen.php'); // factorOfTen()
    require_once('php/addLayer.php'); // addLayer()
    require_once('php/buttonSaveFiles.php'); // buttonSaveFiles()
?>
