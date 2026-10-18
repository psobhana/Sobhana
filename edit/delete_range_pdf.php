<?php
require_once 'db_config.php';


/* ---------- Delete From ID and Reset Numbering ---------- */

$deleteMessage = "";
$deleteError = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['delete_from_id'])) {

    $deleteFromId = filter_var(
        $_POST['delete_from_id'],
        FILTER_VALIDATE_INT
    );

    if ($deleteFromId === false || $deleteFromId < 1) {

        $deleteError = "Please enter a valid ID number.";

    } elseif (
        !isset($_POST['confirm_delete'])
        || $_POST['confirm_delete'] !== 'yes'
    ) {

        $deleteError = "Please confirm the deletion.";

    } else {

        try {
            $pdo->beginTransaction();

            // Delete the specified ID and all subsequent records
            $stmt = $pdo->prepare(
                "DELETE FROM Pdf_list WHERE id >= ?"
            );
            $stmt->execute([$deleteFromId]);

            $deletedRows = $stmt->rowCount();

            $pdo->commit();

            // Reset the next AUTO_INCREMENT number
            $pdo->exec(
                "ALTER TABLE Pdf_list AUTO_INCREMENT = "
                . (int)$deleteFromId
            );

            $deleteMessage = $deletedRows
                . " record(s) deleted. AUTO_INCREMENT reset to "
                . (int)$deleteFromId . ".";

        } catch (PDOException $e) {

            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }

            $deleteError =
                "Operation failed. Please check your database permissions and table configuration.";
        }
    }
}

/* ---------- ---------- */
$limit = 100;

/* ---------- Pagination ---------- */
$page = isset($_GET['page']) && is_numeric($_GET['page'])
    ? max(1, (int)$_GET['page'])
    : 1;

/* ---------- Search ---------- */
$search = isset($_GET['search'])
    ? trim($_GET['search'])
    : "";

/* ---------- ID Range ---------- */
$startId = isset($_GET['start_id']) && $_GET['start_id'] !== ''
    && filter_var($_GET['start_id'], FILTER_VALIDATE_INT) !== false
    ? (int)$_GET['start_id']
    : null;

$endId = isset($_GET['end_id']) && $_GET['end_id'] !== ''
    && filter_var($_GET['end_id'], FILTER_VALIDATE_INT) !== false
    ? (int)$_GET['end_id']
    : null;

/* ---------- Validate ID Range ---------- */
if (($startId !== null && $startId < 1) ||
    ($endId !== null && $endId < 1) ||
    ($startId !== null && $endId !== null && $startId > $endId)) {
    $error = "Please enter a valid ID range. Start ID must not exceed End ID.";
    $startId = null;
    $endId = null;
} else {
    $error = "";
}

/* ---------- Build WHERE Conditions ---------- */
$conditions = [];
$params = [];

if ($startId !== null) {
    $conditions[] = "id >= ?";
    $params[] = $startId;
}

if ($endId !== null) {
    $conditions[] = "id <= ?";
    $params[] = $endId;
}

if ($search !== "") {
    $conditions[] = "(
        file_number LIKE ? OR
        title LIKE ? OR
        author LIKE ? OR
        notes LIKE ?
    )";
    $like = "%$search%";
    $params[] = $like;
    $params[] = $like;
    $params[] = $like;
    $params[] = $like;
}

$where = count($conditions) > 0
    ? "WHERE " . implode(" AND ", $conditions)
    : "";

/* ---------- Count Total Rows ---------- */
$countSql = "SELECT COUNT(*) FROM Pdf_list $where";
$countStmt = $pdo->prepare($countSql);
$countStmt->execute($params);
$totalRows = (int)$countStmt->fetchColumn();
$totalPages = (int)ceil($totalRows / $limit);

/* ---------- Keep Page Within Range ---------- */
if ($totalPages > 0 && $page > $totalPages) {
    $page = $totalPages;
}

$offset = ($page - 1) * $limit;

/* ---------- Fetch Records ---------- */
$sql = "SELECT * FROM Pdf_list
        $where
        ORDER BY id ASC
        LIMIT $limit OFFSET $offset";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$pdfs = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* ---------- Build Pagination URL ---------- */
