"use strict";

// Variables
let user;
var table;
var cont = 0;
let arrayArticulos = [];
let arrayRubros = [];
let orden;
var tablaUI;
var cont_r = 0;
let radioB = [];


let datosU = JSON.parse(localStorage.getItem("datos_usuario"));

// Funciones

function checkRadio(nroSpec, spec_estado, spec_datos, spec_nombre) {
    let spec
    let checkUI = ""
    if (spec_estado == 1 && spec_datos != null && spec_datos != "") {
        spec = spec_datos.split(',')
        checkUI += `<p>${spec_nombre}</p>`
        spec.forEach(function (element, index) {
            checkUI += `
            <p>
            <label>
                <input id="check${nroSpec}${index}" type="checkbox" />
                <span class="capitalize">${element}</span>
            </label>
            </p>`
        })
    }

    if (spec_estado == 2 && spec_datos != null && spec_datos != "") {
        spec = spec_datos.split(',')
        checkUI += `<p>${spec_nombre}</p>`
        spec.forEach(element => {
            checkUI += `
            <p>
            <label>
              <input name="group${nroSpec}" value="${element}" type="radio" />
              <span class="capitalize">${element}</span>
            </label>
          </p>`
        })
    }

    return checkUI

}

function getValue(nroSpec, spec_estado, spec_datos, specArray) {

    let spec

    if (spec_estado == 1 && spec_datos != null && spec_datos != "") {
        let vSpec = false;
        spec = spec_datos.split(',')
        spec.forEach(function (element, index) {
            let c = "#check" + nroSpec + "" + index
            vSpec = document.querySelector(c).checked;
            if (vSpec) specArray.push(element)
        })
    }

    if (spec_estado == 2 && spec_datos != null && spec_datos != "") {
        let cont = 0
        let name = 'group' + nroSpec
        spec = document.getElementsByName(name);
        spec.forEach(element => {
            if (element.checked) {
                cont++
                specArray.push(element.value)
            }
        })

        let datos = {
            spec: nroSpec,
            checked: cont
        }
        radioB.push(datos)
    }

    return specArray

}

