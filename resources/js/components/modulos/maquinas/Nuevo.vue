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
                            <!-- <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.codigo,
                                    }"
                                    >Código*</label
                                >
                                <el-input
                                    placeholder="Código"
                                    :class="{ 'is-invalid': errors.codigo }"
                                    v-model="maquina.codigo"
                                    clearable
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.codigo"
                                    v-text="errors.codigo[0]"
                                ></span>
                            </div> -->
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
                                    v-model="maquina.nombre"
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
                                        'text-danger': errors.categoria_id,
                                    }"
                                    >Categoría*</label
                                >
                                <el-select
                                    class="w-100 d-block"
                                    :class="{
                                        'is-invalid': errors.categoria_id,
                                    }"
                                    v-model="maquina.categoria_id"
                                    clearable
                                >
                                    <el-option
                                        v-for="item in listCategorias"
                                        :key="item.id"
                                        :value="item.id"
                                        :label="item.nombre"
                                    >
                                    </el-option>
                                </el-select>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.categoria_id"
                                    v-text="errors.categoria_id[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.descripcion,
                                    }"
                                    >Descripción</label
                                >

                                <el-input
                                    type="textarea"
                                    autosize
                                    placeholder="Dirección"
                                    :class="{
                                        'is-invalid': errors.descripcion,
                                    }"
                                    v-model="maquina.descripcion"
                                    clearable
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.descripcion"
                                    v-text="errors.descripcion[0]"
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
                                    v-model="maquina.sucursal_id"
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
                                            errors.fecha_incorporacion,
                                    }"
                                    >Fecha de Incorporación</label
                                >

                                <el-input
                                    type="date"
                                    placeholder="Dirección"
                                    :class="{
                                        'is-invalid':
                                            errors.fecha_incorporacion,
                                    }"
                                    v-model="maquina.fecha_incorporacion"
                                    clearable
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.fecha_incorporacion"
                                    v-text="errors.fecha_incorporacion[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.cantidad,
                                    }"
                                    >Cantidad</label
                                >

                                <el-input
                                    type="number"
                                    placeholder="Dirección"
                                    :class="{ 'is-invalid': errors.cantidad }"
                                    v-model="maquina.cantidad"
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.cantidad"
                                    v-text="errors.cantidad[0]"
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
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.estado,
                                    }"
                                    >Estado*</label
                                >
                                <el-switch
                                    :class="{
                                        'is-invalid': errors.estado,
                                    }"
                                    style="display: block"
                                    v-model="maquina.estado"
                                    active-color="#13ce66"
                                    inactive-color="#ff4949"
                                    active-text="ACTIVO"
                                    inactive-text="INACTIVO"
                                    active-value="ACTIVO"
                                    inactive-value="INACTIVO"
                                >
                                </el-switch>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.estado"
                                    v-text="errors.estado[0]"
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
        maquina: {
            type: Object,
            default: {
                id: 0,
                codigo: "",
                nombre: "",
                categoria_id: "",
                descripcion: "",
                sucursal_id: "",
                fecha_incorporacion: "",
                cantidad: "",
                foto: null,
                estado: "INACTIVO",
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
            errors: [],
            listCategorias: [],
            listSucursales: [],
        };
    },
    mounted() {
        this.getCategorias();
        this.getSucursales();
        this.bModal = this.muestra_modal;
    },
    methods: {
        getSucursales() {
            axios.get("/admin/sucursals").then((response) => {
                this.listSucursales = response.data.sucursals;
            });
        },
        getCategorias() {
            axios.get("/admin/categorias").then((response) => {
                this.listCategorias = response.data.categorias;
            });
        },
        setRegistroModal() {
            this.enviando = true;
            try {
                this.textoBtn = "Enviando...";
                let url = "/admin/maquinas";
                let config = {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                };
                let formdata = new FormData();
                formdata.append(
                    "codigo",
                    this.maquina.codigo ? this.maquina.codigo : ""
                );
                formdata.append(
                    "nombre",
                    this.maquina.nombre ? this.maquina.nombre : ""
                );
                formdata.append(
                    "categoria_id",
                    this.maquina.categoria_id ? this.maquina.categoria_id : ""
                );
                formdata.append(
                    "descripcion",
                    this.maquina.descripcion ? this.maquina.descripcion : ""
                );
                formdata.append(
                    "sucursal_id",
                    this.maquina.sucursal_id ? this.maquina.sucursal_id : ""
                );
                formdata.append(
                    "fecha_incorporacion",
                    this.maquina.fecha_incorporacion
                        ? this.maquina.fecha_incorporacion
                        : ""
                );
                formdata.append(
                    "cantidad",
                    this.maquina.cantidad ? this.maquina.cantidad : ""
                );
                formdata.append(
                    "foto",
                    this.maquina.foto ? this.maquina.foto : ""
                );
                formdata.append(
                    "estado",
                    this.maquina.estado ? this.maquina.estado : ""
                );

                if (this.accion == "edit") {
                    url = "/admin/maquinas/" + this.maquina.id;
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
                        this.limpiaMaquina();
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
            this.maquina.foto = e.target.files[0];
        },
        // Dialog/modal
        cierraModal() {
            this.bModal = false;
            this.$emit("close");
        },
        limpiaMaquina() {
            this.errors = [];
            this.maquina.codigo = "";
            this.maquina.nombre = "";
            this.maquina.categoria_id = "";
            this.maquina.descripcion = "";
            this.maquina.sucursal_id = "";
            this.maquina.fecha_incorporacion = "";
            this.maquina.cantidad = "";
            this.maquina.foto = null;
            this.maquina.estado = "INACTIVO";
            this.$refs.input_file.value = null;
        },
    },
};
</script>

<style></style>
