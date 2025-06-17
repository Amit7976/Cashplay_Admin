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
            url: 'assets/php/withdraw.php',
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







function copyTheContent(text) {
    // Check if the Clipboard API is available
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(text)
            .then(function () {
                // Show a success message
                alert("Copied to clipboard: " + text);
            })
            .catch(function (error) {
                // Handle any errors
                alert("Failed to copy text: " + error);
            });
    } else {
        // Fallback for older browsers
        // Create a temporary textarea element
        var tempTextArea = document.createElement("textarea");

        // Set the value of the textarea to the text to be copied
        tempTextArea.value = text;

        // Append the textarea to the document body
        document.body.appendChild(tempTextArea);

        // Select the text inside the textarea
        tempTextArea.select();
        tempTextArea.setSelectionRange(0, 99999); // For mobile devices

        // Copy the text to the clipboard
        try {
            document.execCommand("copy");
            // Show a success message
            alert("Copied to clipboard: " + text);
        } catch (err) {
            // Handle any errors
            alert("Failed to copy text: " + err);
        }

        // Remove the textarea from the document
        document.body.removeChild(tempTextArea);
    }
}


function formatDate(dateString) {
    // Create a Date object from the input date string
    var date = new Date(dateString);

    // Define an array of month names
    var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

    // Extract the day, month, and year from the Date object
    var day = date.getDate();
    var month = months[date.getMonth()];
    var year = date.getFullYear();

    // Format the date as "DD MMM YYYY"
    var formattedDate = day.toString().padStart(2, '0') + " " + month + " " + year;

    return formattedDate;
}





$(document).on('click', '#cancel-btn', function () {
    const wr_id = $(this).data('wr-id');
    const wr_balance = $(this).data('wr-balance');
    $.ajax({
        url: 'assets/php/withdraw.php',
        type: 'POST',
        data: {
            wr_id: wr_id,
            wr_balance: wr_balance,
            action: 'cancel'
        },
        success: function (response) {
            console.log(response);
            if (response.status === 'success') {
                alert('Withdrawal request cancelled successfully.');
                withdrawRequestDataModal(wr_id);
            } else if (response.status === 'error') {
                alert(response.message);
            } else {
                alert('Server error: Please try again later')
            }
        },
        error: function (error) {
            console.error('Error cancelling withdraw request:', error);
        }
    });
});

$(document).on('click', '#complete-btn', function () {
    const wr_id = $(this).data('wr-id');
    const transaction_id = prompt('Enter Transaction ID:');
    if (transaction_id) {
        $.ajax({
            url: 'assets/php/withdraw.php',
            type: 'POST',
            data: {
                wr_id: wr_id,
                action: 'complete',
                transaction_id: transaction_id
            },
            success: function (response) {
                console.log(response);
                if (response.status === 'success') {
                    alert('Withdrawal request completed successfully.');
                    withdrawRequestDataModal(wr_id)
                } else if (response.status === 'error') {
                    alert(response.message);
                } else {
                    alert('Server error: Please try again later')
                }
            },
            error: function (error) {
                console.error('Error completing withdraw request:', error);
            }
        });
    }
});

$(document).on('click', '#in-progress-btn', function () {
    const wr_id = $(this).data('wr-id');
    $.ajax({
        url: 'assets/php/withdraw.php',
        type: 'POST',
        data: {
            wr_id: wr_id,
            action: 'in_progress'
        },
        success: function (response) {
            console.log(response);
            if (response.status === 'success') {
                alert('Withdrawal request status updated to "In Progress".');
                withdrawRequestDataModal(wr_id);
            } else if (response.status === 'error') {
                alert(response.message);
            } else {
                alert('Server error: Please try again later')
            }
        },
        error: function (error) {
            console.error('Error updating withdraw request status:', error);
        }
    });
});