function addArticulo(codigo) {

    console.log(codigo);
    // Busco el indice del articulo en el arrayArticulos y agrego 1 a cantidad
    let indexArray = arrayArticulos.findIndex((elemento) => {
        return elemento.codigo === codigo
    });

    var datos = {
        precio: parseFloat(arrayArticulos[indexArray].precio),
        cantidad: parseInt(arrayArticulos[indexArray].cantidad),
        codigo: parseInt(arrayArticulos[indexArray].codigo),
        detalle: arrayArticulos[indexArray].detalle,
        descripcion: arrayArticulos[indexArray].descripcion,
        rubro: arrayArticulos[indexArray].rubro,
        comentario: parseInt(arrayArticulos[indexArray].comentario),
        specs: parseInt(arrayArticulos[indexArray].specs),
        spec1_estado: parseInt(arrayArticulos[indexArray].spec1_estado),
        spec1_nombre: arrayArticulos[indexArray].spec1_nombre,
        spec1_datos: arrayArticulos[indexArray].spec1_datos,
        spec2_estado: parseInt(arrayArticulos[indexArray].spec2_estado),
        spec2_nombre: arrayArticulos[indexArray].spec2_nombre,
        spec2_datos: arrayArticulos[indexArray].spec2_datos,
        spec3_estado: parseInt(arrayArticulos[indexArray].spec3_estado),
        spec3_nombre: arrayArticulos[indexArray].spec3_nombre,
        spec3_datos: arrayArticulos[indexArray].spec3_datos,
        spec4_estado: parseInt(arrayArticulos[indexArray].spec4_estado),
        spec4_nombre: arrayArticulos[indexArray].spec4_nombre,
        spec4_datos: arrayArticulos[indexArray].spec4_datos,
        spec5_estado: parseInt(arrayArticulos[indexArray].spec5_estado),
        spec5_nombre: arrayArticulos[indexArray].spec5_nombre,
        spec5_datos: arrayArticulos[indexArray].spec5_datos,
    }
    let articulo = datos.detalle;
    console.log(articulo);
    console.log("specs: " + datos.specs);
    console.log("comentario: " + datos.comentario);

    if (datos.specs === 1 || datos.comentario === 1) {

        let check1UI = ""
        let check2UI = ""
        let check3UI = ""
        let check4UI = ""
        let check5UI = ""
        let comentarioUI = ""
        let modal = document.querySelector('#modal1');
        let comentario = datos.comentario;
        modal.innerHTML = ""

        check1UI = checkRadio(1, datos.spec1_estado, capitalize(datos.spec1_datos), datos.spec1_nombre)
        check2UI = checkRadio(2, datos.spec2_estado, capitalize(datos.spec2_datos), datos.spec2_nombre)
        check3UI = checkRadio(3, datos.spec3_estado, capitalize(datos.spec3_datos), datos.spec3_nombre)
        check4UI = checkRadio(4, datos.spec4_estado, capitalize(datos.spec4_datos), datos.spec4_nombre)
        check5UI = checkRadio(5, datos.spec5_estado, capitalize(datos.spec5_datos), datos.spec5_nombre)

        if (comentario == 1) {
            comentarioUI = `
                <div class="input-field col s12">
                    <textarea id="comentario" class="materialize-textarea"></textarea>
                    <label for="comentario">Comentario opcional</label>
                </div>`
        }

        modal.innerHTML += `
            <div class="modal-content">
            <h5>${articulo}</h5>
            <h6>${(datos.descripcion != 'null') ? datos.descripcion : ''}</h6>
            <p>Elegi las opciones para tu ${articulo}</p>
            ${check1UI}
            ${check2UI}
            ${check3UI}
            ${check4UI}
            ${check5UI}
            ${comentarioUI}
            </div>`
        modal.innerHTML += `
            <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect btn-flat">Volver</a>
            <a href="#!" onclick="addArticuloDetalle('${articulo}')" class="waves-effect btn primary">Agregar</a>
            </div>`
        let instance = M.Modal.getInstance(modal);
        // Abro modal
        instance.open();
    } else {

        //El código siguiente activa un evento de Google Analytics con la acción 'add_to_cart', la categoría 'ecommerce'
        // gtag('event', 'add_to_cart');
        gtag('event', 'add_to_cart', {
            "items": [{
                "id": codigo,
                "name": articulo,
                //"list_name": "Search Results",
                //"brand": "Google",
                "category": datos.rubro,
                //"variant": "Black",
                //"list_position": 1,
                "quantity": 1
                //"price": datos.precio
            }]
        });

        console.log("Articulo agregado: " + arrayArticulos[indexArray].detalle);
        arrayArticulos[indexArray].cantidad++;

        // Guardo en LocalStorage
        guardarDatosArticulos(arrayArticulos);

        // Actualizo la tabla con la nueva cantidad
        let art = document.getElementsByClassName(codigo);
        for (let i = 0; i < art.length; i++) {
            //console.log(art[i])
            let num = art[i].innerHTML;
            num++;
            art[i].innerHTML = num;
            console.log(art[i].innerHTML)
        }

        //
        let cant = datos.cantidad;
        cant++;
        var nuevosDatos = {
            precio: datos.precio,
            cantidad: cant,
            detalle: datos.detalle,
            codigo: datos.codigo,
            comentario: 0,
            comentario1: "",
            specs: 0,
            spec1: ""
        }
        if (datos.cantidad == 0) {
            orden.push(nuevosDatos)
        } else {
            // Busco el indice del articulo en orden y agrego 1 a cantidad
            let indexArray = orden.findIndex((elemento) => {
                return elemento.detalle === articulo
            });
            orden[indexArray].cantidad++;
        }
        console.log(orden);
        localStorage.setItem("orden_actual", JSON.stringify(orden));
        console.log("LocalStorage: orden_actual guardada");

        //Actualizo el icono cart
        document.querySelector("#i-cart").innerHTML = "shopping_cart";
        document.querySelector("#floating").classList.remove("disabled");
        document.querySelector("#floating").classList.add("pulse");

        abrirTapTarget();
    }


}

