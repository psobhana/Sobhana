
<?php
require_once 'config_notes.php';

header('Content-Type: text/plain; charset=UTF-8');
header('Cache-Control: no-store, no-cache, must-revalidate');

try {
    $stmt = $pdo->prepare(
        "SELECT content FROM notes WHERE id = :id LIMIT 1"
    );

    $stmt->execute(['id' => 1]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    echo $row ? ($row['content'] ?? '') : '';

} catch (PDOException $e) {
    http_response_code(500);
    echo 'Database loading failed.';
}
?>
