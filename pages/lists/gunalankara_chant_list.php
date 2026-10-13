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
$author   = "Gunalankara";
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


<img src="../../images/siri_gunalankara.png" alt="Siri Gunalankara Thero" class="content-image">

<h3>Kapuduwe Siri Gunalankara Thero</h3>

<p>Kapuduwe Siri Gunalankara Thero (Horapavita Hamuduruwo) is the 
founder of the Five Precepts Project, which is well known and 
followed by many Sri Lankan Buddhists.</p>
<p>Click 
<svg width="16px" height="16px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21 3V8M21 8H16M21 8L18 5.29168C16.4077 3.86656 14.3051 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21C16.2832 21 19.8675 18.008 20.777 14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
 button to play continuously.</p>

<div class="clear"></div>

<!-- <ul class="list-dotted-move">
		<li><a href="punnaji_eng.php">ඉංග්‍රීසි ධර්ම දේශනා හා දහම් ලිපි</a></li>
</ul> -->


</div>



            </div>

        </div>

    </div>

	       <!-- Main table -->
 <?php include '../../include/table_loop.php'; ?>	

 <!-- AI Notice -->
<?php include '../../include/ai_notice.php'; ?>
	
	       <!-- External links -->
<div class="container_max">
<div class="meditation-panes">
	
<div class="header-panes">External Resources of Siri Gunalankara Thero</div>
<?php include '../lists/gunalankara_links.php'; ?>
	
</div>
</div>

</section-max>