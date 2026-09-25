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
$author   = "Chandakitthi";
$length   = "Long";
$talk = "Chant";

/* Count total rows */
$countSql = "SELECT COUNT(*) FROM Talk_list2
             WHERE author = ?
             AND length = ?
             AND talk = ?";

$countStmt = $pdo->prepare($countSql);
$countStmt->execute([$author, $length, $talk]);

$totalRows = $countStmt->fetchColumn();
$totalPages = ceil($totalRows / $limit);

/* Fetch Data */
$sql = "SELECT * FROM Talk_list2
        WHERE author = ?
        AND length = ?
        AND talk = ?
        ORDER BY id ASC
        LIMIT $limit OFFSET $offset";

$stmt = $pdo->prepare($sql);
$stmt->execute([$author, $length, $talk]);

$talks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section-max class="meditations">

<div class="container_max">
        <!-- Teacher Card -->
 <div class="meditation-grid_max">
<div class="meditation">
<div class="container2">

<img src="../../images/chandakitthi.png" alt="Chandakitthi" class="content-image">

<h3>Talalle Chandakitthi Thero</h3>

<p>Rev. Talalle Chandakitthi Thero lives at the Narada Centre in 
Colombo 7, Sri Lanka. He is a well‑known Dhamma teacher 
in Sri Lanka and the founder of the <a href="https://dhammadeepa.lk/" target="_blank">Dhammadeepa Foundation</a>, 
a welfare organization.</p>

<div class="clear"></div>

<!-- <ul class="list-dotted-move">
		<li><a href="punnaji_eng.php">ඉංග්‍රීසි ධර්ම දේශනා හා දහම් ලිපි</a></li>
</ul> -->

</div>
</div>
</div>
</div>

	       <!-- Main table -->
 <?php include '../../include/table.php'; ?>	
	
	       <!-- External links -->
<div class="container_max">
<div class="meditation-panes">
	
<div class="header-panes">External Resources of  Talalle Chandakitthi Thero</div>
<?php include '../lists/chandakitthi_links.php'; ?>
	
</div>
</div>
</section-max>