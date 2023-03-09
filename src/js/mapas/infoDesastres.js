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
const formcaptura = document.querySelector('#formInformacion1')
const formdroga = document.querySelector('#formInformacion2')
const capturas = new Modal(document.getElementById('modaldesastre'), {
    keyboard: false
})

const modaldeptos = new Modal(document.getElementById('modaldepto'), {
    keyboard: false
})


const cambiarmes = async (evento) => {
    evento.preventDefault();


    var cantidadDesastres = document.getElementById('cantidadDesastres');
    var desastresId = document.getElementById('desastresId');
    var incurrenciaId = document.getElementById('incurrenciaId');
    var IncurrenciaDesastres = document.getElementById('IncurrenciaDesastres');
    var personasAfectadas = document.getElementById('personasAfectadas');
    var personasEvacuadas = document.getElementById('personasEvacuadas');
    var personasFallecidas = document.getElementById('personasFallecidas');
    var estructurasColapsadas = document.getElementById('estructurasColapsadas');
    var inundaciones = document.getElementById('inundaciones');
    var derrumbes = document.getElementById('derrumbes');
    var carreterasPuentesColapsados = document.getElementById('carreterasPuentesColapsados');
    var hectareasQuemadas = document.getElementById('hectareasQuemadas');
    var desbordamientosderios = document.getElementById('desbordamientosderios');
    var Departamento_afectado = document.getElementById('Departamento_afectado');
    var f1 = new Date(formBusqueda_resumen.fecha_resumen.value)
    var f2 = new Date(formBusqueda_resumen.fecha_resumen2.value)
    var fecha1 = formBusqueda_resumen.fecha_resumen.value;
    var fecha2 = formBusqueda_resumen.fecha_resumen2.value;
    var fenomenoNatural = formBusqueda_resumen.fenomenos_naturales.value;


    if (f1 < f2 || fecha1 =="" && fecha2=="" )  {

        const url = '/medios-comunicacion/API/mapas/infoDesastres/resumen'
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
        console.log(data);
if(data[0].cantidad == 0){
    Toast.fire({
        icon: 'error',
        title: 'Sin registros'
    })
    }else{
        Toast.fire({
            icon: 'success',
            title: 'Se tienen los siguientes registros'
        })
    

}
        
        if (data) {

            cantidadDesastres.innerText = data[0].cantidad
            IncurrenciaDesastres.innerText = data[1].desc
            if(fenomenoNatural != "" ){
                desastresId.style.display = "none"
                incurrenciaId.style.display = "none"

            }else{
                desastresId.style.display = "block"
                incurrenciaId.style.display = "block"
            }
            personasAfectadas.innerText = data[2].cantidad
            personasEvacuadas.innerText = data[3].cantidad
            personasFallecidas.innerText = data[4].cantidad
            estructurasColapsadas.innerText = data[5].cantidad
            inundaciones.innerText = data[6].cantidad
            derrumbes.innerText = data[7].cantidad
            carreterasPuentesColapsados.innerText = data[8].cantidad
            hectareasQuemadas.innerText = data[9].cantidad
            desbordamientosderios.innerText = data[10].cantidad
            Departamento_afectado.innerText = data[11].departamento
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
    

    } else {
        document.querySelector("#cuadro_busquedad_resumen").style.display = "none";
  


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


        const url = `/medios-comunicacion/API/mapas/infoDesastres/listado`
        const headers = new Headers();
        headers.append("X-Requested-With", "fetch");

        const config = {
            method: 'GET',

        }

        const respuesta = await fetch(url, config);
        const info = await respuesta.json();

console.log(info);
        tablaregistro.destroy();
        tablaregistro = new Datatable('#dataTable2', {
            language: lenguaje,
            data: info,
            columns: [
                { data: "contador", "width": "5%" },
                { data: "fecha", "width": "11%" },
                { data: "departamento", "width": "11%" },
                { data: "lugar", "width": "11%" },
                { data: "tipo", "width": "11%" },
                { data: "fenomeno", "width": "15%" },
                { data: "muertes", "width": "11%" },
                { data: "promedio", "width": "15%" },

                {
                    data: "id",

                    "render": (data, type, row, meta) =>

                        ` <button class='btn btn-success'     onclick='ModalPersonal(${row.id}, ${row.tipo})'><i class="bi bi-info-circle"></i></button>`,
                    "searchable": false,
                    "width": "10%"
                },
                {
                    data: "id",
                    "render": (data, type, row, meta) => `<a target='blank' href='/medios-comunicacion/reportes/topico?id=${row.id}'><button class='btn btn-outline-primary'  >REPORTE<i class="bi bi-printer"></i></button></a>`,
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


    const url = `/medios-comunicacion/API/mapas/infoDesastres/modal`
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
    console.log(info);

    const url1 = `/medios-comunicacion/API/mapas/infoDesastres/informacion`
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

        const url = `/medios-comunicacion/API/mapas/infoDesastres/mapaCalor`
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
if( (fecha1 != "" && fecha2 != "") || formMapa.delitos_mapa_calor.value !="" ){
if(info.length ==  0){
Toast.fire({
    icon: 'error',
    title: 'Sin registros'
})
}else{
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
        const url1 = `/medios-comunicacion/API/mapas/infoDesastres/colores`
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
    const delito = formMapa.delitos_mapa_calor.value
    const url = `/medios-comunicacion/API/mapas/infoDesastres/mapaCalorPorDepto`
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

    
    if (info_depto1) {
        deptoinfo.innerText = info_depto1[0].cantidad_delito
        deptoincidencia.innerText = info_depto1[1].desc
        if (delito != "") {
            label_delito.innerText = 'Delito seleccionado:'
        }
        if (delito == "") {
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

    const url_grafica = `/medios-comunicacion/API/mapas/infoDesastres/mapaCalorPorDeptoGrafica`
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
                        label: 'DELITOS',
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




//________________________________________________________GRAFICA POR DESASTRE Y FECHAS __________________________________________________________________________________________________________


const desastres_estadisticas = async (e) => {
    e && e.preventDefault();



    const url_grafica1 = `/medios-comunicacion/API/mapas/infoDesastres/DesatresCantGrafica`
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

        console.log(datos1);
       


        if((formBusqueda_grafica.fecha_grafica.value != "" && formBusqueda_grafica.fecha_grafica2.value != "") || formBusqueda_grafica.select_grafica.value !=""  ){
            const fecha1 = formBusqueda_grafica.fecha_grafica.value
            const fecha2 = formBusqueda_grafica.fecha_grafica2.value
            if (fecha1 == "" && fecha2 == "") {
                var valor = 1
            } else {
        
                var valor = 2
            }
            var f1 = new Date(formBusqueda_grafica.fecha_grafica.value)
            var f2 = new Date(formBusqueda_grafica.fecha_grafica2.value)
            if ((f1 > f2 && valor == 2) ){
                Toast.fire({
                    icon: 'error',
                    title: 'Ingreso mal las fechas'
                })
                valor = 3;
                
            }

            if(datos1[0]['total'] !=""){
                Toast.fire({
                    icon: 'success',
                    title: 'Se tienen los siguientes registros'
                })

                
            }else{
                Toast.fire({
                    icon: 'error',
                    title: 'Sin registros'
                })


            }

        }

        if(datos1[0]['total'] !="" && valor !=3){

               
       
            document.getElementById('graficaDelitos').style.display = "block"
            document.getElementById('texto_no1').style.display = "none"


            let labels = [], cantidades = []
            datos1.forEach(d => {
                labels = [...labels, "Personas Fallecidas","Personas Evacuadas","Personas Afectadas","Albergues","Estructuras Colapsadas","Hectareas Quemadas", "Inundaciones","Rios"]
                cantidades = [...cantidades, d.per_fallecida,d.per_evacuada,d.per_afectada,d.albergues,d.est_colapsadas,d.hectareas_quemadas,d.inundaciones,d.rios]
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
                        
                        label: 'CANTIDADES',
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
            
        }else{

            document.getElementById('texto_no1').style.display = "block";
            document.getElementById('graficaDelitos').style.display = "none";
        }
        
    } catch (error) {
        console.log(error);
    }

    desastrepormes()
    

}


// const deptos_estadistica = async (e) => {
//     e && e.preventDefault();

//     const url_grafica2 = `/medios-comunicacion/API/mapas/infoDesastres/DelitosDepartamentoGrafica`
//     const bodyGrafica2 = new FormData(formBusqueda_grafica);

//     const headersGrafica2 = new Headers();
//     headersGrafica2.append("X-Requested-With", "fetch");

//     const configGrafica2 = {
//         method: 'POST',
//         headers: headersGrafica2,
//         body: bodyGrafica2,
//     }
//     try {

//         const response2 = await fetch(url_grafica2, configGrafica2)
//         const datos2 = await response2.json()


//         if (datos2.length > 0) {
//             document.getElementById('graficaDelitosDepartamento').style.display = "block"
//             document.getElementById('texto_no2').style.display = "none"


//             let labels = [], cantidades = []
//             datos2.forEach(d => {
//                 labels = [...labels, d.descripcion]
//                 cantidades = [...cantidades, d.cantidad]
//             })
//             // mostrar(datos)
//             //  $("#delitos_cant").destroy();
//             const ctx = document.getElementById('myChart2');
//             if (window.delitosDepartamento_grafica) {
//                 window.delitosDepartamento_grafica.clear();
//                 window.delitosDepartamento_grafica.destroy();
//             }

         
//             window.delitosDepartamento_grafica = new Chart(ctx, {
//                 type: 'doughnut',
//                 data: {
//                     labels,
//                     datasets: [{
//                         label: 'DELITOS',
//                         data: cantidades,

//                         backgroundColor: [
//                             'red',
//                             'rgba(54, 162, 235, 1)',
//                             'rgba(255, 206, 86, 1)',
//                             'rgba(75, 192, 192, 1)',
//                             'rgba(153, 102, 255, 1)',
//                             'blue',
//                             'rgba(255, 159, 64, 1)'
//                         ],
//                         borderColor: [
//                             'rgba(255, 236, 0, 1)',
//                             'rgba(255, 236, 0, 1)',
//                             'rgba(255, 236, 0, 1)',
//                             'rgba(255, 236, 0, 1)',
//                             'rgba(255, 236, 0, 1)',
//                             'rgba(255, 236, 0, 1)'
//                         ],
//                         borderWidth: 5
//                     }]
//                 },
//                 options: {
//                     plugins: {
//                         legend: {
//                             position: 'left',

//                             font: {
//                                 size: 45, // 'size' now within object 'font {}'
//                             },


//                         },
//                     }

//                 }
//             });
//         } else {

//             document.getElementById('texto_no2').style.display = "block";
//             document.getElementById('graficaDelitosDepartamento').style.display = "none";

//         }
//     } catch (error) {
//         console.log(error);
//     }

// }



const desastrepormes = async () => {

    const url_grafica2 = `/medios-comunicacion/API/mapas/infoDesastres/desastrespormes`
    const headersGrafica2 = new Headers();
    headersGrafica2.append("X-Requested-With", "fetch");

    const configGrafica2 = {
        method: 'POST',
        headers: headersGrafica2,

    }
    try {

        const response2 = await fetch(url_grafica2, configGrafica2)
        const datos2 = await response2.json()

console.log(datos2);


let labels = [], cantidades = []
datos2.forEach(d => {
    labels = [...labels, "Personas Fallecidas","Personas Evacuadas","Personas Afectadas","Albergues","Estructuras Colapsadas","Hectareas Quemadas", "Inundaciones","Rios"]
    cantidades = [...cantidades, d.per_fallecida,d.per_evacuada,d.per_afectada,d.albergues,d.est_colapsadas,d.hectareas_quemadas,d.inundaciones,d.rios]
})

const ctx2 = document.getElementById('myChart3');

window.desastrepormes2 = new Chart(ctx2, {
    type: 'bar',
    data: {

        
        labels,
        datasets: [{
            
            label: 'CANTIDADES',
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
    } catch (e) {
        console.log(e)

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



const trimestralesDesastres = async () => {

    const url_grafica2 = `/medios-comunicacion/API/mapas/infoDesastres/GraficaTrimestral`
    const headersGrafica2 = new Headers();
    headersGrafica2.append("X-Requested-With", "fetch");

    const configGrafica2 = {
        method: 'POST',
        headers: headersGrafica2,

    }
    try {

        const response2 = await fetch(url_grafica2, configGrafica2)
        const info = await response2.json()

        const { primer_trimestre,segundo_trimestre,tercer_trimestre,cuarto_trimestre } = info;

        // info.length < 1 && Toast.fire({
        //     icon: 'warning',
        //     title: 'Ingreso mal las fechas'
        // })


        // return

        console.log(info);
        let labels = [], cantidades = []
       
        info.forEach(d => {
            
            labels = [...labels,d.nombre, "Primer Trimestre","Segundo Trimestre","Tercer Trimestre","Cuarto Trimestre"]

           
            cantidades = [...cantidades, d.promedio ]
        })
 
        const ctx2 = document.getElementById('myChart4');
        
        window.desastrepormes2 = new Chart(ctx2, {
            type: 'bar',
            data: {
        
                
                labels,
                datasets: [{
                    
                    label: 'CANTIDADES',
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
    } catch (error) {
        console.log(error)
    }
    // console.log(info);
}



// const trimestral_capturas_general = async () => {
//    const url_grafica2 = `/medios-comunicacion/API/mapas/infoDesastres/GraficaTrimestralGeneral`
//     const headersGrafica2 = new Headers();
//     headersGrafica2.append("X-Requested-With", "fetch");

//     const configGrafica2 = {
//         method: 'POST',
//         headers: headersGrafica2,

//     }
//     try {

//         const response2 = await fetch(url_grafica2, configGrafica2)
//         const info = await response2.json()

//         // info.length < 1 && Toast.fire({
//         //     icon: 'warning',
//         //     title: 'Ingreso mal las fechas'
//         // })


//     const { meses, cantidades } = info;
//     // console.log(info);
//     const canvas1 = document.getElementById('myChart5');
//     const ctx1 = canvas1.getContext('2d');
//     if (window.trimestral_capturaGeneral) {
//         console.log(window.trimestral_capturaGeneral);
//         window.trimestral_capturaGeneral.destroy()
//     }

//     const data = {
//         labels: meses,
//         datasets: [{
//             label: 'ESTADISTICA TRIMESTRAL',
//             data: cantidades,
//             fill: false,
//             borderColor: 'rgb(75, 192, 192)',
//             tension: 0.5,
//             borderColor: '#F10909',
//             backgroundColor: [
//                 'rgba(236, 26, 19  , 0.5)',
//                 'rgba(8, 144, 47 , 0.4)',
//                 'rgba(8, 14, 144 , 0.6)',
//                 'rgba(253, 253, 3, 1)',
//                 'rgba(8, 129, 144 , 1)',
//                 'rgba(255, 159, 64, 1)',
//                 'rgba(241, 9, 9 , 1)',
//                 'rgba(26, 50, 148,  1)',
//                 'rgba(18, 199, 29,  1)'
//             ],
//         }]

//     };

//     const configChart = {
//         type: 'bar',
//         data: data,
//         options: {
//             plugins: {
//                 legend: {
//                   position: "top",
//                   labels: {
//                     boxWidth: 100,
//                     usePointStyle: true,
//                     pointStyle: "line",
//                   }
//                 }
//               },
//             indexAxis: 'x',
//             scales: {
//                 x: {

//                     grid: {
//                         tickColor: "white",
//                         // borderDash: [5, 2],
//                         tickWidth: 25,
//                         color: "black",
//                         borderColor: "black",
//                         size: 25
//                     },

//                     ticks: {
//                         color: "black",
//                         font: {
//                             weight: "bold",
//                             size: 30
//                         },

//                     }

//                 },
//                 y: {
//                     grid: {
//                       color: "black",
//                       borderDash: [5, 2,],
//                       borderColor: "black",
//                       tickColor: "yellow",
//                       tickWidth: 5,
//                       size:10
//                     },
//                     ticks: {
//                         color: "black",
//                         font: {
//                             weight: "bold",
//                             size: 25
//                         },
//                         stepSize: 10,
//                         beginAtZero: true,
//                     },
//                     title: {
//                         display: true,
//                         text: "CAPTURAS",
//                         fullSize: true,
//                         color: 'White',
//                         font: {
//                             weight: "bold",
//                             size: 30
//                         }
//                     }

//                 }
//             }
//         }
//     };
//     window.trimestral_capturaGeneral = new Chart(ctx1, configChart);
//     window.trimestral_capturaGeneral.update()
//     }catch(error){
//         console.log(error);
//     }

   


// }


formBusqueda_resumen.addEventListener('submit', cambiarmes)
formBusqueda_grafica.addEventListener('submit', desastres_estadisticas)
btnBuscar.addEventListener("click", Buscar_capturas);
btnresumenbuscar.addEventListener("click", ocultar_select);
btngraficabuscar.addEventListener("click", ocultar_busquedad_grafica);
btnBuscarmapacalor.addEventListener("click", ocultar_busquedad_mapa);
formBusqueda_mapa.addEventListener('submit', busquedad_mapa_Calor)
btnmapa.addEventListener("click", ocultar_mapa);
busquedad_mapa_Calor();
desastres_estadisticas();
desastrepormes();
trimestralesDesastres();
// trimestral_capturas_general();
// deptos_estadistica();
btngrafica.addEventListener("click", ocultar_graficas);

