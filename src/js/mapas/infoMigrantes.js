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
const formBusqueda_grafica = document.getElementById('formBusqueda_grafica');
const formBusqueda_mapa = document.getElementById('formBusqueda_mapa');
const btnBuscarmapacalor = document.querySelector("#buscaravanzada");
const btnresumenbuscar = document.querySelector("#buscarresumen");
const btngraficabuscar = document.querySelector("#buscarGrafica");
const btnBuscar = document.getElementById("buscarinfo");
const btnmapa = document.querySelector("#ver_mapa");

const btngrafica = document.querySelector("#ver_grafica");

let tablaregistro = new Datatable('#dataTable2');
let TablaInfoPer = new Datatable('#dataTable3');
let TablaInfoPer1 = new Datatable('#dataTable4');
const formmigrante = document.querySelector('#formInformacion1')
const formdroga = document.querySelector('#formInformacion2')
const modalmigrante = new Modal(document.getElementById('modalmigrante'), {
    keyboard: false
})

const modaldeptos = new Modal(document.getElementById('modaldepto'), {
    keyboard: false
})


const cambiarmes = async (evento) => {
    evento.preventDefault();


    var cantidad_migrantes = document.getElementById('cantidad_migrantes');
    var edad_concurrente = document.getElementById('edad_concurrente');
    var cantidad_paises = document.getElementById('cantidad_paises');
    var pais_migrante = document.getElementById('pais_migrante');
    var infomujeres = document.getElementById('cantidad_mujeres');
    var infohombres = document.getElementById('cantidad_hombres');
    var infodepto = document.getElementById('depto_mayor');
    var f1 = new Date(formBusqueda_resumen.fecha_resumen.value)
    var f2 = new Date(formBusqueda_resumen.fecha_resumen2.value)



    if (f1 < f2) {

        const url = '/medios-comunicacion/API/mapas/infoMigrantes/resumen'
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


        if (data) {
            cantidad_migrantes.innerText = data[0].cantidad
            edad_concurrente.innerText = data[1].edades
            cantidad_paises.innerText = data[2].cantidad
            pais_migrante.innerText = data[3].pais
            infomujeres.innerText = data[4].cantidad
            infohombres.innerText = data[5].cantidad
            infodepto.innerText = data[6].desc.trim()
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

function ocultar_graficas() {
    if (document.querySelector("#div_graficas").style.display === "none") {
        document.querySelector("#div_graficas").style.display = "block";
        // document.querySelector("#info7").style.display = "block";
    } else {
        document.querySelector("#div_graficas").style.display = "none";
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

function ocultar_busquedad_grafica() {
    if (document.querySelector("#cuadro_busquedad_grafica").style.display === "none") {
        document.querySelector("#cuadro_busquedad_grafica").style.display = "block";
        // document.querySelector("#mes_elegido").style.display = "none";

    } else {
        document.querySelector("#cuadro_busquedad_grafica").style.display = "none";
        // document.querySelector("#mes_elegido").style.display = "block";


    }

}

function ocultar_busquedad_mapa() {
    if (document.querySelector("#cuadro_busquedad_mapa").style.display === "none") {
        document.querySelector("#cuadro_busquedad_mapa").style.display = "block";

    } else {
        document.querySelector("#cuadro_busquedad_mapa").style.display = "none";

    }

}


const Buscar_migrantes = async (e) => {

    if (document.querySelector("#tabla").style.display === "none") {
        document.querySelector("#tabla").style.display = "block";

    } else {
        document.querySelector("#tabla").style.display = "none";

    }

    try {


        const url = `/medios-comunicacion/API/mapas/infoMigrantes/listado`
        const headers = new Headers();
        headers.append("X-Requested-With", "fetch");

        const config = {
            method: 'GET',

        }

        const respuesta = await fetch(url, config);
        const info = await respuesta.json();
// console.log(info);
        tablaregistro.destroy();
        tablaregistro = new Datatable('#dataTable2', {
            language: lenguaje,
            data: info,
            columns: [
                { data: "contador", "width": "5%" },
                { data: "fecha", "width": "11%" },
                { data: "departamento", "width": "11%" },
                { data: "lugar", "width": "11%" },
                { data: "topico", "width": "15%" },
                { data: "nacionalidad", "width": "11%" },
                { data: "edad", "width": "11%" },
                { data: "cantidad", "width": "15%" },

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


window.ModalPersonal = async (id, tipo) => {


    const url = `/medios-comunicacion/API/mapas/infoMigrantes/modal`
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
   

    const url1 = `/medios-comunicacion/API/mapas/infoMigrantes/informacionMigrantes`
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

    // console.log(info1);
    
            modalmigrante.show();
            info.forEach(info1 => {
                formmigrante.fecha1.value = info1.fecha
                formmigrante.topico.value = info1.topico
                formmigrante.latitud.value = info1.latitud
                formmigrante.longitud.value = info1.longitud
                formmigrante.departamentoBusqueda.value = info1.depto
                formmigrante.municipio.value = info1.municipio[0]['dm_desc_lg']
                formmigrante.actvidad_vinculada.value = info1.actividad
                formmigrante.lugar.value = info1.lugar

            });



            TablaInfoPer.destroy();
            TablaInfoPer = new Datatable('#dataTable3', {
                language: lenguaje,
                data: info1,
                columns: [
                    { data: "contador", "width": "10%" },
                    { data: "pais", "width": "20%" },
                    { data: "sexo", "width": "15%" },
                    { data: "edad", "width": "15%" },
                    { data: "cantidad", "width": "15%" },
                    { data: "destino", "width": "15%" }
                ]
            })


}

const formMapa = document.querySelector('#formBusqueda_mapa')

const busquedad_mapa_Calor = async (e) => {
    e && e.preventDefault();

    // const delito = formMapa.cantidad_droga.value
    const fecha1 = formMapa.fecha_mapa.value
    const fecha2 = formMapa.fecha2.value
    if (fecha1 == "" && fecha2 == "") {
        var valor = 1
    } else {

        var valor = 2
    }
    var f1 = new Date(formMapa.fecha_mapa.value)
    var f2 = new Date(formMapa.fecha2.value)



    if ((f1 < f2 && valor == 2) || (valor == 1)) {

        const url = `/medios-comunicacion/API/mapas/infoMigrantes/mapaCalor`
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
        if ((fecha1 != "" && fecha2 != "") || formMapa.edades_mapa_calor.value != "") {
            if (info.length == 0) {
                Toast.fire({
                    icon: 'error',
                    title: 'Sin registros'
                })
            } else {
                Toast.fire({
                    icon: 'success',
                    title: 'Se tienen siguientes registros'
                })
            }
        }
        // console.log(info)
        window.deptos = document.querySelectorAll('path');
        deptos.forEach(element => {
            element.setAttribute('fill', '#145A32 ')

        })
        const url1 = `/medios-comunicacion/API/mapas/infoMigrantes/colores`
        const headers1 = new Headers();
        headers1.append("X-Requested-With", "fetch");

        const config1 = {
            method: 'POST',

        }

        const respuesta1 = await fetch(url1, config1);
        const info1 = await respuesta1.json();

  

       

            window.cantidad_baja = parseInt(info1[0]['cantidad'])
            window.color_bajo = info1[0]['color']
            window.cantidad_medio = parseInt(info1[1]['cantidad'])
            window.color_medio = info1[1]['color']
            window.cantidad_alta = parseInt(info1[2]['cantidad'])
            window.color_alta = info1[2]['color']

        




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
    } else {
        Toast.fire({
            icon: 'warning',
            title: 'Ingreso mal las fechas'
        })

    }
}



window.detalle = async (valor) => {
    if (valor < 1000) {

        valor = '0' + valor
    }

    var deptoinfo = document.getElementById('deptoinfo');
    var deptoincidencia = document.getElementById('deptoincidencia');
    var label_migrante = document.getElementById('label_migrante');
    const delito = formMapa.edades_mapa_calor.value
    const url = `/medios-comunicacion/API/mapas/infoMigrantes/mapaCalorPorDepto`
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
// console.log(info_depto1);

    if (info_depto1) {
        deptoinfo.innerText = info_depto1[0].cantidad


        deptoincidencia.innerText = info_depto1[1].edades

        if (delito != "") {
            label_migrante.innerText = 'Rango de edad seleccionado:'
        }
        if (delito == "") {
            label_migrante.innerText = 'Incidencia:'
        }
    } else {
        deptoinfo.innerText = ''
        deptoincidencia.innerText = ''
        label_migrante.innerText = 'Incidencia:'

    }

    const label = document.getElementById('depto_name')
    const deptoname = document.getElementById(valor)
    const name = deptoname.getAttribute("name");
    //    alert(name)

    modaldeptos.show();
    label.innerText = 'DEPARTAMENTO DE ' + name.toUpperCase();

    const url_grafica = `/medios-comunicacion/API/mapas/infoMigrantes/mapaCalorPorDeptoGrafica`
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

        // console.log(datos);
        if (datos.length > 0) {
            document.getElementById('grafica_depto1').style.display = "block"
            document.getElementById('texto_no').style.display = "none"


            let labels = [], cantidades = []
            datos.forEach(d => {
                labels = [...labels, d.edades]
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
                        label: 'EDADES',
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




//________________________________________________________GRAFICA POR DELITOS __________________________________________________________________________________________________________


const migrantes_por_edades_estadistica = async (e) => {
    e && e.preventDefault();

    const url_grafica1 = `/medios-comunicacion/API/mapas/infoMigrantes/MigrantesCantGrafica`
    const bodyGrafica1 = new FormData(formBusqueda_grafica);

    const headersGrafica1 = new Headers();
    headersGrafica1.append("X-Requested-With", "fetch");

    const configGrafica1 = {
        method: 'POST',
        headers: headersGrafica1,
        body: bodyGrafica1,
    }
    try {

        const response1 = await fetch(url_grafica1, configGrafica1)
        const datos1 = await response1.json()

        if (datos1.length > 0) {
            document.getElementById('graficaDelitos').style.display = "block"
            document.getElementById('texto_no1').style.display = "none"


            let labels = [], cantidades = []
            datos1.forEach(d => {
                labels = [...labels, d.edades]
                cantidades = [...cantidades, d.cantidad]
            })

            const ctx = document.getElementById('myChart1');
            if (window.delitos_grafica) {
                window.delitos_grafica.clear();
                window.delitos_grafica.destroy();
            }
            window.delitos_grafica = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels,
                    datasets: [{
                        label: 'Migrantes',
                        data: cantidades,

                        backgroundColor: [
                            'rgba(252, 100, 7 , 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(46, 148, 26 , 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(241, 9, 9 , 1)',
                            'rgba(26, 50, 148,  1)',
                            'rgba(18, 199, 29,  1)'
                        ],
                        borderColor: [
                            'rgba(255, 236, 0, 1)',
                            'rgba(255, 236, 0, 1)',
                            'rgba(255, 236, 0, 1)',
                            'rgba(255, 236, 0, 1)',
                            'rgba(255, 236, 0, 1)',
                            'rgba(255, 236, 0, 1)'
                        ],
                        borderWidth: 7
                    }],
                },
                options: {
                    indexAxis: 'y',
                    scales: {
                        y: { // not 'yAxes: [{' anymore (not an array anymore)
                            ticks: {
                                color: "black", // not 'fontColor:' anymore
                                // fontSize: 18,
                                font: {
                                    size: 16, // 'size' now within object 'font {}'
                                },
                                stepSize: 1,
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
                    },

                }
            });

        } else {

            document.getElementById('texto_no1').style.display = "block";
            document.getElementById('graficaDelitos').style.display = "none";
        }

    } catch (error) {
        console.log(error);
    }
    deptos_estadistica()

}


const deptos_estadistica = async (e) => {
    e && e.preventDefault();

    const url_grafica2 = `/medios-comunicacion/API/mapas/infoMigrantes/MigrantesDepartamentoGrafica`
    const bodyGrafica2 = new FormData(formBusqueda_grafica);

    const headersGrafica2 = new Headers();
    headersGrafica2.append("X-Requested-With", "fetch");

    const configGrafica2 = {
        method: 'POST',
        headers: headersGrafica2,
        body: bodyGrafica2,
    }
    try {

        const response2 = await fetch(url_grafica2, configGrafica2)
        const datos2 = await response2.json()
// console.log(datos2);

        if (datos2.length > 0) {
            document.getElementById('graficaDelitosDepartamento').style.display = "block"
            document.getElementById('texto_no2').style.display = "none"


            let labels = [], cantidades = []
            datos2.forEach(d => {
                labels = [...labels, d.descripcion]
                cantidades = [...cantidades, d.cantidad]
            })
            // mostrar(datos)
            //  $("#delitos_cant").destroy();
            const ctx = document.getElementById('myChart2');
            if (window.delitosDepartamento_grafica) {
                window.delitosDepartamento_grafica.clear();
                window.delitosDepartamento_grafica.destroy();
            }


            window.delitosDepartamento_grafica = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels,
                    datasets: [{
                        label: 'DELITOS',
                        data: cantidades,

                        backgroundColor: [
                            'red',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'blue',
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
                        borderWidth: 5
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            position: 'left',

                            font: {
                                size: 45, // 'size' now within object 'font {}'
                            },


                        },
                    }

                }
            });
        } else {

            document.getElementById('texto_no2').style.display = "block";
            document.getElementById('graficaDelitosDepartamento').style.display = "none";

        }
    } catch (error) {
        console.log(error);
    }

}



const MigrantesPorDia = async () => {

    const url_grafica2 = `/medios-comunicacion/API/mapas/infoMigrantes/MigrantesPorDiaGrafica`
    const headersGrafica2 = new Headers();
    headersGrafica2.append("X-Requested-With", "fetch");

    const configGrafica2 = {
        method: 'POST',
        headers: headersGrafica2,

    }
    try {

        const response2 = await fetch(url_grafica2, configGrafica2)
        const datos2 = await response2.json()

        // console.log(datos2);

        const { dias, cantidades } = datos2;

        const canvas = document.getElementById('myChart3');
        const ctx = canvas.getContext('2d');
        if (window.CapturasPorDia) {
            // console.log(window.CapturasPorDia);
            window.CapturasPorDia.destroy()
        }

        const data = {
            labels: dias,
            datasets: [{
                label: 'Migrantes',
                data: cantidades,
                fill: true,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.5,
                borderColor: '#F10909',
                backgroundColor: '#34495E',
                pointBorderColor: 'white',
                pointBackgroundColor: 'black',
                pointRadius: 10,
                pointHoverRadius: 20,
                pointHitRadius: 30,
                pointBorderWidth: 2,
                pointStyle: 'rectRounded',
            }]

        };

        const configChart = {
            type: 'line',
            data: data,
            options: {
                plugins: {
                    legend: {
                        position: "top",
                        labels: {
                            boxWidth: 100,
                            usePointStyle: true,
                            pointStyle: "line",
                        }
                    }
                },
                indexAxis: 'x',
                scales: {
                    x: {

                        grid: {
                            tickColor: "white",
                            borderDash: [5, 2],
                            tickWidth: 25,
                            color: "black",
                            borderColor: "black",
                            size: 25
                        },

                        ticks: {
                            color: "black",
                            font: {
                                weight: "bold",
                                size: 30
                            },


                        },
                        title: {
                            display: true,
                            text: "DIAS DEL MES",
                            fullSize: true,
                            color: 'Black',
                            font: {
                                weight: "bold",
                                size: 30
                            }
                        }
                    },
                    y: {
                        grid: {
                            color: "black",
                            borderDash: [5, 2,],
                            borderColor: "black",
                            tickColor: "yellow",
                            tickWidth: 5,
                            size: 10
                        },
                        ticks: {
                            color: "black",
                            font: {
                                weight: "bold",
                                size: 25
                            },
                            stepSize: 10,
                            beginAtZero: true,

                        },
                        title: {
                            display: true,
                            text: "Migraciones",
                            fullSize: true,
                            color: 'black',
                            font: {
                                weight: "bold",
                                size: 30
                            }
                        }

                    }
                }
            }
        };


        window.CapturasPorDia = new Chart(ctx, configChart);
        window.CapturasPorDia.update()
    } catch (e) {
        console.log(error)

    }

}

const chartColors = [
    'rgba(14, 128, 255, 0.8)', //azul
    'rgba(7, 216, 0, 0.8)', //verde
    'rgba(255, 0, 0, 0.8)', //rojo
    'rgba(255, 0, 231, 0.8)', //rosa
    'rgba(0, 255, 247, 0.8)', //celeste
    'rgba(236, 255, 0, 0.8)', //amarillo
    'rgba(162, 255, 0, 0.8)' //verde mas claro
];



const trimestralesMigrantes = async () => {

    const url_grafica2 = `/medios-comunicacion/API/mapas/infoMigrantes/GraficaTrimestral`
    const headersGrafica2 = new Headers();
    headersGrafica2.append("X-Requested-With", "fetch");

    const configGrafica2 = {
        method: 'POST',
        headers: headersGrafica2,

    }
    try {

        const response2 = await fetch(url_grafica2, configGrafica2)
        const info = await response2.json()
console.log(info);
        // info.length < 1 && Toast.fire({
        //     icon: 'warning',
        //     title: 'Ingreso mal las fechas'
        // })


        // return

        const canvas = document.getElementById('myChart4');
        const ctx = canvas.getContext('2d');
        window.trimestralGrafica && window.trimestralGrafica.destroy()

        let { labels, cantidades } = info;

        // console.log(cantidades);

        let dataSetsLabels = Object.keys(cantidades);
        let dataSetsValues = Object.values(cantidades)

        // console.log(dataSetsLabels);
        // console.log(dataSetsValues);



        let datasets = []

        for (let index = 0; index < dataSetsLabels.length; index++) {
            datasets = [...datasets, {
                label: dataSetsLabels[index],
                data: dataSetsValues[index],
                backgroundColor: chartColors[index],
                borderColor: chartColors[index],
                borderWidth: 1
            }]

        }

        // console.log(datasets);
        let chartInfo = {
            type: 'bar',
            data: {
                labels,
                datasets
            },
            options: {
                indexAxis: 'y',
                plugins: {
                    title: {
                        display: true,
                        text: 'Cantidad de Capturas'
                    },
                    scales: {

                        stepSize: 1,
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(255, 199, 132, 1)'
                        }


                    }
                }
            }
        }


        window.trimestralGrafica = new Chart(ctx, chartInfo);
        window.trimestralGrafica.update()
    } catch (error) {
        console.log(error)
    }
    // console.log(info);
}



const trimestral_migrantes_general = async () => {
    const url_grafica2 = `/medios-comunicacion/API/mapas/infoMigrantes/GraficaTrimestralGeneral`
    const headersGrafica2 = new Headers();
    headersGrafica2.append("X-Requested-With", "fetch");

    const configGrafica2 = {
        method: 'POST',
        headers: headersGrafica2,

    }
    try {

        const response2 = await fetch(url_grafica2, configGrafica2)
        const info = await response2.json()

        


        const { meses, cantidades } = info;
        // console.log(info);
        const canvas1 = document.getElementById('myChart5');
        const ctx1 = canvas1.getContext('2d');
        if (window.trimestral_MigranteGeneral) {
            console.log(window.trimestral_MigranteGeneral);
            window.trimestral_MigranteGeneral.destroy()
        }

        const data = {
            labels: meses,
            datasets: [{
                label: 'ESTADISTICA TRIMESTRAL',
                data: cantidades,
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.5,
                borderColor: '#F10909',
                backgroundColor: [
                    'rgba(236, 26, 19  , 0.5)',
                    'rgba(8, 144, 47 , 0.4)',
                    'rgba(8, 14, 144 , 0.6)',
                    'rgba(253, 253, 3, 1)',
                    'rgba(8, 129, 144 , 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(241, 9, 9 , 1)',
                    'rgba(26, 50, 148,  1)',
                    'rgba(18, 199, 29,  1)'
                ],
            }]

        };

        const configChart = {
            type: 'bar',
            data: data,
            options: {
                plugins: {
                    legend: {
                        position: "top",
                        labels: {
                            boxWidth: 100,
                            usePointStyle: true,
                            pointStyle: "line",
                        }
                    }
                },
                indexAxis: 'x',
                scales: {
                    x: {

                        grid: {
                            tickColor: "white",
                            // borderDash: [5, 2],
                            tickWidth: 25,
                            color: "black",
                            borderColor: "black",
                            size: 25
                        },

                        ticks: {
                            color: "black",
                            font: {
                                weight: "bold",
                                size: 30
                            },

                        }

                    },
                    y: {
                        grid: {
                            color: "black",
                            borderDash: [5, 2,],
                            borderColor: "black",
                            tickColor: "yellow",
                            tickWidth: 5,
                            size: 10
                        },
                        ticks: {
                            color: "black",
                            font: {
                                weight: "bold",
                                size: 25
                            },
                            stepSize: 10,
                            beginAtZero: true,
                        },
                        title: {
                            display: true,
                            text: "Migrantes",
                            fullSize: true,
                            color: 'White',
                            font: {
                                weight: "bold",
                                size: 30
                            }
                        }

                    }
                }
            }
        };
        window.trimestral_MigranteGeneral = new Chart(ctx1, configChart);
        window.trimestral_MigranteGeneral.update()
    } catch (error) {
        console.log(error);
    }




}


formBusqueda_resumen.addEventListener('submit', cambiarmes)
formBusqueda_grafica.addEventListener('submit', migrantes_por_edades_estadistica)
btnBuscar.addEventListener("click", Buscar_migrantes);
btnresumenbuscar.addEventListener("click", ocultar_select);
btngraficabuscar.addEventListener("click", ocultar_busquedad_grafica);
btnBuscarmapacalor.addEventListener("click", ocultar_busquedad_mapa);
formBusqueda_mapa.addEventListener('submit', busquedad_mapa_Calor)
btnmapa.addEventListener("click", ocultar_mapa);
busquedad_mapa_Calor();
migrantes_por_edades_estadistica();
MigrantesPorDia();
trimestralesMigrantes();
trimestral_migrantes_general();
// deptos_estadistica();
btngrafica.addEventListener("click", ocultar_graficas);

