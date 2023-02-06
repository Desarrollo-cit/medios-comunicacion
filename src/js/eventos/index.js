import { Dropdown, Tooltip, Modal, Alert } from "bootstrap";
import tinymce, { TinyMCE } from "tinymce";
import 'tinymce/themes/silver'
import 'tinymce/icons/default'
import 'tinymce/plugins/advlist'
import 'tinymce/plugins/lists'
import 'tinymce/models/dom/model'
import { Toast } from '../funciones';

import { validarFormulario } from "../funciones";
import Swal from "sweetalert2";

const L = require('leaflet')
const modalInformacion = new Modal(document.getElementById('modalIngreso'), {})
const modalCaptura = new Modal(document.getElementById('modalCaptura'), {})
const modalAsesinato = new Modal(document.getElementById('modalAsesinato'), {})
const formInformacion = document.querySelector('#formInformacion')
const divPills = document.getElementById('divPills')
const formCaptura = document.querySelector('#formCaptura')
const formAsesinatos = document.querySelector('#formAsesinatos')
const buttonAgregarInputsCaptura = document.getElementById('agregarInputscaptura');
const buttonQuitarInputsCaptura = document.getElementById('quitarInputscaptura');
const btnGuardarCaptura = document.getElementById('btnGuardarCaptura');
const btnModificarCaptura = document.getElementById('btnModificarCaptura');
const btnBorrarCaptura = document.getElementById('btnBorrarCaptura');
const buttonAgregarInputsAsesinatos = document.getElementById('agregarInputsAsesinatos');
const buttonQuitarInputsAsesinatos = document.getElementById('quitarInputsAsesinatos');
const btnGuardarAsesinatos = document.getElementById('btnGuardarAsesinatos');
const btnModificarAsesinatos = document.getElementById('btnModificarAsesinatos');
const btnBorrarAsesinatos = document.getElementById('btnBorrarCaptura');

const inicioInput = document.getElementById('inicio');
const finInput = document.getElementById('fin');

const map = L.map('map', {
    center: [15.825158, -89.72959],
    zoom: 7.5
})
const markers = L.layerGroup();
const LimpiarMapa = () => {
    map.eachLayer(layer => { markers.removeLayer(layer) })

}

const grayScale = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    maxZoom: 100,
    id: 'mapbox/streets-v11',
    tileSize: 512,
    zoomOffset: -1,
    accessToken: 'pk.eyJ1IjoiZGFuaWVsZmo5NzUiLCJhIjoiY2tpcWNlbHM0MXZmbDJ6dTZvdDV3NGticiJ9.7ciIi1FKO5-BqgE0zz5UFw'
}).addTo(map);



document.addEventListener('DOMContentLoaded', () => {
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new Tooltip(tooltipTriggerEl))

})

tinymce.init({
    selector: 'textarea',
    promotion: false,
    height: 500,
    menubar: true,
    plugins: [
        'lists ',
        'advlist',

    ],
    advlist_number_styles: 'default,lower-alpha,lower-greek,lower-roman,upper-alpha,upper-roman',
    toolbar: 'undo redo | formatselect | ' +
        'bold italic backcolor | alignleft aligncenter ' +
        'alignright alignjustify | bullist numlist advlist outdent indent | ' +
        'removeformat | help',
    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
});


const abreModal = e => {
    const punto = e.latlng;
    formInformacion.reset();
    formInformacion.latitud.value = punto.lat
    formInformacion.longitud.value = punto.lng
    formInformacion.buttonModificar.style.display = 'none'
    formInformacion.buttonEliminar.style.display = 'none'
    formInformacion.buttonGuardar.style.display = ''
    // formInformacion.municipio.innerHTML = ''
    formInformacion.latitud.readOnly = false
    formInformacion.longitud.readOnly = false
    // formInformacion.departamento.disabled = false
    // formInformacion.municipio.disabled = false
    modalInformacion.show();


}

