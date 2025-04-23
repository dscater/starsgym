<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Evaluación Física</title>
    <style type="text/css">
        * {
            font-family: sans-serif;
        }

        @page {
            margin-top: 2cm;
            margin-bottom: 1cm;
            margin-left: 1.5cm;
            margin-right: 1cm;
            border: 5px solid blue;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-top: 20px;
        }

        table thead tr th,
        tbody tr td {
            font-size: 0.63em;
            word-wrap: break-word;
        }

        .encabezado {
            width: 100%;
        }

        .logo img {
            position: absolute;
            width: 190px;
            height: 90px;
            top: -20px;
            left: -20px;
        }

        h2.titulo {
            width: 450px;
            margin: auto;
            margin-top: 15px;
            margin-bottom: 15px;
            text-align: center;
            font-size: 13pt;
        }

        .texto {
            width: 360px;
            text-align: center;
            margin: auto;
            margin-top: 15px;
            font-weight: bold;
            font-size: 0.95em;
        }

        .fecha {
            width: 250px;
            text-align: center;
            margin: auto;
            margin-top: 15px;
            font-weight: normal;
            font-size: 0.85em;
        }

        .total {
            text-align: right;
            padding-right: 15px;
            font-weight: bold;
        }

        table {
            width: 100%;
        }

        table thead {
            background: rgb(225, 97, 105)
        }

        table thead tr th {
            padding: 3px;
            font-size: 0.7em;
        }

        table tbody tr td {
            padding: 3px;
        }

        .centreado {
            padding-left: 0px;
            text-align: center;
        }

        .datos {
            margin-left: 15px;
            border-top: solid 1px;
            border-collapse: collapse;
            width: 250px;
        }

        .txt {
            font-weight: bold;
            text-align: right;
            padding-right: 5px;
        }

        .txt_center {
            font-weight: bold;
            text-align: center;
        }

        .cumplimiento {
            position: absolute;
            width: 150px;
            right: 0px;
            top: 86px;
        }

        .p_cump {
            color: red;
            font-size: 1.2em;
        }

        .b_top {
            border-top: solid 1px black;
        }

        .gray {
            background: rgb(202, 202, 202);
        }

        .green {
            background: #FF6666;
            color: white;
        }

        .txt_rojo {}

        .img_celda img {
            width: 45px;
        }

        .border_bottom {
            border-bottom: solid 1px;
        }

        .descripcion_texto {
            font-size: 0.63em;
        }
    </style>
</head>

