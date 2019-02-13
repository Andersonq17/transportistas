<html>
<title>Reportes de Lineas de Transporte</title>

<link rel="stylesheet" href="/css/app.css">
<h3 class="box-title">Reportes Linea de Transporte <?= $date ?></h3>
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
               <table class="table">
               
                <thead>
                
                    <tr class="text-center">
                    
                        <th>id</th>
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
                    
                        <td><?= $linea->id; ?></td>
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

 </html>   