function addArticuloDetalle(articulo) { // Articulos con specs.

    let modal = document.querySelector('#modal1');
    let instance = M.Modal.getInstance(modal);


    // Busco el indice del articulo en el arrayArticulos
    let indexArray = arrayArticulos.findIndex((elemento) => {
        return elemento.detalle === articulo
    });

    let comentarioUI = "";
    let specArray = []
    let specs = ""

    var datos = {
        precio: parseFloat(arrayArticulos[indexArray].precio),
        cantidad: parseInt(arrayArticulos[indexArray].cantidad),
        codigo: parseInt(arrayArticulos[indexArray].codigo),
        detalle: arrayArticulos[indexArray].detalle,
        rubro: arrayArticulos[indexArray].rubro,
        comentario: parseInt(arrayArticulos[indexArray].comentario),
        specs: parseInt(arrayArticulos[indexArray].specs),
        spec1_estado: parseInt(arrayArticulos[indexArray].spec1_estado),
        spec1_nombre: arrayArticulos[indexArray].spec1_nombre,
        spec1_datos: arrayArticulos[indexArray].spec1_datos,
        spec2_estado: parseInt(arrayArticulos[indexArray].spec2_estado),
        spec2_nombre: arrayArticulos[indexArray].spec2_nombre,
        spec2_datos: arrayArticulos[indexArray].spec2_datos,
        spec3_estado: parseInt(arrayArticulos[indexArray].spec3_estado),
        spec3_nombre: arrayArticulos[indexArray].spec3_nombre,
        spec3_datos: arrayArticulos[indexArray].spec3_datos,
        spec4_estado: parseInt(arrayArticulos[indexArray].spec4_estado),
        spec4_nombre: arrayArticulos[indexArray].spec4_nombre,
        spec4_datos: arrayArticulos[indexArray].spec4_datos,
        spec5_estado: parseInt(arrayArticulos[indexArray].spec5_estado),
        spec5_nombre: arrayArticulos[indexArray].spec5_nombre,
        spec5_datos: arrayArticulos[indexArray].spec5_datos,
    }

    specArray = getValue(1, datos.spec1_estado, datos.spec1_datos, specArray)
    specArray = getValue(2, datos.spec2_estado, datos.spec2_datos, specArray)
    specArray = getValue(3, datos.spec3_estado, datos.spec3_datos, specArray)
    specArray = getValue(4, datos.spec4_estado, datos.spec4_datos, specArray)
    specArray = getValue(5, datos.spec5_estado, datos.spec5_datos, specArray)

    if (datos.comentario == "1") {
        comentarioUI = document.querySelector("#comentario").value;
    }

    specs = specArray.join();

    console.log(radioB)
    let ok = true
    radioB.forEach(element => {
        if (element.checked == 0) {
            radioB = []
            ok = false
        }
    })

    if (!ok) {
        console.log('Debes seleccionar una opcion en los campos que lo indiquen!')
        return
    }

    /////////////////////////////////////////

    //El código siguiente activa un evento de Google Analytics con la acción 'add_to_cart', la categoría 'ecommerce'
    //gtag('event', 'add_to_cart');
    gtag('event', 'add_to_cart', {
        "items": [{
            "id": datos.codigo,
            "name": articulo,
            //"list_name": "Search Results",
            //"brand": "Google",
            "category": datos.rubro,
            //"variant": "Black",
            //"list_position": 1,
            "quantity": 1
            //"price": datos.precio
        }]
    });


    console.log("Articulo agregado: " + arrayArticulos[indexArray].detalle);
    // Agrego uno a arrayArticulos
    arrayArticulos[indexArray].cantidad++;
    localStorage.setItem("lista_articulos", JSON.stringify(arrayArticulos));

    // Agrego uno a orden_actual
    var nuevosDatos = {
        precio: datos.precio,
        cantidad: 1,
        detalle: datos.detalle,
        codigo: datos.codigo,
        comentario: datos.comentario,
        comentario1: comentarioUI,
        specs: datos.specs,
        spec1: specs
    }

    if (datos.cantidad == 0) {
        orden.push(nuevosDatos)
    } else {

        // Busco el indice del articulo en orden y agrego 1 a cantidad
        let indexArray = orden.findIndex((elemento) => {
            return (elemento.detalle === articulo && elemento.spec1 === nuevosDatos.spec1 && elemento.comentario1 === nuevosDatos.comentario1)
        });

        console.log(indexArray)

        if (indexArray === -1) {
            orden.push(nuevosDatos);
        } else {
            orden[indexArray].cantidad++;
        }

    }
    console.log(orden);
    localStorage.setItem("orden_actual", JSON.stringify(orden));
    console.log("LocalStorage: orden_actual guardada");

    // Cierro modal
    instance.close();

    // Actualizo la tabla con la nueva cantidad
    // console.log("Articulo agregado: " + articulo);
    let art = document.getElementsByClassName(datos.codigo);
    for (let i = 0; i < art.length; i++) {
        //console.log(art[i])
        let num = art[i].innerHTML;
        num++;
        art[i].innerHTML = num;
        console.log(art[i].innerHTML)
    }

    //Actualizo el icono cart
    document.querySelector("#i-cart").innerHTML = "shopping_cart";
    document.querySelector("#floating").classList.remove("disabled");
    document.querySelector("#floating").classList.add("pulse");

    abrirTapTarget();
}

