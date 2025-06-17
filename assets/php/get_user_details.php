<?php session_start();

include '../../server/conn.php';


if (isset($_COOKIE['6a5f450a43b7387dcb7d67e17d897498'])) {

    if (isset($_POST['get_user_details'])) {

        $id = mysqli_real_escape_string($conn, ($_POST['id']));

        $sql = "SELECT * FROM `user_details` WHERE `id` = '$id'";
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



    if (isset($_POST['updateFields'])) {
        $id = $_POST['id'];
        $field = $_POST['field'];
        $value = $_POST['value'];

        // Sanitize the value for specific fields
        if (in_array($field, ['phone_number', 'user_unique'])) {
            $value = preg_replace('/\D/', '', $value);
        }


        $query = "UPDATE user_details SET $field = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('si', $value, $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $response = array(
                'status' => 'success',
            );
        } else {
            $response = array(
                'status' => 'fail',
            );
        }

        // header('Content-Type: application/json');
        echo json_encode($response);
        exit(); // Ensure no additional output is sent
    }





    if (isset($_POST['get_user_ratings'])) {

        $user_unique = mysqli_real_escape_string($conn, ($_POST['user_unique']));

        $sql = "SELECT `ar_rating`, `ar_review`, `ar_status`, `ar_date_time` FROM `app_rating` WHERE `ar_user_unique` = '$user_unique'";
        $result = $conn->query($sql);

        $response = array();
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $response = array(
                'status' => 'success',
                'ar_rating' => $row['ar_rating'],
                'ar_review' => $row['ar_review'],
                'ar_status' => $row['ar_status'],
                'ar_date_time' => $row['ar_date_time'],
            );
        } else {
            $response = array(
                'status' => 'success',
                'ar_rating' => '0',
                'ar_review' => '--',
                'ar_status' => '--',
                'ar_date_time' => 'Not Yet',
            );
        }

        header('Content-Type: application/json');
    }







    if (isset($_POST['get_user_feedback'])) {
        $user_unique = mysqli_real_escape_string($conn, $_POST['user_unique']);

        // Ensure that no PHP warnings or errors are outputted
        error_reporting(0);
        ini_set('display_errors', 0);

        $sql = "SELECT `f_feedback`, `f_vote`, `f_date_time` FROM `feedback` WHERE `f_user_unique` = '$user_unique' ORDER BY `f_date_time` DESC";
        $result = $conn->query($sql);

        $response = array();
        if ($result && $result->num_rows > 0) {
            $feedbacks = array();
            while ($row = $result->fetch_assoc()) {
                $feedbacks[] = array(
                    'f_feedback' => $row['f_feedback'],
                    'f_vote' => $row['f_vote'],
                    'f_date_time' => $row['f_date_time'],
                );
            }
            $response = array(
                'status' => 'success',
                'feedbacks' => $feedbacks
            );
        } else {
            $response = array(
                'status' => 'success',
                'feedbacks' => array()
            );
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        exit(); // Ensure no additional output is sent
    }













    if (isset($_POST['get_user_games_details'])) {
        $user_unique = mysqli_real_escape_string($conn, $_POST['user_unique']);

        // Query for total matches played with status 'Complete' and sum of b_price
        $query1 = "SELECT COUNT(*) AS match_count, SUM(b_price) AS total_price
               FROM battles
               WHERE (b_creator_id = '$user_unique' OR b_player2_id = '$user_unique') AND b_status = 'Complete'";

        // Query for matches won by the user and sum of b_won_amount
        $query2 = "SELECT COUNT(*) AS win_count, SUM(b_won_amount) AS total_won_amount
               FROM battles
               WHERE b_winner_id = '$user_unique' AND b_status = 'Complete'";

        // Query for matches not won by the user and sum of b_price
        $query3 = "SELECT COUNT(*) AS lose_count, SUM(b_price) AS total_lost_price
               FROM battles
               WHERE (b_creator_id = '$user_unique' OR b_player2_id = '$user_unique') AND b_winner_id != '$user_unique' AND b_status = 'Complete'";

        // Query for matches with status 'Leave'
        $query4 = "SELECT COUNT(*) AS leave_count
               FROM battles
               WHERE (b_creator_id = '$user_unique' OR b_player2_id = '$user_unique') AND b_status = 'Leave'";

        // Query for matches with status 'Leave'
        $query5 = "SELECT COUNT(*) AS cancel_count
               FROM battles
               WHERE (b_creator_id = '$user_unique' OR b_player2_id = '$user_unique') AND b_status = 'Cancel'";

        // Query for matches with b_game 'Classic'
        $query6 = "SELECT COUNT(*) AS classic_count
               FROM battles
               WHERE (b_creator_id = '$user_unique' OR b_player2_id = '$user_unique') AND b_game = 'Classic'";

        // Query for matches with b_game 'Popular'
        $query7 = "SELECT COUNT(*) AS popular_count
               FROM battles
               WHERE (b_creator_id = '$user_unique' OR b_player2_id = '$user_unique') AND b_game = 'Popular'";

        // Query for matches with b_game 'Quick'
        $query8 = "SELECT COUNT(*) AS quick_count
               FROM battles
               WHERE (b_creator_id = '$user_unique' OR b_player2_id = '$user_unique') AND b_game = 'Quick'";

        // Query for matches with b_game 'Two Token'
        $query9 = "SELECT COUNT(*) AS two_token_count
               FROM battles
               WHERE (b_creator_id = '$user_unique' OR b_player2_id = '$user_unique') AND b_game = 'Two Token'";

        // Query for matches with b_game 'Three Token'
        $query10 = "SELECT COUNT(*) AS three_token_count
               FROM battles
               WHERE (b_creator_id = '$user_unique' OR b_player2_id = '$user_unique') AND b_game = 'Three Token'";

        $response = array('status' => 'success');

        $queries = array($query1, $query2, $query3, $query4, $query5, $query6, $query7, $query8, $query9, $query10);
        $keys = array('complete_matches', 'won_matches', 'lost_matches', 'leave_matches', 'cancel_matches', 'classic_matches', 'popular_matches', 'quick_matches', 'two_token_matches', 'three_token_matches');

        foreach ($queries as $index => $query) {
            $result = $conn->query($query);
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $response[$keys[$index]] = $row;
            } else {
                $response[$keys[$index]] = ($index == 0) ? array('match_count' => 0, 'total_price' => 0) : array('count' => 0, 'sum' => 0);
            }
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }






    if (isset($_POST['get_user_battles_details'])) {

        $user_unique = mysqli_real_escape_string($conn, $_POST['user_unique']);

        $query = "SELECT battles.b_id, battles.b_room_code, battles.b_created_at, battles.b_status, battles.b_game, battles.b_price, battles.b_player2_id, battles.b_creator_id, battles.b_room_code, user1.user_name as creator_name, user1.avatar as creator_avatar, 
              user2.user_name as player2_name, user2.avatar as player2_avatar 
              FROM battles
              LEFT JOIN user_details as user1 ON battles.b_creator_id = user1.user_unique
              LEFT JOIN user_details as user2 ON battles.b_player2_id = user2.user_unique
              WHERE (user1.user_unique LIKE '%$user_unique%' OR user2.user_unique LIKE '%$user_unique%')";
        $query .= " ORDER BY `b_created_at` DESC LIMIT 5";

        // echo $query;
        $result = $conn->query($query);

        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {
?>
                <tr id="battle_id_<?php echo htmlspecialchars($row['b_id']) ?>" class="bg-white hover:bg-gray-50 dark:bg-slate-900 dark:hover:bg-slate-800">
                    <td class="size-px whitespace-nowrap px-6 py-3"><a href="#" class="cursor-pointer">
                            <p class="text-sm text-blue-500 dark:text-gray-200">#<?php echo htmlspecialchars($row['b_id']) ?></p>
                        </a></td>
                    <td class="size-px whitespace-nowrap px-6 py-3"><a href="#" class="cursor-pointer">
                            <p class="text-sm text-amber-500"><?php echo htmlspecialchars($row['b_room_code']) ?></p>
                        </a></td>
                    <td class="size-px whitespace-nowrap">
                        <div class="p-5 cursor-pointer overflow-hidden">
                            <div class="flex items-center gap-x-2 w-max truncate">
                                <img class="inline-block size-9 rounded-full" src="https://cashplay.in/assets/img/avatar/<?php echo htmlspecialchars($row['creator_avatar']) ?>" alt="<?php echo htmlspecialchars($row['creator_name']) ?>'s Avatar">
                                <div class="flex flex-col gap-0.5">
                                    <span class="text-sm text-gray-600 dark:text-gray-400 capitalize font-medium"><?php echo htmlspecialchars($row['creator_name']) ?></span>
                                    <span class="text-xs text-gray-400 dark:text-gray-600 capitalize font-medium"><?php echo htmlspecialchars($row['b_creator_id']) ?></span>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="size-px whitespace-nowrap">
                        <div class="p-5 cursor-pointer overflow-hidden">
                            <div class="flex items-center gap-x-2 w-max truncate">
                                <img class="inline-block size-9 rounded-full" src="https://cashplay.in/assets/img/avatar/<?php echo htmlspecialchars($row['player2_avatar']) ?>" alt="<?php echo htmlspecialchars($row['player2_name']) ?>'s Avatar">
                                <div class="flex flex-col gap-0.5">
                                    <span class="text-sm text-gray-600 dark:text-gray-400 capitalize font-medium"><?php echo htmlspecialchars($row['player2_name']) ?></span>
                                    <span class="text-xs text-gray-400 dark:text-gray-600 capitalize font-medium"><?php echo htmlspecialchars($row['b_player2_id']) ?></span>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="size-px whitespace-nowrap px-8 py-3">
                        <p class="text-sm text-green-500"><?php echo htmlspecialchars($row['b_price']) ?>&#x20B9;</p>
                    </td>
                    <td class="size-px whitespace-nowrap px-6 py-3">
                        <p class="text-sm text-amber-500"><?php echo htmlspecialchars($row['b_game']) ?></p>
                    </td>
                    <td class="size-px whitespace-nowrap px-6 py-3">
                        <p class="text-sm text-green-500"><?php echo htmlspecialchars($row['b_status']) ?></p>
                    </td>
                    <td class="size-px whitespace-nowrap px-6 py-3">
                        <p class="text-sm text-gray-800 dark:text-white"><?php $date = new DateTime($row['b_created_at']);
                                                                            echo $date->format('h:i A - d M Y'); ?></p>
                    </td>
                    <td class="size-px whitespace-nowrap align-center">
                        <button class="btn" onclick="allBattleDetails('<?php echo htmlspecialchars($row['b_id']) ?>')"><a>Details</a></button>
                    </td>
                </tr>
            <?php
            }
        } else {
            echo '<tr><td colspan="9">No records found.</td></tr>';
        }

        exit();
    }





    if (isset($_POST['get_more_battles_details'])) {

        $user_unique = mysqli_real_escape_string($conn, $_POST['user_unique']);

        $start = isset($_POST['b_start']) ? $_POST['b_start'] : 0;
        $limit = isset($_POST['b_limit']) ? $_POST['b_limit'] : 5;

        $query = "SELECT battles.b_id, battles.b_room_code, battles.b_created_at, battles.b_status, battles.b_game, battles.b_price, battles.b_player2_id, battles.b_creator_id, battles.b_room_code, user1.user_name as creator_name, user1.avatar as creator_avatar, 
              user2.user_name as player2_name, user2.avatar as player2_avatar 
              FROM battles
              LEFT JOIN user_details as user1 ON battles.b_creator_id = user1.user_unique
              LEFT JOIN user_details as user2 ON battles.b_player2_id = user2.user_unique
              WHERE (user1.user_unique LIKE '%$user_unique%' OR user2.user_unique LIKE '%$user_unique%')";
        $query .= " ORDER BY `b_created_at` DESC LIMIT $start, $limit";


        $result = $conn->query($query);

        // Check if any rows were returned
        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {
            ?>
                <tr id="battle_id_<?php echo htmlspecialchars($row['b_id']) ?>" class="bg-white hover:bg-gray-50 dark:bg-slate-900 dark:hover:bg-slate-800">
                    <td class="size-px whitespace-nowrap px-6 py-3"><a href="#" class="cursor-pointer">
                            <p class="text-sm text-blue-500 dark:text-gray-200">#<?php echo htmlspecialchars($row['b_id']) ?></p>
                        </a></td>
                    <td class="size-px whitespace-nowrap px-6 py-3"><a href="#" class="cursor-pointer">
                            <p class="text-sm text-amber-500"><?php echo htmlspecialchars($row['b_room_code']) ?></p>
                        </a></td>
                    <td class="size-px whitespace-nowrap">
                        <div class="p-5 cursor-pointer overflow-hidden">
                            <div class="flex items-center gap-x-2 w-max truncate">
                                <img class="inline-block size-9 rounded-full" src="https://cashplay.in/assets/img/avatar/<?php echo htmlspecialchars($row['creator_avatar']) ?>" alt="<?php echo htmlspecialchars($row['creator_name']) ?>'s Avatar">
                                <div class="flex flex-col gap-0.5">
                                    <span class="text-sm text-gray-600 dark:text-gray-400 capitalize font-medium"><?php echo htmlspecialchars($row['creator_name']) ?></span>
                                    <span class="text-xs text-gray-400 dark:text-gray-600 capitalize font-medium"><?php echo htmlspecialchars($row['b_creator_id']) ?></span>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="size-px whitespace-nowrap">
                        <div class="p-5 cursor-pointer overflow-hidden">
                            <div class="flex items-center gap-x-2 w-max truncate">
                                <img class="inline-block size-9 rounded-full" src="https://cashplay.in/assets/img/avatar/<?php echo htmlspecialchars($row['player2_avatar']) ?>" alt="<?php echo htmlspecialchars($row['player2_name']) ?>'s Avatar">
                                <div class="flex flex-col gap-0.5">
                                    <span class="text-sm text-gray-600 dark:text-gray-400 capitalize font-medium"><?php echo htmlspecialchars($row['player2_name']) ?></span>
                                    <span class="text-xs text-gray-400 dark:text-gray-600 capitalize font-medium"><?php echo htmlspecialchars($row['b_player2_id']) ?></span>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="size-px whitespace-nowrap px-8 py-3">
                        <p class="text-sm text-green-500"><?php echo htmlspecialchars($row['b_price']) ?>&#x20B9;</p>
                    </td>
                    <td class="size-px whitespace-nowrap px-6 py-3">
                        <p class="text-sm text-amber-500"><?php echo htmlspecialchars($row['b_game']) ?></p>
                    </td>
                    <td class="size-px whitespace-nowrap px-6 py-3">
                        <p class="text-sm text-green-500"><?php echo htmlspecialchars($row['b_status']) ?></p>
                    </td>
                    <td class="size-px whitespace-nowrap px-6 py-3">
                        <p class="text-sm text-gray-800 dark:text-white"><?php $date = new DateTime($row['b_created_at']);
                                                                            echo $date->format('h:i A - d M Y'); ?></p>
                    </td>
                    <td class="size-px whitespace-nowrap align-center">
                        <button class="btn" onclick="allBattleDetails('<?php echo htmlspecialchars($row['b_id']) ?>')"><a>Details</a></button>
                    </td>
                </tr>
<?php
            }
        } else {
            echo 'No records found.';
        }
    }




















    if (isset($_POST['search'])) {
        $response = array('status' => 'error', 'data' => array());
        $search = mysqli_real_escape_string($conn, $_POST['search']);

        $query = "SELECT id, avatar, user_name, game_uid, country, phone_number, user_unique, total_balance, total_withdraw_balance, log_out_globally, login_access FROM user_details 
              WHERE user_name LIKE '%$search%' 
              OR game_uid LIKE '%$search%' 
              OR phone_number LIKE '%$search%' 
              OR user_unique LIKE '%$search%'";

        $result = $conn->query($query);
        $response = array('status' => 'success', 'data' => array());

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $response['data'][] = $row;
            }
        } else {
            $response['data'] = array(); // no results found
        }
    }

















    // EDIT QUICK SEEN DETAILS



    if (isset($_POST['updateQuickSeenFields'])) {
        $id = $_POST['id'];
        $field = $_POST['field'];
        $value = $_POST['value'];

        // Additional fields for status change
        $login_access = isset($_POST['login_access']) ? $_POST['login_access'] : null;
        // echo " || ";
        $log_out_globally = isset($_POST['log_out_globally']) ? $_POST['log_out_globally'] : null;
        // echo " || ";

        // Update query based on field and value
        $updateQuery = "UPDATE user_details SET ";

        if ($login_access !== null && $log_out_globally !== null) {
            $updateQuery .= "login_access = $login_access, log_out_globally = $log_out_globally WHERE user_unique = $id";
        } else {
            $updateQuery .= "$field = '$value' WHERE id = $id";
        }

        // echo $updateQuery;
        if ($conn->query($updateQuery) === TRUE) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update field.']);
        }
        exit();
    }
} else {
    header("Location: /auth/login.php");
}


mysqli_close($conn);
if (isset($response)) {
    echo json_encode($response);
}
