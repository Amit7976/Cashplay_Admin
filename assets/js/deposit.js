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
            url: 'assets/php/deposit.php',
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

    if (dateString === '---' || !dateString) {
        return '---';
    }
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
    const t_id = $(this).data('t_id');
    if (confirm('Confirm you want to Cancel this Deposit?')) {
        $.ajax({
            url: 'assets/php/deposit.php',
            type: 'POST',
            data: {
                t_id: t_id,
                action: 'cancel'
            },
            success: function (response) {
                console.log(response);
                if (response.status === 'success') {
                    alert('Withdrawal request cancelled successfully.');
                    fetchTransactionDetails(t_id);
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
    }
});



$(document).on('click', '#complete-btn', function () {
    const t_id = $(this).data('t_id');
    if (confirm('Confirm you want to Complete this Deposit?')) {
        $.ajax({
            url: 'assets/php/deposit.php',
            type: 'POST',
            data: {
                t_id: t_id,
                action: 'complete',
            },
            success: function (response) {
                console.log(response);
                if (response.status === 'success') {
                    alert('Withdrawal request completed successfully.');
                    fetchTransactionDetails(t_id)
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
    const t_id = $(this).data('t_id');
    if (confirm('Confirm you want to update this record?')) {
        $.ajax({
            url: 'assets/php/deposit.php',
            type: 'POST',
            data: {
                t_id: t_id,
                action: 'in_progress'
            },
            success: function (response) {
                console.log(response);
                if (response.status === 'success') {
                    alert('Withdrawal request status updated to "In Progress".');
                    fetchTransactionDetails(t_id);
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
    }
});



$(document).on('click', '#delete-record-btn', function () {
    const t_id = $(this).data('t_id');
    if (confirm('Are you sure you want to delete this record?')) {
        $.ajax({
            url: 'assets/php/deposit.php',
            type: 'POST',
            data: { t_id: t_id, action: 'delete' },
            success: function (response) {
                console.log(response);
                if (response.status === 'success') {
                    alert('Deposit Record deleted successfully.');
                    document.querySelector(`#deposit_${t_id}`).remove();
                    document.getElementById('depositDetailsModalButton').click();
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





function fetchTransactionDetails(t_id) {
    $.ajax({
        url: 'assets/php/deposit.php',
        method: 'POST',
        data: { t_id: t_id, fetchALLDetails: 'fetchALLDetails' },
        dataType: 'json',
        success: function (response) {
            if (response.error) {
                // console.error(response.error);
            } else {
                depositDetailsModal.showModal()
                history.pushState({ depositDetailsModalOpen: true }, 'Modal', '#depositDetailsModal&deposit=' + t_id);

                populateTransactionDetails(response);
            }
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
        }
    });
}
window.addEventListener('popstate', handlePopState);

function handlePopState(event) {
    console.log('run');
    if (event.state && event.state.depositDetailsModalOpen) {
        document.getElementById('depositDetailsModal').close();
        if (window.location.hash === '#modal') {
            history.back();
        }
    } else if (!event.state) {
        document.getElementById('depositDetailsModal').close();
    }
}

function populateTransactionDetails(data) {

    $('.transaction-id').text(`#${data.t_id}`);
    $('#user_details_link').attr('href', `?page=allPlayers&player=${data.t_user_unique}`);
    $('.avatar-img').attr('src', `https://cashplay.in/assets/img/avatar/${data.avatar}`);
    $('.user-name').html(`${data.user_name}<button onclick = "copyTheContent('${data.user_name}')" class= "rounded-full p-2 text-base font-semibold lg:text-xl hover:scale-110 duration-300" ><i class="fa-regular fa-copy"></i></button>`);
    $('.user-unique').html(`${data.t_user_unique} <button onclick="copyTheContent('${data.t_user_unique}')" class="rounded-full p-2 text-base font-semibold lg:text-xl hover:scale-110 duration-300"><i class="fa-regular fa-copy"></i></button>`);
    $('.status-text').text(data.t_status);
    $('.withdraw_id').text(data.t_transaction_id);
    $('.transaction_id').text(data.t_unique_id);
    $('.request-date').text(formatDate(data.t_request));
    $('.process-date').text(formatDate(data.t_process));
    $('.total-amount').html(`${data.t_amount} <span class="text-green-500">&#x20B9;</span>`);

    if (data.t_status == 'Complete') {
        $('.total-balance').html(`${parseInt(data.old_account_balance) - parseInt(data.t_amount)} <span class="text-green-500">&#x20B9;</span>`);
        $('.new_total-balance').html(`${parseInt(data.old_account_balance)} <span class="text-green-500">&#x20B9;</span>`);
    } else {
        $('.total-balance').html(`${data.old_account_balance} <span class="text-green-500">&#x20B9;</span>`);
        $('.new_total-balance').html(`${parseInt(data.old_account_balance) + parseInt(data.t_amount)} <span class="text-green-500">&#x20B9;</span>`);
    }
    $('#depositModalActionButtons').html(
        `
            <div class="col-span-1">
            <button id="delete-record-btn" data-t_id="${data.t_id}" class="flex h-14 lg:h-12 border-2 border-red-500 text-red-500 rounded-lg shadow-xl hover:scale-95 duration-300 items-center justify-center w-full lg:w-fit text-xs sm:text-base font-medium px-3 sm:px-10 py-3 col-span-1">
            Delete Record
            </button>
            </div>    
                <div class="col-span-1">
                <button id="in-progress-btn" data-t_id="${data.t_id}" class="flex h-14 lg:h-12 border-2 border-amber-500 text-amber-500 rounded-lg shadow-xl hover:scale-95 duration-300 items-center justify-center w-full lg:w-fit text-xs sm:text-base font-medium px-3 sm:px-10 py-3 col-span-1">
                In Progress
                </button>
                </div>
                <div class="col-span-1">
                <button id="complete-btn" data-t_id="${data.t_id}" class="flex h-14 lg:h-12 border-2 border-green-500 text-green-500 rounded-lg shadow-xl hover:scale-95 duration-300 items-center justify-center w-full lg:w-fit text-xs sm:text-base font-medium px-3 sm:px-10 py-3 col-span-1">
                Complete
                </button>
                </div>
                <div class="col-span-1">
                <button id="cancel-btn" data-t_id="${data.t_id}" class="flex h-14 lg:h-12 border-2 border-red-500 text-red-500 rounded-lg shadow-xl hover:scale-95 duration-300 items-center justify-center w-full lg:w-fit text-xs sm:text-base font-medium px-3 sm:px-10 py-3 col-span-1">
                Cancel
                </button>
                </div>
                `);

    // console.log(data.t_response);

    // Populate the t_response table
    // alert(data.t_response);
    if (data.t_response == null || data.t_response == "'[]'" || data.t_response == '[]') {
        $('#t_response_table_body').html('No Response');
    } else {
        let tResponse;
        try {
            tResponse = JSON.parse(data.t_response);
        } catch (error) {
            $('#t_response_table_body').html('No Response');
            return;
        }

        let tableBody = '';
        for (const [key, value] of Object.entries(tResponse)) {
            if (key === 'Merchant' && typeof value === 'object') {
                for (const [merchantKey, merchantValue] of Object.entries(value)) {
                    tableBody += `<tr>
                                <td class="border px-3 lg:px-10 py-2 text-sm sm:text-base">Merchant ${merchantKey}</td>
                                <td class="border px-3 lg:px-10 py-2 text-sm sm:text-base">${merchantValue}</td>
                              </tr>`;
                }
            } else {
                tableBody += `<tr>
                            <td class="border px-3 lg:px-10 py-2 text-sm sm:text-base">${key}</td>
                            <td class="border px-3 lg:px-10 py-2 text-sm sm:text-base">${value}</td>
                          </tr>`;
            }
        }
        $('#t_response_table_body').html(tableBody);
    }



}




// FOR MODAL TEST
// fetchTransactionDetails('161');