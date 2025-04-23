<template>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row" v-if="configuracion">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h2
                                    style="
                                        font-weight: bold;
                                        text-align: center;
                                    "
                                >
                                    APLICACIÓN WEB {{ configuracion.nombre_sistema }}
                                </h2>
                                <h3 style="text-align: center">
                                    ¡BIENVENID@ {{ user.full_name }}!
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div
                        class="col-12 col-sm-6 col-md-3"
                        v-for="(item, index) in listInfoBox"
                        :key="index"
                    >
                        <div class="info-box">
                            <span
                                class="info-box-icon elevation-1"
                                :class="item.color"
                                ><i :class="item.icon"></i
                            ></span>
                            <div class="info-box-content">
                                <span class="info-box-text">{{
                                    item.label
                                }}</span>
                                <span class="info-box-number">{{
                                    item.cantidad
                                }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-12">
                    <div class="image-container">
                    <img :src="imagePath">
                    </div>
                </div>
            </div>

            
            <!-- /.container-fluid -->
        </section>
    </div>
</template>

<script>
export default {
    data() {
        return {
            imagePath: '/imgs/fondo.png',
            fullscreenLoading: true,
            loadingWindow: Loading.service({
                fullscreen: this.fullscreenLoading,
            }),
            usuarios: 10,
            configuracion: JSON.parse(localStorage.getItem("configuracion")),
            user: JSON.parse(localStorage.getItem("user")),
            listInfoBox: [],
            htmlMision: "",
            htmlVision: "",
            htmlObjetivos: "",
        };
    },
    mounted() {
        this.getInfoBox();
    },
    methods: {
        getInfoBox() {
            axios.get("/admin/usuarios/getInfoBox").then((res) => {
                this.listInfoBox = res.data;
                this.loadingWindow.close();
            });
        },
    },
};
</script>


</script>

<style scoped>
.image-container img {
  width: 100%;
  height: auto;
  object-fit: cover;
}
</style>

<style>
.card-body{
    background: var(--secundario) !important;
}
</style>

<style>
.card-header{
    background: var(--secundario) !important;
}
</style>

<style>
.modal-body{
    background: var(--secundario) !important;
}
</style>
