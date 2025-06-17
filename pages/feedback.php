<!-- Table Section -->
<div class="max-w-[85rem] mx-auto">
    <!-- Card -->
    <div class="flex flex-col">
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-slate-900 dark:border-gray-700">

                    <!-- Table -->
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-slate-800">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-start">
                                    <div class="flex items-center gap-x-2">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            Reviewer
                                        </span>
                                    </div>
                                </th>

                                <th scope="col" class="px-6 py-3 text-start">
                                    <div class="flex items-center gap-x-2">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            Review
                                        </span>
                                    </div>
                                </th>

                                <th scope="col" class="px-6 py-3 text-start">
                                    <div class="flex items-center gap-x-2">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            Date
                                        </span>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3 text-start">
                                    <div class="flex items-center gap-x-2 w-20 justify-center">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200 flex-shrink-0">
                                            Likes
                                        </span>
                                    </div>
                                </th>

                                <th scope="col" class="py-3 text-start w-fit flex-shrink-0">
                                    <div class="flex items-center gap-x-2 justify-center">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            Actions
                                        </span>
                                    </div>
                                </th>
                            </tr>
                        </thead>

                        <tbody id="userFeedbacksTable" class="divide-y divide-gray-200 dark:divide-gray-700">


                            <?php
                            $start = isset($_POST['start']) ? (int)$_POST['start'] : 0;
                            $limit = isset($_POST['limit']) ? (int)$_POST['limit'] : 20;

                            $query = "SELECT * FROM feedback ORDER BY `f_date_time` DESC LIMIT ?, ?";
                            $stmt = $conn->prepare($query);
                            $stmt->bind_param("ii", $start, $limit);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                while ($row2 = $result->fetch_assoc()) {
                                    $user_unique = $row2['f_user_unique'];
                                    $f_id = $row2['f_id'];

                                    $date = new DateTime($row2['f_date_time']);
                                    $formatted_date = $date->format('d M Y');

                                    $user_details_query = "SELECT avatar, user_name FROM user_details WHERE user_unique = ?";
                                    $user_stmt = $conn->prepare($user_details_query);
                                    $user_stmt->bind_param("s", $user_unique);
                                    $user_stmt->execute();
                                    $user_result = $user_stmt->get_result();

                                    if ($user_result->num_rows > 0) {
                                        $row = $user_result->fetch_assoc();

                            ?>
                                        <tr id="feedback_<?php echo $f_id ?>" class="bg-white hover:bg-gray-50 dark:bg-slate-900 dark:hover:bg-slate-800">
                                            <td class="size-px whitespace-nowrap align-top">
                                                <a target="_blank" href="?page=allPlayers&player=<?php echo $user_unique ?>" class="block p-6 overflow-hidden" href="#">
                                                    <div class="flex items-center gap-x-3 w-max truncate">
                                                        <img class="inline-block size-[38px] rounded-full" src="https://cashplay.in/assets/img/avatar/<?php echo $row['avatar'] ?>" alt="<?php echo $row['user_name'] ?>'s Avatar">
                                                        <div class="grow">
                                                            <span class="block text-sm font-semibold text-gray-800 dark:text-gray-200"><?php echo $row['user_name'] ?></span>
                                                            <span class="block text-sm text-gray-500"><?php echo $user_unique ?></span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </td>
                                            <td class="h-px w-72 min-w-72 align-top">
                                                <a class="block p-6" href="#">
                                                    <span class="block text-sm text-gray-500"><?php echo $row2['f_feedback'] ?></span>
                                                </a>
                                            </td>
                                            <td class="size-px whitespace-nowrap align-top">
                                                <a class="block p-6" href="#">
                                                    <span class="text-sm text-gray-600 dark:text-gray-400"><?php echo $formatted_date ?></span>
                                                </a>
                                            </td>

                                            <td class="size-px whitespace-nowrap align-top">
                                                <a class="block p-6 w-full text-center" href="#">
                                                    <span class="text-sm text-gray-600 dark:text-gray-400"><?php echo $row2['f_vote'] ?></span>
                                                </a>
                                            </td>


                                            <!-- <td class="size-px whitespace-nowrap align-top">
                                                <div class="dropdown dropdown-end mt-3 w-full flex justify-center">
                                                    <div tabindex="0" role="button" class="btn m-1"><i class="fa-solid fa-ellipsis-vertical"></i></div>
                                                    <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                                        <li onclick="deleteRating('<?php echo $f_id ?>')"><a>Delete</a></li>
                                                    </ul>
                                                </div>
                                            </td> -->
                                            <td class="whitespace-nowrap">
                                                <div class="px-6">
                                                    <button class="btn" onclick="deleteRating('<?php echo $f_id ?>')">Delete</button>
                                                </div>
                                            </td>
                                        </tr>
                            <?php
                                    }
                                }
                            } else {
                                echo "No user details found";
                            }
                            ?>

                        </tbody>
                    </table>
                    <!-- End Table -->
                    <button id="loadMoreButton" class="btn w-full text-center">Load More</button>

                </div>
            </div>
        </div>
    </div>
    <!-- End Card -->
</div>
<!-- End Table Section -->
<script src="assets/js/feedback.js"></script>