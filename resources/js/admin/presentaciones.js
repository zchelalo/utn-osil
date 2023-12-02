document.addEventListener('DOMContentLoaded', async function() {
  const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
  const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

  const btnVer = document.querySelectorAll('.btnVer')

  if (btnVer.length > 0){
    const galleries = []

    btnVer.forEach((ver, index) => {
      const galleryContainer = document.querySelectorAll('.images')[index]
      const gallery = new Viewer(galleryContainer, {
        toolbar: {
          zoomIn: 4,
          zoomOut: 4,
          oneToOne: 4,
          reset: 4,
          prev: 0,
          play: {
            show: 4,
            size: 'large',
          },
          next: 0,
          rotateLeft: 4,
          rotateRight: 4,
          flipHorizontal: 4,
          flipVertical: 4
        }
      })

      galleries.push(gallery);

      ver.addEventListener('click', (e) => {
        e.preventDefault()

        // Mostrar la galería correspondiente al botón clicado
        galleries[index].show();
      })
    })
  }

  const presentacion = document.getElementById('presentacion')
  if (presentacion != undefined){
    presentacion.addEventListener('change', (e) => {
      const selectedFile = presentacion.files[0]

      if (selectedFile) {
        // Validar el tipo de archivo permitido
        const allowedTypes = ['application/pdf'];
        if (!allowedTypes.includes(selectedFile.type)) {

          Swal.fire({
            text: "Solo se permiten archivos PDF",
            icon: "error",
            confirmButtonText: 'Cerrar',
            confirmButtonColor: '#218c74'
          })

          // Verificar si el input de imagen existe
          if (presentacion) {
            // Limpiar el valor del input de imagen
            presentacion.value = '';
          }

          return
        }
        
        // Obtener el peso de la imagen en kilobytes
        const pesoEnMegabytes = selectedFile.size / (1024 * 1024)
        if (pesoEnMegabytes > 10)
        {
          Swal.fire({
            text: "La presentación no puede pesar mas de 10MB",
            icon: "error",
            confirmButtonText: 'Cerrar',
            confirmButtonColor: '#218c74'
          })

          // Verificar si el input de imagen existe
          if (presentacion) {
            // Limpiar el valor del input de imagen
            presentacion.value = '';
          }

          return
        }
      }
    })
  }

  const imagen = document.getElementById('imagen')

  let base64Image
  let cropperInstance

  let toastPregunta = document.getElementById('toastPregunta')
  let toast = new bootstrap.Toast(toastPregunta)

  if (imagen != undefined){
    imagen.addEventListener('change', (e) => {
      e.preventDefault()

      if (document.querySelector('.editor') != undefined){
        document.querySelector('.editor').innerHTML = ''
      }

      const selectedFile = imagen.files[0]
      
      if (selectedFile) {
        // Validar el tipo de archivo permitido
        const allowedTypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif'];
        if (!allowedTypes.includes(selectedFile.type)) {

          Swal.fire({
            text: "Solo se permiten archivos JPEG, JPG, PNG o GIF",
            icon: "error",
            confirmButtonText: 'Cerrar',
            confirmButtonColor: '#218c74'
          })

          // Verificar si el input de imagen existe
          if (imagen) {
            // Limpiar el valor del input de imagen
            imagen.value = '';
          }

          return
        }
        
        // Obtener el peso de la imagen en kilobytes
        const pesoEnMegabytes = selectedFile.size / (1024 * 1024)
        if (pesoEnMegabytes > 5)
        {
          Swal.fire({
            text: "La imagen no puede pesar mas de 5MB",
            icon: "error",
            confirmButtonText: 'Cerrar',
            confirmButtonColor: '#218c74'
          })

          // Verificar si el input de imagen existe
          if (imagen) {
            // Limpiar el valor del input de imagen
            imagen.value = '';
          }

          return
        }

        const imageURL = URL.createObjectURL(selectedFile)

        const editor = document.querySelector('.editor')
        let img = document.createElement("img")
        img.style.display = 'block'
        img.style.maxWidth = '100%'
        img.id = 'imgRecortada'
        img.src = imageURL

        editor.appendChild(img)

        cropperInstance = new Cropper(img, {
          aspectRatio: 16 / 7,
          viewMode: 2,
          background: true,
          cropend(event) {
            // Obtener el contenido en base64 después de recortar la imagen
            base64Image = cropperInstance.getCroppedCanvas().toDataURL(selectedFile.type)

            // Mostrar el toast después de recortar
            toast.show()
          },
        })
      }
    })
  }

  const btnRecortar = document.getElementById('btnRecortar')
  const contenedorInputsImg = document.getElementById('contenedorInputsImg')

  if (btnRecortar != undefined){
    btnRecortar.addEventListener('click', (e) => {
      e.preventDefault()

      // Crear un elemento input
      let inputElement = document.createElement("input")

      // Configurar los atributos del elemento input
      inputElement.type = "text"
      inputElement.className = "d-none"
      inputElement.name = `img`
      inputElement.value = base64Image

      contenedorInputsImg.appendChild(inputElement)

      if (cropperInstance) {
        cropperInstance.destroy()
      }

      let imgRecortada = document.getElementById('imgRecortada')
      // Verificar si el elemento de imagen existe y tiene un padre
      if (imgRecortada && imgRecortada.parentNode) {
        // Obtener el nodo padre (elemento contenedor) del elemento de imagen
        const contenedor = imgRecortada.parentNode

        // Eliminar el elemento de imagen del DOM al llamar al método removeChild en el nodo padre
        contenedor.removeChild(imgRecortada)
      }

      // Verificar si el input de imagen existe
      if (imagen) {
        // Limpiar el valor del input de imagen
        imagen.value = '';
      }

      toast.hide()

      Swal.fire({
        title: "¡Imagen agregada correctamente!",
        text: "Si desea agregar otra imagen puede hacerlo",
        icon: "success",
        confirmButtonText: 'Cerrar',
        confirmButtonColor: '#218c74'
      })
    })
  }

  const btnQuitarPresentacion = document.getElementById('btnQuitarPresentacion')

  if (btnQuitarPresentacion != undefined){
    btnQuitarPresentacion.addEventListener('click', (e) => {
      e.preventDefault()

      Swal.fire({
        text: "¿Seguro que quiere eliminar la presentación?",
        icon: "info",
        confirmButtonText: 'Eliminar',
        confirmButtonColor: '#e74c3c',
        showDenyButton: true,
        denyButtonText: `No eliminar`,
        denyButtonColor: '#218c74'
      }).then((result) => {
        if (result.isConfirmed){

          document.getElementById('eliminarRuta').click()
        }
      })
    })
  }

  let tablaPresentaciones = document.getElementById('tablaPresentaciones')

  new DataTable(tablaPresentaciones, {
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