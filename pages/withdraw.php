<!-- Table Section -->
<div class="max-w-[85rem] mx-auto">
    <!-- Card -->
    <div class="flex flex-col">
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-slate-900 dark:border-gray-700">
                    <!-- Header -->
                    <div class="px-6 py-4 pb-6 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-gray-700">
                        <div>
                            <h2 class="text-2xl lg:text-3xl font-semibold text-gray-800 dark:text-gray-200">
                                Withdraw Request
                            </h2>
                        </div>

                        <!-- <div>
                            <div class="inline-flex gap-x-2">
                                <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-amber-600 text-white hover:bg-amber-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="#">
                                    <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M5 12h14" />
                                        <path d="M12 5v14" />
                                    </svg>
                                    Create
                                </a>
                            </div>
                        </div> -->
                    </div>
                    <!-- End Header -->

                    <form id="filter-form" class="my-4 w-full">
                        <div class="flex flex-wrap justify-end items-center gap-4 px-10">
                            <input type="text" id="search_user" name="search_user" placeholder="Search here...." class="px-3 py-2 rounded-xl outline-none input border-2 border-gray-300">

                            <select id="status" name="status" class="px-3 py-2 border-2 rounded-xl outline-none select w-40 border-gray-200">
                                <option value="">All</option>
                                <option value="Complete">Complete</option>
                                <option value="Review">Review</option>
                                <option value="Cancel">Cancel</option>
                            </select>

                            <select id="payment_method" name="payment_method" class="px-3 py-2 border-2 rounded-xl outline-none select w-40 border-gray-200">
                                <option value="">All Methods</option>
                                <option value="UPI">UPI</option>
                                <option value="Bank">Bank</option>
                                <option value="Wallet">Wallet</option>
                            </select>

                            <select id="date_filter" name="date_filter" class="px-3 py-2 border-2 rounded-xl outline-none select w-40 border-gray-200">
                                <option value="today">Today</option>
                                <option value="yesterday">Yesterday</option>
                                <option value="this_week">This Week</option>
                                <option value="this_month">This Month</option>
                                <option value="this_year">This Year</option>
                                <option value="custom">Custom Range</option>
                            </select>

                            <input type="date" id="start_date" placeholder="Start Date" name="start_date" class="px-3 py-2 rounded-xl outline-none input hidden border-2 border-gray-300">
                            <input type="date" id="end_date" placeholder="End Date" name="end_date" class="px-3 py-2 rounded-xl outline-none input hidden border-2 border-gray-300">

                            <button type="submit" class="btn px-10 py-1 rounded-xl text-amber-500 border-amber-500 border-2">Filter</button>
                        </div>
                    </form>


                    <!-- Table -->
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-slate-900">
                            <tr>
                                <th scope="col" class="px-6 py-5 text-start flex-shrink-0">
                                    <div class="flex items-center gap-x-2 px-3 flex-shrink-0">
                                        <span class="text-xs font-semibold text uppercase tracking-wide text-gray-800 dark:text-gray-200 flex-shrink-0 w-max">
                                            Player
                                        </span>
                                    </div>
                                </th>

                                <th scope="col" class="px-6 py-5 text-start flex-shrink-0">
                                    <div class="flex items-center gap-x-2 flex-shrink-0">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200 flex-shrink-0 w-max">
                                            Amount
                                        </span>
                                    </div>
                                </th>

                                <th scope="col" class="px-6 py-5 text-start flex-shrink-0">
                                    <div class="flex items-center gap-x-2 flex-shrink-0">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200 flex-shrink-0 w-max">
                                            Remaining
                                        </span>
                                    </div>
                                </th>

                                <th scope="col" class="px-6 py-5 text-start flex-shrink-0">
                                    <div class="flex items-center gap-x-2 flex-shrink-0">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200 flex-shrink-0 w-max">
                                            Method
                                        </span>
                                    </div>
                                </th>

                                <th scope="col" class="px-6 py-5 text-start flex-shrink-0">
                                    <div class="flex items-center gap-x-2 px-3 flex-shrink-0">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200 flex-shrink-0 w-max">
                                            Request
                                        </span>
                                    </div>
                                </th>

                                <th scope="col" class="px-6 py-5 text-start flex-shrink-0">
                                    <div class="flex items-center gap-x-2 px-2 flex-shrink-0">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200 flex-shrink-0 w-max">
                                            Process
                                        </span>
                                    </div>
                                </th>

                                <th scope="col" class="px-6 py-5 text-start flex-shrink-0">
                                    <div class="flex items-center gap-x-2 flex-shrink-0">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200 flex-shrink-0 w-max">
                                            Status
                                        </span>
                                    </div>
                                </th>

                                <th scope="col" class="px-6 py-5 text-start flex-shrink-0">
                                    <div class="flex items-center gap-x-2 flex-shrink-0">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200 flex-shrink-0 w-max">
                                            Actions
                                        </span>
                                    </div>
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const hash = window.location.hash;
                                    const params = new URLSearchParams(hash.slice(1));
                                    const withdraw = params.get('withdraw');
                                    if (withdraw) {
                                        withdrawRequestDataModal(withdraw);
                                    }
                                });
                            </script>
                            <?php
                            $weekStart = date('Y-m-d', strtotime('monday this week'));
                            $weekEnd = date('Y-m-d', strtotime('sunday this week'));

                            $sql = "SELECT wr.wr_id, wr.wr_dateAndTime, wr.wr_process_date, wr.wr_user_unique, wr.wr_balance, wr.wr_paymentAmount, wr.wr_status, wr.wr_paymentMethod, u.user_name, u.avatar 
                                    FROM withdraw_request wr
                                    JOIN user_details u ON wr.wr_user_unique = u.user_unique
                                    WHERE DATE(wr.wr_dateAndTime) BETWEEN '$weekStart' AND '$weekEnd' ORDER BY wr.wr_dateAndTime DESC
                                ";


                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {

                                    $wr_dateAndTime = new DateTime($row['wr_dateAndTime']);

                                    $wr_process_date = new DateTime($row['wr_process_date']);

                            ?>
                                    <tr id="withdraw_request_<?php echo htmlspecialchars($row['wr_id']) ?>" class="bg-white hover:bg-gray-50 dark:bg-slate-900 dark:hover:bg-slate-800">
                                        <td class="size-px whitespace-nowrap px-5">
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
                                                <span class="block px-6 py-2">
                                                    <span class="text-sm font-medium <?php echo (
                                                                                            ($row['wr_status'] === 'Complete') ? 'text-green-500' : (($row['wr_status'] === 'Cancel') ? 'text-red-500' : 'text-gray-400')
                                                                                        ); ?>">
                                                        <?php echo htmlspecialchars($row['wr_status']); ?>
                                                    </span>
                                                </span>
                                            </div>
                                        </td>
                                        <td class="size-px whitespace-nowrap">
                                            <button type="button" class="block">
                                                <span class="px-6 py-1.5">
                                                    <?php
                                                    if ($row['wr_status'] === 'Complete') {
                                                    ?>
                                                        <span onclick="withdrawRequestDataModal('<?php echo htmlspecialchars($row['wr_id']) ?>')" class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-amber-600 transition-all text-sm dark:bg-slate-900 dark:hover:bg-slate-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800">
                                                            <i class="fa-regular fa-file-lines"></i>
                                                            View
                                                        </span>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <span onclick="withdrawRequestDataModal('<?php echo htmlspecialchars($row['wr_id']) ?>')" class="py-1 px-2 inline-flex justify-center items-center gap-2 rounded-lg border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-amber-600 transition-all text-sm dark:bg-slate-900 dark:hover:bg-slate-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800">
                                                            <i class="fa-regular fa-pen"></i>
                                                            Edit
                                                        </span>
                                                    <?php
                                                    }

                                                    ?>
                                                </span>
                                            </button>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo '<tr><td colspan="6">No Today records found.</td></tr>';
                            }

                            ?>
                        </tbody>
                    </table>
                    <!-- End Table -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Card -->
