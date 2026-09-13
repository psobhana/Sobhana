<?php
require_once '../db_config.php';


$limit = 100;

/* Pagination */
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

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
        ORDER BY id DESC
        LIMIT $limit OFFSET $offset";

$stmt = $pdo->prepare($sql);
$stmt->execute([$author, $length, $language]);
$talks = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Dhammagaru – Long – Sinhala Talks</title>
<link rel="stylesheet" href="../css/style.css">
<?php include '../include/formats.php'; ?>
</head>
<body>
  <?php include '../include/header.php'; ?>
  <?php include '../include/menu_dir.php'; ?>
 <?php include '../include/av_players.php'; ?>
<div class="card">
    <h2>Dhammagaru – Long – Sinhala Talks</h2>

    <div class="table-wrapper">
        <table>
            <tr>
                <th>ID</th>
                <th>File</th>
                <th>Title</th>
		<th>Audio</th>
                <th>Video</th>
                <th>Year</th>
            </tr>

            <?php foreach ($talks as $row): 
			$mp3Link = "https://storage.googleapis.com/sobhana/" . 
                           htmlspecialchars($row['file_number']) . ".mp3";
			?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['file_number']) ?></td>
                <td><?= htmlspecialchars($row['title']) ?></td>
				
		<td>
                    <button class="btn btn-primary"
                        onclick="playAudio('<?= $mp3Link ?>')">
                     <img src="https://unpkg.com/bootstrap-icons@1.13.1/icons/soundwave.svg"
                     alt="Audio"
                     class="lucide mr-0">
                    </button>
                </td>	
				
                <td>
                    <?php if ($row['youtube']): ?>
                        <button class="btn btn-primary"
                            onclick="openVideo('<?= htmlspecialchars($row['youtube']) ?>')">
                        <img src="https://unpkg.com/bootstrap-icons@1.13.1/icons/youtube.svg"
                     alt="YouTube"
                     class="lucide mr-0">
                        </button>
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($row['year']) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <!-- Pagination -->
    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i ?>"
               class="<?= ($i == $page) ? 'active' : '' ?>">
               <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>
</div>

<script>
<?php include '../js/menu.js'; ?>
<?php include '../js/av_players.js'; ?>

</script>

<?php require_once '../footer.php'; ?>
</body>
</html>
