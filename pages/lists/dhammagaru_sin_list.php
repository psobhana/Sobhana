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


<img src="../../images/dhammagaru.jpg" alt="Punnaji Thero" class="content-image">

<h3>පූජ්‍ය උස්ගොඩ ධම්‍මගරු හිමිපාණන් වහන්සේ</h3>

<p>(Pandit, BA Hons, MA, MEd, MSSc, MPhil)</p>
<p>පූජ්‍ය උස්ගොඩ ධම්‍මගරු හිමිපාණෝ සිංහල විශ්වකෝෂයේ සහකාර කර්තෘවරයකු 
වශයෙන් මෙන් ම නිට්ටඹුව සාරිපුත්ත අධ්‍යාපන විද්‍යාපීඨයේ කථිකාචාර්යවරයකු වශයෙන් ද 
කටයුතු කළ අතර වර්තමානයේ ඇමරිකාවේ ලොස්ඇන්ජලීස් බෞද්ධ විහාරයේ වැඩ වසති.</p>

<div class="clear"></div>

<ul class="list-dotted-move">
		<li><a href="dhammagaru_eng.php">ඉංග්‍රීසි ධර්ම දේශනා හා දහම් ලිපි</a></li>
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
	
<div class="header-panes">ධම්‍මගරු හිමිපාණන් වහන්සේ ගේ තවත් සබැඳි</div>
<?php include '../lists/dhammagaru_links.php'; ?>
	
</div>
</div>

</section-max>