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
                            v-model="evaluacion_fisica.sucursal_id"
                            clearable
                            @change="getClientes()"
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
                                'text-danger': errors.cliente_id,
                            }"
                            >Seleccionar cliente</label
                        >
                        <el-select
                            class="w-full d-block"
                            :class="{ 'is-invalid': errors.cliente_id }"
                            v-model="evaluacion_fisica.cliente_id"
                            clearable
                            @change="getInfoCliente()"
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
                    <div class="form-group col-md-6">
                        <label
                            :class="{
                                'text-danger': errors.genero,
                            }"
                            >Sexo</label
                        >
                        <el-input
                            placeholder="Sexo"
                            class="readonly"
                            :class="{ 'is-invalid': errors.genero }"
                            v-model="oCliente.genero"
                            readonly
                        >
                        </el-input>
                        <span
                            class="error invalid-feedback"
                            v-if="errors.genero"
                            v-text="errors.genero[0]"
                        ></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label
                            :class="{
                                'text-danger': errors.fecha_nacimiento,
                            }"
                            >Fecha de nacimiento</label
                        >
                        <el-input
                            type="date"
                            class="readonly"
                            :class="{ 'is-invalid': errors.fecha_nacimiento }"
                            v-model="oCliente.fecha_nacimiento"
                            readonly
                        >
                        </el-input>
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
                            >Edad</label
                        >
                        <el-input
                            placeholder="Edad"
                            class="readonly"
                            :class="{ 'is-invalid': errors.edad }"
                            v-model="oCliente.edad"
                            readonly
                        >
                        </el-input>
                        <span
                            class="error invalid-feedback"
                            v-if="errors.edad"
                            v-text="errors.edad[0]"
                        ></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label
                            :class="{
                                'text-danger': errors.talla,
                            }"
                            >Talla</label
                        >
                        <el-input
                            placeholder="Talla"
                            :class="{ 'is-invalid': errors.talla }"
                            v-model="evaluacion_fisica.talla"
                        >
                        </el-input>
                        <span
                            class="error invalid-feedback"
                            v-if="errors.talla"
                            v-text="errors.talla[0]"
                        ></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label
                            :class="{
                                'text-danger': errors.peso_inicial,
                            }"
                            >Peso inicial</label
                        >
                        <el-input
                            placeholder="Peso inicial"
                            :class="{ 'is-invalid': errors.peso_inicial }"
                            v-model="evaluacion_fisica.peso_inicial"
                        >
                        </el-input>
                        <span
                            class="error invalid-feedback"
                            v-if="errors.peso_inicial"
                            v-text="errors.peso_inicial[0]"
                        ></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label
                            :class="{
                                'text-danger': errors.tipo_sangre,
                            }"
                            >Tipo de sangre</label
                        >
                        <el-input
                            placeholder="Tipo de sangre"
                            :class="{ 'is-invalid': errors.tipo_sangre }"
                            v-model="evaluacion_fisica.tipo_sangre"
                        >
                        </el-input>
                        <span
                            class="error invalid-feedback"
                            v-if="errors.tipo_sangre"
                            v-text="errors.tipo_sangre[0]"
                        ></span>
                    </div>
                    <div class="form-group col-md-6">
                        <label
                            :class="{
                                'text-danger': errors.correo,
                            }"
                            >E-mail</label
                        >
                        <el-input
                            placeholder="E-mail"
                            class="readonly"
                            :class="{ 'is-invalid': errors.correo }"
                            v-model="oCliente.correo"
                            readonly
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
                                'text-danger': errors.persona_referencia,
                            }"
                            >Persona de Referencia</label
                        >
                        <el-input
                            placeholder="Persona de Referencia"
                            :class="{ 'is-invalid': errors.persona_referencia }"
                            v-model="evaluacion_fisica.persona_referencia"
                        >
                        </el-input>
                        <span
                            class="error invalid-feedback"
                            v-if="errors.persona_referencia"
                            v-text="errors.persona_referencia[0]"
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
                            class="readonly"
                            :class="{ 'is-invalid': errors.fono }"
                            v-model="oCliente.fono"
                            readonly
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
                                'text-danger': errors.fono2,
                            }"
                            >Teléfono</label
                        >
                        <el-input
                            placeholder="Teléfono"
                            class="readonly"
                            :class="{ 'is-invalid': errors.fono2 }"
                            v-model="oCliente.fono2"
                            readonly
                        >
                        </el-input>
                        <span
                            class="error invalid-feedback"
                            v-if="errors.fono2"
                            v-text="errors.fono2[0]"
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
                            class="readonly"
                            :class="{ 'is-invalid': errors.dir }"
                            v-model="oCliente.dir"
                            readonly
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
                                'text-danger': errors.fecha,
                            }"
                            >Fecha</label
                        >
                        <el-input
                            type="date"
                            :class="{ 'is-invalid': errors.fecha }"
                            v-model="evaluacion_fisica.fecha"
                        >
                        </el-input>
                        <span
                            class="error invalid-feedback"
                            v-if="errors.fecha"
                            v-text="errors.fecha[0]"
                        ></span>
                    </div>
                </div>
                <hr />
                <div class="row">
                    <div class="col-md-12 contenedor_tabla">
                        <h5 class="w-100 text-center">
                            MEDIDAS ANTROPOMÉTRICAS
                        </h5>
                        <table class="table table-bordered mediciones">
                            <thead>
                                <tr>
                                    <th>Pliegues cutáneos</th>
                                    <th>1M</th>
                                    <th>2M</th>
                                    <th>3M</th>
                                    <th>4M</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Fecha:</td>
                                    <td colspan="4">
                                        <input
                                            type="date"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.pliegues.fecha
                                            "
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Bicipital</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.pliegues
                                                    .bicipital1
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.pliegues
                                                    .bicipital2
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.pliegues
                                                    .bicipital3
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.pliegues
                                                    .bicipital4
                                            "
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tricipital</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.pliegues
                                                    .tricipital1
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.pliegues
                                                    .tricipital2
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.pliegues
                                                    .tricipital3
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.pliegues
                                                    .tricipital4
                                            "
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Subescapular</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.pliegues
                                                    .subescapular1
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.pliegues
                                                    .subescapular2
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.pliegues
                                                    .subescapular3
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.pliegues
                                                    .subescapular4
                                            "
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Axilar</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.pliegues
                                                    .axilar1
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.pliegues
                                                    .axilar2
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.pliegues
                                                    .axilar3
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.pliegues
                                                    .axilar4
                                            "
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Pectoral</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.pliegues
                                                    .pectoral1
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.pliegues
                                                    .pectoral2
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.pliegues
                                                    .pectoral3
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.pliegues
                                                    .pectoral4
                                            "
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Abdominal</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.pliegues
                                                    .abdominal1
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.pliegues
                                                    .abdominal2
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.pliegues
                                                    .abdominal3
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.pliegues
                                                    .abdominal4
                                            "
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Supraliaco</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.pliegues
                                                    .supraliaco1
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.pliegues
                                                    .supraliaco2
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.pliegues
                                                    .supraliaco3
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.pliegues
                                                    .supraliaco4
                                            "
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Muslo</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.pliegues
                                                    .muslo1
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.pliegues
                                                    .muslo2
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.pliegues
                                                    .muslo3
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.pliegues
                                                    .muslo4
                                            "
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Pantorilla</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.pliegues
                                                    .pantorilla1
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.pliegues
                                                    .pantorilla2
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.pliegues
                                                    .pantorilla3
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.pliegues
                                                    .pantorilla4
                                            "
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Resultado</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.pliegues
                                                    .resultado1
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.pliegues
                                                    .resultado2
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.pliegues
                                                    .resultado3
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.pliegues
                                                    .resultado4
                                            "
                                        />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table table-bordered mediciones">
                            <thead>
                                <tr>
                                    <th>Perimetría</th>
                                    <th>1M</th>
                                    <th>2M</th>
                                    <th>3M</th>
                                    <th>4M</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Fecha:</td>
                                    <td colspan="4">
                                        <input
                                            type="date"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .fecha
                                            "
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Hombros</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .hombros1
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .hombros2
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .hombros3
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .hombros4
                                            "
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Pecho</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .pecho1
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .pecho2
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .pecho3
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .pecho4
                                            "
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Biceps relajado</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .biceps_relajado1
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .biceps_relajado2
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .biceps_relajado3
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .biceps_relajado4
                                            "
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Biceps contraido</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .biceps_contraido1
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .biceps_contraido2
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .biceps_contraido3
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .biceps_contraido4
                                            "
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Antebrazo</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .antebrazo1
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .antebrazo2
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .antebrazo3
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .antebrazo4
                                            "
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Muñeca</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .muneca1
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .muneca2
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .muneca3
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .muneca4
                                            "
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Cintura</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .cintura1
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .cintura2
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .cintura3
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .cintura4
                                            "
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Abdomen</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .abdomen1
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .abdomen2
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .abdomen3
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .abdomen4
                                            "
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Cadera</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .cadera1
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .cadera2
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .cadera3
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .cadera4
                                            "
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Muslo</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .muslo1
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .muslo2
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .muslo3
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .muslo4
                                            "
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Rodilla</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .rodilla1
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .rodilla2
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .rodilla3
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .rodilla4
                                            "
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Pantorilla</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .pantorilla1
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .pantorilla2
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .pantorilla3
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .pantorilla4
                                            "
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tobillo</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .tobillo1
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .tobillo2
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .tobillo3
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .tobillo4
                                            "
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Resultado</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .resultado1
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .resultado2
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .resultado3
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.perimetrias
                                                    .resultado4
                                            "
                                        />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table table-bordered mediciones">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>1M</th>
                                    <th>2M</th>
                                    <th>3M</th>
                                    <th>4M</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Peso</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.imcs.peso1
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.imcs.peso2
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.imcs.peso3
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.imcs.peso4
                                            "
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>IMC</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.imcs.imc1
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.imcs.imc2
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.imcs.imc3
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.imcs.imc4
                                            "
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Glicemia</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.imcs.glicemia1
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.imcs.glicemia2
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.imcs.glicemia3
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.imcs.glicemia4
                                            "
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>R.P.M.</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.imcs.rpm1
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.imcs.rpm2
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.imcs.rpm3
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.imcs.rpm4
                                            "
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>L.P.M.</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.imcs.lpm1
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.imcs.lpm2
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.imcs.lpm3
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.imcs.lpm4
                                            "
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Oxigeno</td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.imcs.oxigeno1
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.imcs.oxigeno2
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.imcs.oxigeno3
                                            "
                                        />
                                    </td>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="
                                                evaluacion_fisica.imcs.oxigeno4
                                            "
                                        />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label
                            :class="{
                                'text-danger': errors.patologias,
                            }"
                            >Patologías</label
                        >
                        <el-input
                            type="textarea"
                            autosize
                            :autosize="{ minRows: 2 }"
                            class="readonly"
                            :class="{ 'is-invalid': errors.patologias }"
                            v-model="evaluacion_fisica.patologias"
                        >
                        </el-input>
                        <span
                            class="error invalid-feedback"
                            v-if="errors.patologias"
                            v-text="errors.patologias[0]"
                        ></span>
                    </div>
                    <div class="form-group col-md-12">
                        <label
                            :class="{
                                'text-danger': errors.patologias,
                            }"
                            >Observaciones de postura</label
                        >
                        <el-input
                            type="textarea"
                            autosize
                            :autosize="{ minRows: 2 }"
                            class="readonly"
                            :class="{ 'is-invalid': errors.obs_postura }"
                            v-model="evaluacion_fisica.obs_postura"
                        >
                        </el-input>
                        <span
                            class="error invalid-feedback"
                            v-if="errors.obs_postura"
                            v-text="errors.obs_postura[0]"
                        ></span>
                    </div>
                    <div class="form-group col-md-12">
                        <label
                            :class="{
                                'text-danger': errors.recomendaciones,
                            }"
                            >Recomendaciones</label
                        >
                        <el-input
                            type="textarea"
                            autosize
                            :autosize="{ minRows: 2 }"
                            class="readonly"
                            :class="{ 'is-invalid': errors.recomendaciones }"
                            v-model="evaluacion_fisica.recomendaciones"
                        >
                        </el-input>
                        <span
                            class="error invalid-feedback"
                            v-if="errors.recomendaciones"
                            v-text="errors.recomendaciones[0]"
                        ></span>
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
            ></el-button>

            <el-button
                v-if="this.evaluacion_fisica.id != 0"
                type="success"
                :loading="enviando"
                @click="generaReporte()"
                ><i class="fa fa-file-pdf"></i> Exportar</el-button
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
        evaluacion_fisica: {
            type: Object,
            default() {
                return {
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
                };
            },
        },
    },
    watch: {
        evaluacion_fisica(newVal, oldVal) {
            if (newVal.id != 0) {
                this.getClientes();
            }
            this.getInfoCliente();
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
            errors: [],
            listClientes: [],
            listSucursales: [],
            oCliente: this.iniciaInfoCliente(),
        };
    },
    mounted() {
        this.getSucursales();
        if (this.evaluacion_fisica.id == 0) {
            this.evaluacion_fisica.fecha = this.fechaActual();
        }
        this.getClientes();
        if (this.user.tipo != "GERENTE") {
            this.evaluacion_fisica.sucursal_id = this.user.sucursal_id;
            this.getClientes();
        }
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
            if (this.evaluacion_fisica.sucursal_id != "") {
                axios
                    .get("/admin/clientes/clientes_sucursal", {
                        params: {
                            id: this.evaluacion_fisica.sucursal_id,
                        },
                    })
                    .then((response) => {
                        this.listClientes = response.data;
                    });
            } else {
                this.listClientes = [];
            }
        },
        getInfoCliente() {
            if (this.evaluacion_fisica.cliente_id != "") {
                axios
                    .get("/admin/clientes/" + this.evaluacion_fisica.cliente_id)
                    .then((response) => {
                        this.oCliente = response.data.cliente;
                    });
            } else {
                this.oCliente = this.iniciaInfoCliente();
            }
        },
        // ENVIAR REGISTRO
        enviarFormulario() {
            this.enviando = true;
            try {
                this.textoBtn = "Enviando...";
                let url = "/admin/evaluacion_fisicas";
                if (this.accion == "edit") {
                    url =
                        "/admin/evaluacion_fisicas/" +
                        this.evaluacion_fisica.id;
                    this.evaluacion_fisica["_method"] = "PUT";
                }
                axios
                    .post(url, this.evaluacion_fisica)
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
                                Swal.fire({
                                    icon: "error",
                                    title: "Error",
                                    text: "Ocurrió un error durante el registro intenté nuevamente por favor",
                                    showConfirmButton: false,
                                    timer: 2000,
                                });
                            }
                        }
                    });
            } catch (e) {
                this.enviando = false;
                console.log(e);
            }
        },
        limpiaEvaluacionFisica() {
            this.errors = [];
            this.evaluacion_fisica.nombre = "";
            this.evaluacion_fisica.dir = "";
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
        iniciaInfoCliente() {
            return {
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
                foto: "",
                sucursal_id: "",
                fecha_registro: "",
            };
        },
        iniciaSeleccionFilas() {
            $(".mediciones").on("focusin", "input", function () {
                $(this).parents("tr").addClass("seleccionado");
            });
            $(".mediciones").on("focusout", "input", function () {
                $(this).parents("tr").removeClass("seleccionado");
            });
        },
        generaReporte() {
            this.enviando = true;
            let config = {
                responseType: "blob",
            };
            axios
                .post(
                    "/admin/evaluacion_fisicas/pdf/" +
                        this.evaluacion_fisica.id,
                    null,
                    config
                )
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
    },
};
</script>

<style>
.mediciones tbody tr td {
    padding: 0px;
    vertical-align: middle;
}

.mediciones tbody tr td:nth-child(1) {
    padding-left: 5px;
}

.contenedor_tabla {
    overflow: auto;
}
</style>
