export const API_URL = 'http://localhost:8000';

export function closeModal(modal) {
    $('#' + modal).modal('hide')
};

export function showModal(modal) {
    $('#' + modal).modal('show')
};

export function fieldsValidate(campos, obj) {
    let isValid = true;

    campos.forEach(campo => {
        const elemento = document.getElementById(campo);
        const valor = obj[campo];
        if (!valor || String(valor).trim() === '') {
            elemento.classList.add('is-invalid');
            isValid = false;
        } else if (elemento.classList.contains('is-invalid')) {
            elemento.classList.remove('is-invalid');
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