const buscarMunicipio = async e => {
    let departamento = e.target.value;

    if (departamento == '') {
        Toast.fire({
            icon: 'warning',
            title: 'Seleccione un departamento'
        });
        formInformacion.municipio.disabled = true;

        return;
    }
    try {
        formInformacion.municipio.innerHTML = '';
        const url = `/medios-comunicacion/API/eventos/municipios?departamento=${departamento}`
        const headers = new Headers();
        headers.append("X-Requested-With", "fetch");

        const config = {
            method: 'GET',
        }

        const respuesta = await fetch(url, config);
        const data = await respuesta.json();

        let option = document.createElement('option');
        option.innerText = "SELECCIONE...";

        formInformacion.municipio.appendChild(option);

        data.forEach(el => {
            let option = document.createElement('option');
            option.value = el.codigo;
            option.innerText = el.descripcion
            formInformacion.municipio.appendChild(option);
        });

        formInformacion.municipio.disabled = false;

    } catch (error) {
        console.log(error);
    }
}


const guardarEvento = async e => {

    e.preventDefault();

    if (validarFormulario(formInformacion)) {


        const url = '/medios-comunicacion/API/eventos/guardar'

        const body = new FormData(formInformacion);
        const headers = new Headers();
        headers.append("X-Requested-With", "fetch");

        const config = {
            method: 'POST',
            headers,
            body
        }

        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        // console.log(data);
        seleccionarTopico(null, `divTopico${formInformacion.tipo.value}`, formInformacion.tipo.value);

        const { mensaje, codigo, detalle } = data;
        // const resultado = data.resultado;
        let icon = "";
        switch (codigo) {
            case 1:
                icon = "success"
                formInformacion.reset();
                modalInformacion.hide();
                break;
            case 2:
                icon = "warning"
                formInformacion.reset();

                break;
            case 3:
                icon = "error"

                break;
            case 4:
                icon = "error"
                console.log(detalle)

                break;

            default:
                break;
        }

        Toast.fire({
            icon: icon,
            title: mensaje,
        })


    } else {
        Toast.fire({
            icon: 'warning',
            title: 'Debe llenar todos los campos'
        });
    }

}

let topicos = [];
const seleccionarTopico = (e, iddiv, idregistro) => {
    // console.log(e);
    const div = document.getElementById(iddiv);
    if (div.classList.contains('bg-info')) {

        if (e) {
            div.classList.remove('bg-info')
            topicos = topicos.filter(el => el != div.dataset.id)
        }
    } else {

        div.classList.add('bg-info')
        topicos.push(idregistro)
    }
    // console.log(topicos);
    buscarEventos()
}

document.querySelectorAll('[id^=divTopico]').forEach(d => {
    d.addEventListener('click', (e) => {
        seleccionarTopico(e, d.id, d.dataset.id)
    })
})

let iconos = {
    "1": "handcuffs.png",
    "2": "murder.png",
    "9": "walk.png",
    "4": "pills.png",
    "5": "money-bag.png",
    "6": "rifle.png",
    "7": "disaster.png",
    "8": "dynamite.png",
    "10": "banner.png",
}

const buscarEventos = async e => {
    e && e.preventDefault();
    // map.removeLayer(markers)
    let inicio = inicioInput.value,
        fin = finInput.value;
    // console.log(inicio, fin);
    markers.clearLayers();
    try {
        const url = `/medios-comunicacion/API/eventos?topicos=${topicos}&fin=${fin}&inicio=${inicio}`
        const headers = new Headers();
        headers.append("X-Requested-With", "fetch");

        const config = {
            method: 'GET',
            headers
        }

        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        // console.log(data);

        if (data) {
            data.forEach(p => {
                let latlng = [p.latitud, p.longitud]

                const icon = crearIcono(`images/${iconos[p.tipo_id]}`);

                let marker = L.marker(latlng, { icon }).addTo(markers);
                marker.bindPopup(`
                    <p><b>Latitud: </b> ${p.latitud}</p>
                    <p><b>Longitud: </b> ${p.longitud}</p>
                    <p><b>Actividad vinculada: </b> ${p.actividad}</p>
                    <p><b>Tipo de topic: </b> ${p.tipo}</p>
                `);

                marker.addEventListener('contextmenu', e => {

                    switch (p.tipo_id) {
                        case '1':
                            modal1(e, p)
                            break;

                            case '2':
                            modal2(e, p)
                            break;

                    }
                })
                markers.addTo(map)
            })

            markers.addTo(map)
        } else {
            Toast.fire({
                icon: 'info',
                title: 'No hay datos registrados o seleccione un tópico'
            });
        }

    } catch (error) {
        console.log(error);
    }
}

const crearIcono = (nombre) => {
    const icon = L.icon({
        iconUrl: `${nombre}`,
        iconSize: [60, 40],
        iconAnchor: [16, 16],
    });

    return icon;
}

