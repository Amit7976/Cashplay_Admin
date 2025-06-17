<?php session_start();

include '../../server/conn.php';


if (isset($_COOKIE['6a5f450a43b7387dcb7d67e17d897498'])) {

    if (isset($_POST['visibilityControl'])) {
        $user_unique = mysqli_real_escape_string($conn, $_POST['user_unique']);

        $sql = "SELECT `ar_status` FROM `app_rating` WHERE `ar_user_unique` = '$user_unique'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $newStatus = $row['ar_status'] == 1 ? 0 : 1;

            $sql = "UPDATE `app_rating` SET `ar_status` = '$newStatus' WHERE `ar_user_unique` = '$user_unique'";
            $updateResult = $conn->query($sql);

            if ($updateResult) {
                $response = array(
                    'status' => 'success',
                    'ar_status' => $newStatus,
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'message' => 'Failed to update status.',
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Record not found.',
            );
        }
    }






    if (isset($_POST['deleteRating'])) {
        $user_unique = mysqli_real_escape_string($conn, $_POST['user_unique']);

        $sql = "SELECT `ar_status` FROM `app_rating` WHERE `ar_user_unique` = '$user_unique'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $sql = "DELETE FROM `app_rating` WHERE `ar_user_unique` = '$user_unique'";
            $deleteResult = $conn->query($sql);

            if ($deleteResult) {
                $response = array(
                    'status' => 'success',
                    'message' => 'Record deleted successfully.',
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'message' => 'Failed to delete record.',
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Record not found.',
            );
        }
    }
} else {
    header("Location: /auth/login.php");
}


mysqli_close($conn);
if (isset($response)) {
    header('Content-Type: application/json');
    echo json_encode($response);
}
