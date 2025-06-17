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

        $sql = "SELECT wr.wr_id, wr.wr_dateAndTime, wr.wr_process_date, wr.wr_user_unique, wr.wr_balance, wr.wr_paymentAmount, wr.wr_status, wr.wr_paymentMethod, u.user_name, u.avatar FROM withdraw_request wr JOIN user_details u ON wr.wr_user_unique = u.user_unique WHERE 1=1";

        if ($search_user) {
            $sql .= " AND (u.user_name LIKE '%" . $conn->real_escape_string($search_user) . "%')";

            $sql .= " OR (wr.wr_user_unique LIKE '%" . $conn->real_escape_string($search_user) . "%')";

            $sql .= " OR (wr.wr_withdrawalId LIKE '%" . $conn->real_escape_string($search_user) . "%')";

            $sql .= " OR (wr.wr_transactionNumber LIKE '%" . $conn->real_escape_string($search_user) . "%')";
        }


        if ($status) {
            $sql .= " AND wr.wr_status = '" . $conn->real_escape_string($status) . "'";
        }

        if ($payment_method) {
            $sql .= " AND wr.wr_paymentMethod = '" . $conn->real_escape_string($payment_method) . "'";
        }

        if ($date_filter) {
            $today = date('Y-m-d');
            switch ($date_filter) {
                case 'today':
                    $sql .= " AND DATE(wr.wr_dateAndTime) = '$today'";
                    break;
                case 'yesterday':
                    $yesterday = date('Y-m-d', strtotime('-1 day'));
                    $sql .= " AND DATE(wr.wr_dateAndTime) = '$yesterday'";
                    break;
                case 'this_week':
                    $week_start = date('Y-m-d', strtotime('monday this week'));
                    $week_end = date('Y-m-d', strtotime('sunday this week'));
                    $sql .= " AND DATE(wr.wr_dateAndTime) BETWEEN '$week_start' AND '$week_end'";
                    break;
                case 'this_month':
                    $month_start = date('Y-m-01');
                    $month_end = date('Y-m-t');
                    $sql .= " AND DATE(wr.wr_dateAndTime) BETWEEN '$month_start' AND '$month_end'";
                    break;
                case 'this_year':
                    $year_start = date('Y-01-01');
                    $year_end = date('Y-12-31');
                    $sql .= " AND DATE(wr.wr_dateAndTime) BETWEEN '$year_start' AND '$year_end'";
                    break;
                case 'custom':
                    if ($start_date && $end_date) {
                        $sql .= " AND DATE(wr.wr_dateAndTime) BETWEEN '$start_date' AND '$end_date'";
                    }
                    break;
            }
        }
        $sql .= " ORDER BY `wr_dateAndTime` DESC";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $wr_dateAndTime = new DateTime($row['wr_dateAndTime']);
                $wr_process_date = new DateTime($row['wr_process_date']);
