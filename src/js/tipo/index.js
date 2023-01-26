import { Dropdown } from "bootstrap";
import { validarFormulario, Toast } from "../funciones";
import Datatable from 'datatables.net-bs5';
import { lenguaje } from "../lenguaje";
import Swal from "sweetalert2";

const formTipos = document.getElementById('formTipos');
const btnGuardar = document.getElementById('btnGuardar');
const btnModificar = document.getElementById('btnModificar');
const divTabla = document.getElementById('divTabla');
let tablaTipos = new Datatable('#tiposTabla');

btnModificar.parentElement.style.display = 'none';
btnGuardar.disabled = false;
btnModificar.disabled = true;

const guardarTipo = async (evento) => {
    evento.preventDefault();
    
    let formularioValido = validarFormulario(formTipos, ['id']);

    if(!formularioValido){ 
        Toast.fire({
            icon : 'warning',
            title : 'Debe llenar todos los campos'
        })
        return;
    }

    try {
        //Crear el cuerpo de la consulta
        const url = '/medios-comunicacion/API/tipo/guardar'
        const body = new FormData(formTipos);
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

        const { mensaje, codigo, detalle } = data;
        console.log(data)
        // const resultado = data.resultado;
        let icon = "";
        switch (codigo) {
            case 1:
                icon = "success"
                formTipos.reset();
                buscarTipo();
                break;
            case 2:
                icon = "warning"
                formTipos.reset();

                break;
            case 3:
                icon = "error"

                break;
            case 4:
                icon = "error"
                console.log(detalle)
                buscarTipo();

                break;

            default:
                break;
        }

        Toast.fire({
            icon: icon,
            title: mensaje,
        })


        //buscarProducto();

    } catch (error) {
        console.log(error);
    }
}

const buscarTipo = async (evento) => {
    evento && evento.preventDefault();

    try {
        const url = '/medios-comunicacion/API/tipo/buscar'
        const headers = new Headers();
        headers.append("X-Requested-With", "fetch");

        const config = {
            method : 'GET',
        }

        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        // console.log(data);


        
        tablaTipos.destroy();
        let contador = 1;
        tablaTipos = new Datatable('#tiposTabla', {
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
            ]
        })

    } catch (error) {
        console.log(error);
        
        
    }
}

const modificarTipo = async (evento) => {
    evento.preventDefault();
    
    let formularioValido = validarFormulario(formTipos);

    if(!formularioValido){ 
        Toast.fire({
            icon : 'warning',
            title : 'Debe llenar todos los campos'
        })
        return;
    }

    try {
        //Crear el cuerpo de la consulta
        const url = '/medios-comunicacion/API/tipo/modificar'
        const body = new FormData(formTipos);
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
            buscarTipo();
            formTipos.reset();
            btnModificar.parentElement.style.display = 'none';
            btnGuardar.parentElement.style.display = '';
            btnGuardar.disabled = false;
            btnModificar.disabled = true;
        
            divTabla.style.display = ''
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

buscarTipo();

window.asignarValores = (id, desc) => {
    formTipos.id.value = id;
    formTipos.desc.value = desc;
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
            const url = '/medios-comunicacion/API/tipo/eliminar'
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
            console.log(data);
            // const resultado = data.resultado;
    
            if(resultado == 1){
                Toast.fire({
                    icon : 'success',
                    title : 'Registro eliminado'
                })
    
                formTipos.reset();
                buscarTipo();
            }else{
                Toast.fire({
                    icon : 'error',
                    title : 'Ocurrió un error'
                })
            }
        }
    })
}

function NumText(string){//solo letras y numeros
    var out = '';
    //Se añaden las letras validas
    var filtro = 'abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ  ';//Caracteres validos
  
    for (var i=0; i<string.length; i++)
       if (filtro.indexOf(string.charAt(i)) != -1) 
       out += string.charAt(i);
    return out;
  }

formTipos.desc.addEventListener('keyup', e=>{
    let out = NumText(e.target.value)
    e.target.value = out 

})

formTipos.addEventListener('submit', guardarTipo )
btnModificar.addEventListener('click', modificarTipo);

