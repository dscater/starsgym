<template>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Clientes</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-3">
                                        <button
                                            v-if="
                                                permisos.includes(
                                                    'clientes.create'
                                                )
                                            "
                                            class="btn btn-outline-primary bg-red btn-flat btn-block"
                                            @click="
                                                abreModal('nuevo');
                                                limpiaCliente();
                                            "
                                        >
                                            <i class="fa fa-plus"></i>
                                            Nuevo
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <b-col lg="10" class="my-1">
                                        <b-form-group
                                            label="Buscar"
                                            label-for="filter-input"
                                            label-cols-sm="3"
                                            label-align-sm="right"
                                            label-size="sm"
                                            class="mb-0"
                                        >
                                            <b-input-group size="sm">
                                                <b-form-input
                                                    id="filter-input"
                                                    v-model="filter"
                                                    type="search"
                                                    placeholder="Buscar"
                                                ></b-form-input>

                                                <b-input-group-append>
                                                    <b-button
                                                        class="bg-red"
                                                        variant="primary"
                                                        :disabled="!filter"
                                                        @click="filter = ''"
                                                        >Borrar</b-button
                                                    >
                                                </b-input-group-append>
                                            </b-input-group>
                                        </b-form-group>
                                    </b-col>
                                    <div class="col-md-12">
                                        <b-overlay
                                            :show="showOverlay"
                                            rounded="sm"
                                        >
                                            <b-table
                                                :fields="fields"
                                                :items="listRegistros"
                                                show-empty
                                                stacked="md"
                                                responsive
                                                :current-page="currentPage"
                                                :per-page="perPage"
                                                @filtered="onFiltered"
                                                empty-text="Sin resultados"
                                                empty-filtered-text="Sin resultados"
                                                :filter="filter"
                                            >
                                                <template #cell(foto)="row">
                                                    <b-avatar
                                                        :src="
                                                            row.item.path_image
                                                        "
                                                        size="3rem"
                                                    ></b-avatar>
                                                </template>

                                                <template #cell(fono)="row">
                                                    {{ row.item.fono }} -
                                                    {{ row.item.fono2 }}
                                                </template>

                                                <template
                                                    #cell(fecha_nacimiento)="row"
                                                >
                                                    {{
                                                        formatoFecha(
                                                            row.item
                                                                .fecha_nacimiento
                                                        )
                                                    }}
                                                </template>

                                                <template
                                                    #cell(fecha_registro)="row"
                                                >
                                                    {{
                                                        formatoFecha(
                                                            row.item
                                                                .fecha_registro
                                                        )
                                                    }}
                                                </template>

                                                <template #cell(accion)="row">
                                                    <div
                                                        class="row justify-content-center flex-column"
                                                    >
                                                        <b-button
                                                            v-if="
                                                                row.item
                                                                    .declaracion_jurada !=
                                                                    null &&
                                                                row.item
                                                                    .declaracion_jurada !=
                                                                    ''
                                                            "
                                                            size="sm"
                                                            pill
                                                            variant="outline-success"
                                                            class="btn-flat mb-1"
                                                            title="Declaración juarada"
                                                            @click="
                                                                descargarArchivo(
                                                                    row.item.id
                                                                )
                                                            "
                                                        >
                                                            <i
                                                                class="fa fa-download"
                                                            ></i>
                                                        </b-button>
                                                        <b-button
                                                            size="sm"
                                                            pill
                                                            variant="outline-warning"
                                                            class="btn-flat mb-1"
                                                            title="Editar registro"
                                                            @click="
                                                                editarRegistro(
                                                                    row.item
                                                                )
                                                            "
                                                        >
                                                            <i
                                                                class="fa fa-edit"
                                                            ></i>
                                                        </b-button>
                                                        <!-- <b-button
                                                            size="sm"
                                                            pill
                                                            variant="outline-danger"
                                                            class="btn-flat"
                                                            title="Eliminar registro"
                                                            @click="
                                                                eliminaCliente(
                                                                    row.item.id,
                                                                    row.item
                                                                        .full_name
                                                                )
                                                            "
                                                        >
                                                            <i
                                                                class="fa fa-trash"
                                                            ></i>
                                                        </b-button> -->
                                                    </div>
                                                </template>
                                            </b-table>
                                        </b-overlay>
                                        <div class="row">
                                            <b-col
                                                sm="6"
                                                md="2"
                                                class="ml-auto my-1"
                                            >
                                                <b-form-select
                                                    align="right"
                                                    id="per-page-select"
                                                    v-model="perPage"
                                                    :options="pageOptions"
                                                    size="sm"
                                                ></b-form-select>
                                            </b-col>
                                            <b-col
                                                sm="6"
                                                md="2"
                                                class="my-1 mr-auto"
                                                v-if="perPage"
                                            >
                                                <b-pagination
                                                    v-model="currentPage"
                                                    :total-rows="totalRows"
                                                    :per-page="perPage"
                                                    align="left"
                                                ></b-pagination>
                                            </b-col>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <Nuevo
            :muestra_modal="muestra_modal"
            :accion="modal_accion"
            :cliente="oCliente"
            @close="muestra_modal = false"
            @envioModal="getClientes"
        ></Nuevo>
    </div>
