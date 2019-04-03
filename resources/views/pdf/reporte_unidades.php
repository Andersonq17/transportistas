<html>
<title>Reportes de Unidade Transporte</title>

<style>

    body{
        margin:0;
        font-family:"Segoe UI", Roboto,"Helvetica Neue";
        font-size: 0.875rem;
        font-weight: normal;
        line-height: 1.5;
        color: #151b1e;

    }

    .table{
        display:table;
        width: 100%;
        max-width:100%;
        margin-bottom:1rem;
        background-color:transparent;
        border-collapse: collapse;
    }

    .table-bordered{
        border: 1px solid #c2cfd6;
    }

    thead{
        display: table-header-group;
        vertical-align: middle;
        border-color: inherit;
    }
    tr{
        display:table-row;
        vertical-align:inherit;
        border-color: inherit;
    }
    .table th, .table td{
        padding: 0.75rem;
        vertical-align:top;
        border-top: 1px solid #c2cfd6;
    }

    .table thead th{
        vertical-align: bottom;
        border-bottom: 2px solid #c2cfd6
    }

    .table-bordered thead th , .table-bordered thead td{
        border-bottom-width:2px;
    }

    th, td{
        display:table-cell;
        vertical-align: inherit;
    }
    th{
        font-weight:bold;
        text-align: -internal-center;
        text-align: left;
    }

    tbody{
        display:table-row-group;
        vertical-align: middle;
        border-color: inherit;
    }
    tr{
        display:table-row;
        vertical-align:inherit;
        border-color:inherit;
    }
    .table-striped tbody tr:nth-of-type(odd){
        background-color:rgba(0,0,0,0.05);
    }

    .izquierda{
        float:left;
    }

    .derecha{
        float:right;
    }

</style>
<body>
<img src="./img/banner.png">
        <h3 class="">Unidades de transporte  <span class="derecha">Fecha: <?= $date ?></span></h3>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                <table class="table table-bordered table-striped">
                
                    <thead>
                    
                        <tr class="text-center">
                        
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Año</th>
                            <th>Placa</th>
                            <th>Tipo</th>
                            <th>Numero Cupo</th>
                            <th>Status</th>
                            <th>Organización</th>

                        </tr>

                    </thead>

                    <tbody>
                    
                        <?php foreach ($data as $unidad){?>

                        <tr class="text-center">
                            <td><?= $unidad->marca; ?></td>
                            <td><?= $unidad->modelo; ?></td>
                            <td><?= $unidad->anio; ?></td>
                            <td><?= $unidad->placa; ?></td>
                            <td><?= $unidad->tipo; ?></td>
                            <td><?= $unidad->numero_cupo; ?></td>
                            <td><?= $unidad->status?'Activo':'Inactivo'; ?></td>
                            <td><?= $unidad->nombre_linea; ?></td>
                            
                        </tr>
                        <?php } ?>
                    </tbody>

                </table>
                </div>
            </div>
        </div>
    </body>                        
 </html>   