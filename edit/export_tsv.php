<?php
require_once 'db_config.php';

/* Set headers to force download */
header('Content-Type: text/tab-separated-values; charset=UTF-8');
header('Content-Disposition: attachment; filename="Talk_list2_export_' . date('Y-m-d_H-i-s') . '.tsv"');

/* Add UTF-8 BOM (important for Excel Sinhala support) */
echo "\xEF\xBB\xBF";

/* Fetch all records */
$stmt = $pdo->query("SELECT * FROM Talk_list2 ORDER BY id ASC");

/* Output header row */
$columns = [
    'id',
    'file_number',
    'length',
    'talk',
    'list',
    'author',
    'title',
    'youtube',
    'year',
    'backed',
    'public',
    'audience',
    'language',
    'country',
    'translator',
    'notes'
];

echo implode("\t", $columns) . "\n";

/* Output data rows */
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    $line = [];

    foreach ($columns as $col) {
        $value = isset($row[$col]) ? $row[$col] : '';

        // Remove tabs and newlines inside fields
        $value = str_replace(["\t", "\r", "\n"], " ", $value);

        $line[] = $value;
    }

    echo implode("\t", $line) . "\n";
}

exit;
