document.addEventListener('DOMContentLoaded', async function() {
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