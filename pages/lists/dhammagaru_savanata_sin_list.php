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
$language   = "Sinhala";
$talk = "Savanata";

/* Count total rows */
$countSql = "SELECT COUNT(*) FROM Talk_list2
             WHERE author = ?
             AND language = ?
             AND talk = ?";

$countStmt = $pdo->prepare($countSql);
$countStmt->execute([$author, $language, $talk]);

$totalRows = $countStmt->fetchColumn();
$totalPages = ceil($totalRows / $limit);

/* Fetch Data */
$sql = "SELECT * FROM Talk_list2
        WHERE author = ?
        AND language = ?
        AND talk = ?
        ORDER BY id ASC
        LIMIT $limit OFFSET $offset";

$stmt = $pdo->prepare($sql);
$stmt->execute([$author, $language, $talk]);

$talks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section-max class="meditations">

<div class="container_max">
        <!-- Teacher Card -->
 <div class="meditation-grid_max">
<div class="meditation">
<div class="container2">

<img src="../../images/dhammagaru.jpg" alt="Dhammaruwan" class="content-image">

<h3>පූජ්‍ය උස්ගොඩ ධම්‍මගරු හිමිපාණන් වහන්සේ</h3>
<h4>සවනට බුදුබණ</h4>

<?php include 'dhammagaru_about_sin.php'; ?>

<div class="clear"></div>
<?php include 'dhammagaru_categories.php'; ?>


</div>
</div>
</div>
</div>

	       <!-- Main table -->
 <?php include '../../include/table.php'; ?>	
	
	       <!-- External links -->
<div class="container_max">
<div class="meditation-panes">
	
<div class="header-panes">ධම්‍මගරු හිමිපාණන් වහන්සේ ගේ තවත් සබැඳි</div>
<?php include '../lists/dhammagaru_links.php'; ?>
	
</div>
</div>
</section-max>