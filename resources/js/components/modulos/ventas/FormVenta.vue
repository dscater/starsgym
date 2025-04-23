<template>
    <div class="row">
        <div class="col-md-12">
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
                            >Seleccionar sucursal</label
                        >
                        <el-select
                            class="w-full d-block"
                            :class="{
                                'is-invalid': errors.sucursal_id,
                            }"
                            v-model="venta.sucursal_id"
                            clearable
                            @change="
                                getClientes();
                                getProductos();
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
                    <div
                        class="form-group"
                        :class="{
                            'col-md-6': user.tipo == 'GERENTE',
                            'col-md-12': user.tipo != 'GERENTE',
                        }"
                    >
                        <label
                            :class="{
                                'text-danger': errors.cliente_id,
                            }"
                            >Seleccionar cliente</label
                        >
                        <el-select
                            class="w-full d-block"
                            :class="{ 'is-invalid': errors.cliente_id }"
                            v-model="venta.cliente_id"
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
                </div>
                <hr />
                <div class="row">
                    <div class="col-md-12 contenedor_tabla">
                        <h5 class="w-100 text-center">AGREGAR PRODUCTOS</h5>
                    </div>

                    <div class="form-group col-md-6">
                        <label
                            :class="{
                                'text-danger': errors.producto_id,
                            }"
                            >Seleccionar producto</label
                        >
                        <el-select
                            class="w-full d-block"
                            :class="{
                                'is-invalid': errors.producto_id,
                            }"
                            v-model="producto_id"
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
                            >Cantidad</label
                        >
                        <input
                            type="number"
                            class="form-control"
                            :class="{ 'is-invalid': errors.cantidad }"
                            v-model="cantidad"
                        />
                        <span
                            class="error invalid-feedback"
                            v-if="errors.cantidad"
                            v-text="errors.cantidad[0]"
                        ></span>
                    </div>
                    <div class="col-md-12">
                        <button
                            class="btn btn-primary btn-flat btn-block"
                            :disabled="
                                cantidad <= 0 ||
                                cantidad == '' ||
                                producto_id == ''
                            "
                            @click.prevent="validaStock()"
                        >
                            <i class="fa fa-plus"></i> Agregar producto
                        </button>
                    </div>
                </div>
                <hr />
                <div class="row">
                    <div class="col-md-12 contenedor_tabla">
                        <h5 class="w-100 text-center">DETALLE DE LA VENTA</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Producto</th>
                                    <th>Precio Unitario</th>
                                    <th>Cantidad</th>
                                    <th>Subtotal</th>
                                    <th width="5px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-if="venta.detalle_ventas.length > 0"
                                    v-for="(
                                        item, index
                                    ) in venta.detalle_ventas"
                                >
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ item.producto.nombre }}</td>
                                    <td>{{ item.precio }}</td>
                                    <td>{{ item.cantidad }}</td>
                                    <td>{{ item.subtotal }}</td>
                                    <td>
                                        <button
                                            class="btn-sm btn-flat btn-danger"
                                            @click.prevent="
                                                quitarDetalleVenta(
                                                    item.id,
                                                    index
                                                )
                                            "
                                        >
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr v-if="venta.detalle_ventas.length == 0">
                                    <td
                                        colspan="6"
                                        class="text-center text-gray font-weight-bold"
                                    >
                                        NO SE AGREGÓ NINGUN PRODUCTO
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot class="bg-dark">
                                <tr>
                                    <td colspan="4">TOTAL</td>
                                    <td>{{ venta.total }}</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer justify-content-between">
            <el-button
                type="primary"
                class="bg-red"
                :loading="enviando"
                @click="enviarFormulario()"
                v-html="textoBoton"
                :disabled="venta.detalle_ventas.length <= 0"
            ></el-button>

            <el-button
                v-if="this.venta.id != 0"
                type="success"
                :loading="enviando"
                @click="generaReporte()"
                ><i class="fa fa-file-pdf"></i> Exportar</el-button
            >

            <router-link
                :to="{ name: 'ventas.create' }"
                v-if="this.venta.id != 0"
                class="btn btn-danger btn-lg"
                ><i class="fa fa-plus"></i> Realizar otra venta</router-link
            >

            <router-link
                :to="{ name: 'ventas.index' }"
                class="btn btn-default btn-lg"
                ><i class="fa fa-cash-register"></i> Volver a
                ventas</router-link
            >
        </div>
    </div>
