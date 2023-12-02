document.addEventListener('DOMContentLoaded', async function() {
  const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
  const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

  const btnVer = document.querySelectorAll('.btnVer')

  if (btnVer.length > 0){
    const galleries = []

    btnVer.forEach((ver, index) => {
      const galleryContainer = document.querySelectorAll('.images')[index]
      const gallery = new Viewer(galleryContainer)

      galleries.push(gallery);

      ver.addEventListener('click', (e) => {
        e.preventDefault()
        

        // Mostrar la galería correspondiente al botón clicado
        galleries[index].show();
      })
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
  let indice = 0

  if (btnRecortar != undefined){
    btnRecortar.addEventListener('click', (e) => {
      e.preventDefault()

      // Crear un elemento input
      let inputElement = document.createElement("input")

      // Configurar los atributos del elemento input
      inputElement.type = "text"
      inputElement.className = "d-none"
      inputElement.name = `img[${indice}]`
      inputElement.value = base64Image

      contenedorInputsImg.appendChild(inputElement)

      indice++

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

  const btnRecortarEdit = document.getElementById('btnRecortarEdit')
  const rowContenedorImgCongreso = document.getElementById('rowContenedorImgCongreso')

  if (btnRecortarEdit != undefined){
    btnRecortarEdit.addEventListener('click', (e) => {
      e.preventDefault()

      let contenedor = document.createElement("div")
      contenedor.className = "contenedorImgCongreso col-sm-6 col-md-4"

      // Crear el input
      let input = document.createElement("input")
      input.type = "text"
      input.className = "d-none imgCongresoBase64"
      input.name = "img[]"
      input.value = base64Image

      // Crear la imagen
      let imagenEdit = document.createElement("img")
      imagenEdit.className = "w-100 imgCongreso"
      imagenEdit.src = base64Image

      // Crear el botón
      let boton = document.createElement("button")
      boton.type = "button"
      boton.className = "btnImgCongreso btn btn-danger btn-sm"
      boton.innerText = "x"
      boton.addEventListener("click", function() {
        // Función para eliminar el contenedor al hacer clic en el botón
        contenedor.remove()
      })

      // Agregar los elementos al contenedor
      contenedor.appendChild(input)
      contenedor.appendChild(imagenEdit)
      contenedor.appendChild(boton)

      // Agregar el contenedor al cuerpo del documento
      rowContenedorImgCongreso.appendChild(contenedor)

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

  const imgCongresoBase64 = document.querySelectorAll('.imgCongresoBase64')

  if (imgCongresoBase64.length > 0){
    imgCongresoBase64.forEach((input) => {
      const imgElement = input.parentElement.querySelector('.imgCongreso')
  
      // Convierte la imagen en base64
      const canvas = document.createElement('canvas')
      const ctx = canvas.getContext('2d')
      canvas.width = imgElement.width
      canvas.height = imgElement.height
      ctx.drawImage(imgElement, 0, 0, imgElement.width, imgElement.height)
      const imagenBase64 = canvas.toDataURL('image/png')
  
      // Asigna el valor al campo oculto
      input.value = imagenBase64
    })
  }

  const btnImgCongresos = document.querySelectorAll('.btnImgCongreso')

  if (btnImgCongresos.length > 0)
  {
    btnImgCongresos.forEach((btn) => {
      btn.addEventListener('click', function () {
        const contenedorImgCongreso = btn.closest('.contenedorImgCongreso')
  
        // Eliminar el contenedor completo al hacer clic en el botón
        contenedorImgCongreso.remove()
      })
    })
  }

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
})