$(document).on('click', '#delete-record-btn', function () {
    const wr_id = $(this).data('wr-id');
    if (confirm('Are you sure you want to delete this record?')) {
        $.ajax({
            url: 'assets/php/withdraw.php',
            type: 'POST',
            data: { wr_id: wr_id, action: 'delete' },
            success: function (response) {
                console.log(response);
                if (response.status === 'success') {
                    alert('Withdrawal request deleted successfully.');
                    document.querySelector(`#withdraw_request_${wr_id}`).remove();
                    document.getElementById('closeWithdrawModal').click();
                    document.getElementById('closeWithdrawModalButton').click();
                } else if (response.status === 'error') {
                    alert(response.message);
                } else {
                    alert('Server error: Please try again later')
                }
            },
            error: function (error) {
                console.error('Error deleting withdraw request:', error);
            }
        });
    }
});



function withdrawRequestDataModal(wr_id) {
    $.ajax({
        url: 'assets/php/withdraw.php',
        method: 'POST',
        data: { wr_id: wr_id, fetchDetails: 'fetchDetails' },
        success: function (response) {
            // Assuming the response is a JSON object
            const data = JSON.parse(response);

            // Populate the HTML with the received data
            $('#withdrawRequestDataContent').html(renderModalContent(data));

            withdrawRequestData.showModal();
            history.pushState({ withdrawRequestDataOpen: true }, 'Modal', '#withdrawRequestData&withdraw=' + wr_id);


        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
        }
    });
}

window.addEventListener('popstate', handlePopState);

function handlePopState(event) {
    console.log('run');
    if (event.state && event.state.withdrawRequestDataOpen) {
        document.getElementById('withdrawRequestData').close();
        if (window.location.hash === '#modal') {
            history.back();
        }
    } else if (!event.state) {
        document.getElementById('withdrawRequestData').close();
    }
}


