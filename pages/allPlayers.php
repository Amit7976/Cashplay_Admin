<!-- Table Section -->
<div class="max-w-[85rem] mx-auto">
    <!-- Card -->
    <div class="flex flex-col">
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-slate-900 dark:border-gray-700">
                    <!-- Header -->
                    <div class="px-6 py-4 pb-6 grid gap-3 grid-cols- md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-gray-700">
                        <div class="border-b py-3">
                            <h2 class="text-2xl lg:text-3xl font-semibold text-gray-800 dark:text-gray-200">
                                All Players
                            </h2>
                        </div>

                        <div class="flex justify-center gap-x-6 pt-3">
                            <!-- Search -->
                            <div class="flex gap-x-2">
                                <label for="hs-as-table-product-review-search" class="sr-only">Search</label>
                                <div class="relative flex items-center">
                                    <input type="text" id="searchInput" name="hs-as-table-product-review-search" class="py-2 px-3 pr-28 block border-2 w-full min-w-96 font-medium border-gray-200 rounded-lg outline-none text-sm disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Search...">
                                    <button id="searchButton" onclick="searchDetails()" class="px-3 absolute right-0 h-full inline-flex items-center gap-x-2 text-sm font-semibold rounded-r-lg outline-none bg-gray-200 shadow-inner text-gray-500 hover:bg-gray-300 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="#">
                                        <i class="fa-solid fa-magnifying-glass flex-shrink-0"></i>
                                        Search
                                    </button>
                                </div>
                            </div>
                            <!-- <div class="inline-flex gap-x-2">
                                <button class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-amber-600 text-white hover:bg-amber-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="#">
                                    <i class="fa-solid fa-plus flex-shrink-0"></i>
                                    Add user
                                </button>
                            </div> -->
                        </div>
                    </div>
                    <!-- End Header -->

                    <!-- Table -->
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-slate-800">
                            <tr>
                                <th scope="col" class="pl-20 py-3 text-center flex-shrink-0">
                                    <div class="flex items-center justify-start flex-shrink-0">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200 flex-shrink-0 text-center w-max">
                                            User
                                        </span>
                                    </div>
                                </th>

                                <th scope="col" class="px-3 py-3 text-center flex-shrink-0">
                                    <div class="flex items-center justify-center flex-shrink-0">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200 flex-shrink-0 text-center w-max">
                                            Total B.
                                        </span>
                                    </div>
                                </th>
                                <th scope="col" class="px-3 py-3 text-center flex-shrink-0">
                                    <div class="flex items-center justify-center flex-shrink-0">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200 flex-shrink-0 text-center w-max">
                                            Withdraw B.
                                        </span>
                                    </div>
                                </th>
                                <th scope="col" class="px-3 py-3 text-center flex-shrink-0">
                                    <div class="flex items-center justify-center flex-shrink-0">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200 flex-shrink-0 text-center w-max">
                                            Game UID
                                        </span>
                                    </div>
                                </th>
                                <th scope="col" class="px-3 py-3 text-center flex-shrink-0">
                                    <div class="flex items-center justify-center flex-shrink-0">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200 flex-shrink-0 text-center w-max">
                                            User Unique
                                        </span>
                                    </div>
                                </th>

                                <th scope="col" class="px-3 py-3 text-center flex-shrink-0">
                                    <div class="flex items-center justify-center flex-shrink-0">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200 flex-shrink-0 text-center w-max">
                                            Status
                                        </span>
                                    </div>
                                </th>
                                <th scope="col" class="px-8 py-3 text-center flex-shrink-0">
                                    <div class="flex items-center justify-center flex-shrink-0">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200 flex-shrink-0 text-center w-max">
                                            Action
                                        </span>
                                    </div>
                                </th>

                            </tr>
                        </thead>
                        <tbody id="userDetailsTable" class="divide-y divide-gray-200 dark:divide-gray-700">

                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const hash = window.location.hash;
                                    const params = new URLSearchParams(hash.slice(1));
                                    const playerId = params.get('playerId');
                                    if (playerId) {
                                        runningTableDetailsShowModal(playerId);
                                    }
                                });
                            </script>

                            <?php

                            if (isset($_GET['player'])) {
                                $player = $_GET['player'];

                                $user_details = $conn->query("SELECT `id`, `avatar`, `game_uid`, `user_name`, `phone_number`, `user_unique`, `country`, `total_balance`, `total_withdraw_balance`, `log_out_globally`, `login_access` FROM user_details WHERE `user_unique` = '$player'");
                            } else {
                                $start = isset($_POST['start']) ? $_POST['start'] : 0;
                                $limit = isset($_POST['limit']) ? $_POST['limit'] : 20;

                                $user_details = $conn->query("SELECT `id`, `avatar`, `game_uid`, `user_name`, `phone_number`, `user_unique`, `country`, `total_balance`, `total_withdraw_balance`, `log_out_globally`, `login_access` FROM user_details ORDER BY `date_time` DESC LIMIT $start, $limit");
                            }


                            // Check if any rows were returned
                            if (mysqli_num_rows($user_details) > 0) {
                                // Loop through each row in the result set
                                while ($row = mysqli_fetch_assoc($user_details)) {

                                    if (isset($_GET['player'])) {
                            ?>
                                        <script>
                                            setTimeout(() => {
                                                runningTableDetailsShowModal('<?php echo $row['id'] ?>')
                                            }, 1000);
                                        </script>
                                    <?php } ?>

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
                                echo "No user details found";
                            }
                            ?>


                        </tbody>




                    </table>
                    <?php
                    if (!isset($_GET['player'])) {
                    ?>
                        <button id="loadMoreButton" class="btn mx-auto w-full text-center">Load More</button>
                    <?php
                    }
                    ?>

                    <!-- End Table -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Card -->
</div>
<!-- End Table Section -->


<dialog id="userDetailsMainModal" class="modal flex justify-center items-start py-20 overflow-scroll z-40">
    <div id="userDetailsContent" class="bg-white py-10 px-5 lg:p-10 rounded-2xl shadow-2xl max-w-7xl w-full z-[99] relative">

    </div>

    <form method="dialog" onclick="history.back();" id="closeDetailsModalButton2" class="modal-backdrop absolute top-0 left-0 h-screen w-screen z-50">
        <button class="absolute top-0 left-0 h-screen w-screen z-[50]"></button>
    </form>
</dialog>


<dialog id="allBattleDetailsModal" class="modal flex justify-center items-start py-20 overflow-scroll z-40">
    <div id="allBattleDetailsModalContent" class="bg-white p-10 pb-4 rounded-2xl shadow-2xl max-w-7xl w-full relative z-[99] overflow-x-hidden">

    </div>

    <form method="dialog" onclick="history.back();" class="modal-backdrop absolute top-0 left-0 h-screen w-screen z-50">
        <button id="allBattleDetailsModalButton" class="absolute top-0 left-0 h-screen w-screen z-[50]"></button>
    </form>
</dialog>


<script src="assets/js/battles.js"></script>
<script src="assets/js/allPlayers.js"></script>