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

/* Fixed Filters */
$author   = "Dhammagaru";
$language = "English";

/* Count total matching rows */
$countSql = "SELECT COUNT(*)
             FROM Pdf_list
             WHERE author = ?
             AND language = ?";

$countStmt = $pdo->prepare($countSql);
$countStmt->execute([$author, $language]);

$totalRows = (int)$countStmt->fetchColumn();
$totalPages = (int)ceil($totalRows / $limit);

/* Fetch PDF records */
$sql = "SELECT id, file_number, title
        FROM Pdf_list
        WHERE author = ?
        AND language = ?
        ORDER BY id ASC
        LIMIT $limit OFFSET $offset";

$stmt = $pdo->prepare($sql);
$stmt->execute([$author, $language]);

$pdfs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section-max class="meditations">

    <div class="container_max">

        <!-- Teacher Card -->
        <div class="meditation-grid_max">

            <div class="meditation">

   <div class="container2">


<img src="../../images/dhammagaru.jpg" alt="Dhammagaru Thero" class="content-image">

<h3>Bhante Dhammagaru</h3>
<h4>Dhamma Articles</h4>

<?php include 'dhammagaru_about_eng.php'; ?>

<div class="clear"></div>

<?php include 'dhammagaru_categories.php'; ?>



</div>
            </div>

        </div>

    </div>

	       <!-- Main table -->
<?php include '../../include/table_articles.php'; ?>

	
	       <!-- External links -->
<div class="container_max">
<div class="meditation-panes">
	
<div class="header-panes">External Resources of Bhante Dhammagaru</div>
<?php include '../lists/dhammagaru_links.php'; ?>
	
</div>
</div>

</section-max>



