import { Dropdown } from "bootstrap";
import { validarFormulario, Toast } from "../funciones";
import Datatable from 'datatables.net-bs5';
import { lenguaje } from "../lenguaje";
import Swal from "sweetalert2";

const formDelitos = document.getElementById('formDelitos');
const btnGuardar = document.getElementById('btnGuardar');
const btnModificar = document.getElementById('btnModificar');
const divTabla = document.getElementById('divTabla');
let tablaProductos = new Datatable('#delitosTabla');

btnModificar.parentElement.style.display = 'none';
btnGuardar.disabled = false;
btnModificar.disabled = true;

const guardardelitos = async (evento) => {
    evento.preventDefault();

    let formularioValido = validarFormulario(formDelitos, ['id']);
    if (!formularioValido) {
        Toast.fire({
            icon: 'warning',
            title: 'Debe llenar todos los campos'
        })
        return;
    }



    try {
        //Crear el cuerpo de la consulta
        const url = '/medios-comunicacion/API/delitos/guardar'

        const body = new FormData(formDelitos);
        body.delete('id');
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
                formDelitos.reset();
               
                break;
            case 2:
                icon = "warning"
                formDelitos.reset();

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


        buscardelitos()

    } catch (error) {
        console.log(error);
    }
}

const buscardelitos = async (evento) => {
    evento && evento.preventDefault();

    try {
        const url = '/medios-comunicacion/API/delitos/buscar'
        const headers = new Headers();
        headers.append("X-Requested-With", "fetch");

        const config = {
            method : 'GET',
        }

        const respuesta = await fetch(url, config);
        const data = await respuesta.json();

        // console.log(data);

        
        tablaProductos.destroy();
        let contador = 1;
        tablaProductos = new Datatable('#delitosTabla', {
            language : lenguaje,
            data : data,
            columns : [
                { 
                    data : 'id',
                    render : () => {      
                        return contador++;
                    }
                },
                { data : 'desc'},
                
                { 
                    data : 'id',
                    'render': (data, type, row, meta) => {
                        return `<button class="btn btn-warning" onclick="asignarValores('${row.id}', '${row.desc}')">Modificar</button>`
                    } 
                },
                { 
                    data : 'id',
                    'render': (data, type, row, meta) => {
                        return `<button class="btn btn-danger" onclick="eliminarRegistro('${row.id}')">Eliminar</button>`
                    } 
                },
                { 
                    data : 'id',
                    'render': (data, type, row, meta) => {
                        if(row.situacion==1){
                            return `<button class="btn btn-secondary" onclick="cambiarSituacion('${row.id}', '${row.desc}', '${row.situacion}')">DESACTIVAR</button>`
                        }else{
                            return `<button class="btn btn-success" onclick="cambiarSituacion('${row.id}', '${row.desc}', '${row.situacion}')">ACTIVAR</button>`

                        }
                    } 
                },
            ]
        })

    } catch (error) {
        console.log(error);
    }
}

const modificardelitos = async (evento) => {
    evento.preventDefault();

    let formularioValido = validarFormulario(formDelitos);
    if (!formularioValido) {
        Toast.fire({
            icon: 'warning',
            title: 'Debe llenar todos los campos'
        })
        return;
    }



    try {
        //Crear el cuerpo de la consulta
        const url = '/medios-comunicacion/API/delitos/modificar'

        const body = new FormData(formDelitos);
        
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
                formDelitos.reset();
               
                break;
            case 2:
                icon = "warning"
                formDelitos.reset();

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


        buscardelitos()
        formDelitos.reset();
            btnModificar.parentElement.style.display = 'none';
            btnGuardar.parentElement.style.display = '';
            btnGuardar.disabled = false;
            btnModificar.disabled = true;
        
            divTabla.style.display = ''

    } catch (error) {
        console.log(error);
    }
}
buscardelitos();

window.asignarValores = (id, desc) => {
    formDelitos.id.value = id;
    formDelitos.desc.value = desc;
    btnModificar.parentElement.style.display = '';
    btnGuardar.parentElement.style.display = 'none';
    btnGuardar.disabled = true;
    btnModificar.disabled = false;

    divTabla.style.display = 'none'
}

