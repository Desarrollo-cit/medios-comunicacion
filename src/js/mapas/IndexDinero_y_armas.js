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
const btngraficabuscar = document.querySelector("#buscarGrafica");
const formBusqueda_mapa = document.getElementById('formBusqueda_mapa');
const btnBuscarmapacalor = document.querySelector("#buscaravanzada");
const btnresumenbuscar = document.querySelector("#buscarresumen");
const btnBuscar = document.getElementById("buscarcapturas");
const btnmapa = document.querySelector("#ver_mapa");
const btngrafica = document.querySelector("#ver_grafica");

let tablaregistro = new Datatable('#dataTable2');
let TablaInfoPer = new Datatable('#dataTable3');
let TablaInfoPer1 = new Datatable('#dataTable4');
const formcaptura = document.querySelector('#formInformacion1')
const formarmas = document.querySelector('#formInformacion2')
const capturas = new Modal(document.getElementById('modalPersonal12'), {
    keyboard: false
})
const modaldroga1 = new Modal(document.getElementById('modalPersonal13'), {
    keyboard: false
})
const modaldeptos = new Modal(document.getElementById('modaldepto'), {
    keyboard: false
})

const cambiarmes = async (evento) => {
    evento.preventDefault();


    var cantidad_incautaciones = document.getElementById('cantidad_incautaciones');
    var total_armas = document.getElementById('total_armas');

    var incidencia = document.getElementById('delito_concurrente');
    var depto_mayor = document.getElementById('depto_mayor');
    var f1 = new Date(formBusqueda_resumen.fecha_resumen.value)
    var f2 = new Date(formBusqueda_resumen.fecha_resumen2.value)



    if (f1 < f2) {

        const url = '/medios-comunicacion/API/mapas/IndexDinero_y_armas/resumen'
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

         //console.log(data)
        if (data) {
            cantidad_incautaciones.innerText = data[0].cantidad
            total_dinero.innerText = data[4].cantidad_din
            total_armas.innerText = data[2].cantidad_arm
            incidencia.innerText = data[1].descripcion+" "+data[1].municion
            depto_mayor.innerText = data[3].desc.trim()
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


        const url = `/medios-comunicacion/API/mapas/IndexDinero_y_armas/listado`
        const headers = new Headers();
        headers.append("X-Requested-With", "fetch");

        const config = {
            method: 'GET',

        }

        const respuesta = await fetch(url, config);
        const info = await respuesta.json();
      //  console.log(info)

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

                    ` <button class='btn btn-success'     onclick='ModalPersonal(${row.id}, ${row.tipo1})'><i class="bi bi-info-circle"></i></button>`,
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



window.ModalPersonal = async (id, tipo1) => {
// console.log(tipo1)
if (tipo1 == 6){
    const url = `/medios-comunicacion/API/mapas/IndexDinero_y_armas/modal`
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
//    console.log(info);
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

   const url1 = `/medios-comunicacion/API/mapas/IndexDinero_y_armas/informacion`
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

     
  
  

           TablaInfoPer.destroy();
           TablaInfoPer = new Datatable('#dataTable3', {
               language: lenguaje,
               data: info1,
               columns: [
                   { data: "contador", "width": "10%" },
                   { data: "tipo_arma", "width": "20%" },
                   { data: "calibre", "width": "15%" },
                   { data: "cantidad", "width": "15%" },
         
               ]
           })


}else if (tipo1==5){

    const url = `/medios-comunicacion/API/mapas/IndexDinero_y_armas/modal`
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
//    console.log(info);
   modaldroga1.show();
   info.forEach(info1 => {
     //  alert(info1.fecha)

      formarmas.fecha1.value = info1.fecha
       formarmas.topico.value = info1.topico
       formarmas.latitud.value = info1.latitud
       formarmas.longitud.value = info1.longitud
       formarmas.departamentoBusqueda.value = info1.depto
       formarmas.municipio.value = info1.municipio[0]['dm_desc_lg']
       formarmas.actvidad_vinculada.value = info1.actividad
       formarmas.lugar.value = info1.lugar

   });


   modaldroga1.show();
   const url2 = `/medios-comunicacion/API/mapas/IndexDinero_y_armas/informacion1`
   const body2 = new FormData();
   body2.append('id', id);
   const headers1 = new Headers();
   headers1.append("X-Requested-With", "fetch");

   const config2 = {
       method: 'POST',
       body,

   }

   const respuesta1 = await fetch(url2, config2);
   const dinero = await respuesta1.json();
// console.log(dinero);

TablaInfoPer1.destroy();
TablaInfoPer1 = new Datatable('#dataTable4', {
    language: lenguaje,
    data: dinero,
    columns: [
        { data: "contador", "width": "10%" },
        { data: "dinero", "width": "20%" },
        { data: "cantidad", "width": "15%" },
   
    ]
})
   

}

              
        }
    
    
         
    






    const deptos_estadistica = async (e) => {
        e && e.preventDefault();
    
        const url_grafica2 = `/medios-comunicacion/API/mapas/IndexDinero_y_armas/DelitosDepartamentoGrafica`
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
   // console.log(datos2)
    
            if (datos2.length > 0) {
                document.getElementById('graficaDelitosDepartamento').style.display = "block"
                document.getElementById('texto_no2').style.display = "none"
    
    
                let labels = [], cantidades = []
                datos2.forEach(d => {
                    labels = [...labels, d.descripcion]
                    cantidades = [...cantidades, d.cantidad]
                  //  alert(labels)
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
    



    const deptos_estadistica_dinero = async (e) => {
        e && e.preventDefault();
    
        const url_grafica2 = `/medios-comunicacion/API/mapas/IndexDinero_y_armas/DineroDepartamentoGrafica`
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
   // console.log(datos2)
    
            if (datos2.length > 0) {
                document.getElementById('graficaDineroDepartamento').style.display = "block"
                document.getElementById('texto_no2').style.display = "none"
    
    
                let labels = [], cantidades = []
                datos2.forEach(d => {
                    labels = [...labels, d.departamento]
                    cantidades = [...cantidades, d.cantidad]
                   // console.log(labels)
                })
                // mostrar(datos)
                //  $("#delitos_cant").destroy();
                const ctx = document.getElementById('myChart99');
                if (window.dineroDepartamento_grafica) {
                    window.dineroDepartamento_grafica.clear();
                    window.dineroDepartamento_grafica.destroy();
                }
    
             
                window.dineroDepartamento_grafica = new Chart(ctx, {
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
                document.getElementById('graficaDineroDepartamento').style.display = "none";
    
            }
        } catch (error) {
            console.log(error);
        }
    
    }    



const formMapa = document.querySelector('#formBusqueda_mapa')

const busquedad_mapa_Calor = async(e) => {
    e && e.preventDefault();

    // const delito = formMapa.cantidad_droga.value
    // const fecha1 = formMapa.fecha_mapa.value
    // const fecha2 = formMapa.fecha2.value
   


    const url = `/medios-comunicacion/API/mapas/IndexDinero_y_armas/mapaCalor`
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
   
      //   console.log(info)
   window.deptos = document.querySelectorAll('path');
    deptos.forEach(element => {
        element.setAttribute('fill', '#145A32 ')

    })
    const url1 = `/medios-comunicacion/API/mapas/IndexDinero_y_armas/colores`
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
    const arma = formMapa.tipos_arma_mapa_calor.value 
    const url = `/medios-comunicacion/API/mapas/IndexDinero_y_armas/mapaCalorPorDepto`
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
        deptoinfo.innerText = info_depto1[0].descripcion+info_depto1[0].municion
        deptoincidencia.innerText = info_depto1[1].cantidad_arm
        dinero.innerText = info_depto1[2].cantidad_din
        
     
    } else {
        deptoinfo.innerText = ''
        deptoincidencia.innerText = ''
        dinero.innerText = ''
        label_delito.innerText = 'Incidencia:'

    }

    const label = document.getElementById('depto_name')
    const deptoname = document.getElementById(valor)
    const name = deptoname.getAttribute("name");
    //    alert(name)

    modaldeptos.show();
    label.innerText = 'DEPARTAMENTO DE ' + name.toUpperCase();

    const url_grafica = `/medios-comunicacion/API/mapas/IndexDinero_y_armas/mapaCalorPorDeptoGrafica`
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

       

        // console.log(datos);
       // console.log(datos.descripcion);
        // console.log(datos.cantidades.armas.length);
        
            document.getElementById('grafica_depto1').style.display = "block"
            document.getElementById('texto_no').style.display = "none"


            let { descripcion, cantidades, } = datos;

            let dataSetsLabels = Object.values(descripcion);
            let dataSetsValues = Object.values(cantidades.armas); 
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
                    labels: dataSetsLabels,
                    datasets: [{
                        label: 'ARMAS',
                        data: dataSetsValues,
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





//________________________________________________________GRAFICA POR DELITOS __________________________________________________________________________________________________________


const delitos_estadistica = async (e) => {
    e && e.preventDefault();

    const url_grafica1 = `/medios-comunicacion/API/mapas/IndexDinero_y_armas/DelitosCantGrafica`
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
    //    console.log(datos1)

       let { descripcion, cantidades, valor} = datos1;
        
  if(valor > 0){
            document.getElementById('graficaDelitos').style.display = "block"
            document.getElementById('texto_no1').style.display = "none"


         

         
            let dataSetsLabels = Object.values(descripcion);
            let dataSetsValues = Object.values(cantidades.armas); 
            const ctx = document.getElementById('myChart1');
            if (window.delitos_grafica) {
                window.delitos_grafica.clear();
                window.delitos_grafica.destroy();
            }
            window.delitos_grafica = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: dataSetsLabels,
                    datasets: [{
                        label: 'ARMAS',
                        data: dataSetsValues,

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
    deptos_estadistica()
    dinero_estadistica();

}


// dinero estadsitica


const dinero_estadistica = async (e) => {
    e && e.preventDefault();

    const url_grafica1 = `/medios-comunicacion/API/mapas/IndexDinero_y_armas/DineroCantGrafica`
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
        const datos2 = await response1.json()
        // console.log(datos2);
        let {cantidades, labels, valor} = datos2;
        if(valor > 0 ){
        document.getElementById('graficaDinero').style.display = "block"
        document.getElementById('texto_no2').style.display = "none"
        
    

            const ctx = document.getElementById('myChart55');
            if (window.dinero_grafica) {
                window.dinero_grafica.clear();
                window.dinero_grafica.destroy();
            }
            window.dinero_grafica = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'DINERO',
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

            document.getElementById('texto_no2').style.display = "block";
            document.getElementById('graficaDinero').style.display = "none";
        }
         
    } catch (error) {
        console.log(error);
    }
    deptos_estadistica_dinero()

}



const CapturasPorDia = async () => {

    const url_grafica2 = `/medios-comunicacion/API/mapas/IndexDinero_y_armas/CapturasPorDiaGrafica`
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
                            text: "INCAUTACIONES DE DINERO",
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



const CapturasPorDia_armas = async () => {

    const url_grafica2 = `/medios-comunicacion/API/mapas/IndexDinero_y_armas/CapturasPorDiaGrafica_armas`
    const headersGrafica2 = new Headers();
    headersGrafica2.append("X-Requested-With", "fetch");

    const configGrafica2 = {
        method: 'POST',
        headers: headersGrafica2,

    }
    try {

        const response2 = await fetch(url_grafica2, configGrafica2)
        const datos2 = await response2.json()

//  console.log(datos2);

        const { dias, cantidades } = datos2;

        const canvas = document.getElementById('myChart33');
        const ctx = canvas.getContext('2d');
        if (window.DineroPorDia) {
            // console.log(window.CapturasPorDia);
            window.DineroPorDia.destroy()
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
                            text: "INCAUTACIONES DE ARMAS",
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


        window.DineroPorDia = new Chart(ctx, configChart);
        window.DineroPorDia.update()
    } catch (e) {
        console.log(error)

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


const trimestralesDelitos = async () => {

    const url_grafica2 = `/medios-comunicacion/API/mapas/IndexDinero_y_armas/GraficaTrimestral`
    const headersGrafica2 = new Headers();
    headersGrafica2.append("X-Requested-With", "fetch");

    const configGrafica2 = {
        method: 'POST',
        headers: headersGrafica2,

    }
    try {

        const response2 = await fetch(url_grafica2, configGrafica2)
        const info = await response2.json()
    //    console.log(info)



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
       // console.log(datasets);

        for (let index = 0; index < dataSetsLabels.length; index++) {
            datasets = [...datasets, {
                label: dataSetsLabels[index],
                data: dataSetsValues[index],
                backgroundColor: chartColors[index],
                borderColor: chartColors[index],
                borderWidth: 1
            }]

        }

       //  console.log(datasets);
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
                        text: 'Cantidad de Armas'
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


const chartColors = [
    'rgba(14, 128, 255, 0.8)', //azul
    'rgba(7, 216, 0, 0.8)', //verde
    'rgba(255, 0, 0, 0.8)', //rojo
    'rgba(255, 0, 231, 0.8)', //rosa
    'rgba(0, 255, 247, 0.8)', //celeste
    'rgba(236, 255, 0, 0.8)', //amarillo
    'rgba(162, 255, 0, 0.8)' //verde mas claro
];


const trimestral_capturas_general = async () => {
    const url_grafica2 = `/medios-comunicacion/API/mapas/IndexDinero_y_armas/GraficaTrimestralGeneral`
     const headersGrafica2 = new Headers();
     headersGrafica2.append("X-Requested-With", "fetch");
 
     const configGrafica2 = {
         method: 'POST',
         headers: headersGrafica2,
 
     }
     try {
 
         const response2 = await fetch(url_grafica2, configGrafica2)
         const info = await response2.json()
 
         // info.length < 1 && Toast.fire({
         //     icon: 'warning',
         //     title: 'Ingreso mal las fechas'
         // })
 
 
     const { meses, cantidades } = info;
    //   console.log(info);
     const canvas1 = document.getElementById('myChart5');
     const ctx1 = canvas1.getContext('2d');
     if (window.trimestral_capturaGeneral) {
         console.log(window.trimestral_capturaGeneral);
         window.trimestral_capturaGeneral.destroy()
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
                       size:10
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
                         text: "CAPTURAS",
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
     window.trimestral_capturaGeneral = new Chart(ctx1, configChart);
     window.trimestral_capturaGeneral.update()
     }catch(error){
         console.log(error);
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


    
formBusqueda_resumen.addEventListener('submit', cambiarmes)
btnBuscar.addEventListener("click", Buscar_capturas);
btnresumenbuscar.addEventListener("click", ocultar_select);
btngraficabuscar.addEventListener("click", ocultar_busquedad_grafica);
btnBuscarmapacalor.addEventListener("click", ocultar_busquedad_mapa);
formBusqueda_mapa.addEventListener('submit', busquedad_mapa_Calor)
btnmapa.addEventListener("click", ocultar_mapa);
btngrafica.addEventListener("click", ocultar_graficas);
busquedad_mapa_Calor();




formBusqueda_grafica.addEventListener('submit', delitos_estadistica, dinero_estadistica)

btnmapa.addEventListener("click", ocultar_mapa);
busquedad_mapa_Calor();
dinero_estadistica();
delitos_estadistica();
//delitos_estadistica_dinero();
CapturasPorDia();
CapturasPorDia_armas();
trimestralesDelitos();
trimestral_capturas_general();
 deptos_estadistica_dinero();
btngrafica.addEventListener("click", ocultar_graficas);

