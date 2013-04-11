#CsvToTextGrid#
[CsvToTextGrid](https://github.com/AurelioDeRosa/CsvToTextGrid) is a PHP class that lets you to convert a Csv file into a TextGrid, both in the long or short format. The format of the CSV file must be:

    startTime endTime text

##Requirements##
This class requires PHP version 5.3 or higher

##Usage##
Use this class is very simple. All you need to do is include it and call one of its method like the following example:

    <?php
        require_once 'CsvToTextGrid.php';

        $fileExtension = '.csv';
        $path = '.';

        $files = new RegexIterator(new FilesystemIterator($path), "/$fileExtension$/i");
        CsvToTextGrid::convertToLong($files);
    ?>

##License##
[CsvToTextGrid](https://github.com/AurelioDeRosa/CsvToTextGrid) is dual licensed under [MIT](http://www.opensource.org/licenses/MIT) and [GPL-3.0](http://opensource.org/licenses/GPL-3.0)

##Authors##
[Aurelio De Rosa](http://www.audero.it) (Twitter: [@AurelioDeRosa](https://twitter.com/AurelioDeRosa))