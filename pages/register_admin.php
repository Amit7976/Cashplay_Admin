<?php

function encryptPassword($password, $key)
{
    $cipher = "aes-256-cbc";
    $ivlen = openssl_cipher_iv_length($cipher);
    $iv = openssl_random_pseudo_bytes($ivlen);
    $encrypted = openssl_encrypt($password, $cipher, $key, OPENSSL_RAW_DATA, $iv);
    $encrypted = $iv . $encrypted;
    return base64_encode($encrypted);
}


if (isset($_POST['register'])) {
    $name = mysqli_real_escape_string($conn, $_POST['a_name']);
    $email = mysqli_real_escape_string($conn, $_POST['a_email']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['a_number']);
    $pin = mysqli_real_escape_string($conn, $_POST['a_pin']);

    // Generate a unique key for each user (can be user's email or phone number)
    $key = $phone_number;

    // Encrypt the password
    $encrypted_pin = encryptPassword($pin, $key);

    // Insert user into the database
    $stmt = $conn->prepare("INSERT INTO admins (a_name, a_email, a_number, a_pin) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('ssss', $name, $email, $phone_number, $encrypted_pin);
    if ($stmt->execute()) {
        echo "Registration successful.";
    } else {
        echo "Registration failed.";
    }
    $stmt->close();
}
?>

<div class="w-full lg:h-screen mt-10 lg:mt-0 flex items-center justify-center overflow-scroll">
    <form method="post" action="" class="w-full mx-auto max-w-2xl flex flex-col gap-5 border p-10 bg-white rounded-box shadow-2xl">
        <h2 class="text-2xl my-5 font-semibold flex gap-2">Register New Admin <i class="fa-duotone fa-user-crown"></i></h2>
        <div>
            <label for="a_name" class="font-semibold">Name:</label><br>
            <input type="text" class="input w-full mt-3 border-[3px] border-gray-200 outline-none focus:outline-none ring-0" id="a_name" name="a_name" required placeholder="Enter Admin Name"><br>
        </div>
        <div>
            <label for="a_email" class="font-semibold">Email:</label><br>
            <input type="email" class="input w-full mt-3 border-[3px] border-gray-200 outline-none focus:outline-none ring-0" id="a_email" name="a_email" placeholder="Enter Admin Email Id (Optional)"><br>
        </div>
        <div>
            <label for="a_number" class="font-semibold">Phone Number:</label><br>
            <input type="text" class="input w-full mt-3 border-[3px] border-gray-200 outline-none focus:outline-none ring-0" id="a_number" name="a_number" required placeholder="Enter Admin Phone Number"><br>
        </div>
        <div>
            <label for="a_pin" class="font-semibold">Password:</label><br>
            <input type="password" maxlength="6" minlength="6" class="input w-full mt-3 border-[3px] border-gray-200 outline-none focus:outline-none ring-0" id="a_pin" name="a_pin" required placeholder="Enter Admin Password"><br>
        </div>
        <div>
            <input type="submit" class="btn w-full" name="register" value="Register">
        </div>
    </form>
</div>