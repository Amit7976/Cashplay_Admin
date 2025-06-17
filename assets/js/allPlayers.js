function formatDate(dateString) {
    const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

    let date = new Date(dateString);
    let day = String(date.getDate()).padStart(2, '0');
    let month = months[date.getMonth()];
    let year = date.getFullYear();

    return `${day} ${month} ${year}`;
}






function enableInlineEditing() {
    $('.editable-text').parent().dblclick(function () {
        var currentCompleteElement = currentElement;
        var currentElement = $(this).find('.editable-text');
        var currentValue = currentElement.data('value');
        var id = currentElement.data('id');
        var field = currentElement.data('field');
        var input;
        var oldValue = currentValue;

        if (field === 'account_secure') {
            input = $('<select>', {
                class: 'input border-2 border-gray-300',
                html: '<option value="1">Secure</option><option value="0">Danger</option>',
                val: parseInt(currentValue) == 1 ? '1' : '0',
                blur: function () {
                    var newValue = input.val();
                    if (newValue != oldValue) {
                        currentElement.text(newValue == '1' ? 'Secure' : 'Danger');
                        updateField(id, field, newValue);
                    } else {
                        currentElement.text(currentValue == '1' ? 'Secure' : 'Danger');
                    }
                }
            });
        } else if (field.includes('date_time')) {
            input = $('<input>', {
                type: 'datetime-local',
                class: 'input border-2 border-gray-300',
                val: formatDateForInput(currentValue),
                blur: function () {
                    var newValue = formatInputDate(input.val());
                    if (newValue != oldValue) {
                        currentElement.text(newValue);
                        updateField(id, field, newValue);
                    } else {
                        currentElement.html(currentCompleteElement);
                    }
                }
            });
        } else if (field === 'phone_number' || field === 'another_number') {
            currentValue = currentValue.toString();
            oldValue = oldValue.toString();
            input = $('<input>', {
                type: 'number',
                class: 'input border-2 border-gray-300',
                val: currentValue,
                maxLength: 10,
                minLength: 10,
                blur: function () {
                    var newValue = input.val();
                    if (newValue.length === 10 && newValue !== oldValue) {
                        currentElement.text(newValue);
                        updateField(id, field, newValue);
                    } else {
                        if (newValue.length !== 10) {
                            alert('Phone number must be exactly 10 digits.');
                        }
                        currentElement.html(currentCompleteElement);
                    }
                },
                keyup: function (e) {
                    if (e.which === 13) input.blur();
                }
            });
        } else {
            input = $('<input>', {
                type: 'text',
                class: 'input border-2 border-gray-300',
                val: currentValue,
                blur: function () {
                    var newValue = input.val().trim().replace(/\s+/g, '');
                    if (newValue != oldValue) {
                        currentElement.text(newValue);
                        updateField(id, field, newValue);
                    } else {
                        currentElement.html(currentCompleteElement);
                    }
                },
                keyup: function (e) {
                    if (e.which === 13) input.blur();
                }
            });
        }

        var tempSpan = $('<span>').text(currentValue).css({
            'font-size': currentElement.css('font-size'),
            'font-family': currentElement.css('font-family'),
            'visibility': 'hidden',
            'white-space': 'nowrap'
        }).appendTo('body');

        var textWidth = tempSpan.width();
        tempSpan.remove();

        input.css({
            width: textWidth + 100 + 'px',
            maxWidth: '16rem'
        });

        currentElement.empty().append(input);
        input.focus();
    });
}

function updateField(id, field, value) {
    console.log('id: ' + id);
    console.log('field: ' + field);
    console.log('value: ' + value);
    $.ajax({
        url: 'assets/php/get_user_details.php',
        type: 'POST',
        data: {
            updateFields: 'updateFields',
            id: id,
            field: field,
            value: value
        },
        success: function (response) {
            console.log(response);
            response = JSON.parse(response);
            if (response.status === 'success') {
                runningTableDetailsShowModal(id);
                console.log('Field updated successfully.');
            } else {
                alert('Failed to update field.');
            }
        },
        error: function (error) {
            console.error('Error Updating User Details:', error);
        }
    });
}

function formatDateForInput(dateStr) {
    var date = new Date(dateStr);
    var year = date.getFullYear();
    var month = ('0' + (date.getMonth() + 1)).slice(-2);
    var day = ('0' + date.getDate()).slice(-2);
    var hours = ('0' + date.getHours()).slice(-2);
    var minutes = ('0' + date.getMinutes()).slice(-2);
    return `${year}-${month}-${day}T${hours}:${minutes}`;
}

function formatInputDate(inputDate) {
    var date = new Date(inputDate);
    var year = date.getFullYear();
    var month = ('0' + (date.getMonth() + 1)).slice(-2);
    var day = ('0' + date.getDate()).slice(-2);
    var hours = ('0' + date.getHours()).slice(-2);
    var minutes = ('0' + date.getMinutes()).slice(-2);
    var seconds = ('0' + date.getSeconds()).slice(-2);
    return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
}