// MODAL 1
const divCapturados = document.getElementById('divCapturados');
let inputscapturas = 0;
const modal1 = async (e, punto) => {
    L.DomEvent.stopPropagation(e);


    recargarModalCaptura(punto.id)


    modalCaptura.show();



}

const divAsesinados = document.getElementById('divAsesinados');
let inputsasesinados = 0;
const modal2 = async (e, punto) => {
    L.DomEvent.stopPropagation(e);


    recargarModalAsesinatos(punto.id)


    modalAsesinato.show();



}

const recargarModalCaptura = async (id) => {
    formCaptura.reset()
    formCaptura.topico.value = id
    while (inputscapturas > 0) {
        quitarInputsCaptura();
    }
    try {
        const url = `/medios-comunicacion/API/capturas/buscar?topico=${id}`
        const headers = new Headers();
        headers.append("X-Requested-With", "fetch");

        const config = {
            method: 'GET',
            headers
        }

        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        const { captura, capturados } = data;
        // console.log(captura.info);
        // if(captura){
        tinymce.get('info').setContent(captura.info)
        // }
        if (capturados) {
            // console.log(data);
            capturados.forEach(c => {
                agregarInputsCaptura(null, c.id, c.nombre, c.edad, c.nacionalidad, c.sexo, c.delito, c.vinculo, true)
            })

        } 

        if (capturados || captura) {
        
           
            btnGuardarCaptura.disabled = true
            btnModificarCaptura.disabled = false


            btnGuardarCaptura.parentElement.style.display = 'none'
            btnModificarCaptura.parentElement.style.display = ''

        } else {
            btnGuardarCaptura.disabled = false
            btnModificarCaptura.disabled = true

            btnGuardarCaptura.parentElement.style.display = ''
            btnModificarCaptura.parentElement.style.display = 'none'

        }

    } catch (e) {
        console.log(e);
    }

    modalCaptura.show();



}
const recargarModalAsesinatos = async (id) => {
    formAsesinatos.reset()
    formAsesinatos.topico.value = id


    while (inputscapturas > 0) {
        quitarInputsCaptura();
    }

    try {
        const url = `/medios-comunicacion/API/asesinatos/buscar?topico=${id}`
        const headers = new Headers();
        headers.append("X-Requested-With", "fetch");

        const config = {
            method: 'GET',
            headers
        }

        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        const { asesinatos , asesinados } = data;
      
        console.log(data);

        tinymce.get('info').setContent(asesinatos.info)
        
        if(asesinatos && asesinados){
            tinymce.get('info').setContent(asesinatos.info)
           
            asesinados.forEach(a => {
                agregarInputsAsesinatos(null,a.id, a.nombre, a.edad, a.sexo,true)
            })

            btnGuardarCaptura.disabled = true
            btnModificarCaptura.disabled = false
            btnBorrarCaptura.disabled = false

            btnGuardarCaptura.parentElement.style.display = 'none'
            btnModificarCaptura.parentElement.style.display = ''
            btnBorrarCaptura.parentElement.style.display = ''
        }else{
            btnGuardarCaptura.disabled = false
            btnModificarCaptura.disabled = true
            btnBorrarCaptura.disabled = true

            btnGuardarCaptura.parentElement.style.display = ''
            btnModificarCaptura.parentElement.style.display = 'none'
            btnBorrarCaptura.parentElement.style.display = 'none'
        }

    }catch(e){
        console.log(e);
    }

    modalAsesinato.show();


}




