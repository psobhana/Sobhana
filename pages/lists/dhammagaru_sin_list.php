<?php
require_once '../../include/db_config.php';

$limit = 100;

/* Pagination */
$page = isset($_GET['page']) && is_numeric($_GET['page'])
    ? (int)$_GET['page']
    : 1;

if ($page < 1) {
    $page = 1;
}

$offset = ($page - 1) * $limit;

/* Fixed Filter */
$author   = "Dhammagaru";
$length   = "Long";
$language = "Sinhala";

/* Count total rows */
$countSql = "SELECT COUNT(*) FROM Talk_list2
             WHERE author = ?
             AND length = ?
             AND language = ?";

$countStmt = $pdo->prepare($countSql);
$countStmt->execute([$author, $length, $language]);

$totalRows = $countStmt->fetchColumn();
$totalPages = ceil($totalRows / $limit);

/* Fetch Data */
$sql = "SELECT t.*,
               (
                   SELECT GROUP_CONCAT(DISTINCT p.file_number
                                       ORDER BY p.file_number
                                       SEPARATOR ',')
                   FROM Pdf_list p
                   WHERE p.talk_number = t.file_number
               ) AS pdf_file_numbers
        FROM Talk_list2 t
        WHERE t.author = ?
          AND t.length = ?
          AND t.language = ?
        ORDER BY t.id ASC
        LIMIT $limit OFFSET $offset";

$stmt = $pdo->prepare($sql);
$stmt->execute([$author, $length, $language]);

$talks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section-max class="meditations">

    <div class="container_max">

        <!-- Teacher Card -->
        <div class="meditation-grid_max">
            <div class="meditation">
 <div class="container2">

<img src="../../images/dhammagaru.jpg" alt="Dhammagaru Thero" class="content-image">

<h3>පූජ්‍ය උස්ගොඩ ධම්‍මගරු හිමිපාණන් වහන්සේ</h3>

<?php include 'dhammagaru_about_sin.php'; ?>

<div class="clear"></div>

<?php include 'dhammagaru_categories.php'; ?>


</div>
</div>
</div>
</div>

	       <!-- Main table -->
 <?php include '../../include/table_pdf.php'; ?>	
	
	       <!-- External links -->
<div class="container_max">
<div class="meditation-panes">
	
<div class="header-panes">ධම්‍මගරු හිමිපාණන් වහන්සේ ගේ තවත් සබැඳි</div>
<?php include '../lists/dhammagaru_links.php'; ?>
	
</div>
</div>

</section-max>