function removeArticulo(codigo) {

    console.log(codigo);
    // Busco el indice del articulo en el arrayArticulos y agrego 1 a cantidad
    let indexArray = arrayArticulos.findIndex((elemento) => {
        return elemento.codigo === codigo
    });

    var datos = {
        precio: parseFloat(arrayArticulos[indexArray].precio),
        cantidad: parseInt(arrayArticulos[indexArray].cantidad),
        codigo: parseInt(arrayArticulos[indexArray].codigo),
        detalle: arrayArticulos[indexArray].detalle,
        rubro: arrayArticulos[indexArray].rubro,
        specs: parseInt(arrayArticulos[indexArray].specs),
        comentario: parseInt(arrayArticulos[indexArray].comentario)
    }
    let articulo = datos.detalle;
    console.log(articulo);
    console.log("specs: " + datos.specs);
    console.log("comentario: " + datos.comentario);

    if (datos.specs === 1 || datos.comentario === 1) {
        // LLeno modal
        let elem = document.querySelector('#modal1');
        let cont = 0;
        elem.innerHTML = ""
        orden.forEach(element => {
            if (element.detalle == articulo && element.cantidad > 0) {
                cont++;
                let specs = "";
                let comentario = "";
                if (element.specs === 1 && element.spec1 != "") {
                    specs = element.spec1 + `<br>`
                }
                if (element.comentario === 1) {
                    comentario = element.comentario1 + `<br>`
                }

                console.log(specs)
                console.log(comentario)

                elem.innerHTML += `
                    <div class="modal-content">
                        <table>
                            <tr class='item'>
                                <td class='left fs-16' style='text-align:left'>${element.detalle}<br><span class='fs-16'>${specs + comentario}</span>$${element.precio}</td>
                                <td class='right' onclick=\"cambiarCantidadArticulo('${cont}','${element.codigo}','aumentar','${element.spec1}','${element.comentario1}');\"><i class='material-icons primary-text size-circle'>add_circle</i></td>
                                <td class='right'><span class='fs-18' id='${cont}'>${element.cantidad}</span></td>
                                <td class='right' onclick=\"cambiarCantidadArticulo('${cont}','${element.codigo}','disminuir','${element.spec1}','${element.comentario1}');\"><i class='material-icons primary-text size-circle'>remove_circle</i></td>
                            </tr>
                        </table>
                    </div>
                    `
            }
        });
        elem.innerHTML += `
            <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect btn-flat">Volver</a>
            </div>`
        let instance = M.Modal.getInstance(elem);
        // Abro modal
        if (cont > 0) instance.open();
    } else {

        //El código siguiente activa un evento de Google Analytics con la acción 'remove_from_cart', la categoría 'ecommerce'
        //gtag('event', 'remove_from_cart');
        gtag('event', 'remove_from_cart', {
            "items": [{
                "id": datos.codigo,
                "name": articulo,
                //"list_name": "Search Results",
                //"brand": "Google",
                "category": datos.rubro,
                //"variant": "Black",
                //"list_position": 1,
                "quantity": 1
                //"price": datos.precio
            }]
        });

        console.log("Articulo quitado: " + arrayArticulos[indexArray].detalle);

        let cant = arrayArticulos[indexArray].cantidad;
        if (cant > 0) {
            cant--;
            arrayArticulos[indexArray].cantidad = cant;
        }
        // Guardo en LocalStorage
        guardarDatosArticulos(arrayArticulos);

        // Actualizo orden_actual
        let indexArrayOrden = orden.findIndex((elemento) => {
            return (elemento.detalle === articulo && elemento.specs === 0)
        });

        console.log("indice orden_actual: " + indexArrayOrden);
        if (indexArrayOrden == -1)
            return;

        cant = orden[indexArrayOrden].cantidad;
        console.log(cant);
        if (cant > 0) orden[indexArrayOrden].cantidad--;
        if (cant == 1) orden.splice(indexArrayOrden, 1);
        localStorage.setItem("orden_actual", JSON.stringify(orden));

        // Actualizo la tabla con la nueva cantidad
        //console.log("Articulo removido: " + articulo);
        let art = document.getElementsByClassName(codigo);
        for (let i = 0; i < art.length; i++) {
            //console.log(art[i])
            let num = art[i].innerHTML;
            if (num > 0) {
                num--;
            }
            art[i].innerHTML = num;
            console.log(art[i].innerHTML)
        }
    }
}

