<?php session_start();

include 'server/conn.php';

if (!isset($_COOKIE['6a5f450a43b7387dcb7d67e17d897498'])) {

    header("Location: /auth/login.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicon_io/favicon-16x16.png">
    <link rel="manifest" href="assets/img/favicon_io/site.webmanifest">
    <title>CashPlay Admin</title>

    <!-- // TAILWIND CSS -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.7.3/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>


    <!-- // FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- // FONT AWESOME -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v6.0.0-beta3/css/all.css">

    <!-- // JQUERY -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <style>
        *::-webkit-scrollbar {
            display: none;
        }

        * {
            font-family: 'Poppins', sans-serif;
            word-break: break-word;
            scroll-behavior: smooth;
            /* pointer-events:none; */
            /* user-select: auto; */
        }

        .btn-effect {
            animation: button-pop 0s ease-out;
            transform: scale(var(0.95, 0.97));
        }
    </style>
</head>

<body class="bg-gray-100 h-screen overflow-auto">

    <div id="topBarToggle" class="w-full bg-white h-20 sticky top-0 shadow-xl z-10 flex lg:hidden justify-between duration-500">
        <div class="flex flex-shrink-0 px-4 w-40 items-center">
            <button onclick="toggleSideBar()" class="bg-white border-0 btn rounded-full w-12 h-10 px-5 drop-shadow-none ring-0 shadow-none flex-shrink-0">
                <i class="fa-regular fa-bars text-xl shadow-xl"></i>
            </button>
            <div class="flex flex-col flex-shrink-0 w-28 items-center">
                <a href="/" class="flex mr-2 pl-0 p-2 flex-col gap-1">
                    <img src="assets/img/logo4.png" class="max-h-12 dark:hidden block" alt="CashPlay Logo">
                    <span class="self-center text-xs font-semibold sm:text-md whitespace-nowrap dark:text-gray-300">Admin
                        Panel</span>
                </a>
                <button class="hidden rounded-lg focus:outline-none focus:shadow-outline">
                    <svg fill="currentColor" viewBox="0 0 20 20" class="w-6 h-6">
                        <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </div>
        <button class="inline-flex items-center justify-between w-32 py-3 mr-5 text-lg font-medium text-center transition duration-500 ease-in-out transform rounded-xl hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
            <span class="flex-shrink-0 group w-full flex items-center justify-end">
                <i class="fa-regular fa-user text-sm rounded-full group-hover:text-amber-500 duration-300"></i>
                <div class="ml-2 text-left">
                    <p class="text-xs font-semibold text-gray-500 group-hover:text-amber-500 duration-300">
                        <?php echo $_COOKIE["admin_name"] ?>
                    </p>
                </div>
            </span>
        </button>
    </div>


    <div class="flex h-screen overflow-hidden bg-gray-100 lg:mt-0">
        <?php include 'components/sidebar.php' ?>

        <div class="flex flex-col flex-1 w-0 overflow-hidden">
            <main class="relative flex-1 overflow-y-auto focus:outline-none">
                <?php
                if (isset($_GET['page'])) {
                    if ($_GET['page'] !== 'withdraw') {
                ?>
                        <div onclick="location.assign('?page=withdraw')" id="notification" class="hidden cursor-pointer sticky top-0 backdrop-blur-sm w-full max-w-5xl mx-auto z-[99] bg-green-500 text-base sm:text-lg font-semibold text-white px-4 py-2.5 rounded-full text-center tracking-wide shadow-2xl mt-5">Notification Text</div>
                    <?php
                    }
                } else {
                    ?>
                    <div onclick="location.assign('?page=withdraw')" id="notification" class="hidden cursor-pointer sticky top-0 backdrop-blur-sm w-full max-w-5xl mx-auto z-[99] bg-green-500 text-base sm:text-lg font-semibold text-white px-4 py-2.5 rounded-full text-center tracking-wide shadow-2xl mt-5">Notification Text</div>
                <?php
                }
                ?>
                <div class="py-8">
                    <div class="px-4 mx-auto">

                        <?php

                        if (isset($_GET['page'])) {
                            if ($_GET['page'] === 'dashboard') {
                                include 'pages/dashboard.php';
                            } else if ($_GET['page'] === 'products') {
                                include 'pages/products.php';
                            } else if ($_GET['page'] === 'runningTable') {
                                include 'pages/runningTable.php';
                            } else if ($_GET['page'] === 'transactions') {
                                include 'pages/transactions.php';
                            } else if ($_GET['page'] === 'allBattle') {
                                include 'pages/allBattle.php';
                            } else if ($_GET['page'] === 'ratings') {
                                include 'pages/ratings.php';
                            } else if ($_GET['page'] === 'feedback') {
                                include 'pages/feedback.php';
                            } else if ($_GET['page'] === 'allPlayers') {
                                include 'pages/allPlayers.php';
                            } else if ($_GET['page'] === 'games') {
                                include 'pages/games.php';
                            } else if ($_GET['page'] === 'support') {
                                include 'pages/support.php';
                            } else if ($_GET['page'] === 'invoices') {
                                include 'pages/invoices.php';
                            } else if ($_GET['page'] === 'withdraw') {
                                include 'pages/withdraw.php';
                            } else if ($_GET['page'] === 'deposit') {
                                include 'pages/deposit.php';
                            } else if ($_GET['page'] === 'coupon') {
                                include 'pages/coupon.php';
                            } else if ($_GET['page'] === 'register_admin') {
                                include 'pages/register_admin.php';
                            }
                        } else {
                            include 'pages/dashboard.php';
                        }

                        ?>

                    </div>
                </div>
            </main>
        </div>
    </div>



    <script src="assets/js/sidebar.js"></script>
    <script src="assets/js/notification.js"></script>


    <script>
        window.addEventListener('load', () => {
            registerSW();
        });

        // Register the Service Worker
        async function registerSW() {
            if ('serviceWorker' in navigator) {
                try {
                    await navigator
                        .serviceWorker
                        .register('service-worker.js');
                } catch (e) {
                    console.log('SW registration failed');
                }
            }
        }
    </script>
</body>

</html>