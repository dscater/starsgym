<template>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Mantenimiento de Maquinas - Calendario</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <!-- <div class="col-md-3">
                                        <button
                                            v-if="
                                                permisos.includes(
                                                    'mantenimiento_maquinas.create'
                                                )
                                            "
                                            class="btn btn-outline-primary bg-red btn-flat btn-block"
                                            @click="
                                                abreModal('nuevo');
                                                limpiaMantenimientoMaquina();
                                            "
                                        >
                                            <i class="fa fa-plus"></i>
                                            Nuevo
                                        </button>
                                    </div> -->
                                    <div class="col-md-3">
                                        <router-link
                                            :to="{
                                                name: 'mantenimiento_maquinas.index',
                                            }"
                                            class="btn btn-outline-success bg-light btn-flat btn-block"
                                        >
                                            <i class="fa fa-list"></i>
                                            Ver lista
                                        </router-link>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <FullCalendar
                                            ref="calendar"
                                            :options="calendarOptions"
                                            style="
                                                width: 100%;
                                                min-height: 500px;
                                            "
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <Nuevo
            :muestra_modal="muestra_modal"
            :accion="modal_accion"
            :mantenimiento_maquina="oMantenimientoMaquina"
            @close="muestra_modal = false"
            @envioModal="getMantenimientoMaquinas"
        ></Nuevo>
    </div>
</template>

<script>
import Nuevo from "./Nuevo.vue";
import FullCalendar from "@fullcalendar/vue";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";
import esLocale from "@fullcalendar/core/locales/es";

export default {
    components: {
        Nuevo,
        FullCalendar,
    },
    computed: {
        calendarOptions() {
            return {
                plugins: [dayGridPlugin, interactionPlugin],
                initialView: "dayGridMonth",
                weekends: true,
                events: this.listRegistros,
                initialDate: null, // Set the default start date of the calendar (YYYY-MM-DD)
                // editable: true, // Enable event dragging and resizing
                // eventDrop: this.eventDrop,
                eventClick: this.handleEventClick,
                locale: esLocale,
                headerToolbar: {
                    start: "", // Dejar en blanco para ocultar los botones de navegación
                    center: "title",
                    end: "prev today next", // Dejar en blanco para ocultar el botón "Hoy"
                },
                customButtons: {
                    todayButton: {
                        text: "Hoy",
                        click: function () {
                            // Acción personalizada para el botón "Hoy" (opcional)
                        },
                    },
                },
                scrollTime: this.getFechaActual(),
            };
        },
    },
    data() {
        return {
            permisos: localStorage.getItem("permisos"),
            user: JSON.parse(localStorage.getItem("user")),
            listRegistros: [],
            fullscreenLoading: true,
            loadingWindow: Loading.service({
                fullscreen: this.fullscreenLoading,
            }),
            muestra_modal: false,
            modal_accion: "nuevo",
            oMantenimientoMaquina: {
                id: 0,
                sucursal_id: "",
                maquina_id: "",
                fecha_mantenimiento: "",
                descripcion: "",
                fecha_proximo: "",
            },
        };
    },
    mounted() {
        this.loadingWindow.close();
        this.getMantenimientoMaquinas();
    },
    methods: {
        getFechaActual() {
            return this.$moment().format("YYYY-MM-DD");
        },
        // Listar MantenimientoMaquinas
        getMantenimientoMaquinas() {
            this.showOverlay = true;
            this.muestra_modal = false;
            let url = "/admin/mantenimiento_maquinas/fechas_sugeridas";
            if (this.pagina != 0) {
                url += "?page=" + this.pagina;
            }
            axios
                .get(url, {
                    params: { per_page: this.per_page },
                })
                .then((response) => {
                    this.showOverlay = false;
                    const registros = response.data.mantenimiento_maquinas;
                    this.listRegistros = registros.map((registro) => {
                        return {
                            id: registro.id, // Título del evento
                            title:
                                registro.maquina.nombre +
                                " - " +
                                registro.maquina.sucursal.nombre, // Título del evento
                            start: registro.fecha_proximo, // Fecha de inicio del evento
                            backgroundColor:
                                registro.estado == "PROGRAMADO"
                                    ? "#3788d8"
                                    : "#1f2d3d",
                        };
                    });

                    const calendar = this.$refs.calendar.getApi();
                    calendar.removeAllEvents(); // Elimina los eventos actuales
                    calendar.addEventSource(this.listRegistros); // Agrega los nuevos eventos
                });
        },
        formatoFecha(date) {
            return this.$moment(String(date)).format("DD/MM/YYYY");
        },
    },
};
</script>

<style>
.fc-event-title {
    text-wrap: wrap!important;
}
</style>
