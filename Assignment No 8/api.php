<?php
require_once 'db_config.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Allow local React frontend access
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

$request_method = $_SERVER['REQUEST_METHOD'];

switch ($request_method) {
    case 'GET':
        // Fetch all feedbacks from database
        try {
            $stmt = $pdo->query("SELECT * FROM feedbacks ORDER BY created_at DESC");
            $feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(['success' => true, 'data' => $feedbacks]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        break;

    case 'POST':
        // Save new feedback to database
        $data = json_decode(file_get_contents('php://input'), true);

        if ($data) {
            try {
                $stmt = $pdo->prepare("INSERT INTO feedbacks (studentName, course, instructor, semester, rating, comment) 
                                      VALUES (?, ?, ?, ?, ?, ?)");
                
                $result = $stmt->execute([
                    $data['studentName'],
                    $data['course'],
                    $data['instructor'],
                    $data['semester'],
                    $data['rating'],
                    $data['comment']
                ]);

                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Feedback saved successfully']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to save feedback']);
                }
            } catch (PDOException $e) {
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid data provided']);
        }
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Invalid request method']);
        break;
}
?>
