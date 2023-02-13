import { Dropdown } from "bootstrap";
import { validarFormulario, Toast } from "../funciones";
import Datatable from 'datatables.net-bs5';
import { lenguaje } from "../lenguaje";
import Swal from "sweetalert2";
import { Modal } from "bootstrap";
import tinymce from 'tinymce/tinymce';
import 'tinymce/themes/silver/theme';
import Chart from 'chart.js/auto';

const formBusqueda_resumen = document.getElementById('formBusqueda_resumen');
const formBusqueda_mapa = document.getElementById('formBusqueda_mapa');
const btnBuscarmapacalor = document.querySelector("#buscaravanzada");
const btnresumenbuscar = document.querySelector("#buscarresumen");
const btnBuscar = document.getElementById("buscarcapturas");
const btnmapa = document.querySelector("#ver_mapa");

let tablaregistro = new Datatable('#dataTable2');
let TablaInfoPer = new Datatable('#dataTable3');
let TablaInfoPer1 = new Datatable('#dataTable4');
const formcaptura = document.querySelector('#formInformacion1')
const formdroga = document.querySelector('#formInformacion2')
const capturas = new Modal(document.getElementById('modalPersonal12'), {
    keyboard: false
})

const modaldeptos = new Modal(document.getElementById('modaldepto'), {
    keyboard: false
})


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
//alert (f1)
        const url = '/medios-comunicacion/API/mapas/IndexMuertes/resumen'
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

