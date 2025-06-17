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
                                Deposit Payment
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
                                    <div class="flex items-center gap-x-2 flex-shrink-0">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200 flex-shrink-0 w-max">
                                            Player
                                        </span>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-5 text-start flex-shrink-0">
                                    <div class="flex items-center gap-x-2 flex-shrink-0">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200 flex-shrink-0 w-max">
                                            Deposit
                                        </span>
                                    </div>
                                </th>

                                <th scope="col" class="px-6 py-5 text-start flex-shrink-0">
                                    <div class="flex items-center gap-x-2 flex-shrink-0">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200 flex-shrink-0 w-max">
                                            Current
                                        </span>
                                    </div>
                                </th>

                                <th scope="col" class="px-6 py-5 text-start flex-shrink-0">
                                    <div class="flex items-center gap-x-2 flex-shrink-0">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200 flex-shrink-0 w-max">
                                            Requested Date
                                        </span>
                                    </div>
                                </th>

                                <th scope="col" class="px-6 py-5 text-start flex-shrink-0">
                                    <div class="flex items-center gap-x-2 flex-shrink-0">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200 flex-shrink-0 w-max">
                                            Process Date
                                        </span>
                                    </div>
                                </th>

                                <th scope="col" class="px-6 py-5 text-center">
                                    <div class="flex items-center gap-x-2 justify-center">
                                        <span class="text-xs font-semibold uppercase text-center tracking-wide text-gray-800 dark:text-gray-200 flex-shrink-0">
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
                                    const deposit = params.get('deposit');
                                    if (deposit) {
                                        fetchTransactionDetails(deposit);
                                    }
                                });
                            </script>
                            <?php

                            $last24Hours = date('Y-m-d H:i:s', strtotime('-24 hours'));

                            // SQL query to select records from the last 24 hours
                            $sql = "SELECT td.t_process, td.t_request, td.t_id, td.t_user_unique, td.t_amount, td.t_status, u.user_name, u.avatar, u.total_balance 
                                    FROM transaction_details td 
                                    JOIN user_details u ON td.t_user_unique = u.user_unique 
                                    WHERE td.t_request >= ? ORDER BY `t_request` DESC";

                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param('s', $last24Hours);
                            $stmt->execute();
                            $result = $stmt->get_result();




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
                                        <td class="size-px whitespace-nowrap px-5">
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



