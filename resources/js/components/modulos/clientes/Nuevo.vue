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
                                    v-model="cliente.nombre"
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
                                    v-model="cliente.paterno"
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
                                    v-model="cliente.materno"
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
                                    >Número C.I.*</label
                                >
                                <el-input
                                    placeholder="Número de C.I."
                                    :class="{ 'is-invalid': errors.ci }"
                                    v-model="cliente.ci"
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
                                    >Expedición C.I.*</label
                                >
                                <el-select
                                    class="w-100 d-block"
                                    :class="{
                                        'is-invalid': errors.ci_exp,
                                    }"
                                    v-model="cliente.ci_exp"
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
                                        'text-danger': errors.fecha_nacimiento,
                                    }"
                                    >Fecha de nacimiento*</label
                                >
                                <input
                                    type="date"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': errors.fecha_nacimiento,
                                    }"
                                    v-model="cliente.fecha_nacimiento"
                                    @keyup="calculaEdad"
                                    @change="calculaEdad"
                                />
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.fecha_nacimiento"
                                    v-text="errors.fecha_nacimiento[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.edad,
                                    }"
                                    >Edad*</label
                                >
                                <input
                                    type="number"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': errors.edad,
                                    }"
                                    v-model="cliente.edad"
                                    readonly
                                />
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.edad"
                                    v-text="errors.edad[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.genero,
                                    }"
                                    >Género*</label
                                >
                                <el-select
                                    class="w-100 d-block"
                                    :class="{
                                        'is-invalid': errors.genero,
                                    }"
                                    v-model="cliente.genero"
                                    clearable
                                >
                                    <el-option
                                        v-for="(item, index) in [
                                            'HOMBRE',
                                            'MUJER',
                                        ]"
                                        :key="index"
                                        :value="item"
                                        :label="item"
                                    >
                                    </el-option>
                                </el-select>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.genero"
                                    v-text="errors.genero[0]"
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
                                    v-model="cliente.dir"
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
                                        'text-danger': errors.fono2,
                                    }"
                                    >Teléfonos</label
                                >
                                <div class="row">
                                    <div class="col-md-6">
                                        <el-input
                                            placeholder="Teléfono 1"
                                            :class="{
                                                'is-invalid': errors.fono,
                                            }"
                                            v-model="cliente.fono"
                                            clearable
                                        >
                                        </el-input>
                                        <span
                                            class="error invalid-feedback"
                                            v-if="errors.fono"
                                            v-text="errors.fono[0]"
                                        ></span>
                                    </div>
                                    <div class="col-md-6">
                                        <el-input
                                            placeholder="Teléfono 2"
                                            :class="{
                                                'is-invalid': errors.fono2,
                                            }"
                                            v-model="cliente.fono2"
                                            clearable
                                        >
                                        </el-input>
                                        <span
                                            class="error invalid-feedback"
                                            v-if="errors.fono2"
                                            v-text="errors.fono2[0]"
                                        ></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.correo,
                                    }"
                                    >Correo Electrónico</label
                                >
                                <el-input
                                    placeholder="Correo Electrónico"
                                    :class="{ 'is-invalid': errors.correo }"
                                    v-model="cliente.correo"
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
                            <div
                                class="form-group col-md-6"
                                v-if="user.tipo == 'GERENTE'"
                            >
                                <label
                                    :class="{
                                        'text-danger': errors.sucursal_id,
                                    }"
                                    >Sucursal*</label
                                >
                                <el-select
                                    class="w-100 d-block"
                                    :class="{
                                        'is-invalid': errors.sucursal_id,
                                    }"
                                    v-model="cliente.sucursal_id"
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
                                        'text-danger':
                                            errors.declaracion_jurada,
                                    }"
                                    >Declaración jurada</label
                                >
                                <input
                                    type="file"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': errors.declaracion_jurada,
                                    }"
                                    ref="input_file_declaracion_jurada"
                                    @change="cargaArchivo"
                                />
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.declaracion_jurada"
                                    v-text="errors.declaracion_jurada[0]"
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
        cliente: {
            type: Object,
            default: {
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
        },
    },
    watch: {
        muestra_modal: function (newVal, oldVal) {
            this.errors = [];
            if (newVal) {
                this.$refs.input_file.value = null;
                this.$refs.input_file_declaracion_jurada.value = null;
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
        this.getSucursales();
        this.bModal = this.muestra_modal;
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
                let url = "/admin/clientes";
                let config = {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                };
                let formdata = new FormData();
                formdata.append(
                    "nombre",
                    this.cliente.nombre ? this.cliente.nombre : ""
                );
                formdata.append(
                    "paterno",
                    this.cliente.paterno ? this.cliente.paterno : ""
                );
                formdata.append(
                    "materno",
                    this.cliente.materno ? this.cliente.materno : ""
                );
                formdata.append("ci", this.cliente.ci ? this.cliente.ci : "");
                formdata.append(
                    "ci_exp",
                    this.cliente.ci_exp ? this.cliente.ci_exp : ""
                );
                formdata.append(
                    "fecha_nacimiento",
                    this.cliente.fecha_nacimiento
                        ? this.cliente.fecha_nacimiento
                        : ""
                );
                formdata.append(
                    "edad",
                    this.cliente.edad ? this.cliente.edad : ""
                );
                formdata.append(
                    "genero",
                    this.cliente.genero ? this.cliente.genero : ""
                );
                formdata.append(
                    "dir",
                    this.cliente.dir ? this.cliente.dir : ""
                );
                formdata.append(
                    "fono",
                    this.cliente.fono ? this.cliente.fono : ""
                );
                formdata.append(
                    "fono2",
                    this.cliente.fono2 ? this.cliente.fono2 : ""
                );
                formdata.append(
                    "correo",
                    this.cliente.correo ? this.cliente.correo : ""
                );
                formdata.append(
                    "foto",
                    this.cliente.foto ? this.cliente.foto : ""
                );
                formdata.append(
                    "declaracion_jurada",
                    this.cliente.declaracion_jurada
                        ? this.cliente.declaracion_jurada
                        : ""
                );
                formdata.append(
                    "sucursal_id",
                    this.cliente.sucursal_id ? this.cliente.sucursal_id : ""
                );

                if (this.accion == "edit") {
                    url = "/admin/clientes/" + this.cliente.id;
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
                        this.limpiaCliente();
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
            this.cliente.foto = e.target.files[0];
        },
        cargaArchivo(e) {
            this.cliente.declaracion_jurada = e.target.files[0];
        },
        // Dialog/modal
        cierraModal() {
            this.bModal = false;
            this.$emit("close");
        },
        limpiaCliente() {
            this.errors = [];
            this.cliente.nombre = "";
            this.cliente.paterno = "";
            this.cliente.materno = "";
            this.cliente.ci = "";
            this.cliente.ci_exp = "";
            this.cliente.fecha_nacimiento = "";
            this.cliente.edad = "";
            this.cliente.genero = "";
            this.cliente.dir = "";
            this.cliente.fono = "";
            this.cliente.fono2 = "";
            this.cliente.correo = "";
            this.cliente.foto = null;
            this.cliente.declaracion_jurada = null;
            this.cliente.sucursal_id = "";
            this.$refs.input_file.value = null;
        },
        calculaEdad() {
            if (this.cliente.fecha_nacimiento != "") {
                var hoy = new Date();
                var cumpleanos = new Date(this.cliente.fecha_nacimiento);
                var edad = hoy.getFullYear() - cumpleanos.getFullYear();
                var m = hoy.getMonth() - cumpleanos.getMonth();

                if (
                    m < 0 ||
                    (m === 0 && hoy.getDate() < cumpleanos.getDate())
                ) {
                    edad--;
                }
                this.cliente.edad = edad;
            }
        },
    },
};
</script>

<style></style>