function renderModalContent(data) {
    const { user_details, withdraw_request } = data;

    let methodSpecificFields = '';
    if (withdraw_request.wr_paymentMethod === 'Upi') {
        methodSpecificFields = `
            <div class="flex h-auto flex-col-reverse w-full gap-2 card bg-gray-100 p-2 py-3">
                <div class="grid h-auto flex-grow place-items-center">
                    <h3 class="text-sm text-gray-400 font-medium">UPI id</h3>
                </div>
                <div class="flex h-auto gap-3 px-2 sm:px-10 items-center justify-center flex-col sm:flex-row">
                    <p class="text-sm lg:text-base font-medium text-center">${withdraw_request.wr_upiId}</p>
                    <button onclick="copyTheContent('${withdraw_request.wr_upiId}')" class="rounded-full p-2 font-semibold lg:text-xl hover:scale-110 duration-300">
                        <i class="fa-regular fa-copy"></i> <span class="lg:hidden">Copy</span>
                    </button>
                </div>
            </div>
            <div class="flex h-auto flex-col-reverse w-full gap-2 card bg-gray-100 p-2 py-3">
                <div class="grid h-auto flex-grow place-items-center">
                    <h3 class="text-sm text-gray-400 font-medium">Account Holder Name</h3>
                </div>
                <div class="flex h-auto gap-3 px-2 sm:px-10 items-center justify-center flex-col sm:flex-row">
                    <p class="text-sm lg:text-base font-medium text-center">${withdraw_request.wr_upiAHN}</p>
                    <button onclick="copyTheContent('${withdraw_request.wr_upiAHN}')" class="rounded-full p-2 font-semibold lg:text-xl hover:scale-110 duration-300">
                        <i class="fa-regular fa-copy"></i> <span class="lg:hidden">Copy</span>
                    </button>
                </div>
            </div>
        `;
    } else if (withdraw_request.wr_paymentMethod === 'Bank') {
        methodSpecificFields = `
            <div class="flex h-auto flex-col-reverse w-full gap-2 card bg-gray-100 p-2 py-3">
                <div class="grid h-auto flex-grow place-items-center">
                    <h3 class="text-sm text-gray-400 font-medium">Bank Name</h3>
                </div>
                <div class="flex h-auto gap-3 px-2 sm:px-10 items-center justify-center flex-col sm:flex-row">
                    <p class="text-sm lg:text-base font-medium text-center">${withdraw_request.wr_bankName}</p>
                    <button onclick="copyTheContent('${withdraw_request.wr_bankName}')" class="rounded-full p-2 font-semibold lg:text-xl hover:scale-110 duration-300">
                        <i class="fa-regular fa-copy"></i> <span class="lg:hidden">Copy</span>
                    </button>
                </div>
            </div>
            <div class="flex h-auto flex-col-reverse w-full gap-2 card bg-gray-100 p-2 py-3">
                <div class="grid h-auto flex-grow place-items-center">
                    <h3 class="text-sm text-gray-400 font-medium">Account Holder Name</h3>
                </div>
                <div class="flex h-auto gap-3 px-2 sm:px-10 items-center justify-center flex-col sm:flex-row">
                    <p class="text-sm lg:text-base font-medium text-center">${withdraw_request.wr_bankAHN}</p>
                    <button onclick="copyTheContent('${withdraw_request.wr_bankAHN}')" class="rounded-full p-2 font-semibold lg:text-xl hover:scale-110 duration-300">
                        <i class="fa-regular fa-copy"></i> <span class="lg:hidden">Copy</span>
                    </button>
                </div>
            </div>
            <div class="flex h-auto flex-col-reverse w-full gap-2 card bg-gray-100 p-2 py-3">
                <div class="grid h-auto flex-grow place-items-center">
                    <h3 class="text-sm text-gray-400 font-medium">Account Number</h3>
                </div>
                <div class="flex h-auto gap-3 px-2 sm:px-10 items-center justify-center flex-col sm:flex-row">
                    <p class="text-sm lg:text-base font-medium text-center">${withdraw_request.wr_bankBAN}</p>
                    <button onclick="copyTheContent('${withdraw_request.wr_bankBAN}')" class="rounded-full p-2 font-semibold lg:text-xl hover:scale-110 duration-300">
                        <i class="fa-regular fa-copy"></i> <span class="lg:hidden">Copy</span>
                    </button>
                </div>
            </div>
            <div class="flex h-auto flex-col-reverse w-full gap-2 card bg-gray-100 p-2 py-3">
                <div class="grid h-auto flex-grow place-items-center">
                    <h3 class="text-sm text-gray-400 font-medium">IFSC Code</h3>
                </div>
                <div class="flex h-auto gap-3 px-2 sm:px-10 items-center justify-center flex-col sm:flex-row">
                    <p class="text-sm lg:text-base font-medium text-center">${withdraw_request.wr_bankIFSC}</p>
                    <button onclick="copyTheContent('${withdraw_request.wr_bankIFSC}')" class="rounded-full p-2 font-semibold lg:text-xl hover:scale-110 duration-300">
                        <i class="fa-regular fa-copy"></i> <span class="lg:hidden">Copy</span>
                    </button>
                </div>
            </div>
        `;
    } else if (withdraw_request.wr_paymentMethod === 'Wallet') {
        methodSpecificFields = `
            <div class="flex h-auto flex-col-reverse w-full gap-2 card bg-gray-100 p-2 py-3">
                <div class="grid h-auto flex-grow place-items-center">
                    <h3 class="text-sm text-gray-400 font-medium">Account Holder Name</h3>
                </div>
                <div class="flex h-auto gap-3 px-2 sm:px-10 items-center justify-center flex-col sm:flex-row">
                    <p class="text-sm lg:text-base font-medium text-center">${withdraw_request.wr_walletAHN}</p>
                    <button onclick="copyTheContent('${withdraw_request.wr_walletAHN}')" class="rounded-full p-2 font-semibold lg:text-xl hover:scale-110 duration-300">
                        <i class="fa-regular fa-copy"></i> <span class="lg:hidden">Copy</span>
                    </button>
                </div>
            </div>
            <div class="flex h-auto flex-col-reverse w-full gap-2 card bg-gray-100 p-2 py-3">
                <div class="grid h-auto flex-grow place-items-center">
                    <h3 class="text-sm text-gray-400 font-medium">Wallet Name</h3>
                </div>
                <div class="flex h-auto gap-3 px-2 sm:px-10 items-center justify-center flex-col sm:flex-row">
                    <p class="text-sm lg:text-base font-medium text-center">${withdraw_request.wr_walletApp}</p>
                    <button onclick="copyTheContent('${withdraw_request.wr_walletApp}')" class="rounded-full p-2 font-semibold lg:text-xl hover:scale-110 duration-300">
                        <i class="fa-regular fa-copy"></i> <span class="lg:hidden">Copy</span>
                    </button>
                </div>
            </div>
            <div class="flex h-auto flex-col-reverse w-full gap-2 card bg-gray-100 p-2 py-3">
                <div class="grid h-auto flex-grow place-items-center">
                    <h3 class="text-sm text-gray-400 font-medium">Wallet Number</h3>
                </div>
                <div class="flex h-auto gap-3 px-2 sm:px-10 items-center justify-center flex-col sm:flex-row">
                    <p class="text-sm lg:text-base font-medium text-center">${withdraw_request.wr_walletNumber}</p>
                    <button onclick="copyTheContent('${withdraw_request.wr_walletNumber}')" class="rounded-full p-2 font-semibold lg:text-xl hover:scale-110 duration-300">
                        <i class="fa-regular fa-copy"></i> <span class="lg:hidden">Copy</span>
                    </button>
                </div>
            </div>
            `
        if (withdraw_request.wr_walletAHE) {
            methodSpecificFields += ` <div class="flex h-auto flex-col-reverse w-full gap-2 card bg-gray-100 p-2 py-3">
                <div class="grid h-auto flex-grow place-items-center">
                    <h3 class="text-sm text-gray-400 font-medium">Account Holder Email</h3>
                </div>
                <div class="flex h-auto gap-3 px-2 sm:px-10 items-center justify-center flex-col sm:flex-row">
                    <p class="text-sm lg:text-base font-medium text-center">${withdraw_request.wr_walletAHE}</p>
                    <button onclick="copyTheContent('${withdraw_request.wr_walletAHE}')" class="rounded-full p-2 font-semibold lg:text-xl hover:scale-110 duration-300">
                        <i class="fa-regular fa-copy"></i> <span class="lg:hidden">Copy</span>
                    </button>
                </div>
            </div>
        `
        }
    }

    return `
        <div class="flex gap-2 items-center">
            <p class="text-base text-gray-500 dark:text-gray-200">#${withdraw_request.wr_id}</p>
        </div>
        <div class="w-full my-5 grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-8">
            <a target="_blank" href="?page=allPlayers&player=${data.wr_user_unique}" class="h-auto py-5 lg:py-0 lg:px-10 items-center flex flex-col lg:flex-row gap-3 rounded-box outline-none">
                <div>
                    <img src="https://cashplay.in/assets/img/avatar/${user_details.avatar}" class="w-20 h-20 lg:w-10 lg:h-10 rounded-full">
                </div>
                <div>
                    <h4 class="font-semibold text-lg text-center lg:text-start">${user_details.user_name}</h4>
                    <p class="text-center lg:text-start">${withdraw_request.wr_user_unique} <button onclick="copyTheContent('${withdraw_request.wr_user_unique}')" class="rounded-full p-2 text-base font-semibold lg:text-xl hover:scale-110 duration-300">
                            <i class="fa-regular fa-copy"></i>
                        </button></p>
                </div>
            </a>

            <div class="flex h-auto flex-col-reverse w-full gap-2 card bg-gray-100 p-2 py-3">
                <div class="grid h-auto flex-grow place-items-center">
                    <h3 class="text-sm text-gray-400 font-medium">Status</h3>
                </div>
                <div class="flex h-auto gap-3 px-2 sm:px-10 items-center justify-center flex-col sm:flex-row">
                    <p class="text-base font-medium ${(withdraw_request.wr_status == 'Review') ? 'text-amber-500' : (withdraw_request.wr_status == 'Cancel') ? 'text-red-500' : 'text-green-500'}">${withdraw_request.wr_status}</p>
                </div>
            </div>
            <div class="flex h-auto flex-col-reverse w-full gap-2 card bg-gray-100 p-2 py-3">
                <div class="grid h-auto flex-grow place-items-center">
                    <h3 class="text-sm text-gray-400 font-medium">Withdraw Id</h3>
                </div>
                <div class="flex h-auto gap-3 px-2 sm:px-10 items-center justify-center flex-col">
                    <p class="text-sm lg:text-base font-medium text-center">${withdraw_request.wr_withdrawalId}</p>
                     <button onclick="copyTheContent('${withdraw_request.wr_withdrawalId}')" class="rounded-full p-2 text-base font-semibold lg:text-xl hover:scale-110 duration-300">
                        <i class="fa-regular fa-copy"></i> <span class="lg:hidden">Copy</span>
                    </button>
                </div>
            </div>

            ${(withdraw_request.wr_transactionNumber) ?
            ` <div class="flex h-auto flex-col-reverse w-full gap-2 card bg-gray-100 p-2 py-3">
                <div class="grid h-auto flex-grow place-items-center">
                    <h3 class="text-sm text-gray-400 font-medium">Transaction Number</h3>
                </div>
                <div class="flex h-auto gap-3 px-2 sm:px-10 items-center justify-center flex-col sm:flex-row">
                    <p class="text-sm lg:text-base font-medium text-center">${withdraw_request.wr_transactionNumber}</p>
                     <button onclick="copyTheContent('${withdraw_request.wr_transactionNumber}')" class="rounded-full p-2 text-base font-semibold lg:text-xl hover:scale-110 duration-300">
                        <i class="fa-regular fa-copy"></i> <span class="lg:hidden">Copy</span>
                    </button>
                </div>
            </div>`: ''}
             
            <div class="flex h-auto flex-col-reverse w-full gap-2 card bg-gray-100 p-2 py-3">
                <div class="grid h-auto flex-grow place-items-center">
                    <h3 class="text-sm text-gray-400 font-medium">Request Date</h3>
                </div>
                <div class="flex h-auto gap-3 px-2 sm:px-10 items-center justify-center flex-col sm:flex-row">
                    <p class="text-sm lg:text-base font-medium text-center">${formatDate(withdraw_request.wr_dateAndTime)}</p>
                </div>
            </div>


            ${(withdraw_request.wr_process_date) ?
            `<div class="flex h-auto flex-col-reverse w-full gap-2 card bg-gray-100 p-2 py-3">
                <div class="grid h-auto flex-grow place-items-center">
                    <h3 class="text-sm text-gray-400 font-medium">Process Date</h3>
                </div>
                <div class="flex h-auto gap-3 px-2 sm:px-10 items-center justify-center flex-col sm:flex-row">
                    <p class="text-sm lg:text-base font-medium text-center">${formatDate(withdraw_request.wr_process_date)}</p>
                </div>
            </div>`: ''}
             
           
            <div class="flex h-auto flex-col-reverse w-full gap-2 card bg-gray-100 p-2 py-3">
                <div class="grid h-auto flex-grow place-items-center">
                    <h3 class="text-sm text-gray-400 font-medium">Method</h3>
                </div>
                <div class="flex h-auto gap-3 px-2 sm:px-10 items-center justify-center flex-col sm:flex-row">
                    <p class="text-sm lg:text-base font-medium text-center">${withdraw_request.wr_paymentMethod}</p>
                </div>
            </div>

            ${methodSpecificFields}
        </div>
        <div>
            <div class="grid flex-grow w-full gap-2 sm:gap-5 grid-cols-2 lg:grid-cols-3 my-10">
                <div class="flex h-full py-4 flex-grow bg-base-200 rounded-box items-center justify-center flex-col gap-2 col-span-1">
                    <h3 class="text-base lg:text-xl font-medium">${withdraw_request.wr_paymentAmount} <span class="text-green-500">&#x20B9;</span></h3>
                    <p class="text-xs sm:text-base text-gray-400 font-medium whitespace-break-spaces text-center px-5">Withdraw Amount</p>
                </div>
                <div class="flex h-full py-4 flex-grow bg-base-200 rounded-box items-center justify-center flex-col gap-2 col-span-1">
                    <h3 class="text-base lg:text-xl font-medium">${(parseInt(withdraw_request.wr_balance) + (withdraw_request.wr_paymentAmount))} <span class="text-green-500">&#x20B9;</span></h3>
                    <p class="text-xs sm:text-base text-gray-400 font-medium whitespace-break-spaces text-center px-5">Total Balance</p>
                </div>
                <div class="flex h-full py-4 flex-grow bg-base-200 rounded-box items-center justify-center flex-col gap-2 col-span-1">
                    <h3 class="text-base lg:text-xl font-medium">${withdraw_request.wr_balance} <span class="text-green-500">&#x20B9;</span></h3>
                    <p class="text-xs sm:text-base text-gray-400 font-medium whitespace-break-spaces text-center px-5">Remaining Balance</p>
                </div>
                <div class="flex h-full py-4 flex-grow bg-base-200 rounded-box items-center justify-center flex-col gap-2 col-span-1">
                    <h3 class="text-base lg:text-xl font-medium">${user_details.total_balance} <span class="text-green-500">&#x20B9;</span></h3>
                    <p class="text-xs sm:text-base text-gray-400 font-medium whitespace-break-spaces text-center px-5">Current Total Balance</p>
                </div>
                <div class="flex h-full py-4 flex-grow bg-base-200 rounded-box items-center justify-center flex-col gap-2 col-span-2 lg:col-span-1">
                    <h3 class="text-base lg:text-xl font-medium">${user_details.total_withdraw_balance} <span class="text-green-500">&#x20B9;</span></h3>
                    <p class="text-xs sm:text-base text-gray-400 font-medium whitespace-break-spaces text-center px-5">Current Withdraw Balance</p>
                </div>
            </div>

            <div class="grid lg:flex lg:justify-end flex-grow w-full gap-5 grid-cols-2 lg:grid-cols-4 mt-5 relative">
            <div>
            <button id="delete-record-btn" data-wr-id="${withdraw_request.wr_id}" class="flex h-14 lg:h-12 border-2 border-red-500 text-red-500 rounded-lg shadow-xl hover:scale-95 duration-300 items-center justify-center w-full lg:w-fit text-xs sm:text-base font-medium px-3 sm:px-10">
            Delete Record
            </button>
            </div>    
                <div>
                <button id="in-progress-btn" data-wr-id="${withdraw_request.wr_id}" class="flex h-14 lg:h-12 border-2 border-amber-500 text-amber-500 rounded-lg shadow-xl hover:scale-95 duration-300 items-center justify-center w-full lg:w-fit text-xs sm:text-base font-medium px-3 sm:px-10">
                In Progress
                </button>
                </div>
                <div>
                <button id="complete-btn" data-wr-id="${withdraw_request.wr_id}" class="flex h-14 lg:h-12 border-2 border-green-500 text-green-500 rounded-lg shadow-xl hover:scale-95 duration-300 items-center justify-center w-full lg:w-fit text-xs sm:text-base font-medium px-3 sm:px-10">
                Complete
                </button>
                </div>
                <div>
                <button id="cancel-btn" data-wr-id="${withdraw_request.wr_id}" data-wr-balance="${(parseInt(withdraw_request.wr_balance) + (withdraw_request.wr_paymentAmount))}" class="flex h-14 lg:h-12 border-2 border-red-500 text-red-500 rounded-lg shadow-xl hover:scale-95 duration-300 items-center justify-center w-full lg:w-fit text-xs sm:text-base font-medium px-3 sm:px-10">
                Cancel
                </button>
                </div>
            </div>
        </div>
        <form method="dialog" onclick="history.back();" id="closeWithdrawModal" class="modal-backdrop absolute flex justify-center items-center top-3 right-3 w-10 h-10 rounded-full bg-gray-200 text-gray-600 hover:rotate-180 duration-300">
            <button id="closeWithdrawModalButton" class="w-10 h-10"><i class="fa-solid fa-close text-base"></i></button>
        </form>
    `;
}






// FOR MODAL TEST
// withdrawRequestDataModal('34');