<dialog id="depositDetailsModal" class="modal flex justify-center items-start py-20 overflow-scroll z-40">
    <div class="bg-white py-10 px-5 lg:p-10 rounded-2xl shadow-2xl max-w-7xl w-full z-[99] relative">
        <div class="flex gap-2 items-center">
            <p class="transaction-id text-base text-gray-500 dark:text-gray-200">#1387343</p>
        </div>
        <div class="w-full my-5 grid grid-cols-1 gap-4 lg:grid-cols-3 lg:gap-8">
            <a target="_blank" href="?page=allPlayers&player=000000" id="user_details_link" class="h-auto py-5 lg:py-0 lg:px-10 items-center flex flex-col lg:flex-row gap-3 rounded-box outline-none">
                <div>
                    <img src="https://cashplay.in/assets/img/avatar/user.png" class="avatar-img w-20 h-20 lg:w-10 lg:h-10 rounded-full">
                </div>
                <div>
                    <h4 class="user-name ffont-semibold text-lg text-center lg:text-start">Cashplay</h4>
                    <p class="user-unique text-center lg:text-start"></p>
                </div>
            </a>
            <div class="flex h-auto flex-col-reverse w-full gap-2 card bg-gray-100 p-2 py-5 col-span-1">
                <div class="grid h-auto flex-grow place-items-center">
                    <h3 class="text-sm text-gray-500 font-medium">Status</h3>
                </div>
                <div class="flex h-auto gap-3 px-10 items-center justify-center">
                    <p class="status-text text-sm font-medium text-amber-500">In Process</p>
                </div>
            </div>
            <div class="flex h-auto flex-col-reverse w-full gap-2 card bg-gray-100 p-2 py-5 col-span-1">
                <div class="grid h-auto flex-grow place-items-center">
                    <h3 class="text-sm text-gray-400 font-medium">Withdraw Id</h3>
                </div>
                <div class="flex h-auto gap-3 px-10 items-center justify-center">
                    <p class="text-sm sm:text-base text-center font-medium withdraw_id">000000000</p>
                </div>
            </div>
            <div class="flex h-auto flex-col-reverse w-full gap-2 card bg-gray-100 p-2 py-5 col-span-1">
                <div class="grid h-auto flex-grow place-items-center">
                    <h3 class="text-sm text-gray-400 font-medium">Transaction Number</h3>
                </div>
                <div class="flex h-auto gap-3 px-10 items-center justify-center">
                    <p class="text-sm sm:text-base text-center font-medium transaction_id">00000000</p>
                </div>
            </div>
            <div class="flex h-auto flex-col-reverse w-full gap-2 card bg-gray-100 p-2 py-5 col-span-1">
                <div class="grid h-auto flex-grow place-items-center">
                    <h3 class="text-sm text-gray-400 font-medium">Request Date</h3>
                </div>
                <div class="flex h-auto gap-3 px-10 items-center justify-center">
                    <p class="text-sm sm:text-base text-center font-medium request-date">01 JAN 2000</p>
                </div>
            </div>
            <div class="flex h-auto flex-col-reverse w-full gap-2 card bg-gray-100 p-2 py-5 col-span-1">
                <div class="grid h-auto flex-grow place-items-center">
                    <h3 class="text-sm text-gray-400 font-medium">Process Date</h3>
                </div>
                <div class="flex h-auto gap-3 px-10 items-center justify-center">
                    <p class="text-sm sm:text-base text-center font-medium process-date">01 JAN 2000</p>
                </div>
            </div>
            <div class="flex h-auto flex-col w-full gap-5 card bg-gray-100 p-2 py-3 col-span-1 lg:col-span-3 overflow-scroll max-h-96">
                <div class="grid h-auto flex-grow place-items-start">
                    <h3 class="text-xs sm:text-base text-center text-gray-500 font-medium px-14">Gateway Response</h3>
                </div>
                <div class="flex h-auto gap-3 lg:px-10 pb-10 items-center justify-center">
                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="px-3 lg:px-10 py-2 text-start text-sm sm:text-base">Key</th>
                                <th class="px-3 lg:px-10 py-2 text-start text-sm sm:text-base">Value</th>
                            </tr>
                        </thead>
                        <tbody id="t_response_table_body">
                            <!-- Dynamic content will be injected here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div>
            <div class="grid h-full py-4 flex-grow w-full gap-5 grid-cols-2 lg:grid-cols-3 mt-5">
                <div class="flex h-full py-4 flex-grow bg-base-200 rounded-box items-center justify-center flex-col gap-1 col-span-1">
                    <h3 class="total-amount text-sm sm:text-xl font-medium">100 <span class="text-green-500">&#x20B9;</span></h3>
                    <p class="text-xs sm:text-sm text-gray-400 font-medium">Amount</p>
                </div>
                <div class="flex h-full py-4 flex-grow bg-base-200 rounded-box items-center justify-center flex-col gap-1 col-span-1">
                    <h3 class="total-balance text-sm sm:text-xl font-medium">95 <span class="text-green-500">&#x20B9;</span></h3>
                    <p class="text-xs sm:text-sm text-gray-400 font-medium">Total Balance</p>
                </div>
                <div class="flex h-full py-4 flex-grow bg-base-200 rounded-box items-center justify-center flex-col gap-1 col-span-1">
                    <h3 class="new_total-balance text-sm sm:text-xl font-medium">5 <span class="text-green-500">&#x20B9;</span></h3>
                    <p class="text-xs sm:text-sm text-gray-400 font-medium">New Total Balance</p>
                </div>
            </div>
            <div id="depositModalActionButtons" class="grid lg:flex lg:justify-end flex-grow w-full gap-5 grid-cols-2 lg:grid-cols-4 mt-5 relative">
            </div>
        </div>
        <form method="dialog" onclick="history.back();" class="modal-backdrop absolute flex justify-center items-center top-3 right-3 w-10 h-10 rounded-full bg-gray-200 text-gray-600 hover:rotate-180 duration-300">
            <button class="w-10 h-10"><i class="fa-solid fa-close text-base"></i></button>
        </form>
    </div>


    <form method="dialog" onclick="history.back();" class="modal-backdrop absolute top-0 left-0 h-screen w-screen z-50">
        <button id="depositDetailsModalButton" class="absolute top-0 left-0 h-screen w-screen z-[50]"></button>
    </form>
</dialog>

<script src="assets/js/deposit.js"></script>