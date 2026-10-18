
<div class="container_max">
    <div class="meditation-grid_max">
        <div class="card_table">
            <div class="table-wrapper2">

                <table>
                    <thead class="desktop-view">
                        <tr>
                            <th>No.</th>
                            <th>Title</th>
                            <th class="share-column">Share</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                    $number = $offset + 1;

                    foreach ($pdfs as $row):

                        $pdfLink = "https://storage.googleapis.com/sobhana/"
                                 . rawurlencode($row['file_number'])
                                 . ".pdf";

                        $safePdfLink = htmlspecialchars(
                            $pdfLink,
                            ENT_QUOTES,
                            'UTF-8'
                        );

                        $safeTitle = htmlspecialchars(
                            $row['title'],
                            ENT_QUOTES,
                            'UTF-8'
                        );
                    ?>

                        <tr>
                            <!-- Automatic Number -->
                            <td class="number-column">
                                <?= $number++ ?>
                            </td>

                            <!-- Title -->
                            <td class="title-cell2">
                                <div class="title-row">

                                    <span class="title-text2">
                                        <?= $safeTitle ?>
                                    </span>

                                    <!-- Mobile Share Icon -->
                                    <button type="button"
                                            class="btn btn-primary2 mobile-share"
                                            onclick="shareAudio(<?= htmlspecialchars(
                                                json_encode($pdfLink),
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>)"
                                            aria-label="Share PDF">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             width="16"
                                             height="16"
                                             fill="none"
                                             viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                  fill-rule="evenodd"
                                                  d="M13.803 5.333c0-1.84 1.5-3.333 3.348-3.333A3.34 3.34 0 0 1 20.5 5.333c0 1.841-1.5 3.334-3.349 3.334-.933 0-1.777-.381-2.384-.994l-4.635 3.156a3.34 3.34 0 0 1-.182 1.917l5.082 3.34a3.35 3.35 0 0 1 2.12-.753 3.34 3.34 0 0 1 3.348 3.334C20.5 20.507 19 22 17.151 22a3.34 3.34 0 0 1-3.348-3.333c0-.483.103-.942.289-1.356L9.05 14a3.35 3.35 0 0 1-2.202.821A3.34 3.34 0 0 1 3.5 11.487a3.34 3.34 0 0 1 3.348-3.333c1.064 0 2.01.493 2.623 1.261l4.493-3.059a3.3 3.3 0 0 1-.161-1.023"/>
                                        </svg>
                                    </button>

                                </div>
                            </td>

                            <!-- Desktop Share -->
                            <td class="share-column desktop-share">
                                <button type="button"
                                        class="btn btn-primary2"
                                        onclick="shareAudio(<?= htmlspecialchars(
                                            json_encode($pdfLink),
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>)"
                                        aria-label="Share PDF">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         width="16"
                                         height="16"
                                         fill="none"
                                         viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                              fill-rule="evenodd"
                                              d="M13.803 5.333c0-1.84 1.5-3.333 3.348-3.333A3.34 3.34 0 0 1 20.5 5.333c0 1.841-1.5 3.334-3.349 3.334-.933 0-1.777-.381-2.384-.994l-4.635 3.156a3.34 3.34 0 0 1-.182 1.917l5.082 3.34a3.35 3.35 0 0 1 2.12-.753 3.34 3.34 0 0 1 3.348 3.334C20.5 20.507 19 22 17.151 22a3.34 3.34 0 0 1-3.348-3.333c0-.483.103-.942.289-1.356L9.05 14a3.35 3.35 0 0 1-2.202.821A3.34 3.34 0 0 1 3.5 11.487a3.34 3.34 0 0 1 3.348-3.333c1.064 0 2.01.493 2.623 1.261l4.493-3.059a3.3 3.3 0 0 1-.161-1.023"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                    </tbody>
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
    </div>
</div>
