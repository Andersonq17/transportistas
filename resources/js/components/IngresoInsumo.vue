
<template>
    <div class="container">
       <div class="row mt-5">
          <div class="col-12">
              <!--Listado de compras-->
              <template v-if="listado">
            <div class="card" v-if="$gate.isAdmin()">
              <div class="card-header">
                <h3 class="card-title text-center">Registro de Ingreso de Insumos</h3>

                <div class="card-tools">
                    <div class="card-tools">
                    <button class="btn btn-success" @click="mostrarDetalle()">Nuevo <i class="fas fa-plus fa-fw"></i></button>
                  
                </div>
                  <!--<div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Buscar">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </div>
                  </div>-->
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody>
                    <tr class="text-center">
                    <th>Usuario</th>
                    <th>Proveedor</th>
                    <th>Tipo de Comprobante</th>
                    <th>Serie de Comprobante</th>
                    <th>Numero de Comprobante</th>
                    <th>Fecha y Hora</th>
                    <th>Impuesto</th>
                    <th>Total</th>
                    <th>Opciones</th>
                  </tr>

                  
                  <tr class="text-center" v-for="ingreso in ingresos.data" :key="ingreso.id">
                    <td>{{ingreso.idusuario}}</td>
                    <td>{{ingreso.idproveedor}}</td>
                    <td>{{ingreso.tipo_comprobante}}</td>
                    <td>{{ingreso.serie_comprobante}}</td>
                    <td>{{ingreso.num_comprobante}}</td>
                    <td>{{ingreso.fecha_hora}}</td>
                    <td>{{ingreso.impuesto}}</td>
                    <td>{{ingreso.total}}</td>
                    
                     <td>

                        <a href="#" @click="editModal(ingreso)">
                            <i class="fa fa-edit"></i>
                        </a>
                            \
                         <a href="#" @click="borrarUsuario(ingreso.id)">
                            <i style="color:red;" class="fa fa-trash"></i>
                        </a>

                    </td>
                  
                  </tr>
                 
                </tbody></table>
              </div>
              <!-- /.card-body -->
              <div class="card footer">
                  <pagination :data="ingresos" @pagination-change-page="getResults"></pagination>
              </div>
            </div>
              </template>
            
            <!--Fin listado de compras-->

        <!--Ingresar compras-->
        <template v-else>
            <div class="card-body">
                <div class="form-group row border">

                    <div class="col-md-9">
                        <div class="form-group" >
                            <label for="">Proveedor</label>
                            <v-select 
                            :on-search="selectProveedor"
                            label="nombre"
                            :options="arrayProveedor"
                            placeholder="Buscar Proveedores...."
                            v-model="form.idproveedor" >
                            </v-select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="">Impuesto</label>
                        <input class="form-control" type="text" v-model="form.impuesto">
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tipo de Comprobante</label>
                            <select class="form-control" v-model="form.tipo_comprobante">
                                <option value="0">Seleccione</option>
                                <option value="NE">Nota de Entrega</option>
                                <option value="FC">Factura</option>
                                <option value="RC">Recibo</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Serie de comprobante</label>
                                <input type="text" class="form-control" v-model="form.serie_comprobante" placeholder="000-xxx">
                        </div>
                    </div>
                     <div class="col-md-4">
                        <div class="form-group">
                            <label>(*)Numero de comprobante</label>
                                <input type="text" class="form-control" v-model="form.num_comprobante" placeholder="000-xxx">
                        </div>
                    </div>
                </div>
            
             
                <div class="form-group row border">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Insumo</label>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Ingrese Insumo">
                            <button class="btn btn-primary" @click="abrirModal()">...</button>
                        </div>
                    </div>

                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">Precio</label>
                        <input class="form-control" type="number" step="any" >
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">Cantidad</label>
                        <input class="form-control" type="number" step="any">
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <button class="btn btn-success form-control btnagregar"><i class="fas fa-plus fa-fw"></i></button>
                    </div>
                </div>
               </div> 
            
             
                <div class="form-group row border">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Insumo</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Subtotal</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody v-if="arrayDetalle.length">
                                <tr v-for="detalle in arrayDetalle" :key="detalle.id">
                                    <td v-text="detalle.idinsumo"></td>
                                    <td>
                                        <input type="number" class="form-control" v-model="detalle.precio">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" v-model="detalle.cantidad">
                                    </td>
                                    <td>{{detalle.precio*detalle.cantidad}}</td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm">
                                            <i class="fas fa-times-circle"></i>
                                        </button>
                                    </td>
                                </tr>

                                <tr style="background-color: #CEECF5;">
                                    <td colspan="4" align="right">Total Parcial:</td>
                                    <td>$5</td>
                                </tr>
                                 <tr style="background-color: #CEECF5;">
                                    <td colspan="4" align="right"><strong> Impuesto:</strong></td>
                                    <td>$1</td>
                                </tr>
                                <tr style="background-color: #CEECF5;">
                                    <td colspan="4" align="right"><strong> Total Neto:</strong></td>
                                    <td>$6</td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="5" class="text-center">No hay items agregados</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <button type="button" @click="ocultarDetalle()" class="btn btn-secondary">Cerrar</button>
                        <button type="button" class="btn btn-primary" @click="registrarIngreso()">Registrar Ingreso</button>
                    </div>

                </div>
            </div>
        </template>
        </div>
    </div>
       
        <!--Fin ingreso de compras-->

        <div v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>

        <!-- Modal -->
