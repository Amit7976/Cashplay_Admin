<!-- Table Section -->
<div class="max-w-[85rem] mx-auto">
    <!-- Card -->
    <div class="flex flex-col">
        <div class="-m-1.5 overflow-visible">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-slate-900 dark:border-gray-700">
                    <!-- Header -->
                    <div class="px-6 py-6 pb-6 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-gray-700">
                        <div>
                            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">
                                Customer Support
                            </h2>
                        </div>
                    </div>
                    <!-- End Header -->

                    <!-- Table -->
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-slate-800">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-start flex-shrink-0 whitespace-nowrap">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200 flex-shrink-0">
                                        Name
                                    </span>
                                </th>
                                <th scope="col" class="px-6 py-3 text-start flex-shrink-0 whitespace-nowrap">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200 flex-shrink-0">
                                        Icon
                                    </span>
                                </th>
                                <th scope="col" class="px-6 py-3 text-start flex-shrink-0 whitespace-nowrap w-96">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200 flex-shrink-0">
                                        Description
                                    </span>
                                </th>
                                <th scope="col" class="px-6 py-3 text-start flex-shrink-0 whitespace-nowrap">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200 flex-shrink-0">
                                        Link
                                    </span>
                                </th>
                                <th scope="col" class="px-6 py-3 text-start flex-shrink-0 whitespace-nowrap">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200 flex-shrink-0">
                                        Media
                                    </span>
                                </th>
                                <th scope="col" class="px-6 py-3 text-start flex-shrink-0 whitespace-nowrap">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200 flex-shrink-0">
                                        Status
                                    </span>
                                </th>

                                <th scope="col" class="px-6 py-3 text-start flex-shrink-0 whitespace-nowrap">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200 flex-shrink-0 flex-shrink-0">
                                        Actions
                                    </span>
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            <?php
                            $sql = "SELECT * FROM `contact_us` WHERE 1 ORDER BY `CU_id` ASC";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                            ?>
                                    <tr id="support_<?php echo $row['CU_id']; ?>" class="bg-white hover:bg-gray-50 dark:bg-slate-900 dark:hover:bg-slate-800">
                                        <td class="whitespace-nowrap align-top p-6">
                                            <div class="flex items-center gap-x-3 mt-2">
                                                <span class="text-base font-medium text-gray-600 dark:text-gray-400 flex-shrink-0"><?php echo htmlspecialchars($row['CU_name']); ?></span>
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap align-top p-6">
                                            <div class="flex items-center gap-x-3 mt-2">
                                                <span class="text-3xl text-gray-600 dark:text-gray-400 flex-shrink-0"><?php echo $row['CU_icon']; ?></span>
                                            </div>
                                        </td>
                                        <td class="whitespace-wrap align-top p-6">
                                            <div class="mt-2 w-52">
                                                <p class="text-sm text-gray-600 dark:text-gray-400 flex-shrink-0"><?php echo htmlspecialchars($row['CU_description']); ?></p>
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap align-top p-6 flex items-center h-full">
                                            <div class="flex items-center gap-x-3 mt-2">
                                                <p class="text-sm font-medium text-gray-500 flex-shrink-0"><?php echo htmlspecialchars($row['CU_link']); ?></p>
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap align-top p-6">
                                            <div class="flex items-center gap-x-3 mt-2">
                                                <p class="text-sm font-medium text-gray-500 flex-shrink-0"><?php echo htmlspecialchars($row['CU_media']); ?></p>
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap align-top p-6">
                                            <div class="flex items-center gap-x-3 mt-2">
                                                <span class="block text-sm font-semibold flex-shrink-0 <?php echo $row['CU_status'] == 1 ? 'text-green-500' : 'text-red-500'; ?>">
                                                    <?php echo $row['CU_status'] == 1 ? 'Active' : 'Inactive'; ?>
                                                </span>
                                            </div>
                                        </td>
                                        <!-- <td class="whitespace-nowrap align-top">
                                            <div class="dropdown dropdown-end mt-3 w-full flex justify-center">
                                                <div tabindex="0" role="button" class="btn m-1"><i class="fa-solid fa-ellipsis-vertical"></i></div>
                                                <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                                    <li onclick="customerSupportEditShowModal('<?php echo $row['CU_id'] ?>')"><a>Edit</a></li>
                                                    <li onclick="deleteRating('<?php echo $row['CU_id'] ?>')"><a>Delete</a></li>
                                                </ul>
                                            </div>
                                        </td> -->
                                        <td class="whitespace-nowrap">
                                            <div class="px-6">
                                                <button class="btn" onclick="customerSupportEditShowModal('<?php echo $row['CU_id'] ?>')">Edit</button>
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

    <dialog id="customerSupportEdit" class="modal flex justify-center overflow-scroll items-start z-[9999] py-20">
        <div id="supportDetailsContent" class="bg-white p-10 pb-4 lg:rounded-2xl shadow-2xl max-w-2xl w-full relative z-[9999] flex flex-col gap-4">

        </div>

        <form method="dialog" onclick="history.back();" class="modal-backdrop absolute top-0 left-0 h-screen w-screen z-50">
            <button class="absolute top-0 left-0 h-screen w-screen z-[50]"></button>
        </form>
    </dialog>

</div>
<!-- End Table Section -->

<script src="assets/js/support.js"></script>