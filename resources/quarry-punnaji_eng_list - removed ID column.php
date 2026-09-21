<?php
require_once '../../include/db_config.php';
		
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
/* ORDER BY id DESC  - descending order*/
$sql = "SELECT * FROM Talk_list2
        WHERE author = ?
        AND length = ?
        AND language = ?
        ORDER BY id ASC
        LIMIT $limit OFFSET $offset";

$stmt = $pdo->prepare($sql);
$stmt->execute([$author, $length, $language]);
$talks = $stmt->fetchAll();
?>

<section-max class="meditations">

    <div class="container_max">
         <!-- <div style="text-align:center;margin-bottom:48px">
           <h2 class="section-title">Bhante Punnaji</h2> 
         <p style="color:#57534e">Start teachers</p>
        </div>  -->

        <div class="meditation-grid_max">
		
            <div class="meditation">
                <div class="teacher-image teacher-1">
                    <img src="../../images/punnaji.webp"
                         alt="Punnaji Thero">
                </div>
                <div style="flex:1">
                    <h3>Bhante Punnaji</h3>
                    <!-- <p></p> -->
					
               <div class="meditation-bottom">			
                        <span class="duration">Archive.org files</span>
                        <a href="https://www.sobhana.net/audio/english/bodhi/index.htm" target="_blank" class="card-link">
						<button class="listen">Archive</button></a>
                </div>
					
               <div class="meditation-bottom">			
                        <span class="duration">Old site</span>
                        <a href="https://www.sobhana.net/audio/english/bodhi/index.htm" target="_blank" class="card-link">
						<button class="listen">Sobhana.net</button></a>
                </div>					
					
					
		</div>
            </div>

        </div>
    </div>
	
	


<div class="container_max"> 

        <div class="meditation-grid_max"> 
		
              <!--  <div class="meditation">  -->

           <!--  <div style="flex:1">   -->
                  

	 <!-- added start-->	
	 
<div class="card_table">

    <div class="table-wrapper">
        <table>
            <tr>
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
                <td><?= htmlspecialchars($row['file_number']) ?></td>

                <td><?= htmlspecialchars($row['title']) ?></td>

                <td>
                    <button class="btn btn-primary"
                        onclick="playAudio('<?= $mp3Link ?>')">
                        <img src="../../images/soundwave.svg"
                             alt="Audio"
                             class="table-icon">
                    </button>
                </td>

                <td>
                    <?php if ($row['youtube']): ?>
                        <button class="btn btn-primary"
                            onclick="openVideo('<?= htmlspecialchars($row['youtube']) ?>')">
                            <img src="../../images/youtube2.svg"
                                 alt="YouTube"
                                 class="table-icon">
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
<!-- added end-->	

				
					
		<!-- </div>  -->
           <!-- </div>  -->

</div>
</div>

</section-max>