const agregarInputsCaptura = async (e, id = '', nombre = '', edad = '', nacionalidad = '', sexo = '', delito = '', vinculo = "", boton = false) => {
    inputscapturas++;
    // console.log(inputscapturas);
    const fragment = document.createDocumentFragment();
    const divCuadro = document.createElement('div');
    const divRow = document.createElement('div');
    const divRow1 = document.createElement('div');
    const divRow2 = document.createElement('div');
    const divCol1 = document.createElement('div');
    const divCol2 = document.createElement('div');
    const divCol3 = document.createElement('div');
    const divCol4 = document.createElement('div');
    const divCol5 = document.createElement('div');
    const divCol6 = document.createElement('div');
    const inputIdRow = document.createElement('input');
    const input1 = document.createElement('input')
    const input2 = document.createElement('input')
    const select3 = document.createElement('select')
    const select4 = document.createElement('select')
    const select5 = document.createElement('select')
    const select = document.createElement('select')
    const label1 = document.createElement('label')
    const label2 = document.createElement('label')
    const label3 = document.createElement('label')
    const label4 = document.createElement('label')
    const label5 = document.createElement('label')
    const label6 = document.createElement('label')
    const buttonEliminar = document.createElement('button')
    const divColBoton = document.createElement('div');


    const option = document.createElement('option')
    option.value = ""
    option.innerText = "SELECCIONE..."
    select.appendChild(option)
    const option2 = document.createElement('option')
    option2.value = ""
    option2.innerText = "SELECCIONE..."
    select3.appendChild(option2)
    const option9 = document.createElement('option')
    option9.value = ""
    option9.innerText = "SELECCIONE..."
    select5.appendChild(option9)
    const option6 = document.createElement('option')
    option6.value = "1"
    option6.innerText = "MARA 18"
    const option7 = document.createElement('option')
    option7.value = "2"
    option7.innerText = "MARA SALVATRUCHA"
    const option8 = document.createElement('option')
    option8.value = "0"
    option8.innerText = "OTRO"

    select5.appendChild(option6)
    select5.appendChild(option7)
    select5.appendChild(option8)
    select4.appendChild(option9)


    divRow.classList.add("row", "justify-content-center");
    divCuadro.classList.add("col", "border", "rounded", "mb-2", "bg-light");

    divRow1.classList.add("row", "justify-content-start", "mb-2");
    divRow2.classList.add("row", "justify-content-start", "mb-2");
    divCol1.classList.add("col-lg-3");
    divCol2.classList.add("col-lg-3");
    divCol3.classList.add("col-lg-3");
    divCol4.classList.add("col-lg-3");
    divCol5.classList.add("col-lg-3");
    divCol6.classList.add("col-lg-3");
    divColBoton.classList.add("col-lg-3", 'd-flex', 'flex-column', 'justify-content-end');
    inputIdRow.name = `id_per[]`
    inputIdRow.id = `id_per[]`
    inputIdRow.type = 'hidden'
    input1.classList.add("form-control")
    input1.name = `nombre[]`
    input1.id = `nombre[]`
    input1.type = 'text'
    input1.required = true;
    input2.classList.add("form-control")
    input2.name = `edad[]`
    input2.id = `edad[]`
    input2.type = 'number'
    input2.required = true;

    select3.classList.add("form-control")
    select3.name = `nacionalidad[]`
    select3.id = `nacionalidad[]`
    select3.required = true;
    select4.classList.add("form-control")
    select4.name = `sexo[]`
    select4.id = `sexo[]`
    select4.required = true;
    select5.classList.add("form-control")
    select5.name = `vinculo[]`
    select5.id = `vinculo[]`
    select5.required = true;
    select.classList.add("form-control")
    select.name = `delito[]`
    select.id = `delito[]`
    select.required = true;
    label1.innerText = `Persona ${inputscapturas}`
    label1.htmlFor = `nombre[]`
    label2.innerText = `Edad `
    label2.htmlFor = `edad[]`
    label3.innerText = `Nacionalidad `
    label3.htmlFor = `nacionalidad[]`
    label4.innerText = `Delito `
    label4.htmlFor = `delito[]`
    label5.innerText = `Sexo `
    label5.htmlFor = `sexo[]`
    label6.innerText = `Relacion`
    label6.htmlFor = `vinculo[]`

    buttonEliminar.classList.add('btn', 'btn-danger', 'w-100')
    buttonEliminar.innerHTML = "<i class='bi bi-x-circle me-2'></i>Eliminar"
    buttonEliminar.type = 'button'
    divColBoton.appendChild(buttonEliminar);

    const headers = new Headers();
    headers.append("X-Requested-With", "fetch");

    const url3 = `/medios-comunicacion/API/nacionalidad/buscar`;
    const config3 = { method: "GET", headers }
    const response3 = await fetch(url3, config3);
    const nacionalidades = await response3.json()

    // console.log(nacionalidades);
    nacionalidades.forEach(nacionalidad => {
        const option_nacionalidad = document.createElement('option')
        option_nacionalidad.value = nacionalidad.id
        option_nacionalidad.innerText = `${nacionalidad.desc} `
        select3.appendChild(option_nacionalidad)
    })

    const url1 = `/medios-comunicacion/API/delitos/buscar`
    const config1 = { method: "GET", headers }
    const response1 = await fetch(url1, config1);
    const delitos = await response1.json()


    delitos.forEach(delito => {
        const option = document.createElement('option')
        option.value = delito.id
        option.innerText = `${delito.desc} `
        select.appendChild(option)
    })

    const url2 = `/medios-comunicacion/API/eventos/sexo`
    const config2 = { method: "GET", headers }
    const response2 = await fetch(url2, config2);
    const sexos = await response2.json()

    sexos.forEach(sexo => {
        const option_sexo = document.createElement('option')
        option_sexo.value = sexo.id
        option_sexo.innerText = `${sexo.desc} `
        select4.appendChild(option_sexo)
    })


    select.value = delito;
    input1.value = nombre;
    inputIdRow.value = id;
    input2.value = edad;
    select3.value = nacionalidad;
    select4.value = sexo;

    select5.value = vinculo;

    divCol1.appendChild(inputIdRow)
    divCol1.appendChild(label1)
    divCol1.appendChild(input1)
    divCol2.appendChild(label5)
    divCol2.appendChild(select4)
    divCol3.appendChild(label3)
    divCol3.appendChild(select3)
    divCol4.appendChild(label2)
    divCol4.appendChild(input2)
    divCol5.appendChild(label4)
    divCol5.appendChild(select)
    divCol6.appendChild(label6)
    divCol6.appendChild(select5)



    divRow1.appendChild(divCol1)
    divRow1.appendChild(divCol2)
    divRow1.appendChild(divCol4)
    if (boton) {
        divRow1.appendChild(divColBoton)
        buttonEliminar.addEventListener('click', (e) => eliminarCapturado(e, id))
    }
    divRow2.appendChild(divCol3)
    divRow2.appendChild(divCol5)
    divRow2.appendChild(divCol6)
    divCuadro.appendChild(divRow1)
    divCuadro.appendChild(divRow2)
    divRow.appendChild(divCuadro)
    fragment.appendChild(divRow)


    divCapturados.appendChild(fragment)
}
const agregarInputsAsesinatos = async (e, id = '', nombre = '', edad = '',  sexo = '',boton = false) => {
    inputscapturas++;
    // console.log(inputscapturas);
    const fragment = document.createDocumentFragment();
    const divCuadro = document.createElement('div');
    const divRow = document.createElement('div');
    const divRow1 = document.createElement('div');
    const divRow2 = document.createElement('div');
    const divCol1 = document.createElement('div');
    const divCol2 = document.createElement('div');
    const divCol3 = document.createElement('div');
    const divCol4 = document.createElement('div');
    const divCol5 = document.createElement('div');
    const divCol6 = document.createElement('div');
    const inputIdRow = document.createElement('input');
    const input1 = document.createElement('input')
    const input2 = document.createElement('input')
    const select3 = document.createElement('select')
    const select4 = document.createElement('select')
    const select5 = document.createElement('select')
    const select = document.createElement('select')
    const label1 = document.createElement('label')
    const label2 = document.createElement('label')
    const label3 = document.createElement('label')
    const label4 = document.createElement('label')
    const label5 = document.createElement('label')
    const label6 = document.createElement('label')
    const buttonEliminar = document.createElement('button')
    const divColBoton = document.createElement('div');


    const option = document.createElement('option')
    option.value = ""
    option.innerText = "SELECCIONE..."
    select.appendChild(option)
    const option2 = document.createElement('option')
    option2.value = ""
    option2.innerText = "SELECCIONE..."
    select3.appendChild(option2)
    const option9 = document.createElement('option')
    option9.value = ""
    option9.innerText = "SELECCIONE..."
    select5.appendChild(option9)
    const option6 = document.createElement('option')
    option6.value = "1"
    option6.innerText = "MARA 18"
    const option7 = document.createElement('option')
    option7.value = "2"
    option7.innerText = "MARA SALVATRUCHA"
    const option8 = document.createElement('option')
    option8.value = "0"
    option8.innerText = "OTRO"

    select5.appendChild(option6)
    select5.appendChild(option7)
    select5.appendChild(option8)
    select4.appendChild(option9)


    divRow.classList.add("row", "justify-content-center");
    divCuadro.classList.add("col", "border", "rounded", "mb-2", "bg-light");

    divRow1.classList.add("row", "justify-content-start", "mb-2");
    divRow2.classList.add("row", "justify-content-start", "mb-2");
    divCol1.classList.add("col-lg-3");
    divCol2.classList.add("col-lg-3");
    divCol3.classList.add("col-lg-3");
    divCol4.classList.add("col-lg-3");
    divCol5.classList.add("col-lg-3");
    divCol6.classList.add("col-lg-3");
    divColBoton.classList.add("col-lg-3", 'd-flex', 'flex-column', 'justify-content-end');
    inputIdRow.name = `id_per[]`
    inputIdRow.id = `id_per[]`
    inputIdRow.type = 'hidden'
    input1.classList.add("form-control")
    input1.name = `nombre[]`
    input1.id = `nombre[]`
    input1.type = 'text'
    input1.required = true;
    input2.classList.add("form-control")
    input2.name = `edad[]`
    input2.id = `edad[]`
    input2.type = 'number'
    input2.required = true;

    select3.classList.add("form-control")
    select3.name = `nacionalidad[]`
    select3.id = `nacionalidad[]`
    select3.required = true;
    select4.classList.add("form-control")
    select4.name = `sexo[]`
    select4.id = `sexo[]`
    select4.required = true;
    select5.classList.add("form-control")
    select5.name = `vinculo[]`
    select5.id = `vinculo[]`
    select5.required = true;
    select.classList.add("form-control")
    select.name = `delito[]`
    select.id = `delito[]`
    select.required = true;
    label1.innerText = `Persona ${inputscapturas}`
    label1.htmlFor = `nombre[]`
    label2.innerText = `Edad `
    label2.htmlFor = `edad[]`
    label3.innerText = `Nacionalidad `
    label3.htmlFor = `nacionalidad[]`
    label4.innerText = `Delito `
    label4.htmlFor = `delito[]`
    label5.innerText = `Sexo `
    label5.htmlFor = `sexo[]`
    label6.innerText = `Relacion`
    label6.htmlFor = `vinculo[]`

    buttonEliminar.classList.add('btn', 'btn-danger', 'w-100')
    buttonEliminar.innerHTML = "<i class='bi bi-x-circle me-2'></i>Eliminar"
    buttonEliminar.type = 'button'
    divColBoton.appendChild(buttonEliminar);

    const headers = new Headers();
    headers.append("X-Requested-With", "fetch");

    const url3 = `/medios-comunicacion/API/nacionalidad/buscar`;
    const config3 = { method: "GET", headers }
    const response3 = await fetch(url3, config3);
    const nacionalidades = await response3.json()

    // console.log(nacionalidades);
    nacionalidades.forEach(nacionalidad => {
        const option_nacionalidad = document.createElement('option')
        option_nacionalidad.value = nacionalidad.id
        option_nacionalidad.innerText = `${nacionalidad.desc} `
        select3.appendChild(option_nacionalidad)
    })

    const url1 = `/medios-comunicacion/API/delitos/buscar`
    const config1 = { method: "GET", headers }
    const response1 = await fetch(url1, config1);
    const delitos = await response1.json()


    delitos.forEach(delito => {
        const option = document.createElement('option')
        option.value = delito.id
        option.innerText = `${delito.desc} `
        select.appendChild(option)
    })

    const url2 = `/medios-comunicacion/API/eventos/sexo`
    const config2 = { method: "GET", headers }
    const response2 = await fetch(url2, config2);
    const sexos = await response2.json()

    sexos.forEach(sexo => {
        const option_sexo = document.createElement('option')
        option_sexo.value = sexo.id
        option_sexo.innerText = `${sexo.desc} `
        select4.appendChild(option_sexo)
    })


    select.value = delito;
    input1.value = nombre;
    inputIdRow.value = id;
    input2.value = edad;
    select3.value = nacionalidad;
    select4.value = sexo;

    select5.value = vinculo;

    divCol1.appendChild(inputIdRow)
    divCol1.appendChild(label1)
    divCol1.appendChild(input1)
    divCol2.appendChild(label5)
    divCol2.appendChild(select4)
    divCol3.appendChild(label3)
    divCol3.appendChild(select3)
    divCol4.appendChild(label2)
    divCol4.appendChild(input2)
    divCol5.appendChild(label4)
    divCol5.appendChild(select)
    divCol6.appendChild(label6)
    divCol6.appendChild(select5)



    divRow1.appendChild(divCol1)
    divRow1.appendChild(divCol2)
    divRow1.appendChild(divCol4)
    if (boton) {
        divRow1.appendChild(divColBoton)
        buttonEliminar.addEventListener('click', (e) => eliminarCapturado(e, id))
    }
    divRow2.appendChild(divCol3)
    divRow2.appendChild(divCol5)
    divRow2.appendChild(divCol6)
    divCuadro.appendChild(divRow1)
    divCuadro.appendChild(divRow2)
    divRow.appendChild(divCuadro)
    fragment.appendChild(divRow)


    divCapturados.appendChild(fragment)
}
const quitarInputsCaptura = () => {

    if (inputscapturas > 0) {
        divCapturados.removeChild(divCapturados.lastElementChild);
        inputscapturas--;

    } else {
        Toast.fire({
            icon: 'warning',
            title: 'No puede realizar esta acción'
        });
    }
}

