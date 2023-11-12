const urlHost = document.getElementById('urlHost').value
const token = document.cookie.replace(/(?:(?:^|.*;\s*)token\s*=\s*([^;]*).*$)|^.*$/, "$1")

async function obtenerDatos(){
  try {
    const opciones = {
      method: 'GET', // método HTTP, por ejemplo, 'GET' o 'POST'
      headers: {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${token}`,
      }
    }

    const response = await fetch(`${urlHost}/api/admin/organizaciones`, opciones)

    if (!response.ok) {
      throw new Error(`Error de red - Código: ${response.status}`)
    }

    const data = response.json()

    return data
  } catch (error) {
    console.error('Hubo un problema con la solicitud fetch:', error.message)
  }
}

// Código para crear una nueva fila con datos
const createRow = (organizacion) => {
  const newRow = document.createElement('tr')

  const thCell = document.createElement('th')
  thCell.textContent = organizacion.id
  newRow.appendChild(thCell)

  const tdCell1 = document.createElement('td')
  tdCell1.textContent = organizacion.nombre
  newRow.appendChild(tdCell1)

  // Crear la celda de la tabla
  const tableCell = document.createElement('td')

  // Crear el contenedor div
  const dropdownDiv = document.createElement('div')
  dropdownDiv.classList.add('dropdown')

  // Crear el botón
  const button = document.createElement('button')
  button.classList.add('btnDireccion', 'dropdown-toggle')
  button.type = 'button'
  button.setAttribute('data-bs-toggle', 'dropdown')
  button.setAttribute('aria-expanded', 'false')
  button.textContent = 'Ver más'

  // Crear la lista desplegable (ul)
  const dropdownList = document.createElement('ul')
  dropdownList.classList.add('dropdown-menu')
  dropdownList.classList.add('p-3')

  // Agregar elementos de lista (li) sin enlaces (a)
  const direccion = organizacion.direccion

  const listItem = document.createElement('li')
  listItem.innerHTML = `<b>País:</b> ${direccion.pais}`
  dropdownList.appendChild(listItem)

  const listItem2 = document.createElement('li')
  listItem2.innerHTML = `<b>Estado:</b> ${direccion.estado}`
  dropdownList.appendChild(listItem2)

  const listItem3 = document.createElement('li')
  listItem3.innerHTML = `<b>Municipio:</b> ${direccion.municipio}`
  dropdownList.appendChild(listItem3)

  const listItem4 = document.createElement('li')
  listItem4.innerHTML = `<b>Colonia:</b> ${direccion.colonia}`
  dropdownList.appendChild(listItem4)

  const listItem5 = document.createElement('li')
  listItem5.innerHTML = `<b>Calle:</b> ${direccion.calle}`
  dropdownList.appendChild(listItem5)

  const listItem6 = document.createElement('li')
  listItem6.innerHTML = `<b>Número exterior:</b> ${direccion.num_ext}`
  dropdownList.appendChild(listItem6)

  const listItem7 = document.createElement('li')
  listItem7.innerHTML = `<b>Número interior:</b> ${direccion.num_int}`
  dropdownList.appendChild(listItem7)

  // Agregar los elementos al documento
  dropdownDiv.appendChild(button)
  dropdownDiv.appendChild(dropdownList)
  tableCell.appendChild(dropdownDiv)

  newRow.appendChild(tableCell)

  return newRow
}

document.addEventListener('DOMContentLoaded', async function() {
  let tablaOrganizaciones = document.getElementById('tablaOrganizaciones')

  if (tablaOrganizaciones != undefined){
    let tbody = tablaOrganizaciones.querySelector('tbody')

    const organizaciones = await obtenerDatos()

    organizaciones.forEach((organizacion) => {
      const row = createRow(organizacion)
      tbody.appendChild(row)
    })
  }
})