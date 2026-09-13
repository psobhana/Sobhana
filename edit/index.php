<?php
require_once 'db_config.php';


$limit = 100;

/* ---------- Pagination ---------- */
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

$offset = ($page - 1) * $limit;

/* ---------- Search ---------- */
$search = isset($_GET['search']) ? trim($_GET['search']) : "";

$where = "";
$params = [];

if ($search !== "") {
    $where = "WHERE 
        file_number LIKE ? OR
        title LIKE ? OR
        author LIKE ? OR
        notes LIKE ?";
    $like = "%$search%";
    $params = [$like, $like, $like, $like];
}

/* ---------- Count total rows ---------- */
$countSql = "SELECT COUNT(*) FROM Talk_list2 $where";
$countStmt = $pdo->prepare($countSql);
$countStmt->execute($params);
$totalRows = $countStmt->fetchColumn();

$totalPages = ceil($totalRows / $limit);

/* ---------- Fetch paginated data ---------- */
$sql = "SELECT * FROM Talk_list2 $where ORDER BY id ASC LIMIT $limit OFFSET $offset";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$talks = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Talk List</title>
<link rel="stylesheet" href="css/style.css">
<style>
a { text-decoration:none; }
.actions a { margin-right:8px; }

.search-box { margin-bottom:15px; }
button { padding:6px 10px; }

  /* Small inline style only to set a default size for all Lucide <img> tags */
        img.lucide { width: 1.5rem; height: 1.5rem; }

</style>

<?php include 'include/formats.php'; ?>

<script>
function confirmDelete(id) {
    if (confirm("Are you sure you want to delete this record?")) {
        window.location = "delete.php?id=" + id;
    }
}
</script>

</head>
<body>

<?php include 'include/header.php'; ?>
<?php include 'include/menu.php'; ?>
<?php include 'include/av_players.php'; ?>

<div class="card">
    <h2> </h2>

    <form method="get" class="form-group">
        <input type="text" name="search" placeholder="Search...">
        <button class="btn btn-primary">Search</button>
    </form>

    <div class="table-wrapper">

<table>
<tr>
    <th>ID</th>
    <th>File</th>
    <th>Title</th>
    <th>Audio</th>
    <th>Video</th>
    <th>Actions</th>
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
    <td class="actions">
	<a href="view.php?id=<?= $row['id'] ?>">View</a>
        <a href="edit.php?id=<?= $row['id'] ?>">Edit</a>
        <a href="javascript:void(0);" onclick="confirmDelete(<?= $row['id'] ?>)">Delete</a>
    </td>
</tr>
<?php endforeach; ?>

</table>
</div>


</div>



<!-- Pagination -->
<div class="pagination">

<?php for ($i = 1; $i <= $totalPages; $i++): ?>
    <a href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"
       class="<?= ($i == $page) ? 'active' : '' ?>">
       <?= $i ?>
    </a>
<?php endfor; ?>
</div>


<script>

<?php include 'js/menu.js'; ?>
<?php include 'js/av_players.js'; ?>

</script>

</body>
</html>
