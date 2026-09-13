<?php
require_once '../db_config.php';

$limit = 100;

/* Get filter values */
$language = isset($_GET['language']) ? $_GET['language'] : '';
$length   = isset($_GET['length']) ? $_GET['length'] : '';

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

$offset = ($page - 1) * $limit;

/* Build WHERE dynamically */
$where = [];
$params = [];

if ($language !== '') {
    $where[] = "language = ?";
    $params[] = $language;
}

if ($length !== '') {
    $where[] = "length = ?";
    $params[] = $length;
}

$whereSQL = "";
if (!empty($where)) {
    $whereSQL = "WHERE " . implode(" AND ", $where);
}

/* Count total */
$countSql = "SELECT COUNT(*) FROM Talk_list2 $whereSQL";
$countStmt = $pdo->prepare($countSql);
$countStmt->execute($params);
$totalRows = $countStmt->fetchColumn();
$totalPages = ceil($totalRows / $limit);

/* Fetch data */
$sql = "SELECT * FROM Talk_list2
        $whereSQL
        ORDER BY id DESC
        LIMIT $limit OFFSET $offset";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$talks = $stmt->fetchAll();
?>
<html>
<head>
<meta charset="UTF-8">
<title>Filter by Language & Length, typable</title>
<link rel="stylesheet" href="../css/style.css">
<?php include '../include/formats.php'; ?>
</head>
<body>
  <?php include '../include/header.php'; ?>
  <?php include '../include/menu_dir.php'; ?>
 <?php include '../include/av_players.php'; ?>

<div class="card">
    <h2>Filter by Language & Length - can type</h2>

    <form method="get" class="form-group" style="display:flex; gap:15px; flex-wrap:wrap;">

        <div>
    <label>Language</label>
    <input type="text" name="language"
           list="languageList"
           value="<?= htmlspecialchars($language) ?>"
           placeholder="Type or select language">

    <datalist id="languageList">
        <option value="English">
        <option value="Sinhala">
    </datalist>
</div>


        <div>
    <label>Length</label>
    <input type="text" name="length"
           list="lengthList"
           value="<?= htmlspecialchars($length) ?>"
           placeholder="Type or select length">

    <datalist id="lengthList">
        <option value="Long">
        <option value="Short">
    </datalist>
</div>

        <div style="align-self:flex-end;">
            <button class="btn btn-primary">Filter</button>
        </div>

    </form>
</div>

<div class="card">
    <div class="table-wrapper">
        <table>
            <tr>
                <th>ID</th>
                <th>File</th>
                <th>Title</th>
                <th>Author</th>
                <th>Language</th>
                <th>Length</th>
                <th>YouTube</th>
            </tr>

            <?php foreach ($talks as $row): 
			$mp3Link = "https://storage.googleapis.com/sobhana/" . 
                           htmlspecialchars($row['file_number']) . ".mp3";
			?>
	<tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['file_number']) ?></td>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td><?= htmlspecialchars($row['language']) ?></td>
                <td><?= htmlspecialchars($row['length']) ?></td>
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
            </tr>
            <?php endforeach; ?>

        </table>
    </div>

    <!-- Pagination -->
    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i ?>&language=<?= urlencode($language) ?>&length=<?= urlencode($length) ?>"
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