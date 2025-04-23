<template>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Evaluación física - <span>Editar</span></h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <FormEvaluacion
                                    :evaluacion_fisica="oEvaluacionFisica"
                                    :accion="'edit'"
                                    @envioFormulario="recargaFormulario()"
                                ></FormEvaluacion>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
<script>
import FormEvaluacion from "./FormEvaluacion.vue";
export default {
    components: {
        FormEvaluacion,
    },
    props: ["id"],
    data() {
        return {
            user: JSON.parse(localStorage.getItem("user")),
            fullscreenLoading: true,
            loadingWindow: Loading.service({
                fullscreen: this.fullscreenLoading,
            }),
            oEvaluacionFisica: {
                id: 0,
                cliente_id: "",
                sucursal_id: "",
                talla: "",
                tipo_sangre: "",
                persona_referencia: "",
                fecha: "",
                peso_inicial: "",
                patologias: "",
                obs_postura: "",
                recomendaciones: "",
                pliegues: {
                    id: 0,
                    evaluacion_id: "",
                    fecha: "",
                    bicipital1: "",
                    bicipital2: "",
                    bicipital3: "",
                    bicipital4: "",
                    tricipital1: "",
                    tricipital2: "",
                    tricipital3: "",
                    tricipital4: "",
                    subescapular1: "",
                    subescapular2: "",
                    subescapular3: "",
                    subescapular4: "",
                    axilar1: "",
                    axilar2: "",
                    axilar3: "",
                    axilar4: "",
                    pectoral1: "",
                    pectoral2: "",
                    pectoral3: "",
                    pectoral4: "",
                    abdominal1: "",
                    abdominal2: "",
                    abdominal3: "",
                    abdominal4: "",
                    supraliaco1: "",
                    supraliaco2: "",
                    supraliaco3: "",
                    supraliaco4: "",
                    muslo1: "",
                    muslo2: "",
                    muslo3: "",
                    muslo4: "",
                    pantorilla1: "",
                    pantorilla2: "",
                    pantorilla3: "",
                    pantorilla4: "",
                    resultado1: "",
                    resultado2: "",
                    resultado3: "",
                    resultado4: "",
                },
                perimetrias: {
                    id: 0,
                    evaluacion_id: "",
                    hombros1: "",
                    hombros2: "",
                    hombros3: "",
                    hombros4: "",
                    pecho1: "",
                    pecho2: "",
                    pecho3: "",
                    pecho4: "",
                    biceps_relajado1: "",
                    biceps_relajado2: "",
                    biceps_relajado3: "",
                    biceps_relajado4: "",
                    biceps_contraido1: "",
                    biceps_contraido2: "",
                    biceps_contraido3: "",
                    biceps_contraido4: "",
                    antebrazo1: "",
                    antebrazo2: "",
                    antebrazo3: "",
                    antebrazo4: "",
                    muneca1: "",
                    muneca2: "",
                    muneca3: "",
                    muneca4: "",
                    cintura1: "",
                    cintura2: "",
                    cintura3: "",
                    cintura4: "",
                    abdomen1: "",
                    abdomen2: "",
                    abdomen3: "",
                    abdomen4: "",
                    cadera1: "",
                    cadera2: "",
                    cadera3: "",
                    cadera4: "",
                    muslo1: "",
                    muslo2: "",
                    muslo3: "",
                    muslo4: "",
                    rodilla1: "",
                    rodilla2: "",
                    rodilla3: "",
                    rodilla4: "",
                    pantorilla1: "",
                    pantorilla2: "",
                    pantorilla3: "",
                    pantorilla4: "",
                    tobillo1: "",
                    tobillo2: "",
                    tobillo3: "",
                    tobillo4: "",
                    resultado1: "",
                    resultado2: "",
                    resultado3: "",
                    resultado4: "",
                },
                imcs: {
                    id: 0,
                    evaluacion_id: "",
                    peso1: "",
                    peso2: "",
                    peso3: "",
                    peso4: "",
                    imc1: "",
                    imc2: "",
                    imc3: "",
                    imc4: "",
                    glicemia1: "",
                    glicemia2: "",
                    glicemia3: "",
                    glicemia4: "",
                    rpm1: "",
                    rpm2: "",
                    rpm3: "",
                    rpm4: "",
                    lpm1: "",
                    lpm2: "",
                    lpm3: "",
                    lpm4: "",
                    oxigeno1: "",
                    oxigeno2: "",
                    oxigeno3: "",
                    oxigeno4: "",
                },
            },
        };
    },
    mounted() {
        this.getEvaluacionFisica();
        this.loadingWindow.close();
        if (this.user.tipo != "GERENTE") {
            this.oEvaluacionFisica.sucursal_id = this.user.sucursal_id;
        }
    },
    methods: {
        recargaFormulario() {
            location.reload();
        },
        getEvaluacionFisica() {
            axios
                .get("/admin/evaluacion_fisicas/" + this.id)
                .then((response) => {
                    this.oEvaluacionFisica = response.data;
                });
        },
    },
};
</script>
<style></style>