<body>
    @inject('configuracion', 'App\Models\Configuracion')
    <div class="encabezado">
        <div class="logo">
            <img src="{{ asset('imgs/' . $configuracion->first()->logo) }}">
        </div>
        <h2 class="titulo">
            {{ $configuracion->first()->razon_social }}
        </h2>
        <h4 class="texto">PLANILLA DE ACONDICIONAMIENTO FÍSICO</h4>
    </div>

    <table>
        <tbody>
            <tr>
                <td width="16%">Nombre:</td>
                <td class="border_bottom">{{ $evaluacion_fisica->cliente->full_name }}</td>
                <td width="10%">Sexo:</td>
                <td class="border_bottom">{{ $evaluacion_fisica->cliente->genero }}</td>
            </tr>
            <tr>
                <td>Fecha de nacimiento:</td>
                <td class="border_bottom">{{ date('d/m/Y', strtotime($evaluacion_fisica->cliente->fecha_nacimiento)) }}
                </td>
                <td>Edad:</td>
                <td class="border_bottom">{{ $evaluacion_fisica->cliente->edad }}</td>
            </tr>
            <tr>
                <td>Talla:</td>
                <td class="border_bottom">{{ $evaluacion_fisica->talla }}</td>
                <td>Peso inicial:</td>
                <td class="border_bottom">{{ $evaluacion_fisica->peso_inicial }}</td>
            </tr>
            <tr>
                <td>Tipo de sangre:</td>
                <td class="border_bottom">{{ $evaluacion_fisica->tipo_sangre }}</td>
                <td>Email:</td>
                <td class="border_bottom">{{ $evaluacion_fisica->cliente->correo }}</td>
            </tr>
            <tr>
                <td>Persona de referencia:</td>
                <td class="border_bottom">{{ $evaluacion_fisica->persona_referencia }}</td>
                <td>Teléfono:</td>
                <td class="border_bottom">{{ $evaluacion_fisica->cliente->fono }}</td>
            </tr>
            <tr>
                <td>Dirección:</td>
                <td class="border_bottom">{{ $evaluacion_fisica->cliente->dir }}</td>
                <td>Teléfono:</td>
                <td class="border_bottom">{{ $evaluacion_fisica->fono2 }}</td>
            </tr>
            <tr>
                <td>Fecha:</td>
                <td class="border_bottom">{{ date('d/m/Y', strtotime($evaluacion_fisica->fecha)) }}</td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <h4 class="texto">MEDIDAS ANTROPOMÉTRICAS</h4>

    <table border="1">
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
                    {{ $evaluacion_fisica->pliegues->fecha }}
                </td>
            </tr>
            <tr>
                <td>Bicipital</td>
                <td class="centreado">
                    {{ $evaluacion_fisica->pliegues->bicipital1 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->pliegues->bicipital2 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->pliegues->bicipital3 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->pliegues->bicipital4 }}
                </td>
            </tr>
            <tr>
                <td>Tricipital</td>
                <td class="centreado">
                    {{ $evaluacion_fisica->pliegues->tricipital1 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->pliegues->tricipital2 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->pliegues->tricipital3 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->pliegues->tricipital4 }}
                </td>
            </tr>
            <tr>
                <td>Subescapular</td>
                <td class="centreado">
                    {{ $evaluacion_fisica->pliegues->subescapular1 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->pliegues->subescapular2 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->pliegues->subescapular3 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->pliegues->subescapular4 }}
                </td>
            </tr>
            <tr>
                <td>Axilar</td>
                <td class="centreado">
                    {{ $evaluacion_fisica->pliegues->axilar1 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->pliegues->axilar2 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->pliegues->axilar3 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->pliegues->axilar4 }}
                </td>
            </tr>
            <tr>
                <td>Pectoral</td>
                <td class="centreado">
                    {{ $evaluacion_fisica->pliegues->pectoral1 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->pliegues->pectoral2 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->pliegues->pectoral3 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->pliegues->pectoral4 }}
                </td>
            </tr>
            <tr>
                <td>Abdominal</td>
                <td class="centreado">
                    {{ $evaluacion_fisica->pliegues->abdominal1 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->pliegues->abdominal2 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->pliegues->abdominal3 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->pliegues->abdominal4 }}
                </td>
            </tr>
            <tr>
                <td>Supraliaco</td>
                <td class="centreado">
                    {{ $evaluacion_fisica->pliegues->supraliaco1 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->pliegues->supraliaco2 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->pliegues->supraliaco3 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->pliegues->supraliaco4 }}
                </td>
            </tr>
            <tr>
                <td>Muslo</td>
                <td class="centreado">
                    {{ $evaluacion_fisica->pliegues->muslo1 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->pliegues->muslo2 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->pliegues->muslo3 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->pliegues->muslo4 }}
                </td>
            </tr>
            <tr>
                <td>Pantorilla</td>
                <td class="centreado">
                    {{ $evaluacion_fisica->pliegues->pantorilla1 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->pliegues->pantorilla2 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->pliegues->pantorilla3 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->pliegues->pantorilla4 }}
                </td>
            </tr>
            <tr>
                <td class="font-weight-bold">Resultado</td>
                <td class="centreado">
                    {{ $evaluacion_fisica->pliegues->resultado1 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->pliegues->resultado2 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->pliegues->resultado3 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->pliegues->resultado4 }}
                </td>
            </tr>
        </tbody>
    </table>

    <table border="1">
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
                    {{ $evaluacion_fisica->perimetrias->fecha }}
                </td>
            </tr>
            <tr>
                <td>Hombros</td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->hombros1 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->hombros2 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->hombros3 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->hombros4 }}
                </td>
            </tr>
            <tr>
                <td>Pecho</td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->pecho1 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->pecho2 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->pecho3 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->pecho4 }}
                </td>
            </tr>
            <tr>
                <td>Biceps relajado</td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->biceps_relajado1 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->biceps_relajado2 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->biceps_relajado3 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->biceps_relajado4 }}
                </td>
            </tr>
            <tr>
                <td>Biceps contraido</td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->biceps_contraido1 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->biceps_contraido2 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->biceps_contraido3 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->biceps_contraido4 }}
                </td>
            </tr>
            <tr>
                <td>Antebrazo</td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->antebrazo1 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->antebrazo2 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->antebrazo3 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->antebrazo4 }}
                </td>
            </tr>
            <tr>
                <td>Muñeca</td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->muneca1 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->muneca2 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->muneca3 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->muneca4 }}
                </td>
            </tr>
            <tr>
                <td>Cintura</td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->cintura1 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->cintura2 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->cintura3 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->cintura4 }}
                </td>
            </tr>
            <tr>
                <td>Abdomen</td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->abdomen1 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->abdomen2 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->abdomen3 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->abdomen4 }}
                </td>
            </tr>
            <tr>
                <td>Cadera</td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->cadera1 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->cadera2 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->cadera3 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->cadera4 }}
                </td>
            </tr>
            <tr>
                <td>Muslo</td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->muslo1 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->muslo2 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->muslo3 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->muslo4 }}
                </td>
            </tr>
            <tr>
                <td>Rodilla</td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->rodilla1 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->rodilla2 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->rodilla3 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->rodilla4 }}
                </td>
            </tr>
            <tr>
                <td>Pantorilla</td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->pantorilla1 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->pantorilla2 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->pantorilla3 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->pantorilla4 }}
                </td>
            </tr>
            <tr>
                <td>Tobillo</td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->tobillo1 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->tobillo2 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->tobillo3 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->tobillo4 }}
                </td>
            </tr>
            <tr>
                <td class="font-weight-bold">Resultado</td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->resultado1 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->resultado2 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->resultado3 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->perimetrias->resultado4 }}
                </td>
            </tr>
        </tbody>
    </table>

    <table border="1">
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
                <td class="centreado">
                    {{ $evaluacion_fisica->imcs->peso1 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->imcs->peso2 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->imcs->peso3 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->imcs->peso4 }}
                </td>
            </tr>
            <tr>
                <td>IMC</td>
                <td class="centreado">
                    {{ $evaluacion_fisica->imcs->imc1 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->imcs->imc2 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->imcs->imc3 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->imcs->imc4 }}
                </td>
            </tr>
            <tr>
                <td>Glicemia</td>
                <td class="centreado">
                    {{ $evaluacion_fisica->imcs->glicemia1 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->imcs->glicemia2 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->imcs->glicemia3 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->imcs->glicemia4 }}
                </td>
            </tr>
            <tr>
                <td>R.P.M.</td>
                <td class="centreado">
                    {{ $evaluacion_fisica->imcs->rpm1 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->imcs->rpm2 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->imcs->rpm3 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->imcs->rpm4 }}
                </td>
            </tr>
            <tr>
                <td>L.P.M.</td>
                <td class="centreado">
                    {{ $evaluacion_fisica->imcs->lpm1 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->imcs->lpm2 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->imcs->lpm3 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->imcs->lpm4 }}
                </td>
            </tr>
            <tr>
                <td>Oxigeno</td>
                <td class="centreado">
                    {{ $evaluacion_fisica->imcs->oxigeno1 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->imcs->oxigeno2 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->imcs->oxigeno3 }}
                </td>
                <td class="centreado">
                    {{ $evaluacion_fisica->imcs->oxigeno4 }}
                </td>
            </tr>
        </tbody>
    </table>

    <p class="descripcion_texto"><strong>Patologías:</strong></p>
    <p class="descripcion_texto">{{ $evaluacion_fisica->patologias }}</p>
    <p class="descripcion_texto"><strong>Observaciones de postura:</strong></p>
    <p class="descripcion_texto">{{ $evaluacion_fisica->obs_postura }}</p>
    <p class="descripcion_texto"><strong>Recomendaciones:</strong></p>
    <p class="descripcion_texto">{{ $evaluacion_fisica->recomendaciones }}</p>
</body>

</html>
