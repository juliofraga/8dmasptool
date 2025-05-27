export const API_URL = 'http://localhost:8000';

export function closeModal(modal) {
    $('#' + modal).modal('hide')
};

export function showModal(modal) {
    $('#' + modal).modal('show')
};

export function fieldsValidate(fields, obj) {
    let isValid = true;

    fields.forEach(field => {
        const element = document.getElementById(field);
        const value = obj[field];
        if (!value || String(value).trim() === '') {
            element.classList.add('is-invalid');
            isValid = false;
        } else if (element.classList.contains('is-invalid')) {
            element.classList.remove('is-invalid');
        }
    });
    goToTop();
    return isValid;
};

export function returnCurrentDate() {
    const today = new Date();
    const year = today.getFullYear();
    const month = String(today.getMonth() + 1).padStart(2, '0');
    const day = String(today.getDate()).padStart(2, '0');
    const currentDate = `${year}-${month}-${day}`;
    return currentDate;
}

export function goToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

export function clearInvalidFeedback(id, value) {
    if (value) {
        if (document.getElementById(id).classList.contains('is-invalid')) {
            document.getElementById(id).classList.remove('is-invalid');
        }
    }
}

export function clearFeedbackMessage(obj, time = 5000) {
    setTimeout(() => {
        obj.status = '';
        obj.feedbackTitle = '';
        obj.feedbackMessage = '';
    }, time);
}

export function makeFieldsDisabled(fields) {
    fields.forEach(field => {
        document.getElementById(field).disabled = true;
    });
}