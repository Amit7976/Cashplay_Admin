<?php
session_start();

include '../server/conn.php';

if (!isset($_COOKIE['6a5f450a43b7387dcb7d67e17d897498'])) {

    header("Location: /auth/login.php");
    exit();
}


?>
<?php
$start = isset($_POST['start']) ? (int)$_POST['start'] : 0;
$limit = isset($_POST['limit']) ? (int)$_POST['limit'] : 20;

$query = "SELECT * FROM app_rating ORDER BY `ar_date_time` DESC LIMIT ?, ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $start, $limit);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row2 = $result->fetch_assoc()) {
        $user_unique = $row2['ar_user_unique'];

        $date = new DateTime($row2['ar_date_time']);
        $formatted_date = $date->format('d M Y');

        $user_details_query = "SELECT avatar, user_name FROM user_details WHERE user_unique = ?";
        $user_stmt = $conn->prepare($user_details_query);
        $user_stmt->bind_param("s", $user_unique);
        $user_stmt->execute();
        $user_result = $user_stmt->get_result();

        if ($user_result->num_rows > 0) {
            $row = $user_result->fetch_assoc();

?>
            <tr id="ratings_<?php echo $user_unique ?>" class="bg-white hover:bg-gray-50 dark:bg-slate-900 dark:hover:bg-slate-800">
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
                    <div class="block p-6">
                        <div class="flex gap-x-1 mb-2">
                            <?php for ($i = 1; $i <= 5; $i++) : ?>
                                <i class="fa-solid fa-star text-lg <?php echo ($row2['ar_rating'] >= $i) ? 'text-amber-500' : 'text-gray-500' ?>"></i>
                            <?php endfor; ?>
                        </div>
                        <span class="block text-sm text-gray-500"><?php echo $row2['ar_review'] ?></span>
                    </div>
                </td>
                <td class="size-px whitespace-nowrap align-top">
                    <div class="block p-6">
                        <span class="text-sm text-gray-600 dark:text-gray-400"><?php echo $formatted_date ?></span>
                    </div>
                </td>
                <td class="size-px whitespace-nowrap align-top">
                    <div class="block p-6" id="visibility_show_<?php echo $user_unique ?>">
                        <?php if ($row2['ar_status'] == 1) : ?>
                            <span class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-teal-100 text-teal-800 rounded-full dark:bg-teal-500/10 dark:text-teal-500">
                                <i class="fa-solid fa-check"></i> Published
                            </span>
                        <?php else : ?>
                            <span class="py-1 px-2 inline-flex items-center gap-x-1 text-xs font-medium bg-red-100 text-red-800 rounded-full dark:bg-red-500/10 dark:text-red-500">
                                <i class="fa-solid fa-xmark"></i> Unpublish
                            </span>
                        <?php endif; ?>
                    </div>
                </td>
                <td class="size-px whitespace-nowrap align-top flex-shrink-0 px-5">
                    <div class="dropdown dropdown-end mt-3 w-full flex justify-center">
                        <div tabindex="0" role="button" class="btn m-1"><i class="fa-solid fa-ellipsis-vertical"></i></div>
                        <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                            <li onclick="visibilityControl('<?php echo $user_unique ?>')"><a id="visibility_button_<?php echo $user_unique ?>"><?php echo ($row2['ar_status'] == 1) ? 'Unpublish' : 'Publish' ?></a></li>
                            <li onclick="deleteRating('<?php echo $user_unique ?>')"><a>Delete</a></li>
                        </ul>
                    </div>
                </td>
            </tr>
<?php
        }
    }
} else {
    echo "";
}
?>