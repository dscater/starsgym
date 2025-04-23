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
                                    >Seleccionar sucursal*</label
                                >
                                <el-select
                                    class="w-full d-block"
                                    :class="{
                                        'is-invalid': errors.sucursal_id,
                                    }"
                                    v-model="inscripcion.sucursal_id"
                                    clearable
                                    @change="
                                        getClientes();
                                        getPlanes();
                                    "
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
                                    v-model="inscripcion.cliente_id"
                                    clearable
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
                                        'text-danger': errors.plan_id,
                                    }"
                                    >Seleccionar plan*</label
                                >
                                <el-select
                                    class="w-full d-block"
                                    :class="{ 'is-invalid': errors.plan_id }"
                                    v-model="inscripcion.plan_id"
                                    clearable
                                >
                                    <el-option
                                        v-for="item in listPlanes"
                                        :key="item.id"
                                        :value="item.id"
                                        :label="item.nombre"
                                    >
                                    </el-option>
                                </el-select>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.plan_id"
                                    v-text="errors.plan_id[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.disciplina,
                                    }"
                                    >Disciplina*</label
                                >
                                <el-input
                                    placeholder="Disciplina"
                                    :class="{ 'is-invalid': errors.disciplina }"
                                    v-model="inscripcion.disciplina"
                                    clearable
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.disciplina"
                                    v-text="errors.disciplina[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.fecha_inscripcion,
                                    }"
                                    >Fecha de inscripción*</label
                                >
                                <el-input
                                    type="date"
                                    placeholder="Nombre"
                                    :class="{
                                        'is-invalid': errors.fecha_inscripcion,
                                    }"
                                    v-model="inscripcion.fecha_inscripcion"
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.fecha_inscripcion"
                                    v-text="errors.fecha_inscripcion[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.codigo_rfid,
                                    }"
                                    >Código Cliente*</label
                                >

                                <el-input
                                    placeholder="Código Cliente"
                                    :class="{
                                        'is-invalid': errors.codigo_rfid,
                                    }"
                                    v-model="inscripcion.codigo_rfid"
                                    clearable
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.codigo_rfid"
                                    v-text="errors.codigo_rfid[0]"
                                ></span>
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
        inscripcion: {
            type: Object,
            default: {
                id: 0,
                cliente_id: "",
                plan_id: "",
                disciplina: "",
                sucursal_id: "",
                fecha_inscripcion: "",
                codigo_rfid: "",
            },
        },
    },
    watch: {
        muestra_modal: function (newVal, oldVal) {
            this.errors = [];
            this.getClientes();
            this.getPlanes();

            if (newVal) {
                this.bModal = true;
            } else {
                this.bModal = false;
            }
        },
    },
    computed: {
        tituloModal() {
            if (this.accion == "nuevo") {
                return "AGREGAR REGISTRO";
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
            listPlanes: [],
            listSucursales: [],
        };
    },
    mounted() {
        this.getSucursales();
        this.getClientes();
        this.getPlanes();
        this.bModal = this.muestra_modal;
    },
    methods: {
        getSucursales() {
            axios.get("/admin/sucursals").then((response) => {
                this.listSucursales = response.data.sucursals;
            });
        },
        getClientes() {
            if (this.inscripcion.sucursal_id != "") {
                axios
                    .get("/admin/clientes/clientes_sucursal", {
                        params: {
                            id: this.inscripcion.sucursal_id,
                        },
                    })
                    .then((response) => {
                        this.listClientes = response.data;
                    });
            } else {
                this.listClientes = [];
            }
        },
        getPlanes() {
            if (this.inscripcion.sucursal_id != "") {
                axios
                    .get("/admin/plans/plans_sucursal", {
                        params: {
                            id: this.inscripcion.sucursal_id,
                        },
                    })
                    .then((response) => {
                        this.listPlanes = response.data;
                    });
            } else {
                this.listPlanes = [];
            }
        },
        setRegistroModal() {
            this.enviando = true;
            try {
                this.textoBtn = "Enviando...";
                let url = "/admin/inscripcions";
                let config = {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                };
                let formdata = new FormData();
                formdata.append(
                    "cliente_id",
                    this.inscripcion.cliente_id
                        ? this.inscripcion.cliente_id
                        : ""
                );
                formdata.append(
                    "plan_id",
                    this.inscripcion.plan_id ? this.inscripcion.plan_id : ""
                );
                formdata.append(
                    "disciplina",
                    this.inscripcion.disciplina
                        ? this.inscripcion.disciplina
                        : ""
                );
                formdata.append(
                    "sucursal_id",
                    this.inscripcion.sucursal_id
                        ? this.inscripcion.sucursal_id
                        : ""
                );
                formdata.append(
                    "fecha_inscripcion",
                    this.inscripcion.fecha_inscripcion
                        ? this.inscripcion.fecha_inscripcion
                        : ""
                );
                formdata.append(
                    "codigo_rfid",
                    this.inscripcion.codigo_rfid
                        ? this.inscripcion.codigo_rfid
                        : ""
                );
                if (this.accion == "edit") {
                    url = "/admin/inscripcions/" + this.inscripcion.id;
                    formdata.append("_method", "PUT");
                }
                axios
                    .post(url, formdata, config)
                    .then((res) => {
                        this.enviando = false;
                        if (res.data.sw) {
                            Swal.fire({
                                icon: "success",
                                title: res.data.msj,
                                showConfirmButton: false,
                                timer: 1500,
                            });
                            this.limpiaInscripcion();
                            this.$emit("envioModal");
                            this.errors = [];
                            if (this.accion == "edit") {
                                this.textoBtn = "Actualizar";
                            } else {
                                this.textoBtn = "Registrar";
                            }
                        } else {
                            Swal.fire({
                                icon: "info",
                                title: res.data.msj,
                                showConfirmButton: false,
                                timer: 3500,
                            });
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
        limpiaInscripcion() {
            this.errors = [];
            this.inscripcion.cliente_id = "";
            this.inscripcion.plan_id = "";
            this.inscripcion.disciplina = "";
            this.inscripcion.sucursal_id = "";
            this.inscripcion.fecha_inscripcion = "";
            this.inscripcion.codigo_rfid = "";
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
