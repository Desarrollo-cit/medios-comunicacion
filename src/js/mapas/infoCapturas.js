import { Dropdown } from "bootstrap";
import { validarFormulario, Toast } from "../funciones";
import Datatable from 'datatables.net-bs5';
import { lenguaje } from "../lenguaje";
import Swal from "sweetalert2";
import { Modal } from "bootstrap";
import tinymce from 'tinymce/tinymce';
import 'tinymce/themes/silver/theme';

const formBusqueda_resumen = document.getElementById('formBusqueda_resumen');
const btnBuscarmapacalor = document.querySelector("#buscaravanzada");
const btnresumenbuscar = document.querySelector("#buscarresumen");
const btnBuscar = document.getElementById("buscarcapturas");

let tablaregistro = new Datatable('#dataTable2');
let TablaInfoPer = new Datatable('#dataTable3');
let TablaInfoPer1 = new Datatable('#dataTable4');



const cambiarmes = async (evento) => {
    evento.preventDefault();


    var infocapturas = document.getElementById('cantidad_capturas');
    var infodelito = document.getElementById('delito_concurrente');
    var infomujeres = document.getElementById('cantidad_mujeres');
    var infohombres = document.getElementById('cantidad_hombres');
    var infodepto = document.getElementById('depto_mayor');
    var f1 = new Date(formBusqueda_resumen.fecha_resumen.value)
    var f2 = new Date(formBusqueda_resumen.fecha_resumen2.value)



    if (f1 < f2) {

        const url = '/medios-comunicacion/API/mapas/infoCapturas/resumen'
        const body = new FormData(formBusqueda_resumen);
        const headers = new Headers();
        headers.append("X-Requested-With", "fetch");

        const config = {
            method: 'POST',
            headers,
            body,
        }

        const respuesta = await fetch(url, config);
        const data = await respuesta.json();

        // console.log(data)
        if (data) {
            infocapturas.innerText = data[0].cantidad
            infodelito.innerText = data[1].desc
            infomujeres.innerText = data[2].cantidad
            infohombres.innerText = data[3].cantidad1
            infodepto.innerText = data[4].desc.trim()
        }

    } else {
        Toast.fire({
            icon: 'warning',
            title: 'Ingreso mal las fechas'
        })

    }

}

function ocultar_select() {
    if (document.querySelector("#cuadro_busquedad_resumen").style.display === "none") {
        document.querySelector("#cuadro_busquedad_resumen").style.display = "block";
        document.querySelector("#mes_elegido").style.display = "none";

    } else {
        document.querySelector("#cuadro_busquedad_resumen").style.display = "none";
        document.querySelector("#mes_elegido").style.display = "block";


    }

}

function ocultar_busquedad_mapa() {
    if (document.querySelector("#cuadro_busquedad_mapa").style.display === "none") {
        document.querySelector("#cuadro_busquedad_mapa").style.display = "block";

    } else {
        document.querySelector("#cuadro_busquedad_mapa").style.display = "none";

    }

}


const Buscar_capturas = async (e) => {

    if (document.querySelector("#tabla").style.display === "none") {
        document.querySelector("#tabla").style.display = "block";

    } else {
        document.querySelector("#tabla").style.display = "none";

    }

    try {


        const url = `/medios-comunicacion/API/mapas/infoCapturas/listado`
        const headers = new Headers();
        headers.append("X-Requested-With", "fetch");

        const config = {
            method: 'GET',

        }

        const respuesta = await fetch(url, config);
        const info = await respuesta.json();
        // console.log(info)

        tablaregistro.destroy();
        tablaregistro = new Datatable('#dataTable2', {
            language: lenguaje,
            data: info,
            columns: [
                { data: "contador", "width": "5%" },
                { data: "fecha", "width": "11%" },
                { data: "municipio", "width": "11%" },
                { data: "lugar", "width": "11%" },
                { data: "topico", "width": "15%" },
                { data: "delito", "width": "11%" },
                { data: "actividad", "width": "15%" },

                {
                    data: "id",

                    "render": (data, type, row, meta) =>

                        ` <button class='btn btn-success'     onclick='ModalPersonal(${row.id}, ${row.tipo})'><i class="bi bi-info-circle"></i></button>`,
                    "searchable": false,
                    "width": "10%"
                },
                {
                    data: "id",
                    "render": (data, type, row, meta) => `<a target='blank' href='pdf.php?id=${row.id}&topico= ${row.tipo}'><button class='btn btn-outline-primary'  >REPORTE<i class="bi bi-printer"></i></button></a>`,
                    "searchable": false,
                    "width": "11%"
                },



            ]

        })
    }
    catch (e) {

    }


}