const guardarCaptura = async e => {
    e.preventDefault();

    let info = tinymce.get('info').getContent()
    // console.log(info);
    if (validarFormulario(formCaptura, ['id_per[]', 'info']) && info != '') {

        // console.log('hola');
        try {

            const url = '/medios-comunicacion/API/capturas/guardar'

            const body = new FormData(formCaptura);
            body.append('info', info)
            const headers = new Headers();
            headers.append("X-Requested-With", "fetch");

            const config = {
                method: 'POST',
                headers,
                body
            }

            const respuesta = await fetch(url, config);
            const data = await respuesta.json();

            // console.log(data);
            const { mensaje, codigo, detalle } = data;
            // const resultado = data.resultado;
            let icon = "";
            switch (codigo) {
                case 1:
                    icon = "success"
                    recargarModalCaptura(formCaptura.topico.value)
                    break;
                case 2:
                    icon = "warning"
                    formCaptura.reset();

                    break;
                case 3:
                    icon = "error"

                    break;
                case 4:
                    icon = "error"
                    console.log(detalle)

                    break;

                default:
                    break;
            }

            Toast.fire({
                icon: icon,
                title: mensaje,
            })

        } catch (error) {
            console.log(error);
        }

    } else {
        Toast.fire({
            icon: 'warning',
            title: 'Debe llenar todos los campos'
        });
    }

}

