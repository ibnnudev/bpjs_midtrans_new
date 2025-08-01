<?php

function array_to_csv($array, $file = 'php://output')
{
    $fp = fopen($file, 'w');

    // Menulis data ke dalam file CSV
    foreach ($array as $fields) {
        fputcsv($fp, $fields);
    }

    fclose($fp);
}
