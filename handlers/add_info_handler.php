<?php

include "../database/database.php";

try {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $fname = $_POST['fname'];
        $mname = $_POST['mname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $city = $_POST['city'];
        $bgry = $_POST['bgry'];

        $checkStmt = $conn->prepare("SELECT * FROM information WHERE fname = ? AND lname = ?");
        $checkStmt->bind_param("ss", $fname, $lname);
        $checkStmt->execute();
        $result = $checkStmt->get_result();

        if ($result->num_rows > 0) {
            header("Location: ../index.php?error=Record already exists");
            exit;
        } else {
            $stmt = $conn->prepare("INSERT INTO information (fname, mname, lname, email, city, bgry) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $fname, $mname, $lname, $email, $city, $bgry);

            if ($stmt->execute()) {
                header("Location: ../index.php");
                exit;
            } else {
                echo "Operation failed";
            }
        }
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}

?>