function runningTableDetailsShowModal(id) {

    console.log("run " + id);

    $.ajax({
        url: 'assets/php/get_user_details.php',
        type: 'POST',
        data: {
            get_user_details: 'get_user_details',
            id: id,
        },
        success: function (response) {
            console.log(response);
            if (response.status === 'success') {
                userDetailsMainModal.showModal();
                history.pushState({ userDetailsMainModalOpen: true }, 'Modal', '#userDetailsMainModal&playerId=' + id);

                let userData = response.data;

                let userDetailsContent = document.getElementById("userDetailsContent");

                userDetailsContent.innerHTML =
                    `
                        <div class="flex items-center gap-4 justify-between flex-col lg:flex-row">
                            <div class="flex items-center gap-3  flex-col lg:flex-row">
                                <img src="https://cashplay.in/assets/img/avatar/${userData.avatar}" class="w-28 h-28 lg:w-20 lg:h-20 rounded-full">
                                <div class="flex gap-2 flex-col items-center lg:items-start"><div><div>
                                    <h5 class="text-lg editable-text" font-semibold data-id="${userData.id}" data-field="user_name" data-value="${userData.user_name}">${userData.user_name}</h5></div></div><div><div>
                                    <p class="text-sm editable-text" data-id="${userData.id}" data-field="user_unique" data-value="${userData.user_unique}">${userData.user_unique}</p></div></div>
                                </div>
                            </div>
                            <div class="flex flex-col gap-2 my-5 lg:my-0">
                                <div class="grid grid-cols-6 lg:grid-cols-4 items-center gap-x-5 cursor-pointer overflow-hidden">
                                    <h5 class="whitespace-nowrap truncate flex-shrink-0 text-sm sm:text-base font-medium col-span-2 lg:col-span-1 text-gray-400">Phone Number:</h5>
                                    <p class="whitespace-nowrap flex-shrink-0 text-sm font-semibold col-span-4 lg:col-span-3 editable-text" data-id="${userData.id}" data-field="phone_number" data-value="${userData.phone_number}">${userData.country} ${userData.phone_number}</p>
                                </div>
                                <div class="grid grid-cols-6 items-center gap-x-5 cursor-pointer overflow-hidden">
                                    <h5 class="whitespace-nowrap truncate flex-shrink-0 text-sm sm:text-base font-medium col-span-2 lg:col-span-1 text-gray-400">Refer Id:</h5>
                                    <p class="whitespace-nowrap flex-shrink-0 text-sm font-semibold col-span-4 lg:col-span-3 editable-text" data-id="${userData.id}" data-field="refer_id" data-value="${userData.refer_id}">${userData.refer_id}</p>
                                </div>
                                <div class="grid grid-cols-6 items-center gap-x-5 cursor-pointer overflow-hidden">
                                    <h5 class="whitespace-nowrap truncate flex-shrink-0 text-sm sm:text-base font-medium col-span-2 lg:col-span-1 text-gray-400">Password:</h5>
                                    <p class="whitespace-nowrap flex-shrink-0 text-sm font-semibold col-span-4 lg:col-span-3 truncate overflow-hidden max-w-96 editable-text" data-id="${userData.id}" data-field="password" data-value="${userData.password}">${userData.password}</p>
                                </div>
                                <div class="grid grid-cols-6 items-center gap-x-5 cursor-pointer overflow-hidden">
                                    <h5 class="whitespace-nowrap truncate flex-shrink-0 text-sm sm:text-base font-medium col-span-2 lg:col-span-1 text-gray-400">Game Uid:</h5>
                                    <p class="whitespace-nowrap flex-shrink-0 text-sm font-semibold col-span-4 lg:col-span-3 editable-text" data-id="${userData.id}" data-field="game_uid" data-value="${userData.game_uid}">${userData.game_uid}</p>
                                </div>
                            </div>
                        </div>
                            <div role="tablist" class="tabs tabs-lifted mt-5 mb-8 overflow-x-auto">
            <input type="radio" name="my_tabs_2" role="tab" class="tab" aria-label="About" style="width: max-content;" checked />
            <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6 max-h-[40vh] overflow-scroll flex-shrink-0 w-full border-2">
                <div class="grid grid-cols-2 gap-3 items-stretch max-h-[40vh]">
                    <div class="col-span-1 px-4 rounded-xl bg-gray-100 flex items-center justify-center gap-3 lg:gap-2 flex-col relative py-5">
                        <p class="text-sm sm:text-lg font-medium editable-text whitespace-break-spaces flex-shrink-0 text-center" data-id="${userData.id}" data-field="total_balance" data-value="${userData.total_balance}">${userData.total_balance} <span class="text-green-500">&#x20B9;</span></p>
                        <p class="text-xs sm:text-sm text-gray-400 font-medium whitespace-break-spaces flex-shrink-0 text-center">Total Balance</p>
                    </div>
                    <div class="col-span-1 px-4 rounded-xl bg-gray-100 flex items-center justify-center gap-3 lg:gap-2 flex-col relative py-5">
                        <p class="text-sm sm:text-lg font-medium editable-text whitespace-break-spaces flex-shrink-0 text-center" data-id="${userData.id}" data-field="total_withdraw_balance" data-value="${userData.total_withdraw_balance}">${userData.total_withdraw_balance} <span class="text-green-500">&#x20B9;</span></p>
                        <p class="text-xs sm:text-sm text-gray-400 font-medium whitespace-break-spaces flex-shrink-0 text-center">Total Withdrawal Balance</p>
                    </div>
                    <div class="col-span-1 px-4 rounded-xl bg-gray-100 flex items-center justify-center gap-3 lg:gap-2 flex-col relative py-5">
                        <p class="text-sm sm:text-lg font-medium editable-text whitespace-break-spaces flex-shrink-0 text-center" data-id="${userData.id}" data-field="total_balance_backup" data-value="${userData.total_balance_backup}">${userData.total_balance_backup} <span class="text-green-500">&#x20B9;</span></p>
                        <p class="text-xs sm:text-sm text-gray-400 font-medium whitespace-break-spaces flex-shrink-0 text-center">Total Balance Backup</p>
                    </div>
                    <div class="col-span-1 px-4 rounded-xl bg-gray-100 flex items-center justify-center gap-3 lg:gap-2 flex-col relative py-5">
                        <p class="text-sm sm:text-lg font-medium editable-text whitespace-break-spaces flex-shrink-0 text-center" data-id="${userData.id}" data-field="withdraw_balance_backup" data-value="${userData.withdraw_balance_backup}">${userData.withdraw_balance_backup} <span class="text-green-500">&#x20B9;</span></p>
                        <p class="text-xs sm:text-sm text-gray-400 font-medium whitespace-break-spaces flex-shrink-0 text-center">Total Withdrawal Backup</p>
                    </div>
                    <div class="col-span-1 px-4 rounded-xl bg-gray-100 flex items-center justify-center gap-3 lg:gap-2 flex-col relative py-5">
                        <p class="text-sm sm:text-lg font-medium editable-text whitespace-break-spaces flex-shrink-0 text-center" data-id="${userData.id}" data-field="last_settle_amount" data-value="${userData.last_settle_amount}">${userData.last_settle_amount} <span class="text-green-500">&#x20B9;</span></p>
                        <p class="text-xs sm:text-sm text-gray-400 font-medium whitespace-break-spaces flex-shrink-0 text-center">Last Settle Amount</p>
                    </div>
                    <div class="col-span-1 px-4 rounded-xl bg-gray-100 flex items-center justify-center gap-3 lg:gap-2 flex-col relative py-5">
                        <p class="text-sm sm:text-lg font-medium editable-text whitespace-break-spaces flex-shrink-0 text-center" data-id="${userData.id}" data-field="penalty_amount" data-value="${userData.penalty_amount}">${userData.penalty_amount} <span class="text-green-500">&#x20B9;</span></p>
                        <p class="text-xs sm:text-sm text-gray-400 font-medium whitespace-break-spaces flex-shrink-0 text-center">Penalty Amount</p>
                    </div>
                    <div class="px-4 rounded-xl bg-gray-100 flex items-center justify-center gap-3 lg:gap-2 flex-col relative py-5 col-span-2 lg:col-span-1">
                        <p class="text-sm sm:text-lg font-medium editable-text whitespace-break-spaces flex-shrink-0 text-center" data-id="${userData.id}" data-field="another_number" data-value="${userData.another_number}">${userData.another_number}</p>
                        <p class="text-xs sm:text-sm text-gray-400 font-medium whitespace-break-spaces flex-shrink-0 text-center">Another Number</p>
                    </div>
                    <div class="px-4 rounded-xl bg-gray-100 flex items-center justify-center gap-3 lg:gap-2 flex-col relative py-5 col-span-2 lg:col-span-1">
                        <p class="text-sm sm:text-lg font-medium editable-text whitespace-break-spaces flex-shrink-0 text-center" data-id="${userData.id}" data-field="email_id" data-value="${userData.email_id}">${userData.email_id}</p>
                        <p class="text-xs sm:text-sm text-gray-400 font-medium whitespace-break-spaces flex-shrink-0 text-center">Email Id</p>
                    </div>
                    <div class="px-4 rounded-xl bg-gray-100 flex items-center justify-center gap-3 lg:gap-2 flex-col relative py-5 col-span-2 lg:col-span-1">
                        <p class="text-sm sm:text-lg font-medium editable-text whitespace-break-spaces flex-shrink-0 text-center" data-id="${userData.id}" data-field="invite_id" data-value="${userData.invite_id}">${userData.invite_id}</p>
                        <p class="text-xs sm:text-sm text-gray-400 font-medium whitespace-break-spaces flex-shrink-0 text-center">Invite By</p>
                    </div>
                    <div class="col-span-1 px-4 rounded-xl bg-gray-100 flex items-center justify-center gap-3 lg:gap-2 flex-col relative py-5">
                        <p class="text-sm sm:text-lg font-medium editable-text whitespace-break-spaces flex-shrink-0 text-center" data-id="${userData.id}" data-field="date_time" data-value="${userData.date_time}">${formatDate(userData.date_time)}</p>
                        <p class="text-xs sm:text-sm text-gray-400 font-medium whitespace-break-spaces flex-shrink-0 text-center">Join Date</p>
                    </div>
                    <div class="col-span-1 px-4 rounded-xl bg-gray-100 flex items-center justify-center gap-3 lg:gap-2 flex-col relative py-5">
                        <p class="text-sm sm:text-lg font-medium editable-text whitespace-break-spaces flex-shrink-0 text-center ${parseInt(userData.account_secure) == 1 ? 'text-green-500' : 'text-red-500'}" data-id="${userData.id}" data-field="account_secure" data-value="${userData.account_secure}">${parseInt(userData.account_secure) == 1 ? 'Secure' : 'Danger'}</p>
                        <p class="text-xs sm:text-sm text-gray-400 font-medium whitespace-break-spaces flex-shrink-0 text-center">Account Secured</p>
                    </div>
                    <div class="px-4 rounded-xl bg-gray-100 flex items-center justify-center gap-3 lg:gap-2 flex-col relative py-5 col-span-2 lg:col-span-1">
                        <p class="text-sm sm:text-lg font-medium editable-text whitespace-break-spaces flex-shrink-0 text-center" data-id="${userData.id}" data-field="delete_account_date_time" data-value="${userData.delete_account_date_time}">${((userData.delete_account_date_time) ? formatDate(userData.delete_account_date_time) : '--')}</p>
                        <p class="text-xs sm:text-sm text-gray-400 font-medium whitespace-break-spaces flex-shrink-0 text-center">Delete Account Date</p>
                    </div>
                </div>
            </div>



            <input type="radio" onclick="fetchGamesDetailsOfUser('${userData.user_unique}')" name="my_tabs_2" role="tab" class="tab" aria-label="Games" style="width: max-content;" />
            <div role="tabpanel" id="fetchGamesDetailsOfUser" class="tab-content bg-base-100 border-base-300 rounded-box p-6 max-h-[40vh] overflow-scroll flex-shrink-0 w-full border-2">

            </div>
         
            <input type="radio" onclick="fetchPlayedBattleDetailsOfUser('${userData.user_unique}')" name="my_tabs_2" role="tab" class="tab" aria-label="Battle" style="width: max-content;" />
            <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6  max-h-[40vh] overflow-scroll">
             <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-slate-800">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-start whitespace-nowrap">
                                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200 flex-shrink-0 w-max text-balance">
                                            Id
                                        </p>
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-start whitespace-nowrap">
                                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200 flex-shrink-0 w-max text-balance">
                                            Room Code
                                        </p>
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-start whitespace-nowrap">
                                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200 flex-shrink-0 w-max text-balance">
                                            Player 1
                                        </p>
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-start whitespace-nowrap">
                                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200 flex-shrink-0 w-max text-balance">
                                            Player 2
                                        </p>
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-start whitespace-nowrap">
                                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200 flex-shrink-0 w-max text-balance">
                                            Amount
                                        </p>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-start whitespace-nowrap">
                                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200 flex-shrink-0 w-max text-balance">
                                            Game Type
                                        </p>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-start whitespace-nowrap">
                                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200 flex-shrink-0 w-max text-balance">
                                            Status
                                        </p>
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-start whitespace-nowrap">
                                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200 flex-shrink-0 w-max text-balance">
                                            Date
                                        </p>
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-start whitespace-nowrap">
                                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200 flex-shrink-0 w-max text-balance">
                                            Action
                                        </p>
                                    </th>
                                </tr>
                            </thead>

                            <tbody id="fetchPlayedBattleDetailsOfUser" class="divide-y pb-20 divide-gray-200 dark:divide-gray-700">
                               
                            </tbody>
                            </table>
                            <button id="loadMoreBattlesButton" onclick="fetchBattlesNextRecords('${userData.user_unique}')" class="btn mx-auto w-full text-center sticky left-0">Load More</button>
            </div>
               <input type="radio" onclick="fetchRatingsByUser('${userData.user_unique}')" name="my_tabs_2" role="tab" class="tab" aria-label="Ratings" style="width: max-content;" />
            <div role="tabpanel" id="fetchRatingsByUser" class="tab-content bg-base-100 border-base-300 rounded-box p-6 max-h-[40vh] overflow-scroll flex-shrink-0 w-full border-2">

            </div>

            <input type="radio" onclick="fetchFeedbackByUser('${userData.user_unique}')" name="my_tabs_2" role="tab" class="tab" aria-label="Feedback" style="width: max-content;" />
            <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6 max-h-[40vh] overflow-scroll flex-shrink-0 w-full border-2">
                <div class="flex w-full flex-col gap-6" id="fetchFeedbackByUser">

                </div>
            </div>

            <form method="dialog" onclick="history.back();" id="closeDetailsModalButton" class="modal-backdrop absolute flex justify-center items-center top-3 right-3 w-10 h-10 rounded-full bg-gray-200 text-gray-600 hover:rotate-180 duration-300">
            <button class="w-10 h-10"><i class="fa-solid fa-close text-base"></i></button>
            </form>
            </div
      
                        `;

                enableInlineEditing();
            } else {
                console.log('Failed to fetch user details.');
            }
        }
    });
}


