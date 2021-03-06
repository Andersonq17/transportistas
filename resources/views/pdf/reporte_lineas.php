<html>
<title>Reportes de Lineas de Transporte</title>

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
        <h3 class="">Reporte Lineas de Transporte <span class="derecha">Fecha: <?= $date ?></span></h3>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                <table class="table table-bordered table-striped">
                
                    <thead>
                    
                        <tr class="text-center">
                        
                            <th>Nombre</th>
                            <th>RIF</th>
                            <th>Municipio</th>
                            <th>Correo</th>
                            <th>Telefono</th>
                            <th>Tipo de Ruta</th>
                            <th>Unidades</th>

                        </tr>

                    </thead>

                    <tbody>
                    
                        <?php foreach ($data as $linea){?>

                        <tr class="text-center">
                            <td><?= $linea->nombre; ?></td>
                            <td><?= $linea->rif; ?></td>
                            <td><?= $linea->municipio; ?></td>
                            <td><?= $linea->correo; ?></td>
                            <td><?= $linea->telefono; ?></td>
                            <td><?= $linea->tipo_ruta; ?></td>
                            <td><?= $linea->unidades()->count(); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>

                </table>
                </div>
            </div>
        </div>
    </body>                        
 </html>   