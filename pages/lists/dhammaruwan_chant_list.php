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
$author   = "Dhammaruwan";
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

<img src="../../images/dhammaruwan.png" alt="Dhammaruwan" class="content-image">

<h3>Dhammaruwan</h3>

<p>Mr. Chandrasiri Seneviratne (Dhammaruwan) was born in a small 
village near Kandy, Sri Lanka in November, 1968. From the age of about 
two, before he could read or write , he spontaneously started to chant 
the ancient Buddhist scriptures in the original pali language , known 
only a two few scholar monks.</p>

<p>Each day, somewhere around two o'clock in the morning, after 
sitting in meditation with his adopted and devoutly Buddhist foster father for about twenty to forty munits, he would spontaneously start to chant pali suttas. On the special Poya or lunar Observance day, he would sometimes chant for two hours.</p>

<p>Dhammaruwan's foster father starting making amateur recording 
of the chanting and invited prominent scholar monk to listen. 
The monk verified that it was indeed the ancient pali language and 
the boy was chanting it in an ancient style.</p>

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
	
<div class="header-panes">External Resources of Dhammaruwan</div>
<?php include '../lists/dhammaruwan_links.php'; ?>
	
</div>
</div>
</section-max>