document.addEventListener('DOMContentLoaded', async function() {
  const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
  const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

  let tablaOrganizaciones = document.getElementById('tablaOrganizaciones')

  new DataTable(tablaOrganizaciones, {
    scrollX: true,
    language: {
      "search": "Buscar",
      "lengthMenu": "Mostrar _MENU_ filas",
      "info": "Mostrando página _PAGE_ de _PAGES_",
      "paginate": {
        previous: "Anterior",
        next: "Siguiente",
        first: "Primero",
        last: "Último"
      }
    }
  })
})