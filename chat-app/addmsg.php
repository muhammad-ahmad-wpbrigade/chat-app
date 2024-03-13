<?php
    session_start();
    include "db.php";

    // Validate input to avoid SQL injection
    $msg = isset($_GET["msg"]) ? mysqli_real_escape_string($db, $_GET["msg"]) : '';
    $phone = isset($_SESSION["phone"]) ? mysqli_real_escape_string($db, $_SESSION["phone"]) : '';

    if (empty($phone)) {
        // Handle the case where "phone" is not set in the session
        echo "Phone number not set in session";
        exit;
    }

    // Check if user with the given phone number exists
    $userQuery = "SELECT * FROM `user` WHERE phone='$phone'";
    $userResult = mysqli_query($db, $userQuery);

    if ($userResult) {
        if (mysqli_num_rows($userResult) == 1) {
            // User exists, proceed to insert the message
            $insertQuery = "INSERT INTO `msg` (`phone`, `msg`) VALUES ('$phone', '$msg')";
            
            if ($insertResult = mysqli_query($db, $insertQuery)) {
                // Message successfully inserted
                // You can add additional logic or send a response back to the client if needed
            } else {
                // Handle the error if the insertion fails
                echo "Error: " . mysqli_error($db);
            }
        } else {
            // Handle the case where the user does not exist
            echo "User not found";
        }
    } else {
        // Handle the error if the user query fails
        echo "Error: " . mysqli_error($db);
    }
?>
