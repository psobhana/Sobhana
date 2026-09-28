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
$author   = "Punnaji";
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


<img src="../../images/punnaji.webp" alt="Punnaji Thero" class="content-image">

<h3>පූජ්‍ය මඩවල පුණ්ණජි හිමිපාණන් වහන්සේ</h3>

<p>පූජ්‍ය මඩවල පුණ්ණජි හිමිපාණන් වහන්සේ ඇමරිකාව, කැනඩාව ආදී රටවල 
ඉංග්‍රීසි භාශාවෙන් ධර්ම දේශනා පැවැත්වීමට හා භාවනා පන්ති ආදිය පැවැත්වීමට 
මහත් ප්‍රසිද්ධියක් ඉසිලූ හිමි නමකි.</p>

<div class="clear"></div>

<ul class="list-dotted-move">
		<li><a href="punnaji_eng.php">ඉංග්‍රීසි ධර්ම දේශනා</a></li>
</ul>


</div>



            </div>

        </div>

    </div>

	       <!-- Main table -->
 <?php include '../../include/table.php'; ?>	
	
	       <!-- External links -->
<div class="container_max">
<div class="meditation-panes">
	
<div class="header-panes">පුණ්ණජි හිමිපාණන් වහන්සේ ගේ තවත් සබැඳි</div>
<?php include '../lists/punnaji_links.php'; ?>
	
</div>
</div>

</section-max>