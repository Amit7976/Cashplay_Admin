$(document).ready(function () {
    // Inline editing for text fields
    $('.editable-text').parent().parent().dblclick(function () {
        var currentElement = $(this).find('.editable-text');
        var currentValue = currentElement.text();

        // Create a temporary span element to measure the width of the text
        var tempSpan = $('<span>').text(currentValue).css({
            'font-size': currentElement.css('font-size'),
            'font-family': currentElement.css('font-family'),
            'visibility': 'hidden',
            'white-space': 'nowrap'
        }).appendTo('body');

        // Get the width of the text
        var textWidth = tempSpan.width();

        // Remove the temporary span element
        tempSpan.remove();

        // Create the input element with the calculated width
        var input = $('<input>', {
            value: currentValue,
            class: 'input border-2 border-gray-300',
            type: 'text',
            css: {
                width: textWidth + 100 + 'px',
                maxWidth: '16rem'
            },
            blur: function () {
                var newValue = input.val();
                var id = currentElement.data('id');
                var field = currentElement.data('field');

                // Update the text and send AJAX request to update in database
                currentElement.text(newValue);
                updateField(id, field, newValue);
            },
            keyup: function (e) {
                if (e.which === 13) input.blur();
            }
        }).appendTo(currentElement.empty()).focus();
    });


    // Inline editing for select fields
    $('.editable-select').change(function () {
        var selectElement = $(this);
        var newValue = selectElement.val();
        var id = selectElement.data('id');

        // Send AJAX request to update in database
        updateField(id, 'game_category', newValue);
    });

    // Inline editing for select fields (game status)
    $('.editable-select-status').change(function () {
        var selectElement = $(this);
        var newValue = selectElement.val();
        var id = selectElement.data('id');

        // Send AJAX request to update in database
        updateField(id, 'game_status', newValue);
    });

    // Inline editing for image
    $('.editable-image').dblclick(function () {
        var imageElement = $(this);
        var id = imageElement.data('id');
        var inputFile = $('<input>', {
            type: 'file',
            change: function () {
                console.log("File input change detected.");
                var file = this.files[0];
                if (!file) {
                    console.error("No file selected.");
                    return;
                }
                console.log("Selected file:", file);

                var formData = new FormData();
                formData.append('updateImage', 'updateImage');
                formData.append('image', file);
                formData.append('id', id);
                console.log([...formData.entries()]);


                // AJAX request to upload the new image
                $.ajax({
                    url: 'assets/php/games.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        console.log("AJAX request successful.");
                        console.log("Response:", response);
                        if (response.status === 'success') {
                            console.log("Image updated successfully.");
                            imageElement.attr('src', response.new_image_url);
                        } else {
                            console.error("Failed to upload image.");
                            alert('Failed to upload image.');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX request failed.');
                        console.error('Error:', error);
                    }
                });
            }

        }).click();
    });

    function updateField(id, field, value) {
        $.ajax({
            url: 'assets/php/games.php',
            type: 'POST',
            data: {
                updateFields: 'updateFields',
                id: id,
                field: field,
                value: value
            },
            success: function (response) {
                console.log(response);
                if (response.status === 'success') {
                    console.log('Field updated successfully.');
                } else {
                    alert('Failed to update field.');
                }
            }
        });
    }
});
