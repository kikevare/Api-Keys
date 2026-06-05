const btnGenerar = document.getElementById('btnGenerar');
const btnValidar = document.getElementById('btnValidar');
const inputValidar = document.getElementById('inputValidar');

const modal = document.getElementById('modal');
const modalBody = document.getElementById('modalBody');
const cerrarModal = document.getElementById('cerrarModal');

function abrirModal(html) {
    modalBody.innerHTML = html;
    modal.style.display = "block";
}

cerrarModal.onclick = () => modal.style.display = "none";
window.onclick = e => { if (e.target === modal) modal.style.display = "none"; };

btnGenerar.addEventListener('click', async () => {
    const res = await fetch('/generate');
    const data = await res.json();

    abrirModal(`
        <h2>Nueva API Key generada</h2>
        <p><strong>${data.api_key}</strong></p>
    `);
});
btnValidar.addEventListener('click', async () => {
    const key = inputValidar.value.trim();

    if (!key) {
        abrirModal("<p>⚠ Debes ingresar una API Key</p>");
        return;
    }

    const res = await fetch(`/validate?key=${key}`);
    const data = await res.json();

    abrirModal(`
        <h2>Resultado de validación</h2>
        <p>${data.valid ? "La API Key es válida" : "La API Key ingresada es inválida o ha sido revocada"}</p>
    `);
});
const listaKeys = document.getElementById('lista');

async function cargarKeys() {
    const res = await fetch('/keys');
    const data = await res.json();

    listaKeys.innerHTML = "";

    data.forEach(key => {
        const fila = document.createElement('section');
        fila.classList.add('resultados__fila');
        fila.setAttribute('data-id', key.id);

        fila.innerHTML = `
            <div>${key.api_key}</div>
            <div>${key.is_revoked ? "Revocada" : "Activa"}</div>
            <div>
                ${key.is_revoked 
                    ? "-" 
                    : `<button class="btnRevocar" data-id="${key.id}">Revocar</button>`
                }
            </div>
        `;

        listaKeys.appendChild(fila);
    });

    activarBotonesRevocar();
}

function activarBotonesRevocar() {
    const botones = document.querySelectorAll('.btnRevocar');

    botones.forEach(btn => {
        btn.addEventListener('click', async () => {
            const id = btn.getAttribute('data-id');
            await fetch(`/revoke/${id}`);
            const fila = document.querySelector(`.resultados__fila[data-id="${id}"]`);
            if (fila) fila.remove();
        });
    });
}
cargarKeys();

