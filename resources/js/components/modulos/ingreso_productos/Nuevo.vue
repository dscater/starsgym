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
                                        'text-danger': errors.sucursal_id,
                                    }"
                                    >Seleccionar sucursal*</label
                                >
                                <el-select
                                    class="w-full d-block"
                                    :class="{
                                        'is-invalid': errors.sucursal_id,
                                    }"
                                    v-model="ingreso_producto.sucursal_id"
                                    clearable
                                    @change="getProductos()"
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
                                        'text-danger': errors.producto_id,
                                    }"
                                    >Seleccionar producto*</label
                                >
                                <el-select
                                    class="w-full d-block"
                                    :class="{
                                        'is-invalid': errors.producto_id,
                                    }"
                                    v-model="ingreso_producto.producto_id"
                                    clearable
                                >
                                    <el-option
                                        v-for="item in listProductos"
                                        :key="item.id"
                                        :value="item.id"
                                        :label="item.nombre"
                                    >
                                    </el-option>
                                </el-select>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.producto_id"
                                    v-text="errors.producto_id[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.cantidad,
                                    }"
                                    >Cantidad de ingreso*</label
                                >
                                <el-input
                                    type="number"
                                    placeholder="Cantidad de ingreso"
                                    :class="{ 'is-invalid': errors.cantidad }"
                                    v-model="ingreso_producto.cantidad"
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
                                        'text-danger': errors.fecha_ingreso,
                                    }"
                                    >Fecha de ingreso*</label
                                >

                                <el-input
                                    type="date"
                                    :class="{
                                        'is-invalid': errors.fecha_ingreso,
                                    }"
                                    v-model="ingreso_producto.fecha_ingreso"
                                    readonly
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.fecha_ingreso"
                                    v-text="errors.fecha_ingreso[0]"
                                ></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label
                                    :class="{
                                        'text-danger': errors.fecha_vencimiento,
                                    }"
                                    >Fecha de vencimiento</label
                                >

                                <el-input
                                    type="date"
                                    :class="{
                                        'is-invalid': errors.fecha_vencimiento,
                                    }"
                                    v-model="ingreso_producto.fecha_vencimiento"
                                >
                                </el-input>
                                <span
                                    class="error invalid-feedback"
                                    v-if="errors.fecha_vencimiento"
                                    v-text="errors.fecha_vencimiento[0]"
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
        ingreso_producto: {
            type: Object,
            default: {
                id: 0,
                sucursal_id: "",
                producto_id: "",
                cantidad: "",
                fecha_ingreso: "",
                fecha_vencimiento: "",
            },
        },
    },
    watch: {
        muestra_modal: function (newVal, oldVal) {
            this.errors = [];
            if (newVal) {
                this.getProductos();
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
            listProductos: [],
            listSucursales: [],
        };
    },
    mounted() {
        this.getSucursales();
        this.getProductos();
        this.bModal = this.muestra_modal;
    },
    methods: {
        getSucursales() {
            axios.get("/admin/sucursals").then((response) => {
                this.listSucursales = response.data.sucursals;
            });
        },
        getProductos() {
            if (this.ingreso_producto.sucursal_id != "") {
                axios
                    .get("/admin/productos/productos_sucursal", {
                        params: {
                            id: this.ingreso_producto.sucursal_id,
                        },
                    })
                    .then((response) => {
                        if (response.data.length > 0) {
                            this.listProductos = response.data;
                        } else {
                            this.listProductos = [];
                            this.ingreso_producto.producto_id = "";
                        }
                    });
            } else {
                this.listProductos = [];
            }
        },
        setRegistroModal() {
            this.enviando = true;
            try {
                this.textoBtn = "Enviando...";
                let url = "/admin/ingreso_productos";
                let config = {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                };
                let formdata = new FormData();
                formdata.append(
                    "sucursal_id",
                    this.ingreso_producto.sucursal_id
                        ? this.ingreso_producto.sucursal_id
                        : ""
                );
                formdata.append(
                    "producto_id",
                    this.ingreso_producto.producto_id
                        ? this.ingreso_producto.producto_id
                        : ""
                );
                formdata.append(
                    "cantidad",
                    this.ingreso_producto.cantidad
                        ? this.ingreso_producto.cantidad
                        : ""
                );
                formdata.append(
                    "fecha_ingreso",
                    this.ingreso_producto.fecha_ingreso
                        ? this.ingreso_producto.fecha_ingreso
                        : ""
                );
                formdata.append(
                    "fecha_vencimiento",
                    this.ingreso_producto.fecha_vencimiento
                        ? this.ingreso_producto.fecha_vencimiento
                        : ""
                );
                if (this.accion == "edit") {
                    url =
                        "/admin/ingreso_productos/" + this.ingreso_producto.id;
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
                        this.limpiaIngresoProducto();
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
        // Dialog/modal
        cierraModal() {
            this.bModal = false;
            this.$emit("close");
        },
        limpiaIngresoProducto() {
            this.errors = [];
            this.ingreso_producto.sucursal_id = "";
            this.ingreso_producto.producto_id = "";
            this.ingreso_producto.cantidad = "";
            this.ingreso_producto.fecha_ingreso = "";
            this.ingreso_producto.fecha_vencimiento = "";
        },
    },
};
</script>

<style></style>