window.addEventListener('popstate', handlePopState);


function handlePopState(event) {
    console.log('run');
    if (event.state && event.state.userDetailsMainModalOpen) {
        document.getElementById('userDetailsMainModal').close();
        if (window.location.hash === '#modal') {
            history.back();
        }
    } else if (!event.state) {
        document.getElementById('userDetailsMainModal').close();
    }
}


function fetchRatingsByUser(userUnique) {
    console.log("run ratings " + userUnique);
    let fetchRatingsByUser = document.getElementById("fetchRatingsByUser");
    fetchRatingsByUser.innerHTML = '';
    $.ajax({
        url: 'assets/php/get_user_details.php',
        type: 'POST',
        data: {
            get_user_ratings: 'get_user_ratings',
            user_unique: userUnique,
        },
        success: function (response) {
            console.log(response);
            if (response.status === 'success') {

                let ratingContent = '';
                if (parseInt(response.ar_rating) === 0) {
                    ratingContent = 'No ratings yet';
                } else {
                    ratingContent = `
    <div class="flex items-center mb-1 space-x-10">
    <div class="flex items-center mb-1 space-x-1">
        <i class="fa-solid fa-star text-sm sm:text-lg ${(parseInt(response.ar_rating) >= 1 ? 'text-amber-500' : 'text-gray-500')}"></i>
        <i class="fa-solid fa-star text-sm sm:text-lg ${(parseInt(response.ar_rating) >= 2 ? 'text-amber-500' : 'text-gray-500')}"></i>
        <i class="fa-solid fa-star text-sm sm:text-lg ${(parseInt(response.ar_rating) >= 3 ? 'text-amber-500' : 'text-gray-500')}"></i>
        <i class="fa-solid fa-star text-sm sm:text-lg ${(parseInt(response.ar_rating) >= 4 ? 'text-amber-500' : 'text-gray-500')}"></i>
        <i class="fa-solid fa-star text-sm sm:text-lg ${(parseInt(response.ar_rating) == 5 ? 'text-amber-500' : 'text-gray-500')}"></i>
    </div>
    <p class="mb-2 text-sm sm:text-base ${(parseInt(response.ar_status) == 1 ? 'text-green-500' : 'text-blue-500')}">${(parseInt(response.ar_status) == 1 ? 'Active' : 'In Review')}</p>
    <p class="mb-2 text-sm sm:text-base text-gray-500 dark:text-gray-400">${formatDate(response.ar_date_time)}</p>
    </div>
    <p class="mb-2 text-sm sm:text-base text-gray-500 dark:text-gray-400">${response.ar_review}</p>
`;
                }

                fetchRatingsByUser.innerHTML = ratingContent;

            } else {
                alert('Error: ' + response.status);
            }
        }
    });
}


