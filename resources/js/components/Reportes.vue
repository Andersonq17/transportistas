<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-4">
                <div class="card card-default">
                    <div class="card-body text-center">
                        Reportes del Sistema.
                    </div>

                    <div class="box-body table-responsive no-padding">

                        <table class="table table-hover">
                            <thead>
                                <tr  class="text-center">
                                    <th>Reporte</th>
                                    <th>Ver</th>
                                    <th>Descargar</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr  class="text-center">
                                    <td>Lineas de transporte</td>
                                    <td><a href="api/reporte_lineas/1" target="_blank"><button class="btn btn-block btn-primary btn-xs">Ver</button></a></td>
                                    <td><a href="api/reporte_lineas/2" target="_blank"><button class="btn btn-block btn-success btn-xs">Descargar</button></a></td>
                                </tr>
                                <tr  class="text-center">
                                    <td>Unidades de transporte</td>
                                    <td><a href="api/reporte_unidades/1" target="_blank"><button class="btn btn-block btn-primary btn-xs">Ver</button></a></td>
                                    <td><a href="api/reporte_unidades/2" target="_blank"><button class="btn btn-block btn-success btn-xs">Descargar</button></a></td>
                                </tr>
                                <tr  class="text-center">
                                    <td>Choferes</td>
                                    <td><a href="api/reporte_persona/1" target="_blank"><button class="btn btn-block btn-primary btn-xs">Ver</button></a></td>
                                    <td><a href="api/reporte_persona/2" target="_blank"><button class="btn btn-block btn-success btn-xs">Descargar</button></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        
        }
    
</script>
