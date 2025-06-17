// Players
// document.getElementById('sideBarPlayersDropdownContent').style.marginTop = "-200%";
// document.getElementById('sideBarPlayersDropdownOpen').addEventListener('click', () => {
//     if (document.getElementById('sideBarPlayersDropdownContent').style.marginTop === "-200%") {
//         document.getElementById('sideBarPlayersDropdownContent').style.marginTop = "0%";
//     } else {
//         document.getElementById('sideBarPlayersDropdownContent').style.marginTop = "-200%";
//     }
// })



// Payments
// document.getElementById('sideBarPaymentsDropdownContent').style.marginTop = "-200%";
// document.getElementById('sideBarPaymentsDropdownOpen').addEventListener('click', () => {
//     if (document.getElementById('sideBarPaymentsDropdownContent').style.marginTop === "-200%") {
//         document.getElementById('sideBarPaymentsDropdownContent').style.marginTop = "0%";
//     } else {
//         document.getElementById('sideBarPaymentsDropdownContent').style.marginTop = "-200%";
//     }
// })



// Battle
// document.getElementById('sideBarBattleDropdownContent').style.marginTop = "-200%";
// document.getElementById('sideBarBattleDropdownOpen').addEventListener('click', () => {
//     if (document.getElementById('sideBarBattleDropdownContent').style.marginTop === "-200%") {
//         document.getElementById('sideBarBattleDropdownContent').style.marginTop = "0%";
//     } else {
//         document.getElementById('sideBarBattleDropdownContent').style.marginTop = "-200%";
//     }
// })




// Settings
// document.getElementById('sideBarSettingsDropdownContent').style.marginTop = "-200%";
// document.getElementById('sideBarSettingsDropdownOpen').addEventListener('click', () => {
//     if (document.getElementById('sideBarSettingsDropdownContent').style.marginTop === "-200%") {
//         document.getElementById('sideBarSettingsDropdownContent').style.marginTop = "0%";
//     } else {
//         document.getElementById('sideBarSettingsDropdownContent').style.marginTop = "-200%";
//     }
// })










// TOGGLE SIDE BAR
function toggleSideBar() {
    const sideBar = document.getElementById('sideBarToggle');
    const topBar = document.getElementById('topBarToggle');

    if (sideBar.style.left === '0%') {
        sideBar.style.left = '-100%';
    } else {
        sideBar.style.left = '0%';
    }
}

document.getElementById('sideBarToggle').addEventListener('click', toggleSideBar);