function fetchFeedbackByUser(userUnique) {
    console.log("run Feedback " + userUnique);
    let fetchFeedbackByUser = document.getElementById("fetchFeedbackByUser");
    fetchFeedbackByUser.innerHTML = '';

    $.ajax({
        url: 'assets/php/get_user_details.php',
        type: 'POST',
        data: {
            get_user_feedback: 'get_user_feedback',
            user_unique: userUnique,
        },
        dataType: 'json', // Ensure the response is parsed as JSON
        success: function (response) {
            console.log("its run");
            console.log(response);
            if (response.status === 'success') {
                if (response.feedbacks.length > 0) {
                    response.feedbacks.forEach(feedback => {
                        fetchFeedbackByUser.innerHTML += `
                        <div class="flex w-full items-center gap-6 py-6">
                            <div class="flex-shrink-0 w-20 h-20 flex items-center justify-center rounded-xl bg-white text-lg sm:text-2xl flex-col font-bold gap-0" style="box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;">
                                <i class="fa-duotone fa-caret-up scale-125 -mb-2"></i>
                                <p>${feedback.f_vote}</p>
                            </div>
                            <div class="flex flex-col gap-3">
                                <p class="text-sm sm:text-base font-medium">${feedback.f_feedback}</p>
                                <p class="text-sm sm:text-base font-medium">${formatDate(feedback.f_date_time)}</p>
                            </div>
                        </div>`;
                    });
                } else {
                    fetchFeedbackByUser.innerHTML = '<p class="text-base font-medium">No feedback available</p>';
                }
            } else {
                alert('Error: ' + response.status);
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX Error:', status, error);
            alert('AJAX Error: ' + status + ' - ' + error);
        }
    });
}




function fetchGamesDetailsOfUser(userUnique) {
    console.log("Fetching match stats for user: " + userUnique);
    let fetchGamesDetailsOfUser = document.getElementById("fetchGamesDetailsOfUser");
    fetchGamesDetailsOfUser.innerHTML = '';
    $.ajax({
        url: 'assets/php/get_user_details.php',
        type: 'POST',
        data: {
            get_user_games_details: 'get_user_games_details',
            user_unique: userUnique,
        },
        success: function (response) {
            console.log(response);
            if (response.status === 'success') {

                fetchGamesDetailsOfUser.innerHTML = `
   <div class="grid grid-cols-2 lg:grid-cols-4 gap-5 items-stretch my-10">
                    <div class="col-span-1 p-4 rounded-xl bg-gray-100 flex items-center justify-center gap-2 flex-col relative">
                        <i class="fa-solid fa-swords absolute text-base w-10 h-10 flex items-center justify-center rounded-full top-0 right-0 text-gray-400"></i>
                        <h3 class="text-sm sm:text-xl font-medium">${response.complete_matches.match_count}</h3>
                        <p class="text-xs sm:text-sm text-gray-400 font-medium">Completed Battle</p>
                        <p class="text-sm sm:text-base font-medium">${((response.complete_matches.total_price) ? response.complete_matches.total_price : '00.00')} <span class="text-green-500">&#x20B9;</span></p>

                    </div>
                    <div class="col-span-1 p-4 rounded-xl bg-gray-100 flex items-center justify-center gap-2 flex-col relative">
                        <i class="fa-solid fa-trophy absolute text-base w-10 h-10 flex items-center justify-center rounded-full top-0 right-0 text-gray-400"></i>
                        <h3 class="text-sm sm:text-xl font-medium">${response.won_matches.win_count}</h3>
                        <p class="text-xs sm:text-sm text-gray-400 font-medium">Win Battles</p>
                        <p class="text-sm sm:text-base font-medium">${((response.won_matches.total_won_amount) ? response.won_matches.total_won_amount : '00.00')} <span class="text-green-500">&#x20B9;</span></p>

                    </div>
                    <div class="col-span-1 p-4 rounded-xl bg-gray-100 flex items-center justify-center gap-2 flex-col relative">
                        <i class="fa-solid fa-face-sad-cry absolute text-base w-10 h-10 flex items-center justify-center rounded-full top-0 right-0 text-gray-400"></i>
                        <h3 class="text-sm sm:text-xl font-medium">${response.lost_matches.lose_count}</h3>
                        <p class="text-xs sm:text-sm text-gray-400 font-medium">Loosed Battles</p>
                        <p class="text-sm sm:text-base font-medium">${((response.lost_matches.total_lost_price) ? response.lost_matches.total_lost_price : '00.00')} <span class="text-green-500">&#x20B9;</span></p>

                    </div>
                    <div class="col-span-1 p-4 rounded-xl bg-gray-100 flex items-center justify-center gap-2 flex-col relative">
                        <i class="fa-solid fa-person-to-door absolute text-base w-10 h-10 flex items-center justify-center rounded-full top-0 right-0 text-gray-400"></i>
                        <h3 class="text-sm sm:text-xl font-medium">${response.leave_matches.leave_count}</h3>
                        <p class="text-xs sm:text-sm text-gray-400 font-medium">Leaved Battles</p>

                    </div>
                    <div class="col-span-1 p-4 rounded-xl bg-gray-100 flex items-center justify-center gap-2 flex-col relative">
                        <i class="fa-solid fa-ban absolute text-base w-10 h-10 flex items-center justify-center rounded-full top-0 right-0 text-gray-400"></i>
                        <h3 class="text-sm sm:text-xl font-medium">${response.cancel_matches.cancel_count}</h3>
                        <p class="text-xs sm:text-sm text-gray-400 font-medium">Canceled Battles</p>

                    </div>
                    <div class="col-span-1 p-4 rounded-xl bg-gray-100 flex items-center justify-center gap-2 flex-col relative">
                        <h3 class="text-sm sm:text-xl font-medium">${response.classic_matches.classic_count}</h3>
                        <p class="text-xs sm:text-sm text-gray-400 font-medium">Classic</p>
                    </div>
                    <div class="col-span-1 p-4 rounded-xl bg-gray-100 flex items-center justify-center gap-2 flex-col relative">
                        <h3 class="text-sm sm:text-xl font-medium">${response.popular_matches.popular_count}</h3>
                        <p class="text-xs sm:text-sm text-gray-400 font-medium">Popular</p>

                    </div>
                    <div class="col-span-1 p-4 rounded-xl bg-gray-100 flex items-center justify-center gap-2 flex-col relative">
                        <h3 class="text-sm sm:text-xl font-medium">${response.quick_matches.quick_count}</h3>
                        <p class="text-xs sm:text-sm text-gray-400 font-medium">Quick</p>
                    </div>
                    <div class="col-span-1 p-4 rounded-xl bg-gray-100 flex items-center justify-center gap-2 flex-col relative">
                        <h3 class="text-sm sm:text-xl font-medium">${response.two_token_matches.two_token_count}</h3>
                        <p class="text-xs sm:text-sm text-gray-400 font-medium">Two Token</p>
                    </div>
                    <div class="col-span-1 p-4 rounded-xl bg-gray-100 flex items-center justify-center gap-2 flex-col relative">
                        <h3 class="text-sm sm:text-xl font-medium">${response.three_token_matches.three_token_count}</h3>
                        <p class="text-xs sm:text-sm text-gray-400 font-medium">Three Token</p>
                    </div>
                </div>
`;


            } else {
                alert('Error: ' + response.status);
            }
        }
    });
}





function fetchPlayedBattleDetailsOfUser(userUnique) {
    console.log("Fetching match stats for user: " + userUnique);
    $('#fetchPlayedBattleDetailsOfUser').html('');

    $.ajax({
        url: 'assets/php/get_user_details.php',
        method: 'POST',
        data: {
            get_user_battles_details: 'get_user_battles_details',
            user_unique: userUnique,
        },
        success: function (data) {
            // console.log(data);
            $('#fetchPlayedBattleDetailsOfUser').html(data);
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
        }
    });

}

let b_start = 0;
const b_limit = 5;

function fetchBattlesNextRecords(userUnique) {
    $('#loadMoreBattlesButton').text('Loading');

    console.log("amit   1");

    b_start += b_limit;
    $.ajax({
        url: 'assets/php/get_user_details.php',
        type: 'POST',
        data: {
            get_more_battles_details: 'get_more_battles_details',
            user_unique: userUnique,
            b_start: b_start,
            b_limit: b_limit
        },
        success: function (response) {
            console.log(response);
            console.log(response.trim() == 'No records found.');
            if (response.trim() === '') {
                // If response is empty, remove the button
                $('#loadMoreBattlesButton').remove();
            } else if (response.trim() == 'No records found.') {
                // If response is No records found., remove the button
                $('#loadMoreBattlesButton').remove();
            } else {
                // Append the new records to the table
                $('#fetchPlayedBattleDetailsOfUser').append(response);
            }


            $('#loadMoreBattlesButton').text('Load More');
            quickSeen();
        }
    });
}




function fetchPlayedBattleDetailsOfUser0(userUnique) {
    console.log("Fetching match stats for user: " + userUnique);
    let fetchPlayedBattleDetailsOfUser = document.getElementById("fetchPlayedBattleDetailsOfUser");
    fetchPlayedBattleDetailsOfUser.innerHTML = '';
    $.ajax({
        url: 'assets/php/get_user_details.php',
        type: 'POST',
        data: {
            get_user_battles_details: 'get_user_battles_details',
            user_unique: userUnique,
        },
        success: function (response) {
            console.log(response);
            if (response.status === 'success') {
                response.battles.forEach(battle => {
                    fetchPlayedBattleDetailsOfUser.innerHTML += `
                        <tr class="${battle.b_winner_id != '' ? battle.b_winner_id === userUnique ? 'bg-green-100 text-black' : 'bg-red-100 text-black' : ''} py-5 rounded-xl">
                            <td class="size-px whitespace-nowrap px-6 py-3">
                                <a href="#" class="cursor-pointer">
                                    <p class="text-sm text-amber-600">${battle.b_id}</p>
                                </a>
                            </td>
                            <td class="size-px whitespace-nowrap px-6 py-3">
                                <a href="#" class="cursor-pointer">
                                    <p class="text-sm text-amber-600">${battle.b_room_code}</p>
                                </a>
                            </td>
                            <td class="size-px whitespace-nowrap px-6 py-3">
                                <a href="#" class="cursor-pointer">
                                    <p class="text-sm">${battle.b_creator_id === userUnique ? battle.b_player2_id : battle.b_creator_id}</p>
                                </a>
                            </td>
                            <td class="size-px whitespace-nowrap px-8 py-3">
                                <p class="text-sm text-green-600">${battle.b_price}&#x20B9;</p>
                            </td>
                            <td class="size-px whitespace-nowrap px-6 py-3">
                                <p class="text-sm text-amber-600">${battle.b_game}</p>
                            </td>
                            <td class="size-px whitespace-nowrap px-6 py-3">
                                <p class="text-sm text-green-600">${battle.b_status}</p>
                            </td>
                            <td class="size-px whitespace-nowrap px-6 py-3">
                                <p class="text-sm">${formatDate(battle.b_game_end)}</p>
                            </td>
                        </tr>
                    `;
                });
            } else {
                alert('Error: ' + response.status);
            }
        }
    });
}






let start = 0;
const limit = 20;

function fetchNextRecords() {
    console.log("amit   1");
    start += limit;
    $.ajax({
        url: '/pages/allPlayers_scroll.php',
        type: 'POST',
        data: {
            start: start,
            limit: limit
        },
        success: function (response) {
            if (response.trim() === '') {
                // If response is empty, remove the button
                $('#loadMoreButton').remove();
            } else {
                // Append the new records to the table
                $('#userDetailsTable').append(response);
            }
            $('#loadMoreButton').text('Load More');
            quickSeen();
        }
    });
}


$('#loadMoreButton').click(function () {
    fetchNextRecords();
    $('#loadMoreButton').text('Loading');
});









// SEARCH USER DETAILS

document.getElementById("searchInput").addEventListener('keydown', (event) => {
    if (event.key === 'Enter') {
        searchDetails();
    }
});

function searchDetails() {
    console.log("search start");

    let searchInput = document.getElementById("searchInput").value;

    $.ajax({
        url: 'assets/php/get_user_details.php',
        type: 'POST',
        data: {
            search: searchInput,
        },
        dataType: 'json', // Ensure the response is parsed as JSON
        success: function (response) {
            console.log("its run");
            console.log(response);

            $('#userDetailsTable').html('');
            if (response.status === 'success') {
                console.log(response);
                response.data.forEach(user => {
                    console.log(user);
                    document.getElementById("userDetailsTable").innerHTML +=
                        `
                    <tr id="user_unique_${user.user_unique}">
                                        <td class="whitespace-nowrap">
                                            <div class="px-6 py-3 overflow-hidden">
                                                <div class="flex items-center gap-x-3 w-max truncate">
                                                    <img class="inline-block size-[38px] rounded-full" src="https://cashplay.in/assets/img/avatar/${user.avatar}" alt="${user.user_name}'s Avatar">
                                                    <div class="grow">
                                                        <span class="block text-sm font-semibold text-gray-800 dark:text-gray-200">${user.user_name}</span>
                                                        <span class="block text-sm text-gray-500">${user.user_unique}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap">
                                            <div class="px-6 py-3">
                                                <span class="block text-sm text-gray-500 editable-text2" data-id="${user.id}" data-field="total_balance" data-value="${user.total_balance}">${user.total_balance}</span>
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap">
                                            <div class="px-6 py-3">
                                                <span class="block text-sm text-gray-500 editable-text2" data-id="${user.id}" data-field="total_withdraw_balance" data-value="${user.total_withdraw_balance}">${user.total_withdraw_balance}</span>
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap">
                                            <div class="px-6 py-3">
                                                <span class="block text-sm text-gray-500 editable-text2" data-id="${user.id}" data-field="game_uid" data-value="${user.game_uid}">${user.game_uid}</span>
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap">
                                            <div class="px-6 py-3">
                                                <span class="block text-sm text-gray-500">${user.country} <span class="editable-text2" data-id="${user.id}" data-field="phone_number" data-value="${user.phone_number}">${user.phone_number}</span></span>
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap">
                                            <div class="px-6 py-3 flex justify-end">
                                                <select class="select2 bg-white text-sm cursor-pointer outline-none">
                                                    <option ${((user.login_access != 1 && user.log_out_globally != 1) ? 'selected' : '')} value="Active" class="text-green-500">Active</option>
                                                    <option ${(user.log_out_globally == 1 ? 'selected' : '')} value="Logout" class="text-amber-500">Logout</option>
                                                    <option ${(user.login_access != 1 ? 'selected' : '')} value="Blocked" class="text-red-500">Blocked</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap">
                                            <div class="px-6">
                                                <button class="btn" onclick="runningTableDetailsShowModal('${user.id}')">Details</button>
                                            </div>
                                        </td>
                                    </tr>
                    `;
                    quickSeen();
                });
            } else {
                $('#userDetailsTable').html('<p>No results found.</p>');
            }

        },
        error: function (xhr, status, error) {
            console.error('AJAX Error:', status, error);
            alert('AJAX Error: ' + status + ' - ' + error);
        }
    });
}












///// EDIT QUICK SEEN DETAILS

function quickSeen() {
    $(document).ready(function () {
        // Enable inline editing for text fields
        $('.editable-text2').parent().dblclick(function () {
            var currentElement = $(this).find('.editable-text2');
            var currentValue = currentElement.data('value');
            var id = currentElement.data('id');
            var field = currentElement.data('field');
            var input;
            var oldValue = currentValue;
            var currentCompleteElement = currentElement.html();

            if (field === 'phone_number' || field === 'another_number') {
                input = $('<input>', {
                    type: 'number',
                    class: 'input border-2 border-gray-300',
                    val: currentValue,
                    maxLength: 10,
                    minLength: 10,
                    blur: function () {
                        var newValue = input.val();
                        if (newValue.length === 10 && newValue !== oldValue) {
                            currentElement.text(newValue);
                            updateField2(id, field, newValue);
                        } else {
                            if (newValue.length !== 10) {
                                alert('Phone number must be exactly 10 digits.');
                            }
                            currentElement.html(currentCompleteElement);
                        }
                    },
                    keyup: function (e) {
                        if (e.which === 13) input.blur();
                    }
                });
            } else {
                input = $('<input>', {
                    type: 'text',
                    class: 'input border-2 border-gray-300',
                    val: currentValue,
                    blur: function () {
                        var newValue = input.val().trim().replace(/\s+/g, '');
                        if (newValue !== oldValue) {
                            currentElement.text(newValue);
                            updateField2(id, field, newValue);
                        } else {
                            currentElement.html(currentCompleteElement);
                        }
                    },
                    keyup: function (e) {
                        if (e.which === 13) input.blur();
                    }
                });
            }

            var tempSpan = $('<span>').text(currentValue).css({
                'font-size': currentElement.css('font-size'),
                'font-family': currentElement.css('font-family'),
                'visibility': 'hidden',
                'white-space': 'nowrap'
            }).appendTo('body');

            var textWidth = tempSpan.width();
            tempSpan.remove();

            input.css({
                width: textWidth + 100 + 'px',
                maxWidth: '16rem'
            });

            currentElement.empty().append(input);
            input.focus();
        });

        // Handle select field changes
        $('.select2').change(function () {
            var selectedValue = $(this).val();
            var id = $(this).closest('tr').attr('id').split('_')[2]; // Extract the user_unique
            var field = 'status'; // Assuming you have a status field in your database

            var data = {
                id: id,
                field: 'status'
            };

            if (selectedValue === 'Active') {
                data['login_access'] = 1;
                data['log_out_globally'] = 0;
            } else if (selectedValue === 'Logout') {
                data['login_access'] = 1;
                data['log_out_globally'] = 1;
            } else if (selectedValue === 'Blocked') {
                data['login_access'] = 0;
                data['log_out_globally'] = 0;
            }

            updateField2(id, field, selectedValue, data);
        });
    });

    function updateField2(id, field, value, additionalData = {}) {
        var data = {
            updateQuickSeenFields: 'updateQuickSeenFields',
            id: id,
            field: field,
            value: value
        };

        // Merge additional data if any
        $.extend(data, additionalData);

        $.ajax({
            url: 'assets/php/get_user_details.php',
            type: 'POST',
            data: data,
            success: function (response) {
                console.log(response);
                response = JSON.parse(response);
                if (response.status === 'success') {
                    console.log('Field updated successfully.');
                } else {
                    alert('Failed to update field.');
                }
            },
            error: function (error) {
                console.error('Error Updating User Details:', error);
            }
        });
    }

}
quickSeen();




// FOR TEST MODAL
// runningTableDetailsShowModal('18')
// location.assign('#modal-open');