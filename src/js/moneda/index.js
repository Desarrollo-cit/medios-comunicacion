import { Dropdown } from "bootstrap";
import { validarFormulario, Toast } from "../funciones";
import Datatable from 'datatables.net-bs5';
import { lenguaje } from "../lenguaje";
import Swal from "sweetalert2";

const formMoneda = document.getElementById('formMoneda');
const btnGuardar = document.getElementById('btnGuardar');
const btnModificar = document.getElementById('btnModificar');
const divTabla = document.getElementById('divTabla');
let tablaMoneda = new Datatable('#monedaTabla');


btnModificar.parentElement.style.display = 'none';
btnGuardar.disabled = false;
btnModificar.disabled = true;

const guardarMoneda = async (evento) => {
    evento.preventDefault();

    let formularioValido = validarFormulario(formMoneda, ['id']);
    if (!formularioValido) {
        Toast.fire({
            icon: 'warning',
            title: 'Debe llenar todos los campos'
        })
        return;
    }



    try {
        //Crear el cuerpo de la consulta
        const url = '/medios-comunicacion/API/moneda/guardar'

        const body = new FormData(formMoneda);
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
                formMoneda.reset();
               
                break;
            case 2:
                icon = "warning"
                formMoneda.reset();

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


        buscarDesastres()

    } catch (error) {
        console.log(error);
    }
}

const buscarDesastres = async (evento) => {
    evento && evento.preventDefault();

    try {
        const url = '/medios-comunicacion/API/moneda/buscar'
        const headers = new Headers();
        headers.append("X-Requested-With", "fetch");

        const config = {
            method: 'GET',
        }

        const respuesta = await fetch(url, config);
        const data = await respuesta.json();

        // console.log(data);


        tablaMoneda.destroy();
        let contador = 1;
        tablaMoneda = new Datatable('#monedaTabla', {
            language: lenguaje,
            data: data,
            columns: [
                {
                    data: 'id',
                    render: () => {
                        return contador++;
                    }
                },
                { data: 'desc' },
                { 
                    data : 'cambio',
                    render : (data, type, row, meta) => {
                        return `Q. ${data}`
                    } 
                },

                {
                    data: 'id',
                    'render': (data, type, row, meta) => {
                        return `<button class="btn btn-warning" onclick="asignarValores('${row.id}', '${row.desc}','${row.cambio}' )">Modificar</button>`
                    }
                },
                {
                    data: 'id',
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

const modificarDesastre = async (evento) => {
    evento.preventDefault();

    let formularioValido = validarFormulario(formMoneda);

    if (!formularioValido) {
        Toast.fire({
            icon: 'warning',
            title: 'Debe llenar todos los campos'
        })
        return;
    }

    try {
        //Crear el cuerpo de la consulta
        const url = '/medios-comunicacion/API/moneda/modificar'
        const body = new FormData(formMoneda);
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
        const { resultado } = data;
        // const resultado = data.resultado;

        if (resultado == 1) {
            Toast.fire({
                icon: 'success',
                title: 'Registro modificado'
            })
            buscarDesastres();
            formMoneda.reset();
            btnModificar.parentElement.style.display = 'none';
            btnGuardar.parentElement.style.display = '';
            btnGuardar.disabled = false;
            btnModificar.disabled = true;

            divTabla.style.display = ''
        } else {
            Toast.fire({
                icon: 'error',
                title: 'Ocurrió un error'
            })
        }

    } catch (error) {
        console.log(error);
    }
}

buscarDesastres();

window.asignarValores = (id, desc, cambio) => {
    formMoneda.id.value = id;
    formMoneda.desc.value = desc;
    formMoneda.cambio.value = cambio;
    btnModificar.parentElement.style.display = '';
    btnGuardar.parentElement.style.display = 'none';
    btnGuardar.disabled = true;
    btnModificar.disabled = false;

    divTabla.style.display = 'none'
}

window.eliminarRegistro = (id) => {
    Swal.fire({
        title: 'Confirmación',
        icon: 'warning',
        text: '¿Esta seguro que desea eliminar este registro?',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar'
    }).then(async (result) => {
        if (result.isConfirmed) {
            const url = '/medios-comunicacion/API/moneda/eliminar'
            const body = new FormData();
            body.append('id', id);
            const headers = new Headers();
            headers.append("X-Requested-With", "fetch");

            const config = {
                method: 'POST',
                headers,
                body
            }

            const respuesta = await fetch(url, config);
            const data = await respuesta.json();

            const { resultado } = data;

            // const resultado = data.resultado;

            if (resultado == 1) {
                Toast.fire({
                    icon: 'success',
                    title: 'Registro eliminado'
                })

                formMoneda.reset();
                buscarDesastres();
            } else {
                Toast.fire({
                    icon: 'error',
                    title: 'Ocurrió un error'
                })
            }
        }
    })
}


function NumText(string){//solo letras y numeros
    var out = '';
    //Se añaden las letras validas
    var filtro = 'aáéíóúabcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZÁÉÍÓÚ ';//Caracteres validos
  
    for (var i=0; i<string.length; i++)
       if (filtro.indexOf(string.charAt(i)) != -1) 
       out += string.charAt(i);
    return out;
  }

formMoneda.desc.addEventListener('keyup', e=>{
    let out = NumText(e.target.value)
    e.target.value = out 

})



function numeros(){
   let cambio = document.getElementById('cambio').value
 //  alert(cambio);
if (cambio<0){
    //alert(cambio)
    document.getElementById('cambio').value=""
}

}





formMoneda.cambio.addEventListener('keyup', numeros);
formMoneda.addEventListener('submit', guardarMoneda);
btnModificar.addEventListener('click', modificarDesastre);

