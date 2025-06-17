<?php session_start();

include '../../server/conn.php';


if (isset($_COOKIE['6a5f450a43b7387dcb7d67e17d897498'])) {

    if (isset($_POST['get_support_details'])) {

        $support_id = mysqli_real_escape_string($conn, ($_POST['support_id']));

        $sql = "SELECT * FROM `contact_us` WHERE `CU_id` = '$support_id'";
        $result = $conn->query($sql);

        $response = array();
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $response = array(
                'status' => 'success',
                'data' => $row,
            );
        } else {
            $response['status'] = 'error';
        }

        header('Content-Type: application/json');
    }






    if (isset($_POST['update'])) {

        // Get the form data from AJAX request
        $cu_id = intval($_POST['CU_id']);
        $cu_name = mysqli_real_escape_string($conn, $_POST['CU_name']);
        $cu_description = mysqli_real_escape_string($conn, $_POST['CU_description']);
        $cu_icon = mysqli_real_escape_string($conn, $_POST['CU_icon']);
        $cu_link = mysqli_real_escape_string($conn, $_POST['CU_link']);
        $cu_media = mysqli_real_escape_string($conn, $_POST['CU_media']);
        $cu_status = intval($_POST['CU_status']);

        // Update the record in the database
        $sql = "UPDATE `contact_us` SET 
                `CU_name` = '$cu_name',
                `CU_description` = '$cu_description',
                `CU_icon` = '$cu_icon',
                `CU_link` = '$cu_link',
                `CU_media` = '$cu_media',
                `CU_status` = '$cu_status'
                WHERE `CU_id` = $cu_id";


        $updateResult = $conn->query($sql);

        if ($updateResult) {
            $response = array(
                'status' => 'success',
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Error updating record: ' . $conn->error,
            );
        }
        header('Content-Type: application/json');
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
