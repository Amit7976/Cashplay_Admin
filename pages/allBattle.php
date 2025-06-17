<section class="scale-x-95">
    <div class="max-w-[85rem] mx-auto relative">
        <div class="flex flex-col">
            <div class="">
                <div class="min-w-full inline-block align-middle">
                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-slate-900 dark:border-gray-700">
                        <!-- Header -->
                        <div class="px-6 py-4 pb-6 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-gray-700">
                            <div class="w-1/2">
                                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 flex-shrink-0">
                                    All Battle
                                </h2>
                            </div>
                            <!-- Search -->
                            <form id="filter-form" class="my-4 w-full">
                                <input type="hidden" name="filterRecords" value="true">
                                <div class="flex flex-wrap justify-end items-center gap-4 px-10">
                                    <input type="text" id="search_user" name="search_user" placeholder="Search here...." class="px-3 py-2 rounded-xl outline-none input border-2 border-gray-300">

                                    <select id="status" name="status" class="px-3 py-2 border-2 rounded-xl outline-none select w-40 border-gray-200">
                                        <?php
                                        if (isset($_GET['status'])) {
                                            $status = $_GET['status'];
                                        ?>
                                            <option value="<?php echo $status ?>"><?php echo $status ?></option>
                                        <?php
                                        } else {
                                        ?>
                                            <option value="">All</option>
                                            <option value="Complete">Complete</option>
                                            <option value="Leave">Leave</option>
                                            <option value="Active">Active</option>
                                            <option value="Running">Running</option>
                                        <?php } ?>
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
                        </div>
                        <!-- End Header -->

                        <!-- Table -->
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-slate-800">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-start whitespace-nowrap">
                                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            Id
                                        </p>
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-start whitespace-nowrap">
                                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            Room Code
                                        </p>
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-start whitespace-nowrap">
                                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            Player 1
                                        </p>
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-start whitespace-nowrap">
                                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            Player 2
                                        </p>
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-start whitespace-nowrap">
                                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            Amount
                                        </p>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-start whitespace-nowrap">
                                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            Game Type
                                        </p>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-start whitespace-nowrap">
                                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            Status
                                        </p>
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-start whitespace-nowrap">
                                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            Date
                                        </p>
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-start whitespace-nowrap">
                                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            Action
                                        </p>
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y pb-20 divide-gray-200 dark:divide-gray-700">
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const hash = window.location.hash;
                                        const params = new URLSearchParams(hash.slice(1));
                                        const battle = params.get('battle');
                                        if (battle) {
                                            allBattleDetails(battle);
                                        }
                                    });
                                </script>

                                <?php
                                if (isset($_GET['status'])) {
                                    $status = $_GET['status'];

                                    $query = "SELECT battles.b_id, battles.b_room_code, battles.b_created_at, battles.b_status, battles.b_game, battles.b_price, battles.b_player2_id, battles.b_creator_id, battles.b_room_code, user1.user_name as creator_name, user1.avatar as creator_avatar, 
                                            user2.user_name as player2_name, user2.avatar as player2_avatar 
                                            FROM battles
                                            LEFT JOIN user_details as user1 ON battles.b_creator_id = user1.user_unique
                                            LEFT JOIN user_details as user2 ON battles.b_player2_id = user2.user_unique
                                    WHERE b_status = '$status' AND DATE(battles.b_created_at) = CURDATE() ORDER BY b_id DESC";
                                    // -- WHERE b_status = '$status' ORDER BY b_id DESC";

                                } else {
                                    $query = "SELECT battles.b_id, battles.b_room_code, battles.b_created_at, battles.b_status, battles.b_game, battles.b_price, battles.b_player2_id, battles.b_creator_id, battles.b_room_code, user1.user_name as creator_name, user1.avatar as creator_avatar, 
                                            user2.user_name as player2_name, user2.avatar as player2_avatar 
                                            FROM battles
                                            LEFT JOIN user_details as user1 ON battles.b_creator_id = user1.user_unique
                                            LEFT JOIN user_details as user2 ON battles.b_player2_id = user2.user_unique
                                    WHERE DATE(battles.b_created_at) = CURDATE() ORDER BY b_id DESC";
                                    // WHERE 1 ORDER BY b_id DESC";
                                }


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
                                ?>
                            </tbody>
                        </table>
                        <!-- End Table -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<dialog id="allBattleDetailsModal" class="modal flex justify-center items-start py-20 overflow-scroll z-40">
    <div id="allBattleDetailsModalContent" class="bg-white p-10 pb-4 rounded-2xl shadow-2xl max-w-7xl w-full relative z-[99] overflow-x-hidden">

    </div>

    <form method="dialog" onclick="history.back();" class="modal-backdrop absolute top-0 left-0 h-screen w-screen z-50">
        <button id="allBattleDetailsModalButton" class="absolute top-0 left-0 h-screen w-screen z-[50]"></button>
    </form>
</dialog>


<script src="assets/js/battles.js"></script>