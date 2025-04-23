<template>
    <div class="login-page">
        <div class="login-box">
            <!-- /.login-logo -->
            <div class="card mb-1">
                <div class="card-body text-center">
                    <b class="text-xl text-primary" v-text="empresa"></b>
                    <img :src="logo" alt="Logo" class="logo" />
                </div>
            </div>

            <div class="card border border-primary">
                <div class="card-body">
                    <p
                        class="login-box-msg text-success font-weight-bold text-lg mb-1 pb-1"
                        v-html="nombreSucursal"
                    ></p>
                    <p
                        class="login-box-msg text-success font-weight-bold m-0 text-sm"
                    >
                        INGRESA TU CÓDIGO DE CLIENTE
                    </p>

                    <div>
                        <div
                            class="input-group mb-0"
                            :class="{
                                'is-invalid': errors.rfid,
                            }"
                        >
                            <input
                                type="password"
                                class="form-control"
                                placeholder="Código Cliente"
                                v-model="rfid"
                                @keypress.enter="enviaRfid()"
                                ref="input_rfid"
                                autofocus
                            />
                            <div class="input-group-append">
                                <div class="input-group-text bg-success">
                                    <span class="fas fa-id-card"></span>
                                </div>
                            </div>
                        </div>
                        <span
                            class="error invalid-feedback"
                            v-if="errors.rfid"
                            v-text="errors.rfid[0]"
                        ></span>
                        <div class="row mt-2" v-if="error">
                            <div class="col-12">
                                <div class="callout callout-danger">
                                    <h5>¡Error!</h5>
                                    <p>
                                        El código ingresado no se encuentra en
                                        nuestros registros
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <!-- /.col -->
                            <div class="col-12">
                                <button
                                    type="button"
                                    class="btn btn-success btn-block btn-flat font-weight-bold"
                                    @click.prevent="enviaRfid"
                                    v-loading.fullscreen.lock="
                                        fullscreenLoading
                                    "
                                >
                                    Enviar código
                                </button>
                            </div>
                            <!-- /.col -->
                            <div class="col-12 mt-2">
                                <button
                                    type="button"
                                    class="btn btn-outline-primary btn-block btn-flat font-weight-bold"
                                    @click.prevent="vistaInicio"
                                >
                                    Volver
                                </button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>

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
                        <h4 class="modal-title">Seleccionar ubicación</h4>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                            @click="confirmarUbicacion"
                        >
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label
                                        :class="{
                                            'text-danger': errors.sucursal_id,
                                        }"
                                        >Seleccionar ubicación*</label
                                    >
                                    <el-select
                                        class="w-100 d-block"
                                        :class="{
                                            'is-invalid': errors.sucursal_id,
                                        }"
                                        v-model="sucursal_id"
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
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer justify-content-end">
                        <el-button
                            type="primary"
                            class="bg-red"
                            @click="confirmarUbicacion"
                            >Aceptar</el-button
                        >
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        empresa: { String, default: "Nombre Empresa" },
        logo: {
            String,
            default:
                "https://www.logodesign.net/logo/eye-and-house-5806ld.png?size=2&industry=All",
        },
        configuracion: {
            String,
            default: "",
        },
    },
    data() {
        return {
            rfid: "",
            error: false,
            fullscreenLoading: false,
            listSucursales: [],
            sucursal_id: "",
            bModal: false,
            errors: [],
        };
    },
    computed: {
        nombreSucursal() {
            if (this.sucursal_id != "") {
                return this.listSucursales.filter(
                    (value) => value.id == this.sucursal_id
                )[0].nombre;
            }
            return '<span class="text-red">SIN UBICACIÓN</span>';
        },
    },
    mounted() {
        this.$refs.input_rfid.focus();
        this.getSucursales();
        if (this.sucursal_id == "" || this.sucursal_id == null) {
            this.bModal = true;
        }
    },
    methods: {
        getSucursales() {
            axios.get("/admin/sucursals").then((response) => {
                this.listSucursales = response.data.sucursals;
            });
        },
        enviaRfid() {
            if (this.rfid != "") {
                axios
                    .post("/admin/accesos", {
                        rfid: this.rfid,
                        sucursal_id: this.sucursal_id,
                    })
                    .then((response) => {
                        if (response.data.sw) {
                            Swal.fire({
                                icon: "success",
                                title: response.data.accion,
                                html: `${response.data.img} <br/> ${response.data.msj}`,
                                showConfirmButton: false,
                                timer: 10000,
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                html: response.data.msj,
                                showConfirmButton: false,
                                timer: 10000,
                            });
                        }
                        this.rfid = "";
                        this.$refs.input_rfid.focus();
                    })
                    .catch((error) => {
                        if (error.response) {
                            if (error.response.status === 422) {
                                this.errors = error.response.data.errors;
                                if (this.errors.rfid) {
                                    // this.rfid = "";
                                    this.$refs.input_rfid.focus();
                                    this.$refs.input_rfid.select();
                                }
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
                                    timer: 2000,
                                });
                            }
                        }
                    });
            } else {
            }
        },
        vistaInicio() {
            window.location = "/";
        },
        confirmarUbicacion() {
            if (this.sucursal_id != "") {
                this.bModal = false;
                this.$refs.input_rfid.focus();
            } else {
                Swal.fire({
                    icon: "info",
                    title: "Atención",
                    text: "Selecciona la ubicación",
                    showConfirmButton: false,
                    timer: 1800,
                });
            }
        },
    },
};


</script>

<style>
.login-page {
    background: #9e9e9e;
}

.login-page .card {
    border-radius: 0px;
    box-shadow: 0px 5px 10px 10px var(--secundario);
}
.login-page .card-header {
    border-bottom: solid 1px var(--principal);
}

.logo {
    max-width: 100%;
}

.swal2-html-container img {
    width: 90px;
    height: 90px;
    border-radius: 50%;
}
</style>
