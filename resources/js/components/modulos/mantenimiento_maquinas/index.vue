<template>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Mantenimiento de Maquinas</h1>
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
                                                    'mantenimiento_maquinas.create'
                                                )
                                            "
                                            class="btn btn-outline-primary bg-red btn-flat btn-block"
                                            @click="
                                                abreModal('nuevo');
                                                limpiaMantenimientoMaquina();
                                            "
                                        >
                                            <i class="fa fa-plus"></i>
                                            Nuevo
                                        </button>
                                    </div>
                                    <div class="col-md-3">
                                        <router-link
                                            :to="{
                                                name: 'mantenimiento_maquinas.calendario',
                                            }"
                                            class="btn btn-outline-success bg-success btn-flat btn-block"
                                        >
                                            <i class="fa fa-calendar-alt"></i>
                                            Ver calendario
                                        </router-link>
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
                                                    #cell(fecha_mantenimiento)="row"
                                                >
                                                    <span
                                                        v-if="
                                                            row.item
                                                                .fecha_mantenimiento
                                                        "
                                                    >
                                                        {{
                                                            formatoFecha(
                                                                row.item
                                                                    .fecha_mantenimiento
                                                            )
                                                        }}
                                                    </span>
                                                </template>

                                                <template
                                                    #cell(fecha_proximo)="row"
                                                >
                                                    <span
                                                        v-if="
                                                            row.item
                                                                .fecha_proximo
                                                        "
                                                    >
                                                        {{
                                                            formatoFecha(
                                                                row.item
                                                                    .fecha_proximo
                                                            )
                                                        }}
                                                    </span>
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
                                                            ></i>
                                                        </b-button>
                                                        <b-button
                                                            size="sm"
                                                            pill
                                                            variant="outline-danger"
                                                            class="btn-flat"
                                                            title="Eliminar registro"
                                                            @click="
                                                                eliminaMantenimientoMaquina(
                                                                    row.item.id,
                                                                    row.item
                                                                        .maquina
                                                                        .nombre
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
            :mantenimiento_maquina="oMantenimientoMaquina"
            @close="muestra_modal = false"
            @envioModal="getMantenimientoMaquinas"
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
                    key: "maquina.nombre",
                    label: "Maquina",
                    sortable: true,
                },
                {
                    key: "maquina.sucursal.nombre",
                    label: "Sucursal",
                    sortable: true,
                },
                {
                    key: "fecha_mantenimiento",
                    label: "Fecha de mantenimiento",
                    sortable: true,
                },
                { key: "descripcion", label: "Descripción", sortable: true },
                {
                    key: "fecha_proximo",
                    label: "Fecha sugerida para proximo mantenimiento",
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
            oMantenimientoMaquina: {
                id: 0,
                sucursal_id: "",
                maquina_id: "",
                fecha_mantenimiento: "",
                descripcion: "",
                fecha_proximo: "",
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
        this.getMantenimientoMaquinas();
    },
    methods: {
        // Seleccionar Opciones de Tabla
        editarRegistro(item) {
            this.oMantenimientoMaquina.id = item.id;
            this.oMantenimientoMaquina.sucursal_id = item.sucursal_id
                ? item.sucursal_id
                : "";
            this.oMantenimientoMaquina.maquina_id = item.maquina_id
                ? item.maquina_id
                : "";
            this.oMantenimientoMaquina.fecha_mantenimiento =
                item.fecha_mantenimiento ? item.fecha_mantenimiento : "";
            this.oMantenimientoMaquina.descripcion = item.descripcion
                ? item.descripcion
                : "";
            this.oMantenimientoMaquina.fecha_proximo = item.fecha_proximo
                ? item.fecha_proximo
                : "";
            this.modal_accion = "edit";
            this.muestra_modal = true;
        },

        // Listar MantenimientoMaquinas
        getMantenimientoMaquinas() {
            this.showOverlay = true;
            this.muestra_modal = false;
            let url = "/admin/mantenimiento_maquinas";
            if (this.pagina != 0) {
                url += "?page=" + this.pagina;
            }
            axios
                .get(url, {
                    params: { per_page: this.per_page },
                })
                .then((res) => {
                    this.showOverlay = false;
                    this.listRegistros = res.data.mantenimiento_maquinas;
                    this.totalRows = res.data.total;
                });
        },
        eliminaMantenimientoMaquina(id, descripcion) {
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
                        .post("/admin/mantenimiento_maquinas/" + id, {
                            _method: "DELETE",
                        })
                        .then((res) => {
                            this.getMantenimientoMaquinas();
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
        abreModal(tipo_accion = "nuevo", mantenimiento_maquina = null) {
            this.muestra_modal = true;
            this.modal_accion = tipo_accion;
            if (mantenimiento_maquina) {
                this.oMantenimientoMaquina = mantenimiento_maquina;
            }
        },
        onFiltered(filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalRows = filteredItems.length;
            this.currentPage = 1;
        },
        limpiaMantenimientoMaquina() {
            this.oMantenimientoMaquina.sucursal_id = "";
            if (this.user.tipo != "GERENTE") {
                this.oMantenimientoMaquina.sucursal_id = this.user.sucursal_id;
            }
            this.oMantenimientoMaquina.maquina_id = "";
            this.oMantenimientoMaquina.fecha_mantenimiento = "";
            this.oMantenimientoMaquina.descripcion = "";
            this.oMantenimientoMaquina.fecha_proximo = "";
        },
        formatoFecha(date) {
            return this.$moment(String(date)).format("DD/MM/YYYY");
        },
    },
};
</script>

<style></style>