?>
                <tr id="withdraw_request_<?php echo htmlspecialchars($row['wr_id']) ?>" class="bg-white hover:bg-gray-50 dark:bg-slate-900 dark:hover:bg-slate-800">
                    <td class="size-px px-5 whitespace-nowrap">
                        <a target="_blank" href="?page=allPlayers&player=<?php echo htmlspecialchars($row['wr_user_unique']) ?>" class="p-5 cursor-pointer overflow-hidden">
                            <div class="flex items-center gap-x-2 w-max truncate">
                                <img class="inline-block size-9 rounded-full" src="https://cashplay.in/assets/img/avatar/<?php echo htmlspecialchars($row['avatar']) ?>" alt="<?php echo htmlspecialchars($row['user_name']) ?>'s Avatar">
                                <div class="flex flex-col gap-0.5">
                                    <span class="text-sm text-gray-600 dark:text-gray-400 capitalize font-medium"><?php echo htmlspecialchars($row['user_name']) ?></span>
                                    <span class="text-xs text-gray-400 dark:text-gray-600 capitalize font-medium"><?php echo htmlspecialchars($row['wr_user_unique']) ?></span>
                                </div>
                            </div>
                        </a>
                    </td>
                    <td class="size-px whitespace-nowrap">
                        <div class="block">
                            <span class="block px-6 py-2">
                                <span class="text-sm text-gray-600 dark:text-gray-400"><?php echo htmlspecialchars($row['wr_paymentAmount']) ?> <span class="text-green-400">&#x20B9;</span></span>
                            </span>
                        </div>
                    </td>
                    <td class="size-px whitespace-nowrap">
                        <div class="block">
                            <span class="block px-6 py-2">
                                <span class="text-sm text-gray-600 dark:text-gray-400"><?php echo htmlspecialchars($row['wr_balance']) ?> <span class="text-green-400">&#x20B9;</span></span>
                            </span>
                        </div>
                    </td>
                    <td class="size-px whitespace-nowrap">
                        <div class="block">
                            <span class="block px-6 py-2">
                                <span class="text-sm text-gray-600 dark:text-gray-400"><?php echo htmlspecialchars($row['wr_paymentMethod']) ?></span>
                            </span>
                        </div>
                    </td>
                    <td class="size-px whitespace-nowrap">
                        <div class="block">
                            <span class="block px-6 py-2">
                                <span class="text-sm text-gray-600 dark:text-gray-400"><?php echo $wr_dateAndTime->format('d M Y') ?></span>
                            </span>
                        </div>
                    </td>
                    <td class="size-px whitespace-nowrap">
                        <div class="block">
                            <span class="block px-6 py-2">
                                <span class="text-sm text-gray-600 dark:text-gray-400"><?php echo $wr_process_date->format('d M Y') ?></span>
                            </span>
                        </div>
                    </td>
                    <td class="size-px whitespace-nowrap">
                        <div class="block">
                            <span class="text-sm font-medium <?php echo (
                                                                    ($row['wr_status'] === 'Complete') ? 'text-green-500' : (($row['wr_status'] === 'Cancel') ? 'text-red-500' : 'text-gray-400')
                                                                ); ?>">
                                <?php echo htmlspecialchars($row['wr_status']); ?>
                            </span>
                        </div>
                    </td>
                    <td class="size-px whitespace-nowrap">
                        <button type="button" class="block">
                            <span class="px-6 py-1.5">
                                <?php if ($row['wr_status'] === 'Complete') { ?>
                                    <span onclick="withdrawRequestDataModal('<?php echo htmlspecialchars($row['wr_id']) ?>')" class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-amber-600 transition-all text-sm dark:bg-slate-900 dark:hover:bg-slate-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800">
                                        <i class="fa-regular fa-file-lines"></i> View
                                    </span>
                                <?php } else { ?>
                                    <span onclick="withdrawRequestDataModal('<?php echo htmlspecialchars($row['wr_id']) ?>')" class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-amber-600 transition-all text-sm dark:bg-slate-900 dark:hover:bg-slate-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800">
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
            echo '<tr><td colspan="8">No records found.</td></tr>';
        }
    }











    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fetchDetails'])) {
        $wr_id = $_POST['wr_id'];

        // Fetch withdraw request data
        $query = "SELECT * FROM withdraw_request WHERE wr_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param(
            'i',
            $wr_id
        );
        $stmt->execute();
        $result = $stmt->get_result();
        $withdraw_request = $result->fetch_assoc();

        // Fetch user details data
        $user_unique = $withdraw_request['wr_user_unique'];
        $query = "SELECT  `avatar`, `user_name`,`total_balance`,`total_withdraw_balance` FROM user_details WHERE user_unique = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $user_unique);
        $stmt->execute();
        $result = $stmt->get_result();
        $user_details = $result->fetch_assoc();

        // Combine the data into an array
        $data = [
            'withdraw_request' => $withdraw_request,
            'user_details' => $user_details
        ];

        echo json_encode($data);
    }






    if (isset($_POST['action']) && $_POST['action'] === 'cancel') {
        $wr_id = $_POST['wr_id'];
        $currentDateTime = new DateTime("now", new DateTimeZone('Asia/Kolkata'));
        $formattedDateTime = $currentDateTime->format('Y-m-d H:i:s');

        // Check current status of the withdrawal request
        $checkStatusSql = "SELECT wr_status, wr_paymentAmount, wr_user_unique, wr_withdrawalId FROM withdraw_request WHERE wr_id = ?";
        $stmt = $conn->prepare($checkStatusSql);
        $stmt->bind_param('i', $wr_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if ($row['wr_status'] !== 'Cancel') {
                $wr_paymentAmount = $row['wr_paymentAmount'];
                $wr_user_unique = $row['wr_user_unique'];
                $wr_withdrawalId = $row['wr_withdrawalId'];

                // Update withdrawal request status to 'Cancel'
                $updateSql = "UPDATE withdraw_request SET wr_status = 'Cancel', wr_transactionNumber = '', wr_process_date = ? WHERE wr_id = ?";
                $stmt = $conn->prepare($updateSql);
                $stmt->bind_param('si', $formattedDateTime, $wr_id);

                if ($stmt->execute()) {
                    // UPDATE TRANSACTION DETAILS
                    $updateTransactionDetails = "UPDATE transaction_details SET t_status = 'Cancel', t_unique_id = '', t_process = '' WHERE t_transaction_id = ?";
                    $stmt = $conn->prepare($updateTransactionDetails);
                    $stmt->bind_param('s', $wr_withdrawalId);

                    if ($stmt->execute()) {
                        // Fetch current user balances
                        $userBalanceSql = "SELECT total_balance, total_withdraw_balance FROM user_details WHERE user_unique = ?";
                        $stmt = $conn->prepare($userBalanceSql);
                        $stmt->bind_param('s', $wr_user_unique);
                        $stmt->execute();
                        $userResult = $stmt->get_result();

                        if ($userResult->num_rows > 0) {
                            $userRow = $userResult->fetch_assoc();
                            $total_balance = $userRow['total_balance'];
                            $total_withdraw_balance = $userRow['total_withdraw_balance'];

                            // Update user balances
                            $newTotalBalance = $total_balance + $wr_paymentAmount;
                            $newWithdrawBalance = $total_withdraw_balance + $wr_paymentAmount;

                            $updateUserBalanceSql = "UPDATE user_details SET total_balance = ?, total_withdraw_balance = ? WHERE user_unique = ?";
                            $stmt = $conn->prepare($updateUserBalanceSql);
                            $stmt->bind_param('dds', $newTotalBalance, $newWithdrawBalance, $wr_user_unique);

                            if ($stmt->execute()) {
                                $response = array(
                                    'status' => 'success',
                                    'message' => 'Record updated successfully and balances adjusted.',
                                );
                            } else {
                                $response = array(
                                    'status' => 'error',
                                    'message' => "Error updating user balances: " . $conn->error,
                                );
                            }
                        } else {
                            $response = array(
                                'status' => 'error',
                                'message' => 'User not found.',
                            );
                        }
                    } else {
                        $response = array(
                            'status' => 'error',
                            'message' => "Error updating transaction details: " . $conn->error,
                        );
                    }
                } else {
                    $response = array(
                        'status' => 'error',
                        'message' => "Error updating withdraw request: " . $conn->error,
                    );
                }
            } else {
                $response = array(
                    'status' => 'error',
                    'message' => 'The withdraw request has already been cancelled.',
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Withdrawal request not found.',
            );
        }

        if (isset($response)) {
            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }








    if (isset($_POST['action']) && $_POST['action'] === 'complete') {

        $wr_id = $_POST['wr_id'];
        $transaction_id = $_POST['transaction_id'];
        $currentDateTime = new DateTime("now", new DateTimeZone('Asia/Kolkata'));
        $formattedDateTime = $currentDateTime->format('Y-m-d H:i:s');

        // Update withdrawal request status to 'Complete'
        $updateRequestSql = "UPDATE withdraw_request SET wr_status = 'Complete', wr_transactionNumber = ?, wr_process_date = ? WHERE wr_id = ?";
        $stmt = $conn->prepare($updateRequestSql);
        $stmt->bind_param('ssi', $transaction_id, $formattedDateTime, $wr_id);

        if ($stmt->execute()) {

            // Check for withdrawal ID associated with the request
            $checkWithdrawalIdSql = "SELECT wr_withdrawalId FROM withdraw_request WHERE wr_id = ?";
            $stmt = $conn->prepare($checkWithdrawalIdSql);
            $stmt->bind_param('i', $wr_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $wr_withdrawalId = $row['wr_withdrawalId'];

                // Update transaction details status to 'Complete'
                $updateTransactionSql = "UPDATE transaction_details SET t_status = 'Complete', t_unique_id = ?, t_process = ? WHERE t_transaction_id = ?";
                $stmt = $conn->prepare($updateTransactionSql);
                $stmt->bind_param('sss', $transaction_id, $formattedDateTime, $wr_withdrawalId);

                if ($stmt->execute()) {
                    $response = array(
                        'status' => 'success',
                        'message' => 'Record updated successfully.',
                    );
                } else {
                    $response = array(
                        'status' => 'error',
                        'message' => "Error updating transaction details: " . $conn->error,
                    );
                }
            } else {
                $response = array(
                    'status' => 'error',
                    'message' => 'Withdrawal ID not found.',
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'message' => "Error updating withdraw request: " . $conn->error,
            );
        }

        if (isset($response)) {
            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }










    if (isset($_POST['action']) && $_POST['action'] === 'in_progress') {

        $wr_id = $_POST['wr_id'];
        $currentDateTime = new DateTime("now", new DateTimeZone('Asia/Kolkata'));
        $formattedDateTime = $currentDateTime->format('Y-m-d H:i:s');

        // Update withdrawal request status to 'Review'
        $updateRequestSql = "UPDATE withdraw_request SET wr_status = 'Review', wr_transactionNumber = '', wr_process_date = ? WHERE wr_id = ?";
        $stmt = $conn->prepare($updateRequestSql);
        $stmt->bind_param('si', $formattedDateTime, $wr_id);

        if ($stmt->execute()) {
            // Check for withdrawal ID associated with the request
            $checkWithdrawalIdSql = "SELECT wr_withdrawalId FROM withdraw_request WHERE wr_id = ?";
            $stmt = $conn->prepare($checkWithdrawalIdSql);
            $stmt->bind_param('i', $wr_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $wr_withdrawalId = $row['wr_withdrawalId'];

                // Update transaction details status to 'Review'
                $updateTransactionSql = "UPDATE transaction_details SET t_status = 'Review', t_unique_id = '', t_process = '' WHERE t_transaction_id = ?";
                $stmt = $conn->prepare($updateTransactionSql);
                $stmt->bind_param('s', $wr_withdrawalId);

                if ($stmt->execute()) {
                    $response = array(
                        'status' => 'success',
                        'message' => 'Record updated successfully',
                    );
                } else {
                    $response = array(
                        'status' => 'error',
                        'message' => "Error updating transaction details: " . $conn->error,
                    );
                }
            } else {
                $response = array(
                    'status' => 'error',
                    'message' => 'Withdrawal ID not found.',
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'message' => "Error updating withdraw request: " . $conn->error,
            );
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }







    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $wr_id = $_POST['wr_id'];

        // First, check if the withdraw request exists and get the withdrawal ID
        $checkWithdrawalIdSql = "SELECT wr_withdrawalId FROM withdraw_request WHERE wr_id = ?";
        $stmt = $conn->prepare($checkWithdrawalIdSql);
        $stmt->bind_param('i', $wr_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $wr_withdrawalId = $row['wr_withdrawalId'];

            // Delete the withdraw request
            $deleteRequestSql = "DELETE FROM withdraw_request WHERE wr_id = ?";
            $stmt = $conn->prepare($deleteRequestSql);
            $stmt->bind_param('i', $wr_id);

            if ($stmt->execute()) {
                // Delete the associated transaction details
                $deleteTransactionDetailsSql = "DELETE FROM transaction_details WHERE t_transaction_id = ?";
                $stmt = $conn->prepare($deleteTransactionDetailsSql);
                $stmt->bind_param('s', $wr_withdrawalId);

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
            } else {
                $response = array(
                    'status' => 'error',
                    'message' => "Error deleting withdraw request: " . $conn->error,
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Withdrawal request not found.',
            );
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }
} else {
    header("Location: /auth/login.php");
}


mysqli_close($conn);
