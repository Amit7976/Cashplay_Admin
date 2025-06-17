
<?php session_start(); ?>

<?php

include '../../server/conn.php';
include "user_information.php";
include "userLocation.php";


/// login start
// echo 'hii i am in 2';
// echo $_COOKIE['6a5f450a43b7387dcb7d67e17d897498'];
if (!isset($_COOKIE['6a5f450a43b7387dcb7d67e17d897498'])) {

    function decryptPassword($encrypted, $key)
    {
        $cipher = "aes-256-cbc";
        $ivlen = openssl_cipher_iv_length($cipher);
        $encrypted = base64_decode($encrypted);
        $iv = substr($encrypted, 0, $ivlen);
        $encrypted = substr($encrypted, $ivlen);
        $decrypted = openssl_decrypt($encrypted, $cipher, $key, OPENSSL_RAW_DATA, $iv);
        return $decrypted;
    }


    // echo 'hii i am in 1';
    if (isset($_POST['forLogin'])) {
        // echo 'hii i am in';
        $phone_number = mysqli_real_escape_string($conn, ($_POST['phone_number']));
        $user_pass = mysqli_real_escape_string($conn, ($_POST['login_pass']));

        // Check if the connection was successful
        if (!$conn) {
            die('Failed to connect to the database: ' . mysqli_connect_error());
        }


        // Retrieve user's encrypted password from the database
        $stmt = $conn->prepare("SELECT `a_name`, `a_number`, `a_login_access`, `a_pin` FROM admins WHERE a_number = ?");
        $stmt->bind_param('s', $phone_number);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Decrypt the stored password
            $key = $phone_number;
            $stored_pass = decryptPassword($row['a_pin'], $key);

            // Verify the password
            if ($user_pass === $stored_pass) {

                if ($row['a_login_access'] == "1") {

                    

                    // Start session if not already started
                    if (session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }


                    $_SESSION["6a5f450a43b7387dcb7d67e17d897498"] = true;
                    $_SESSION["admin_name"] = $row['a_name'];
                    $_SESSION["admin_phone_number"] = $row['a_number'];

                    // SET COOKIES START
                    setcookie('6a5f450a43b7387dcb7d67e17d897498', true, time() + 60 * 60 * 24 * 30, '/');
                    setcookie('admin_name', $row['a_name'], time() + 60 * 60 * 24 * 30, '/');
                    setcookie('admin_phone_number', $row['a_number'], time() + 60 * 60 * 24 * 30, '/');
                    // SET COOKIES END


                    $user_number = $row['a_number'];

                    $user_ip = UserInfo::get_ip();
                    $user_os = UserInfo::get_os();
                    $user_browser = UserInfo::get_browser();
                    $user_device = UserInfo::get_device();

                    // ----------- inset LOGIN ACTIVITY database ------------
                    $Location = $locCity . " " . $locState . " " . $locCountry . " " . $locZip;

                    $query = "INSERT INTO admin_login_activity(`admin_number`,`la_location`,`la_city`,`la_state`,`la_country`,`la_zip`,`la_ip`,`la_os`,`la_browser`,`la_login_device`) VALUES ('$user_number','$Location','$locCity','$locState','$locCountry','$locZip','$user_ip','$user_os','$user_browser','$user_device')";
                    $query_run = mysqli_query($conn, $query);

                    // ----------- inset LOGIN ACTIVITY database ------------


                    $response = array(
                        'status' => 'loginSuccess',
                    );


                } else {
                    $response = array(
                        'status' => 'declineLoginAccess',
                    );
                }
            }else{
                $response = array(
                    'status' => 'passwordWrong',
                );   
            }
        } else {
            // Create an associative array with the response data
            $response = array(
                'status' => 'loginFail',
            );
        }
    }
}else{

    // Create an associative array with the response data
    $response = array(
        'status' => 'Already_Login',
    );
}

// Close the database connection
mysqli_close($conn);

// Convert the response array to JSON and send the response
echo json_encode($response);
?>