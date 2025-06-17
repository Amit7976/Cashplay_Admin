function formatDate(dateString) {
    const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

    let date = new Date(dateString);
    let day = String(date.getDate()).padStart(2, '0');
    let month = months[date.getMonth()];
    let year = date.getFullYear();

    return `${day} ${month} ${year}`;
}


function customerSupportEditShowModal(support_id) {
    console.log("run " + support_id);
    let customerSupportEdit = document.getElementById("customerSupportEdit");

    customerSupportEdit.showModal();
    history.pushState({ customerSupportEditOpen: true }, 'Modal', '#customerSupportEdit');


    $.ajax({
        url: 'assets/php/support.php',
        type: 'POST',
        data: {
            get_support_details: 'get_support_details',
            support_id: support_id,
        },
        success: function (response) {
            console.log(response);
            if (response.status === 'success') {
                let supportData = response.data;

                let supportDetailsContent = document.getElementById("supportDetailsContent");

                supportDetailsContent.innerHTML =
                    `
               <div class="flex flex-col gap-2">
                <label for="CU_name" class="flex-shrink-0 font-medium">Name:</label>
                <input type="text" id="CU_name_${supportData.CU_id}" name="CU_name" value="${supportData.CU_name}" class="input w-full border-2 border-gray-300" placeholder="Support Name">
            </div>
            <div class="flex flex-col gap-2">
                <label for="CU_description" class="flex-shrink-0 font-medium">Description:</label>
                <textarea id="CU_description_${supportData.CU_id}" name="CU_description" class="textarea w-full border-2 border-gray-300" placeholder="Something About the Support">${supportData.CU_description}</textarea>
            </div>
            <div class="flex flex-col gap-2">
                <label for="CU_icon" class="flex-shrink-0 font-medium">Icon:</label>
                <input type="text" id="CU_icon_${supportData.CU_id}" name="CU_icon" value='${supportData.CU_icon}' class="input w-full border-2 border-gray-300" placeholder="Icon of the Support">
            </div>
            <div class="flex flex-col gap-2">
                <label for="CU_link" class="flex-shrink-0 font-medium">Link:</label>
                <input type="text" id="CU_link_${supportData.CU_id}" name="CU_link" value="${supportData.CU_link}" class="input w-full border-2 border-gray-300" placeholder="Support Link">
            </div>
            <div class="flex flex-col gap-2">
                <label for="CU_link" class="flex-shrink-0 font-medium">Media:</label>
                <input type="text" id="CU_media_${supportData.CU_id}" name="CU_media" value="${supportData.CU_media}" class="input w-full border-2 border-gray-300" placeholder="Support Media">
            </div>
            <div class="flex flex-col gap-2">
                <label for="CU_status" class="flex-shrink-0 font-medium">Status:</label>
                <select id="CU_status_${supportData.CU_id}" name="CU_status" class="select w-full border-2 border-gray-300">
                    <option value="1" ${supportData.CU_status == 1 ? 'selected' : ''}>Active</option>
                    <option value="0" ${supportData.CU_status != 1 ? 'selected' : ''}>Inactive</option>
                </select>

            </div>
            <button type="button" onclick="updateSupportData('${supportData.CU_id}')" class="btn w-full mt-10">Update</button>
            <button type="button" onclick="customerSupportEditCloseModal()" class="btn w-full mt-2">Cancel</button>
                `;





            } else {
                alert('Error: ' + response.status);
            }
        }
    });
}

window.addEventListener('popstate', handlePopState);

function handlePopState(event) {
    console.log('run');
    if (event.state && event.state.customerSupportEditOpen) {
        document.getElementById('customerSupportEdit').close();
        if (window.location.hash === '#modal') {
            history.back();
        }
    } else if (!event.state) {
        document.getElementById('customerSupportEdit').close();
    }
}


function customerSupportEditCloseModal() {
    document.getElementById('customerSupportEdit').close();
}




function updateSupportData(support_id) {
    let name = document.getElementById('CU_name_' + support_id).value.trim();
    let description = document.getElementById('CU_description_' + support_id).value.trim();
    let icon = document.getElementById('CU_icon_' + support_id).value.trim();
    let link = document.getElementById('CU_link_' + support_id).value.trim();
    let media = document.getElementById('CU_media_' + support_id).value.trim();
    let status = document.getElementById('CU_status_' + support_id).value.trim();

    if (name.length > 0 && description.length > 0 && icon.length > 0) {
        $.ajax({
            url: 'assets/php/support.php', // The PHP script to handle the update
            type: 'POST',
            data: {
                update: 'update',
                CU_id: support_id,
                CU_name: name,
                CU_description: description,
                CU_icon: icon,
                CU_link: link,
                CU_media: media,
                CU_status: status
            },
            success: function (response) {
                console.log(response);
                if (response.status === 'success') {
                    alert('Data updated successfully');
                    // Optionally, you can refresh the data on the page without reloading
                    location.reload();
                } else {
                    alert('Error: ' + response.status);
                }
            },
            error: function (xhr, status, error) {
                alert('Error updating data: ' + error);
            }
        });
    } else {
        alert('Fill Complete Data');
    }
}
