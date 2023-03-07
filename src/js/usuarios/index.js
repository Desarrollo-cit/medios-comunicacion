import { Dropdown } from "bootstrap";
import { validarFormulario, Toast } from "../funciones";
import Datatable from 'datatables.net-bs5';
import { lenguaje } from "../lenguaje";
import Swal from "sweetalert2";

const formUsuarios = document.getElementById('formUsuario');
const btnGuardar = document.getElementById('btnGuardar');
const btnModificar = document.getElementById('btnModificar');
const btnSituacion = document.getElementById('btnSituacion');
const btnCancelar = document.getElementById('btnCancelar');
const divTabla = document.getElementById('divTabla');
let tablaUsuarios = new Datatable('#usuariosTabla');

btnModificar.parentElement.style.display = 'none';
btnSituacion.parentElement.style.display = 'none';
// btnCancelar.parentElement.style.display = 'none';
btnGuardar.disabled = false;
btnModificar.disabled = true;
btnSituacion.disabled = true;
// btnCancelar.disabled = true;


const guardarusuarios = async (evento) => {
    evento.preventDefault();

    let formularioValido = validarFormulario(formUsuarios, ['id']);
    if (!formularioValido) {
        Toast.fire({
            icon: 'warning',
            title: 'Debe llenar todos los campos'
        })
        return;
    }



    try {
        //Crear el cuerpo de la consulta
        const url = '/medios-comunicacion/API/usuarios/guardar'

        const body = new FormData(formUsuarios);
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
        // console.log(data);
        
        const { mensaje, codigo, detalle } = data;
        // const resultado = data.resultado;
        let icon = "";
        switch (codigo) {
            case 1:
                icon = "success"
                formUsuarios.reset();
               
                break;
            case 2:
                icon = "warning"
                formUsuarios.reset();

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


        buscarusuarios()

    } catch (error) {
        console.log(error);
    }
}





const buscarusuarios = async (evento) => {
    evento && evento.preventDefault();

    try {
        const url = '/medios-comunicacion/API/usuarios/buscar'
        const headers = new Headers();
        headers.append("X-Requested-With", "fetch");

        const config = {
            method : 'GET',
            headers
        }

        const respuesta = await fetch(url, config);
        const data = await respuesta.json();

        // console.log(data);

        
        tablaUsuarios.destroy();
        let contador = 1;
        tablaUsuarios = new Datatable('#usuariosTabla', {
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
                // { data : 'situacion'},
                
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
                        if(row.situacion == 1){
                        return `<button class="btn btn-secondary" onclick="cambiarSituacion('${row.id}',' ${row.situacion}',' ${row.desc}')">Desactivar</button>`
                    }else{
                        return `<button class="btn btn-success" onclick="cambiarSituacion('${row.id}', '${row.situacion}',' ${row.desc}')">Activar</button>`
                    }
                    } 
                },
            ]
        })

    } catch (error) {
        console.log(error);
    }
}



const modificarusuarios = async (evento) => {
    evento.preventDefault();

    let formularioValido = validarFormulario(formUsuarios);
    if (!formularioValido) {
        Toast.fire({
            icon: 'warning',
            title: 'Debe llenar todos los campos'
        })
        return;
    }



    try {
        //Crear el cuerpo de la consulta
        const url = '/medios-comunicacion/API/usuarios/modificar'

        const body = new FormData(formUsuarios);
        
        const headers = new Headers();
        headers.append("X-Requested-With", "fetch");

        const config = {
            method: 'POST',
            headers,
            body
        }

        const respuesta = await fetch(url, config);
        const data = await respuesta.text();
        // console.log(data);
        const { mensaje, codigo, detalle } = data;
        // const resultado = data.resultado;
        let icon = "";
        switch (codigo) {
            case 1:
                icon = "success"
                formUsuarios.reset();
               
                break;
            case 2:
                icon = "warning"
                formUsuarios.reset();

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


        buscarusuarios()
        btnModificar.parentElement.style.display = 'none';
        btnCancelar.parentElement.style.display = 'none';
        btnGuardar.parentElement.style.display = '';
        btnGuardar.disabled = false;
        btnCancelar.disabled = true;
        btnModificar.disabled = true;
        formUsuarios.reset();
        
        
            divTabla.style.display = ''

    } catch (error) {
        console.log(error);
    }
}



buscarusuarios();

window.asignarValores = (id, desc) => {
    formUsuarios.id.value = id;
    formUsuarios.desc.value = desc;
    btnModificar.parentElement.style.display = '';
    btnGuardar.parentElement.style.display = 'none';
    btnCancelar.parentElement.style.display = '';
    btnGuardar.disabled = true;
    btnModificar.disabled = false;
    btnCancelar.disabled = false;

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
            const url = '/medios-comunicacion/API/usuarios/eliminar'
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
    
                formUsuarios.reset();
                buscarusuarios();
            }else{
                Toast.fire({
                    icon : 'error',
                    title : 'Ocurrió un error'
                })
            }
        }
    })
}
window.cambiarSituacion = (id, situacion,desc) => {
   
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
            const url = '/medios-comunicacion/API/usuarios/cambiarSituacion'
            const body = new FormData();
            body.append('id', id);
            body.append('situacion', situacion);
            body.append('desc', desc);
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
    
                formUsuarios.reset();
                buscarusuarios();
            }else{
                Toast.fire({
                    icon : 'error',
                    title : 'Ocurrió un error'
                })
            }
        }
    })
}


formUsuarios.addEventListener('submit', guardarusuarios)
btnModificar.addEventListener('click', modificarusuarios);