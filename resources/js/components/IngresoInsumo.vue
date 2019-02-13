<template>
  <div class="container">
    <div class="row mt-5">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title text-center"> Ingresar Insumos</h3>
          </div>
          <div class="card-body">
            <form class="col-md-12">
              <div class="form-group">
                <div class="input-group">
                      
                  <select class="form-control col-md-6">
                    <option disabled value="0">Seleccione Proveedor</option>
                  </select>

                  <select class="form-control col-md-6 ml-2">
                    <option disabled value="0">Tipo de Comprobante</option>
                    <option value="NE">Nota de Entrega</option>
                    <option value="FC">Factura</option>
                    <option value="RC">Recibo</option>
                  </select>
                
                </div>
              </div>
              <div class="form-row">

                  <label>Numero Comprobante
                  <input type="text" placeholder="000xxx" class="form-control">
                  </label>
                   <label>Numero de Serie
                  <input type="text" placeholder="0000-xxxx" class="form-control ml-2">
                  </label>
                  <label>Fecha de Documento
                  <input type='datetime-local' placeholder="Fecha Documento" class="form-control ml-4">
                  </label>
                
              </div>
              
             </form>
            </div>
        </div>

      </div>
    </div>

  </div>
  
</template>