const guardarAsesinatos = async e => {
    e.preventDefault();

    let info = tinymce.get('info').getContent()
    // console.log(info);
    if (validarFormulario(formCaptura, ['id_per[]', 'info']) && info != '') {

        // console.log('hola');
        try {

            const url = '/medios-comunicacion/API/capturas/guardar'

            const body = new FormData(formCaptura);
            body.append('info', info)
            const headers = new Headers();
            headers.append("X-Requested-With", "fetch");

            const config = {
                method: 'POST',
                headers,
                body
            }

            const respuesta = await fetch(url, config);
            const data = await respuesta.json();

            // console.log(data);
            const { mensaje, codigo, detalle } = data;
            // const resultado = data.resultado;
            let icon = "";
            switch (codigo) {
                case 1:
                    icon = "success"
                    recargarModalCaptura(formCaptura.topico.value)
                    break;
                case 2:
                    icon = "warning"
                    formCaptura.reset();

                    break;
                case 3:
                    icon = "error"

                    break;
                case 4:
                    icon = "error"
                    console.log(detalle)

                    break;

                default:
                    break;
            }

            Toast.fire({
                icon: icon,
                title: mensaje,
            })

        } catch (error) {
            console.log(error);
        }

    } else {
        Toast.fire({
            icon: 'warning',
            title: 'Debe llenar todos los campos'
        });
    }

}

