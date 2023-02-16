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

import L from "leaflet"
import 'leaflet-easyprint'
const modalInformacion = new Modal(document.getElementById('modalIngreso'), {})
const modalCaptura = new Modal(document.getElementById('modalCaptura'), {})
const modalAsesinato = new Modal(document.getElementById('modalAsesinato'), {})
const modalMigrantes = new Modal(document.getElementById('modalMigrantes'), {})
const modalDroga = new Modal(document.getElementById('modalDrogas'), {})
const modalArmas = new Modal(document.getElementById('modalArmas'), {})
const formInformacion = document.querySelector('#formInformacion')
const divPills = document.getElementById('divPills')
const formCaptura = document.querySelector('#formCaptura')
const formAsesinatos = document.querySelector('#formAsesinatos')
const formDroga = document.querySelector('#formDroga')
const formArmas = document.querySelector('#formArmas')
const formMigrantes = document.querySelector('#formMigrantes')
const buttonAgregarInputsCaptura = document.getElementById('agregarInputscaptura');
const buttonQuitarInputsCaptura = document.getElementById('quitarInputscaptura');
const buttonAgregarInputsCapturaDroga = document.getElementById('agregarInputscapturaDroga');
const buttonQuitarInputsCapturaDroga = document.getElementById('quitarInputscapturaDroga');
const btnGuardarCaptura = document.getElementById('btnGuardarCaptura');
const btnModificarCaptura = document.getElementById('btnModificarCaptura');
const btnBorrarCaptura = document.getElementById('btnBorrarCaptura');
const btnGuardarCapturaDroga = document.getElementById('btnGuardarCapturaDroga');
const btnModificarCapturaDroga = document.getElementById('btnModificarCapturaDroga');
const btnBorrarCapturaDroga = document.getElementById('btnBorrarCapturaDroga');
const buttonAgregarInputsAsesinatos = document.getElementById('agregarInputsAsesinatos');
const buttonQuitarInputsAsesinatos = document.getElementById('quitarInputsAsesinatos');
const buttonAgregarInputsArmas = document.getElementById('agregarInputsArmas');
const buttonQuitarInputsArmas = document.getElementById('quitarInputsArmas');
const buttonAgregarInputsMunicion = document.getElementById('agregarInputsMunicion');
const buttonQuitarInputsMunicion = document.getElementById('quitarInputsMunicion');
const btnGuardarAsesinatos = document.getElementById('btnGuardarAsesinados');
const btnModificarAsesinatos = document.getElementById('btnModificarAsesinados');
const btnBorrarAsesinatos = document.getElementById('btnBorrarAsesinados');
const btnGuardarArmas = document.getElementById('btnGuardarArmas');
const btnModificarArmas = document.getElementById('btnModificarArmas');
const btnBorrarArmas = document.getElementById('btnBorrarArmas');
const divCapturados = document.getElementById('divCapturados');
let inputscapturas = 0;
const divCapturadosDroga = document.getElementById('divCapturadosDroga');
let inputsDrogas = 0;
const divArmas = document.getElementById('divArmas');
let inputsArmas = 0;
const divMunicion = document.getElementById('divMunicion');
let inputsMunicion = 0;

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

