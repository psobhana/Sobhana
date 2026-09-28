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
$language = "English";

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
$sql = "SELECT * FROM Talk_list2
        WHERE author = ?
        AND length = ?
        AND language = ?
        ORDER BY id ASC
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

<h3>Bhante Dhammagaru</h3>

<p>(Pandit, BA Hons, MA, MEd, MSSc, MPhil)</p>
<p>Ven. Usgoda Dhammagaru lives in Los Angeles Buddhist Vihara, 
California, USA. He was an Assistant Editor in Sinhala Encyclopaedia 
and a former Lecturer of Sariputta National College of Education in 
Nittambuwa.</p>

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
	
<div class="header-panes">External Resources of Bhante Dhammagaru</div>
<?php include '../lists/dhammagaru_links.php'; ?>
	
</div>
</div>

</section-max>