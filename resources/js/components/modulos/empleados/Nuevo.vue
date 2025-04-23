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
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.nombre,
                                    }"
                                    >Nombre*</label
                                >
                                <el-input
                                    placeholder="Nombre"
                                    :class="{ 'is-invalid': errors.nombre }"
                                    v-model="empleado.nombre"
                                    clearable
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.nombre"
                                    v-text="errors.nombre[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.paterno,
                                    }"
                                    >Ap. Paterno</label
                                >

                                <el-input
                                    placeholder="Ap. Paterno"
                                    :class="{ 'is-invalid': errors.paterno }"
                                    v-model="empleado.paterno"
                                    clearable
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.paterno"
                                    v-text="errors.paterno[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.materno,
                                    }"
                                    >Ap. Materno</label
                                >
                                <el-input
                                    placeholder="Ap. Materno"
                                    :class="{ 'is-invalid': errors.materno }"
                                    v-model="empleado.materno"
                                    clearable
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.materno"
                                    v-text="errors.materno[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.ci,
                                    }"
                                    >C.I.*</label
                                >
                                <el-input
                                    placeholder="Número de C.I."
                                    :class="{ 'is-invalid': errors.ci }"
                                    v-model="empleado.ci"
                                    clearable
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.ci"
                                    v-text="errors.ci[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.ci_exp,
                                    }"
                                    >Expedido*</label
                                >
                                <el-select
                                    class="w-100 d-block"
                                    :class="{
                                        'is-invalid': errors.ci_exp,
                                    }"
                                    v-model="empleado.ci_exp"
                                    clearable
                                >
                                    <el-option
                                        v-for="(item, index) in listExpedido"
                                        :key="index"
                                        :value="item.value"
                                        :label="item.label"
                                    >
                                    </el-option>
                                </el-select>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.ci_exp"
                                    v-text="errors.ci_exp[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.dir,
                                    }"
                                    >Dirección</label
                                >
                                <el-input
                                    placeholder="Dirección"
                                    :class="{ 'is-invalid': errors.dir }"
                                    v-model="empleado.dir"
                                    clearable
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.dir"
                                    v-text="errors.dir[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.fono,
                                    }"
                                    >Teléfono</label
                                >
                                <el-input
                                    placeholder="Teléfono"
                                    :class="{ 'is-invalid': errors.fono }"
                                    v-model="empleado.fono"
                                    clearable
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.fono"
                                    v-text="errors.fono[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.fono_referencia,
                                    }"
                                    >Teléfono de referencia</label
                                >
                                <el-input
                                    placeholder="Teléfono de referencia"
                                    :class="{
                                        'is-invalid': errors.fono_referencia,
                                    }"
                                    v-model="empleado.fono_referencia"
                                    clearable
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.fono_referencia"
                                    v-text="errors.fono_referencia[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.correo,
                                    }"
                                    >Correo Electrónico</label
                                >
                                <el-input
                                    type="email"
                                    placeholder="Teléfono de referencia"
                                    :class="{
                                        'is-invalid': errors.correo,
                                    }"
                                    v-model="empleado.correo"
                                    clearable
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.correo"
                                    v-text="errors.correo[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.fecha_inicio,
                                    }"
                                    >Fecha Inicio de Contrato*</label
                                >
                                <el-input
                                    type="date"
                                    :class="{
                                        'is-invalid': errors.fecha_inicio,
                                    }"
                                    v-model="empleado.fecha_inicio"
                                    clearable
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.fecha_inicio"
                                    v-text="errors.fecha_inicio[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.cargo,
                                    }"
                                    >Cargo</label
                                >
                                <el-input
                                    placeholder="Cargo"
                                    :class="{ 'is-invalid': errors.cargo }"
                                    v-model="empleado.cargo"
                                    clearable
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.cargo"
                                    v-text="errors.cargo[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.salario,
                                    }"
                                    >Salario</label
                                >
                                <el-input
                                    type="number"
                                    placeholder="Salario"
                                    :class="{ 'is-invalid': errors.salario }"
                                    v-model="empleado.salario"
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.salario"
                                    v-text="errors.salario[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.horario,
                                    }"
                                    >Horario</label
                                >
                                <el-input
                                    placeholder="Horario"
                                    :class="{ 'is-invalid': errors.horario }"
                                    v-model="empleado.horario"
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.horario"
                                    v-text="errors.horario[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.sucursal_id,
                                    }"
                                    >Seleccionar Sucursal*</label
                                >
                                <el-select
                                    class="w-100 d-block"
                                    :class="{
                                        'is-invalid': errors.sucursal_id,
                                    }"
                                    v-model="empleado.sucursal_id"
                                    clearable
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
                                        'text-danger': errors.foto,
                                    }"
                                    >Foto</label
                                >
                                <input
                                    type="file"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': errors.foto,
                                    }"
                                    ref="input_file"
                                    @change="cargaImagen"
                                />
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.foto"
                                    v-text="errors.foto[0]"
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
        empleado: {
            type: Object,
            default: {
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
        },
    },
    watch: {
        muestra_modal: function (newVal, oldVal) {
            this.errors = [];
            if (newVal) {
                this.$refs.input_file.value = null;
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
            listExpedido: [
                { value: "LP", label: "La Paz" },
                { value: "CB", label: "Cochabamba" },
                { value: "SC", label: "Santa Cruz" },
                { value: "CH", label: "Chuquisaca" },
                { value: "OR", label: "Oruro" },
                { value: "PT", label: "Potosi" },
                { value: "TJ", label: "Tarija" },
                { value: "PD", label: "Pando" },
                { value: "BN", label: "Beni" },
            ],
            listSucursales: [],
            errors: [],
        };
    },
    mounted() {
        this.bModal = this.muestra_modal;
        this.getSucursales();
    },
    methods: {
        getSucursales() {
            axios.get("/admin/sucursals").then((response) => {
                this.listSucursales = response.data.sucursals;
            });
        },
        setRegistroModal() {
            this.enviando = true;
            try {
                this.textoBtn = "Enviando...";
                let url = "/admin/empleados";
                let config = {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                };
                let formdata = new FormData();
                formdata.append(
                    "nombre",
                    this.empleado.nombre ? this.empleado.nombre : ""
                );
                formdata.append(
                    "paterno",
                    this.empleado.paterno ? this.empleado.paterno : ""
                );
                formdata.append(
                    "materno",
                    this.empleado.materno ? this.empleado.materno : ""
                );
                formdata.append("ci", this.empleado.ci ? this.empleado.ci : "");
                formdata.append(
                    "ci_exp",
                    this.empleado.ci_exp ? this.empleado.ci_exp : ""
                );
                formdata.append(
                    "dir",
                    this.empleado.dir ? this.empleado.dir : ""
                );
                formdata.append(
                    "fono",
                    this.empleado.fono ? this.empleado.fono : ""
                );
                formdata.append(
                    "fono_referencia",
                    this.empleado.fono_referencia
                        ? this.empleado.fono_referencia
                        : ""
                );
                if (this.empleado.correo && this.empleado.correo.trim() != "") {
                    formdata.append("correo", this.empleado.correo);
                }
                formdata.append(
                    "fecha_inicio",
                    this.empleado.fecha_inicio ? this.empleado.fecha_inicio : ""
                );
                formdata.append(
                    "cargo",
                    this.empleado.cargo ? this.empleado.cargo : ""
                );
                if (
                    this.empleado.salario &&
                    this.empleado.salario.trim() != ""
                ) {
                    formdata.append("salario", this.empleado.salario);
                }
                
                formdata.append(
                    "horario",
                    this.empleado.horario ? this.empleado.horario : ""
                );
                formdata.append(
                    "foto",
                    this.empleado.foto ? this.empleado.foto : ""
                );
                formdata.append(
                    "sucursal_id",
                    this.empleado.sucursal_id ? this.empleado.sucursal_id : ""
                );

                if (this.accion == "edit") {
                    url = "/admin/empleados/" + this.empleado.id;
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
                        this.limpiaEmpleado();
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
                        }
                    });
            } catch (e) {
                this.enviando = false;
                console.log(e);
            }
        },
        cargaImagen(e) {
            this.empleado.foto = e.target.files[0];
        },
        // Dialog/modal
        cierraModal() {
            this.bModal = false;
            this.$emit("close");
        },
        limpiaEmpleado() {
            this.errors = [];
            this.empleado.nombre = "";
            this.empleado.paterno = "";
            this.empleado.materno = "";
            this.empleado.ci = "";
            this.empleado.ci_exp = "";
            this.empleado.dir = "";
            this.empleado.fono = "";
            this.empleado.fono_referencia = "";
            this.empleado.correo = "";
            this.empleado.fecha_inicio = "";
            this.empleado.cargo = "";
            this.empleado.salario = "";
            this.empleado.horario = "";
            this.empleado.foto = "";
            this.empleado.sucursal_id = "";
            this.$refs.input_file.value = null;
        },
    },
};
</script>

<style></style>