const formcaptura = document.querySelector('#formInformacion1')
const formdroga = document.querySelector('#formInformacion2')
const capturas = new Modal(document.getElementById('modalPersonal12'), {
    keyboard: false
})
const modaldroga1 = new Modal(document.getElementById('modalPersonal13'), {
    keyboard: false
})

window.ModalPersonal = async (id, tipo) => {



    const url = `/medios-comunicacion/API/mapas/infoCapturas/modal`
    const body = new FormData();
    body.append('id', id);
    const headers = new Headers();
    headers.append("X-Requested-With", "fetch");

    const config = {
        method: 'POST',
        body,

    }

    const respuesta = await fetch(url, config);
    const info = await respuesta.json();

    const url1 = `/medios-comunicacion/API/mapas/infoCapturas/informacion`
    const body1 = new FormData();
    body1.append('id', id);
    const headers2 = new Headers();
    headers2.append("X-Requested-With", "fetch");

    const config1 = {
        method: 'POST',
        body,

    }

    const respuesta1 = await fetch(url1, config1);
    const info1 = await respuesta1.json();


    switch (tipo) {

        case 1:
            capturas.show();
            info.forEach(info1 => {
                formcaptura.fecha1.value = info1.fecha
                formcaptura.topico.value = info1.topico
                formcaptura.latitud.value = info1.latitud
                formcaptura.longitud.value = info1.longitud
                formcaptura.departamentoBusqueda.value = info1.depto
                formcaptura.municipio.value = info1.municipio[0]['dm_desc_lg']
                formcaptura.actvidad_vinculada.value = info1.actividad
                formcaptura.lugar.value = info1.lugar

            });



            TablaInfoPer.destroy();
            TablaInfoPer = new Datatable('#dataTable3', {
                language: lenguaje,
                data: info1,
                columns: [
                    { data: "contador", "width": "10%" },
                    { data: "nombre", "width": "20%" },
                    { data: "sexo", "width": "15%" },
                    { data: "edad", "width": "15%" },
                    { data: "nacionalidad", "width": "25%" },
                    { data: "delito", "width": "15%" }
                ]
            })

            break;
        case 4:
            modaldroga1.show();
            const url2 = `/medios-comunicacion/API/mapas/infoCapturas/informacion1`
            const body2 = new FormData();
            body2.append('id', id);
            const headers1 = new Headers();
            headers1.append("X-Requested-With", "fetch");

            const config2 = {
                method: 'POST',
                body,

            }

            const respuesta2 = await fetch(url2, config2);
            const droga = await respuesta2.json();

            info.forEach(info1 => {
                formdroga.fecha1.value = info1.fecha
                formdroga.topico1.value = info1.topico
                formdroga.latitud1.value = info1.latitud
                formdroga.longitud1.value = info1.longitud
                formdroga.departamentoBusqueda1.value = info1.depto
                formdroga.municipio1.value = info1.municipio[0]['dm_desc_lg']
                formdroga.actvidad_vinculada1.value = info1.actividad
                formdroga.lugar1.value = info1.lugar

            });
            droga.forEach(droga1 => {
                formdroga.cantidad_droga.value = droga1.cantidad
                formdroga.tipo_droga.value = droga1.droga
                formdroga.transporte.value = droga1.transporte
                formdroga.placa.value = droga1.matricula
                formdroga.tipo_transporte.value = droga1.tipo_t

            });


            TablaInfoPer1.destroy();
            TablaInfoPer1 = new Datatable('#dataTable4', {
                language: lenguaje,
                data: info1,
                columns: [
                    { data: "contador", "width": "10%" },
                    { data: "nombre", "width": "20%" },
                    { data: "sexo", "width": "15%" },
                    { data: "edad", "width": "15%" },
                    { data: "nacionalidad", "width": "25%" },
                    { data: "delito", "width": "15%" }
                ]
            })
            break;
    }


}


formBusqueda_resumen.addEventListener('submit', cambiarmes)
btnBuscar.addEventListener("click", Buscar_capturas);
btnresumenbuscar.addEventListener("click", ocultar_select);
btnBuscarmapacalor.addEventListener("click", ocultar_busquedad_mapa);