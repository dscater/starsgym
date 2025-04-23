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
                                    class="w-100 d-block"
                                    :class="{
                                        'is-invalid': errors.sucursal_id,
                                    }"
                                    v-model="mantenimiento_maquina.sucursal_id"
                                    @change="getMaquinas"
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
                                        'text-danger': errors.maquina_id,
                                    }"
                                    >Seleccionar Maquina*</label
                                >
                                <el-select
                                    class="w-100 d-block"
                                    :class="{
                                        'is-invalid': errors.maquina_id,
                                    }"
                                    v-model="mantenimiento_maquina.maquina_id"
                                    clearable
                                >
                                    <el-option
                                        v-for="item in listMaquinas"
                                        :key="item.id"
                                        :value="item.id"
                                        :label="item.nombre"
                                    >
                                    </el-option>
                                </el-select>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.maquina_id"
                                    v-text="errors.maquina_id[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger':
                                            errors.fecha_mantenimiento,
                                    }"
                                    >Fecha de Mantenimiento</label
                                >
                                <el-input
                                    type="date"
                                    :class="{
                                        'is-invalid':
                                            errors.fecha_mantenimiento,
                                    }"
                                    v-model="
                                        mantenimiento_maquina.fecha_mantenimiento
                                    "
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.fecha_mantenimiento"
                                    v-text="errors.fecha_mantenimiento[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-12">
                                <label
                                    :class="{
                                        'text-danger': errors.descripcion,
                                    }"
                                    >Descripción de Mantenimiento
                                    realizado</label
                                >
                                <el-input
                                    type="textarea"
                                    autosize
                                    placeholder="Dirección"
                                    :class="{
                                        'is-invalid': errors.descripcion,
                                    }"
                                    v-model="mantenimiento_maquina.descripcion"
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
                                        'text-danger': errors.fecha_proximo,
                                    }"
                                    >Fecha sugerida para próximo
                                    mantenimiento</label
                                >

                                <el-input
                                    type="date"
                                    placeholder="Dirección"
                                    :class="{
                                        'is-invalid': errors.fecha_proximo,
                                    }"
                                    v-model="
                                        mantenimiento_maquina.fecha_proximo
                                    "
                                    clearable
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.fecha_proximo"
                                    v-text="errors.fecha_proximo[0]"
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
        mantenimiento_maquina: {
            type: Object,
            default: {
                id: 0,
                sucursal_id: "",
                maquina_id: "",
                fecha_mantenimiento: "",
                descripcion: "",
                fecha_proximo: "",
            },
        },
    },
    watch: {
        muestra_modal: function (newVal, oldVal) {
            this.errors = [];
            this.getMaquinas();
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
            listMaquinas: [],
            listSucursales: [],
        };
    },
    mounted() {
        this.getMaquinas();
        this.getSucursales();
        this.bModal = this.muestra_modal;
    },
    methods: {
        getSucursales() {
            axios.get("/admin/sucursals").then((response) => {
                this.listSucursales = response.data.sucursals;
            });
        },
        getMaquinas() {
            axios
                .get("/admin/maquinas/maquinas_sucursal", {
                    params: {
                        id: this.mantenimiento_maquina.sucursal_id,
                    },
                })
                .then((response) => {
                    this.listMaquinas = response.data;
                });
        },
        setRegistroModal() {
            this.enviando = true;
            try {
                this.textoBtn = "Enviando...";
                let url = "/admin/mantenimiento_maquinas";
                let config = {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                };
                let formdata = new FormData();
                formdata.append(
                    "sucursal_id",
                    this.mantenimiento_maquina.sucursal_id
                        ? this.mantenimiento_maquina.sucursal_id
                        : ""
                );
                formdata.append(
                    "maquina_id",
                    this.mantenimiento_maquina.maquina_id
                        ? this.mantenimiento_maquina.maquina_id
                        : ""
                );
                formdata.append(
                    "fecha_mantenimiento",
                    this.mantenimiento_maquina.fecha_mantenimiento
                        ? this.mantenimiento_maquina.fecha_mantenimiento
                        : ""
                );
                formdata.append(
                    "descripcion",
                    this.mantenimiento_maquina.descripcion
                        ? this.mantenimiento_maquina.descripcion
                        : ""
                );
                formdata.append(
                    "fecha_proximo",
                    this.mantenimiento_maquina.fecha_proximo
                        ? this.mantenimiento_maquina.fecha_proximo
                        : ""
                );

                if (this.accion == "edit") {
                    url =
                        "/admin/mantenimiento_maquinas/" +
                        this.mantenimiento_maquina.id;
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
                        this.limpiaMantenimientoMaquina();

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
            this.mantenimiento_maquina.foto = e.target.files[0];
        },
        // Dialog/modal
        cierraModal() {
            this.bModal = false;
            this.$emit("close");
        },
        limpiaMantenimientoMaquina() {
            this.errors = [];
            this.mantenimiento_maquina.sucursal_id = "";
            this.mantenimiento_maquina.maquina_id = "";
            this.mantenimiento_maquina.fecha_mantenimiento = "";
            this.mantenimiento_maquina.descripcion = "";
            this.mantenimiento_maquina.fecha_proximo = "";
        },
    },
};
</script>

<style></style>
