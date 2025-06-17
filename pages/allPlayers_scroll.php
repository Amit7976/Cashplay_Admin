<?php
session_start();

include '../server/conn.php';

if (!isset($_COOKIE['6a5f450a43b7387dcb7d67e17d897498'])) {

    header("Location: /auth/login.php");
    exit();
}




$start = isset($_POST['start']) ? $_POST['start'] : 0;
$limit = isset($_POST['limit']) ? $_POST['limit'] : 20;

$user_details = $conn->query("SELECT `id`, `avatar`, `game_uid`, `user_name`, `phone_number`, `user_unique`, `country`, `total_balance`, `total_withdraw_balance`, `log_out_globally`, `login_access` FROM user_details ORDER BY `date_time` DESC LIMIT $start, $limit");

// Check if any rows were returned
if (mysqli_num_rows($user_details) > 0) {
    // Loop through each row in the result set
    while ($row = mysqli_fetch_assoc($user_details)) {
?>
        <tr id="user_unique_<?php echo $row['user_unique'] ?>">
            <td class="whitespace-nowrap">
                <div class="px-6 py-3 overflow-hidden">
                    <div class="flex items-center gap-x-3 w-max truncate">
                        <img class="inline-block size-[38px] rounded-full" src="https://cashplay.in/assets/img/avatar/<?php echo $row['avatar'] ?>" alt="<?php echo $row['user_name'] ?>'s Avatar">
                        <div class="grow">
                            <span class="block text-sm font-semibold text-gray-800 dark:text-gray-200"><?php echo $row['user_name'] ?></span>
                            <span class="block text-sm text-gray-500"><?php echo $row['user_unique'] ?></span>
                        </div>
                    </div>
                </div>
            </td>
            <td class="whitespace-nowrap">
                <div class="px-6 py-3">
                    <span class="block text-sm text-gray-500 editable-text2" data-id="<?php echo $row['id'] ?>" data-field="total_balance" data-value="<?php echo $row['total_balance'] ?>"><?php echo $row['total_balance'] ?></span>
                </div>
            </td>
            <td class="whitespace-nowrap">
                <div class="px-6 py-3">
                    <span class="block text-sm text-gray-500 editable-text2" data-id="<?php echo $row['id'] ?>" data-field="total_withdraw_balance" data-value="<?php echo $row['total_withdraw_balance'] ?>"><?php echo $row['total_withdraw_balance'] ?></span>
                </div>
            </td>
            <td class="whitespace-nowrap">
                <div class="px-6 py-3">
                    <span class="block text-sm text-gray-500 editable-text2" data-id="<?php echo $row['id'] ?>" data-field="game_uid" data-value="<?php echo $row['game_uid'] ?>"><?php echo $row['game_uid'] ?></span>
                </div>
            </td>
            <td class="whitespace-nowrap">
                <div class="px-6 py-3">
                    <span class="block text-sm text-gray-500"><?php echo $row['country'] ?> <span class="editable-text2" data-id="<?php echo $row['id'] ?>" data-field="phone_number" data-value="<?php echo $row['phone_number'] ?>"><?php echo $row['phone_number'] ?></span></span>
                </div>
            </td>
            <td class="whitespace-nowrap">
                <div class="px-6 py-3 flex justify-end">
                    <select class="select2 bg-white text-sm cursor-pointer outline-none">
                        <option <?php echo (($row['login_access'] != 1 && $row['log_out_globally'] != 1) ? 'selected' : '') ?> value="Active" class="text-green-500">Active</option>
                        <option <?php echo ($row['log_out_globally'] == 1 ? 'selected' : '') ?> value="Logout" class="text-amber-500">Logout</option>
                        <option <?php echo ($row['login_access'] != 1 ? 'selected' : '') ?> value="Blocked" class="text-red-500">Blocked</option>
                    </select>
                </div>
            </td>
            <td class="whitespace-nowrap">
                <div class="px-6">
                    <button class="btn" onclick="runningTableDetailsShowModal('<?php echo $row['id'] ?>')">Details</button>
                </div>
            </td>
        </tr>
<?php
    }
} else {
    echo "";
}
?>