</div>
<!-- End Table Section -->



<dialog id="withdrawRequestData" class="modal flex justify-center items-start py-20 overflow-scroll z-40">
    <div id="withdrawRequestDataContent" class="bg-white p-5 sm:p-10 rounded-2xl shadow-2xl max-w-7xl w-full z-[99] relative">

    </div>

    <form method="dialog" onclick="history.back();" class="modal-backdrop absolute top-0 left-0 h-screen w-screen z-50">
        <button class="absolute top-0 left-0 h-screen w-screen z-[50]"></button>
    </form>
</dialog>


<script src="assets/js/withdraw.js"></script>

<script>
    function setFocusStatus() {
        if (document.visibilityState === 'visible') {
            localStorage.setItem('withdrawPageFocus', 'true');
        } else {
            localStorage.setItem('withdrawPageFocus', 'false');
        }
    }
    setFocusStatus();


    document.addEventListener('visibilitychange', function() {
        setFocusStatus();

        if (document.visibilityState === 'visible' && localStorage.getItem('withdrawPageFocus') === 'true') {
            // Clear existing notification if the user navigates back to the withdraw page
            if (existingNotification) {
                console.log('Clearing existing notification as withdraw page is in focus');
                localStorage.removeItem('activeNotification');
                existingNotification.close();
                existingNotification = null;
            }
        } else if (document.visibilityState === 'visible' && window.location.href.includes('http://localhost/?page=withdraw')) {
            // Clear all existing notifications if user is on the withdrawal page
            console.log('Clearing all existing notifications as user is on the withdrawal page');
            localStorage.removeItem('activeNotification');
            if (existingNotification) {
                existingNotification.close();
                existingNotification = null;
            }
        }
    });
</script>