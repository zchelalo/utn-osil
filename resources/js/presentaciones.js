document.addEventListener('DOMContentLoaded', function() {
  const urlHost = document.getElementById('urlHost').value

  let idTipo = ''
  let busqueda = ''

  const tipoPresentacionesLinks = document.querySelectorAll('.tipoPresentaciones')
  const buscador = document.getElementById('buscador')
  
  let articulosPresentaciones = document.getElementById('articulosDePresentaciones')

  async function obtenerDatos(filtros = '') {
    try {
      const opciones = {
        method: 'GET', // método HTTP, por ejemplo, 'GET' o 'POST'
        headers: {
          'Content-Type': 'application/json', // tipo de contenido esperado en la respuesta
          // Otras cabeceras según sea necesario
        },
        // Puedes incluir 'body' si estás haciendo una solicitud POST o PUT
        // body: JSON.stringify({ key: 'valor' }),
      }
  
      const response = await fetch(`${urlHost}/api/presentaciones${filtros}`, opciones)
  
      if (!response.ok) {
        throw new Error(`Error de red - Código: ${response.status}`)
      }
  
      const data = await response.json()
  
      // Manipular los datos recibidos
      const tl = gsap.timeline({
        onComplete: () => {
          articulosPresentaciones.innerHTML = ''
  
          Object.keys(data).forEach(key => {
            const presentacion = data[key];
  
            // Crea un elemento de artículo
            let article = document.createElement('article')
            article.className = 'card text-center mb-4'
  
            // Crea el encabezado de la tarjeta
            let cardHeader = document.createElement('div')
            cardHeader.className = 'card-header bgColor'
            cardHeader.innerHTML = `<span>${presentacion[0].presentaciones.nombre}</span>`
            article.appendChild(cardHeader)
  
            // Crea el cuerpo de la tarjeta
            let bodyCardPresentaciones = document.createElement('div')
            bodyCardPresentaciones.className = 'bodyCardPresentaciones card-body d-flex justify-content-center align-items-center p-2'
  
            // Crea el contenedor de información de presentaciones
            let contenedorInfoPresentaciones = document.createElement('div')
            contenedorInfoPresentaciones.className = 'contenedorInfoPresentaciones col-lg-8 p-3'
            contenedorInfoPresentaciones.innerHTML = `
              <p class="card-text">${presentacion[0].presentaciones.descripcion}</p>
              ${presentacion[0].tipo_presentacion_nombre === 'Otro' ?
                `<a href="${urlHost}/presentaciones/${presentacion[0].presentaciones.id}" class="btn bgColor btnPresentaciones">Ir a Presentación</a>` :
                `<a href="${urlHost}/presentaciones/${presentacion[0].presentaciones.id}" class="btn bgColor btnPresentaciones">Ir a ${presentacion[0].tipo_presentacion_nombre}</a>`
              }
              ${presentacion[0].congresos.id ?
                `<a href="${urlHost}/congresos/${presentacion[0].congresos.id}" class="btn bgColor btnPresentaciones">Ir al congreso</a>` : ''
              }
            `
            bodyCardPresentaciones.appendChild(contenedorInfoPresentaciones)
  
            // Crea el contenedor de imágenes de presentaciones
            let contenedorImgPresentaciones = document.createElement('div')
            contenedorImgPresentaciones.className = 'contenedorImgPresentaciones col-lg-4 p-2'
            contenedorImgPresentaciones.innerHTML = `<img class="imgPresentaciones img-fluid" src="${presentacion[0].presentaciones.img ? presentacion[0].presentaciones.img : urlHost+'/storage/img/img-por-defecto-congresos.jpg'}" alt="">`
            bodyCardPresentaciones.appendChild(contenedorImgPresentaciones)
  
            // Añade el cuerpo de la tarjeta al artículo
            article.appendChild(bodyCardPresentaciones)
  
            // Crea el pie de la tarjeta
            let cardFooter = document.createElement('div')
            cardFooter.className = 'card-footer text-body-secondary bgColor'
            cardFooter.innerHTML = `De: <small>${presentacion[0].dia}</small> A: <small>${presentacion[presentacion.length - 1].dia}</small>`
            article.appendChild(cardFooter)
  
            // Añade el artículo al contenedor principal
            articulosPresentaciones.appendChild(article)
          })
          
          // Animación para mostrar los nuevos elementos
          gsap.to(articulosPresentaciones, { y: 0, opacity: 1, duration: 0.2 })
        },
      })
      
      // Primera animación: desplazar hacia la izquierda y desvanecer
      tl.to(articulosPresentaciones, { y: 50, opacity: 0, duration: 0.2 })
      
      // Iniciar la línea de tiempo
      tl.play()
  
    } catch (error) {
      console.error('Hubo un problema con la solicitud fetch:', error.message)
    }
  }

  // Agrega un evento de clic a cada enlace
  tipoPresentacionesLinks.forEach((link) => {
    link.addEventListener('click', (e) => {
      e.preventDefault()
      // Accede al atributo 'id-tipo' y muestra su valor
      idTipo = link.getAttribute('id-tipo')

      if (idTipo != '' && busqueda != '')
      {
        obtenerDatos(`?idTipo=${idTipo}&nombrePresentacion=${busqueda}`)
      }
      else if (idTipo != '' && busqueda == '')
      {
        obtenerDatos(`?idTipo=${idTipo}`)
      }
      else if (idTipo == '' && busqueda != '')
      {
        obtenerDatos(`?nombrePresentacion=${busqueda}`)
      }
      else
      {
        obtenerDatos()
      }

    })
  })

  buscador.addEventListener('change', () => {
    busqueda = buscador.value

    if (idTipo != '' && busqueda != '')
    {
      obtenerDatos(`?idTipo=${idTipo}&nombrePresentacion=${busqueda}`)
    }
    else if (idTipo != '' && busqueda == '')
    {
      obtenerDatos(`?idTipo=${idTipo}`)
    }
    else if (idTipo == '' && busqueda != '')
    {
      obtenerDatos(`?nombrePresentacion=${busqueda}`)
    }
    else
    {
      obtenerDatos()
    }
  })
})