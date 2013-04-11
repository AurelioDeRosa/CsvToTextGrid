<!DOCTYPE html>
<html>
   <head>
      <meta charset="UTF-8">
      <title>Demo</title>
   </head>
   <body>
      <p>
         <?php
         require_once '../CsvToTextGrid.php';

         echo "Process started<br />";
         $fileExtension = '.csv';
         $path = '.';

         $files = new RegexIterator(new FilesystemIterator($path), "/$fileExtension$/i");
         if (CsvToTextGrid::convertToLong($files) === true)
            echo "<br />Conversion completed successful.<br />";
         else
            echo "<br />There was a problem with the files.<br />";

         echo "<br />Process finished<br />";

         ?>
      </p>
   </body>
</html>
