<?php
include '../database/database.php';

header('Content-Type: application/json'); 

try {
    if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['name'])) {
        $name = trim($_GET['name']);

        // Prepare the statement
        $stmt = $conn->prepare("SELECT * FROM information WHERE fname = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode(['error' => 'No record found']);
        }

        $stmt->close();
    } else {
        echo json_encode(['error' => 'Invalid request']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}

$conn->close();
?>
