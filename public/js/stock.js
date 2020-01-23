"use strict"

let arrayArticulos = [];
let rubros;
let stock;

const traerStock = async () => {
    try {
        let response = await fetch("/api/stock")
        if (response.ok) {
            let data = await response.json()
            console.log("transfer is complete: ")
            console.log(data)

            // Capitalizo data api
            data.forEach(elem => {
                elem.rubro = capitalize(elem.rubro)
                elem.subrubro = capitalize(elem.subrubro)
            })

            arrayArticulos = data

            let rubros = arrayArticulos.map((item) => item.rubro.trim()).filter((item, i, ar) => ar.indexOf(item) === i).sort((a, b) => a - b).map(item => {
                return {
                    rubro: capitalize(item)
                }
            });
            console.log(rubros)

            rubros = rubros
            stock = data

            let result = {
                rubros: rubros,
                stock: data
            }

            return result

        } else {
            throw Error(`Promesa rechazada con status ${response.status}`)
        }

    } catch (error) {
        console.log('Hubo un problema con la petición Fetch:' + error.message);
    }
}

const pintarRubros = (payload) => {
    let div = document.getElementById('rubros')
    payload.forEach(element => {
        div.innerHTML += `<a name="" id="${element.rubro}" class="btn btn-outline-primary" href="#" onclick="pintarLista('${element.rubro}')" role="button">${element.rubro}</a>
        `
    })
}

const pintarLista = (rubro, subrubro) => {
    let div = document.getElementById('lista-productos')
    div.innerHTML = ""
    let data = stock

    if (rubro)
        data = stock.filter(e => {
            return e.rubro == rubro
        })

    if (subrubro)
        data = stock.filter(e => {
            return e.subrubro == subrubro
        })

    data.forEach(element => {
        div.innerHTML += `                        
            <li class="list-group-item d-flex justify-content-between align-items-center">
                ${element.detalle}
                <div class="float-right">
                    <button class="btn btn-outline-info mr-2">${element.cantidad}</button>
                    <button class="btn btn-warning mr-2"><i class="material-icons">edit</i></button>
                    <button class="btn btn-danger"><i class="material-icons">delete</i></button>
                </div>
            </li>

        `
    })
}

const capitalize = (s) => {
    if (typeof s !== 'string') return ''
    return s.charAt(0).toUpperCase() + s.slice(1).toLowerCase()
}

// Eventos
document.addEventListener("DOMContentLoaded", async () => {

    let data = await traerStock();

    console.log(data)

    pintarRubros(data.rubros);

    pintarLista()

});