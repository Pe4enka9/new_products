const form = document.querySelector('form');
const login = document.getElementById('login');
const password = document.getElementById('password');
const btn = document.getElementById('btn');

function validateLogin() {
    const reg = /^[A-Za-z]+$/;

    if (reg.test(login.value)) {
        login.style.borderColor = '';
    } else {
        login.style.borderColor = '#dc3545';
    }

    checkFormValidity();
}

function validatePassword() {
    const reg = /^[A-Za-z]+$/;

    if (reg.test(password.value)) {
        password.style.borderColor = '';
    } else {
        password.style.borderColor = '#dc3545';
    }

    checkFormValidity();
}

function checkFormValidity() {
    const reg = /^[A-Za-z]+$/;
    const loginValid = reg.test(login.value);
    const passwordValid = reg.test(password.value);

    if (loginValid && passwordValid) {
        btn.removeAttribute('disabled');
    } else {
        btn.setAttribute('disabled', '');
    }
}

login.addEventListener('input', validateLogin);
password.addEventListener('input', validatePassword);

form.addEventListener('submit', event => {
    const reg = /^[A-Za-z]+$/;

    if (!reg.test(login.value) || !reg.test(password.value)) {
        event.preventDefault();
    }
});

window.onload = checkFormValidity;