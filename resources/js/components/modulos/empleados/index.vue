<template>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Empleados</h1>
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
                                                    'empleados.create'
                                                )
                                            "
                                            class="btn btn-outline-primary bg-red btn-flat btn-block"
                                            @click="
                                                abreModal('nuevo');
                                                limpiaEmpleado();
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

                                                <template
                                                    #cell(fecha_inicio)="row"
                                                >
                                                    {{
                                                        formatoFecha(
                                                            row.item
                                                                .fecha_inicio
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
                                                            ></i> </b-button
                                                        >
                                                        <b-button
                                                            size="sm"
                                                            pill
                                                            variant="outline-danger"
                                                            class="btn-flat"
                                                            title="Eliminar registro"
                                                            @click="
                                                                eliminaEmpleado(
                                                                    row.item.id,
                                                                    row.item
                                                                        .full_name
                                                                )
                                                            "
                                                        >
                                                            <i
                                                                class="fa fa-trash"
                                                            ></i>
                                                        </b-button>
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
            :empleado="oEmpleado"
            @close="muestra_modal = false"
            @envioModal="getEmpleados"
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
            search: "",
            listRegistros: [],
            showOverlay: false,
            fields: [
                { key: "full_name", label: "Nombre", sortable: true },
                {
                    key: "full_ci",
                    label: "C.I.",
                    sortable: true,
                },
                { key: "dir", label: "Dirección", sortable: true },
                { key: "fono", label: "Teléfono", sortable: true },
                {
                    key: "fono_referencia",
                    label: "Teléfono de refencia",
                    sortable: true,
                },
                { key: "correo", label: "E-mail", sortable: true },
                {
                    key: "fecha_inicio",
                    label: "Fecha Inicio de Contrato",
                    sortable: true,
                },
                {
                    key: "cargo",
                    label: "Cargo",
                    sortable: true,
                },
                {
                    key: "salario",
                    label: "Salario",
                    sortable: true,
                },
                {
                    key: "horario",
                    label: "Horario",
                    sortable: true,
                },
                {
                    key: "sucursal.nombre",
                    label: "Sucursal",
                    sortable: true,
                },
                {
                    key: "foto",
                    label: "Foto",
                    sortable: true,
                },
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
            oEmpleado: {
                id: 0,
                nombre: "",
                paterno: "",
                materno: "",
                ci: "",
                ci_exp: "",
                dir: "",
                fono: "",
                fono_referencia: "",
                correo: "",
                fecha_inicio: "",
                cargo: "",
                salario: "",
                horario: "",
                foto: null,
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
        this.getEmpleados();
    },
    methods: {
        // Seleccionar Opciones de Tabla
        editarRegistro(item) {
            this.oEmpleado.id = item.id;
            this.oEmpleado.nombre = item.nombre ? item.nombre : "";
            this.oEmpleado.paterno = item.paterno ? item.paterno : "";
            this.oEmpleado.materno = item.materno ? item.materno : "";
            this.oEmpleado.ci = item.ci ? item.ci : "";
            this.oEmpleado.ci_exp = item.ci_exp ? item.ci_exp : "";
            this.oEmpleado.dir = item.dir ? item.dir : "";
            this.oEmpleado.fono = item.fono ? item.fono : "";
            this.oEmpleado.fono_referencia = item.fono_referencia ? item.fono_referencia : "";
            this.oEmpleado.correo = item.correo ? item.correo : "";
            this.oEmpleado.fecha_inicio = item.fecha_inicio ? item.fecha_inicio : "";
            this.oEmpleado.cargo = item.cargo ? item.cargo : "";
            this.oEmpleado.salario = item.salario ? item.salario : "";
            this.oEmpleado.horario = item.horario ? item.horario : "";
            this.oEmpleado.foto = item.foto ? item.foto : "";
            this.oEmpleado.sucursal_id = item.sucursal_id ? item.sucursal_id : "";
    
            this.modal_accion = "edit";
            this.muestra_modal = true;
        },

        // Listar Empleados
        getEmpleados() {
            this.showOverlay = true;
            this.muestra_modal = false;
            let url = "/admin/empleados";
            if (this.pagina != 0) {
                url += "?page=" + this.pagina;
            }
            axios
                .get(url, {
                    params: { per_page: this.per_page },
                })
                .then((res) => {
                    this.showOverlay = false;
                    this.listRegistros = res.data.empleados;
                    this.totalRows = res.data.total;
                });
        },
        eliminaEmpleado(id, descripcion) {
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
                        .post("/admin/empleados/" + id, {
                            _method: "DELETE",
                        })
                        .then((res) => {
                            this.getEmpleados();
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
        abreModal(tipo_accion = "nuevo", empleado = null) {
            this.muestra_modal = true;
            this.modal_accion = tipo_accion;
            if (empleado) {
                this.oEmpleado = empleado;
            }
        },
        onFiltered(filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalRows = filteredItems.length;
            this.currentPage = 1;
        },
        limpiaEmpleado() {
            this.oEmpleado.nombre = "";
            this.oEmpleado.paterno = "";
            this.oEmpleado.materno = "";
            this.oEmpleado.ci = "";
            this.oEmpleado.ci_exp = "";
            this.oEmpleado.dir = "";
            this.oEmpleado.fono = "";
            this.oEmpleado.fono_referencia = "";
            this.oEmpleado.correo = "";
            this.oEmpleado.fecha_inicio = "";
            this.oEmpleado.cargo = "";
            this.oEmpleado.salario = "";
            this.oEmpleado.horario = "";
            this.oEmpleado.foto = null;
            this.oEmpleado.sucursal_id = "";
        },
        formatoFecha(date) {
            return this.$moment(String(date)).format("DD/MM/YYYY");
        },
    },
};
</script>

<style></style>
