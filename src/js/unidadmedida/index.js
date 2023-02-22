import { Dropdown } from "bootstrap";
import { validarFormulario, Toast } from "../funciones";
import Datatable from 'datatables.net-bs5';
import { lenguaje } from "../lenguaje";
import Swal from "sweetalert2";

const formMedidas = document.getElementById('formMedidas');
const btnGuardar = document.getElementById('btnGuardar');
const btnModificar = document.getElementById('btnModificar');
const btnBuscar = document.getElementById('btnBuscar');
const btnLimpiar = document.getElementById('btnLimpiar');
const divTabla = document.getElementById('divTabla');
let tablaMedida = new Datatable('#medidasTabla');

btnModificar.parentElement.style.display = 'none';
btnGuardar.disabled = false;
btnLimpiar.disabled = true;
btnModificar.disabled = true;



const guardarmedida = async (evento) => {
    evento.preventDefault();

    let formularioValido = validarFormulario(formMedidas, ['id']);
    if (!formularioValido) {
        Toast.fire({
            icon: 'warning',
            title: 'Debe llenar todos los campos'
        })
        return;
    }



    try {
        //Crear el cuerpo de la consulta
        const url = '/medios-comunicacion/API/medida/guardar'

        const body = new FormData(formMedidas);
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
                formArmas.reset();
               
                break;
            case 2:
                icon = "warning"
                formMedidas.reset();

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


        // buscararmas()

    } catch (error) {
        console.log(error);
    }
}

formMedidas.addEventListener('submit', guardarmedida );
btnModificar.addEventListener('click', modificararmas);