function cambiarCantidadArticulo(id, codigo, accion, spec1, comentario) {
    console.log(document.getElementById(id).innerHTML);
    console.log(codigo);
    console.log(spec1);
    console.log(comentario);

    // Busco el indice del articulo en el arrayArticulos
    let indexArray = arrayArticulos.findIndex((elemento) => {
        return (elemento.codigo === codigo)
    });
    console.log("indice lista_articulos: " + indexArray);

    let datos = {
        precio: parseFloat(arrayArticulos[indexArray].precio),
        codigo: parseInt(arrayArticulos[indexArray].codigo),
        detalle: arrayArticulos[indexArray].detalle,
        rubro: arrayArticulos[indexArray].rubro,
        comentario: parseInt(arrayArticulos[indexArray].comentario)
    }
    let articulo = datos.detalle;

    let indexArrayOrden = orden.findIndex((elemento) => {
        return (elemento.detalle === datos.detalle && elemento.spec1 === spec1 && elemento.comentario1 === comentario)
    });

    console.log("indice orden_actual: " + indexArrayOrden);
    if (indexArrayOrden != -1) {
        var cantid = orden[indexArrayOrden].cantidad;
        console.log(cantid);
    }


    if (cantid > 0 && accion == "disminuir" && indexArrayOrden != -1) {

        //El código siguiente activa un evento de Google Analytics con la acción 'remove_from_cart', la categoría 'ecommerce'
        //gtag('event', 'remove_from_cart');
        gtag('event', 'remove_from_cart', {
            "items": [{
                "id": datos.codigo,
                "name": articulo,
                //"list_name": "Search Results",
                //"brand": "Google",
                "category": datos.rubro,
                //"variant": "Black",
                //"list_position": 1,
                "quantity": 1
                //"price": datos.precio
            }]
        });

        orden[indexArrayOrden].cantidad--;
        arrayArticulos[indexArray].cantidad--;
        if (cantid == 1) {
            console.log("Elimino elemento del array");
            orden.splice(indexArrayOrden, 1);
        }
        let span = document.getElementById(id);
        let cant = parseInt(span.innerHTML);
        cant--;
        span.innerHTML = cant;

        // Actualizo la tabla con la nueva cantidad
        let art = document.getElementsByClassName(codigo);
        for (let i = 0; i < art.length; i++) {
            //console.log(art[i])
            let num = art[i].innerHTML;
            if (num > 0) {
                num--;
            }
            art[i].innerHTML = num;
            console.log(art[i].innerHTML)
        }
    }

    if (accion == "aumentar") {

        //El código siguiente activa un evento de Google Analytics con la acción 'add_to_cart', la categoría 'ecommerce'
        //gtag('event', 'add_to_cart');
        gtag('event', 'add_to_cart', {
            "items": [{
                "id": datos.codigo,
                "name": articulo,
                //"list_name": "Search Results",
                //"brand": "Google",
                "category": datos.rubro,
                //"variant": "Black",
                //"list_position": 1,
                "quantity": 1
                //"price": datos.precio
            }]
        });

        if (indexArrayOrden != -1) {
            orden[indexArrayOrden].cantidad++;
        } else {
            let nuevosDatos = {
                precio: datos.precio,
                cantidad: 1,
                detalle: datos.detalle,
                codigo: datos.codigo,
                comentario: datos.comentario,
                comentario1: comentario,
                specs: 1,
                spec1: spec1,
            }

            orden.push(nuevosDatos);
        }

        arrayArticulos[indexArray].cantidad++;
        let span = document.getElementById(id);
        let cant = parseInt(span.innerHTML);
        cant++;
        span.innerHTML = cant;

        // Actualizo la tabla con la nueva cantidad
        let art = document.getElementsByClassName(codigo);
        for (let i = 0; i < art.length; i++) {
            //console.log(art[i])
            let num = art[i].innerHTML;
            num++;
            art[i].innerHTML = num;
            console.log(art[i].innerHTML)
        }
    }


    console.log(orden);
    localStorage.setItem("lista_articulos", JSON.stringify(arrayArticulos));
    localStorage.setItem("orden_actual", JSON.stringify(orden));
    console.log("LocalStorage: lista_articulos guardada");
    console.log("LocalStorage: orden_actual guardada");
}

