document.addEventListener('DOMContentLoaded', async function() {
  const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
  const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

  let tablaCongresos = document.getElementById('tablaCongresos')

  new DataTable(tablaCongresos, {
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

  const btnVer = document.getElementById('btnVer')

  if (btnVer != undefined){

    const gallery = new Viewer(document.getElementById('images'))

    btnVer.addEventListener('click', (e) =>{
      e.preventDefault()

      gallery.show()
    })

  }
})