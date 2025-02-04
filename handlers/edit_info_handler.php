<?php
include '../database/database.php';

try {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $fname = $_POST['fname'];
        $mname = $_POST['mname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $city = $_POST['city'];
        $bgry = $_POST['bgry'];

        $stmt = $conn->prepare("UPDATE information SET mname = ?, lname = ?, email = ?, city = ?, bgry = ? WHERE fname = ?");
        $stmt->bind_param("ssssss", $mname, $lname, $email, $city, $bgry, $fname);
        $stmt->execute();

    }
} catch (\Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}

$conn->close();
?>