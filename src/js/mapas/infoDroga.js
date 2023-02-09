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
const btnBuscar = document.getElementById("buscarincautaciones");
const btnmapa = document.querySelector("#ver_mapa");


const btngrafica = document.querySelector("#ver_grafica");

let tablaregistro = new Datatable('#dataTable2');
let TablaInfoPer = new Datatable('#dataTable3');
let TablaInfoPer1 = new Datatable('#dataTable4');
const forminfo = document.querySelector('#formInformacion1')
const formdroga = document.querySelector('#formInformacion2')
const capturas = new Modal(document.getElementById('modalPersonal12'), {
    keyboard: false
})
const modaldroga1 = new Modal(document.getElementById('modalPersonal13'), {
    keyboard: false
})
const modaldeptos = new Modal(document.getElementById('modaldepto'), {
    keyboard: false
})
const modal_pista = new Modal(document.getElementById('modalPersonal12'), {
    keyboard: false
})


const cambiarmes = async (evento) => {
    evento.preventDefault();


    var cantidadIncautaciones = document.getElementById('cantidadIncautaciones');
    var kilosIncautados = document.getElementById('kilosIncautados');
    var kilosIncautados1 = document.getElementById('kilosIncautados1');
    var matasIncautados = document.getElementById('matasIncautados');
    var matasIncautados1 = document.getElementById('matasIncautados1');
    var cantidadCapturas = document.getElementById('cantidadCapturas');
    var cantidadHombres = document.getElementById('cantidadHombres');
    var cantidadMujeres = document.getElementById('cantidadMujeres');
    var cantidadPista = document.getElementById('cantidadPista');
    var deptoMayor = document.getElementById('deptoMayor');
    var deptoMayor1 = document.getElementById('deptoMayor1');
    var f1 = new Date(formBusqueda_resumen.fecha_resumen.value)
    var f2 = new Date(formBusqueda_resumen.fecha_resumen2.value)



    if (f1 < f2) {

        const url = '/medios-comunicacion/API/mapas/infoDroga/resumen'
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
            cantidadIncautaciones.innerText = data[0].cantidad
            kilosIncautados.innerText = data[2].cantidad
            kilosIncautados1.innerText = data[1].desc
            matasIncautados.innerText = data[4].cantidad
            matasIncautados1.innerText = data[3].desc
            cantidadCapturas.innerText = data[5].cantidad
            cantidadHombres.innerText = data[7].cantidad
            cantidadMujeres.innerText = data[6].cantidad
            cantidadPista.innerText = data[8].cantidad
            deptoMayor.innerText = data[9].desc
            deptoMayor1.innerText = data[10].desc.trim()
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


const Buscar_capturas = async (e) => {

    if (document.querySelector("#tabla").style.display === "none") {
        document.querySelector("#tabla").style.display = "block";

    } else {
        document.querySelector("#tabla").style.display = "none";

    }

    try {


        const url = `/medios-comunicacion/API/mapas/infoDroga/listado`
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
                { data: "departamento", "width": "11%" },
                { data: "lugar", "width": "11%" },
                { data: "topico", "width": "15%" },

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


window.ModalPersonal = async (id, tipo) => {



    const url = `/medios-comunicacion/API/mapas/infoDroga/modal`
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
    // console.log(info)

    switch (tipo) {

        case 4:

            modaldroga1.show();


            info.forEach(info1 => {
                formdroga.fecha1.value = info1.fecha
                formdroga.topico.value = info1.topico
                formdroga.latitud.value = info1.latitud
                formdroga.longitud.value = info1.longitud
                formdroga.departamentoBusqueda.value = info1.depto
                formdroga.municipio.value = info1.municipio
                formdroga.actvidad_vinculada.value = info1.actividad
                formdroga.lugar.value = info1.lugar
                // forminfo.departamentoBusqueda.value = info1.FECHA
            });




            const url1 = `/medios-comunicacion/API/mapas/infoDroga/informacion`
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

            // console.log(droga)
            if (info1 != null) {
                info1.forEach(droga1 => {
                    formdroga.cantidad_droga.value = droga1.cantidad
                    formdroga.tipo_droga.value = droga1.droga
                    formdroga.transporte.value = droga1.transporte
                    formdroga.placa.value = droga1.matricula
                    formdroga.tipo_transporte.value = droga1.tipo_t

                    // formdroga.actvidad_vinculada.value = droga1.ACTIVIDAD
                    // formdroga.lugar.value = droga1.LUGAR
                    // forminfo.departamentoBusqueda.value = info1.FECHA
                });
            }


            const url3 = `/medios-comunicacion/API/mapas/infoDroga/informacion1`
            const body3 = new FormData();
            body3.append('id', id);
            const headers3 = new Headers();
            headers3.append("X-Requested-With", "fetch");

            const config3 = {
                method: 'POST',
                body,

            }

            const respuesta3 = await fetch(url3, config3);
            const droga1 = await respuesta3.json();

            // console.log(droga1)
            if (droga1 != null) {
                droga1.forEach(droga11 => {

                    formdroga.matas_incautadas.value = droga11.cantidad1
                    formdroga.tipo_matas.value = droga11.tipo_droga
                    // formdroga.actvidad_vinculada.value = droga1.ACTIVIDAD
                    // formdroga.lugar.value = droga1.LUGAR
                    // forminfo.departamentoBusqueda.value = info1.FECHA
                });
            }


            const url_Droga = `/medios-comunicacion/API/mapas/infoDroga/informacionPersonas`
            const bodyDroga = new FormData();
            bodyDroga.append('id', id);
            const headersDroga = new Headers();
            headersDroga.append("X-Requested-With", "fetch");

            const config_Droga = {
                method: 'POST',
                body: bodyDroga,

            }

            const response_Droga = await fetch(url_Droga, config_Droga);
            const info_Droga = await response_Droga.json();
            //  console.log(info_Droga);

            TablaInfoPer1.destroy();
            TablaInfoPer1 = new Datatable('#dataTable4', {

                language: lenguaje,
                data: info_Droga,
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
        case 8:
            modal_pista.show();

            info.forEach(info1 => {
                forminfo.fecha1.value = info1.fecha
                forminfo.topico1.value = info1.topico
                forminfo.latitud1.value = info1.latitud
                forminfo.longitud1.value = info1.longitud
                forminfo.departamentoBusqueda1.value = info1.depto
                forminfo.municipio1.value = info1.municipio
                forminfo.actvidad_vinculada1.value = info1.actividad
                forminfo.lugar1.value = info1.lugar
                // forminfo.departamentoBusqueda.value = info1.FECHA
            });

            const urlPista = `/medios-comunicacion/API/mapas/infoDroga/distanciaPista`
            const bodyPista = new FormData();
            bodyPista.append('id', id);
            const headersPista = new Headers();
            headersPista.append("X-Requested-With", "fetch");

            const configPista = {
                method: 'POST',
                body: bodyPista,

            }

            const responsePista = await fetch(urlPista, configPista);
            const pista_dato = await responsePista.json();


            console.log(pista_dato)
            if (pista_dato != null) {
                pista_dato.forEach(pista1 => {
                    forminfo.longitud_pista.value = pista1.cantidad

                });
            }

            break;
    }


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

        const url = `/medios-comunicacion/API/mapas/infoDroga/mapaCalor`
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
        // console.log(info);

        if ((fecha1 != "" && fecha2 != "") || formMapa.incautaciondroga_mapa_calor.value != "") {
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
        const url1 = `/medios-comunicacion/API/mapas/infoDroga/colores`
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
    const tipoDroga = formMapa.incautaciondroga_mapa_calor.value
    const url = `/medios-comunicacion/API/mapas/infoDroga/mapaCalorPorDepto`
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
        deptoinfo1.innerText = info_depto1[0].cantidad
        deptoincidencia1.innerText = info_depto1[1].desc
        deptoinfo.innerText = info_depto1[2].cantidad
        deptoinfo2.innerText = info_depto1[4].cantidad
        deptoincidencia.innerText = info_depto1[3].desc
        if (tipoDroga != "") {
            label_delito.innerText = '  Droga seleccionado:'
        }
        if (tipoDroga == "") {
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

    const url_grafica = `/medios-comunicacion/API/mapas/infoDroga/mapaCalorPorDeptoGrafica`
    const bodyGrafica = new FormData(formMapa);
    bodyGrafica.append('departamento', valor);
    const headersGrafica = new Headers();
    headersGrafica.append("X-Requested-With", "fetch");

    const configGrafica = {
        method: 'POST',
        headers: headersGrafica,
        body: bodyGrafica,

    }
    const response = await fetch(url_grafica, configGrafica)
    const datos = await response.json()
    try {

       

        
        if (datos) {
            document.getElementById('grafica_depto1').style.display = "block"
            document.getElementById('texto_no').style.display = "none"

            const ctx = document.getElementById('droga_cant');
            if (window.grafica) {
                window.grafica.clear();
                window.grafica.destroy();
            }

            let { labels, cantidades } = datos;
            
            let dataSetsLabels = Object.keys(cantidades);
            let dataSetsValues = Object.values(cantidades)
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
            // mostrar(datos)
            //  $("#delitos_cant").destroy();


            let chartInfo = {
                type: 'bar',
                data: {
                    labels,
                    datasets
                },
                options: {
                    indexAxis: 'x',
                    plugins: {
                        title: {
                            display: true,
                            text: 'Cantidad de Droga'
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
            window.grafica = new Chart(ctx, chartInfo)
            window.grafica.update()

        }
        else {
          
            document.getElementById('grafica_depto1').style.display = "none"
            document.getElementById('texto_no').style.display = "block"
        }
    } catch (error) {
        console.log(error);
    }




}

window.pistas_clandestinas = async(e) => {
    e && e.preventDefault();
    // tipo_droga = $('#incautaciondroga_mapa_calor').val()

   
    const url = `/medios-comunicacion/API/mapas/infoDroga/mapaCalorPorDeptoPistas`
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

    deptos = document.querySelectorAll('path');
   
        // console.log(info)

    deptos.forEach(element => {
        element.setAttribute('fill', '#145A32 ')
            // console.log(element)
    })

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




//________________________________________________________GRAFICA POR DELITOS __________________________________________________________________________________________________________


const drogas_estadistica = async (e) => {
    e && e.preventDefault();

    const url_grafica1 = `/medios-comunicacion/API/mapas/infoDroga/DrogasCantGrafica`
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
        // console.log(datos1);
        if (window.drogas_grafica) {
            window.drogas_grafica.clear();
            window.drogas_grafica.destroy();
        }
        let { labels, cantidades, informacion } = datos1;

            let dataSetsLabels = Object.keys(cantidades);
            let dataSetsValues = Object.values(cantidades); 
           
        if (informacion > 0 ) {
            document.getElementById('graficaDroga').style.display = "block"
            document.getElementById('texto_no1').style.display = "none"

                 
        
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

            const ctx = document.getElementById('myChart9');
           
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
                            text: 'Cantidad de Droga'
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
            window.drogas_grafica = new Chart(ctx, chartInfo);
            window.drogas_grafica.update()
        } 
   
        else {

            document.getElementById('texto_no1').style.display = "block";
            document.getElementById('graficaDroga').style.display = "none";

        }
    } catch (error) {
        console.log(error);
    }
    deptos_estadistica();
}


const deptos_estadistica = async (e) => {
    e && e.preventDefault();

    const url_grafica2 = `/medios-comunicacion/API/mapas/infoDroga/DrogasDepartamentoGrafica`
    const bodyGrafica2 = new FormData(formBusqueda_grafica);

    const headersGrafica2 = new Headers();
    headersGrafica2.append("X-Requested-With", "fetch");

    const configGrafica2 = {
        method: 'POST',
        headers: headersGrafica2,
        body: bodyGrafica2,
    }
    const response2 = await fetch(url_grafica2, configGrafica2)
    const datos2 = await response2.json()
        // console.log(datos2)
    try {

       
        if (datos2.length > 0) {
            document.getElementById('graficaDrogaDepartamento').style.display = "block"
            document.getElementById('texto_no2').style.display = "none"


            let labels = [], cantidades = []
            datos2.forEach(d => {
                labels = [...labels, d.descripcion]
                cantidades = [...cantidades, d.cantidad]
            })
            // mostrar(datos)
            //  $("#delitos_cant").destroy();
            const ctx = document.getElementById('myChart2');
          

            if (window.DrogaDepartamento_grafica) {
                window.DrogaDepartamento_grafica.clear();
                window.DrogaDepartamento_grafica.destroy();
            }
            window.DrogaDepartamento_grafica = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels,
                    datasets: [{
                        label: 'Droga',
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
            document.getElementById('graficaDrogaDepartamento').style.display = "none";

        }
    } catch (error) {
        console.log(error);
    }

}



const IncautacionesPorDia = async () => {

    const url_grafica2 = `/medios-comunicacion/API/mapas/infoDroga/IncautacionesPorDiaGrafica`
    const headersGrafica2 = new Headers();
    headersGrafica2.append("X-Requested-With", "fetch");

    const configGrafica2 = {
        method: 'POST',
        headers: headersGrafica2,
    }
    const response2 = await fetch(url_grafica2, configGrafica2)
    const datos2 = await response2.json()


    const url_grafica = `/medios-comunicacion/API/mapas/infoDroga/KilosPorDiaGrafica`
    const headersGrafica = new Headers();
    headersGrafica.append("X-Requested-With", "fetch");

    const configGrafica = {
        method: 'POST',
        headers: headersGrafica,
    }
    const response = await fetch(url_grafica, configGrafica)
    const datos = await response.json()
   


    const url_grafica1 = `/medios-comunicacion/API/mapas/infoDroga/MatasPorDiaGrafica`
    const headersGrafica1 = new Headers();
    headersGrafica1.append("X-Requested-With", "fetch");
    const configGrafica1 = {
        method: 'POST',
        headers: headersGrafica1,
    }
    const response1 = await fetch(url_grafica1, configGrafica1)
    const datos1 = await response1.json()
    // console.log(datos1);

    try { 




        const { dias, cantidades } = datos2;
        const {matas} = datos1;
        const {kilos} = datos;

        const canvas = document.getElementById('myChart3');
        const ctx = canvas.getContext('2d');
        if (window.CapturasPorDia) {
            // console.log(window.CapturasPorDia);
            window.CapturasPorDia.destroy()
        }

        const data = {
            labels: dias,
            datasets: [{
                label: 'INCAUTACIONES',
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
            },
            {
                label: 'CANTIDAD DE KILOS INCAUTADOS',
                data: kilos,
                fill: true,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.5,
                borderColor: '#F10909',
                backgroundColor: '#52A00F',
                pointBorderColor: 'white',
                pointBackgroundColor: 'blue',
                pointRadius: 10,
                pointHoverRadius: 20,
                pointHitRadius: 30,
                pointBorderWidth: 2,
                pointStyle: 'rectRounded',
            },
            {
                label: 'CANTIDAD DE MATAS INCAUTADAS',
                data: matas,
                fill: true,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.5,
                borderColor: '#F10909',
                backgroundColor: '#E6F805',
                pointBorderColor: 'white',
                pointBackgroundColor: 'black',
                pointRadius: 10,
                pointHoverRadius: 20,
                pointHitRadius: 30,
                pointBorderWidth: 2,
                pointStyle: 'rectRounded',
            }
        ]

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
                            text: "OPERACIONES E INCAUTACIONES",
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



const trimestralKilos= async () => {

    const url_grafica2 = `/medios-comunicacion/API/mapas/infoDroga/GraficatrimestralKilos`
    const headersGrafica2 = new Headers();
    headersGrafica2.append("X-Requested-With", "fetch");

    const configGrafica2 = {
        method: 'POST',
        headers: headersGrafica2,

    }
    try {

        const response2 = await fetch(url_grafica2, configGrafica2)
        const info = await response2.json()

       
        const canvas = document.getElementById('myChart4');
        const ctx = canvas.getContext('2d');
        window.trimestralGrafica && window.trimestralGrafica.destroy()

        let { labels, cantidades } = info;


        let dataSetsLabels = Object.keys(cantidades);
        let dataSetsValues = Object.values(cantidades)



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
 
}


const trimestralMatas= async () => {

    const url_grafica2 = `/medios-comunicacion/API/mapas/infoDroga/GraficatrimestralMatas`
    const headersGrafica2 = new Headers();
    headersGrafica2.append("X-Requested-With", "fetch");

    const configGrafica2 = {
        method: 'POST',
        headers: headersGrafica2,

    }
    try {

        const response2 = await fetch(url_grafica2, configGrafica2)
        const info = await response2.json()

        const canvas = document.getElementById('myChart11');
        const ctx = canvas.getContext('2d');
        window.trimestralGraficaMatas && window.trimestralGraficaMatas.destroy()

        let { labels, cantidades } = info;



        let dataSetsLabels = Object.keys(cantidades);
        let dataSetsValues = Object.values(cantidades)

      



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


        window.trimestralGraficaMatas = new Chart(ctx, chartInfo);
        window.trimestralGraficaMatas.update()
    } catch (error) {
        console.log(error)
    }
  
}


const trimestralPistas= async () => {

    const url_grafica2 = `/medios-comunicacion/API/mapas/infoDroga/GraficatrimestralPistas`
    const headersGrafica2 = new Headers();
    headersGrafica2.append("X-Requested-With", "fetch");

    const configGrafica2 = {
        method: 'POST',
        headers: headersGrafica2,

    }
    try {

        const response2 = await fetch(url_grafica2, configGrafica2)
        const info = await response2.json()


        const canvas = document.getElementById('pista_clandestina');
        const ctx = canvas.getContext('2d');
        window.trimestralGraficaPistas && window.trimestralGraficaPistas.destroy()

        let { meses, cantidades } = info;

        const data = {
            labels: meses,
            datasets: [{
                label: 'Pistas inhabilitadas',
                data: cantidades,
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.5,
                borderColor: '#F10909',
                backgroundColor: [
                    'rgba(233, 252, 5 , 0.5)',
                    'rgba(252, 17, 5, 0.8)',
                    'rgba(5, 47, 252 , 0.6)',
                    'rgba(61, 118, 11 , 1)',
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
               
                indexAxis: 'x',
                scales: {
                    x: {
    
                        grid: {
                            tickColor: "white",
                        
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
                        
                        ticks: {
                            color: "black",
                            font: {
                                weight: "bold",
                                size: 25
                            },
                            // stepSize: 10,
                            beginAtZero: true,
                        },
                        title: {
                            display: true,
                            text: "Pistas inhabilitadas",
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

        window.trimestralGraficaPistas = new Chart(ctx, configChart);
        window.trimestralGraficaPistas.update()
    } catch (error) {
        console.log(error)
    }
    // console.log(info);
}


const trimestral_incautaciones_general = async () => {
    const url_grafica2 = `/medios-comunicacion/API/mapas/infoDroga/GraficaTrimestralIncautacionesGeneral`
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
    
        const canvas1 = document.getElementById('myChart5');
        const ctx1 = canvas1.getContext('2d');
        if (window.trimestralIncautacionesGeneral) {
            console.log(window.trimestralIncautacionesGeneral);
            window.trimestralIncautacionesGeneral.destroy()
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
                            text: "INCAUTACIONES",
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
        window.trimestralIncautacionesGeneral = new Chart(ctx1, configChart);
        window.trimestralIncautacionesGeneral.update()
    } catch (error) {
        console.log(error);
    }




}

btnmapa.addEventListener("click", ocultar_mapa);
formBusqueda_resumen.addEventListener('submit', cambiarmes)
formBusqueda_grafica.addEventListener('submit', drogas_estadistica)
btngrafica.addEventListener("click", ocultar_graficas);
btnBuscar.addEventListener("click", Buscar_capturas);
btnresumenbuscar.addEventListener("click", ocultar_select);
btngraficabuscar.addEventListener("click", ocultar_busquedad_grafica);
btnBuscarmapacalor.addEventListener("click", ocultar_busquedad_mapa);
formBusqueda_mapa.addEventListener('submit', busquedad_mapa_Calor)

busquedad_mapa_Calor();
drogas_estadistica();
trimestralKilos();
IncautacionesPorDia();
trimestralMatas();
trimestralPistas();
trimestral_incautaciones_general();