async function traerDatos() {

    try {
        let response = await fetch("/api/stock")
        if (response.ok) {
            let data = await response.json()
            console.log("Articulos table transfer is complete: ");
            console.log(data);

            // Capitalizo data api
            data.forEach(elem => {
                elem.rubro = capitalize(elem.rubro)
                elem.subrubro = capitalize(elem.subrubro)
            })

            arrayArticulos = data;

            let rubros = arrayArticulos.map((item) => item.rubro.trim()).filter((item, i, ar) => ar.indexOf(item) === i).sort((a, b) => a - b).map(item => {
                return {
                    rubro: capitalize(item)
                }
            });
            console.log(rubros);

            guardarDatosRubros(rubros);

            guardarDatosArticulos(data);

            return
        } else {
            throw Error(`Promesa rechazada con status ${response.status}`)
        }

    } catch (error) {
        console.log('Hubo un problema con la petición Fetch:' + error.message);
    }
}

const guardarDatosRubros = (data) => {
    // Convierto a JSON mi array y lo guardo en localStorage
    localStorage.setItem("lista_rubros", JSON.stringify(data));
    console.log("LocalStorage: lista_rubros guardada")
}

const guardarDatosArticulos = (data) => {
    // Convierto a JSON mi array y lo guardo en localStorage
    localStorage.setItem("lista_articulos", JSON.stringify(data));
    console.log("LocalStorage: lista_articulos guardada");
}

function pintarTablaRubros(tabla) {

    try {
        table = document.getElementById(tabla);

        // Limpio lo que haya en la tabla de articulos
        document.getElementById('tabla_articulos').innerHTML = "";

        // Limpio lo que haya en la lista
        //table.innerHTML = "";

        // Si es la primera vez que entro a esta funcion no entro al if
        // Que es esto
        cont_r++;
        if (cont_r > 1) {
            table.style.display = "block";
            reiniciarColoresSidenav();
            return;
        }

        // Leo elemento a elemento
        arrayRubros.forEach(element => {
            let rubro = element.rubro.trim();
            if (rubro != "") { // ELiminar cuando tenga la carta del casino
                table.innerHTML += `
                <div class="col-12 col-md-6 col-lg-4" style="padding: 0">
                    <div class="card" onclick="seleccionarRubro('${rubro}')" style="margin-bottom: 0.5rem; margin-left: 0.5rem; margin-right: 0.5rem">
                        <div class="card-image">
                            <img style="height:128px" src="/view/img/${rubro}.jpg">
                            <span class="card-title center-align truncate text-shadow" style="width: 100%; font-weight: 500; font-size: 32px;">${element.rubro}</span>
                        </div>
                    </div>
                </div>
                `
            }
        });

    } catch (error) {
        console.log(error.message)
    } finally {
        // Escondo preloader y pinto sideNav
        //hidePreloader();
        //pintarSidenav();
        //reiniciarColoresSidenav();
    }

}

