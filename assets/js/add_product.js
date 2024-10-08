document.querySelector('textarea').addEventListener('input', function () {
    this.style.height = 'auto';
    this.style.height = `${this.scrollHeight}px`;
});

const addCategory = document.getElementById('add-category');
const modal = document.getElementById('modal');
const closeModal = document.getElementById('close-modal');
const modalWrapper = document.querySelector('.modal-wrapper');

addCategory.addEventListener('click', () => {
    modal.style.opacity = '1';
    modal.style.pointerEvents = 'auto';
    modalWrapper.style.transform = 'scale(1)';
});

closeModal.addEventListener('click', () => {
    modal.style.opacity = '';
    modal.style.pointerEvents = '';
    modalWrapper.style.transform = '';
});


const productForm = document.getElementById('add-product');
const productName = document.getElementById('name');
const description = document.getElementById('description');
const category = document.getElementById('category');
const btn = document.getElementById('btn');

const reg = /^[A-Za-zА-яЁё]+$/;

function validateProductName() {
    if (reg.test(productName.value)) {
        productName.style.borderColor = '';
    } else {
        productName.style.borderColor = '#dc3545';
    }

    checkFormValidity();
}

function validateDescription() {
    if (reg.test(description.value)) {
        description.style.borderColor = '';
    } else {
        description.style.borderColor = '#dc3545';
    }

    checkFormValidity();
}

function validateCategory() {
    if (category.value !== 'all') {
        category.style.borderColor = '';
    } else {
        category.style.borderColor = '#dc3545';
    }

    checkFormValidity();
}

function checkFormValidity() {
    const productNameValid = reg.test(productName.value);
    const descriptionValid = reg.test(description.value);
    const categoryValid = category.value !== 'all';

    if (productNameValid && descriptionValid && categoryValid) {
        btn.removeAttribute('disabled');
    } else {
        btn.setAttribute('disabled', '');
    }
}

productName.addEventListener('input', validateProductName);
description.addEventListener('input', validateDescription);
category.addEventListener('change', validateCategory);

productForm.addEventListener('submit', event => {
    if (!reg.test(productName.value) || !reg.test(description.value) || category.value === 'all') {
        event.preventDefault();
    }
});

window.onload = checkFormValidity;


const modalForm = document.getElementById('modal');
const categoryName = document.getElementById('category-name');
const addCategoryBtn = document.getElementById('add-category-btn');

function validateCategoryName() {
    if (reg.test(categoryName.value)) {
        categoryName.style.borderColor = '';
    } else {
        categoryName.style.borderColor = '#dc3545';
    }

    checkFromModalValidity();
}

function checkFromModalValidity() {
    const categoryNameValid = reg.test(categoryName.value);

    if (categoryNameValid) {
        addCategoryBtn.removeAttribute('disabled');
    } else {
        addCategoryBtn.setAttribute('disabled', '');
    }
}

categoryName.addEventListener('input', validateCategoryName);

modalForm.addEventListener('submit', event => {
    if (!reg.test(categoryName.value)) {
        event.preventDefault();
    }
});

window.onload = checkFromModalValidity;