import { Dropdown } from "bootstrap";
import { validarFormulario, Toast } from "../funciones";
import Datatable from 'datatables.net-bs5';
import { lenguaje } from "../lenguaje";
import Swal from "sweetalert2";

const formActividad_vinculada = document.getElementById('formActividad_vinculada');
const btnGuardar = document.getElementById('btnGuardar');
const btnModificar = document.getElementById('btnModificar');
const btnCancelar = document.getElementById('btnCancelar')
const divTabla = document.getElementById('divTabla');
let tablaProductos = new Datatable('#Actividad_vinculadaTabla');

btnModificar.parentElement.style.display = 'none';
btnCancelar.parentElement.style.display = 'none';
btnCancelar.disabled = true;
btnGuardar.disabled = false;
btnModificar.disabled = true;



const guardarActividad_vinculada = async (evento) => {
    evento.preventDefault();

    let formularioValido = validarFormulario(formActividad_vinculada, ['id']);
    if (!formularioValido) {
        Toast.fire({
            icon: 'warning',
            title: 'Debe llenar todos los campos'
        })
        return;
    }



    try {
        //Crear el cuerpo de la consulta
        const url = '/medios-comunicacion/API/Actividad_vinculada/guardar'

        const body = new FormData(formActividad_vinculada);
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
                formActividad_vinculada.reset();
               
                break;
            case 2:
                icon = "warning"
                formActividad_vinculada.reset();

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


        buscarActividad_vinculada()

    } catch (error) {
        console.log(error);
    }
}





const buscarActividad_vinculada = async (evento) => {
    evento && evento.preventDefault();

    try {
        const url = '/medios-comunicacion/API/Actividad_vinculada/buscar'
        const headers = new Headers();
        headers.append("X-Requested-With", "fetch");

        const config = {
            method : 'GET', headers
        }

        const respuesta = await fetch(url, config);
        const data = await respuesta.json();

        console.log(data);

        
        tablaProductos.destroy();
        let contador = 1;
        tablaProductos = new Datatable('#Actividad_vinculada', {
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
                // { data: 'situacion'},
                
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
                        return `<button class="btn btn-secondary" onclick="cambiarSituacion('${row.id}',' ${row.situacion}',' ${row.desc}')">DESACTIVAR</button>`
                    }if (row.situacion == 2){
                        return `<button class="btn btn-success" onclick="cambiarSituacion('${row.id}',' ${row.situacion}',' ${row.desc}')">ACTIVAR</button>`

                    }
                    } 
                },
            ]
        })

    } catch (error) {
        console.log(error);
    }
}



const modificarActividad_vinculada = async (evento) => {
    evento.preventDefault();

    let formularioValido = validarFormulario(formActividad_vinculada);
    if (!formularioValido) {
        Toast.fire({
            icon: 'warning',
            title: 'Debe llenar todos los campos'
        })
        return;
    }



    try {
        //Crear el cuerpo de la consulta
        const url = '/medios-comunicacion/API/Actividad_vinculada/modificar'

        const body = new FormData(formActividad_vinculada);
        
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
                formActividad_vinculada.reset();
               
                break;
            case 2:
                icon = "warning"
                formActividad_vinculada.reset();

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


        buscarActividad_vinculada()
        formActividad_vinculada.reset();
            btnModificar.parentElement.style.display = 'none';
            btnGuardar.parentElement.style.display = '';
            btnGuardar.disabled = false;
            btnModificar.disabled = true;
            divTabla.style.display = ''

    } catch (error) {
        console.log(error);
    }
}





window.asignarValores = (id, desc) => {
    formActividad_vinculada.id.value = id;
    formActividad_vinculada.desc.value = desc;
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
            const url = '/medios-comunicacion/API/Actividad_vinculada/eliminar'
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
    
                formActividad_vinculada.reset();
                buscarActividad_vinculada();
            }else{
                Toast.fire({
                    icon : 'error',
                    title : 'Ocurrió un error'
                })
            }
        }
        btnCancelar.parentElement.style.display = '';
        btnCancelar.disabled = true;
    })
}
window.cambiarSituacion = (id, situacion, desc) => {
   
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
            const url = '/medios-comunicacion/API/Actividad_vinculada/cambiarSituacion'
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
            // cosole.log(data)
            const {resultado} = data;
            // const resultado = data.resultado;
          
            if(resultado == 1){
                
                Toast.fire({
                    icon : 'success',
                    title : 'Se cambió situación'
                                       
                })
                formActividad_vinculada.reset();
                
                buscarActividad_vinculada();
            }else{
                Toast.fire({
                    icon : 'error',
                    title : 'Ocurrió un error'
                })
            }
            }
    })
}


buscarActividad_vinculada();
formActividad_vinculada.addEventListener('submit', guardarActividad_vinculada )
btnModificar.addEventListener('click', modificarActividad_vinculada);