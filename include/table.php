

    <div class="container_max">

        <div class="meditation-grid_max">

            <div class="card_table">

                <div class="table-wrapper">

                    <table>

                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Title</th>
                                <th class="audio-column">Audio</th>
				<th class="video-column">Video</th>
				<th class="share-column">Share</th>
                              
                            </tr>
                        </thead>

                        <tbody>

                        <?php
                        /*
                         * Automatic numbering.
                         * It does NOT use the database ID.
                         * Numbering continues correctly across pages.
                         */
                        $number = $offset + 1;

                        foreach ($talks as $row):

                            $mp3Link = "https://storage.googleapis.com/sobhana/"
                                     . htmlspecialchars($row['file_number'])
                                     . ".mp3";
                        ?>

                            <tr>

    <!-- Auto Number -->
    <td><?= $number++ ?></td>

    <!-- Title + Icons -->
    <td class="title-cell">

		<div class="title-text">
		<button type="button"
			class="btn btn-primary2-max"
                    onclick="playAudio('<?= $mp3Link ?>')">
            <?= htmlspecialchars($row['title']) ?>
		</button>
		</div>
        

        <div class="mobile-icons">

            <!-- Audio -->
            <button type="button"
			class="btn btn-primary2"
                    onclick="playAudio('<?= $mp3Link ?>')">
		
		<div class="audio icon"></div>
                <!-- <img src="../../images/soundwave.svg"
                     alt="Audio"
                     class="table-icon">  -->

            </button>

            <!-- Video -->
            <?php if (!empty($row['youtube'])): ?>

                <button type="button"
				class="btn btn-primary2"
                        onclick="openVideo('<?= htmlspecialchars($row['youtube']) ?>')">
			<div class="tv icon"></div>
                    <!-- <img src="../../images/youtube2.svg"
                         alt="YouTube"
                         class="table-icon"> -->

                </button>

            <?php endif; ?>

		<!-- Share -->
	<button type="button"
        class="btn btn-primary2"
        onclick="shareAudio(<?= htmlspecialchars(json_encode($mp3Link), ENT_QUOTES, 'UTF-8') ?>)"
        aria-label="Share audio">
		<div class="link icon"></div>
		<!-- <img src="../../images/share.svg"
         alt="Share"
         class="table-icon"> -->

		</button>



        </div>

    </td>

    <!-- Desktop Audio -->
    <td class="audio-column">
        <button type="button"
		class="btn btn-primary2"
                onclick="playAudio('<?= $mp3Link ?>')">

		<div class="audio icon"></div>
            <!-- <img src="../../images/soundwave.svg"
                 alt="Audio"
                 class="table-icon"> -->

        </button>
    </td>

    <!-- Desktop Video -->
    <td class="video-column">
        <?php if (!empty($row['youtube'])): ?>

            <button type="button"
			class="btn btn-primary2"
                    onclick="openVideo('<?= htmlspecialchars($row['youtube']) ?>')">
		<div class="tv icon"></div>
                <!-- <img src="../../images/youtube2.svg"
                     alt="YouTube"
                     class="table-icon"> -->

            </button>

        <?php endif; ?>
    </td>

    <!-- Desktop Share -->
<td class="share-column">
    <button type="button"
            class="btn btn-primary2"
            onclick="shareAudio(<?= htmlspecialchars(json_encode($mp3Link), ENT_QUOTES, 'UTF-8') ?>)"
            aria-label="Share audio">
		<div class="link icon"></div>
        <!-- <img src="../../images/share.svg"
             alt="Share"
             class="table-icon"> -->

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