$queryParams = [
    'search' => $search,
    'start_id' => $startId,
    'end_id' => $endId
];
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>PDF List</title>
<link rel="stylesheet" href="css/style.css">
<link rel="shortcut icon" href="include/edit.svg">
<style>
a {
    text-decoration: none;
}
.actions a {
    margin-right: 8px;
}
.search-box {
    margin-bottom: 15px;
}
button {
    padding: 6px 10px;
}
img.lucide {
    width: 1.5rem;
    height: 1.5rem;
}
.id-range-form {
    display: flex;
    flex-wrap: wrap;
    align-items: end;
    gap: 10px;
    margin-bottom: 15px;
}
.id-range-form .field {
    display: flex;
    flex-direction: column;
    gap: 5px;
}
.id-range-form input {
    width: 120px;
    max-width: 100%;
    padding: 8px;
    box-sizing: border-box;
}
.id-range-form button,
.id-range-form a {
    padding: 8px 12px;
}
.range-error {
    color: #c62828;
    margin-bottom: 12px;
}
.range-info {
    margin: 10px 0;
}
@media (max-width: 600px) {
    .id-range-form {
        align-items: stretch;
    }
    .id-range-form .field {
        flex: 1 1 120px;
    }
    .id-range-form input {
        width: 100%;
    }
}


.delete-range-section {
    margin-bottom: 25px;
    padding: 15px;
    border: 1px solid #dc3545;
    border-radius: 6px;
}

.delete-range-section h3 {
    margin-top: 0;
}

.delete-range-form {
    display: flex;
    flex-wrap: wrap;
    align-items: end;
    gap: 12px;
}

