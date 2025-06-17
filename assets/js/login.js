
///////////////PASSWORD/////////////////
function loginPass() {
    let user_pin = document.getElementById('pin');
    if (user_pin.value.length != 6) {
        user_pin.style.borderColor = "red";
    } else {
        user_pin.style.borderColor = "#00d300";
    }
}

///////////////////////////// ONLY INPUT NUMBER //////////////
function onlyNumberKey(a) {
    let b = a.which ? a.which : a.keyCode;
    return !(b > 31) || (!(b < 48) && !(b > 57));
}
///////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////
////////////////////////////////// LOGIN /////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////
// let userEmail = '';
function loginFormSubmit() {
    let number = document.getElementById("number");
    let user_pin = document.getElementById("pin");

    console.log(number);
    console.log(number.value);
    console.log(user_pin.value.length >= 6);
    console.log(
        number.value.length == 10 && user_pin.value.length == 6
    );

    if (number.value.length == 10 && user_pin.value.length == 6) {
        $.ajax({
            type: "POST",
            url: "../assets/php/login.php",
            data: {
                forLogin: 'forLogin',
                phone_number: number.value,
                login_pass: user_pin.value,
            },
            success: function (response) {
                console.log(response);
                const data = JSON.parse(response);

                if (data.status === "loginSuccess") {
                    alert('Login Success');
                    console.log("hi");
                    setTimeout(() => {
                        location.assign("/");
                    }, 1000);

                } else if (data.status === "Already_Login") {
                    alert('Login Success');
                    console.log("You are already Logged in");
                    setTimeout(() => {
                        location.assign("/");
                    }, 1000);
                } else {
                    number.style.borderColor = "red";
                    user_pin.style.borderColor = "red";

                    number.addEventListener("keypress", () => {
                        if (number.value.length >= 10) {
                            number.style.borderColor = "#00d300";
                        }
                    });
                    user_pin.addEventListener("keypress", () => {
                        if (user_pin.value.length >= 6) {
                            user_pin.style.borderColor = "#00d300";
                        }
                    });
                    alert('Login Fail: Invalid Number and Password');
                }
            },
        });
    } else {
        if (number.value.length < 10) {
            number.style.borderColor = "red";
        }
        if (user_pin.value.length < 6) {
            user_pin.style.borderColor = "red";
        }
        number.addEventListener("keypress", () => {
            if (number.value.length >= 10) {
                number.style.borderColor = "lightGray";
            }
        });
        user_pin.addEventListener("keypress", () => {
            if (user_pin.value.length >= 6) {
                user_pin.style.borderColor = "lightGray";
            }
        });
        alert('FILL CORRECT INFORMATION');
    }
}

document
    .getElementById("number")
    .addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
            loginFormSubmit();
        }
    });
document
    .getElementById("pin")
    .addEventListener("keypress", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
            loginFormSubmit();
        }
    });
