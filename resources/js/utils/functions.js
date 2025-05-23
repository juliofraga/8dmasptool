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
    return isValid;
};