<?php session_start();

include '../../server/conn.php';


if (isset($_COOKIE['6a5f450a43b7387dcb7d67e17d897498'])) {

    if (isset($_POST['updateImage'])) {
        if (isset($_POST['id']) && isset($_FILES['image'])) {
            $id = $conn->real_escape_string($_POST['id']);
            $image = $_FILES['image']['name'];
            $target_dir = "../img/games/";
            $target_file = $target_dir . basename($image);

            // Fetch the current image name from the database
            $current_image_sql = "SELECT `game_image` FROM `games` WHERE `game_id` = '$id'";
            $current_image_result = $conn->query($current_image_sql);

            if ($current_image_result->num_rows > 0) {
                $current_image_row = $current_image_result->fetch_assoc();
                $current_image = $current_image_row['game_image'];
                $current_image_path = $target_dir . $current_image;

                // Check if the current image file exists
                if (file_exists($current_image_path)) {
                    // Rename the current image file by appending the current timestamp
                    $timestamp = time();
                    $new_name = pathinfo($current_image_path, PATHINFO_FILENAME) . "_old_$timestamp." . pathinfo($current_image_path, PATHINFO_EXTENSION);
                    rename($current_image_path, $target_dir . $new_name);
                }
            }

            // Debugging information
            $is_uploaded_file = is_uploaded_file($_FILES['image']['tmp_name']);
            $file_exists = file_exists($target_dir);
            $is_dir = is_dir($target_dir);
            $is_writable = is_writable($target_dir);

            // Check if the file was properly uploaded
            if (!$is_uploaded_file) {
                $response = array(
                    'status' => 'error',
                    'message' => 'File upload error.',
                    'debug' => array(
                        'is_uploaded_file' => $is_uploaded_file,
                        'file' => $_FILES['image']['tmp_name']
                    )
                );
            } else if (!$file_exists || !$is_dir || !$is_writable) {
                $response = array(
                    'status' => 'error',
                    'path' => $target_dir,
                    'message' => 'Target directory is not writable or does not exist.',
                    'debug' => array(
                        'file_exists' => $file_exists,
                        'is_dir' => $is_dir,
                        'is_writable' => $is_writable
                    )
                );
            } else if (file_exists($target_file)) {
                $response = array(
                    'status' => 'error',
                    'message' => 'File with the same name already exists.',
                );
            } else if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                $sql = "UPDATE `games` SET `game_image` = '$image' WHERE `game_id` = '$id'";
                if ($conn->query($sql) === TRUE) {
                    $response = array(
                        'status' => 'success',
                        'new_image_url' => 'assets/img/games/' . $image,
                    );
                } else {
                    $response = array(
                        'status' => 'error',
                        'message' => 'Database update error.',
                        'debug' => array(
                            'sql' => $sql,
                            'error' => $conn->error
                        )
                    );
                }
            } else {
                $response = array(
                    'status' => 'error',
                    'message' => 'Failed to move file to target directory.',
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Incomplete data received.',
            );
        }
    }







    if (isset($_POST['updateFields'])) {
        if (isset($_POST['id']) && isset($_POST['field']) && isset($_POST['value'])) {
            $id = $conn->real_escape_string($_POST['id']);
            $field = $conn->real_escape_string($_POST['field']);
            $value = $conn->real_escape_string($_POST['value']);

            $sql = "UPDATE `games` SET `$field` = '$value' WHERE `game_id` = '$id'";

            if ($conn->query($sql) === TRUE) {
                $response = array(
                    'status' => 'success',
                );
            } else {
                $response = array(
                    'status' => 'failed',
                );
            }
        } else {
            $response = array(
                'status' => 'error',
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