L.easyPrint({
	title: 'Imprimir vista actual',
	position: 'topright',
	sizeModes: ['A4Portrait', 'A4Landscape']
}).addTo(map);
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
        console.log(data);

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
                    <p><b>Ingresado por: </b> ${p.dependencia}</p>
                `);

                marker.addEventListener('contextmenu', e => {

                    switch (p.tipo_id) {
                        case '1':
                            modal1(e, p)
                            break;

                            case '2':
                            modal2(e, p)
                            break;
                            case '4':
                            modal4(e, p)
                            break;
                            case '6':
                            modal6(e, p)
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

const modal1 = async (e, punto) => {
    L.DomEvent.stopPropagation(e);


    recargarModalCaptura(punto.id)


    modalCaptura.show();



}

const divAsesinados = document.getElementById('divAsesinados');
let inputsasesinados = 0;

//MODAL 2
const modal2 = async (e, punto) => {
    L.DomEvent.stopPropagation(e);


    recargarModalAsesinatos(punto.id)


    modalAsesinato.show();



}
// MODAL 4
const modal4 = async (e, punto) => {
    L.DomEvent.stopPropagation(e);


    recargarModalDroga(punto.id)


    modalDroga.show();



}
const modal6 = async (e, punto) => {
    L.DomEvent.stopPropagation(e);


    recargarModalArmas(punto.id)


    modalArmas.show();



}
const recargarModalCaptura = async (id) => {
    formCaptura.reset()
    formCaptura.topico.value = id
    while (inputscapturas > 0) {
        quitarInputsCaptura(0, divCapturados);
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
        console.log(data);
        const { captura, capturados } = data;

        // if(captura){
        captura && tinymce.get('info').setContent(captura.info)
        // }
        if (capturados) {
            // console.log(data);
            capturados.forEach(c => {
                agregarInputsCaptura(null, c.id, c.nombre, c.edad, c.nacionalidad, c.sexo, c.delito, c.vinculo, true, 0, divCapturados)
            })

        } 

        if (capturados.length > 0 && captura) {
        
           
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


    while (inputsasesinados > 0) {
        quitarInputsAsesinatos();
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
              
        console.log(asesinatos.info);
        tinymce.get('info2').setContent(asesinatos.info)

     
        
        if(asesinatos || asesinados){
      

            asesinados.forEach(a => {
                agregarInputsAsesinatos(null,a.id, a.nombre, a.edad, a.sexo,true)
            })

            btnGuardarAsesinatos.disabled = true
            btnModificarAsesinatos.disabled = false
            btnBorrarAsesinatos.disabled = false

            btnGuardarAsesinatos.parentElement.style.display = 'none'
            btnModificarAsesinatos.parentElement.style.display = ''
            btnBorrarAsesinatos.parentElement.style.display = ''
        }else{
            btnGuardarAsesinatos.disabled = false
            btnModificarAsesinatos.disabled = true
            btnBorrarAsesinatos.disabled = true

            btnGuardarAsesinatos.parentElement.style.display = ''
            btnModificarAsesinatos.parentElement.style.display = 'none'
            btnBorrarAsesinatos.parentElement.style.display = 'none'
        }

    }catch(e){
        console.log(e);
    }

    modalAsesinato.show();


}
const recargarModalDroga = async (id) => {
    formDroga.reset()
    formDroga.topico.value = id
    while (inputsDrogas > 0) {
        console.log(inputsDrogas);
        quitarInputsCaptura(1, divCapturadosDroga);
    }
    try {
        const url = `/medios-comunicacion/API/incautacion/buscar?topico=${id}`
        const headers = new Headers();
        headers.append("X-Requested-With", "fetch");

        const config = {
            method: 'GET',
            headers
        }

        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log(data);
        const { evento, incautacion , capturados } = data;

    //     // if(captura){
        evento && tinymce.get('info_incautacion').setContent(evento.info)

        formDroga.cantidad.value = incautacion.cantidad
        formDroga.cantidad_plantacion.value = incautacion.cantidad_plantacion
        formDroga.matricula.value = incautacion.matricula
        formDroga.tipo_droga_plantacion.value = incautacion.tip_droga_plantacion
        formDroga.tipo_droga.value = incautacion.tipo_droga
        formDroga.tipo_transporte.value = incautacion.tipo_transporte
        formDroga.transporte.value = incautacion.transporte

    //     // }
        if (capturados) {
            // console.log(data);
            capturados.forEach(c => {
                agregarInputsCaptura(null, c.id, c.nombre, c.edad, c.nacionalidad, c.sexo, c.delito, c.vinculo, true, 1, divCapturadosDroga)
            })

        } 

        if (capturados.length > 0 && evento && incautacion) {
        
           
            btnGuardarCapturaDroga.disabled = true
            btnModificarCapturaDroga.disabled = false


            btnGuardarCapturaDroga.parentElement.style.display = 'none'
            btnModificarCapturaDroga.parentElement.style.display = ''
            
        } else {
            btnGuardarCapturaDroga.disabled = false
            btnModificarCapturaDroga.disabled = true
            
            btnGuardarCapturaDroga.parentElement.style.display = ''
            btnModificarCapturaDroga.parentElement.style.display = 'none'

        }

    } catch (e) {
        console.log(e);
    }

    modalDroga.show();



}
const recargarModalArmas = async (id) => {
    formArmas.reset()
    formArmas.topico.value = id
    while (inputsArmas > 0) {
        quitarInputsArmas();
    }
    while (inputsMunicion > 0) {
        quitarInputsMunicion();
    }
    try {
        const url = `/medios-comunicacion/API/incautacion_armas/buscar?topico=${id}`
        const headers = new Headers();
        headers.append("X-Requested-With", "fetch");

        const config = {
            method: 'GET',
            headers
        }

        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log(data);
        const { evento, armas , municion } = data;

        evento && tinymce.get('info_incautacion_armas').setContent(evento.info)

        if (armas) {
            // console.log(data);
            armas.forEach(arma => {
                agregarInputsArmas(null, arma.id, arma.cantidad, arma.tipo_arma, arma.calibre, true)
            })

        } 
        if (municion) {
            // console.log(data);
            municion.forEach(municion => {
                agregarInputsMunicion(null, municion.id, municion.cantidad,municion.calibre, true)
            })

        } 

        if (armas.length > 0 && evento && municion.length > 0) {
        
           
            btnGuardarArmas.disabled = true
            btnModificarArmas.disabled = false


            btnGuardarArmas.parentElement.style.display = 'none'
            btnModificarArmas.parentElement.style.display = ''
            
        } else {
            btnGuardarArmas.disabled = false
            btnModificarArmas.disabled = true
            
            btnGuardarArmas.parentElement.style.display = ''
            btnModificarArmas.parentElement.style.display = 'none'

        }

    } catch (e) {
        console.log(e);
    }




}



const agregarInputsCaptura = async (e, id = '', nombre = '', edad = '', nacionalidad = '', sexo = '', delito = '', vinculo = "", boton = false, contador , divInputs) => {
    let cantidad = 0
    switch (contador) {
        case 0:
            cantidad = ++inputscapturas;
            
            break;
        case 1:
            cantidad = ++inputsDrogas;
            
            break;
    }
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
    label1.innerText = `Persona ${cantidad}`
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
        buttonEliminar.addEventListener('click', (e) => eliminarCapturado(e, id, contador))
    }
    divRow2.appendChild(divCol3)
    divRow2.appendChild(divCol5)
    divRow2.appendChild(divCol6)
    divCuadro.appendChild(divRow1)
    divCuadro.appendChild(divRow2)
    divRow.appendChild(divCuadro)
    fragment.appendChild(divRow)


    divInputs.appendChild(fragment)
}
const agregarInputsAsesinatos = async (e, id = '', nombre = '', edad = '',  sexo = '',boton = false) => {
    inputsasesinados++;
    // console.log(inputscapturas);
    const fragment = document.createDocumentFragment();
    const divCuadro = document.createElement('div');
    const divRow = document.createElement('div');
    const divRow1 = document.createElement('div');
   
    const divCol1 = document.createElement('div');
    const divCol2 = document.createElement('div');
    const divCol3 = document.createElement('div');
    
    const inputIdRow = document.createElement('input');
    const input1 = document.createElement('input')
    const input2 = document.createElement('input')
    const select3 = document.createElement('select')
    const select = document.createElement('select')
    const label1 = document.createElement('label')
    const label2 = document.createElement('label')
    const label3 = document.createElement('label')
    const buttonEliminar = document.createElement('button')
    const divColBoton = document.createElement('div');

    divRow.classList.add("row", "justify-content-center");
    divCuadro.classList.add("col", "border", "rounded", "mb-2", "bg-light");
    divRow1.classList.add("row", "justify-content-start", "mb-2");
    divCol1.classList.add("col-lg-3");
    divCol2.classList.add("col-lg-3");
    divCol3.classList.add("col-lg-3");
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
    select3.name = `sexo[]`
    select3.id = `sexo[]`
    select3.required = true;
    select.required = true;
    label1.innerText = `Persona ${inputsasesinados}`
    label1.htmlFor = `nombre[]`
    label2.innerText = `Edad `
    label2.htmlFor = `edad[]`
    label3.innerText = `Sexo `
    label3.htmlFor = `sexo[]`

    buttonEliminar.classList.add('btn', 'btn-danger', 'w-100')
    buttonEliminar.innerHTML = "<i class='bi bi-x-circle me-2'></i>Eliminar"
    buttonEliminar.type = 'button'
    divColBoton.appendChild(buttonEliminar);

    const headers = new Headers();
    headers.append("X-Requested-With", "fetch");


    const url2 = `/medios-comunicacion/API/eventos/sexo`
    const config2 = { method: "GET", headers }
    const response2 = await fetch(url2, config2);
    const sexos = await response2.json()

    sexos.forEach(sexo => {
        const option_sexo = document.createElement('option')
        option_sexo.value = sexo.id
        option_sexo.innerText = `${sexo.desc} `
        select3.appendChild(option_sexo)
    })


    input1.value = nombre;
    inputIdRow.value = id;
    input2.value = edad;
    select3.value = sexo;


    divCol1.appendChild(inputIdRow)
    divCol1.appendChild(label1)
    divCol1.appendChild(input1)
    divCol2.appendChild(label2)
    divCol2.appendChild(input2)
    divCol3.appendChild(label3)
    divCol3.appendChild(select3)

    divRow1.appendChild(divCol1)
    divRow1.appendChild(divCol2)
    divRow1.appendChild(divCol3)
    if (boton) {
        divRow1.appendChild(divColBoton)
        buttonEliminar.addEventListener('click', (e) => eliminarAsesinado(e, id))
    }

    divCuadro.appendChild(divRow1)
    divRow.appendChild(divCuadro)
    fragment.appendChild(divRow)


    divAsesinados.appendChild(fragment)
}
const agregarInputsArmas = async (e, id = '', cantidad = '', tipo = '',  calibre = '',boton = false) => {
    inputsArmas++;
    // console.log(inputscapturas);
    const fragment = document.createDocumentFragment();
    const divCuadro = document.createElement('div');
    const divExterno = document.createElement('div');
    const divRow = document.createElement('div');
   
    const divColCantidad = document.createElement('div');
    const divColTipo = document.createElement('div');
    const divColCalibre = document.createElement('div');
    const divColBoton = document.createElement('div');
    
    const inputIdRow = document.createElement('input');
    const inputCantidad = document.createElement('input')
    const selectTipo = document.createElement('select')
    const selectCalibre = document.createElement('select')
    const label1 = document.createElement('label')
    const label2 = document.createElement('label')
    const label3 = document.createElement('label')
    const buttonEliminar = document.createElement('button')

    divExterno.classList.add("row", "justify-content-center");
    divRow.classList.add("row", "justify-content-start");
    divCuadro.classList.add("col", "border", "rounded", "mb-2", "bg-light", 'p-3');
    divColCantidad.classList.add("col-lg-3");
    divColTipo.classList.add("col-lg-3");
    divColCalibre.classList.add("col-lg-3");
    divColBoton.classList.add("col-lg-3", 'd-flex', 'flex-column', 'justify-content-end');
    inputIdRow.name = `id_registro[]`
    inputIdRow.id = `id_registro[]`
    inputIdRow.type = 'hidden'
    inputCantidad.classList.add("form-control")
    inputCantidad.name = `cantidad[]`
    inputCantidad.id = `cantidad[]`
    inputCantidad.type = 'number'
    inputCantidad.required = true;

    selectTipo.classList.add("form-control")
    selectTipo.name = `tipo[]`
    selectTipo.id = `tipo[]`
    selectTipo.required = true;
    
    selectCalibre.classList.add("form-control")
    selectCalibre.name = `calibre[]`
    selectCalibre.id = `calibre[]`
    selectCalibre.required = true;

    label1.innerText = `Tipo arma ${inputsArmas}`
    label2.innerText = `Calibre arma ${inputsArmas}`
    label3.innerText = `Cantidad`

    buttonEliminar.classList.add('btn', 'btn-danger', 'w-100')
    buttonEliminar.innerHTML = "<i class='bi bi-x-circle me-2'></i>Eliminar"
    buttonEliminar.type = 'button'

    divColBoton.appendChild(buttonEliminar);

    const optionVacio1 = document.createElement('option')
    optionVacio1.value = ""
    optionVacio1.innerText = "SELECCIONE..."

    const optionVacio2 = optionVacio1.cloneNode(true)

    selectTipo.appendChild(optionVacio1)
    selectCalibre.appendChild(optionVacio2)

    const headers = new Headers();
    headers.append("X-Requested-With", "fetch");


    const urlTipos = `/medios-comunicacion/API/armas/buscar`
    const configTipos = { method: "GET", headers }
    const responseTipos = await fetch(urlTipos, configTipos);
    const tipos = await responseTipos.json()

    tipos.forEach(tipo => {
        const option = document.createElement('option')
        option.value = tipo.id
        option.innerText = `${tipo.desc} `
        selectTipo.appendChild(option)
    })
    
    const urlCalibres = `/medios-comunicacion/API/calibres/buscar`
    const configCalibres = { method: "GET", headers }
    const responseCalibres = await fetch(urlCalibres, configCalibres);
    const calibres = await responseCalibres.json()

    calibres.forEach(tipo => {
        const option = document.createElement('option')
        option.value = tipo.id
        option.innerText = `${tipo.desc} `
        selectCalibre.appendChild(option)
    })


    inputCantidad.value = cantidad;
    inputIdRow.value = id;
    selectTipo.value = tipo;
    selectCalibre.value = calibre;


    divColTipo.appendChild(inputIdRow)
    divColTipo.appendChild(label1)
    divColTipo.appendChild(selectTipo)
    divColCalibre.appendChild(label2)
    divColCalibre.appendChild(selectCalibre)
    divColCantidad.appendChild(label3)
    divColCantidad.appendChild(inputCantidad)

    divRow.appendChild(divColTipo)
    divRow.appendChild(divColCalibre)
    divRow.appendChild(divColCantidad)
    if (boton) {
        divRow.appendChild(divColBoton)
        buttonEliminar.addEventListener('click', (e) => eliminarArmamento(e, id))
    }

    divCuadro.appendChild(divRow)
    divExterno.appendChild(divCuadro)
    fragment.appendChild(divExterno)


    divArmas.appendChild(fragment)
}

const agregarInputsMunicion = async (e, id = '', cantidad = '', calibre = '',boton = false) => {
    inputsMunicion++;
    // console.log(inputscapturas);
    const fragment = document.createDocumentFragment();
    const divCuadro = document.createElement('div');
    const divExterno = document.createElement('div');
    const divRow = document.createElement('div');
   
    const divColCantidad = document.createElement('div');
    const divColCalibre = document.createElement('div');
    const divColBoton = document.createElement('div');
    
    const inputIdRow = document.createElement('input');
    const inputCantidad = document.createElement('input')
    const selectCalibre = document.createElement('select')
    const label1 = document.createElement('label')
    const label2 = document.createElement('label')
    const buttonEliminar = document.createElement('button')

    divExterno.classList.add("row", "justify-content-center");
    divRow.classList.add("row", "justify-content-start");
    divCuadro.classList.add("col", "border", "rounded", "mb-2", "bg-light", 'p-3');
    divColCantidad.classList.add("col-lg-4");
    divColCalibre.classList.add("col-lg-5");
    divColBoton.classList.add("col-lg-3", 'd-flex', 'flex-column', 'justify-content-end');
    inputIdRow.name = `id_registro_municion[]`
    inputIdRow.id = `id_registro_municion[]`
    inputIdRow.type = 'hidden'
    inputCantidad.classList.add("form-control")
    inputCantidad.name = `cantidad_municion[]`
    inputCantidad.id = `cantidad_municion[]`
    inputCantidad.type = 'number'
    inputCantidad.required = true;
   
    selectCalibre.classList.add("form-control")
    selectCalibre.name = `calibre_municion[]`
    selectCalibre.id = `calibre_municion[]`
    selectCalibre.required = true;

    label1.innerText = `Calibre arma ${inputsMunicion}`
    label2.innerText = `Cantidad `


    buttonEliminar.classList.add('btn', 'btn-danger', 'w-100')
    buttonEliminar.innerHTML = "<i class='bi bi-x-circle me-2'></i>Eliminar"
    buttonEliminar.type = 'button'

    divColBoton.appendChild(buttonEliminar);

    const optionVacio2 = document.createElement('option')
    optionVacio2.value = ""
    optionVacio2.innerText = "SELECCIONE..."

 


    selectCalibre.appendChild(optionVacio2)

    const headers = new Headers();
    headers.append("X-Requested-With", "fetch");

    const urlCalibres = `/medios-comunicacion/API/calibres/buscar`
    const configCalibres = { method: "GET", headers }
    const responseCalibres = await fetch(urlCalibres, configCalibres);
    const calibres = await responseCalibres.json()

    calibres.forEach(tipo => {
        const option = document.createElement('option')
        option.value = tipo.id
        option.innerText = `${tipo.desc} `
        selectCalibre.appendChild(option)
    })


    inputCantidad.value = cantidad;
    inputIdRow.value = id;
    selectCalibre.value = calibre;



    divColCalibre.appendChild(inputIdRow)
    divColCalibre.appendChild(label1)
    divColCalibre.appendChild(selectCalibre)
    divColCantidad.appendChild(label2)
    divColCantidad.appendChild(inputCantidad)


    divRow.appendChild(divColCalibre)
    divRow.appendChild(divColCantidad)
    if (boton) {
        divRow.appendChild(divColBoton)
        buttonEliminar.addEventListener('click', (e) => eliminarMunicion(e, id))
    }

    divCuadro.appendChild(divRow)
    divExterno.appendChild(divCuadro)
    fragment.appendChild(divExterno)


    divMunicion.appendChild(fragment)
}


const quitarInputsCaptura = (contador, divInputs) => {

    if (inputscapturas > 0 || inputsDrogas > 0) {
        divInputs.removeChild(divInputs.lastElementChild);
        switch (contador) {
            case 0:
                inputscapturas--;
                
                break;
            case 1:
                inputsDrogas--;
                
                break;
        }

    } else {
        Toast.fire({
            icon: 'warning',
            title: 'No puede realizar esta acción'
        });
    }
}

const quitarInputsAsesinatos = () => {

    if (inputsasesinados > 0) {
        divAsesinados.removeChild(divAsesinados.lastElementChild);
        inputsasesinados--;

    } else {
        Toast.fire({
            icon: 'warning',
            title: 'No puede realizar esta acción'
        });
    }
}

const quitarInputsArmas = () => {

    if (inputsArmas > 0) {
        divArmas.removeChild(divArmas.lastElementChild);
        inputsArmas--;

    } else {
        Toast.fire({
            icon: 'warning',
            title: 'No puede realizar esta acción'
        });
    }
}
const quitarInputsMunicion = () => {

    if (inputsMunicion > 0) {
        divMunicion.removeChild(divMunicion.lastElementChild);
        inputsMunicion--;

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

const guardarIncautacion = async e => {
    e.preventDefault();

    let info = tinymce.get('info_incautacion').getContent()
    // console.log(info);
    if (validarFormulario(formDroga, ['id_per[]', 'info_incautacion']) && info != '') {

        // console.log('hola');
        try {

            const url = '/medios-comunicacion/API/incautacion/guardar'

            const body = new FormData(formDroga);
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

            console.log(data);

            const { mensaje, codigo, detalle } = data;
            // const resultado = data.resultado;
            let icon = "";
            switch (codigo) {
                case 1:
                    icon = "success"
                    recargarModalDroga(formDroga.topico.value)
                    break;
                case 2:
                    icon = "warning"
                    formDroga.reset();

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
const guardarIncautacionArmamento = async e => {
    e.preventDefault();

    let info = tinymce.get('info_incautacion_armas').getContent()
    console.log(info);
    if (validarFormulario(formArmas, ['id_registro[]','id_registro_municion[]', 'info_incautacion_armas']) && info != '') {

        // console.log('hola');
        try {

            const url = '/medios-comunicacion/API/incautacion_armas/guardar'

            const body = new FormData(formArmas);
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

            console.log(data);

            const { mensaje, codigo, detalle } = data;
            // const resultado = data.resultado;
            let icon = "";
            switch (codigo) {
                case 1:
                    icon = "success"
                    recargarModalArmas(formArmas.topico.value)
                    break;
                case 2:
                    icon = "warning"
                    formArmas.reset();

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

    let info = tinymce.get('info2').getContent()
    console.log(info);

 
    if (validarFormulario(formAsesinatos, ['id_per[]', 'info2']) && info != '') {

        // console.log('hola');
        try {

            const url = '/medios-comunicacion/API/asesinatos/guardar'

            const body = new FormData(formAsesinatos);
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
                    recargarModalAsesinatos(formAsesinatos.topico.value)
                    break;
                case 2:
                    icon = "warning"
                    formAsesinatos.reset();

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

const eliminarCapturado = async (e, id, contador) => {
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
                        switch (contador) {
                            case 0:
                                recargarModalCaptura(formCaptura.topico.value)
                                
                                break;
                            case 1 :
                                recargarModalDroga(formDroga.topico.value)
                                break;
                            default:
                                break;
                        }
                        break;
                    case 2:
                        icon = "warning"
                        switch (contador) {
                            case 0:
                                    recargarModalCaptura(formCaptura.topico.value)
                                    formCaptura.reset();
                                
                                break;
                                case 1 :
                                    recargarModalDroga(formDroga.topico.value)
                                    formDroga.reset();
                                break;
                            default:
                                break;
                        }
    
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

const eliminarAsesinado = async (e, id) => {
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

                const url = '/medios-comunicacion/API/asesinatos/asesinado/eliminar'
    
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
                        recargarModalAsesinatos(formAsesinatos.topico.value)
                        break;
                    case 2:
                        icon = "warning"
                        formAsesinatos.reset();
    
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

const eliminarAsesinato = async (e) => {
    Swal.fire({
        title: 'Confirmación',
        text: "¿Esta seguro que desea eliminar este Asesinato?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Eliminar'
    }).then( async(result) => {
        if (result.isConfirmed) {
            try {

                const url = '/medios-comunicacion/API/asesinatos/eliminar'
    
                const body = new FormData();
                body.append('topico', formAsesinatos.topico.value)
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
                        modalAsesinato.hide()
                        buscarEventos()
                        break;
                    case 2:
                        icon = "warning"
                        formAsesinatos.reset();
    
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

const eliminarIncautacion = async (e) => {
    Swal.fire({
        title: 'Confirmación',
        text: "¿Esta seguro que desea eliminar esta incautación?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Eliminar'
    }).then( async(result) => {
        if (result.isConfirmed) {
            try {

                const url = '/medios-comunicacion/API/incautacion/eliminar'
    
                const body = new FormData();
                body.append('topico', formDroga.topico.value)
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
                        modalDroga.hide()
                        buscarEventos()
                        break;
                    case 2:
                        icon = "warning"
                        formDroga.reset();
    
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
const modificarIncautacion = async e => {
    e.preventDefault();

    // alert("hola")
    // return

    let info = tinymce.get('info_incautacion').getContent()
        
    // console.log(info);
    if (validarFormulario(formDroga, ['id_per[]', 'info_incautacion']) && info != '') {

        // console.log('hola');
        try {

            const url = '/medios-comunicacion/API/incautacion/modificar'

            const body = new FormData(formDroga);
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

            console.log(data);
            // return 
            const { mensaje, codigo, detalle } = data;
            // const resultado = data.resultado;
            let icon = "";
            switch (codigo) {
                case 1:
                    icon = "success"
                    recargarModalArmas(formDroga.topico.value)
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

const modificarAsesinato = async e => {
    e.preventDefault();

    let info = tinymce.get('info2').getContent()
    if (validarFormulario(formAsesinatos, ['id_per[]', 'info2']) && info != '') {

        // console.log('hola');
        try {

            const url = '/medios-comunicacion/API/asesinatos/modificar'

            const body = new FormData(formAsesinatos);
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

            console.log(data);
            // return 
            const { mensaje, codigo, detalle } = data;
            // const resultado = data.resultado;
            let icon = "";
            switch (codigo) {
                case 1:
                    icon = "success"
                    recargarModalAsesinatos(formAsesinatos.topico.value)
                    break;
                case 2:
                    icon = "warning"
                    formAsesinatos.reset();

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
const modificarIncautacionArmamento = async e => {
    e.preventDefault();

    let info = tinymce.get('info_incautacion_armas').getContent()
    // console.log(info);
    if (validarFormulario(formArmas, ['id_registro[]','id_registro_municion[]', 'info_incautacion_armas']) && info != '') {

        // console.log('hola');
        try {

            const url = '/medios-comunicacion/API/incautacion_armas/modificar'

            const body = new FormData(formArmas);
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

            console.log(data);

            const { mensaje, codigo, detalle } = data;
            // const resultado = data.resultado;
            let icon = "";
            switch (codigo) {
                case 1:
                    icon = "success"
                    recargarModalArmas(formArmas.topico.value)
                    break;
                case 2:
                    icon = "warning"
                    formArmas.reset();

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
const eliminarArmamento = async (e, id) => {
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

                const url = '/medios-comunicacion/API/incautacion_armas/armas/eliminar'
    
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
                        recargarModalArmas(formArmas.topico.value)
                        break;
                    case 2:
                        icon = "warning"
                        formArmas.reset();
    
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
const eliminarMunicion = async (e, id) => {
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

                const url = '/medios-comunicacion/API/incautacion_armas/municion/eliminar'
    
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
                        recargarModalArmas(formArmas.topico.value)
                        break;
                    case 2:
                        icon = "warning"
                        formArmas.reset();
    
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

const eliminarIncautacionArmamento = async (e) => {
    Swal.fire({
        title: 'Confirmación',
        text: "¿Esta seguro que desea eliminar esta incautación?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Eliminar'
    }).then( async(result) => {
        if (result.isConfirmed) {
            try {

                const url = '/medios-comunicacion/API/incautacion_armas/eliminar'
    
                const body = new FormData();
                body.append('topico', formArmas.topico.value)
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
                        modalArmas.hide()
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


map.on('click', abreModal)
formInformacion.departamento.addEventListener('change', buscarMunicipio)
formInformacion.addEventListener('submit', guardarEvento)
inicioInput.addEventListener('change', buscarEventos)
finInput.addEventListener('change', buscarEventos)
btnModificarCaptura.addEventListener('click', modificarCaptura)
btnModificarCapturaDroga.addEventListener('click', modificarIncautacion)
btnModificarAsesinatos.addEventListener('click', modificarAsesinato)
btnModificarArmas.addEventListener('click', modificarIncautacionArmamento)
btnBorrarCaptura.addEventListener('click', eliminarCaptura );
btnBorrarCapturaDroga.addEventListener('click', eliminarIncautacion );
btnBorrarAsesinatos.addEventListener('click', eliminarAsesinato );
btnBorrarArmas.addEventListener('click', eliminarIncautacionArmamento )
buttonAgregarInputsCaptura.addEventListener('click',e => agregarInputsCaptura(e,'','','','','','','',false, 0, divCapturados))
buttonQuitarInputsCaptura.addEventListener('click', e => quitarInputsCaptura(0, divCapturados))
buttonAgregarInputsCapturaDroga.addEventListener('click',e => agregarInputsCaptura(e,'','','','','','','',false, 1, divCapturadosDroga))
buttonQuitarInputsCapturaDroga.addEventListener('click', e => quitarInputsCaptura(1, divCapturadosDroga))
buttonAgregarInputsAsesinatos.addEventListener('click', agregarInputsAsesinatos)
buttonQuitarInputsAsesinatos.addEventListener('click', quitarInputsAsesinatos)
buttonAgregarInputsArmas.addEventListener('click', agregarInputsArmas)
buttonQuitarInputsArmas.addEventListener('click', quitarInputsArmas)
buttonAgregarInputsMunicion.addEventListener('click', agregarInputsMunicion)
buttonQuitarInputsMunicion.addEventListener('click', quitarInputsMunicion)
formCaptura.addEventListener('submit', guardarCaptura)
formAsesinatos.addEventListener('submit',guardarAsesinatos)
formDroga.addEventListener('submit', guardarIncautacion)
formArmas.addEventListener('submit', guardarIncautacionArmamento)