function ocultar_mapa() {
    if (document.querySelector("#mapa_calor").style.display === "none") {
        document.querySelector("#mapa_calor").style.display = "block";
        // document.querySelector("#info7").style.display = "block";
    } else {
        document.querySelector("#mapa_calor").style.display = "none";
        // document.querySelector("#info7").style.display = "none";
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


        const url = `/medios-comunicacion/API/mapas/IndexMuertes/listado`
        const headers = new Headers();
        headers.append("X-Requested-With", "fetch");

        const config = {
            method: 'GET',

        }

        const respuesta = await fetch(url, config);
        const info = await respuesta.json();
     //    console.log(info)

        tablaregistro.destroy();
        tablaregistro = new Datatable('#dataTable2', {
            language: lenguaje,
            data: info,
            columns: [
                { data: "contador", "width": "5%" },
                { data: "fecha", "width": "11%" },
                { data: "departamento", "width": "11%" },
                { data: "lugar", "width": "11%" },
                { data: "tipo", "width": "15%" },
            
                { data: "actividad", "width": "15%" },

                {
                    data: "id",

                    "render": (data, type, row, meta) =>

                        ` <button class='btn btn-success'     onclick='ModalPersonal(${row.id})'><i class="bi bi-info-circle"></i></button>`,
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



window.ModalPersonal = async (id) => {



    const url = `/medios-comunicacion/API/mapas/IndexMuertes/modal`
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
   // console.log(info[0].fecha);

    const url1 = `/medios-comunicacion/API/mapas/IndexMuertes/informacion`
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

console.log(info);
   
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
          
                ]
            })


          
    


         
    }








const formMapa = document.querySelector('#formBusqueda_mapa')

const busquedad_mapa_Calor = async(e) => {
    e && e.preventDefault();

    // const delito = formMapa.cantidad_droga.value
    // const fecha1 = formMapa.fecha_mapa.value
    // const fecha2 = formMapa.fecha2.value
   


    const url = `/medios-comunicacion/API/mapas/IndexMuertes/mapaCalor`
    const body = new FormData(formMapa);
    
    const headers = new Headers();
    headers.append("X-Requested-With", "fetch");

    const config = {
        method: 'POST',
        headers,
        body,

    }

    const respuesta = await fetch(url, config);
    const info = await respuesta.json();
   
       //  console.log(info)
   window.deptos = document.querySelectorAll('path');
    deptos.forEach(element => {
        element.setAttribute('fill', '#145A32 ')

    })
    const url1 = `/medios-comunicacion/API/mapas/IndexMuertes/colores`
    const headers1 = new Headers();
    headers1.append("X-Requested-With", "fetch");

    const config1 = {
        method: 'POST',

    }

    const respuesta1 = await fetch(url1, config1);
    const info1 = await respuesta1.json();
   
       // console.log(info1)

    info1.forEach(data1 => {
        
        window.cantidad_baja = parseInt(info1[0]['cantidad'])
        window.color_bajo = info1[0]['color']
        window.cantidad_medio = parseInt(info1[1]['cantidad'])
        window.color_medio = info1[1]['color']
        window.cantidad_alta = parseInt(info1[2]['cantidad'])
        window.color_alta = info1[2]['color']

    })




    // console.log(cantidad_baja)
    if (info != null) {
        info.forEach(data => {
            // console.log(parseInt(data.CANTIDAD), cantidad_alta, cantidad_baja, cantidad_medio)
            data.fill = 'gray'
            let color = '#145A32 '

            if (parseInt(data.cantidad) >= cantidad_baja && parseInt(data.cantidad) <= cantidad_medio) {

                color = color_bajo;
            }
            if (parseInt(data.cantidad) >= cantidad_medio && parseInt(data.cantidad) < cantidad_alta) {
                // console.log(color_medio)
                color = color_medio;
            }
            if (parseInt(data.cantidad) >= cantidad_alta) {

                color = color_alta;
            }

            document.getElementById(data.codigo).setAttribute('fill', color);


        })
    }
}



window.detalle = async(valor) => {
    if (valor < 1000) {

        valor = '0' + valor
    }
    const muerte = formMapa.tipos_muerte_mapa_calor.value 
    const url = `/medios-comunicacion/API/mapas/IndexMuertes/mapaCalorPorDepto`
    const body = new FormData(formMapa);
    body.append('departamento', valor);
    const headers = new Headers();
    headers.append("X-Requested-With", "fetch");

    const config = {
        method: 'POST',
        headers,
        body,

    }

    const respuesta = await fetch(url, config);
    const info_depto1 = await respuesta.json();
   
        // console.log(info_depto1)
    if (info_depto1) {
        deptoinfo.innerText = info_depto1[0].cantidad_delito
        deptoincidencia.innerText = info_depto1[1].desc
        
        switch (info_depto1[1].situacion) {
            case '1':
                deptoincidencia.innerText = 'ASESINATO'
                break;

            case '2':
                deptoincidencia.innerText = 'HOMICIDIO'
                break;
            case '3':
                deptoincidencia.innerText = 'SICARIATO'
                break;
            case '4':
                deptoincidencia.innerText = 'FEMICIDIO'
                break;
            case '5':
                deptoincidencia.innerText = 'SUICIDIO'
                break;
        }
        if (muerte != "") {
            label_delito.innerText = 'Delito seleccionado:'
        }
        if (muerte == "") {
            label_delito.innerText = 'Incidencia:'
        }
    } else {
        deptoinfo.innerText = ''
        deptoincidencia.innerText = ''
        label_delito.innerText = 'Incidencia:'

    }

    const label = document.getElementById('depto_name')
    const deptoname = document.getElementById(valor)
    const name = deptoname.getAttribute("name");
    //    alert(name)

    modaldeptos.show();
    label.innerText = 'DEPARTAMENTO DE ' + name.toUpperCase();

    const url_grafica = `/medios-comunicacion/API/mapas/IndexMuertes/mapaCalorPorDeptoGrafica`
    const bodyGrafica = new FormData(formMapa);
    bodyGrafica.append('departamento', valor);
    const headersGrafica = new Headers();
    headersGrafica.append("X-Requested-With", "fetch");

    const configGrafica = {
        method: 'POST',
        headers: headersGrafica,
        body: bodyGrafica,

    }

    try {

        const response = await fetch(url_grafica, configGrafica)
        const datos = await response.json()

       //  console.log(datos);
        if (datos.length > 0) {
            document.getElementById('grafica_depto1').style.display = "block"
            document.getElementById('texto_no').style.display = "none"


            let labels = [], cantidades = []
            datos.forEach(d => {
                labels = [...labels, d.descripcion]
                cantidades = [...cantidades, d.cantidad]
            })
            // mostrar(datos)
            //  $("#delitos_cant").destroy();
            const ctx = document.getElementById('delitos_cant');
            if (window.grafica) {
                window.grafica.clear();
                window.grafica.destroy();
            }
            window.grafica = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels,
                    datasets: [{
                        label: 'MUERTES',
                        data: cantidades,
                        backgroundColor: [
                            'rgba(255, 199, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderColor: [
                            'rgba(255, 236, 0, 1)',
                            'rgba(255, 236, 0, 1)',
                            'rgba(255, 236, 0, 1)',
                            'rgba(255, 236, 0, 1)',
                            'rgba(255, 236, 0, 1)',
                            'rgba(255, 236, 0, 1)'
                        ],
                        borderWidth: 4
                    }],
                },
                options: {

                    scales: {
                        y: { // not 'yAxes: [{' anymore (not an array anymore)
                            ticks: {
                                color: "black", // not 'fontColor:' anymore
                                // fontSize: 18,
                                font: {
                                    size: 18, // 'size' now within object 'font {}'
                                },
                                stepSize: 5,
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(255, 199, 132, 1)'
                                }
                            }
                        },
                        x: { // not 'xAxes: [{' anymore (not an array anymore)
                            ticks: {
                                color: "black", // not 'fontColor:' anymore
                                //fontSize: 14,
                                font: {
                                    size: 14 // 'size' now within object 'font {}'
                                },
                                stepSize: 1,
                                beginAtZero: true,

                            }
                        }

                    },
                    legend: {
                        labels: {
                            color: "black",
                            labels: {
                                color: "blue", // not 'fontColor:' anymore
                                // fontSize: 18  // not 'fontSize:' anymore
                                font: {
                                    size: 18 // 'size' now within object 'font {}'
                                }
                            }
                        }
                    }
                }
            });

        } else {
            // alert("hola")
            document.getElementById('grafica_depto1').style.display = "none"
            document.getElementById('texto_no').style.display = "block"
        }
    } catch (error) {
        console.log(error);
    }




}
    const mostrar = (delitos_depto) => {
        // console.log(delitos_depto)

        if (delitos_depto) {
            document.getElementById('grafica_depto1').style.display = "block"
            document.getElementById('texto_no').style.display = "none"
            delitos_depto.forEach(element => {

                window.grafica.data['labels'].push(element.DESCRIPCION)
                window.grafica.data['datasets'][0].data.push(element.CANTIDAD)

            });
        } else {

            document.getElementById('grafica_depto1').style.display = "none"
            document.getElementById('texto_no').style.display = "block"
        }
    }



    
formBusqueda_resumen.addEventListener('submit', cambiarmes)
btnBuscar.addEventListener("click", Buscar_capturas);
btnresumenbuscar.addEventListener("click", ocultar_select);
btnBuscarmapacalor.addEventListener("click", ocultar_busquedad_mapa);
formBusqueda_mapa.addEventListener('submit', busquedad_mapa_Calor)
btnmapa.addEventListener("click", ocultar_mapa);
busquedad_mapa_Calor();

