<?php
require_once 'include/db_config.php';

$limit = 100;

/* Pagination */
$page = isset($_GET['page']) && is_numeric($_GET['page'])
    ? max(1, (int) $_GET['page'])
    : 1;
$offset = ($page - 1) * $limit;

/* Search both tables by file_number, title, and author */
$search = isset($_GET['search']) ? trim((string) $_GET['search']) : '';
$where = '';
$params = [];

if ($search !== '') {
    $where = 'WHERE file_number LIKE ? OR title LIKE ? OR author LIKE ?';
    $like = '%' . $search . '%';
    $params = [$like, $like, $like];
}

/* Give both tables the same columns for UNION ALL */
/* Give both tables the same columns for UNION ALL */
$combinedTables = "(
    SELECT
        t.id,
        t.file_number,
        t.title,
        t.author,
        t.youtube,
        (
            SELECT GROUP_CONCAT(
                DISTINCT p.file_number
                ORDER BY p.file_number
                SEPARATOR ','
            )
            FROM Pdf_list p
            WHERE p.talk_number = t.file_number
        ) AS pdf_file_numbers,
        'Talk_list2' AS source_table
    FROM Talk_list2 t

    UNION ALL

    SELECT
        p.id,
        p.file_number,
        p.title,
        p.author,
        NULL AS youtube,
        p.file_number AS pdf_file_numbers,
        'Pdf_list' AS source_table
    FROM Pdf_list p
) AS combined";


/* Count combined search results */
$countSql = "SELECT COUNT(*) FROM $combinedTables $where";
$countStmt = $pdo->prepare($countSql);
$countStmt->execute($params);
$totalRows = (int) $countStmt->fetchColumn();
$totalPages = max(1, (int) ceil($totalRows / $limit));

/* Fetch current page */
$sql = "SELECT * FROM $combinedTables
        $where
        ORDER BY id ASC, source_table ASC
        LIMIT $limit OFFSET $offset";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$talks = $stmt->fetchAll(PDO::FETCH_ASSOC);

$searchQuery = $search !== '' ? '&search=' . urlencode($search) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search - SobhanaNet</title>
    <link rel="shortcut icon" href="images/lotus.png">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'include/header.php'; ?>
<?php include 'include/navbar.php'; ?>
<?php include 'include/av_players.php'; ?>

<div class="container_max">
    <div class="card_table">
        <div class="table-wrapper">
            <table>
                <thead>
    <tr>
        <th>No.</th>
        <th>Title</th>
        <th class="pdf-column">PDF</th>
        <th class="audio-column">Audio</th>
        <th class="video-column">Video</th>
        <th class="share-column">Share</th>
    </tr>
</thead>
                <tbody>
                <?php $number = $offset + 1; ?>

                <?php foreach ($talks as $row): ?>
                    <?php
                    $isPdf = ($row['source_table'] === 'Pdf_list');
                    $fileNumber = (string) ($row['file_number'] ?? '');
                    $pdfLink = 'https://storage.googleapis.com/sobhana/'
                             . rawurlencode($fileNumber) . '.pdf';
                    $mp3Link = 'https://storage.googleapis.com/sobhana/'
                             . rawurlencode($fileNumber) . '.mp3';
                    $youtube = (!$isPdf && !empty($row['youtube']))
                             ? (string) $row['youtube'] : '';
                    $title = (string) ($row['title'] ?? '');
                    ?>
                    <tr>
                        <td><?= $number++ ?></td>

                        
<td class="title-cell">
    <div class="title-text">
        <?php if ($isPdf): ?>
            <a href="<?= htmlspecialchars($pdfLink, ENT_QUOTES, 'UTF-8') ?>"
               target="_blank" rel="noopener noreferrer">
                <?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?>
            </a>
        <?php else: ?>
            <a href="#"
               onclick="playAudio(<?= htmlspecialchars(json_encode($mp3Link), ENT_QUOTES, 'UTF-8') ?>); return false;"
               aria-label="Play audio: <?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?>">
                <?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?>
            </a>
        <?php endif; ?>
    </div>

    <!-- Mobile icons -->
    <div class="mobile-icons">
        <?php if ($isPdf): ?>
            <button type="button" class="btn btn-primary"
                    onclick="shareAudio(<?= htmlspecialchars(json_encode($pdfLink), ENT_QUOTES, 'UTF-8') ?>)"
                    aria-label="Share PDF">
                <img src="images/share.svg" alt="Share PDF" class="table-icon">
            </button>
        <?php else: ?>
		
		
		<!-- Mobile PDF links -->
