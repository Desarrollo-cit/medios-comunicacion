import { Dropdown, Modal } from "bootstrap";
import { validarFormulario, Toast } from "../funciones";
import Datatable from 'datatables.net-bs5';
import { lenguaje } from "../lenguaje";
import Swal from "sweetalert2";

const formColores = document.getElementById('formColores');
const btnGuardar = document.getElementById('btnGuardar');
const btnModificar = document.getElementById('btnModificar');
const btnCerrar = document.getElementById('btnCerrar');
const divTabla = document.getElementById('divTabla');
const tablaColores = document.getElementById('coloresTabla')
const modal = new Modal(document.getElementById('modalColores'))


btnModificar.parentElement.style.display = 'none';
btnGuardar.disabled = false;
btnModificar.disabled = true;
// tablaColores.parentElement.style.display='none';




const buscarColores = async (evento) => {
    evento && evento.preventDefault();



    var topico = formColores.topico2.value





    //    var topico = evento ?  evento.target.value : '';






    try {
        // alert(topico)
        const url = `/medios-comunicacion/API/colores/buscar?topico=${topico}`
        const headers = new Headers();
        headers.append("X-Requested-With", "fetch");

        const config = {
            method: 'GET',
        }

        const respuesta = await fetch(url, config);
        let data = await respuesta.json();

        console.log(data);
        data = data ? data : [];

        let tablaColores = new Datatable('#coloresTabla');
        tablaColores.destroy();
        let contador = 1;
        new Datatable('#coloresTabla', {
            language: lenguaje,
            data: data,
            columns: [
                {
                    data: 'id',
                    render: () => {
                        return contador++;
                    }
                },
                {
                    data: 'descripcion',
                },
                {
                    data: 'cantidad',
                },

                {
                    data: 'color',
                    'render': (data, type, row, meta) => {
                        return `<input type='color' value='${data}' disabled />`
                    }
                },

                {
                    data: 'nivel',
                },
                {
                    data: 'desc',
                },
                {
                    data: 'id',
                    'render': (data, type, row, meta) => {
                        // return '1'
                        return `<button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalColores" onclick="asignarValores('${row.id}', '${row.descripcion}', '${row.cantidad}', '${row.color}', '${row.nivel}', '${row.topico}')">Modificar</button>`
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

    if (!formularioValido || formColores.descripcion.value == '') {
        Toast.fire({
            icon: 'warning',
            title: 'Debe llenar todos los campos'
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
            method: 'POST',
            headers,
            body
        }

        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        console.log(data
            
            
            );
        // const {resultado} = data;
        // const resultado = data.resultado;

        const { mensaje, codigo, detalle } = data;
        // const resultado = data.resultado;
        let icon = "";
        switch (codigo) {
            case 1:
                icon = "success"
                modal.hide();


                break;
            case 2:
                icon = "warning"

                break;
            case 3:
                icon = "error"

                break;
            case 4:
                icon = "error"
                console.log(detalle)

                break;

                case 6:
                    icon = "warning"
                    console.log(detalle)
    
                    break;

            default:
                break;
        }

        Toast.fire({
            icon: icon,
            title: mensaje,

        })





        buscarColores();





    } catch (error) {
        console.log(error);
    }
}




// buscarColores();

window.asignarValores = (id, descripcion, cantidad, color, nivel, topico) => {
    formColores.id.value = id;
    formColores.descripcion.value = descripcion;
    formColores.cantidad.value = cantidad;
    formColores.color.value = color;
    formColores.nivel.value = nivel;
    formColores.nombre_topico.value = topico;
    formColores.topico.value = topico;
    btnModificar.parentElement.style.display = '';
    btnGuardar.parentElement.style.display = 'none';
    btnGuardar.disabled = true;
    btnModificar.disabled = false;

}




btnModificar.addEventListener('click', modificarColores);

document.getElementById('topico2').addEventListener('change', buscarColores)





