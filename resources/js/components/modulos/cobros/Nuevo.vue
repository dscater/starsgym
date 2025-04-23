<template>
    <div
        class="modal fade"
        :class="{ show: bModal }"
        id="modal-default"
        aria-modal="true"
        role="dialog"
    >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-red">
                    <h4 class="modal-title" v-text="tituloModal"></h4>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                        @click="cierraModal"
                    >
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div
                                class="form-group col-md-6"
                                v-if="user.tipo == 'GERENTE'"
                            >
                                <label
                                    :class="{
                                        'text-danger': errors.sucursal_id,
                                    }"
                                    >Seleccionar Sucursal*</label
                                >
                                <el-select
                                    class="w-full d-block"
                                    :class="{
                                        'is-invalid': errors.sucursal_id,
                                    }"
                                    v-model="cobro.sucursal_id"
                                    clearable
                                    @change="getClientes()"
                                >
                                    <el-option
                                        v-for="item in listSucursales"
                                        :key="item.id"
                                        :value="item.id"
                                        :label="item.nombre"
                                    >
                                    </el-option>
                                </el-select>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.sucursal_id"
                                    v-text="errors.sucursal_id[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.cliente_id,
                                    }"
                                    >Seleccionar cliente*</label
                                >
                                <el-select
                                    class="w-full d-block"
                                    :class="{ 'is-invalid': errors.cliente_id }"
                                    v-model="cobro.cliente_id"
                                    clearable
                                    @change="getInfoInscripcion"
                                >
                                    <el-option
                                        v-for="item in listClientes"
                                        :key="item.id"
                                        :value="item.id"
                                        :label="item.full_name"
                                    >
                                    </el-option>
                                </el-select>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.cliente_id"
                                    v-text="errors.cliente_id[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.fecha_cobro,
                                    }"
                                    >Fecha de cobro*</label
                                >
                                <el-input
                                    type="date"
                                    class="w-full d-block"
                                    :class="{
                                        'is-invalid': errors.fecha_cobro,
                                    }"
                                    v-model="cobro.fecha_cobro"
                                    readonly
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.fecha_cobro"
                                    v-text="errors.fecha_cobro[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Detalle de la inscripción</label>
                                <div class="row" v-if="oInscripcion">
                                    <div class="col-md-12">
                                        <div class="card card-body">
                                            <div class="form-group col-md-12">
                                                <label>Plan:</label>
                                                <div>
                                                    {{
                                                        oInscripcion.plan.nombre
                                                    }}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label>Costo:</label>
                                                <div>
                                                    {{
                                                        oInscripcion.plan.costo
                                                    }}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label>Duración:</label>
                                                <div>
                                                    {{
                                                        oInscripcion.plan
                                                            .duracion
                                                    }}
                                                    días
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label>Sucursal:</label>
                                                <div>
                                                    {{
                                                        oInscripcion.sucursal
                                                            .nombre
                                                    }}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label
                                                    >Fecha de
                                                    inscripción:</label
                                                >
                                                <div>
                                                    Del
                                                    {{
                                                        formatoFecha(
                                                            oInscripcion.fecha_inscripcion
                                                        )
                                                    }}
                                                    al
                                                    {{
                                                        formatoFecha(
                                                            oInscripcion.fecha_fin
                                                        )
                                                    }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" v-else>
                                    <div class="col-md-12">
                                        <div
                                            class="text-gray"
                                            :class="{
                                                'is-invalid':
                                                    errors.inscripcion_id,
                                            }"
                                        >
                                            <i
                                                >No se encontró ninguna
                                                Inscripción con un cobro
                                                pendiente</i
                                            >
                                        </div>

                                        <span
                                            class="error invalid-feedback"
                                            v-if="errors.inscripcion_id"
                                            v-text="errors.inscripcion_id[0]"
                                        ></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button
                        type="button"
                        class="btn btn-default"
                        data-dismiss="modal"
                        @click="cierraModal"
                    >
                        Cerrar
                    </button>
                    <el-button
                        type="primary"
                        class="bg-red"
                        :loading="enviando"
                        @click="setRegistroModal()"
                        >{{ textoBoton }}</el-button
                    >
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        muestra_modal: {
            type: Boolean,
            default: false,
        },
        accion: {
            type: String,
            default: "nuevo",
        },
        cobro: {
            type: Object,
            default: {
                id: 0,
                cliente_id: "",
                inscripcion_id: "",
                sucursal_id: "",
                fecha_cobro: "",
            },
        },
    },
    watch: {
        muestra_modal: function (newVal, oldVal) {
            this.errors = [];
            this.getClientes();
            if (newVal) {
                if (this.user.tipo == "GERENTE") {
                    this.cobro.sucursal_id = "";
                    this.cobro.cliente_id = "";
                }
                this.oInscripcion = null;
                this.bModal = true;
            } else {
                this.bModal = false;
            }
        },
    },
    computed: {
        tituloModal() {
            if (this.accion == "nuevo") {
                return "REGISTRAR COBRO";
            } else {
                return "MODIFICAR REGISTRO";
            }
        },
        textoBoton() {
            if (this.accion == "nuevo") {
                return "Registrar";
            } else {
                return "Actualizar";
            }
        },
    },
    data() {
        return {
            user: JSON.parse(localStorage.getItem("user")),
            bModal: this.muestra_modal,
            enviando: false,
            errors: [],
            listClientes: [],
            listSucursales: [],
            oInscripcion: null,
        };
    },
    mounted() {
        this.getClientes();
        this.getSucursales();
        this.bModal = this.muestra_modal;
    },
    methods: {
        getClientes() {
            if (this.cobro.sucursal_id != "") {
                axios
                    .get("/admin/clientes/clientes_sucursal", {
                        params: {
                            id: this.cobro.sucursal_id,
                        },
                    })
                    .then((response) => {
                        this.listClientes = response.data;
                    });
            } else {
                this.listClientes = [];
            }
        },
        getSucursales() {
            axios.get("/admin/sucursals").then((response) => {
                this.listSucursales = response.data.sucursals;
            });
        },
        getInfoInscripcion() {
            if (this.cobro.sucursal_id != "" && this.cobro.cliente_id != "") {
                axios
                    .get("/admin/inscripcions/getInfoInscripcion", {
                        params: {
                            cliente_id: this.cobro.cliente_id,
                            sucursal_id: this.cobro.sucursal_id,
                        },
                    })
                    .then((response) => {
                        this.oInscripcion = response.data;
                        if (this.oInscripcion.id) {
                            this.cobro.inscripcion_id = this.oInscripcion.id;
                        } else {
                            this.oInscripcion = null;
                            this.cobro.inscripcion_id = null;
                        }
                    });
            } else {
                this.oInscripcion = null;
            }
        },
        setRegistroModal() {
            this.enviando = true;
            try {
                this.textoBtn = "Enviando...";
                let url = "/admin/cobros";
                let config = {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                };
                let formdata = new FormData();
                formdata.append(
                    "cliente_id",
                    this.cobro.cliente_id ? this.cobro.cliente_id : ""
                );
                formdata.append(
                    "inscripcion_id",
                    this.cobro.inscripcion_id ? this.cobro.inscripcion_id : ""
                );
                formdata.append(
                    "sucursal_id",
                    this.cobro.sucursal_id ? this.cobro.sucursal_id : ""
                );

                formdata.append(
                    "fecha_cobro",
                    this.cobro.fecha_cobro ? this.cobro.fecha_cobro : ""
                );
                if (this.accion == "edit") {
                    url = "/admin/cobros/" + this.cobro.id;
                    formdata.append("_method", "PUT");
                }
                axios
                    .post(url, formdata, config)
                    .then((res) => {
                        this.enviando = false;
                        Swal.fire({
                            icon: "success",
                            title: res.data.msj,
                            showConfirmButton: false,
                            timer: 1500,
                        });
                        this.limpiaCobro();
                        this.$emit("envioModal");
                        this.errors = [];
                        if (this.accion == "edit") {
                            this.textoBtn = "Actualizar";
                        } else {
                            this.textoBtn = "Registrar";
                        }
                    })
                    .catch((error) => {
                        this.enviando = false;
                        if (this.accion == "edit") {
                            this.textoBtn = "Actualizar";
                        } else {
                            this.textoBtn = "Registrar";
                        }
                        if (error.response) {
                            if (error.response.status === 422) {
                                this.errors = error.response.data.errors;
                            }
                            if (
                                error.response.status === 420 ||
                                error.response.status === 419 ||
                                error.response.status === 401
                            ) {
                                window.location = "/";
                            }
                            if (error.response.status === 500) {
                                Swal.fire({
                                    icon: "error",
                                    title: "Error",
                                    html: error.response.data.message,
                                    showConfirmButton: false,
                                    timer: 3000,
                                });
                            }
                        }
                    });
            } catch (e) {
                this.enviando = false;
                console.log(e);
            }
        },
        // Dialog/modal
        cierraModal() {
            this.bModal = false;
            this.$emit("close");
        },
        limpiaCobro() {
            this.errors = [];
            this.cobro.cliente_id = "";
            this.cobro.inscripcion_id = "";
            this.cobro.sucursal_id = "";
            this.cobro.fecha_cobro = "";
        },
        formatoFecha(date) {
            return this.$moment(String(date)).format("DD/MM/YYYY");
        },
    },
};
</script>

<style></style>
