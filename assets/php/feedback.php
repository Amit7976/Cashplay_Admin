<?php session_start();

include '../../server/conn.php';


if (isset($_COOKIE['6a5f450a43b7387dcb7d67e17d897498'])) {



    if (isset($_POST['deleteRating'])) {
        $feedback_id = mysqli_real_escape_string($conn, $_POST['feedback_id']);

        $sql = "SELECT `f_id` FROM `feedback` WHERE `f_id` = '$feedback_id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $sql = "DELETE FROM `feedback` WHERE `f_id` = '$feedback_id'";
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