function pintarTablaSubrubros(tabla, rubro) {

    table = document.getElementById(tabla);
    console.log(rubro)

    // Limpio lo que haya en la tabla
    table.innerHTML = "";
    table.style.display = "block"

    // Oculto la lista de rubros
    document.getElementById('tabla_rubros').style.display = "none";

    if (arrayArticulos == null || arrayArticulos.length == 0)
        arrayArticulos = JSON.parse(localStorage.getItem("lista_articulos"));

    let subrubros = arrayArticulos.map((item) => item.subrubro.trim()).filter((item, i, ar) => ar.indexOf(item) === i).sort((a, b) => a - b).map(item => {
        let new_list = arrayArticulos.filter(itm => itm.subrubro == item).map(itm => itm.rubro);
        return {
            subrubro: item,
            rubro: new_list[0]
        }
    });
    console.log(subrubros);

    let cont = 0;
    // Leo elemento a elemento
    subrubros.forEach(element => {

        //let subrubro = element.subrubro.trim()
        let s = element.subrubro
        let r = element.rubro.trim()
        if (r == rubro && s != '') {
            table.innerHTML += `
            <div class="col-6 col-md-4" style="padding: 0">
                <div class="card" onclick="pintarTablaArticulos('tabla_articulos','${s}','${r}')" style="margin-bottom: 0.5rem; margin-left: 0.5rem; margin-right: 0.5rem">
                    <div class="card-image">
                        <img style="height:128px" src="/view/img/${s}.jpg">
                        <span class="card-title center-align truncate text-shadow" style="width: 100%; font-weight: 500; font-size: 28px;">${s}</span>
                    </div>
                </div>
            </div>
            `
            cont++
        }

        /*
        let inner = `
        <div class="col s6 m4" style="padding: 0">
            <div class="card" onclick="pintarTablaArticulos('tabla_articulos','${subrubro}')" style="margin-bottom: 0.5rem; margin-left: 0.5rem; margin-right: 0.5rem">
                <div class="card-image">
                    <img style="height:128px" src="/view/img/${subrubro}.jpg">
                    <span class="card-title center-align truncate text-shadow" style="width: 100%; font-weight: 500; font-size: 28px;">${subrubro}</span>
                </div>
            </div>
        </div>
        `

        if (r == rubro && subrubro != '') {
            table.innerHTML += inner
            cont++
        } else if (rubro === "%") {

            table.innerHTML += inner
        } */
    });

    window.location = "#subrubros"

    //Si no hay subrubros en el rubro entonces pinto la tabla  de articulos con una nueva funcion
    if (cont == 0) {
        pintarTablaArticulosPorRubros("tabla_articulos", rubro)
    }
}

function pintarTablaArticulos(tabla, subrubro, rubro) {

    try {

        table = document.getElementById(tabla);
        console.log(rubro + " - " + subrubro)

        // Limpio lo que haya en la tabla
        table.innerHTML = "";

        // Oculto la lista de rubros
        document.getElementById('tabla_rubros').style.display = "none";
        document.getElementById('tabla_subrubros').style.display = "none";

        // Leo elemento a elemento
        arrayArticulos.forEach(element => {

            let r = element.rubro.trim()
            let s = element.subrubro
            let inner = `
            <li class="list-group-item">
                <img onclick="ampliarImagen(${element.codigo},'${element.descripcion}')" width="44" height="44" src="/view/img/${element.codigo}.jpg" alt="" class="circle">
                ${element.detalle}<br>$${element.precio}
                <div class="float-right">
                    <span onclick=\"removeArticulo('${element.codigo}');\"><i class='material-icons primary-text size-circle'>remove_circle</i></span>
                    <span id='${element.detalle}' class='${element.codigo}'>${element.cantidad}</span></td>
                    <span onclick=\"addArticulo('${element.codigo}');\"><i class='material-icons primary-text size-circle'>add_circle</i></span>
                </div>
            </li>
            `

            if (s == subrubro && r == rubro) {
                table.innerHTML += inner
            } else if (subrubro === "%") {

                table.innerHTML += inner
            }
        });

        //window.location = "#articulos"

    } catch (error) {
        console.log(error.message)
    }

}

