<?php 
include '../connect.php'; 

// Function to sanitize input data
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Retrieve and sanitize email and verification code
$email = sanitize(filterRequest('email'));
$verify = sanitize(filterRequest('verifycode'));

// Prepare and execute SQL query
$stmt = $con->prepare("SELECT * FROM user WHERE user_email = ? AND user_verifyCode = ?");
$stmt->execute([$email, $verify]);
$count = $stmt->rowCount();
if ($count > 0) { 
    $data = array("verified" => "1");
    // Update verified status in the database
    updateData("user", $data, "user_email = '$email'");
} else {
    // Return JSON response with error message
    $response = array("error" => "wrong otp");
    echo json_encode($response);
}