window.eliminarRegistro = (id) => {
    Swal.fire({
        title : 'Confirmación',
        icon : 'warning',
        text : '¿Esta seguro que desea eliminar este registro?',
        showCancelButton : true,
        confirmButtonColor : '#3085d6',
        cancelButtonColor : '#d33',
        confirmButtonText: 'Si, eliminar'
    }).then( async (result) => {
        if(result.isConfirmed){
            const url = '/medios-comunicacion/API/delitos/eliminar'
            const body = new FormData();
            body.append('id', id);
            const headers = new Headers();
            headers.append("X-Requested-With", "fetch");
    
            const config = {
                method : 'POST',
                headers,
                body
            }
    
            const respuesta = await fetch(url, config);
            const data = await respuesta.json();
            const {resultado} = data;
            // const resultado = data.resultado;
    
            if(resultado == 1){
                Toast.fire({
                    icon : 'success',
                    title : 'Registro eliminado'
                })
    
                formDelitos.reset();
                buscardelitos();
            }else{
                Toast.fire({
                    icon : 'error',
                    title : 'Ocurrió un error'
                })
            }
        }
    })
    
    }

    window.cambiarSituacion = (id,desc, situacion) => {
   
        Swal.fire({
            title : 'Confirmación',
            icon : 'warning',
            text : '¿Esta seguro que desea cambiar situacion?',
            showCancelButton : true,
            confirmButtonColor : '#3085d6',
            cancelButtonColor : '#d33',
            confirmButtonText: 'Si, Cambiar'
        }).then( async (result) => {
            if(result.isConfirmed){
                const url = '/medios-comunicacion/API/delitos/situacion'
                const body = new FormData();
                body.append('id', id);
                body.append('desc', desc);
                body.append('situacion', situacion);
                const headers = new Headers();
                headers.append("X-Requested-With", "fetch");
        
                const config = {
                    method : 'POST',
                    headers,
                    body
                }
        
                const respuesta = await fetch(url, config);
                const data = await respuesta.json();
                const {resultado} = data;
                // const resultado = data.resultado;
        
                if(resultado == 1){
                    Toast.fire({
                        icon : 'success',
                        title : 'Se cambió situación'
                    })
        
                    formDelitos.reset();
                    buscardelitos();
                }else{
                    Toast.fire({
                        icon : 'error',
                        title : 
                        'Ocurrió un error'
                    })
                    formFuentes.reset();
                    buscardelitos();
                }
            }
        })
    }
    
//     ////////Estados
//     window.cambiarestados = (id,desc, estados) => {
       
//         Swal.fire({
//             title : 'Confirmación',
//             icon : 'warning',
//             text : '¿Esta seguro que desea cambiar situacion?',
//             showCancelButton : true,
//             confirmButtonColor : '#3085d6',
//             cancelButtonColor : '#d33',
//             confirmButtonText: 'Si, Cambiar'
//         }).then( async (result) => {
//             if(result.isConfirmed){
//                 const url = '/medios-comunicacion/API/estados/situacion'
//                 const body = new FormData();
//                 body.append('id', id);
//                 body.append('desc', desc);
//                 body.append('estados', situacion);
//                 const headers = new Headers();
//                 headers.append("X-Requested-With", "fetch");
        
//                 const config = {
//                     method : 'POST',
//                     headers,
//                     body
//                 }
        
//                 const respuesta = await fetch(url, config);
//                 const data = await respuesta.json();
//                 const {resultado} = data;
//                 // const resultado = data.resultado;
        
//                 if(resultado == 1){
//                     Toast.fire({
//                         icon : 'success',
//                         title : 'Se cambió Estado'
//                     })
        
//                     formestados.reset();
//                     buscarestados();
//                 }else{
//                     Toast.fire({
//                         icon : 'error',
//                         title : 
//                         'Ocurrió un error'
//                     })
//                     formestados.reset();
//                     buscarFuentes();
//                 }
//             }
//         })
// }


formDelitos.addEventListener('submit', guardardelitos )
btnModificar.addEventListener('click', modificardelitos);
