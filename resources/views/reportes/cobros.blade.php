<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Cobros</title>
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
            width: 200px;
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
            font-size: 14pt;
        }

        .texto {
            width: 250px;
            text-align: center;
            margin: auto;
            margin-top: 15px;
            font-weight: bold;
            font-size: 1.1em;
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
            font-size: 0.55em;
        }

        table tbody tr td.franco {
            background: red;
            color: white;
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

        .derecha {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        .img_celda img {
            width: 45px;
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
        <h4 class="texto">LISTA DE COBROS</h4>
        <h4 class="fecha">Expedido: {{ date('d-m-Y') }}</h4>
    </div>
    <table border="1">
        <thead class="green">
            <tr>
                <th width="3%">N°</th>
                <th>CLIENTE</th>
                <th>SUCURSAL</th>
                <th>PLAN</th>
                <th width="9%">FECHA DE INSCRIPCIÓN</th>
                <th width="9%">FECHA DE COBRO</th>
                <th>TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @php
                $cont = 1;
                $total = 0;
            @endphp
            @foreach ($cobros as $cobro)
                <tr>
                    <td class="centreado">{{ $cont++ }}</td>
                    <td>{{ $cobro->cliente->full_name }}</td>
                    <td>{{ $cobro->sucursal->nombre }}</td>
                    <td>{{ $cobro->inscripcion->plan->nombre }}</td>
                    <td>{{ date('d/m/Y', strtotime($cobro->inscripcion->fecha_inscripcion)) }}</td>
                    <td>{{ date('d/m/Y', strtotime($cobro->fecha_registro)) }}</td>
                    <td class="centreado">{{ $cobro->inscripcion->plan->costo }}</td>
                </tr>
                @php
                    $total += (float) $cobro->inscripcion->plan->costo;
                @endphp
            @endforeach
            <tr>
                <td colspan="6" class="derecha bold">TOTAL</td>
                <td class="centreado bold">{{ number_format($total, 2) }}</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
