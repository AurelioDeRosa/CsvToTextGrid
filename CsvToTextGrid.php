<?php

/**
 * This class converts a CSV file into a TextGrid, both in the long or short format.
 * The format of the CSV file must be:
 *
 * startTime endTime text
 *
 * PHP version 5.3
 *
 * WARRANTY: The software is provided "as is", without warranty of any kind,
 * express or implied, including but not limited to the warranties of
 * merchantability, fitness for a particular purpose and noninfringement.
 * In no event shall the authors or copyright holders be liable for any claim,
 * damages or other liability, whether in an action of contract, tort or otherwise,
 * arising from, out of or in connection with the software or the use or
 * other dealings in the software.
 *
 * @author  Aurelio De Rosa <aurelioderosa@gmail.com>
 * @link    https://github.com/AurelioDeRosa/CsvToTextGrid
 * @license Dual licensed under MIT (http://www.opensource.org/licenses/MIT)
 * and GPL-3.0 (http://opensource.org/licenses/GPL-3.0)
 *
 */
class CsvToTextGrid
{
    /**
     * This method converts a set of CSV files in their respective
     * long TextGrid equivalents
     *
     * @param Iterator $files The files to process
     *
     * @return boolean
     */
    public static function convertToLong(Iterator $files)
    {
        foreach ($files as $file) {
            $sourceHandle = fopen($file->getPathname(), 'r');
            $intervals = array();
            while (($line = fgets($sourceHandle)) !== false) {
                $fields = explode(' ', $line);
                $fields[0] /= 22050;
                $fields[1] /= 22050;
                // Remove all the characters after the underscore
                $fields[2] = preg_replace('/_.*/', '', $fields[2]);
                // Remove all the non-alphabetic characters
                $fields[2] = preg_replace('/[^a-z]/i', '', $fields[2]);
                $intervals[] = $fields;
                unset($fields);
            }
            fclose($sourceHandle);

            $textGridHandle = fopen($file->getPathname() . '.Long.TextGrid', 'w');
            $header = <<<EOT
File type = "ooTextFile"
Object class = "TextGrid"

xmin = 0
xmax = {$intervals[count($intervals) - 1][1]}
tiers? <exists>
size = 1
item []:
    item [1]:
        class = "IntervalTier"
        name = "Label"
        xmin = 0
        xmax = {$intervals[count($intervals) - 1][1]}
        intervals: size =
EOT;
            fwrite($textGridHandle, $header);
            fwrite($textGridHandle, count($intervals) . "\n");
            foreach ($intervals as $index => $interval) {
                fwrite($textGridHandle, str_repeat(' ', 8) . 'intervals [' . ($index + 1) . ']:' . "\n");
                fwrite($textGridHandle, str_repeat(' ', 12) . 'xmin = ' . $interval[0] . "\n");
                fwrite($textGridHandle, str_repeat(' ', 12) . 'xmax = ' . $interval[1] . "\n");
                fwrite($textGridHandle, str_repeat(' ', 12) . 'text = "' . $interval[2] . '"' . "\n");
            }
            fclose($textGridHandle);
        }

        return true;
    }

    /**
     * This method converts a set of CSV files in their respective
     * short TextGrid equivalents
     *
     * @param Iterator $files The files to process
     *
     * @return boolean
     */
    public static function convertToShort(Iterator $files)
    {
        foreach ($files as $file) {
            $sourceHandle = fopen($file->getPathname(), 'r');
            $intervals = array();
            while (($line = fgets($sourceHandle)) !== false) {
                $fields = explode(' ', $line);
                $fields[0] /= 22050;
                $fields[1] /= 22050;
                // Remove all the characters after the underscore
                $fields[2] = preg_replace('/_.*/', '', $fields[2]);
                // Remove all the non-alphabetic characters
                $fields[2] = preg_replace('/[^a-z]/i', '', $fields[2]);
                $intervals[] = $fields;
                unset($fields);
            }
            fclose($sourceHandle);

            $textGridHandle = fopen($file->getPathname() . '.Short.TextGrid', 'w');
            $header = <<<EOT
File type = "ooTextFile"
Object class = "TextGrid"

0
{$intervals[count($intervals) - 1][1]}
<exists>
1
"IntervalTier"
"Label"
0
{$intervals[count($intervals) - 1][1]}
EOT;
            fwrite($textGridHandle, $header . "\n");
            fwrite($textGridHandle, count($intervals) . "\n");
            foreach ($intervals as $interval) {
                fwrite($textGridHandle, $interval[0] . "\n");
                fwrite($textGridHandle, $interval[1] . "\n");
                fwrite($textGridHandle, '"' . $interval[2] . '"' . "\n");
            }
            fclose($textGridHandle);
        }

        return true;
    }
}