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
$author   = "YRahula";
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


<img src="../../images/yrahula.jpg" alt="Y Rahula Thero" class="content-image">

<h3>Bhante Yogavacara Rahula</h3>

<p>Bhante Yogavacara Rahula was born as Scott Joseph Du Prez 
in Southern California in 1948. He grew up during the 60's 
and entered the U.S. Army for three years in 1967, spending 
ten months in Vietnam. Adopting the lifestyle of a 
wandering hippie, he began a long odyssey starting in 
Scandinavia which took him half way around the world to 
India and Nepal.</p>
<p>In Nepal he encountered his first spiritual 
teachers, Tibetan Lamas, at a month long meditation 
course, by the end of which he was converted more or less 
to being a Buddhist or at least an earnest seeker after Truth.</p>
<p>His search brought him south to Sri Lanka where 
he ordained as a Buddhist monk in 1975. He remained in 
Sri Lanka off and on until 1986 when he returned to 
the U.S.A. Since then he has been living at the Bhavana 
West Virginia. Now he is Residing/teaching at the Lion of Wisdom 
Meditation Center near Damascus,Md.</p>

</div>
</div>
</div>
</div>

	       <!-- Main table -->
<?php include '../../include/table.php'; ?>

	
	       <!-- External links -->
<div class="container_max">
<div class="meditation-panes">
	
<div class="header-panes">External Resources of Bhante Yogavacara Rahula</div>
<?php include '../lists/yrahula_links.php'; ?>
	
</div>
</div>

</section-max>