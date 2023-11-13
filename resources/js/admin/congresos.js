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

  const imagen = document.getElementById('imagen')

  if (imagen != undefined){
    imagen.addEventListener('change', (e) => {
      e.preventDefault()

      const selectedFile = imagen.files[0]

      if (selectedFile) {
        const imageURL = URL.createObjectURL(selectedFile)

        const editor = document.querySelector('.editor')
        let img = document.createElement("img")
        img.style.display = 'block'
        img.style.maxWidth = '100%'
        img.src = imageURL

        editor.appendChild(img)

        const cropper = new Cropper(img, {
          aspectRatio: 16 / 9,
          viewMode: 2,
          minContainerHeight: 50,
          crop(event) {
            // console.log(event.detail.x);
            // console.log(event.detail.y);
            // console.log(event.detail.width);
            // console.log(event.detail.height);
            // console.log(event.detail.rotate);
            // console.log(event.detail.scaleX);
            // console.log(event.detail.scaleY);
          },
        })
      }
      
    })
  }
})