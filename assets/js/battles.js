document.addEventListener('DOMContentLoaded', function () {
    const filterForm = $('#filter-form');
    const dateFilter = $('#date_filter');
    const startDateInput = $('#start_date');
    const endDateInput = $('#end_date');

    dateFilter.on('change', function () {
        if (dateFilter.val() === 'custom') {
            startDateInput.removeClass('hidden');
            endDateInput.removeClass('hidden');
        } else {
            startDateInput.addClass('hidden');
            endDateInput.addClass('hidden');
        }
    });

    filterForm.on('submit', function (event) {
        event.preventDefault();
        fetchFilteredData();
    });

    function fetchFilteredData() {
        const formData = filterForm.serializeArray();
        formData.push({ name: 'filterRecords', value: 'filterRecords' });

        $.ajax({
            url: 'assets/php/battles.php',
            method: 'POST',
            data: formData,
            success: function (data) {
                // console.log(data);
                $('tbody').html(data);
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }
});



$(document).on('click', '#cancel-btn', function () {
    const b_id = $(this).data('b_id');
    const userConfirmed = confirm('Are you sure you want to cancel this Battle?');

    if (userConfirmed) {
        $.ajax({
            url: 'assets/php/battles.php',
            type: 'POST',
            data: {
                b_id: b_id,
                action: 'cancel'
            },
            success: function (response) {
                console.log(response);
                if (response.status === 'success') {
                    alert('Battle cancelled successfully.');
                    allBattleDetails(b_id);
                } else if (response.status === 'battle_already_cancelled') {
                    alert('Battle is already cancelled');
                } else if (response.status === 'error') {
                    alert(response.message);
                } else {
                    alert('Server error: Please try again later');
                }
            },
            error: function (error) {
                console.error('Error cancelling Battle:', error);
            }
        });
    }
});





$(document).on('click', '#complete-btn', function () {
    const b_id = $(this).data('b_id');
    const b_creator = $(this).data('b_creator');
    const b_joiner = $(this).data('b_joiner');

    // Generate radio buttons for user IDs
    let radioHtml = `
        <form id="battle-complete-form" class="flex flex-col gap-2">
            <select id="users-id-select" class="w-full border-2 rounded-xl py-3 lg:py-1 outline-none px-2">
                <option value="${b_creator}">Creator (Player 1)</option>
                <option value="${b_joiner}">Joiner (Player 2)</option>
            </select>
            <button type="button" id="user-id-next-btn" class="cursor-pointer rounded-box px-3 py-3 lg:py-1.5 bg-gray-200 block">Next</button>
            <button type="button" id="cancelThisForm" class="cursor-pointer rounded-box px-3 py-1.5 bg-gray-200 absolute top-2 right-2">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </form>`;
    document.getElementById('dynamic-form-container-parent').style.display = 'flex';
    $('#dynamic-form-container').html(radioHtml);

    // Remove previous event listeners to avoid duplication
    $(document).off('click', '#cancelThisForm');
    $(document).off('click', '#user-id-next-btn');
    $(document).off('click', '#complete-submit-btn');

    // Handle the "Cancel" button click
    $(document).on('click', '#cancelThisForm', function () {
        document.getElementById('dynamic-form-container-parent').style.display = 'none';
        $('#dynamic-form-container').html('');
    });

    // Handle the "Next" button click
    $(document).on('click', '#user-id-next-btn', function () {
        $('#user-id-next-btn').hide();

        // Display select input for payment transfer decision
        const selectHtml = `
            <select id="payment-transfer-select" class="w-full my-5 border-2 rounded-xl py-3 px-2">
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
            <button type="button" id="complete-submit-btn" class="cursor-pointer rounded-box px-3 py-3 lg:py-1.5 w-full bg-gray-200">Submit</button>
        `;
        $('#dynamic-form-container').append(selectHtml);

        // Handle the "Submit" button click
        $(document).on('click', '#complete-submit-btn', function () {
            const selectedUserId = $('#users-id-select').val();
            const paymentTransfer = $('#payment-transfer-select').val();
            $.ajax({
                url: 'assets/php/battles.php',
                type: 'POST',
                data: {
                    b_id: b_id,
                    user_unique: selectedUserId,
                    transfer: paymentTransfer,
                    action: 'complete',
                    winnerId: selectedUserId // Assuming the selected user is the winner
                },
                success: function (response) {
                    console.log(response);
                    if (response.status === 'success') {
                        alert('Battle completed successfully.');
                        allBattleDetails(b_id); // Call your existing function
                    } else if (response.status === 'error') {
                        alert(response.message);
                    } else {
                        alert('Server error: Please try again later');
                    }
                },
                error: function (error) {
                    console.error('Error completing battle:', error);
                }
            });
        });
    });
});



$(document).on('click', '#delete-record-btn', function () {
    const b_id = $(this).data('b_id');
    if (confirm('Are you sure you want to delete this record?')) {
        console.log(b_id);
        $.ajax({
            url: 'assets/php/battles.php',
            type: 'POST',
            data: { b_id: b_id, action: 'delete' },
            success: function (response) {
                console.log(response);
                if (response.status === 'success') {
                    alert('Battle Record deleted successfully.');
                    document.querySelector(`#battle_id_${b_id}`).remove();
                    document.getElementById('allBattleDetailsModalButton').click();
                } else if (response.status === 'error') {
                    alert(response.message);
                } else {
                    alert('Server error: Please try again later')
                }
            },
            error: function (error) {
                console.error('Error deleting Deposit Record:', error);
            }
        });
    }
});



$(document).on('click', '#checkResult', function () {
    const b_id = $(this).data('b_id');
    const user_unique = $(this).data('user_unique');
    $.ajax({
        url: 'assets/php/battles.php',
        type: 'POST',
        data: { b_id: b_id, checkResult: 'checkResult', user_unique: user_unique },
        success: function (response) {
            console.log(response);
            if (response.status === 'success') {
                alert('Battle Completed');
            } else if (response.status === 'battleNotRunning') {
                alert('This Battle is not Running');
            } else if (response.status === 'joining') {
                alert('Users joining the Battle');
            } else if (response.status === 'playing') {
                alert('Users Playing the Battle');
            } else {
                alert(response.status)
            }
        },
        error: function (error) {
            console.error('Error Checking Room Result:', error);
        }
    });
});





function formatDateTime(date_time) {
    if (!date_time) {
        return "--";
    }

    const dateObject = new Date(date_time);

    // Check if the date is invalid
    if (isNaN(dateObject.getTime())) {
        return "--";
    }

    const now = new Date();
    const isToday = dateObject.toDateString() === now.toDateString();
    const isCurrentYear = dateObject.getFullYear() === now.getFullYear();

    const options = {
        hour: '2-digit',
        minute: '2-digit',
        hour12: true,
    };

    let formattedDate = "";

    if (!isToday) {
        const day = dateObject.getDate();
        const month = dateObject.toLocaleString('default', { month: 'short' });

        if (!isCurrentYear) {
            const year = dateObject.getFullYear();
            formattedDate = `${day} ${month} ${year}`; // Full date with year
        } else {
            formattedDate = `${day} ${month}`; // Month and day only
        }
    }

    const formattedTime = dateObject.toLocaleTimeString(undefined, options);

    return formattedDate ? `${formattedTime} - ${formattedDate}` : formattedTime;
}

function checkActionsByCreator(actionsByCreator) {
    if (actionsByCreator == 3) {
        return "Match, not Start";
    } else if (actionsByCreator == 4) {
        return "Player not Playing";
    } else if (actionsByCreator == 5) {
        return "Room Code not Working";
    } else if (actionsByCreator == 6) {
        return "Report Wrong Result";
    } else if (actionsByCreator == 0) {
        return "--";
    } else {
        return "Unknown Action";
    }
}


function updateResponseTable(result_JSON) {
    if (result_JSON == null || result_JSON === "'[]'" || result_JSON === '[]') {
        return 'No Response';
    } else {
        let tResponse;
        try {
            tResponse = JSON.parse(result_JSON);
        } catch (error) {
            $('#t_response_table_body').html('No Response');
            return;
        }

        let tableBody = '';
        for (const [key, value] of Object.entries(tResponse)) {
            if (key === 'Merchant' && typeof value === 'object') {
                for (const [merchantKey, merchantValue] of Object.entries(value)) {
                    tableBody += `<tr>
                                    <td class="border px-10 py-2 text-sm sm:text-base">Merchant ${merchantKey}</td>
                                    <td class="border px-10 py-2 text-sm sm:text-base">${merchantValue}</td>
                                  </tr>`;
                }
            } else {
                tableBody += `<tr>
                                <td class="border px-10 py-2 text-sm sm:text-base">${key}</td>
                                <td class="border px-10 py-2 text-sm sm:text-base">${value}</td>
                              </tr>`;
            }
        }
        return tableBody;
    }
}


function allBattleDetails(b_id) {
    $.ajax({
        url: 'assets/php/battles.php', // Your server-side script to get the battle details
        method: 'POST',
        data: { b_id: b_id, fetchALLDetails: 'fetchALLDetails' },
        success: function (response) {
            // console.log(response);
            const data = JSON.parse(response);
            populateBattleDetails(data);

            history.pushState({ allBattleDetailsModalOpen: true }, 'Modal', '#allBattleDetailsModal&battle=' + b_id);


            allBattleDetailsModal.showModal();
        },
        error: function () {
            alert('Failed to fetch battle details. Please try again.');
        }
    });
}

window.addEventListener('popstate', handlePopState);

function handlePopState(event) {
    console.log('run');
    if (event.state && event.state.allBattleDetailsModalOpen) {
        document.getElementById('allBattleDetailsModal').close();
        if (window.location.hash === '#modal') {
            history.back();
        }
    } else if (!event.state) {
        document.getElementById('allBattleDetailsModal').close();
    }
}



function populateBattleDetails(data) {
    let textColor = 'text-gray-400';

    if (data.b_status == 'Complete') {
        textColor = 'text-green-400';
    } else if (data.b_status == 'Cancel') {
        textColor = 'text-red-400';
    } else if (data.b_status == 'Leave') {
        textColor = 'text-amber-400';
    } else if (data.b_status == 'Active') {
        textColor = 'text-blue-400';
    } else {
        textColor = 'text-gray-400';
    }

    let content = '';


    content =
        `
     <div class="flex gap-2 items-center">
            <p class="text-sm sm:text-base text-gray-500 dark:text-gray-200">#${data.b_unique_id}</p>
            <p class="text-sm sm:text-base text-gray-500 dark:text-gray-200">-</p>
            <p class="text-sm sm:text-base text-gray-500 dark:text-gray-200">${data.b_game}</p>
            <p class="text-sm sm:text-base text-gray-500 dark:text-gray-200">-</p>
            <p class="text-sm sm:text-base text-gray-500 dark:text-gray-200">${data.b_room_code}</p>
        </div>
        <div class="w-full my-5 flex flex-col gap-5">
            <div class="grid flex-grow w-full gap-5 grid-cols-1 lg:grid-cols-3 mt-3 items-stretch">

                <div class="w-full gap-10 py-5 px-10 items-center ${((data.b_winner_id == data.b_creator_id) ? 'bg-green-50 border-green-400' : 'bg-red-50 border-red-300')} rounded-box relative border-4">
                    <a target="_blank" href="?page=allPlayers&player=${data.b_creator_id}" class="flex gap-3 items-center outline-none ${((data.b_winner_id == data.b_creator_id) ? 'bg-green-50' : 'bg-red-50')} rounded-box">
                        <div class="flex-shrink-0">
                            <img src="https://cashplay.in/assets/img/avatar/${data.creator_avatar}" class="w-10 h-10 rounded-full">
                        </div>
                        <div class="overflow-hidden">
                            <h4 class="font-semibold text-base sm:text-lg">${data.creator_name}</h4>
                            <p class="truncate text-sm sm:text-base">${data.b_creator_id}</p>
                            <p class="truncate text-sm sm:text-base text-gray-400">${data.creator_game_uid}</p>
                        </div>
                    </a>
                    <div class="card ${((data.b_winner_id == data.b_creator_id) ? 'bg-green-50' : 'hidden')} rounded-box place-items-center absolute w-6 h-6 -top-1.5 -right-1.5">
                    </div>
                    <div class="car rounded-box place-items-center absolute top-2 right-5">
                        <h3 class="text-sm text-amber-500 font-medium">Creator</h3>
                    </div>
                    <div class="card rounded-box place-items-center absolute ${((data.b_winner_id == data.b_creator_id) ? '' : 'hidden')} -top-3.5 -right-3.5">
                        <h3 class="text-2xl text-green-400 font-medium">🎉</h3>
                    </div>
                </div>


                <div class="w-full gap-10 py-5 px-10 items-center ${((data.b_winner_id == data.b_player2_id) ? 'bg-green-50 border-green-400' : 'bg-red-50 border-red-300')} rounded-box relative border-4">
                    <a target="_blank" href="?page=allPlayers&player=${data.b_player2_id}" class="flex gap-3 items-center outline-none ${((data.b_winner_id == data.b_player2_id) ? 'bg-green-50' : 'bg-red-50')} rounded-box">
                        <div class="flex-shrink-0">
                            <img src="https://cashplay.in/assets/img/avatar/${data.joiner_avatar}" class="w-10 h-10 rounded-full">
                        </div>
                        <div class="overflow-hidden">
                            <h4 class="font-semibold text-base sm:text-lg">${data.joiner_name}</h4>
                            <p class="truncate text-sm sm:text-base">${data.b_player2_id}</p>
                            <p class="truncate text-sm sm:text-base text-gray-400">${data.joiner_game_uid}</p>
                        </div>
                    </a>
                    <div class="card ${((data.b_winner_id == data.b_player2_id) ? 'bg-green-50' : 'hidden')} rounded-box place-items-center absolute w-6 h-6 -top-1.5 -right-1.5">
                    </div>
                    <div class="car rounded-box place-items-center absolute top-2 right-5">
                        <h3 class="text-sm text-blue-500 font-medium">Joiner</h3>
                    </div>
                    <div class="card rounded-box place-items-center absolute ${((data.b_winner_id == data.b_player2_id) ? '' : 'hidden')} -top-3.5 -right-3.5">
                        <h3 class="text-2xl text-green-400 font-medium">🎉</h3>
                    </div>
                </div>


                <div class="flex h-28 lg:h-full flex-grow bg-base-200 rounded-box items-center justify-center flex-col gap-4 col-span-1">
                    <h3 class="text-xl font-medium text-center whitespace-break-spaces px-5">${((data.b_winner_id == '') ? '--' : data.b_winner_id)}</h3>
                    <p class="text-xs sm:text-sm text-gray-400 font-medium">Wining Id</p>
                </div>

            </div>

            <div class="grid h-20 flex-grow w-full gap-5 grid-cols-2 lg:grid-cols-4 mt-3">
                <div class="flex h-20 flex-grow bg-base-200 rounded-box items-center justify-center flex-col gap-1 col-span-1">
                    <h3 class="text-lg font-medium ${textColor} text-green-400">${data.b_status}</h3>
                    <p class="text-xs sm:text-sm text-gray-400 font-medium">Status</p>
                </div>
                <div class="flex h-20 flex-grow bg-base-200 rounded-box items-center justify-center flex-col gap-2 col-span-1">
                    <h3 class="text-sm font-medium">${formatDateTime(data.b_created_at)}</h3>
                    <p class="text-xs sm:text-sm text-gray-400 font-medium">Room Create</p>
                </div>
                <div class="flex h-20 flex-grow bg-base-200 rounded-box items-center justify-center flex-col gap-2 col-span-1">
                    <h3 class="text-sm font-medium">${formatDateTime(data.b_joined_time)}</h3>
                    <p class="text-xs sm:text-sm text-gray-400 font-medium">Room Join</p>
                </div>
                <div class="flex h-20 flex-grow bg-base-200 rounded-box items-center justify-center flex-col gap-2 col-span-1">
                    <h3 class="text-sm font-medium">${formatDateTime(data.b_game_end)}</h3>
                    <p class="text-xs sm:text-sm text-gray-400 font-medium">Room End</p>
                </div>
            </div>


            <div class="grid flex-grow w-full gap-5 grid-cols-2 lg:grid-cols-4 mt-3">
                <div class="flex flex-grow bg-base-200 rounded-box items-center justify-center flex-col gap-1 col-span-1 py-3">
                    <div class="tooltip cursor-pointer" data-tip="Creator Old Total Balance">
                        <h3 class="text-base font-semibold tracking-wider font-sans">${parseInt(data.creator_old_total).toLocaleString('en-IN')} <span class="text-green-500">&#x20B9;</span></h3>
                    </div>
                    <div class="tooltip cursor-pointer" data-tip="Creator New Total Balance">
                        <h3 class="text-base font-semibold tracking-wider font-sans">${parseInt(data.creator_new_total).toLocaleString('en-IN')} <span class="text-green-500">&#x20B9;</span></h3>
                    </div>
                    <p class="text-xs sm:text-sm text-gray-400 font-medium whitespace-break-spaces px-5 text-center">Creator Total Balance</p>
                </div>
                <div class="flex flex-grow bg-base-200 rounded-box items-center justify-center flex-col gap-1 col-span-1 py-3">
                    <div class="tooltip cursor-pointer" data-tip="Creator Old Withdraw Balance">
                        <h3 class="text-base font-semibold tracking-wider font-sans">${parseInt(data.creator_old_withdraw).toLocaleString('en-IN')} <span class="text-green-500">&#x20B9;</span></h3>
                    </div>
                    <div class="tooltip cursor-pointer" data-tip="Creator New Withdraw Balance">
                        <h3 class="text-base font-semibold tracking-wider font-sans">${parseInt(data.creator_new_withdraw).toLocaleString('en-IN')} <span class="text-green-500">&#x20B9;</span></h3>
                    </div>
                    <p class="text-xs sm:text-sm text-gray-400 font-medium whitespace-break-spaces px-5 text-center">Creator Withdraw Balance</p>
                </div>
                <div class="flex flex-grow bg-base-200 rounded-box items-center justify-center flex-col gap-1 col-span-1 py-3">
                    <div class="tooltip cursor-pointer" data-tip="Joiner Old Total Balance">
                        <h3 class="text-base font-semibold tracking-wider font-sans">${parseInt(data.joiner_old_total).toLocaleString('en-IN')} <span class="text-green-500">&#x20B9;</span></h3>
                    </div>
                    <div class="tooltip cursor-pointer" data-tip="Joiner New Total Balance">
                        <h3 class="text-base font-semibold tracking-wider font-sans">${parseInt(data.joiner_new_total).toLocaleString('en-IN')} <span class="text-green-500">&#x20B9;</span></h3>
                    </div>
                    <p class="text-xs sm:text-sm text-gray-400 font-medium whitespace-break-spaces px-5 text-center">Joiner Total Balance</p>
                </div>
                <div class="flex flex-grow bg-base-200 rounded-box items-center justify-center flex-col gap-1 col-span-1 py-3">
                    <div class="tooltip cursor-pointer" data-tip="Joiner Old Withdraw Balance">
                        <h3 class="text-base font-semibold tracking-wider font-sans">${parseInt(data.joiner_old_withdraw).toLocaleString('en-IN')} <span class="text-green-500">&#x20B9;</span></h3>
                    </div>
                    <div class="tooltip cursor-pointer" data-tip="Joiner New Withdraw Balance">
                        <h3 class="text-base font-semibold tracking-wider font-sans">${parseInt(data.joiner_new_withdraw).toLocaleString('en-IN')} <span class="text-green-500">&#x20B9;</span></h3>
                    </div>
                    <p class="text-xs sm:text-sm text-gray-400 font-medium whitespace-break-spaces px-5 text-center">Joiner Withdraw Balance</p>
                </div>
            </div>




            <div class="grid flex-grow w-full gap-5 grid-cols-2 lg:grid-cols-4 mt-0 lg:mt-5">
                <!-- <div class="flex flex-grow bg-base-200 rounded-box items-center justify-center flex-col gap-1 col-span-1">
                    <h3 class="text-xl font-medium">Yes</h3>
                    <p class="text-xs sm:text-sm font-medium">Payment Transfer</p>
                </div> -->
                <div class="flex flex-grow bg-base-200 rounded-box items-center justify-center flex-col gap-1 col-span-1 py-4">
                ${(data.proofByCreator !== '') ? '<a href="https://cashplay.in/assets/img/proof/' + data.proofByCreator + '" target="_blank" class="w-40 h-40 object-contain overflow-scroll rounded-xl"><img src = "https://cashplay.in/assets/img/proof/' + data.proofByCreator + '" alt = "Match not Start" class="object-contain rounded-xl" ></a >' : ''}
                    <h3 class="text-base font-medium whitespace-break-spaces px-5 text-center">${checkActionsByCreator(data.actionsByCreator)}</h3>
                    <p class="text-xs sm:text-sm text-gray-400 font-medium">Creator Report</p>
                </div>
                <div class="flex flex-grow bg-base-200 rounded-box items-center justify-center flex-col gap-1 col-span-1 py-4">
                ${(data.proofByJoiner !== '') ? '<a href="https://cashplay.in/assets/img/proof/' + data.proofByJoiner + '" target="_blank" class="w-40 h-40 object-contain overflow-scroll rounded-xl"><img src = "https://cashplay.in/assets/img/proof/' + data.proofByJoiner + '" alt = "Match not Start" class="object-contain rounded-xl" ></a >' : ''}
                    <h3 class="text-base font-medium whitespace-break-spaces px-5 text-center">${checkActionsByCreator(data.actionsByJoiner)}</h3>
                    <p class="text-xs sm:text-sm text-gray-400 font-medium">Joiner Report</p>
                </div>
                <div class="flex flex-grow bg-base-200 rounded-box items-center justify-center flex-col gap-1 col-span-1 py-4">
                ${(data.creatorResultProof !== '') ? '<a href="https://cashplay.in/assets/img/proof/' + data.creatorResultProof + '" target="_blank" class="w-40 h-40 object-contain overflow-scroll rounded-xl"><img src = "https://cashplay.in/assets/img/proof/' + data.creatorResultProof + '" alt = "Match not Start" class="object-contain rounded-xl" ></a >' : ''}
                    <h3 class="text-base font-medium whitespace-break-spaces px-5 text-center">${((data.creatorResultClaim != '') ? data.creatorResultClaim : '--')}</h3>
                    <p class="text-xs sm:text-sm text-gray-400 font-medium">Creator Claim</p>
                </div>
                <div class="flex flex-grow bg-base-200 rounded-box items-center justify-center flex-col gap-1 col-span-1 py-4">
                                    ${(data.joinerResultProof !== '') ? '<a href="https://cashplay.in/assets/img/proof/' + data.joinerResultProof + '" target="_blank" class="w-40 h-40 object-contain overflow-scroll rounded-xl"><img src = "https://cashplay.in/assets/img/proof/' + data.joinerResultProof + '" alt = "Match not Start" class="object-contain rounded-xl" ></a >' : ''}
                    <h3 class="text-base font-medium whitespace-break-spaces px-5 text-center">${((data.joinerResultClaim != '') ? data.joinerResultClaim : '--')}</h3>
                    <p class="text-xs sm:text-sm text-gray-400 font-medium">Joiner Claim</p>
                </div>
            </div>



            <div id="tableOutput" class="w-full h-full max-h-56 overflow-scroll rounded-box bg-base-200">
                <table class="table table-bordered">
                    ${updateResponseTable(data.result_JSON)}
                </table>
            </div>


            <div class="grid flex-grow w-full gap-5 grid-cols-2 lg:grid-cols-4 mt-5">
                <div class="flex h-20 flex-grow bg-base-200 rounded-box items-center justify-center flex-col gap-1 col-span-1">
                    <h3 class="text-sm sm:text-xl font-medium">${data.b_price} <span class="text-green-500">&#x20B9;</span></h3>
                    <p class="text-xs sm:text-sm text-gray-400 font-medium">Battle Amount</p>
                </div>
                <div class="flex h-20 flex-grow bg-base-200 rounded-box items-center justify-center flex-col gap-1 col-span-1">
                    <h3 class="text-sm sm:text-xl font-medium">${data.b_won_amount} <span class="text-green-500">&#x20B9;</span></h3>
                    <p class="text-xs sm:text-sm text-gray-400 font-medium">Won Amount</p>
                </div>
                <div class="flex h-20 flex-grow bg-base-200 rounded-box items-center justify-center flex-col gap-1 col-span-1">
                    <h3 class="text-sm sm:text-xl font-medium">${data.b_total_commission} <span class="text-green-500">&#x20B9;</span></h3>
                    <p class="text-xs sm:text-sm text-gray-400 font-medium">Total Commission</p>
                </div>
                <div class="flex h-20 flex-grow bg-base-200 rounded-box items-center justify-center flex-col gap-1 col-span-1">
                    <h3 class="text-sm sm:text-xl font-medium">${data.b_cashplay_commission} <span class="text-green-500">&#x20B9;</span></h3>
                    <p class="text-xs sm:text-sm text-gray-400 font-medium">Cashplay Commission</p>
                </div>
            </div>
            <div class="grid lg:flex lg:justify-end flex-grow w-full gap-5 grid-cols-2 lg:grid-cols-4 mt-5 relative">
                <div>
                <button id="delete-record-btn" data-b_id="${data.b_id}" class="flex h-14 lg:h-12 border-2 w-full lg:w-fit border-red-500 text-red-500 rounded-lg shadow-xl hover:scale-95 duration-300 items-center justify-center text-xs sm:text-base font-medium px-3 sm:px-10">
                    Delete Record
                </button>
                </div>
                <div>
                <button id="complete-btn" data-b_id="${data.b_id}" data-b_creator="${data.b_creator_id}" data-b_joiner="${data.b_player2_id}"  class="flex h-14 lg:h-12 border-2 w-full lg:w-fit border-green-500 text-green-500 rounded-lg shadow-xl hover:scale-95 duration-300 items-center justify-center text-xs sm:text-base font-medium px-3 sm:px-10">
                    Complete
                </button>
                </div>
                <div>
                <button id="checkResult" data-b_id="${data.b_id}" data-user_unique="${data.b_creator_id}" class="flex h-14 lg:h-12 border-2 w-full lg:w-fit border-blue-500 text-blue-500 rounded-lg shadow-xl hover:scale-95 duration-300 items-center justify-center text-xs sm:text-base font-medium px-3 sm:px-10">
                    Refresh Result
                </button>
                </div>
                <div>
                <button id="cancel-btn" data-b_id="${data.b_id}" data-user_unique="${data.b_creator_id}" class="flex h-14 lg:h-12 border-2 w-full lg:w-fit border-red-500 text-red-500 rounded-lg shadow-xl hover:scale-95 duration-300 items-center justify-center text-xs sm:text-base font-medium px-3 sm:px-10">
                    Cancel
                </button>
                </div>
            </div>
            </div>
                 <div class="flex flex-grow w-full gap-5 justify-end">
            <div id="dynamic-form-container-parent" class="fixed top-0 left-0 w-full h-full items-center justify-center hidden z-[9999] bg-[#0000006b]">
            <div id="dynamic-form-container" class="bg-white rounded-box py-14 px-10 lg:p-10 shadow-2xl relative w-[80%] lg:w-fit"></div>
            </div>
        </div>
        <form method="dialog" onclick="history.back();" class="modal-backdrop absolute flex justify-center items-center top-3 right-3 w-10 h-10 rounded-full bg-gray-200 text-gray-600 hover:rotate-180 duration-300">
            <button class="w-10 h-10" ><i class="fa-solid fa-close text-base"></i></button>
        </form>
    `;



    $('#allBattleDetailsModalContent').html(content);
}





// For TEST MODAL
// allBattleDetails('24');