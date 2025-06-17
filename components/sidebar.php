<div id="sideBarToggle" class="flex flex-shrink-0 backdrop-blur-[1.5px] fixed lg:relative h-screen z-20 top-0 w-screen lg:w-fit duration-500 -left-full lg:left-0">
    <div class="flex flex-col w-58 shadow-2xl drop-shadow-2xl">
        <div class="flex flex-col flex-grow pt-5 overflow-y-auto bg-white w-full">
            <div class="flex flex-col flex-shrink-0 px-4 w-full items-center">
                <a href="/" class="flex ml-2 p-2 flex-col gap-1 w-2/3">
                    <img src="assets/img/logo4.png" class="max-h-12 mr-3 dark:hidden block" alt="CashPlay Logo">
                    <span class="self-center text-sm font-semibold sm:text-md whitespace-nowrap dark:text-gray-300">Admin
                        Panel</span>
                </a>
                <button class="hidden rounded-lg focus:outline-none focus:shadow-outline">
                    <svg fill="currentColor" viewBox="0 0 20 20" class="w-6 h-6">
                        <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <div class="flex flex-col flex-grow px-1 lg:px-4 mt-5">
                <nav class="flex-1 space-y-3 bg-white">
                    <p class="px-4 pt-4 text-xs font-semibold text-gray-400 uppercase">
                        Analytics
                    </p>
                    <ul class="flex flex-col gap-2">
                        <li>
                            <a href="?page=dashboard" class="inline-flex items-center w-full px-4 py-2 mt-1 text-sm text-gray-500 transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-gray-100 hover:scale-95 hover:text-amber-500" href="/">
                                <i class="fa-light opacity-50 fa-grid-2 w-8 text-lg flex-shrink-0 justify-center flex"></i>
                                <span class="text-[1rem] truncate w-full overflow-hidden ml-3 lg:ml-4">
                                    Dashboard
                                </span>
                            </a>

                        </li>
                        <li>
                            <a href="?page=allPlayers" class="inline-flex items-center w-full px-4 py-2 mt-1 text-sm text-gray-500 transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-gray-100 hover:scale-95 hover:text-amber-500">
                                <i class="fa-light opacity-50 fa-users w-8 text-lg flex-shrink-0 justify-center flex"></i>
                                <span class="text-[1rem] truncate w-full overflow-hidden ml-3 lg:ml-4">All
                                    Players</span>
                            </a>
                        </li>
                        <li>
                            <a href="?page=deposit" class="inline-flex items-center w-full px-4 py-2 mt-1 text-sm text-gray-500 transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-gray-100 hover:scale-95 hover:text-amber-500">
                                <i class="fa-light fa-money-simple-from-bracket opacity-50 w-8 text-lg flex-shrink-0 justify-center flex"></i>
                                <span class="text-[1rem] truncate w-full overflow-hidden ml-3 lg:ml-4">Deposit</span>
                            </a>
                        </li>
                        <li>
                            <a href="?page=withdraw" class="inline-flex items-center w-full px-4 py-2 mt-1 text-sm text-gray-500 transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-gray-100 hover:scale-95 hover:text-amber-500">
                                <i class="fa-light fa-wallet opacity-50 w-8 text-lg flex-shrink-0 justify-center flex"></i>
                                <span class="text-[1rem] truncate w-full overflow-hidden ml-3 lg:ml-4">Withdraw</span>
                            </a>
                        </li>
                        <li>
                            <a href="?page=allBattle&status=Running" class="inline-flex items-center w-full px-4 py-2 mt-1 text-sm text-gray-500 transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-gray-100 hover:scale-95 hover:text-amber-500">
                                <i class="fa-light fa-swords opacity-50 w-8 text-lg flex-shrink-0 justify-center flex"></i>
                                <span class="text-[1rem] truncate w-full overflow-hidden ml-3 lg:ml-4">Running Battle</span>
                            </a>
                        </li>
                        <li>
                            <a href="?page=allBattle&status=Active" class="inline-flex items-center w-full px-4 py-2 mt-1 text-sm text-gray-500 transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-gray-100 hover:scale-95 hover:text-amber-500">
                                <i class="fa-light fa-sword opacity-50 w-8 text-lg flex-shrink-0 justify-center flex"></i>
                                <span class="text-[1rem] truncate w-full overflow-hidden ml-3 lg:ml-4">Active Battle</span>
                            </a>
                        </li>
                        <li>
                            <a href="?page=allBattle" class="inline-flex items-center w-full px-4 py-2 mt-1 text-sm text-gray-500 transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-gray-100 hover:scale-95 hover:text-amber-500">
                                <i class="fa-regular fa-axe-battle opacity-50 w-8 text-lg flex-shrink-0 justify-center flex"></i>
                                <span class="text-[1rem] truncate w-full overflow-hidden ml-3 lg:ml-4">All Battle</span>
                            </a>
                        </li>
                        <!-- <li>
                            <div id="sideBarPlayersDropdownOpen" class="inline-flex items-center justify-between cursor-pointer w-full px-4 py-2 mt-1 text-sm text-gray-500 transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-gray-100 hover:scale-95 hover:text-amber-500">
                                <div class="flex items-center gap-1 w-full">
                                    <i class="fa-light opacity-50 fa-user w-6 flex-shrink-0 justify-center flex"></i>
                                    <span class="ml-4">
                                        Players
                                    </span>
                                </div>
                                <i class="fa-solid fa-chevron-down"></i>
                            </div>

                            <div class="w-full rounded-xl overflow-hidden pl-5">
                                <ul id="sideBarPlayersDropdownContent" class="duration-500 bg-gray-50 my-2 p-2 rounded-xl">
                                    <li>
                                        <a href="?page=allPlayers" class="flex items-center gap-1 p-2 text-base text-gray-900 rounded-lg hover:bg-gray-100 group dark:hover:bg-gray-700">
                                            <i class="fa-light opacity-50 fa-users w-8 justify-center flex"></i>
                                            <span class="text-[0.75rem] truncate w-full overflow-hidden">All
                                                Players</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li> -->
                    </ul>
                    <!-- <p class="px-4 pt-4 text-xs font-semibold text-gray-400 uppercase">
                        Content
                    </p>
                    <ul>
                        <li>
                            <div id="sideBarPaymentsDropdownOpen" class="inline-flex items-center justify-between cursor-pointer w-full px-4 py-2 mt-1 text-sm text-gray-500 transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-gray-100 hover:scale-95 hover:text-amber-500">
                                <div class="flex items-center gap-1">
                                    <i class="fa-light opacity-50 fa-dice w-6 flex-shrink-0 justify-center flex"></i>

                                    <span class="ml-4">
                                        Payments
                                    </span>
                                </div>
                                <i class="fa-solid fa-chevron-down"></i>
                            </div>

                            <div class="w-full rounded-xl overflow-hidden pl-5">
                                <ul id="sideBarPaymentsDropdownContent" class="duration-500 bg-gray-50 my-2 p-2 rounded-xl">
                                    <li>
                                        <a href="?page=deposit" class="flex items-center gap-1 p-2 text-base text-gray-900 rounded-lg hover:bg-gray-100 group dark:hover:bg-gray-700">
                                            <i class="fa-light fa-money-simple-from-bracket opacity-50 w-8 justify-center flex"></i>
                                            <span class="text-[0.75rem] truncate w-full overflow-hidden">Deposit</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="?page=withdraw" class="flex items-center gap-1 p-2 text-base text-gray-900 rounded-lg hover:bg-gray-100 group dark:hover:bg-gray-700">
                                            <i class="fa-light fa-wallet opacity-50 w-8 justify-center flex"></i>
                                            <span class="text-[0.75rem] truncate w-full overflow-hidden">Withdraw</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="?page=coupon" class="flex items-center gap-1 p-2 text-base text-gray-900 rounded-lg hover:bg-gray-100 group dark:hover:bg-gray-700">
                                            <i class="fa-light fa-badge-percent opacity-50 w-8 justify-center flex"></i>
                                            <span class="text-[0.75rem] truncate w-full overflow-hidden">Coupons</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="?page=products" class="flex items-center gap-1 p-2 text-base text-gray-900 rounded-lg hover:bg-gray-100 group dark:hover:bg-gray-700">
                                            <i class="fa-light fa-credit-card opacity-50 w-8 justify-center flex"></i>
                                            <span class="text-[0.75rem] truncate w-full overflow-hidden">Settings</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li> -->
                    <!-- <li>
                        <div id="sideBarBattleDropdownOpen" class="inline-flex items-center justify-between cursor-pointer w-full px-4 py-2 mt-1 text-sm text-gray-500 transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-gray-100 hover:scale-95 hover:text-amber-500">
                            <div class="flex items-center gap-1">
                                <i class="fa-light opacity-50 fa-dice w-6 flex-shrink-0 justify-center flex"></i>

                                <span class="ml-4">
                                    Battle
                                </span>
                            </div>
                            <i class="fa-solid fa-chevron-down"></i>
                        </div>


                        <div class="w-full rounded-xl overflow-hidden pl-5">
                            <ul id="sideBarBattleDropdownContent" class="duration-500 bg-gray-50 my-2 p-2 rounded-xl">
                                <li>
                                    <a href="?page=allBattle&status=Running" class="flex items-center gap-1 p-2 text-base text-gray-900 rounded-lg hover:bg-gray-100 group dark:hover:bg-gray-700">
                                        <i class="fa-light fa-swords opacity-50 w-8 justify-center flex"></i>
                                        <span class="text-[0.75rem] truncate w-full overflow-hidden">Running Battle</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="?page=allBattle&status=Active" class="flex items-center gap-1 p-2 text-base text-gray-900 rounded-lg hover:bg-gray-100 group dark:hover:bg-gray-700">
                                        <i class="fa-light fa-sword opacity-50 w-8 justify-center flex"></i>
                                        <span class="text-[0.75rem] truncate w-full overflow-hidden">Active Battle</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="?page=allBattle" class="flex items-center gap-1 p-2 text-base text-gray-900 rounded-lg hover:bg-gray-100 group dark:hover:bg-gray-700">
                                        <i class="fa-regular fa-axe-battle opacity-50 w-8 justify-center flex"></i>
                                        <span class="text-[0.75rem] truncate w-full overflow-hidden">All Battle</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li> -->
                    </ul>
                    <p class="px-4 pt-4 text-xs font-semibold text-gray-400 uppercase">
                        Customization
                    </p>
                    <ul>
                        <li>
                            <a href="?page=games" class="inline-flex items-center w-full px-4 py-2 mt-1 cursor-pointer text-sm text-gray-500 transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-gray-100 hover:scale-95 hover:text-amber-500">
                                <i class="fa-light opacity-50 fa-joystick w-8 text-lg flex-shrink-0 justify-center flex"></i>
                                <span class="ml-3 lg:ml-4 text-lg">Games</span>
                            </a>
                        </li>
                        <li>
                            <a href="?page=feedback" class="inline-flex items-center w-full px-4 py-2 mt-1 cursor-pointer text-sm text-gray-500 transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-gray-100 hover:scale-95 hover:text-amber-500">
                                <i class="fa-light opacity-50 fa-message-dots w-8 text-lg flex-shrink-0 justify-center flex"></i>

                                <span class="ml-3 lg:ml-4 text-lg">Feedback</span>
                            </a>
                        </li>
                        <li>
                            <a href="?page=ratings" class="inline-flex items-center w-full px-4 py-2 mt-1 cursor-pointer text-sm text-gray-500 transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-gray-100 hover:scale-95 hover:text-amber-500">
                                <i class="fa-light opacity-50 fa-star w-8 text-lg flex-shrink-0 justify-center flex"></i>

                                <span class="ml-3 lg:ml-4 text-lg">Ratings</span>
                            </a>
                        </li>
                        <li>
                            <a href="?page=support" class="inline-flex items-center w-full px-4 py-2 mt-1 cursor-pointer text-sm text-gray-500 transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-gray-100 hover:scale-95 hover:text-amber-500">
                                <i class="fa-light opacity-50 fa-headset w-8 text-lg flex-shrink-0 justify-center flex"></i>

                                <span class="ml-3 lg:ml-4 text-lg">Support</span>
                            </a>
                        </li>
                        <li>
                            <a href="?page=register_admin" class="inline-flex items-center w-full px-4 py-2 mt-1 cursor-pointer text-sm text-gray-500 transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-gray-100 hover:scale-95 hover:text-amber-500">
                                <i class="fa-light fa-user-crown opacity-50 w-8 text-lg flex-shrink-0 justify-center flex"></i>
                                <span class="ml-3 lg:ml-4 text-lg">Register Admin</span>
                            </a>
                        </li>
                        <!-- <li>
                            <div class="inline-flex items-center w-full px-4 py-2 mt-1 cursor-pointer text-sm text-gray-500 transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-gray-100 hover:scale-95 hover:text-amber-500">
                                <i class="fa-light opacity-50 fa-file-invoice w-6 flex-shrink-0 justify-center flex"></i>
                                <span class="ml-4">
                                    Documents
                                </span>
                            </div>
                        </li> -->
                        <!-- <li>
                            <div id="sideBarSettingsDropdownOpen" class="inline-flex items-center justify-between w-full px-4 py-2 mt-1 cursor-pointer text-sm text-gray-500 transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-gray-100 hover:scale-95 hover:text-amber-500">
                                <div class="flex items-center gap-1">
                                    <i class="fa-light opacity-50 fa-gear w-6 flex-shrink-0 justify-center flex"></i>
                                    <span class="ml-4">
                                        Settings
                                    </span>
                                </div>
                                <i class="fa-solid fa-chevron-down"></i>
                            </div>

                            <div class="w-full rounded-xl overflow-hidden pl-5">
                                <ul id="sideBarSettingsDropdownContent" class="duration-500 bg-gray-50 my-2 p-2 rounded-xl">
                                    <li>
                                        <a href="?page=products" class="flex items-center gap-1 p-2 text-base text-gray-900 rounded-lg hover:bg-gray-100 group dark:hover:bg-gray-700">
                                            <i class="fa-light fa-users opacity-50 w-8 justify-center flex"></i>
                                            <span class="text-[0.75rem] truncate w-full overflow-hidden">Users</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="?page=products" class="flex items-center gap-1 p-2 text-base text-gray-900 rounded-lg hover:bg-gray-100 group dark:hover:bg-gray-700">
                                            <i class="fa-light opacity-50 fa-user-tie w-8 justify-center flex"></i>
                                            <span class="text-[0.75rem] truncate w-full overflow-hidden">Admin</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li> -->

                        <li>
                            <div onclick="location.assign('/logout.php')" class="inline-flex items-center w-full px-4 py-2 mt-1 cursor-pointer text-sm text-gray-500 transition duration-200 ease-in-out transform rounded-lg focus:shadow-outline hover:bg-gray-100 hover:scale-95 hover:text-amber-500">
                                <i class="fa-light fa-arrow-right-from-bracket opacity-50 w-8 text-lg flex-shrink-0 justify-center flex"></i>
                                <span class="ml-3 lg:ml-4 text-lg">Logout</span>
                            </div>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="flex flex-shrink-0 p-4 px-4 bg-gray-50">
                <div class="w-full relative">
                    <button class="inline-flex items-center justify-between w-full px-4 py-3 text-lg font-medium text-center transition duration-500 ease-in-out transform rounded-xl hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">

                        <span class="flex-shrink-0 group w-full flex items-center justify-between">
                            <div class="flex items-center">
                                <div>
                                    <i class="fa-duotone fa-user-crown text-2xl rounded-full group-hover:text-amber-500 duration-300"></i>
                                </div>
                                <div class="ml-3 text-left">
                                    <p class="text-sm font-medium text-gray-500 group-hover:text-amber-500 duration-300">
                                        <?php echo $_COOKIE["admin_name"] ?>
                                    </p>
                                    <p class="text-xs font-medium text-gray-500 group-hover:text-amber-500 duration-300">
                                        Admin
                                    </p>
                                </div>
                            </div>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>