<html>
<title>Reportes de Lineas de Transporte</title>

<link rel="stylesheet" href="/css/app.css">
<body>
        <h3 class="box-title">Unidades de transporte <?= $date ?></h3>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                <table class="table table-responsive">
                
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
                            <td><?= $unidad->status; ?></td>
                            
                        </tr>
                        <?php } ?>
                    </tbody>

                </table>
                </div>
            </div>
        </div>
    </body>                        
 </html>   