<?php session_start();

include '../../server/conn.php';
include "user_information.php";
include "userLocation.php";


if (isset($_COOKIE['6a5f450a43b7387dcb7d67e17d897498'])) {

    $sql = "SELECT COUNT(*) AS count FROM `transaction_details` WHERE `t_payment_via` = 'Withdraw' AND `t_status` = 'Review'";
    $result = $conn->query($sql);

    $response = array();
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $count = $row['count'];
        if ($count > 0) {
            $response['status'] = 'found';
            $response = array(
                'status' => 'found',
            );
        } else {
            $response = array(
                'status' => 'not_found',
            );
        }
    } else {
        $response['status'] = 'error';
    }

    header('Content-Type: application/json');
} else {
    header("Location: /auth/login.php");
}


mysqli_close($conn);
echo json_encode($response);
