
<?php
require_once '../../include/db_config.php';

$limit = 100;

/* Pagination */
$page = isset($_GET['page']) && is_numeric($_GET['page'])
    ? max(1, (int)$_GET['page'])
    : 1;

$offset = ($page - 1) * $limit;

/* Fixed Filters */
$author   = "Dhammagaru";
$language = "English";

/*
 * Count unique file_number values.
 * Only the first entry (lowest id) for each file_number is counted.
 */
$countSql = "
    SELECT COUNT(DISTINCT file_number)
    FROM Pdf_list
    WHERE author = ?
      AND language = ?
";

$countStmt = $pdo->prepare($countSql);
$countStmt->execute([$author, $language]);

$totalRows = (int)$countStmt->fetchColumn();
$totalPages = (int)ceil($totalRows / $limit);

/*
 * Fetch only the first entry for each file_number.
 * The entry with the lowest id is retained.
 */
$sql = "
    SELECT p.id, p.file_number, p.title
    FROM Pdf_list p
    WHERE p.author = ?
      AND p.language = ?
      AND p.id = (
          SELECT MIN(p2.id)
          FROM Pdf_list p2
          WHERE p2.file_number = p.file_number
            AND p2.author = p.author
            AND p2.language = p.language
      )
    ORDER BY p.id ASC
    LIMIT $limit OFFSET $offset
";

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



