<!-- Table Section -->
<div class="max-w-[85rem] mx-auto">
    <!-- Card -->
    <div class="flex flex-col">
        <div class="-m-1.5 overflow-visible">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-slate-900 dark:border-gray-700">
                    <!-- Header -->
                    <div class="px-6 py-4 pb-6 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-gray-700">
                        <div>
                            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">
                                Games
                            </h2>
                        </div>
                    </div>
                    <!-- End Header -->

                    <!-- Table -->
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-slate-800">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-start">
                                    <div class="flex items-center gap-x-2">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            Games
                                        </span>
                                    </div>
                                </th>

                                <th scope="col" class="px-6 py-3 text-start">
                                    <div class="flex items-center justify-center gap-x-2">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            Name
                                        </span>
                                    </div>
                                </th>

                                <th scope="col" class="px-6 py-3 text-start">
                                    <div class="flex items-center gap-x-2">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            Category
                                        </span>
                                    </div>
                                </th>

                                <th scope="col" class="px-6 py-3 text-start">
                                    <div class="flex items-center gap-x-2">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            Min
                                        </span>
                                    </div>
                                </th>

                                <th scope="col" class="px-6 py-3 text-start">
                                    <div class="flex items-center gap-x-2">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            Max
                                        </span>
                                    </div>
                                </th>

                                <th scope="col" class="px-6 py-3 text-start">
                                    <div class="flex items-center gap-x-2">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200 flex-shrink-0">
                                            Battle Amount
                                        </span>
                                    </div>
                                </th>

                                <th scope="col" class="px-6 py-3 text-start">
                                    <div class="flex items-center gap-x-2">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            Status
                                        </span>
                                    </div>
                                </th>

                                <th scope="col" class="px-6 py-3 text-start flex-shrink-0">
                                    <div class="flex items-center gap-x-2">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200 flex-shrink-0">
                                            Actions
                                        </span>
                                    </div>
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            <?php


                            // Fetch unique game categories
                            $category_sql = "SELECT DISTINCT `game_category` FROM `games`";
                            $category_result = $conn->query($category_sql);

                            $categories = [];
                            if ($category_result->num_rows > 0) {
                                while ($category_row = $category_result->fetch_assoc()) {
                                    $categories[] = $category_row['game_category'];
                                }
                            }

                            // Fetch all games
                            $sql = "SELECT * FROM `games` WHERE 1 ORDER BY `game_id` ASC";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                            ?>
                                    <tr class="bg-white dark:bg-slate-900">
                                        <td class="whitespace-nowrap cursor-pointer align-top p-6 flex-shrink-0">
                                            <div class="flex items-center gap-x-4 w-20">
                                                <img class="flex-shrink-0 aspect-square w-20 rounded-lg editable-image" src="assets/img/games/<?php echo htmlspecialchars($row['game_image']); ?>" alt="Image Description" data-id="<?php echo htmlspecialchars($row['game_id']); ?>">
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap cursor-pointer align-top p-6 flex items-center justify-center h-full w-32">
                                            <div class="flex items-center mt-2 overflow-hidden justify-center">
                                                <p class="text-sm font-medium text-gray-500 editable-text text-center whitespace-break-spaces" data-id="<?php echo htmlspecialchars($row['game_id']); ?>" data-field="game_name"><?php echo htmlspecialchars($row['game_name']); ?></p>
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap cursor-pointer align-top p-6">
                                            <div class="flex items-center gap-x-3 mt-2">
                                                <select name="gameCategory" id="gameCategory_<?php echo htmlspecialchars($row['game_id']); ?>" class="editable-select cursor-pointer bg-white outline-none" data-id="<?php echo htmlspecialchars($row['game_id']); ?>">
                                                    <?php foreach ($categories as $category) { ?>
                                                        <option value="<?php echo htmlspecialchars($category); ?>" <?php echo $row['game_category'] == $category ? 'selected' : ''; ?>>
                                                            <?php echo htmlspecialchars($category); ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap cursor-pointer align-top p-6">
                                            <div class="flex items-center gap-x-3 mt-2">
                                                <p class="text-sm font-medium text-gray-500 editable-text" data-id="<?php echo htmlspecialchars($row['game_id']); ?>" data-field="game_min_price"><?php echo htmlspecialchars($row['game_min_price']); ?></p>
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap cursor-pointer align-top p-6">
                                            <div class="flex items-center gap-x-3 mt-2">
                                                <p class="text-sm font-medium text-gray-500 editable-text" data-id="<?php echo htmlspecialchars($row['game_id']); ?>" data-field="game_max_price"><?php echo htmlspecialchars($row['game_max_price']); ?></p>
                                            </div>
                                        </td>
                                        <td class="align-top p-6 max-w-72 cursor-pointer flex-shrink-0">
                                            <div class="flex items-center gap-x-3 mt-2 w-56">
                                                <span class="text-sm text-gray-600 dark:text-gray-400 editable-text" data-id="<?php echo htmlspecialchars($row['game_id']); ?>" data-field="battlesAmount"><?php echo htmlspecialchars($row['battlesAmount']); ?></span>
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap cursor-pointer align-top p-6">
                                            <div class="flex items-center gap-x-3 mt-2">
                                                <select name="gameStatus" id="gameStatus_<?php echo htmlspecialchars($row['game_id']); ?>" class="editable-select-status bg-white outline-none" data-id="<?php echo htmlspecialchars($row['game_id']); ?>">
                                                    <option value="Active" <?php echo $row['game_status'] == 'Active' ? 'selected' : ''; ?>>Active</option>
                                                    <option value="Soon" <?php echo $row['game_status'] == 'Soon' ? 'selected' : ''; ?>>Soon</option>
                                                    <option value="Upcoming" <?php echo $row['game_status'] == 'Upcoming' ? 'selected' : ''; ?>>Upcoming</option>
                                                </select>
                                            </div>
                                        </td>
                                        <!-- <td class="whitespace-nowrap cursor-pointer align-top">
                                            <div class="dropdown dropdown-end mt-3 w-full flex justify-center">
                                                <div tabindex="0" role="button" class="btn m-1"><i class="fa-solid fa-ellipsis-vertical"></i></div>
                                                <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                                    <li><a target="_blank" href="https://cashplay.in/?p=battles&name=<?php echo $row['game_name']; ?>&battleStart=<?php echo $row['game_min_price']; ?>&battleEnd=<?php echo $row['game_max_price']; ?>">View</a></li>
                                                    <li><a href="delete.php?id=<?php echo $row['game_id']; ?>">Delete</a></li>
                                                </ul>
                                            </div>
                                        </td> -->
                                        <td class="whitespace-nowrap">
                                            <div class="px-6">
                                                <button class="btn" onclick="location.assign('https://cashplay.in/?p=battles&name=<?php echo $row['game_name']; ?>&battleStart=<?php echo $row['game_min_price']; ?>&battleEnd=<?php echo $row['game_max_price']; ?>')">View</button>
                                            </div>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo "No records found.";
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
<script src="assets/js/games.js"></script>