const quitarInputsAsesinatos = () => {

    if (inputscapturas > 0) {
        divCapturados.removeChild(divCapturados.lastElementChild);
        inputscapturas--;

    } else {
        Toast.fire({
            icon: 'warning',
            title: 'No puede realizar esta acción'
        });
    }
}



const eliminarCapturado = async (e, id) => {
    Swal.fire({
        title: 'Confirmación',
        text: "¿Esta seguro que desea eliminar este registro?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Eliminar'
    }).then( async(result) => {
        if (result.isConfirmed) {
            try {

                const url = '/medios-comunicacion/API/capturas/capturado/eliminar'
    
                const body = new FormData();
                body.append('id', id)
                const headers = new Headers();
                headers.append("X-Requested-With", "fetch");
    
                const config = {
                    method: 'POST',
                    headers,
                    body
                }
    
                const respuesta = await fetch(url, config);
                const data = await respuesta.json();
    
                // console.log(data);
                // return 
                const { mensaje, codigo, detalle } = data;
                // const resultado = data.resultado;
                let icon = "";
                switch (codigo) {
                    case 1:
                        icon = "success"
                        recargarModalCaptura(formCaptura.topico.value)
                        break;
                    case 2:
                        icon = "warning"
                        formCaptura.reset();
    
                        break;
                    case 3:
                        icon = "error"
    
                        break;
                    case 4:
                        icon = "error"
                        console.log(detalle)
    
                        break;
    
                    default:
                        break;
                }
    
                Toast.fire({
                    icon: icon,
                    title: mensaje,
                })
    
            } catch (error) {
                console.log(error);
            }
        }
    })
}