<div class="modal fade" id="nuevoIngreso" tabindex="-1" role="dialog" aria-labelledby="nuevoIngreso" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title">Seleccione Insumo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="form-group">
              <div class="table-responsive">
                  <table class="table table-hover">
                      <tbody>
                          <tr class="text-center">
                              <th>Marca</th>
                              <th>Tipo</th>
                              <th>Medidas</th>
                              <th>Amperaje</th>
                              <th>Tipo Aceite</th>
                              <th>Selecionar</th>
                          </tr>

                          <tr v-for="insumo in arrayInsumo" :key="insumo.id" class="text-center">
                              <td ></td>
                              <td ></td>
                              <td ></td>
                              <td ></td>
                              <td ></td>
                              <td ></td>

                          </tr>
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
      
    </div>
  </div>
</div>
    </div>
</template>

<script>
    export default {

        data(){
            return{
                ingresos:{},
                listado:1,
                arrayProveedor:[],
                arrayDetalle:[],
                arrayIngreso:[],
                arrayInsumo:[], //objeto js de axios
                form : new Form({
                    id :'',
                    idproveedor: '',
                    idusuario:'',
                    tipo_comprobante: 'NE',
                    serie_comprobante:'',
                    num_comprobante:'',
                    impuesto :0.12,
                    total:0.0,
                    idinsumo:0,
                    precio:0,
                    cantidad:0
                    
                    
                })
            }

        },

        methods:{
                getResults(page = 1) {
			        axios.get('api/ingreso?page=' + page)
				.then(response => {
					this.ingresos = response.data;
				});
            },

            abrirModal(){
                
                this.form.reset();
                 $('#nuevoIngreso').modal('show');
                
            },

            
               
             listarIngreso(){
                 if(this.$gate.isAdmin()){
                    axios.get("api/ingreso").then(({ data })=>(this.ingresos = data)); //(api/user) por defecto agara al index de primero
                    //enviar la peticion solo si es admin
                 }
                 
             },
             mostrarDetalle(){
                 this.listado=0;
             },
             ocultarDetalle(){
                 this.listado=1;
             },

             selectProveedor(search,loading){
                 loading=true;
                 axios.get('api/selectProveedor?filtro='+search).then((data)=>{
                    this.arrayProveedor=data.data;
                    loading=false;
                    })
                    .catch(()=>{

                    })
             },

                getDatosProveedor(val1){
                   
                   loading=true;
                    this.form.idproveedor=val1.id;

            },

             crearIngreso(){
                 
                 this.form.post('api/ingreso').then(()=>{ //validar si se envio todos los datos bien
                        this.$Progress.start();
                        $('#nuevoIngreso').modal('hide')

                        this.$Progress.finish();
                        this.listarIngreso();
                        
                        toast({
                            type: 'success',
                            title: 'Usuario creado con exito!'
                            })

                 })
                 
                 .catch(()=>{ //mostrar error


                 })

                   
             },

             actUsuario(){
                 this.$Progress.start();
                 this.form.put('api/ingreso/'+this.form.id).then(()=>{
                     $('#nuevoIngreso').modal('hide')
                     swal(
                                'Actualizado',
                                'El usuario ha sido actualizado',
                                'success'
                                )
                     this.listarIngreso();
                     this.$Progress.finish();
                 }).catch(()=>{
                    this.$Progress.fail();
                 })
                 //console.log('Editando');
             },

             borrarUsuario(id){
                 swal({
                    title: 'Estas seguro de eliminar este usuario?',
                    text: "Esta acción no se puede revertir!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si'
                    }).then((result) => {

                        //enviar la peticion al servidor
                    if (result.value) { //evaluar si Si o No elimina
                        this.form.delete('api/ingreso/'+id).then(()=>{ //llamar al metodo borrar del controlador mediante el route list
                           
                                swal(
                                'Eliminado',
                                'El usuario ha sido eliminado',
                                'success'
                                )

                                this.listarIngreso();
                    

                        }).catch(()=>{
                             swal(
                                'Falló',
                                'Algo salió mal',
                                'warning'
                                )
                        })
                        }
                    
                    })

             },


             
            
        },
        created() {
            Fire.$on('buscando',() =>{
                let query = this.$parent.buscar;
                axios.get('api/buscarIngreso?q='+ query)
                .then((data)=>{
                    this.ingresos=data.data;
                })
                .catch(()=>{

                })
            });
            this.listarIngreso();
            this.selectProveedor();
        }
    }
</script>
<style>
    @media(min-width: 600px){
        .btnagregar{
            margin-top:2rem;
        }
    }
</style>