<?php if (!$isPdf && !empty($row['pdf_file_numbers'])): ?>
    <div class="mobile-pdf-links">
        <?php foreach (explode(',', $row['pdf_file_numbers']) as $pdfFileNumber): ?>
            <?php
                $pdfFileNumber = trim($pdfFileNumber);

                if ($pdfFileNumber === '') {
                    continue;
                }

                $linkedPdf = 'https://storage.googleapis.com/sobhana/'
                          . rawurlencode($pdfFileNumber)
                          . '.pdf';
            ?>

            <a class="pdf-link mobile-pdf-link"
               href="<?= htmlspecialchars($linkedPdf, ENT_QUOTES, 'UTF-8') ?>"
               target="_blank"
               rel="noopener noreferrer"
               aria-label="Open PDF file <?= htmlspecialchars($pdfFileNumber, ENT_QUOTES, 'UTF-8') ?>"
               title="Open PDF">

                <svg xmlns="http://www.w3.org/2000/svg"
                     width="18" height="18"
                     viewBox="0 0 24 24"
                     fill="currentColor"
                     fill-rule="evenodd"
                     aria-hidden="true">
                    <path d="M6 2h9l5 5v15H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2zm8 1.5V8h4.5 M7 13h10v1.5H7zm0 3h10v1.5H7z"/>
                </svg>
            </a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
		
		
		
		
            <button type="button" class="btn btn-primary"
                    onclick="playAudio(<?= htmlspecialchars(json_encode($mp3Link), ENT_QUOTES, 'UTF-8') ?>)"
                    aria-label="Play audio">
                <img src="images/soundwave.svg" alt="Audio" class="table-icon">
            </button>

            <?php if ($youtube !== ''): ?>
                <button type="button" class="btn btn-primary"
                        onclick="openVideo(<?= htmlspecialchars(json_encode($youtube), ENT_QUOTES, 'UTF-8') ?>)"
                        aria-label="Play video">
                    <img src="images/youtube2.svg" alt="YouTube" class="table-icon">
                </button>
            <?php endif; ?>

            <button type="button" class="btn btn-primary"
                    onclick="shareAudio(<?= htmlspecialchars(json_encode($mp3Link), ENT_QUOTES, 'UTF-8') ?>)"
                    aria-label="Share audio">
                <img src="images/share.svg" alt="Share audio" class="table-icon">
            </button>
        <?php endif; ?>
    </div>
</td>


                        <!-- Desktop Audio: only Talk_list2 -->
			
			
			<!-- Desktop PDF links -->
<td class="pdf-column">
    <?php if (!$isPdf && !empty($row['pdf_file_numbers'])): ?>
        <?php foreach (explode(',', $row['pdf_file_numbers']) as $pdfFileNumber): ?>
            <?php
                $pdfFileNumber = trim($pdfFileNumber);

                if ($pdfFileNumber === '') {
                    continue;
                }

                $linkedPdf = 'https://storage.googleapis.com/sobhana/'
                           . rawurlencode($pdfFileNumber)
                           . '.pdf';
            ?>

            <a class="pdf-link"
               href="<?= htmlspecialchars($linkedPdf, ENT_QUOTES, 'UTF-8') ?>"
               target="_blank"
               rel="noopener noreferrer"
               aria-label="Open PDF file <?= htmlspecialchars($pdfFileNumber, ENT_QUOTES, 'UTF-8') ?>"
               title="Open PDF">

                <svg xmlns="http://www.w3.org/2000/svg"
                     width="18" height="18"
                     viewBox="0 0 24 24"
                     fill="currentColor"
                     fill-rule="evenodd"
                     aria-hidden="true">
                    <path d="M6 2h9l5 5v15H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2zm8 1.5V8h4.5 M7 13h10v1.5H7zm0 3h10v1.5H7z"/>
                </svg>
            </a>
        <?php endforeach; ?>
    <?php endif; ?>
</td>
			
			
			
			
                        <td class="audio-column">
                            <?php if (!$isPdf): ?>
                                <button type="button" class="btn btn-primary"
                                        onclick="playAudio(<?= htmlspecialchars(json_encode($mp3Link), ENT_QUOTES, 'UTF-8') ?>)"
                                        aria-label="Play audio">
                                    <img src="images/soundwave.svg" alt="Audio" class="table-icon">
                                </button>
                            <?php endif; ?>
                        </td>

                        <!-- Desktop Video: only Talk_list2 records with YouTube ID -->
                        <td class="video-column">
                            <?php if ($youtube !== ''): ?>
                                <button type="button" class="btn btn-primary"
                                        onclick="openVideo(<?= htmlspecialchars(json_encode($youtube), ENT_QUOTES, 'UTF-8') ?>)"
                                        aria-label="Play video">
                                    <img src="images/youtube2.svg" alt="YouTube" class="table-icon">
                                </button>
                            <?php endif; ?>
                        </td>

                        <!-- Desktop Share: PDF URL for Pdf_list, MP3 URL for Talk_list2 -->
                        <td class="share-column">
                            <?php if ($isPdf): ?>
                                <button type="button" class="btn btn-primary"
                                        onclick="shareAudio(<?= htmlspecialchars(json_encode($pdfLink), ENT_QUOTES, 'UTF-8') ?>)"
                                        aria-label="Share PDF">
                                    <img src="images/share.svg" alt="Share PDF" class="table-icon">
                                </button>
                            <?php else: ?>
                                <button type="button" class="btn btn-primary"
                                        onclick="shareAudio(<?= htmlspecialchars(json_encode($mp3Link), ENT_QUOTES, 'UTF-8') ?>)"
                                        aria-label="Share audio">
                                    <img src="images/share.svg" alt="Share audio" class="table-icon">
                                </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <?php if (empty($talks)): ?>
                    <tr>
                        <td colspan="5" style="text-align:center; padding:30px;">
                            <?php if ($search !== ''): ?>
                                No results found for
                                <strong><?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?></strong>.
                            <?php else: ?>
                                No records found.
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if ($totalPages > 1): ?>
            <div class="pagination">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?page=<?= $i ?><?= $searchQuery ?>"
                       class="<?= ($i === $page) ? 'active' : '' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'include/footer.php'; ?>
<script>
<?php include 'js/scripts.js'; ?>
<?php include 'js/search.js'; ?>
<?php include 'js/av_players.js'; ?>
</script>
</body>
</html>