const eliminarCaptura = async (e) => {
    Swal.fire({
        title: 'Confirmación',
        text: "¿Esta seguro que desea eliminar esta captura?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Eliminar'
    }).then( async(result) => {
        if (result.isConfirmed) {
            try {

                const url = '/medios-comunicacion/API/capturas/eliminar'
    
                const body = new FormData();
                body.append('topico', formCaptura.topico.value)
                const headers = new Headers();
                headers.append("X-Requested-With", "fetch");
    
                const config = {
                    method: 'POST',
                    headers,
                    body
                }
    
                const respuesta = await fetch(url, config);
                const data = await respuesta.json();
    
                console.log(data);
                // return 
                const { mensaje, codigo, detalle } = data;
                // const resultado = data.resultado;
                let icon = "";
                switch (codigo) {
                    case 1:
                        icon = "success"
                        modalCaptura.hide()
                        buscarEventos()
                        break;
                    case 2:
                        icon = "warning"
                        formCaptura.reset();
    
                        break;
                    case 3:
                        icon = "error"
    
                        break;
                    case 4:
                        icon = "error"
                        console.log(detalle)
    
                        break;
    
                    default:
                        break;
                }
    
                Toast.fire({
                    icon: icon,
                    title: mensaje,
                })
    
            } catch (error) {
                console.log(error);
            }
        }
    })
}



const modificarCaptura = async e => {
    e.preventDefault();

    let info = tinymce.get('info').getContent()
    if (validarFormulario(formCaptura, ['id_per[]', 'info']) && info != '') {

        // console.log('hola');
        try {

            const url = '/medios-comunicacion/API/capturas/modificar'

            const body = new FormData(formCaptura);
            body.append('info', info)
            const headers = new Headers();
            headers.append("X-Requested-With", "fetch");

            const config = {
                method: 'POST',
                headers,
                body
            }

            const respuesta = await fetch(url, config);
            const data = await respuesta.json();

            // console.log(data);
            // return 
            const { mensaje, codigo, detalle } = data;
            // const resultado = data.resultado;
            let icon = "";
            switch (codigo) {
                case 1:
                    icon = "success"
                    recargarModalCaptura(formCaptura.topico.value)
                    break;
                case 2:
                    icon = "warning"
                    formCaptura.reset();

                    break;
                case 3:
                    icon = "error"

                    break;
                case 4:
                    icon = "error"
                    console.log(detalle)

                    break;

                default:
                    break;
            }

            Toast.fire({
                icon: icon,
                title: mensaje,
            })

        } catch (error) {
            console.log(error);
        }

    } else {
        Toast.fire({
            icon: 'warning',
            title: 'Debe llenar todos los campos'
        });
    }

}

map.on('click', abreModal)
formInformacion.departamento.addEventListener('change', buscarMunicipio)
formInformacion.addEventListener('submit', guardarEvento)
inicioInput.addEventListener('change', buscarEventos)
finInput.addEventListener('change', buscarEventos)
btnModificarCaptura.addEventListener('click', modificarCaptura)
btnBorrarCaptura.addEventListener('click', eliminarCaptura );
buttonAgregarInputsCaptura.addEventListener('click', agregarInputsCaptura)
buttonQuitarInputsCaptura.addEventListener('click', quitarInputsCaptura)
buttonAgregarInputsAsesinatos.addEventListener('click', agregarInputsAsesinatos)
buttonQuitarInputsAsesinatos.addEventListener('click', quitarInputsAsesinatos)
formCaptura.addEventListener('submit', guardarCaptura)
formAsesinatos.addEventListener('submit', guardarAsesinatos)