</template>

<script>
export default {
    props: {
        accion: {
            type: String,
            default: "nuevo",
        },
        venta: {
            type: Object,
            default() {
                return {
                    id: 0,
                    sucursal_id: "",
                    cliente_id: "",
                    total: "0.00",
                    fecha: "",
                    detalle_ventas: [],
                };
            },
        },
    },
    watch: {
        venta(newVal, oldVal) {
            if (newVal.id != 0) {
                this.getClientes();
                this.getProductos();
            }
        },
    },
    computed: {
        textoBoton() {
            if (this.accion == "nuevo") {
                return '<i class="fa fa-save"></i> Registrar';
            } else {
                return '<i class="fa fa-edit"></i> Actualizar';
            }
        },
    },
    data() {
        return {
            user: JSON.parse(localStorage.getItem("user")),
            enviando: false,
            producto_id: "",
            cantidad: 1,
            errors: [],
            listClientes: [],
            listProductos: [],
            listSucursales: [],
            eliminados: [],
        };
    },
    mounted() {
        this.getSucursales();
        if (this.venta.id == 0) {
            this.venta.fecha = this.fechaActual();
        }
        if (this.user.tipo != "GERENTE") {
            this.venta.sucursal_id = this.user.sucursal_id;
        }
        this.getClientes();
        this.getProductos();
        this.iniciaSeleccionFilas();
    },
    methods: {
        // OBTENER LISTADOS E INFORMACIÓN
        getSucursales() {
            axios.get("/admin/sucursals").then((response) => {
                this.listSucursales = response.data.sucursals;
            });
        },
        getClientes() {
            if (this.venta.sucursal_id != "") {
                axios
                    .get("/admin/clientes/clientes_sucursal", {
                        params: {
                            id: this.venta.sucursal_id,
                        },
                    })
                    .then((response) => {
                        this.listClientes = response.data;
                    });
            } else {
                this.listClientes = [];
            }
        },
        getProductos() {
            if (this.venta.sucursal_id != "") {
                axios
                    .get("/admin/productos/productos_sucursal", {
                        params: {
                            id: this.venta.sucursal_id,
                        },
                    })
                    .then((response) => {
                        if (response.data.length > 0) {
                            this.listProductos = response.data;
                        } else {
                            this.listProductos = [];
                            this.producto_id = "";
                        }
                    });
            } else {
                this.listProductos = [];
            }
        },
        // ENVIAR REGISTRO
        enviarFormulario() {
            this.enviando = true;
            try {
                this.textoBtn = "Enviando...";
                let url = "/admin/ventas";
                if (this.accion == "edit") {
                    url = "/admin/ventas/" + this.venta.id;
                    this.venta["_method"] = "PUT";
                    this.venta.eliminados = this.eliminados;
                }
                axios
                    .post(url, this.venta)
                    .then((res) => {
                        this.enviando = false;
                        if (res.data.sw) {
                            Swal.fire({
                                icon: "success",
                                title: res.data.msj,
                                showConfirmButton: false,
                                timer: 2000,
                            });
                            this.$emit("envioFormulario", res.data.id);
                            this.errors = [];
                            if (this.accion == "edit") {
                                this.textoBtn = "Actualizar";
                            } else {
                                this.textoBtn = "Registrar";
                            }
                        } else {
                            Swal.fire({
                                icon: "info",
                                title: "Atención",
                                html: res.data.msj,
                                showConfirmButton: false,
                                timer: 2000,
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
                            if (
                                error.response.status === 420 ||
                                error.response.status === 419 ||
                                error.response.status === 401
                            ) {
                                window.location = "/";
                            }

                            if (error.response.status === 422) {
                                this.errors = error.response.data.errors;
                                Swal.fire({
                                    icon: "error",
                                    title: "Error",
                                    html: "Tienes errores en el formulario<br>",
                                    showConfirmButton: false,
                                    timer: 2000,
                                });
                            } else {
                                if (error.response.status === 500) {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Error",
                                        html: error.response.data.message,
                                        showConfirmButton: false,
                                        timer: 3000,
                                    });
                                } else {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Error",
                                        text: "Ocurrió un error durante el registro intenté nuevamente por favor",
                                        showConfirmButton: false,
                                        timer: 2000,
                                    });
                                }
                            }
                        }
                    });
            } catch (e) {
                this.enviando = false;
                console.log(e);
            }
        },
        limpiaVenta() {
            this.errors = [];
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
        iniciaSeleccionFilas() {
            $(".detalle_venta").on("focusin", "input", function () {
                $(this).parents("tr").addClass("seleccionado");
            });
            $(".detalle_venta").on("focusout", "input", function () {
                $(this).parents("tr").removeClass("seleccionado");
            });
        },
        generaReporte() {
            this.enviando = true;
            let config = {
                responseType: "blob",
            };
            axios
                .post("/admin/ventas/pdf/" + this.venta.id, null, config)
                .then((res) => {
                    this.errors = [];
                    this.enviando = false;
                    let pdfBlob = new Blob([res.data], {
                        type: "application/pdf",
                    });
                    let urlReporte = URL.createObjectURL(pdfBlob);
                    window.open(urlReporte);
                    this.enviando = false;
                })
                .catch(async (error) => {
                    let responseObj = await error.response.data.text();
                    responseObj = JSON.parse(responseObj);
                    this.enviando = false;
                    if (error.response) {
                        if (error.response.status == 422)
                            this.errors = responseObj.errors;
                    }
                    this.enviando = false;
                });
        },
        validaStock() {
            let existe = this.venta.detalle_ventas.find(
                (elem) => elem.producto_id == this.producto_id
            );
            let cantidad_vender = this.cantidad;
            if (existe) {
                cantidad_vender =
                    parseFloat(existe.cantidad) + parseFloat(this.cantidad);
            }

            console.log(cantidad_vender);
            axios
                .get("/admin/productos/valida_stock", {
                    params: {
                        id: this.producto_id,
                        cantidad: cantidad_vender,
                    },
                })
                .then((response) => {
                    if (response.data.sw) {
                        let subtotal =
                            parseFloat(this.cantidad) *
                            parseFloat(response.data.producto.precio);
                        if (existe) {
                            existe.cantidad =
                                parseFloat(existe.cantidad) +
                                parseFloat(this.cantidad);
                            subtotal =
                                parseFloat(existe.cantidad) *
                                parseFloat(response.data.producto.precio);
                            existe.subtotal = subtotal.toFixed(2);
                        } else {
                            this.venta.detalle_ventas.push({
                                id: 0,
                                venta_id: 0,
                                producto_id: response.data.producto.id,
                                cantidad: this.cantidad,
                                precio: response.data.producto.precio,
                                subtotal: subtotal.toFixed(2),
                                producto: response.data.producto,
                            });
                        }

                        this.sumaTotalVenta();
                        this.producto_id = "";
                        this.cantidad = 1;
                    } else {
                        Swal.fire({
                            icon: "info",
                            title: "ATENCIÓN",
                            html: response.data.msj,
                            showConfirmButton: false,
                            timer: 3500,
                        });
                    }
                });
        },
        sumaTotalVenta() {
            let suma_total = 0;
            this.venta.detalle_ventas.forEach((elem) => {
                suma_total += parseFloat(elem.subtotal);
            });
            this.venta.total = suma_total.toFixed(2);
        },
        quitarDetalleVenta(id, index) {
            if (id) {
                this.eliminados.push(id);
            }
            this.venta.detalle_ventas.splice(index, 1);
            this.sumaTotalVenta();
        },
    },
};
</script>

<style>
.detalle_venta tbody tr td {
    padding: 0px;
    vertical-align: middle;
}

.detalle_venta tbody tr td:nth-child(1) {
    padding-left: 5px;
}

.contenedor_tabla {
    overflow: auto;
}
</style>
