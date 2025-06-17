<!-- <div class="text-sm">
    <ul class="flex items-center gap-2">
        <li><a>Admin</a></li>
        <li><i class="fa-solid fa-angle-right text-gray-400"></i></li>
        <li>Dashboard</li>
    </ul>
</div> -->




<section class="">
    <div class="max-w-[85rem] mx-auto">
        <!-- Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-8">
            <!-- Card -->
            <a href="?page=allPlayers" class="flex flex-col btn-effect bg-white shadow-lg sm:shadow-2xl rounded-xl py-4 dark:bg-slate-900 dark:border-gray-800">
                <div class="p-4 md:p-8 flex gap-x-4">
                    <div class="flex-shrink-0 flex justify-center items-center size-[46px] bg-gray-100 rounded-lg dark:bg-gray-800">
                        <i class="fa-regular fa-users flex-shrink-0 text-xl text-gray-600 dark:text-gray-400"></i>
                    </div>
                    <div class="grow">
                        <div class="flex items-center gap-x-2">
                            <p class="text-xs uppercase tracking-wide text-gray-500">
                                Total users
                            </p>
                        </div>
                        <div class="mt-1 flex items-center gap-x-2">
                            <h3 class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-gray-200">
                                <?php
                                $sql = "SELECT COUNT(*) as total_users FROM `user_details`";
                                $result = $conn->query($sql);

                                if ($result && $result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $total_users = number_format($row['total_users'], 0);
                                    echo $total_users;
                                } else {
                                    echo "0 users";
                                }

                                $result->free_result();

                                ?>
                            </h3>
                        </div>
                    </div>
                </div>
            </a>
            <!-- End Card -->
            <!-- Card -->
            <div class="flex flex-col bg-white shadow-lg sm:shadow-2xl rounded-xl py-4 dark:bg-slate-900 dark:border-gray-800">
                <div class="p-4 md:p-8 flex gap-x-4">
                    <div class="flex-shrink-0 flex justify-center items-center size-[46px] bg-gray-100 rounded-lg dark:bg-gray-800">
                        <i class="fa-solid fa-indian-rupee-sign flex-shrink-0 text-xl text-gray-600 dark:text-gray-400"></i>
                    </div>
                    <div class="grow">
                        <div class="flex items-center gap-x-2">
                            <p class="text-xs uppercase tracking-wide text-gray-500">
                                Total users Balance
                            </p>

                        </div>
                        <div class="mt-1 flex items-center gap-x-2">
                            <h3 class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-gray-200">
                                <?php
                                $sql = "SELECT SUM(`total_balance`) AS total_balance FROM `user_details`";
                                $result = $conn->query($sql);

                                if ($result && $result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $total_balance = number_format($row['total_balance'], 2);
                                    echo '&#x20B9;' . $total_balance;
                                } else {
                                    echo "&#x20B9; 0";
                                }

                                $result->free_result();

                                ?>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Card -->
            <!-- Card -->
            <div class="flex flex-col bg-white shadow-lg sm:shadow-2xl rounded-xl py-4 dark:bg-slate-900 dark:border-gray-800">
                <div class="p-4 md:p-8 flex gap-x-4">
                    <div class="flex-shrink-0 flex justify-center items-center size-[46px] bg-gray-100 rounded-lg dark:bg-gray-800">
                        <i class="fa-solid fa-indian-rupee-sign flex-shrink-0 text-xl text-gray-600 dark:text-gray-400"></i>
                    </div>
                    <div class="grow">
                        <div class="flex items-center gap-x-2">
                            <p class="text-xs uppercase tracking-wide text-gray-500">
                                Total Withdrawal Balance
                            </p>

                        </div>
                        <div class="mt-1 flex items-center gap-x-2">
                            <h3 class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-gray-200">
                                <?php
                                $sql = "SELECT SUM(`total_withdraw_balance`) AS total_withdraw_balance FROM `user_details`";
                                $result = $conn->query($sql);

                                if ($result && $result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $total_withdraw_balance = number_format($row['total_withdraw_balance'], 2);
                                    echo '&#x20B9;' . $total_withdraw_balance;
                                } else {
                                    echo "&#x20B9; 0";
                                }

                                $result->free_result();

                                ?>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Card -->
            <!-- Card -->
            <a href="?page=allPlayers" class="flex flex-col btn-effect bg-white shadow-lg sm:shadow-2xl rounded-xl py-4 dark:bg-slate-900 dark:border-gray-800">
                <div class="p-4 md:p-8 flex gap-x-4">
                    <div class="flex-shrink-0 flex justify-center items-center size-[46px] bg-gray-100 rounded-lg dark:bg-gray-800">
                        <i class="fa-regular fa-user-plus flex-shrink-0 text-xl text-gray-600 dark:text-gray-400"></i>
                    </div>
                    <div class="grow">
                        <div class="flex items-center gap-x-2">
                            <p class="text-xs uppercase tracking-wide text-gray-500">
                                Today New Users
                            </p>

                        </div>
                        <div class="mt-1 flex items-center gap-x-2">
                            <h3 class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-gray-200">
                                <?php
                                $sql = "SELECT COUNT(*) AS total_users FROM `user_details` WHERE DATE(`date_time`) = CURDATE()";
                                $result = $conn->query($sql);

                                if ($result && $result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $total_users = number_format($row['total_users'], 0);
                                    echo $total_users;
                                } else {
                                    echo "0";
                                }

                                $result->free_result();

                                ?>
                            </h3>
                        </div>
                    </div>
                </div>
            </a>
            <!-- End Card -->
            <!-- Card -->
            <!-- <div class="flex flex-col bg-white shadow-lg sm:shadow-2xl rounded-xl py-4 dark:bg-slate-900 dark:border-gray-800">
                <div class="p-4 md:p-8 flex gap-x-4">
                    <div class="flex-shrink-0 flex justify-center items-center size-[46px] bg-gray-100 rounded-lg dark:bg-gray-800">
                        <i class="fa-solid fa-user-xmark flex-shrink-0 text-xl text-gray-600 dark:text-gray-400"></i>
                    </div>
                    <div class="grow">
                        <div class="flex items-center gap-x-2">
                            <p class="text-xs uppercase tracking-wide text-gray-500">
                                Total Blocked Users
                            </p>

                        </div>
                        <div class="mt-1 flex items-center gap-x-2">
                            <h3 class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-gray-200">
                                0
                            </h3>
                        </div>
                    </div>
                </div>
            </div> -->
            <!-- End Card -->
            <!-- Card -->
            <a href="?page=allBattle" class="flex flex-col btn-effect bg-white shadow-lg sm:shadow-2xl rounded-xl py-4 dark:bg-slate-900 dark:border-gray-800">
                <div class="p-4 md:p-8 flex gap-x-4">
                    <div class="flex-shrink-0 flex justify-center items-center size-[46px] bg-gray-100 rounded-lg dark:bg-gray-800">
                        <i class="fa-regular fa-dice flex-shrink-0 text-xl text-gray-600 dark:text-gray-400"></i>
                    </div>
                    <div class="grow">
                        <div class="flex items-center gap-x-2">
                            <p class="text-xs uppercase tracking-wide text-gray-500">
                                Today Games
                            </p>

                        </div>
                        <div class="mt-1 flex items-center gap-x-2">
                            <h3 class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-gray-200">
                                <?php
                                $sql = "SELECT COUNT(*) AS total_battles FROM `battles` WHERE DATE(`b_created_at`) = CURDATE()";
                                $result = $conn->query($sql);

                                if ($result && $result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $total_battles = number_format($row['total_battles'], 0);
                                    echo $total_battles;
                                } else {
                                    echo "0";
                                }

                                $result->free_result();

                                ?>
                            </h3>
                        </div>
                    </div>
                </div>
            </a>
            <!-- End Card -->
            <!-- Card -->
            <a href="?page=allBattle" class="flex flex-col btn-effect bg-white shadow-lg sm:shadow-2xl rounded-xl py-4 dark:bg-slate-900 dark:border-gray-800">
                <div class="p-4 md:p-8 flex gap-x-4">
                    <div class="flex-shrink-0 flex justify-center items-center size-[46px] bg-gray-100 rounded-lg dark:bg-gray-800">
                        <i class="fa-regular fa-gamepad flex-shrink-0 text-xl text-gray-600 dark:text-gray-400"></i>
                    </div>
                    <div class="grow">
                        <div class="flex items-center gap-x-2">
                            <p class="text-xs uppercase tracking-wide text-gray-500">
                                All Games
                            </p>

                        </div>
                        <div class="mt-1 flex items-center gap-x-2">
                            <h3 class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-gray-200">
                                <?php
                                $sql = "SELECT COUNT(*) AS total_battles FROM `battles`";
                                $result = $conn->query($sql);

                                if ($result && $result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $total_battles = number_format($row['total_battles'], 0);
                                    echo $total_battles;
                                } else {
                                    echo "0";
                                }

                                $result->free_result();

                                ?>
                            </h3>
                        </div>
                    </div>
                </div>
            </a>
            <!-- End Card -->
            <!-- Card -->
            <a href="?page=allBattle&status=Complete" class="flex flex-col btn-effect bg-white shadow-lg sm:shadow-2xl rounded-xl py-4 dark:bg-slate-900 dark:border-gray-800">
                <div class="p-4 md:p-8 flex gap-x-4">
                    <div class="flex-shrink-0 flex justify-center items-center size-[46px] bg-gray-100 rounded-lg dark:bg-gray-800">
                        <i class="fa-regular fa-gamepad-modern flex-shrink-0 text-xl text-gray-600 dark:text-gray-400"></i>
                    </div>
                    <div class="grow">
                        <div class="flex items-center gap-x-2">
                            <p class="text-xs uppercase tracking-wide text-gray-500">
                                Today Success Games
                            </p>

                        </div>
                        <div class="mt-1 flex items-center gap-x-2">
                            <h3 class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-gray-200">
                                <?php
                                $sql = "SELECT COUNT(*) AS total_completed_battles FROM `battles` WHERE `b_status` = 'complete'";
                                $result = $conn->query($sql);

                                if ($result && $result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $total_completed_battles = number_format($row['total_completed_battles'], 0);
                                    echo $total_completed_battles;
                                } else {
                                    echo "0";
                                }

                                $result->free_result();

                                ?>
                            </h3>
                        </div>
                    </div>
                </div>
            </a>
            <!-- End Card -->
            <!-- Card -->
            <a href="?page=allBattle&status=Cancel" class="flex flex-col btn-effect bg-white shadow-lg sm:shadow-2xl rounded-xl py-4 dark:bg-slate-900 dark:border-gray-800">
                <div class="p-4 md:p-8 flex gap-x-4">
                    <div class="flex-shrink-0 flex justify-center items-center size-[46px] bg-gray-100 rounded-lg dark:bg-gray-800">
                        <i class="fa-regular fa-ban flex-shrink-0 text-xl text-gray-600 dark:text-gray-400"></i>
                    </div>
                    <div class="grow">
                        <div class="flex items-center gap-x-2">
                            <p class="text-xs uppercase tracking-wide text-gray-500">
                                Total Cancel Games
                            </p>

                        </div>
                        <div class="mt-1 flex items-center gap-x-2">
                            <h3 class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-gray-200">
                                <?php
                                $sql = "SELECT COUNT(*) AS total_completed_battles FROM `battles` WHERE `b_status` = 'Leave'";
                                $result = $conn->query($sql);

                                if ($result && $result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $total_completed_battles = number_format($row['total_completed_battles'], 0);
                                    echo $total_completed_battles;
                                } else {
                                    echo "0";
                                }

                                $result->free_result();

                                ?>
                            </h3>
                        </div>
                    </div>
                </div>
            </a>
            <!-- End Card -->
            <!-- Card -->
            <div class="flex flex-col bg-white shadow-lg sm:shadow-2xl rounded-xl py-4 dark:bg-slate-900 dark:border-gray-800">
                <div class="p-4 md:p-8 flex gap-x-4">
                    <div class="flex-shrink-0 flex justify-center items-center size-[46px] bg-gray-100 rounded-lg dark:bg-gray-800">
                        <i class="fa-solid fa-money-bill flex-shrink-0 text-xl text-gray-600 dark:text-gray-400"></i>
                    </div>
                    <div class="grow">
                        <div class="flex items-center gap-x-2">
                            <p class="text-xs uppercase tracking-wide text-gray-500">
                                Total Admin Commission
                            </p>

                        </div>
                        <div class="mt-1 flex items-center gap-x-2">
                            <h3 class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-gray-200">
                                <?php
                                $sql = "SELECT SUM(`b_cashplay_commission`) AS total_cashplay_commission FROM `battles` WHERE `b_status` = 'complete'";
                                $result = $conn->query($sql);

                                if ($result && $result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $total_cashplay_commission = number_format($row['total_cashplay_commission'], 2);
                                    echo "&#x20B9; " . $total_cashplay_commission;
                                } else {
                                    echo "0";
                                }

                                $result->free_result();

                                ?>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Card -->
            <!-- Card -->
            <div class="flex flex-col bg-white shadow-lg sm:shadow-2xl rounded-xl py-4 dark:bg-slate-900 dark:border-gray-800">
                <div class="p-4 md:p-8 flex gap-x-4">
                    <div class="flex-shrink-0 flex justify-center items-center size-[46px] bg-gray-100 rounded-lg dark:bg-gray-800">
                        <i class="fa-regular fa-money-bill flex-shrink-0 text-xl text-gray-600 dark:text-gray-400"></i>
                    </div>
                    <div class="grow">
                        <div class="flex items-center gap-x-2">
                            <p class="text-xs uppercase tracking-wide text-gray-500">
                                &#x20B9; Today Admin Commission
                            </p>

                        </div>
                        <div class="mt-1 flex items-center gap-x-2">
                            <h3 class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-gray-200">
                                <?php
                                $sql = "SELECT SUM(`b_cashplay_commission`) AS total_cashplay_commission FROM `battles` WHERE DATE(`b_created_at`) = CURDATE() AND `b_status` = 'complete'";
                                $result = $conn->query($sql);

                                if ($result && $result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $total_cashplay_commission = number_format($row['total_cashplay_commission'], 2);
                                    echo "&#x20B9; " . $total_cashplay_commission;
                                } else {
                                    echo "0";
                                }

                                $result->free_result();

                                ?>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Card -->
            <!-- Card -->
            <a href="?page=deposit" class="flex flex-col btn-effect bg-white shadow-lg sm:shadow-2xl rounded-xl py-4 dark:bg-slate-900 dark:border-gray-800">
                <div class="p-4 md:p-8 flex gap-x-4">
                    <div class="flex-shrink-0 flex justify-center items-center size-[46px] bg-gray-100 rounded-lg dark:bg-gray-800">
                        <i class="fa-solid fa-coin flex-shrink-0 text-xl text-gray-600 dark:text-gray-400"></i>
                    </div>
                    <div class="grow">
                        <div class="flex items-center gap-x-2">
                            <p class="text-xs uppercase tracking-wide text-gray-500">
                                Total Deposit
                            </p>

                        </div>
                        <div class="mt-1 flex items-center gap-x-2">
                            <h3 class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-gray-200">
                                <?php
                                $sql = "SELECT SUM(`t_amount`) AS total_deposit_amount FROM `transaction_details` WHERE `t_payment_via` = 'Deposit' AND `t_status` = 'Complete'";
                                $result = $conn->query($sql);

                                if ($result && $result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $total_deposit_amount = number_format($row['total_deposit_amount'], 2);
                                    echo "&#x20B9; " . $total_deposit_amount;
                                } else {
                                    echo "0  &#x20B9;";
                                }

                                $result->free_result();

                                ?>
                            </h3>
                        </div>
                    </div>
                </div>
            </a>
            <!-- End Card -->
            <!-- Card -->
            <a href="?page=deposit" class="flex flex-col btn-effect bg-white shadow-lg sm:shadow-2xl rounded-xl py-4 dark:bg-slate-900 dark:border-gray-800">
                <div class="p-4 md:p-8 flex gap-x-4">
                    <div class="flex-shrink-0 flex justify-center items-center size-[46px] bg-gray-100 rounded-lg dark:bg-gray-800">
                        <i class="fa-solid fa-coin-vertical flex-shrink-0 text-xl text-gray-600 dark:text-gray-400"></i>
                    </div>
                    <div class="grow">
                        <div class="flex items-center gap-x-2">
                            <p class="text-xs uppercase tracking-wide text-gray-500">
                                Today Deposit
                            </p>

                        </div>
                        <div class="mt-1 flex items-center gap-x-2">
                            <h3 class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-gray-200">
                                <?php
                                $sql = "SELECT SUM(`t_amount`) AS total_deposit_amount FROM `transaction_details` WHERE `t_payment_via` = 'Deposit' AND `t_status` = 'Complete' AND DATE(`t_request`) = CURDATE()";
                                $result = $conn->query($sql);

                                if ($result && $result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $total_deposit_amount = number_format($row['total_deposit_amount'], 2);
                                    echo "&#x20B9; " . $total_deposit_amount;
                                } else {
                                    echo "0  &#x20B9;";
                                }

                                $result->free_result();

                                ?>
                            </h3>
                        </div>
                    </div>
                </div>
            </a>
            <!-- End Card -->
            <!-- Card -->
            <a href="?page=withdraw" class="flex flex-col btn-effect bg-white shadow-lg sm:shadow-2xl rounded-xl py-4 dark:bg-slate-900 dark:border-gray-800">
                <div class="p-4 md:p-8 flex gap-x-4">
                    <div class="flex-shrink-0 flex justify-center items-center size-[46px] bg-gray-100 rounded-lg dark:bg-gray-800">
                        <i class="fa-sharp fa-solid fa-receipt flex-shrink-0 text-xl text-gray-600 dark:text-gray-400"></i>
                    </div>
                    <div class="grow">
                        <div class="flex items-center gap-x-2">
                            <p class="text-xs uppercase tracking-wide text-gray-500">
                                Total Withdrawal
                            </p>

                        </div>
                        <div class="mt-1 flex items-center gap-x-2">
                            <h3 class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-gray-200">
                                <?php
                                $sql = "SELECT SUM(`t_amount`) AS total_withdraw_amount FROM `transaction_details` WHERE `t_payment_via` = 'Withdraw' AND `t_status` = 'complete'";
                                $result = $conn->query($sql);

                                if ($result && $result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $total_withdraw_amount = number_format($row['total_withdraw_amount'], 2);
                                    echo "&#x20B9; " . $total_withdraw_amount;
                                } else {
                                    echo "0  &#x20B9;";
                                }

                                $result->free_result();

                                ?>
                            </h3>
                        </div>
                    </div>
                </div>
            </a>
            <!-- End Card -->
            <!-- Card -->
            <a href="?page=withdraw" class="flex flex-col btn-effect bg-white shadow-lg sm:shadow-2xl rounded-xl py-4 dark:bg-slate-900 dark:border-gray-800">
                <div class="p-4 md:p-8 flex gap-x-4">
                    <div class="flex-shrink-0 flex justify-center items-center size-[46px] bg-gray-100 rounded-lg dark:bg-gray-800">
                        <i class="fa-regular fa-hand-holding-dollar flex-shrink-0 text-xl text-gray-600 dark:text-gray-400"></i>
                    </div>
                    <div class="grow">
                        <div class="flex items-center gap-x-2">
                            <p class="text-xs uppercase tracking-wide text-gray-500">
                                Today Withdrawal
                            </p>

                        </div>
                        <div class="mt-1 flex items-center gap-x-2">
                            <h3 class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-gray-200">
                                <?php
                                $sql = "SELECT SUM(`t_amount`) AS total_withdraw_amount FROM `transaction_details` WHERE `t_payment_via` = 'Withdraw' AND `t_status` = 'complete' AND DATE(`t_request`) = CURDATE()";
                                $result = $conn->query($sql);

                                if ($result && $result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $total_withdraw_amount = number_format($row['total_withdraw_amount'], 2);
                                    echo "&#x20B9; " . $total_withdraw_amount;
                                } else {
                                    echo "0  &#x20B9;";
                                }

                                $result->free_result();

                                ?>
                            </h3>
                        </div>
                    </div>
                </div>
            </a>
            <!-- End Card -->
</section>