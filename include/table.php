

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
		
<svg fill="currentColor" width="16px" height="16px" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg"><path d="M1129.432 113v1694.148H903.545l-451.772-451.773V564.773L903.545 113h225.887Zm542.545 248.057C1832.017 521.097 1920 733.882 1920 960.107c0 226.226-87.983 438.898-248.023 598.938l-79.851-79.85c138.694-138.582 214.93-323.018 214.93-519.087 0-196.183-76.236-380.506-214.93-519.2ZM338.83 564.773v790.602H169.415C75.672 1355.375 0 1279.703 0 1185.96V734.187c0-93.742 75.672-169.414 169.415-169.414H338.83Zm1093.922 36.085c95.776 97.018 148.407 224.644 148.407 359.16 0 134.628-52.631 262.253-148.407 359.272l-80.303-79.174c74.656-75.897 115.767-175.4 115.767-280.099 0-104.585-41.111-204.088-115.767-279.986Z" fill-rule="evenodd"/></svg>
                <!-- <img src="../../images/soundwave.svg"
                     alt="Audio"
                     class="table-icon">  -->

            </button>

            <!-- Video -->
            <?php if (!empty($row['youtube'])): ?>

                <button type="button"
				class="btn btn-primary2"
                        onclick="openVideo('<?= htmlspecialchars($row['youtube']) ?>')">
<svg width="16px" height="16px" viewBox="0 -3 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g id="Dribbble-Light-Preview" transform="translate(-300.000000, -7442.000000)" fill="currentColor"><g id="icons" transform="translate(56.000000, 160.000000)"><path d="M251.988432,7291.58588 L251.988432,7285.97425 C253.980638,7286.91168 255.523602,7287.8172 257.348463,7288.79353 C255.843351,7289.62824 253.980638,7290.56468 251.988432,7291.58588 M263.090998,7283.18289 C262.747343,7282.73013 262.161634,7282.37809 261.538073,7282.26141 C259.705243,7281.91336 248.270974,7281.91237 246.439141,7282.26141 C245.939097,7282.35515 245.493839,7282.58153 245.111335,7282.93357 C243.49964,7284.42947 244.004664,7292.45151 244.393145,7293.75096 C244.556505,7294.31342 244.767679,7294.71931 245.033639,7294.98558 C245.376298,7295.33761 245.845463,7295.57995 246.384355,7295.68865 C247.893451,7296.0008 255.668037,7296.17532 261.506198,7295.73552 C262.044094,7295.64178 262.520231,7295.39147 262.895762,7295.02447 C264.385932,7293.53455 264.28433,7285.06174 263.090998,7283.18289" id="youtube-[#168]"></path></g></g></g></svg>
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
		<!-- <div class="link icon"></div> -->
<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M13.803 5.333c0-1.84 1.5-3.333 3.348-3.333A3.34 3.34 0 0 1 20.5 5.333c0 1.841-1.5 3.334-3.349 3.334-.933 0-1.777-.381-2.384-.994l-4.635 3.156a3.34 3.34 0 0 1-.182 1.917l5.082 3.34a3.35 3.35 0 0 1 2.12-.753 3.34 3.34 0 0 1 3.348 3.334C20.5 20.507 19 22 17.151 22a3.34 3.34 0 0 1-3.348-3.333c0-.483.103-.942.289-1.356L9.05 14a3.35 3.35 0 0 1-2.202.821A3.34 3.34 0 0 1 3.5 11.487a3.34 3.34 0 0 1 3.348-3.333c1.064 0 2.01.493 2.623 1.261l4.493-3.059a3.3 3.3 0 0 1-.161-1.023" clip-rule="evenodd"/></svg>
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

<svg fill="currentColor" width="16px" height="16px" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg"><path d="M1129.432 113v1694.148H903.545l-451.772-451.773V564.773L903.545 113h225.887Zm542.545 248.057C1832.017 521.097 1920 733.882 1920 960.107c0 226.226-87.983 438.898-248.023 598.938l-79.851-79.85c138.694-138.582 214.93-323.018 214.93-519.087 0-196.183-76.236-380.506-214.93-519.2ZM338.83 564.773v790.602H169.415C75.672 1355.375 0 1279.703 0 1185.96V734.187c0-93.742 75.672-169.414 169.415-169.414H338.83Zm1093.922 36.085c95.776 97.018 148.407 224.644 148.407 359.16 0 134.628-52.631 262.253-148.407 359.272l-80.303-79.174c74.656-75.897 115.767-175.4 115.767-280.099 0-104.585-41.111-204.088-115.767-279.986Z" fill-rule="evenodd"/></svg>
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
<svg width="16px" height="16px" viewBox="0 -3 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g id="Dribbble-Light-Preview" transform="translate(-300.000000, -7442.000000)" fill="currentColor"><g id="icons" transform="translate(56.000000, 160.000000)"><path d="M251.988432,7291.58588 L251.988432,7285.97425 C253.980638,7286.91168 255.523602,7287.8172 257.348463,7288.79353 C255.843351,7289.62824 253.980638,7290.56468 251.988432,7291.58588 M263.090998,7283.18289 C262.747343,7282.73013 262.161634,7282.37809 261.538073,7282.26141 C259.705243,7281.91336 248.270974,7281.91237 246.439141,7282.26141 C245.939097,7282.35515 245.493839,7282.58153 245.111335,7282.93357 C243.49964,7284.42947 244.004664,7292.45151 244.393145,7293.75096 C244.556505,7294.31342 244.767679,7294.71931 245.033639,7294.98558 C245.376298,7295.33761 245.845463,7295.57995 246.384355,7295.68865 C247.893451,7296.0008 255.668037,7296.17532 261.506198,7295.73552 C262.044094,7295.64178 262.520231,7295.39147 262.895762,7295.02447 C264.385932,7293.53455 264.28433,7285.06174 263.090998,7283.18289" id="youtube-[#168]"></path></g></g></g></svg>
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
		<!-- <div class="link icon"></div> -->
<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="M13.803 5.333c0-1.84 1.5-3.333 3.348-3.333A3.34 3.34 0 0 1 20.5 5.333c0 1.841-1.5 3.334-3.349 3.334-.933 0-1.777-.381-2.384-.994l-4.635 3.156a3.34 3.34 0 0 1-.182 1.917l5.082 3.34a3.35 3.35 0 0 1 2.12-.753 3.34 3.34 0 0 1 3.348 3.334C20.5 20.507 19 22 17.151 22a3.34 3.34 0 0 1-3.348-3.333c0-.483.103-.942.289-1.356L9.05 14a3.35 3.35 0 0 1-2.202.821A3.34 3.34 0 0 1 3.5 11.487a3.34 3.34 0 0 1 3.348-3.333c1.064 0 2.01.493 2.623 1.261l4.493-3.059a3.3 3.3 0 0 1-.161-1.023" clip-rule="evenodd"/></svg>
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
