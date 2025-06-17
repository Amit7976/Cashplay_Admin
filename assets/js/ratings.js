let start = 0;
const limit = 20;

function fetchNextRecords() {
    console.log("amit   1");
    start += limit;
    $.ajax({
        url: '/pages/ratings_scroll.php',
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
                $('#userRatingsTable').append(response);
            }
            $('#loadMoreButton').text('Load More');
        }
    });
}


$('#loadMoreButton').click(function () {
    fetchNextRecords();
    $('#loadMoreButton').text('Loading');
});



function visibilityControl(userUnique) {
    console.log('visibilityControl start');
    console.log(userUnique);
    $.ajax({
        url: 'assets/php/ratings.php',
        type: 'POST',
        data: {
            visibilityControl: 'visibilityControl',
            user_unique: userUnique,
        },
        success: function (response) {
            // console.log(response);
            // console.log(response.status);
            if (response.status === 'success') {

                let visibilityShow = document.getElementById('visibility_show_' + userUnique);
                let visibilityButton = document.getElementById('visibility_button_' + userUnique);

                if (response.ar_status === 1) {
                    visibilityButton.innerHTML = 'Unpublish';
                    visibilityShow.innerHTML =
                        `<span class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-teal-100 text-teal-800 rounded-full dark:bg-teal-500/10 dark:text-teal-500">
                                                            <i class="fa-solid fa-check"></i> Published
                                                        </span>`;
                } else {
                    visibilityButton.innerHTML = 'Publish';
                    visibilityShow.innerHTML =
                        `<span class="py-1 px-2 inline-flex items-center gap-x-1 text-xs font-medium bg-red-100 text-red-800 rounded-full dark:bg-red-500/10 dark:text-red-500">
                                                            <i class="fa-solid fa-xmark"></i> Unpublish
                                                        </span>`;
                }




            } else {
                console.error('Error:', response);
            }
        },
        error: function (xhr, status, error) {
            console.error('Error:', response);
        }
    });
}


function deleteRating(userUnique) {
    console.log('Delete recored');
    $.ajax({
        url: 'assets/php/ratings.php',
        type: 'POST',
        data: {
            deleteRating: 'deleteRating',
            user_unique: userUnique,
        },
        success: function (response) {
            console.log(response);
            if (response.status === 'success') {
                console.log("deletd");

                let rating = document.getElementById("ratings_" + userUnique)

                rating.remove();


            } else {
                alert('Error: ' + response.status);
            }
        },
        error: function (xhr, status, error) {
            console.error('Error:', response);
        }
    });

}