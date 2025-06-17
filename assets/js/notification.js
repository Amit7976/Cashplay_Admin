let existingNotification = null;
localStorage.removeItem('activeNotification');

function checkTransactions() {
    // console.log('Checking transactions...');

    // Check if the withdraw page is focused
    if (localStorage.getItem('withdrawPageFocus') === 'true') {
        console.log('Withdraw page is focused, skipping notifications.');
        return;
    }

    $.ajax({
        url: 'assets/php/check_transactions.php',
        type: 'GET',
        success: function (response) {
            // console.log('Response:', response);
            if (response.status === 'found') {
                document.getElementById('notification').innerText = 'Withdrawal Requested by User';
                document.getElementById('notification').classList.remove('hidden');

                // Check for notification permission
                if (Notification.permission === 'granted') {
                    // Check if there is an active notification
                    if (!localStorage.getItem('activeNotification')) {
                        showNotification();
                    }
                } else if (Notification.permission !== 'denied') {
                    // Request permission
                    Notification.requestPermission().then(function (permission) {
                        if (permission === 'granted') {
                            if (!localStorage.getItem('activeNotification')) {
                                showNotification();
                            }
                        }
                    });
                }
            } else {
                document.getElementById('notification').classList.add('hidden');
                if (existingNotification) {
                    existingNotification.close();
                    existingNotification = null;
                    localStorage.removeItem('activeNotification');
                }
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error('Error checking transactions:', textStatus, errorThrown);
        }
    });
}

function showNotification() {
    // console.log('Showing notification...');
    const options = {
        body: 'Check out this withdrawal request as soon as possible.',
        icon: 'https://cashplay.in/assets/img/favicon_io/android-chrome-512x512.png'
    };
    existingNotification = new Notification('New Withdrawal Request', options);

    // Set the active notification flag
    localStorage.setItem('activeNotification', 'sent');

    // Optional: Add event listener for notification click
    existingNotification.onclick = function (event) {
        event.preventDefault(); // Prevent the browser from focusing the Notification's tab
        // console.log('Notification clicked');

        // Clear the active notification flag
        localStorage.removeItem('activeNotification');
        existingNotification.close();
        existingNotification = null;

        window.open('http://localhost/?page=withdraw');
    };

    // When the notification is closed, clear the reference and the flag
    existingNotification.onclose = function () {
        // console.log('Notification closed');
        localStorage.removeItem('activeNotification');
        existingNotification = null;
    };

    // Add a timeout to clear the notification after 10 seconds
    setTimeout(function () {
        if (existingNotification) {
            // console.log('Clearing notification after timeout');
            localStorage.removeItem('activeNotification');
            existingNotification.close();
            existingNotification = null;
        }
    }, 10000); // 10 seconds
}


if (document.getElementById('notification')) {
    // console.log('Notification element found, starting checkTransactions...');
    checkTransactions(); // Initial call
    setInterval(checkTransactions, 10000); // Repeat every 5 seconds
}

// Ensure that the script requests permission when the page loads
console.log('Notification permission: ' + Notification.permission);
if (Notification.permission !== 'granted' && Notification.permission !== 'denied') {
    // console.log('Requesting notification permission...');
    Notification.requestPermission();
} else if (Notification.permission === 'denied') {
    // console.log('Requesting notification permission...');
    Notification.requestPermission();
}

// Add visibility change event listener
document.addEventListener('visibilitychange', function () {
    if (document.visibilityState === 'visible' && localStorage.getItem('withdrawPageFocus') === 'true') {
        // Clear existing notification if the user navigates back to the withdraw page
        if (existingNotification) {
            // console.log('Clearing existing notification as withdraw page is in focus');
            localStorage.removeItem('activeNotification');
            existingNotification.close();
            existingNotification = null;
        }
    }
});