</template>

<script>
import Nuevo from "./Nuevo.vue";
export default {
    components: {
        Nuevo,
    },
    data() {
        return {
            permisos: localStorage.getItem("permisos"),
            user: JSON.parse(localStorage.getItem("user")),
            search: "",
            listRegistros: [],
            showOverlay: false,
            fields: [
                { key: "full_name", label: "Nombre", sortable: true },
                { key: "full_ci", label: "C.I.", sortable: true },
                {
                    key: "fecha_nacimiento",
                    label: "Fecha de Nacimiento",
                    sortable: true,
                },
                {
                    key: "edad",
                    label: "Edad",
                    sortable: true,
                },
                { key: "genero", label: "Género", sortable: true },
                { key: "dir", label: "Dirección", sortable: true },
                { key: "fono", label: "Teléfonos", sortable: true },
                { key: "correo", label: "Correo", sortable: true },
                { key: "foto", label: "Foto" },
                { key: "sucursal.nombre", label: "Sucursal" },
                {
                    key: "fecha_registro",
                    label: "Fecha de registro",
                    sortable: true,
                },
                { key: "accion", label: "Acción" },
            ],
            loading: true,
            fullscreenLoading: true,
            loadingWindow: Loading.service({
                fullscreen: this.fullscreenLoading,
            }),
            muestra_modal: false,
            modal_accion: "nuevo",
            oCliente: {
                id: 0,
                nombre: "",
                paterno: "",
                materno: "",
                ci: "",
                ci_exp: "",
                fecha_nacimiento: "",
                edad: "",
                genero: "",
                dir: "",
                fono: "",
                fono2: "",
                correo: "",
                foto: null,
                declaracion_jurada: null,
                sucursal_id: "",
            },
            currentPage: 1,
            perPage: 5,
            pageOptions: [
                { value: 5, text: "Mostrar 5 Registros" },
                { value: 10, text: "Mostrar 10 Registros" },
                { value: 25, text: "Mostrar 25 Registros" },
                { value: 50, text: "Mostrar 50 Registros" },
                { value: 100, text: "Mostrar 100 Registros" },
                { value: this.totalRows, text: "Mostrar Todo" },
            ],
            totalRows: 10,
            filter: null,
        };
    },
    mounted() {
        this.loadingWindow.close();
        this.getClientes();
    },
    methods: {
        // Seleccionar Opciones de Tabla
        editarRegistro(item) {
            this.oCliente.id = item.id;
            this.oCliente.nombre = item.nombre ? item.nombre : "";
            this.oCliente.paterno = item.paterno ? item.paterno : "";
            this.oCliente.materno = item.materno ? item.materno : "";
            this.oCliente.ci = item.ci ? item.ci : "";
            this.oCliente.ci_exp = item.ci_exp ? item.ci_exp : "";
            this.oCliente.fecha_nacimiento = item.fecha_nacimiento
                ? item.fecha_nacimiento
                : "";
            this.oCliente.edad = item.edad ? item.edad : "";
            this.oCliente.genero = item.genero ? item.genero : "";
            this.oCliente.dir = item.dir ? item.dir : "";
            this.oCliente.fono = item.fono ? item.fono : "";
            this.oCliente.fono2 = item.fono2 ? item.fono2 : "";
            this.oCliente.correo = item.correo ? item.correo : "";
            this.oCliente.foto = item.foto ? item.foto : "";
            this.oCliente.declaracion_jurada = item.declaracion_jurada
                ? item.declaracion_jurada
                : "";
            this.oCliente.sucursal_id = item.sucursal_id
                ? item.sucursal_id
                : "";

            this.modal_accion = "edit";
            this.muestra_modal = true;
        },

        // Listar Clientes
        getClientes() {
            this.showOverlay = true;
            this.muestra_modal = false;
            let url = "/admin/clientes";
            if (this.pagina != 0) {
                url += "?page=" + this.pagina;
            }
            axios
                .get(url, {
                    params: { per_page: this.per_page },
                })
                .then((res) => {
                    this.showOverlay = false;
                    this.listRegistros = res.data.clientes;
                    this.totalRows = res.data.total;
                });
        },
        eliminaCliente(id, descripcion) {
            Swal.fire({
                title: "¿Quierés eliminar este registro?",
                html: `<strong>${descripcion}</strong>`,
                showCancelButton: true,
                confirmButtonColor: "#05568e",
                confirmButtonText: "Si, eliminar",
                cancelButtonText: "No, cancelar",
                denyButtonText: `No, cancelar`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    axios
                        .post("/admin/clientes/" + id, {
                            _method: "DELETE",
                        })
                        .then((res) => {
                            this.getClientes();
                            this.filter = "";
                            Swal.fire({
                                icon: "success",
                                title: res.data.msj,
                                showConfirmButton: false,
                                timer: 1500,
                            });
                        });
                }
            });
        },
        abreModal(tipo_accion = "nuevo", cliente = null) {
            this.muestra_modal = true;
            this.modal_accion = tipo_accion;
            if (cliente) {
                this.oCliente = cliente;
            }
        },
        onFiltered(filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalRows = filteredItems.length;
            this.currentPage = 1;
        },
        limpiaCliente() {
            this.oCliente.nombre = "";
            this.oCliente.paterno = "";
            this.oCliente.materno = "";
            this.oCliente.ci = "";
            this.oCliente.ci_exp = "";
            this.oCliente.fecha_nacimiento = "";
            this.oCliente.edad = "";
            this.oCliente.genero = "";
            this.oCliente.dir = "";
            this.oCliente.fono = "";
            this.oCliente.fono2 = "";
            this.oCliente.correo = "";
            this.oCliente.foto = null;
            this.oCliente.declaracion_jurada = null;
            if (this.user.tipo != "GERENTE") {
                this.oCliente.sucursal_id = this.user.sucursal_id;
            } else {
                this.oCliente.sucursal_id = "";
            }
        },
        formatoFecha(date) {
            return this.$moment(String(date)).format("DD/MM/YYYY");
        },
        descargarArchivo(id) {
            let config = {
                responseType: "blob",
            };
            axios
                .post(
                    "/admin/clientes/descargar_declaracion/" + id,
                    null,
                    config
                )
                .then((res) => {
                    console.log(res);
                    let nom = res.headers["content-disposition"].split("=");
                    var fileURL = window.URL.createObjectURL(
                        new Blob([res.data])
                    );
                    var fileLink = document.createElement("a");

                    fileLink.href = fileURL;
                    fileLink.setAttribute("download", nom[1]);
                    document.body.appendChild(fileLink);

                    fileLink.click();
                })
                .catch(async (error) => {
                    console.log(error);
                    let responseObj = await error.response.data.text();
                    responseObj = JSON.parse(responseObj);
                    this.enviando = false;
                    if (error.response) {
                    }
                });
        },
    },
};
</script>

<style></style>
