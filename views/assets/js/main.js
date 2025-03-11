document.getElementById('form-publicar').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Obtener datos del formulario
    const titulo = document.getElementById('titulo').value;
    const descripcion = document.getElementById('descripcion').value;
    const salario = document.getElementById('salario').value;
    const contacto = document.getElementById('contacto').value;

    // Crear una nueva tarjeta
    const tarjeta = document.createElement('div');
    tarjeta.classList.add('tarjeta');
    tarjeta.innerHTML = `
        <h3>${titulo}</h3>
        <p>${descripcion}</p>
        <p><strong>Salario:</strong> $${salario}</p>
        <p><strong>Contacto:</strong> ${contacto}</p>
    `;

    // Añadir la tarjeta a la lista
    document.getElementById('lista-trabajos').appendChild(tarjeta);

    // Limpiar el formulario
    document.getElementById('form-publicar').reset();
});


// Filtrar trabajos por categoría
document.getElementById('categoria').addEventListener('change', function () {
    const selectedCategory = this.value;
    const jobs = document.querySelectorAll('.col.mb-5');

    jobs.forEach(job => {
        const jobCategory = job.getAttribute('data-category');
        if (selectedCategory === 'todos' || jobCategory === selectedCategory) {
            job.style.display = 'block';
        } else {
            job.style.display = 'none';
        }
    });
});
