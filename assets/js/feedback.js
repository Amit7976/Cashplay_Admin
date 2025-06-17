let start = 0;
const limit = 20;

function fetchNextRecords() {
    console.log("amit   1");
    start += limit;
    $.ajax({
        url: '/pages/feedback_scroll.php',
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
                $('#userFeedbacksTable').append(response);
            }
            $('#loadMoreButton').text('Load More');
        }
    });
}


$('#loadMoreButton').click(function () {
    fetchNextRecords();
    $('#loadMoreButton').text('Loading');
});




function deleteRating(f_id) {
    console.log('Delete recored');
    $.ajax({
        url: 'assets/php/feedback.php',
        type: 'POST',
        data: {
            deleteRating: 'deleteRating',
            feedback_id: f_id,
        },
        success: function (response) {
            console.log(response);
            if (response.status === 'success') {
                console.log("deletd");

                let feedback = document.getElementById("feedback_" + f_id)

                feedback.remove();


            } else {
                alert('Error: ' + response.status);
            }
        },
        error: function (xhr, status, error) {
            console.error('Error:', response);
        }
    });

}