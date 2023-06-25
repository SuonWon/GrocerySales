const submitBtn = document.querySelector("#loginSubmit");
const loginForm = document.querySelector("#loginForm");

const loginUserName = document.querySelector("#loginUserName");
const loginPassword = document.querySelector("#loginPassword");
const rememberChk = document.querySelector("#rememberChk");
const invalidUserName = document.querySelector(".invalid-userName");
const invalidPassword = document.querySelector(".invalid-password");

loginUserName.addEventListener("blur", BlankValidationUserName);
loginPassword.addEventListener("blur", BlankValidationPassword);

function BlankValidationUserName() {
    if (loginUserName.value) {
        invalidUserName.style.display = "none";
    } else {
        invalidUserName.style.display = "block";
    }
}

function BlankValidationPassword() {
    if (loginPassword.value) {
        invalidPassword.style.display = "none";
    } else {
        invalidPassword.style.display = "block";
    }
}

submitBtn.addEventListener("click", CheckLoginForm);
function CheckLoginForm(event) {
    event.preventDefault();

    if (loginUserName.value && loginPassword.value) {
        loginForm.submit();
    }
}

const UpdateYear = new Date().getFullYear();
document.querySelector("#UpdateYear").innerHTML = UpdateYear;