function pintarTablaArticulosPorRubros(tabla, rubro) {

    /* let recomendados = document.getElementById('recomendados');
    recomendados.style.display = "none"; */

    table = document.getElementById(tabla);
    console.log(rubro)

    // Limpio lo que haya en la tabla
    table.innerHTML = "";

    // Limpio lo que haya en rubros
    //document.getElementById('tabla_rubros').innerHTML = "";
    // Oculto la lista de rubros
    document.getElementById('tabla_rubros').style.display = "none";
    document.getElementById('tabla_subrubros').style.display = "none";

    // Leo elemento a elemento
    arrayArticulos.forEach(element => {

        let r = element.rubro.trim()
        let inner = `
        <tr class='item'>
            <td><img onclick="ampliarImagen(${element.codigo},'${element.descripcion}')" width="44" height="44" src="/view/img/${element.codigo}.jpg" alt="" class="circle"></td>
            <td class='left' style='text-align:left'>${element.detalle}<br>$${element.precio}</td>
            <td onclick=\"removeArticulo('${element.codigo}');\"><i class='material-icons primary-text size-circle'>remove_circle</i></td>
            <td><span id='${element.detalle}' class='${element.codigo}'>${element.cantidad}</span></td>
            <td onclick=\"addArticulo('${element.codigo}');\"><i class='material-icons primary-text size-circle'>add_circle</i></td>
        </tr>
        `

        if (r == rubro) {
            table.innerHTML += inner
        } else if (rubro === "%") {

            table.innerHTML += inner
        }
    });
}

function seleccionarRubro(e) {
    console.log(e)
    const tabla = 'tabla_subrubros';

    pintarTablaSubrubros(tabla, e);

    /* // Paso el valor del rubro elegido al breadcrumb
    document.getElementById("rubro-breadcrumb").innerHTML = e;
    // Muestro el breadcrumb
    document.getElementById("rubros-footer").style.display = "block"; */

    /* reiniciarColoresSidenav();

    // Cambio colores del sidenav
    let z = document.getElementById(e);

    z.classList.add("active");
    z.classList.add("primary");
    z = document.getElementById(e + "-a");

    z.classList.add("white-text"); */

}

function getOrdenActual() {
    orden = JSON.parse(localStorage.getItem("orden_actual"));
    if (orden === null) {
        orden = [];
    }
}

function hidePreloader() {
    // Oculto el preloader al terminar la carga
    let preloader = document.querySelector("#preloader");
    preloader.style.display = "none";
    console.log("Carga terminada, escondo preloader");
}

function filterHTML(tabla, valor) {
    arrayArticulos = JSON.parse(localStorage.getItem("lista_articulos"));
    table = document.getElementById(tabla);
    let texto = document.getElementById('help-buscar');
    if (valor == "") {
        table.innerHTML = "";
        texto.style.display = "block"
        return;
    }
    valor = valor.toLowerCase();
    texto.style.display = "none"
    table.innerHTML = "";
    arrayArticulos.forEach(element => {
        let str = element.detalle;
        str = str.toLowerCase()

        if (str.startsWith(valor)) {
            table.innerHTML += `
            <tr class='item'>
                <td><img onclick="ampliarImagen(${element.codigo},'${element.descripcion}')" width="44" height="44" src="/view/img/${element.codigo}.jpg" alt="" class="circle"></td>
                <td class='left' style='text-align:left'>${element.detalle}<br>$${element.precio}</td>
                <td onclick=\"removeArticulo('${element.codigo}');\"><i class='material-icons primary-text size-circle'>remove_circle</i></td>
                <td><span id='${element.detalle}' class='${element.codigo}'>${element.cantidad}</span></td>
                <td onclick=\"addArticulo('${element.codigo}');\"><i class='material-icons primary-text size-circle'>add_circle</i></td>
            </tr>
            `
        }
    });
}

const capitalize = (s) => {
    if (typeof s !== 'string') return ''
    return s.charAt(0).toUpperCase() + s.slice(1).toLowerCase()
}


// Eventos
document.addEventListener("DOMContentLoaded", async () => {

    // Parseo a un array lo que obtengo del LocalStorage o si no hay datos llamo a traerDatos()
    arrayRubros = JSON.parse(localStorage.getItem("lista_rubros"));
    console.log(arrayRubros)

    if (arrayRubros === null) {
        arrayRubros = [];
        await traerDatos();
        arrayRubros = JSON.parse(localStorage.getItem("lista_rubros"));
        console.log(arrayRubros)
    }

    arrayArticulos = JSON.parse(localStorage.getItem("lista_articulos"));

    if (arrayArticulos === null) {
        arrayArticulos = []
        await traerDatos();
        arrayArticulos = JSON.parse(localStorage.getItem("lista_articulos"));
        console.log(arrayArticulos)
    }

    pintarTablaRubros("tabla_rubros");
    getOrdenActual();

});