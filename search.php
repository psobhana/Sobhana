<?php
require_once 'include/db_config.php';

$limit = 100;

/* =========================================================
   Pagination
   ========================================================= */

$page = isset($_GET['page']) && is_numeric($_GET['page'])
    ? (int)$_GET['page']
    : 1;

if ($page < 1) {
    $page = 1;
}

$offset = ($page - 1) * $limit;


/* =========================================================
   Search
   ========================================================= */

$search = isset($_GET['search'])
    ? trim($_GET['search'])
    : '';

$where  = '';
$params = [];

if ($search !== '') {

    $where = "WHERE
        file_number LIKE ? OR
        title LIKE ? OR
        author LIKE ? OR
        notes LIKE ?";

    $like = "%{$search}%";

    $params = [
        $like,
        $like,
        $like,
        $like
    ];
}


/* =========================================================
   Count Results
   ========================================================= */

$countSql = "
    SELECT COUNT(*)
    FROM Talk_list2
    $where
";

$countStmt = $pdo->prepare($countSql);
$countStmt->execute($params);

$totalRows = (int)$countStmt->fetchColumn();

$totalPages = $totalRows > 0
    ? (int)ceil($totalRows / $limit)
    : 1;


/* =========================================================
   Fetch Results
   ========================================================= */

$sql = "
    SELECT *
    FROM Talk_list2
    $where
    ORDER BY id DESC
    LIMIT $limit OFFSET $offset
";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

$talks = $stmt->fetchAll(PDO::FETCH_ASSOC);


/* =========================================================
   Keep Current Search in Pagination
   ========================================================= */

$searchQuery = $search !== ''
    ? '&search=' . urlencode($search)
    : '';

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Search - SobhanaNet</title>

    <link rel="stylesheet" href="css/style.css">


</head>


<body>


<?php include 'include/header.php'; ?>
<?php include 'include/navbar.php'; ?>
 <?php include 'include/av_players.php'; ?>

<!-- =========================================================
     Search Page
     ========================================================= -->
<div class="container_max">
<div class="card_table">

    <!-- =====================================================
         Results Table
         ===================================================== -->

    <div class="table-wrapper">

        <table>

            <thead>

                <tr>

                    <th>No.</th>

                    <th>Title</th>

                    <th class="audio-column">
                        Audio
                    </th>

                    <th class="video-column">
                        Video
                    </th>

                    <th class="share-column">
                        Share
                    </th>

                </tr>

            </thead>


            <tbody>


            <?php

            /*
             * Automatic numbering.
             * Numbering continues correctly across pages.
             */

            $number = $offset + 1;

            foreach ($talks as $row):

                $mp3Link =
                    "https://storage.googleapis.com/sobhana/"
                    . $row['file_number']
                    . ".mp3";

                $youtube =
                    !empty($row['youtube'])
                    ? $row['youtube']
                    : '';

            ?>


                <tr>


                    <!-- =================================================
                         Number
                         ================================================= -->

                    <td>
                        <?= $number++ ?>
                    </td>


                    <!-- =================================================
                         Title + Mobile Icons
                         ================================================= -->

                    <td class="title-cell">


                        <div class="title-text">

                            <?= htmlspecialchars(
                                $row['title'] ?? ''
                            ) ?>

                        </div>


                        <!-- Mobile Icons -->

                        <div class="mobile-icons">


                            <!-- Audio -->

                            <button
                                type="button"
                                class="btn btn-primary"
                                onclick="playAudio(<?= htmlspecialchars(
                                    json_encode($mp3Link),
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>)"
                                aria-label="Play audio">

                                <img
                                    src="images/soundwave.svg"
                                    alt="Audio"
                                    class="table-icon">

                            </button>


                            <!-- Video -->

                            <?php if ($youtube !== ''): ?>

                                <button
                                    type="button"
                                    class="btn btn-primary"
                                    onclick="openVideo(<?= htmlspecialchars(
                                        json_encode($youtube),
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>)"
                                    aria-label="Play video">

                                    <img
                                        src="images/youtube2.svg"
                                        alt="YouTube"
                                        class="table-icon">

                                </button>

                            <?php endif; ?>


                            <!-- Share -->

                            <button
                                type="button"
                                class="btn btn-primary"
                                onclick="shareAudio(<?= htmlspecialchars(
                                    json_encode($mp3Link),
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>)"
                                aria-label="Share audio">

                                <img
                                    src="images/share.svg"
                                    alt="Share"
                                    class="table-icon">

                            </button>


                        </div>

                    </td>


                    <!-- =================================================
                         Desktop Audio
                         ================================================= -->

                    <td class="audio-column">

                        <button
                            type="button"
                            class="btn btn-primary"
                            onclick="playAudio(<?= htmlspecialchars(
                                json_encode($mp3Link),
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>)"
                            aria-label="Play audio">

                            <img
                                src="images/soundwave.svg"
                                alt="Audio"
                                class="table-icon">

                        </button>

                    </td>


                    <!-- =================================================
                         Desktop Video
                         ================================================= -->

                    <td class="video-column">

                        <?php if ($youtube !== ''): ?>

                            <button
                                type="button"
                                class="btn btn-primary"
                                onclick="openVideo(<?= htmlspecialchars(
                                    json_encode($youtube),
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>)"
                                aria-label="Play video">

                                <img
                                    src="images/youtube2.svg"
                                    alt="YouTube"
                                    class="table-icon">

                            </button>

                        <?php endif; ?>

                    </td>


                    <!-- =================================================
                         Desktop Share
                         ================================================= -->

                    <td class="share-column">

                        <button
                            type="button"
                            class="btn btn-primary"
                            onclick="shareAudio(<?= htmlspecialchars(
                                json_encode($mp3Link),
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>)"
                            aria-label="Share audio">

                            <img
                                src="images/share.svg"
                                alt="Share"
                                class="table-icon">

                        </button>

                    </td>


                </tr>


            <?php endforeach; ?>


            <?php if (empty($talks)): ?>

                <tr>

                    <td colspan="5"
                        style="text-align:center; padding:30px;">

                        <?php if ($search !== ''): ?>

                            No results found for
                            "<strong><?= htmlspecialchars($search) ?></strong>".

                        <?php else: ?>

                            No records found.

                        <?php endif; ?>

                    </td>

                </tr>

            <?php endif; ?>


            </tbody>

        </table>

    </div>

    <!-- =========================================================
         Pagination
         ========================================================= -->

    <?php if ($totalPages > 1): ?>

        <div class="pagination">

            <?php for (
                $i = 1;
                $i <= $totalPages;
                $i++
            ): ?>

                <a
                    href="?page=<?= $i ?><?= $searchQuery ?>"
                    class="<?= ($i == $page) ? 'active' : '' ?>">

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