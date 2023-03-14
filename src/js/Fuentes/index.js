import { Dropdown } from "bootstrap";
import { validarFormulario, Toast } from "../funciones";
import Datatable from 'datatables.net-bs5';
import { lenguaje } from "../lenguaje";
import Swal from "sweetalert2";

const formFuentes = document.getElementById('formFuentes');
const btnGuardar = document.getElementById('btnGuardar');
const btnModificar = document.getElementById('btnModificar');
const divTabla = document.getElementById('divTabla');
let tablaProductos = new Datatable('#FuentesTabla');

btnModificar.parentElement.style.display = 'none';

btnGuardar.disabled = false;
btnModificar.disabled = true;
btnModificar.disabled = true;



const guardarFuentes = async (evento) => {
    evento.preventDefault();

    let formularioValido = validarFormulario(formFuentes, ['id']);
    if (!formularioValido) {
        Toast.fire({
            icon: 'warning',
            title: 'Debe llenar todos los campos'
        })
        return;
    }



    try {
        //Crear el cuerpo de la consulta
        const url = '/medios-comunicacion/API/Fuentes/guardar'

        const body = new FormData(formFuentes);
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
                formFuentes.reset();
               
                break;
            case 2:
                icon = "warning"
                formFuentes.reset();

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


        buscarFuentes()

    } catch (error) {
        console.log(error);
    }
}

// const buscarFuentes = async (evento) => {
//     evento && evento.preventDefault();

//     try {
//         const url = '/medios-comunicacion/API/Fuentes/buscar'
//         const headers = new Headers();
//         headers.append("X-Requested-With", "fetch");

//         const config = {
//             method : 'GET',
//         }

//         const respuesta = await fetch(url, config);
//         const data = await respuesta.json();

//         // console.log(data);

        
//         tablaFuetes.destroy();
//         let contador = 1;
//         tablaProductos = new Datatable('#fuentesTabla', {
//             language : lenguaje,
//             data : data,
//             columns : [
//                 { 
//                     data : 'id',
//                     render : () => {      
//                         return contador++;
//                     }
//                 },
//                 { data : 'desc'},
                
//                 { 
//                     data : 'id',
//                     'render': (data, type, row, meta) => {
//                         return `<button class="btn btn-warning" onclick="asignarValores('${row.id}', '${row.desc}')">Modificar</button>`
//                     } 
//                 },
//                 { 
//                     data : 'id',
//                     'render': (data, type, row, meta) => {
//                         return `<button class="btn btn-danger" onclick="eliminarRegistro('${row.id}')">Eliminar</button>`
//                     } 
//                 },
//             ]
//         })

//     } catch (error) {
//         console.log(error);
//     }
// }




const buscarFuentes = async (evento) => {
    evento && evento.preventDefault();

    try {
        const url = '/medios-comunicacion/API/Fuentes/buscar'
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
        tablaProductos = new Datatable('#FuentesTabla', {
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

    } catch(error) {
        console.log(error);
    }
}



const modificarFuentes = async (e) => {
    e.preventDefault();

    let formularioValido = validarFormulario(formFuentes);
    if (!formularioValido) {
        Toast.fire({
            icon: 'warning',
            title: 'Debe llenar todos los campos'
        })
        return;
    }



    try {
        //Crear el cuerpo de la consulta
        const url = '/medios-comunicacion/API/Fuentes/modificar'

        const body = new FormData(formFuentes);
        
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
                formFuentes.reset();
               
                break;
            case 2:
                icon = "warning"
                formFuentes.reset();

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


        buscarFuentes()
        formFuentes.reset();
            btnModificar.parentElement.style.display = 'none';
            btnGuardar.parentElement.style.display = '';
            btnGuardar.disabled = false;
            btnModificar.disabled = true;
        
            divTabla.style.display = ''

    } catch (error) {
        console.log(error);
    }
}



buscarFuentes();

window.asignarValores = (id, desc) => {
    formFuentes.id.value = id;
    formFuentes.desc.value = desc;
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
            const url = '/medios-comunicacion/API/Fuentes/eliminar'
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
    
                formFuentes.reset();
                buscarFuentes();
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
            const url = '/medios-comunicacion/API/Fuentes/situacion'
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
    
                formFuentes.reset();
                buscarFuentes();
            }else{
                Toast.fire({
                    icon : 'error',
                    title : 
                    'Ocurrió un error'
                })
                formFuentes.reset();
                buscarFuentes();
            }
        }
    })
}

////////Estados
window.cambiarestados = (id,desc, estados) => {
   
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
            const url = '/medios-comunicacion/API/estados/situacion'
            const body = new FormData();
            body.append('id', id);
            body.append('desc', desc);
            body.append('estados', situacion);
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
                    title : 'Se cambió Estado'
                })
    
                formestados.reset();
                buscarestados();
            }else{
                Toast.fire({
                    icon : 'error',
                    title : 
                    'Ocurrió un error'
                })
                formestados.reset();
                buscarFuentes();
            }
        }
    })
}





formFuentes.addEventListener('submit', guardarFuentes )
btnModificar.addEventListener('click', modificarFuentes)