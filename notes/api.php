<?php
require __DIR__ . '/config_keep.php';

header('Content-Type: application/json; charset=utf-8');

$action = isset($_GET['action']) ? $_GET['action'] : '';

try {
    $db = getDB();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(array(
        'error' => 'Database connection failed: ' . $e->getMessage(),
        'hint' => 'Check config.php credentials and ensure MySQL is running.'
    ));
    exit;
}

try {
    switch ($action) {

        case 'list':
            $search = isset($_GET['search']) ? trim($_GET['search']) : '';
            if ($search !== '') {
                $param = '%' . $search . '%';
                $stmt = $db->prepare("
                    SELECT id, title, color, updated_at,
                           LEFT(content, 200) AS preview
                    FROM notes
                    WHERE title LIKE ? OR content LIKE ?
                    ORDER BY updated_at DESC
                    LIMIT 1000
                ");
                $stmt->execute(array($param, $param));
            } else {
                $stmt = $db->query("
                    SELECT id, title, color, updated_at,
                           LEFT(content, 200) AS preview
                    FROM notes
                    ORDER BY updated_at DESC
                    LIMIT 1000
                ");
            }
            echo json_encode($stmt->fetchAll());
            break;

        case 'get':
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if (!$id) throw new Exception('Invalid note ID');
            $stmt = $db->prepare("SELECT * FROM notes WHERE id = ?");
            $stmt->execute(array($id));
            $note = $stmt->fetch();
            echo json_encode($note ? $note : array('error' => 'Note not found'));
            break;

        case 'save':
            $raw = file_get_contents('php://input');
            $data = json_decode($raw, true);
            if (!is_array($data)) {
                throw new Exception('Invalid JSON body received. Raw: ' . substr($raw, 0, 200));
            }

            $id = isset($data['id']) ? filter_var($data['id'], FILTER_VALIDATE_INT) : 0;
            if (!$id) $id = 0;
            $title = isset($data['title']) ? trim($data['title']) : 'Untitled';
            if ($title === '') $title = 'Untitled';
            $content = isset($data['content']) ? $data['content'] : '';
            $color = isset($data['color']) && preg_match('/^#[0-9A-F]{6}$/i', $data['color'])
                ? $data['color']
                : '#ffffff';

            if ($id > 0) {
                $stmt = $db->prepare("
                    UPDATE notes SET title = ?, content = ?, color = ? WHERE id = ?
                ");
                $stmt->execute(array($title, $content, $color, $id));
            } else {
                $stmt = $db->prepare("
                    INSERT INTO notes (title, content, color) VALUES (?, ?, ?)
                ");
                $stmt->execute(array($title, $content, $color));
                $id = (int)$db->lastInsertId();
            }

            echo json_encode(array(
                'success' => true,
                'id' => $id,
                'updated_at' => date('Y-m-d H:i:s')
            ));
            break;

        case 'delete':
            $raw = file_get_contents('php://input');
            $data = json_decode($raw, true);
            $id = isset($data['id']) ? filter_var($data['id'], FILTER_VALIDATE_INT) : 0;
            if (!$id) throw new Exception('Invalid note ID');
            $stmt = $db->prepare("DELETE FROM notes WHERE id = ?");
            $stmt->execute(array($id));
            echo json_encode(array('success' => true));
            break;

        default:
            throw new Exception('Invalid action: ' . $action);
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(array(
        'error' => $e->getMessage(),
        'file' => basename($e->getFile()),
        'line' => $e->getLine()
    ));
}