.delete-range-form .field {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.delete-range-form input[type="number"] {
    width: 120px;
    padding: 8px;
    box-sizing: border-box;
}

.confirm-label {
    display: flex;
    align-items: center;
    gap: 6px;
    max-width: 100%;
}

.btn-danger {
    background-color: #dc3545;
    color: white;
    border: none;
    padding: 8px 12px;
    cursor: pointer;
}

.delete-success {
    color: #198754;
    margin-bottom: 0;
}

.delete-error {
    color: #dc3545;
    margin-bottom: 0;
}

@media (max-width: 600px) {
    .delete-range-form {
        align-items: stretch;
        flex-direction: column;
    }

    .delete-range-form .field,
    .delete-range-form input[type="number"] {
        width: 100%;
    }

    .delete-range-form .btn-danger {
        align-self: flex-start;
    }
}

</style>
<?php include 'include/formats.php'; ?>
<script>
function confirmDelete(id) {
    if (confirm("Are you sure you want to delete this record?")) {
        window.location = "delete_pdf.php?id=" + id;
    }
}


function confirmDeleteFromId(form) {
    const id = form.elements['delete_from_id'].value;

    if (!form.elements['confirm_delete'].checked) {
        alert("Please confirm the deletion.");
        return false;
    }

    return confirm(
        "WARNING: This will permanently delete every record " +
        "with ID >= " + id + " from Pdf_list.\n\n" +
        "The next AUTO_INCREMENT number will be reset to " +
        id + ".\n\n" +
        "Make sure you have a database backup before continuing.\n\n" +
        "Do you want to proceed?"
    );
}

</script>
</head>
<body>
<?php include 'include/header.php'; ?>
<?php include 'include/menu.php'; ?>

<div class="card">


<!-- Delete From ID and Reset Numbering Form -->

<div class="delete-range-section">

    <h3>Delete Records and Reset Numbering</h3>

    <form method="post"
          class="delete-range-form"
          onsubmit="return confirmDeleteFromId(this);">

        <div class="field">
            <label for="delete_from_id">
                Delete from ID
            </label>

            <input
                type="number"
                id="delete_from_id"
                name="delete_from_id"
                min="1"
                value="768"
                required
            >
        </div>

        <label class="confirm-label">
            <input
                type="checkbox"
                name="confirm_delete"
                value="yes"
                required
            >
            I understand that all records from this ID onward
            will be permanently deleted.
        </label>

        <button type="submit" class="btn btn-danger">
            Delete and Reset ID
        </button>

    </form>

    <?php if ($deleteMessage !== ""): ?>
        <p class="delete-success">
            <?= htmlspecialchars($deleteMessage) ?>
        </p>
    <?php endif; ?>

    <?php if ($deleteError !== ""): ?>
        <p class="delete-error">
            <?= htmlspecialchars($deleteError) ?>
        </p>
    <?php endif; ?>

</div>


    <!-- ID Range Form -->
    <form method="get" class="id-range-form">
        <div class="field">
            <label for="start_id">Start ID</label>
            <input
                type="number"
                id="start_id"
                name="start_id"
                min="1"
                value="<?= $startId !== null ? $startId : '' ?>"
                placeholder="e.g. 100"
            >
        </div>

        <div class="field">
            <label for="end_id">End ID</label>
            <input
                type="number"
                id="end_id"
                name="end_id"
                min="1"
                value="<?= $endId !== null ? $endId : '' ?>"
                placeholder="e.g. 200"
            >
        </div>

        <button type="submit" class="btn btn-primary">
            Show IDs
        </button>

        <a href="?" class="btn btn-primary">
            Show All
        </a>
    </form>

    <?php if ($error !== ""): ?>
        <p class="range-error">
            <?= htmlspecialchars($error) ?>
        </p>
    <?php endif; ?>

    <!-- Search Form -->
    <form method="get" class="form-group">
        <input
            type="text"
            name="search"
            value="<?= htmlspecialchars($search) ?>"
            placeholder="Search..."
        >

        <?php if ($startId !== null): ?>
            <input type="hidden" name="start_id"
                   value="<?= $startId ?>">
        <?php endif; ?>

        <?php if ($endId !== null): ?>
            <input type="hidden" name="end_id"
                   value="<?= $endId ?>">
        <?php endif; ?>

        <button type="submit" class="btn btn-primary">
            Search
        </button>
    </form>

    <p class="range-info">
        Records found: <strong><?= $totalRows ?></strong>
        <?php if ($startId !== null || $endId !== null): ?>
            — ID range:
            <strong><?= $startId !== null ? $startId : 'Any' ?></strong>
            to
            <strong><?= $endId !== null ? $endId : 'Any' ?></strong>
        <?php endif; ?>
    </p>

    <div class="table-wrapper">
        <table>
            <tr>
                <th>ID</th>
                <th>File</th>
                <th>Title</th>
                <th>PDF</th>
                <th>Actions</th>
            </tr>

            <?php foreach ($pdfs as $row):
                $pdfLink = "https://storage.googleapis.com/sobhana/"
                    . rawurlencode($row['file_number']) . ".pdf";
            ?>
            <tr>
                <td><?= (int)$row['id'] ?></td>
                <td>
                    <?= htmlspecialchars($row['file_number']) ?>
                </td>
                <td>
                    <?= htmlspecialchars($row['title']) ?>
                </td>
                <td>
                    <a href="<?= htmlspecialchars($pdfLink) ?>" target="_blank" class="btn btn-primary">
                        <img
                            src="https://unpkg.com/bootstrap-icons@1.13.1/icons/file-earmark-pdf.svg"
                            alt="PDF"
                            class="lucide mr-0"
                        >
                    </a>
                </td>
                <td class="actions">
                    <a href="view_pdf.php?id=<?= (int)$row['id'] ?>">
                        View
                    </a>
                    <a href="edit_pdf.php?id=<?= (int)$row['id'] ?>">
                        Edit
                    </a>
                    <a href="javascript:void(0);"
                       onclick="confirmDelete(<?= (int)$row['id'] ?>)">
                        Delete
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>

            <?php if (empty($pdfs)): ?>
                <tr>
                    <td colspan="5">No records found.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
</div>

<!-- Pagination -->
<div class="pagination">
    <?php for ($i = 1; $i <= $totalPages; $i++):
        $queryParams['page'] = $i;
    ?>
        <a href="?<?= htmlspecialchars(http_build_query($queryParams)) ?>"
           class="<?= ($i == $page) ? 'active' : '' ?>">
            <?= $i ?>
        </a>
    <?php endfor; ?>
</div>

<script>
<?php include 'js/menu.js'; ?>
</script>
</body>
</html>