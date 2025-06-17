<?php session_start();

include '../../server/conn.php';


if (isset($_COOKIE['6a5f450a43b7387dcb7d67e17d897498'])) {




    if (isset($_POST['filterRecords']) && $_POST['filterRecords'] === 'filterRecords') {
        $search_user = $_POST['search_user'] ?? '';
        $status = $_POST['status'] ?? '';
        $payment_method = $_POST['payment_method'] ?? '';
        $date_filter = $_POST['date_filter'] ?? '';
        $start_date = $_POST['start_date'] ?? '';
        $end_date = $_POST['end_date'] ?? '';

        echo $sql = "SELECT td.t_process, td.t_request, td.t_id, td.t_user_unique, td.t_amount, td.t_status, u.user_name, u.avatar, u.total_balance 
            FROM transaction_details td 
            JOIN user_details u ON td.t_user_unique = u.user_unique 
            WHERE `t_payment_via`= 'Deposit'";

        if ($search_user) {
            $sql .= " AND u.user_name LIKE '%" . $conn->real_escape_string($search_user) . "%'";

            $sql .= " OR (td.t_user_unique LIKE '%" . $conn->real_escape_string($search_user) . "%')";

            $sql .= " OR (td.t_transaction_id LIKE '%" . $conn->real_escape_string($search_user) . "%')";

            $sql .= " OR (td.t_unique_id LIKE '%" . $conn->real_escape_string($search_user) . "%')";
        }

        if ($status) {
            $sql .= " AND td.t_status = '" . $conn->real_escape_string($status) . "'";
        }

        if ($payment_method) {
            $sql .= " AND td.t_payment_via = '" . $conn->real_escape_string($payment_method) . "'";
        }

        $today = date('Y-m-d');
        if ($date_filter) {
            switch ($date_filter) {
                case 'today':
                    $sql .= " AND DATE(td.t_request) = '$today'";
                    break;
                case 'yesterday':
                    $yesterday = date('Y-m-d', strtotime('-1 day'));
                    $sql .= " AND DATE(td.t_request) = '$yesterday'";
                    break;
                case 'this_week':
                    $week_start = date('Y-m-d', strtotime('monday this week'));
                    $week_end = date('Y-m-d', strtotime('sunday this week'));
                    $sql .= " AND DATE(td.t_request) BETWEEN '$week_start' AND '$week_end'";
                    break;
                case 'this_month':
                    $month_start = date('Y-m-01');
                    $month_end = date('Y-m-t');
                    $sql .= " AND DATE(td.t_request) BETWEEN '$month_start' AND '$month_end'";
                    break;
                case 'this_year':
                    $year_start = date('Y-01-01');
                    $year_end = date('Y-12-31');
                    $sql .= " AND DATE(td.t_request) BETWEEN '$year_start' AND '$year_end'";
                    break;
                case 'custom':
                    if ($start_date && $end_date) {
                        $sql .= " AND DATE(td.t_request) BETWEEN '$start_date' AND '$end_date'";
                    }
                    break;
            }
        } else {
            $sql .= " AND DATE(td.t_request) = '$today'";
        }
        $sql .= " ORDER BY `t_request` DESC";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $t_request = new DateTime($row['t_request']);

                if ($row['t_process'] === '---') {
                    $formattedProcessDate = '---';
                } else {
                    $t_process = new DateTime($row['t_process']);
                    $formattedProcessDate = $t_process->format('d M Y');
                }
?>
                <tr id="deposit_<?php echo htmlspecialchars($row['t_id']) ?>" class="bg-white hover:bg-gray-50 dark:bg-slate-900 dark:hover:bg-slate-800">
                    <td class="size-px px-5 whitespace-nowrap">
                        <a target="_blank" href="?page=allPlayers&player=<?php echo htmlspecialchars($row['t_user_unique']) ?>" class="p-5 cursor-pointer overflow-hidden">
                            <div class="flex items-center gap-x-2 w-max truncate">
                                <img class="inline-block size-9 rounded-full" src="https://cashplay.in/assets/img/avatar/<?php echo htmlspecialchars($row['avatar']) ?>" alt="<?php echo htmlspecialchars($row['user_name']) ?>'s Avatar">
                                <div class="flex flex-col gap-0.5">
                                    <span class="text-sm text-gray-600 dark:text-gray-400 capitalize font-medium"><?php echo htmlspecialchars($row['user_name']) ?></span>
                                    <span class="text-xs text-gray-400 dark:text-gray-600 capitalize font-medium"><?php echo htmlspecialchars($row['t_user_unique']) ?></span>
                                </div>
                            </div>
                        </a>
                    </td>
                    <td class="size-px whitespace-nowrap">
                        <div class="block">
                            <span class="block px-6 py-2">
                                <span class="text-sm text-gray-600 dark:text-gray-400"><?php echo htmlspecialchars($row['t_amount']) ?><b class="font-semibold text-green-500 ml-0.5 text-base">&#x20B9;</b></span>
                            </span>
                        </div>
                    </td>
                    <td class="size-px whitespace-nowrap">
                        <div class="block">
                            <span class="block px-6 py-2">
                                <span class="text-sm text-gray-600 dark:text-gray-400"><?php echo htmlspecialchars($row['total_balance']) ?><b class="font-semibold text-green-500 ml-0.5 text-base">&#x20B9;</b></span>
                            </span>
                        </div>
                    </td>
                    <td class="size-px whitespace-nowrap">
                        <div class="block">
                            <span class="block px-6 py-2">
                                <span class="text-sm text-gray-600 dark:text-gray-400"><?php echo $t_request->format('d M Y') ?></span>
                            </span>
                        </div>
                    </td>
                    <td class="size-px whitespace-nowrap">
                        <div class="block">
                            <span class="block px-6 py-2">
                                <span class="text-sm text-gray-600 dark:text-gray-400"><?php echo $formattedProcessDate ?></span>
                            </span>
                        </div>
                    </td>
                    <td class="size-px whitespace-nowrap">
                        <div class="block">
                            <span class="block px-6 py-2 text-center">
                                <span class="text-sm font-medium <?php echo (
                                                                        ($row['t_status'] === 'Complete') ? 'text-green-500' : (($row['t_status'] === 'Cancel') ? 'text-red-500' : 'text-gray-400')
                                                                    ); ?>">
                                    <?php echo htmlspecialchars($row['t_status']); ?>
                                </span>
                            </span>
                        </div>
                    </td>
                    <td class="size-px whitespace-nowrap">
                        <button type="button" class="block">
                            <span class="px-6 py-1.5">
                                <?php if ($row['t_status'] === 'Complete') { ?>
                                    <span onclick="fetchTransactionDetails('<?php echo htmlspecialchars($row['t_id']); ?>')" class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-amber-600 transition-all text-sm dark:bg-slate-900 dark:hover:bg-slate-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800">
                                        <i class="fa-regular fa-file-lines"></i> View
                                    </span>
                                <?php } else { ?>
                                    <span onclick="fetchTransactionDetails('<?php echo htmlspecialchars($row['t_id']); ?>')" class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-amber-600 transition-all text-sm dark:bg-slate-900 dark:hover:bg-slate-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800">
                                        <i class="fa-regular fa-pen"></i> Edit
                                    </span>
                                <?php } ?>
                            </span>
                        </button>
                    </td>
                </tr>
<?php
            }
        } else {
            echo '<tr><td colspan="7">No records found.</td></tr>';
        }
    }









    if (isset($_POST['fetchALLDetails'])) {
        $t_id = $_POST['t_id'];

        $sql = "SELECT td.*, u.user_name, u.avatar
            FROM transaction_details td 
            JOIN user_details u ON td.t_user_unique = u.user_unique 
            WHERE td.t_id = '" . $conn->real_escape_string($t_id) . "'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            echo json_encode($data);
        } else {
            echo json_encode(['error' => 'No record found.']);
        }
    }







    if (isset($_POST['action']) && $_POST['action'] === 'cancel') {
        $t_id = $_POST['t_id'];

        $currentDateTime = new DateTime("now", new DateTimeZone('Asia/Kolkata'));
        $formattedDateTime = $currentDateTime->format('Y-m-d H:i:s');

        // Check if the deposit record exists and retrieve necessary details
        $checkDepositIdSql = "SELECT t_amount, t_user_unique FROM transaction_details WHERE t_id = ?";
        $stmt = $conn->prepare($checkDepositIdSql);
        $stmt->bind_param('i', $t_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $t_amount = $row['t_amount'];
            $t_user_unique = $row['t_user_unique'];

            // Check if the transaction is already marked as complete
            $checkCompleteSql = "SELECT t_id FROM transaction_details WHERE t_id = ? AND t_status = 'Complete'";
            $stmt = $conn->prepare($checkCompleteSql);
            $stmt->bind_param('i', $t_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {


                // Retrieve user balance
                $userBalanceSql = "SELECT total_balance FROM user_details WHERE user_unique = ?";
                $stmt = $conn->prepare($userBalanceSql);
                $stmt->bind_param('s', $t_user_unique);
                $stmt->execute();
                $userResult = $stmt->get_result();


                if ($userResult->num_rows > 0) {
                    $row2 = $userResult->fetch_assoc();
                    $total_balance = $row2['total_balance'];

                    // Update user balance
                    $new_total_balance = intval($total_balance) - intval($t_amount);
                    $updateUserBalanceSql = "UPDATE user_details SET total_balance = ? WHERE user_unique = ?";
                    $stmt = $conn->prepare($updateUserBalanceSql);
                    $stmt->bind_param('ds', $new_total_balance, $t_user_unique);

                    if ($stmt->execute()) {
                        // Update transaction status to 'Complete'
                        $updateTransactionSql = "UPDATE transaction_details SET t_status = 'Cancel', t_process = ? WHERE t_id = ?";
                        $stmt = $conn->prepare($updateTransactionSql);
                        $stmt->bind_param('si', $formattedDateTime, $t_id);

                        if ($stmt->execute()) {
                            $response = array(
                                'status' => 'success',
                                'message' => 'Record updated successfully.',
                            );
                            header('Content-Type: application/json');

                            echo json_encode($response);
                        } else {
                            $response = array(
                                'status' => 'error',
                                'message' => "Error updating transaction details: " . $conn->error,
                            );
                            header('Content-Type: application/json');

                            echo json_encode($response);
                        }
                    } else {
                        $response = array(
                            'status' => 'error',
                            'message' => "Error updating user balance: " . $conn->error,
                        );
                        header('Content-Type: application/json');

                        echo json_encode($response);
                    }
                } else {
                    $response = array(
                        'status' => 'error',
                        'message' => 'User not found.',
                    );
                    header('Content-Type: application/json');

                    echo json_encode($response);
                }
            } else {

                // Update transaction status to 'Complete'
                $updateTransactionSql = "UPDATE transaction_details SET t_status = 'Cancel', t_process = ? WHERE t_id = ?";
                $stmt = $conn->prepare($updateTransactionSql);
                $stmt->bind_param('si', $formattedDateTime, $t_id);

                if ($stmt->execute()) {
                    $response = array(
                        'status' => 'success',
                        'message' => 'Record updated successfully.',
                    );
                    header('Content-Type: application/json');

                    echo json_encode($response);
                } else {
                    $response = array(
                        'status' => 'error',
                        'message' => "Error updating transaction details: " . $conn->error,
                    );
                    header('Content-Type: application/json');

                    echo json_encode($response);
                }
            }
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Deposit Record not found.',
            );
            header('Content-Type: application/json');

            echo json_encode($response);
        }
    }










    // echo "hi";

    if (isset($_POST['action']) && $_POST['action'] === 'complete') {
        $t_id = $_POST['t_id'];

        $currentDateTime = new DateTime("now", new DateTimeZone('Asia/Kolkata'));
        $formattedDateTime = $currentDateTime->format('Y-m-d H:i:s');

        // Check if the deposit record exists and retrieve necessary details
        $checkDepositIdSql = "SELECT t_amount, t_user_unique FROM transaction_details WHERE t_id = ?";
        $stmt = $conn->prepare($checkDepositIdSql);
        $stmt->bind_param('i', $t_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $t_amount = $row['t_amount'];
            $t_user_unique = $row['t_user_unique'];

            // Check if the transaction is already marked as complete
            $checkCompleteSql = "SELECT t_id FROM transaction_details WHERE t_id = ? AND t_status = 'Complete'";
            $stmt = $conn->prepare($checkCompleteSql);
            $stmt->bind_param('i', $t_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $response = array(
                    'status' => 'error',
                    'message' => 'Already Completed transaction',
                );
                header('Content-Type: application/json');

                echo json_encode($response);
            } else {
                // Retrieve user balance
                $userBalanceSql = "SELECT total_balance FROM user_details WHERE user_unique = ?";
                $stmt = $conn->prepare($userBalanceSql);
                $stmt->bind_param('s', $t_user_unique);
                $stmt->execute();
                $userResult = $stmt->get_result();

                if ($userResult->num_rows > 0) {
                    $row2 = $userResult->fetch_assoc();
                    $total_balance = $row2['total_balance'];

                    // Update user balance
                    $new_total_balance = intval($total_balance) + intval($t_amount);
                    $updateUserBalanceSql = "UPDATE user_details SET total_balance = ? WHERE user_unique = ?";
                    $stmt = $conn->prepare($updateUserBalanceSql);
                    $stmt->bind_param('ds', $new_total_balance, $t_user_unique);

                    if ($stmt->execute()) {
                        // Update transaction status to 'Complete'
                        $updateTransactionSql = "UPDATE transaction_details SET t_status = 'Complete', t_process = ? WHERE t_id = ?";
                        $stmt = $conn->prepare($updateTransactionSql);
                        $stmt->bind_param('si', $formattedDateTime, $t_id);

                        if ($stmt->execute()) {
                            $response = array(
                                'status' => 'success',
                                'message' => 'Record updated successfully.',
                            );
                            header('Content-Type: application/json');

                            echo json_encode($response);
                        } else {
                            $response = array(
                                'status' => 'error',
                                'message' => "Error updating transaction details: " . $conn->error,
                            );
                            header('Content-Type: application/json');

                            echo json_encode($response);
                        }
                    } else {
                        $response = array(
                            'status' => 'error',
                            'message' => "Error updating user balance: " . $conn->error,
                        );
                        header('Content-Type: application/json');

                        echo json_encode($response);
                    }
                } else {
                    $response = array(
                        'status' => 'error',
                        'message' => 'User not found.',
                    );
                    header('Content-Type: application/json');

                    echo json_encode($response);
                }
            }
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Deposit Record not found.',
            );
            header('Content-Type: application/json');

            echo json_encode($response);
        }
    }










    if (isset($_POST['action']) && $_POST['action'] === 'in_progress') {

        $t_id = $_POST['t_id'];

        // Check if the deposit record exists and retrieve necessary details
        $checkDepositIdSql = "SELECT t_amount, t_user_unique FROM transaction_details WHERE t_id = ?";
        $stmt = $conn->prepare($checkDepositIdSql);
        $stmt->bind_param('i', $t_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $t_amount = $row['t_amount'];
            $t_user_unique = $row['t_user_unique'];

            // Check if the transaction is already marked as complete
            $checkCompleteSql = "SELECT t_id FROM transaction_details WHERE t_id = ? AND t_status = 'Complete'";
            $stmt = $conn->prepare($checkCompleteSql);
            $stmt->bind_param('i', $t_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {


                // Retrieve user balance
                $userBalanceSql = "SELECT total_balance FROM user_details WHERE user_unique = ?";
                $stmt = $conn->prepare($userBalanceSql);
                $stmt->bind_param('s', $t_user_unique);
                $stmt->execute();
                $userResult = $stmt->get_result();


                if ($userResult->num_rows > 0) {
                    $row2 = $userResult->fetch_assoc();
                    $total_balance = $row2['total_balance'];

                    // Update user balance
                    $new_total_balance = intval($total_balance) - intval($t_amount);
                    $updateUserBalanceSql = "UPDATE user_details SET total_balance = ? WHERE user_unique = ?";
                    $stmt = $conn->prepare($updateUserBalanceSql);
                    $stmt->bind_param('ds', $new_total_balance, $t_user_unique);

                    if ($stmt->execute()) {
                        // Update transaction status to 'Complete'
                        $updateTransactionSql = "UPDATE transaction_details SET t_status = 'Review', t_process = '' WHERE t_id = ?";
                        $stmt = $conn->prepare($updateTransactionSql);
                        $stmt->bind_param('i', $t_id);

                        if ($stmt->execute()) {
                            $response = array(
                                'status' => 'success',
                                'message' => 'Record updated successfully.',
                            );
                            header('Content-Type: application/json');

                            echo json_encode($response);
                        } else {
                            $response = array(
                                'status' => 'error',
                                'message' => "Error updating transaction details: " . $conn->error,
                            );
                            header('Content-Type: application/json');

                            echo json_encode($response);
                        }
                    } else {
                        $response = array(
                            'status' => 'error',
                            'message' => "Error updating user balance: " . $conn->error,
                        );
                        header('Content-Type: application/json');

                        echo json_encode($response);
                    }
                } else {
                    $response = array(
                        'status' => 'error',
                        'message' => 'User not found.',
                    );
                    header('Content-Type: application/json');

                    echo json_encode($response);
                }
            } else {

                // Update transaction status to 'Complete'
                $updateTransactionSql = "UPDATE transaction_details SET t_status = 'Review', t_process = '' WHERE t_id = ?";
                $stmt = $conn->prepare($updateTransactionSql);
                $stmt->bind_param('i', $t_id);

                if ($stmt->execute()) {
                    $response = array(
                        'status' => 'success',
                        'message' => 'Record updated successfully.',
                    );
                    header('Content-Type: application/json');

                    echo json_encode($response);
                } else {
                    $response = array(
                        'status' => 'error',
                        'message' => "Error updating transaction details: " . $conn->error,
                    );
                    header('Content-Type: application/json');

                    echo json_encode($response);
                }
            }
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Deposit Record not found.',
            );
            header('Content-Type: application/json');

            echo json_encode($response);
        }
    }







    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $t_id = $_POST['t_id'];



        // Delete the associated transaction details
        $deleteTransactionDetailsSql = "DELETE FROM transaction_details WHERE t_id = ?";
        $stmt = $conn->prepare($deleteTransactionDetailsSql);
        $stmt->bind_param('s', $t_id);

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
