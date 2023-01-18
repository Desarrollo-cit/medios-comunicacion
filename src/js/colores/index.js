import { Dropdown } from "bootstrap";
import { validarFormulario, Toast } from "../funciones";
import Datatable from 'datatables.net-bs5';
import { lenguaje } from "../lenguaje";
import Swal from "sweetalert2";

const formColores = document.getElementById('formColores');
const btnGuardar = document.getElementById('btnGuardar');
const btnModificar = document.getElementById('btnModificar');
const divTabla = document.getElementById('divTabla');
let tablaColores = new Datatable('#coloresTabla');

btnModificar.parentElement.style.display = 'none';
btnGuardar.disabled = false;
btnModificar.disabled = true;

const guardarColores = async (evento) => {
    evento.preventDefault();
    
    let formularioValido = validarFormulario(formColores, ['id']);

    if(!formularioValido || formColores.descripcion.value == '' ){ 
        Toast.fire({
            icon : 'warning',
            title : 'Debe llenar todos los campos'
        })
        return;
    }


    try {
        //Crear el cuerpo de la consulta
        const url = '/medios-comunicacion/API/colores/guardar'
        const body = new FormData(formColores);
        body.delete('id');
        const headers = new Headers();
        headers.append("X-Requested-With", "fetch");

        const config = {
            method : 'POST',
            headers,
            body
        }

        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log(data);
        const {resultado} = data;
        // const resultado = data.resultado;

        if(resultado == 1){
            Toast.fire({
                icon : 'success',
                title : 'Registro guardado'
            })

            formColores.reset();
            buscarColores();
        }else{
            Toast.fire({
                icon : 'error',
                title : 'Ocurrió un error'
            })
           
        }

    } catch (error) {
        console.log(error);
    }
}

const buscarColores = async (evento) => {
    evento && evento.preventDefault();

    try {
        const url = '/medios-comunicacion/API/colores/buscar'
        const headers = new Headers();
        headers.append("X-requested-With", "fetch");

        const config = {
            method : 'GET',
        }

        const respuesta = await fetch(url, config);
        const data = await respuesta.json();

        console.log(data);

        
        tablaColores.destroy();
        let contador = 1;
        tablaColores = new Datatable('#coloresTabla', {
            language : lenguaje,
            data : data,
            columns : [
                { 
                    data : 'id',
                    render : () => {      
                        return contador++;
                    }
                },
                { data : 'descripcion'},
                { 
                    data : 'cantidad', },

                    { 
                        data : 'color',
                        'render': (data, type, row, meta) => {
                            return `<input type='color' value='${row.color}' disabled></button>`
                        } 
                    },
                   
                        { 
                            data : 'nivel', },
                            { 
                                data : 'desc', },
                { 
                    data : 'id',
                    'render': (data, type, row, meta) => {
                        return `<button class="btn btn-warning" onclick="asignarValores('${row.id}', '${row.descripcion}', '${row.cantidad}', '${row.color}', '${row.nivel}', '${row.topico}')">Modificar</button>`
                    } 
                },
                { 
                    data : 'id',
                    'render': (data, type, row, meta) => {
                        return `<button class="btn btn-danger" onclick="eliminarRegistro('${row.id}')">Eliminar</button>`
                    } 
                },
            ]
        })

    } catch (error) {
        console.log(error);
    }
}

const modificarColores = async (evento) => {
    evento.preventDefault();
    
    let formularioValido = validarFormulario(formColores);

    if(!formularioValido || formColores.descripcion.value == '' ){ 
        Toast.fire({
            icon : 'warning',
            title : 'Debe llenar todos los campos'
        })
        return;
    }

    try {
        //Crear el cuerpo de la consulta
        const url = '/medios-comunicacion/API/colores/modificar'
        const body = new FormData(formColores);
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
                title : 'Registro modificado'
            })
            buscarColores();
            formColores.reset();
            btnModificar.parentElement.style.display = 'none';
            btnGuardar.parentElement.style.display = '';
            btnGuardar.disabled = false;
            btnModificar.disabled = true;
        
            divTabla.style.display = ''
        }else{
            // console.log(data);
            Toast.fire({
                icon : 'error',
                title : 'Ocurrió un error'
            })
        }

    } catch (error) {
        console.log(error);
    }
}

buscarColores();

window.asignarValores = (id, descripcion, cantidad, color,nivel,topico) => {
    formColores.id.value = id;
    formColores.descripcion.value = descripcion;
    formColores.cantidad.value = cantidad;
    formColores.color.value = color;
    formColores.nivel.value = nivel;
    formColores.topico.value = topico;
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
            const url = '/medios-comunicacion/API/colores/eliminar'
            const body = new FormData();
            body.append('id', id);
            const headers = new Headers();
            headers.append("X-requested-With", "fetch");
    
            const config = {
                method : 'POST',
                headers,
                body
            }
    
            const respuesta = await fetch(url, config);
            const data = await respuesta.json();
            const {resultado} = data;
            // const resultado = data.resultado;
            
            console.log(data);
    
            if(resultado == 1){
                Toast.fire({
                    icon : 'success',
                    title : 'Registro eliminado'
                })
    
                formColores.reset();
                buscarColores();
            }else{
                Toast.fire({
                    icon : 'error',
                    title : 'Ocurrió un error'
                })
            }
        }
    })
}

formColores.addEventListener('submit', guardarColores)
btnModificar.addEventListener('click', modificarColores);

