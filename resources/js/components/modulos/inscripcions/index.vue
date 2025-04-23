<template>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Inscripciones</h1>
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
                                                    'inscripcions.create'
                                                )
                                            "
                                            class="btn btn-outline-primary bg-red btn-flat btn-block"
                                            @click="
                                                abreModal('nuevo');
                                                limpiaInscripcion();
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
                                                <template
                                                    #cell(fecha_inscripcion)="row"
                                                >
                                                    {{
                                                        formatoFecha(
                                                            row.item
                                                                .fecha_inscripcion
                                                        )
                                                    }}
                                                </template>
                                                <template
                                                    #cell(fecha_fin)="row"
                                                >
                                                    {{
                                                        formatoFecha(
                                                            row.item.fecha_fin
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

                                                <template #cell(estado)="row">
                                                    <span
                                                        v-if="
                                                            row.item.pausa ==
                                                                1 &&
                                                            row.item.estado ==
                                                                'VIGENTE'
                                                        "
                                                    >
                                                        PAUSADO <br />{{
                                                            formatoFecha(
                                                                row.item
                                                                    .fecha_pausa
                                                            )
                                                        }}
                                                        <br />
                                                        {{
                                                            row.item
                                                                .justificacion
                                                        }}
                                                    </span>
                                                    <span v-else>{{
                                                        row.item.estado
                                                    }}</span>
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
                                                            ></i>
                                                        </b-button>
                                                        <template
                                                            v-if="
                                                                row.item
                                                                    .estado ==
                                                                'VIGENTE'
                                                            "
                                                        >
                                                            <b-button
                                                                v-if="
                                                                    row.item
                                                                        .pausa ==
                                                                    0
                                                                "
                                                                size="sm"
                                                                pill
                                                                variant="outline-primary"
                                                                class="btn-flat mb-1"
                                                                title="Pausar plan"
                                                                @click="
                                                                    pausarPlan(
                                                                        row.item
                                                                            .id,
                                                                        row.item
                                                                            .cliente
                                                                            .full_name +
                                                                            ' con fecha de inscripcion ' +
                                                                            formatoFecha(
                                                                                row
                                                                                    .item
                                                                                    .fecha_inscripcion
                                                                            )
                                                                    )
                                                                "
                                                            >
                                                                <i
                                                                    class="fa fa-ban"
                                                                ></i>
                                                            </b-button>
                                                            <b-button
                                                                v-else
                                                                size="sm"
                                                                pill
                                                                variant="outline-success"
                                                                class="btn-flat mb-1"
                                                                title="Pausar plan"
                                                                @click="
                                                                    reactivarPlan(
                                                                        row.item
                                                                            .id,
                                                                        row.item
                                                                            .cliente
                                                                            .full_name +
                                                                            ' con fecha de inscripcion ' +
                                                                            formatoFecha(
                                                                                row
                                                                                    .item
                                                                                    .fecha_inscripcion
                                                                            )
                                                                    )
                                                                "
                                                            >
                                                                <i
                                                                    class="fa fa-play"
                                                                ></i>
                                                            </b-button>
                                                        </template>
                                                        <b-button
                                                            size="sm"
                                                            pill
                                                            variant="outline-danger"
                                                            class="btn-flat"
                                                            title="Eliminar registro"
                                                            @click="
                                                                eliminaInscripcion(
                                                                    row.item.id,
                                                                    row.item
                                                                        .cliente
                                                                        .full_name +
                                                                        ' con fecha de inscripcion ' +
                                                                        formatoFecha(
                                                                            row
                                                                                .item
                                                                                .fecha_inscripcion
                                                                        )
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
            :inscripcion="oInscripcion"
            @close="muestra_modal = false"
            @envioModal="getInscripcions"
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
                {
                    key: "cliente.full_name",
                    label: "Cliente",
                    sortable: true,
                },
                { key: "sucursal.nombre", label: "Sucursal", sortable: true },
                { key: "plan.nombre", label: "Plan", sortable: true },
                { key: "disciplina", label: "Disciplina", sortable: true },
                { key: "sucursal.nombre", label: "Sucursal", sortable: true },
                {
                    key: "fecha_inscripcion",
                    label: "Fecha de inscripción",
                    sortable: true,
                },
                {
                    key: "fecha_fin",
                    label: "Fecha de finalización",
                    sortable: true,
                },
                {
                    key: "estado",
                    label: "Estado",
                    sortable: true,
                },
                {
                    key: "codigo_rfid",
                    label: "Código Cliente",
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
            oInscripcion: {
                id: 0,
                cliente_id: "",
                plan_id: "",
                disciplina: "",
                sucursal_id: "",
                fecha_inscripcion: "",
                codigo_rfid: "",
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
        this.getInscripcions();
    },
    methods: {
        // Seleccionar Opciones de Tabla
        editarRegistro(item) {
            this.oInscripcion.id = item.id;
            this.oInscripcion.cliente_id = item.cliente_id
                ? item.cliente_id
                : "";
            this.oInscripcion.plan_id = item.plan_id ? item.plan_id : "";
            this.oInscripcion.disciplina = item.disciplina
                ? item.disciplina
                : "";
            this.oInscripcion.sucursal_id = item.sucursal_id
                ? item.sucursal_id
                : "";
            this.oInscripcion.fecha_inscripcion = item.fecha_inscripcion
                ? item.fecha_inscripcion
                : "";
            this.oInscripcion.codigo_rfid = item.codigo_rfid
                ? item.codigo_rfid
                : "";

            this.modal_accion = "edit";
            this.muestra_modal = true;
        },

        // Listar Inscripcions
        getInscripcions() {
            this.showOverlay = true;
            this.muestra_modal = false;
            let url = "/admin/inscripcions";
            if (this.pagina != 0) {
                url += "?page=" + this.pagina;
            }
            axios
                .get(url, {
                    params: { per_page: this.per_page },
                })
                .then((res) => {
                    this.showOverlay = false;
                    this.listRegistros = res.data.inscripcions;
                    this.totalRows = res.data.total;
                });
        },
        eliminaInscripcion(id, descripcion) {
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
                        .post("/admin/inscripcions/" + id, {
                            _method: "DELETE",
                        })
                        .then((res) => {
                            this.getInscripcions();
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
        pausarPlan(id, descripcion) {
            let txt_justificacion = "";
            Swal.fire({
                title: "¿Quierés pausar este plan?",
                html: `<strong>${descripcion}</strong>`,
                showCancelButton: true,
                confirmButtonColor: "#05568e",
                confirmButtonText: "Si, pausar",
                cancelButtonText: "No, cancelar",
                denyButtonText: `No, cancelar`,
                input: "textarea",
                inputAttributes: {
                    rows: "3",
                    placeholder: "Justificación",
                },
                preConfirm: (justificacion) => {
                    if (justificacion.trim() != "") {
                        txt_justificacion = justificacion.trim()
                        return true;
                    }
                    Swal.showValidationMessage(
                        `Debes ingresar la justificación`
                    );
                    return false;
                },
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed && txt_justificacion != "") {
                    axios
                        .post("/admin/inscripcions/pausar_plan/" + id, {
                            _method: "PUT",
                            pausa: 1,
                            justificacion: txt_justificacion,
                        })
                        .then((res) => {
                            this.getInscripcions();
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
        reactivarPlan(id, descripcion) {
            Swal.fire({
                title: "¿Quierés reanudar este plan?",
                html: `<strong>${descripcion}</strong>`,
                showCancelButton: true,
                confirmButtonColor: "#05568e",
                confirmButtonText: "Si, reanudar",
                cancelButtonText: "No, cancelar",
                denyButtonText: `No, cancelar`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    axios
                        .post("/admin/inscripcions/pausar_plan/" + id, {
                            _method: "PUT",
                            pausa: 0,
                        })
                        .then((res) => {
                            this.getInscripcions();
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
        abreModal(tipo_accion = "nuevo", inscripcion = null) {
            this.muestra_modal = true;
            this.modal_accion = tipo_accion;
            if (inscripcion) {
                this.oInscripcion = inscripcion;
            }
        },
        onFiltered(filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalRows = filteredItems.length;
            this.currentPage = 1;
        },
        limpiaInscripcion() {
            this.oInscripcion.cliente_id = "";
            this.oInscripcion.plan_id = "";
            this.oInscripcion.disciplina = "";
            this.oInscripcion.sucursal_id = "";
            if (this.user.tipo != "GERENTE") {
                this.oInscripcion.sucursal_id = this.user.sucursal_id;
            }
            this.oInscripcion.fecha_inscripcion = this.fechaActual();
            this.oInscripcion.codigo_rfid = "";
        },
        formatoFecha(date) {
            return this.$moment(String(date)).format("DD/MM/YYYY");
        },
        fechaActual() {
            // crea un nuevo objeto `Date`
            var today = new Date();

            // `getDate()` devuelve el día del mes (del 1 al 31)
            var day = today.getDate();
            if (day < 10) {
                day = "0" + day;
            }
            // `getMonth()` devuelve el mes (de 0 a 11)
            var month = today.getMonth() + 1;
            if (month < 10) {
                month = "0" + month;
            }

            // `getFullYear()` devuelve el año completo
            var year = today.getFullYear();

            // muestra la fecha de hoy en formato `MM/DD/YYYY`
            return `${year}-${month}-${day}`;
        },
    },
};
</script>

<style></style>
