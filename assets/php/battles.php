<?php session_start();

include '../../server/conn.php';


if (isset($_COOKIE['6a5f450a43b7387dcb7d67e17d897498'])) {

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['filterRecords'])) {
        $search_user = $_POST['search_user'] ?? '';
        $status = $_POST['status'] ?? '';
        $date_filter = $_POST['date_filter'] ?? '';
        $start_date = $_POST['start_date'] ?? '';
        $end_date = $_POST['end_date'] ?? '';

        $query = "SELECT battles.b_id, battles.b_room_code, battles.b_created_at, battles.b_status, battles.b_game, battles.b_price, battles.b_player2_id, battles.b_creator_id, battles.b_room_code, user1.user_name as creator_name, user1.avatar as creator_avatar, 
              user2.user_name as player2_name, user2.avatar as player2_avatar 
              FROM battles
              LEFT JOIN user_details as user1 ON battles.b_creator_id = user1.user_unique
              LEFT JOIN user_details as user2 ON battles.b_player2_id = user2.user_unique
              WHERE 1";

        if (!empty($search_user)) {
            $query .= " AND (user1.user_name LIKE '%$search_user%' OR user2.user_name LIKE '%$search_user%')";
        }

        if (!empty($status)) {
            $query .= " AND battles.b_status = '$status'";
        }

        if (!empty($date_filter)) {
            switch ($date_filter) {
                case 'today':
                    $query .= " AND DATE(battles.b_created_at) = CURDATE()";
                    break;
                case 'yesterday':
                    $query .= " AND DATE(battles.b_created_at) = CURDATE() - INTERVAL 1 DAY";
                    break;
                case 'this_week':
                    $query .= " AND YEARWEEK(battles.b_created_at, 1) = YEARWEEK(CURDATE(), 1)";
                    break;
                case 'this_month':
                    $query .= " AND MONTH(battles.b_created_at) = MONTH(CURDATE()) AND YEAR(battles.b_created_at) = YEAR(CURDATE())";
                    break;
                case 'this_year':
                    $query .= " AND YEAR(battles.b_created_at) = YEAR(CURDATE())";
                    break;
                case 'custom':
                    if (!empty($start_date) && !empty($end_date)) {
                        $query .= " AND DATE(battles.b_created_at) BETWEEN '$start_date' AND '$end_date'";
                    }
                    break;
            }
        } else {
            // Show today's data by default
            $query .= " AND DATE(battles.b_created_at) = CURDATE()";
        }
        $query .= " ORDER BY `b_created_at` DESC";

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
                    <td class="size-px px-5 whitespace-nowrap">
                        <a target="_blank" href="?page=allPlayers&player=<?php echo htmlspecialchars($row['b_creator_id']) ?>" class="p-5 cursor-pointer">
                            <div class="flex items-center gap-x-2">
                                <img class="inline-block size-9 rounded-full" src="https://cashplay.in/assets/img/avatar/<?php echo htmlspecialchars($row['creator_avatar']) ?>" alt="<?php echo htmlspecialchars($row['creator_name']) ?>'s Avatar">
                                <div class="flex flex-col gap-0.5">
                                    <span class="text-sm text-gray-600 dark:text-gray-400 capitalize font-medium"><?php echo htmlspecialchars($row['creator_name']) ?></span>
                                    <span class="text-xs text-gray-400 dark:text-gray-600 capitalize font-medium"><?php echo htmlspecialchars($row['b_creator_id']) ?></span>
                                </div>
                            </div>
                        </a>
                    </td>
                    <td class="size-px px-5 whitespace-nowrap">
                        <a target="_blank" href="?page=allPlayers&player=<?php echo htmlspecialchars($row['b_player2_id']) ?>" class="p-5 cursor-pointer">
                            <div class="flex items-center gap-x-2">
                                <img class="inline-block size-9 rounded-full" src="https://cashplay.in/assets/img/avatar/<?php echo htmlspecialchars($row['player2_avatar']) ?>" alt="<?php echo htmlspecialchars($row['player2_name']) ?>'s Avatar">
                                <div class="flex flex-col gap-0.5">
                                    <span class="text-sm text-gray-600 dark:text-gray-400 capitalize font-medium"><?php echo htmlspecialchars($row['player2_name']) ?></span>
                                    <span class="text-xs text-gray-400 dark:text-gray-600 capitalize font-medium"><?php echo htmlspecialchars($row['b_player2_id']) ?></span>
                                </div>
                            </div>
                        </a>
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
    }








    if (isset($_POST['fetchALLDetails'])) {
        $b_id = $_POST['b_id'];

        $sql = "SELECT battles.*, 
                     user1.user_name AS creator_name, 
                     user1.avatar AS creator_avatar, 
                     user1.game_uid AS creator_game_uid, 
                     user2.user_name AS joiner_name, 
                     user2.avatar AS joiner_avatar,
                     user2.game_uid AS joiner_game_uid 
              FROM battles
              LEFT JOIN user_details AS user1 ON battles.b_creator_id = user1.user_unique
              LEFT JOIN user_details AS user2 ON battles.b_player2_id = user2.user_unique
              WHERE battles.b_id = '$b_id'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            echo json_encode($data);
        } else {
            echo json_encode(['error' => 'No record found.']);
        }
    }

















    if (isset($_POST['checkResult'])) {
        $user_unique = $_POST["user_unique"];
        $b_id = $_POST["b_id"];

        if (!$conn) {
            die('Failed to connect to the database: ' . mysqli_connect_error());
        }


        $get_room_details = $conn->query("SELECT `b_price`, `b_won_amount` FROM `battles` WHERE `b_room_code` != 0 AND `b_status` = 'Complete' AND `b_id` = '$b_id'");

        if (mysqli_num_rows($get_room_details) > 0) {
            $response = array(
                'status' => 'gameComplete',
            );
        } else {
            $get_room_details = $conn->query("SELECT `b_price`, `b_won_amount`, `b_id` FROM `battles` WHERE `b_room_code` != 0 AND `b_status` = 'Running' AND `b_id` = '$b_id'");

            if (mysqli_num_rows($get_room_details) > 0) {

                $r_row = mysqli_fetch_assoc($get_room_details);


                // GET OWN GAME UID

                $check_joined_battle_sql = "SELECT `game_uid` FROM `user_details` WHERE `user_unique` = ?";
                $check_joined_battle_stmt = $conn->prepare($check_joined_battle_sql);
                $check_joined_battle_stmt->bind_param('s', $user_unique);
                $check_joined_battle_stmt->execute();
                $check_joined_battle_stmt->store_result();
                $check_joined_battle_stmt->bind_result($own_game_UID);
                $check_joined_battle_stmt->fetch();



                // GET PLAYERS ID AND ROOM CODE

                $check_joined_battle_sql = "SELECT `b_creator_id`, `b_player2_id`, `b_room_code` FROM `battles` WHERE `b_id` = ?";
                $check_joined_battle_stmt = $conn->prepare($check_joined_battle_sql);
                $check_joined_battle_stmt->bind_param('s', $b_id);
                $check_joined_battle_stmt->execute();
                $check_joined_battle_stmt->store_result();
                $check_joined_battle_stmt->bind_result($room_creator_Id, $room_opponent_Id, $roomCode);
                $check_joined_battle_stmt->fetch();



                // GET OPPONENT GAME UID

                $opponent_unique_id;

                if ($room_creator_Id == $user_unique) {
                    $opponent_unique_id = $room_opponent_Id;

                    $check_joined_battle_sql = "SELECT `game_uid` FROM `user_details` WHERE `user_unique` = ?";
                    $check_joined_battle_stmt = $conn->prepare($check_joined_battle_sql);
                    $check_joined_battle_stmt->bind_param('s', $room_opponent_Id);
                    $check_joined_battle_stmt->execute();
                    $check_joined_battle_stmt->store_result();
                    $check_joined_battle_stmt->bind_result($opponent_game_UID);
                    $check_joined_battle_stmt->fetch();
                } else {
                    $opponent_unique_id = $room_creator_Id;

                    $check_joined_battle_sql = "SELECT `game_uid` FROM `user_details` WHERE `user_unique` = ?";
                    $check_joined_battle_stmt = $conn->prepare($check_joined_battle_sql);
                    $check_joined_battle_stmt->bind_param('s', $room_creator_Id);
                    $check_joined_battle_stmt->execute();
                    $check_joined_battle_stmt->store_result();
                    $check_joined_battle_stmt->bind_result($opponent_game_UID);
                    $check_joined_battle_stmt->fetch();
                }


                $curl = curl_init();
                echo "||";
                echo $roomCode;
                echo "||";

                curl_setopt_array($curl, [
                    CURLOPT_URL => "https://ludo-king-room-code-api.p.rapidapi.com/result?code=$roomCode",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => [
                        "X-RapidAPI-Host: ludo-king-room-code-api.p.rapidapi.com",
                        "X-RapidAPI-Key: 317e76f85fmsh55bd70d3bf55488p19b483jsn5744a66c2ed1"
                    ],
                ]);


                $res = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                if ($err) {
                    echo "cURL Error #:" . $err;
                } else {
                    echo CURLOPT_URL;
                    echo " || ";
                    echo $res;



                    $res = json_decode($res, true);
                    $status = $res['status'];
                    $roomCode = $res['roomcode'];
                    $creatorId = $res['creator_id'];
                    $creatorName = $res['creator_name'];
                    $player1Id = $res['player1_id'];
                    $player1Name = $res['player1_name'];
                    $player1Status = $res['player1_status'];
                    $player2Id = $res['player2_id'];
                    $player2Name = $res['player2_name'];
                    $player2Status = $res['player2_status'];


                    $check_battle_complete = $conn->query("SELECT `b_id` FROM `battles` WHERE `b_id` = '$b_id' AND `b_status` = 'Running'");

                    if (mysqli_num_rows($check_battle_complete) > 0) {

                        $get_winning_amount = $conn->query("SELECT `b_won_amount` FROM `battles` WHERE `b_id` = '$b_id'");

                        if (mysqli_num_rows($get_winning_amount) > 0) {

                            $r_row = mysqli_fetch_assoc($get_winning_amount);
                            $b_won_amount = $r_row['b_won_amount'];

                            $get_user_old_balance = $conn->query("SELECT `total_balance`, `total_withdraw_balance`  FROM `user_details` WHERE `user_unique` = '$user_unique'");


                            if (mysqli_num_rows($get_user_old_balance) > 0) {
                                $get_user_old_balance_row = mysqli_fetch_assoc($get_user_old_balance);


                                $total_balance = $get_user_old_balance_row['total_balance'];
                                $total_withdraw_balance = $get_user_old_balance_row['total_withdraw_balance'];


                                $new_total_balance = intval($total_balance) + intval($b_won_amount);
                                $new_total_withdraw_balance = intval($total_withdraw_balance) + intval($b_won_amount);

                                $winnerId = 0;


                                if ($player1Id) {
                                    if ($player1Status == 'Won') {

                                        $update_battle_closed_sql = "UPDATE `battles` SET `b_status` = 'Complete' WHERE `b_id` = ?";
                                        $update_battle_closed_stmt = $conn->prepare($update_battle_closed_sql);
                                        $update_battle_closed_stmt->bind_param('s', $user_unique);

                                        if ($update_battle_closed_stmt->execute()) {

                                            if ($own_game_UID == $player1Id) {
                                                $winnerId = $user_unique;
                                            } elseif ($opponent_game_UID == $player1Id) {
                                                $winnerId = $opponent_unique_id;
                                            } else {
                                                $winnerId = $player1Id;
                                            }

                                            $resJson = json_encode($res);

                                            $check_battle_complete2 = $conn->query("SELECT `b_id` FROM `battles` WHERE `b_id` = '$b_id' AND `b_payment_transfer` = 1");

                                            if (mysqli_num_rows($check_battle_complete2) > 0) {

                                                $response = array(
                                                    'status' => 'battle_closed',
                                                );
                                            } else {


                                                if ($winnerId == $room_creator_Id or $winnerId == $room_opponent_Id) {

                                                    if ($winnerId == $room_creator_Id) {
                                                        $get_amount_complete_details = $conn->query("SELECT `b_won_amount`, `creator_old_total`, `creator_old_withdraw`, `creator_new_total`, `creator_new_withdraw` FROM `battles` WHERE `b_id` = '$b_id'");

                                                        if (mysqli_num_rows($get_amount_complete_details) > 0) {
                                                            $detail_row = mysqli_fetch_assoc($get_amount_complete_details);

                                                            // $creator_old_total = $detail_row['creator_old_total'];
                                                            // $creator_old_withdraw = $detail_row['creator_old_withdraw'];
                                                            $creator_new_total = $detail_row['creator_new_total'];
                                                            $creator_new_withdraw = $detail_row['creator_new_withdraw'];

                                                            $update_amount_balance_sql = "UPDATE `user_details` SET `total_balance` = ?, `total_withdraw_balance` = ? WHERE `user_unique` = ?";
                                                            $update_amount_balance_stmt = $conn->prepare($update_amount_balance_sql);
                                                            $update_amount_balance_stmt->bind_param('sss', $creator_new_total, $creator_new_withdraw, $winnerId);
                                                        } else {
                                                            echo "CURRENT BATTLE ID IS WRONG";
                                                        }
                                                    } else if ($winnerId == $room_opponent_Id) {
                                                        $get_amount_complete_details = $conn->query("SELECT `b_won_amount`, `joiner_old_total`, `joiner_old_withdraw`, `joiner_new_total`, `joiner_new_withdraw` FROM `battles` WHERE `b_id` = '$b_id'");

                                                        if (mysqli_num_rows($get_amount_complete_details) > 0) {
                                                            $detail_row = mysqli_fetch_assoc($get_amount_complete_details);

                                                            // $joiner_old_total = $detail_row['joiner_old_total'];
                                                            // $joiner_old_withdraw = $detail_row['joiner_old_withdraw'];
                                                            $joiner_new_total = $detail_row['joiner_new_total'];
                                                            $joiner_new_withdraw = $detail_row['joiner_new_withdraw'];

                                                            $update_amount_balance_sql = "UPDATE `user_details` SET `total_balance` = ?, `total_withdraw_balance` = ? WHERE `user_unique` = ?";
                                                            $update_amount_balance_stmt = $conn->prepare($update_amount_balance_sql);
                                                            $update_amount_balance_stmt->bind_param('sss', $joiner_new_total, $joiner_new_withdraw, $winnerId);
                                                        } else {
                                                            echo "CURRENT BATTLE ID IS WRONG";
                                                        }
                                                    }
                                                } else {
                                                    echo "API Failed";
                                                    $update_amount_balance_sql = "UPDATE `user_details` SET `total_balance` = ?, `total_withdraw_balance` = ? WHERE `user_unique` = ?";
                                                    $update_amount_balance_stmt = $conn->prepare($update_amount_balance_sql);
                                                    $update_amount_balance_stmt->bind_param('sss', $new_total_balance, $new_total_withdraw_balance, $winnerId);
                                                }






                                                if ($update_amount_balance_stmt->execute()) {


                                                    date_default_timezone_set('Asia/Kolkata');
                                                    $currentDateTime = date('Y-m-d H:i:s');


                                                    $update_battle_sql = "UPDATE `battles` SET `result_JSON` = ?, `b_status` = 'Complete', `b_winner_id` = ?, `b_game_end` = ?, `b_payment_transfer` = 1 WHERE `b_id` = ?";
                                                    $update_battle_stmt = $conn->prepare($update_battle_sql);
                                                    $update_battle_stmt->bind_param('ssss', $resJson, $winnerId, $currentDateTime, $b_id);

                                                    if ($update_battle_stmt->execute()) {



                                                        $response = array(
                                                            'status' => 'success',
                                                        );
                                                    } else {
                                                        $response = array(
                                                            'status' => 'error',
                                                        );
                                                    }
                                                } else {
                                                    $response = array(
                                                        'status' => 'players_game_UID_error',
                                                    );
                                                }
                                            }
                                        } else {
                                            $response = array(
                                                'status' => 'battle_closed',
                                            );
                                        }
                                    } else if ($player2Status == 'Won') {

                                        $update_battle_closed_sql = "UPDATE `battles` SET `b_status` = 'Complete' WHERE `b_id` = ?";
                                        $update_battle_closed_stmt = $conn->prepare($update_battle_closed_sql);
                                        $update_battle_closed_stmt->bind_param('s', $user_unique);

                                        if ($update_battle_closed_stmt->execute()) {

                                            if ($own_game_UID == $player2Id) {
                                                $winnerId = $user_unique;
                                            } elseif ($opponent_game_UID == $player2Id) {
                                                $winnerId = $opponent_unique_id;
                                            } else {
                                                $winnerId = $player2Id;
                                            }

                                            $resJson = json_encode($res);

                                            $check_battle_complete2 = $conn->query("SELECT `b_id` FROM `battles` WHERE `b_id` = '$b_id' AND `b_payment_transfer` = 1");
                                            if (mysqli_num_rows($check_battle_complete2) > 0) {
                                                $response = array(
                                                    'status' => 'battle_closed',
                                                );
                                            } else {




                                                if ($winnerId == $room_creator_Id or $winnerId == $room_opponent_Id) {

                                                    if ($winnerId == $room_creator_Id) {
                                                        $get_amount_complete_details = $conn->query("SELECT `b_won_amount`, `creator_old_total`, `creator_old_withdraw`, `creator_new_total`, `creator_new_withdraw` FROM `battles` WHERE `b_id` = '$b_id'");

                                                        if (mysqli_num_rows($get_amount_complete_details) > 0) {
                                                            $detail_row = mysqli_fetch_assoc($get_amount_complete_details);

                                                            // $creator_old_total = $detail_row['creator_old_total'];
                                                            // $creator_old_withdraw = $detail_row['creator_old_withdraw'];
                                                            $creator_new_total = $detail_row['creator_new_total'];
                                                            $creator_new_withdraw = $detail_row['creator_new_withdraw'];

                                                            $update_amount_balance_sql = "UPDATE `user_details` SET `total_balance` = ?, `total_withdraw_balance` = ? WHERE `user_unique` = ?";
                                                            $update_amount_balance_stmt = $conn->prepare($update_amount_balance_sql);
                                                            $update_amount_balance_stmt->bind_param('sss', $creator_new_total, $creator_new_withdraw, $winnerId);
                                                        } else {
                                                            echo "CURRENT BATTLE ID IS WRONG";
                                                        }
                                                    } else if ($winnerId == $room_opponent_Id) {
                                                        $get_amount_complete_details = $conn->query("SELECT `b_won_amount`, `joiner_old_total`, `joiner_old_withdraw`, `joiner_new_total`, `joiner_new_withdraw` FROM `battles` WHERE `b_id` = '$b_id'");

                                                        if (mysqli_num_rows($get_amount_complete_details) > 0) {
                                                            $detail_row = mysqli_fetch_assoc($get_amount_complete_details);

                                                            $joiner_new_total = $detail_row['joiner_new_total'];
                                                            $joiner_new_withdraw = $detail_row['joiner_new_withdraw'];

                                                            $update_amount_balance_sql = "UPDATE `user_details` SET `total_balance` = ?, `total_withdraw_balance` = ? WHERE `user_unique` = ?";
                                                            $update_amount_balance_stmt = $conn->prepare($update_amount_balance_sql);
                                                            $update_amount_balance_stmt->bind_param('sss', $joiner_new_total, $joiner_new_withdraw, $winnerId);
                                                        } else {
                                                            echo "CURRENT BATTLE ID IS WRONG";
                                                        }
                                                    }
                                                } else {
                                                    echo "API Failed";
                                                    $update_amount_balance_sql = "UPDATE `user_details` SET `total_balance` = ?, `total_withdraw_balance` = ? WHERE `user_unique` = ?";
                                                    $update_amount_balance_stmt = $conn->prepare($update_amount_balance_sql);
                                                    $update_amount_balance_stmt->bind_param('sss', $new_total_balance, $new_total_withdraw_balance, $winnerId);
                                                }

                                                if ($update_amount_balance_stmt->execute()) {


                                                    date_default_timezone_set('Asia/Kolkata');
                                                    $currentDateTime = date('Y-m-d H:i:s');


                                                    $update_battle_sql = "UPDATE `battles` SET `result_JSON` = ?, `b_status` = 'Complete', `b_winner_id` = ?, `b_game_end` = ?, `b_payment_transfer` = 1 WHERE `b_id` = ?";
                                                    $update_battle_stmt = $conn->prepare($update_battle_sql);
                                                    $update_battle_stmt->bind_param('ssss', $resJson, $winnerId, $currentDateTime, $b_id);

                                                    if ($update_battle_stmt->execute()) {

                                                        $response = array(
                                                            'status' => 'success',
                                                        );
                                                    } else {
                                                        $response = array(
                                                            'status' => 'error',
                                                        );
                                                    }
                                                } else {
                                                    $response = array(
                                                        'status' => 'players_game_UID_error',
                                                    );
                                                }
                                            }
                                        } else {
                                            $response = array(
                                                'status' => 'battle_closed',
                                            );
                                        }
                                    } else {
                                        $response = array(
                                            'status' => 'Playing',
                                            'data' => $res,
                                        );
                                    }
                                } else {
                                    $response = array(
                                        'status' => 'joining',
                                    );
                                }
                            }
                        }
                    } else {



                        $response = array(
                            'status' => 'alreadyResultSubmitted',
                        );
                    }
                }
            } else {

                $response = array(
                    'status' => 'battleNotRunning',
                );
            }
        }
        // header('Content-Type: application/json');
        echo json_encode($response);
    }









    function refundAmount($conn, $user_unique, $b_id)
    {
        // Fetch the battle price
        $battle_details = $conn->query("SELECT `b_price` FROM `battles` WHERE `b_id` = '$b_id'");
        if (mysqli_num_rows($battle_details) > 0) {
            $b_row = mysqli_fetch_assoc($battle_details);
            $b_price = $b_row['b_price'];

            // Fetch the user's balance
            $user_details = $conn->query("SELECT `total_balance`, `total_withdraw_balance` FROM `user_details` WHERE `user_unique` = '$user_unique'");
            if (mysqli_num_rows($user_details) > 0) {
                $u_row = mysqli_fetch_assoc($user_details);
                $total_balance = $u_row['total_balance'];
                $withdraw_balance = $u_row['total_withdraw_balance'];

                // Calculate the new balances by adding the battle price as it's a refund
                $new_total_balance = intval($total_balance) + intval($b_price);
                $new_total_withdraw_balance = intval($withdraw_balance) + intval($b_price);

                // Update the user's balance
                $update_players_userInfo_sql = "UPDATE `user_details` SET `total_balance` = ?, `total_withdraw_balance` = ? WHERE `user_unique` = ?";
                $update_players_userInfo_stmt = $conn->prepare($update_players_userInfo_sql);
                $update_players_userInfo_stmt->bind_param('sss', $new_total_balance, $new_total_withdraw_balance, $user_unique);

                if ($update_players_userInfo_stmt->execute()) {
                    // Update the battle status
                    date_default_timezone_set('Asia/Kolkata');
                    $currentDateTime = date('Y-m-d H:i:s');

                    $update_battle_sql = "UPDATE `battles` SET `b_status` = 'Cancel', `b_winner_id` = '', `b_game_end` = ?, `b_payment_transfer` = 1 WHERE `b_id` = ?";
                    $update_battle_stmt = $conn->prepare($update_battle_sql);
                    $update_battle_stmt->bind_param('ss', $currentDateTime, $b_id);

                    if ($update_battle_stmt->execute()) {
                        return array('status' => 'success');
                    } else {
                        return array('status' => 'error', 'message' => "Error updating battle status: " . $conn->error);
                    }
                } else {
                    return array('status' => 'error', 'message' => "Error updating user balance: " . $conn->error);
                }
            } else {
                return array('status' => 'user_not_found');
            }
        } else {
            return array('status' => 'battle_not_found');
        }
    }

    function removeWinningMoney($conn, $winnerId, $b_amount)
    {
        $update_balance_sql = "UPDATE `user_details` SET `total_balance` = `total_balance` - ?, `total_withdraw_balance` = `total_withdraw_balance` - ? WHERE `user_unique` = ?";
        $update_balance_stmt = $conn->prepare($update_balance_sql);
        $update_balance_stmt->bind_param('dds', $b_amount, $b_amount, $winnerId);
        if (!$update_balance_stmt->execute()) {
            return array('status' => 'error', 'message' => "Error updating winner's balance: " . $conn->error);
        }
        return array('status' => 'success');
    }

    // Main code
    if (isset($_POST['action']) && $_POST['action'] === 'cancel') {
        $b_id = $_POST["b_id"];
        $response = array();

        if (!$conn) {
            die('Failed to connect to the database: ' . mysqli_connect_error());
        }

        // Check if the battle is joined by both players
        $check_joined_battle_sql = "SELECT `b_creator_id`, `b_player2_id`, `b_payment_transfer`, `b_winner_id`, `b_won_amount`, `b_status` FROM `battles` WHERE `b_id` = ?";
        $check_joined_battle_stmt = $conn->prepare($check_joined_battle_sql);
        $check_joined_battle_stmt->bind_param('s', $b_id);
        $check_joined_battle_stmt->execute();
        $check_joined_battle_stmt->store_result();
        $check_joined_battle_stmt->bind_result($room_creator_Id, $room_opponent_Id, $b_payment_transfer, $old_winnerId, $b_won_amount, $b_status);
        $check_joined_battle_stmt->fetch();

        if ($b_status == 'Cancel') {
            $response = array(
                'status' => 'battle_already_cancelled',
            );
        } else {
            // Update the battle status
            date_default_timezone_set('Asia/Kolkata');
            $currentDateTime = date('Y-m-d H:i:s');

            if ($b_payment_transfer != 1) {
                // Refund amounts to both players
                $response_creator = refundAmount($conn, $room_creator_Id, $b_id);
                $response_opponent = refundAmount($conn, $room_opponent_Id, $b_id);

                if ($response_creator['status'] === 'success' && $response_opponent['status'] === 'success') {
                    $response = array('status' => 'success');
                } else {
                    $response = array(
                        'status' => 'error',
                        'message' => "Error refunding amounts: " . $conn->error
                    );
                }
            } else {
                if (empty($old_winnerId)) {
                    $response_creator = refundAmount($conn, $room_creator_Id, $b_id);
                    $response_opponent = refundAmount($conn, $room_opponent_Id, $b_id);
                } else {
                    $b_amount = intval($b_won_amount);

                    if ($old_winnerId == $room_creator_Id) {
                        $response_remove = removeWinningMoney($conn, $room_creator_Id, $b_amount);
                    } else if ($old_winnerId == $room_opponent_Id) {
                        $response_remove = removeWinningMoney($conn, $room_opponent_Id, $b_amount);
                    }

                    $response_creator = refundAmount($conn, $room_creator_Id, $b_id);
                    $response_opponent = refundAmount($conn, $room_opponent_Id, $b_id);
                }

                $update_battle_sql = "UPDATE `battles` SET `b_status` = 'Cancel', `b_winner_id` = '', `b_game_end` = ? WHERE `b_id` = ?";
                $update_battle_stmt = $conn->prepare($update_battle_sql);
                $update_battle_stmt->bind_param('ss', $currentDateTime, $b_id);

                if ($update_battle_stmt->execute()) {
                    $response = array('status' => 'success');
                } else {
                    $response = array(
                        'status' => 'error',
                        'message' => "Error updating battle status: " . $conn->error
                    );
                }
            }
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
















    // Functions to update balances and battle status


    function updateWinnerBalance($conn, $winnerId, $b_won_amount)
    {
        $update_balance_sql = "UPDATE `user_details` SET `total_balance` = `total_balance` + ?, `total_withdraw_balance` = `total_withdraw_balance` + ? WHERE `user_unique` = ?";
        $update_balance_stmt = $conn->prepare($update_balance_sql);
        $update_balance_stmt->bind_param('dds', $b_won_amount, $b_won_amount, $winnerId);
        if (!$update_balance_stmt->execute()) {
            return array('status' => 'error', 'message' => "Error updating winner's balance: " . $conn->error);
        }
        return array('status' => 'success');
    }

    function updateLoserBalance($conn, $loserId, $b_won_amount)
    {
        $update_balance_sql = "UPDATE `user_details` SET `total_balance` = `total_balance` - ?, `total_withdraw_balance` = `total_withdraw_balance` - ? WHERE `user_unique` = ?";
        $update_balance_stmt = $conn->prepare($update_balance_sql);
        $update_balance_stmt->bind_param('dds', $b_won_amount, $b_won_amount, $loserId);
        if (!$update_balance_stmt->execute()) {
            return array('status' => 'error', 'message' => "Error updating loser's balance: " . $conn->error);
        }
        return array('status' => 'success');
    }

    function updateBattleStatus($conn, $b_id, $winnerId)
    {
        date_default_timezone_set('Asia/Kolkata');
        $currentDateTime = date('Y-m-d H:i:s');
        $update_battle_sql = "UPDATE `battles` SET `b_status` = 'Complete', `b_winner_id` = ?, `b_game_end` = ?, `b_payment_transfer` = 1 WHERE `b_id` = ?";
        $update_battle_stmt = $conn->prepare($update_battle_sql);
        $update_battle_stmt->bind_param('sss', $winnerId, $currentDateTime, $b_id);
        if (!$update_battle_stmt->execute()) {
            return array('status' => 'error', 'message' => "Error updating battle status: " . $conn->error);
        }
        return array('status' => 'success');
    }

    function updateBattleStatus2($conn, $b_id, $winnerId)
    {
        date_default_timezone_set('Asia/Kolkata');
        $currentDateTime = date('Y-m-d H:i:s');
        $update_battle_sql = "UPDATE `battles` SET `b_status` = 'Complete', `b_winner_id` = ?, `b_game_end` = ?, `b_payment_transfer` = 0 WHERE `b_id` = ?";
        $update_battle_stmt = $conn->prepare($update_battle_sql);
        $update_battle_stmt->bind_param('sss', $winnerId, $currentDateTime, $b_id);
        if (!$update_battle_stmt->execute()) {
            return array('status' => 'error', 'message' => "Error updating battle status: " . $conn->error);
        }
        return array('status' => 'success');
    }

    function removingRefundedAmount($conn, $user_unique, $b_amount)
    {
        $user_details = $conn->query("SELECT `total_balance`, `total_withdraw_balance` FROM `user_details` WHERE `user_unique` = '$user_unique'");
        if (mysqli_num_rows($user_details) > 0) {
            $u_row = mysqli_fetch_assoc($user_details);
            $total_balance = $u_row['total_balance'];
            $total_withdraw_balance = $u_row['total_withdraw_balance'];

            if (intval($b_amount) <= intval($total_balance)) {
                $balance_without_withdrawal_amount = intval($total_balance) - intval($total_withdraw_balance);
                if (intval($balance_without_withdrawal_amount) > intval($b_amount)) {
                    $new_total_withdraw_balance = $total_withdraw_balance;
                    $new_total_balance = intval($total_balance) - intval($b_amount);
                } else {
                    $remainingAmount = intval($b_amount) - intval($balance_without_withdrawal_amount);
                    $new_total_balance = intval($total_balance) - intval($b_amount);
                    $new_total_withdraw_balance = $total_withdraw_balance - $remainingAmount;
                }

                $update_players_userInfo_sql = "UPDATE `user_details` SET `total_balance` = ?, `total_withdraw_balance` = ? WHERE `user_unique` = ?";
                $update_players_userInfo_stmt = $conn->prepare($update_players_userInfo_sql);
                $update_players_userInfo_stmt->bind_param('sss', $new_total_balance, $new_total_withdraw_balance, $user_unique);

                if ($update_players_userInfo_stmt->execute()) {
                    return array('status' => 'success');
                } else {
                    return array('status' => 'error', 'message' => "Error updating user's balance: " . $conn->error);
                }
            }
        }
        return array('status' => 'error', 'message' => 'User not found or insufficient balance');
    }


    if (isset($_POST['action']) && $_POST['action'] === 'complete') {
        $user_unique = $_POST["user_unique"];
        $new_winnerId = $_POST["winnerId"];
        $transfer = $_POST["transfer"];
        $b_id = $_POST["b_id"];

        if (!$conn) {
            die('Failed to connect to the database: ' . mysqli_connect_error());
        }

        // Fetch battle details
        $fetch_battle_sql = "SELECT `b_creator_id`, `b_player2_id`, `b_winner_id`, `b_won_amount`, `b_price`, `b_payment_transfer`, `b_status` FROM `battles` WHERE `b_id` = ?";
        $fetch_battle_stmt = $conn->prepare($fetch_battle_sql);
        $fetch_battle_stmt->bind_param('s', $b_id);
        $fetch_battle_stmt->execute();
        $fetch_battle_stmt->store_result();
        $fetch_battle_stmt->bind_result($creatorId, $player2Id, $old_winnerId, $b_won_amount, $b_price, $payment_transfer, $b_status);
        $fetch_battle_stmt->fetch();

        if ($transfer) {
            // Check payment transfer status
            if ($b_status == 'Cancel') {
                $response = removingRefundedAmount($conn, $creatorId, $b_price);
                if ($response['status'] === 'success') {
                    $response = removingRefundedAmount(
                        $conn,
                        $player2Id,
                        $b_price
                    );
                    $response = updateWinnerBalance($conn, $new_winnerId, $b_won_amount);
                    if ($response['status'] === 'success') {
                        $response = updateBattleStatus($conn, $b_id, $new_winnerId);
                    }
                }
            } else {
                if ($payment_transfer == 1) {
                    // Check if winner ID is empty
                    if (empty($old_winnerId)) {
                        // No previous winner, update balances directly
                        $response = updateWinnerBalance($conn, $new_winnerId, $b_won_amount);
                        if ($response['status'] === 'success') {
                            $response = updateBattleStatus($conn, $b_id, $new_winnerId);
                        }
                    } else {
                        // Compare old winner ID and new winner ID
                        if ($old_winnerId == $new_winnerId) {
                            $response = updateBattleStatus($conn, $b_id, $new_winnerId);
                        } else {
                            // Winner has changed
                            if ($old_winnerId == $creatorId || $old_winnerId == $player2Id) {
                                // Deduct the won amount from the old winner's balance
                                $response = updateLoserBalance($conn, $old_winnerId, $b_won_amount);
                                if ($response['status'] === 'success') {
                                    // Add the won amount to the new winner's balance
                                    $response = updateWinnerBalance($conn, $new_winnerId, $b_won_amount);
                                    if ($response['status'] === 'success') {
                                        $response = updateBattleStatus($conn, $b_id, $new_winnerId);
                                    }
                                }
                            } else {
                                // Old winner ID doesn't match creator or player2
                                $response = updateWinnerBalance($conn, $new_winnerId, $b_won_amount);
                                if ($response['status'] === 'success') {
                                    $response = updateBattleStatus($conn, $b_id, $new_winnerId);
                                }
                            }
                        }
                    }
                } else {
                    // Add the won amount to the new winner's balance
                    $response = updateWinnerBalance($conn, $new_winnerId, $b_won_amount);
                    if ($response['status'] === 'success') {
                        $response = updateBattleStatus($conn, $b_id, $new_winnerId);
                    }
                }
            }
        } else {
            if ($b_status == 'Cancel') {
                $response = removingRefundedAmount($conn, $creatorId, $b_price);
                if ($response['status'] === 'success') {
                    $response = removingRefundedAmount(
                        $conn,
                        $player2Id,
                        $b_price
                    );
                    if ($response['status'] === 'success') {
                        $response = updateBattleStatus2($conn, $b_id, $new_winnerId);
                    }
                }
            } else {
                if ($payment_transfer == 1) {
                    // Check if winner ID is empty
                    if (empty($old_winnerId)) {
                        // No previous winner, update directly
                        $response = updateBattleStatus2($conn, $b_id, $new_winnerId);
                    } else {

                        // Winner has changed
                        if ($old_winnerId == $creatorId || $old_winnerId == $player2Id) {
                            $response = updateLoserBalance($conn, $old_winnerId, $b_won_amount);
                            if ($response['status'] === 'success') {
                                $response = updateBattleStatus2($conn, $b_id, $new_winnerId);
                            }
                        } else {
                            $response = updateBattleStatus2($conn, $b_id, $new_winnerId);
                        }
                    }
                } else {
                    $response = updateBattleStatus2($conn, $b_id, $new_winnerId);
                }
            }
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }











    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $b_id = $_POST['b_id'];

        // Delete the associated transaction details
        $deleteTransactionDetailsSql = "DELETE FROM battles WHERE b_id = ?";
        $stmt = $conn->prepare($deleteTransactionDetailsSql);
        $stmt->bind_param('s', $b_id);

        if ($stmt->execute()) {
            $response = array(
                'status' => 'success',
                'message' => 'Record deleted successfully',
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => "Error deleting transaction details: " . $conn->error,
            );
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
} else {
    header("Location: /auth/login.php");
}


mysqli_close($conn);
