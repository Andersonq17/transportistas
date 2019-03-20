
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
                    <th>Observaciones</th>
                    <th>Opciones</th>
                  </tr>

                  
                  <tr class="text-center" v-for="ingreso in ingresos.data" :key="ingreso.id">
                    <td>{{ingreso.nombre_usuario}}</td>
                    <td>{{ingreso.nombre_proveedor}}</td>
                    <td>{{ingreso.tipo_comprobante}}</td>
                    <td>{{ingreso.serie_comprobante}}</td>
                    <td>{{ingreso.num_comprobante}}</td>
                    <td>{{ingreso.fecha_hora}}</td>
                    <td>{{ingreso.impuesto}}</td>
                    <td>{{ingreso.total}}</td>
                    <td>{{ingreso.observaciones}}</td>
                    
                     <td>

                         <a href="#" @click="anular(ingreso.id)">
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
                            v-model="idproveedor" >
                            </v-select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="">Impuesto</label>
                        <input class="form-control" type="text" v-model="impuesto">
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tipo de Comprobante</label>
                            <select class="form-control" v-model="tipo_comprobante">
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
                                <input type="text" class="form-control" v-model="serie_comprobante" placeholder="000-xxx">
                        </div>
                    </div>
                     <div class="col-md-4">
                        <div class="form-group">
                            <label>(*)Numero de comprobante</label>
                                <input type="text" class="form-control" v-model="num_comprobante" placeholder="000-xxx">
                        </div>
                    </div>
                    
                </div>
                <div class="col-md-4">
                        <div class="form-group">
                            <label>Observaciones y comentarios</label>
                                <textarea type="text" class="form-control" v-model="observaciones" placeholder=""></textarea>
                        </div>
                    </div>
             
                <div class="form-group row border">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Insumo <span style="color:red;" v-show="idinsumo==0">*Seleccione</span></label>
                        <div class="form-inline">
                            <input type="text" class="form-control" placeholder="Buscar por Codigo" v-model="codigo" @keyup.enter="buscarPorCodigo()">
                            <button class="btn btn-primary" @click="abrirModal()">...</button>
                            <input type="text" readonly class="form-control" v-model="marca">
                        </div>
                    </div>

                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">Precio<span style="color:red;" v-show="precio==0">*Ingrese</span></label>
                        <input class="form-control" type="number" step="any" v-model="precio" >
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">Cantidad <span style="color:red;" v-show="cantidad==0">*Ingrese</span></label>
                        <input class="form-control" type="number" step="any" v-model="cantidad">
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <button @click="agregarDetalle()" class="btn btn-success form-control btnagregar"><i class="fas fa-plus fa-fw"></i></button>
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
                                <tr v-for="(detalle,index) in arrayDetalle" :key="detalle.id">
                                    <td v-text="detalle.marca">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" v-model="detalle.precio">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" v-model="detalle.cantidad">
                                    </td>
                                    <td>{{detalle.precio*detalle.cantidad}}</td>
                                    <td>
                                        <button @click="eliminarRenglon(index)" type="button" class="btn btn-danger btn-sm">
                                            <i class="fas fa-times-circle"></i>
                                        </button>
                                    </td>
                                </tr>

                                <tr style="background-color: #CEECF5;">
                                    <td colspan="4" align="right">Total Parcial:</td>
                                    <td>Bs.S {{total_parcial=(total-total_impuesto).toFixed(2)}}</td>
                                </tr>
                                 <tr style="background-color: #CEECF5;">
                                    <td colspan="4" align="right"><strong> Impuesto:</strong></td>
                                    <td>Bs.S {{total_impuesto= ((total*impuesto)/(1+impuesto)).toFixed(2)}}</td>
                                </tr>
                                <tr style="background-color: #CEECF5;">
                                    <td colspan="4" align="right"><strong> Total Neto:</strong></td>
                                    <td>Bs.S {{total=calcularTotal}}</td>
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
                        <button type="button" class="btn btn-primary" @click="crearIngreso()">Registrar Ingreso</button>
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
  <div class="modal-dialog modal-primary modal-lg" role="document">
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
                              <th>Seleccionar</th>
                          </tr>

                          <tr v-for="insumo in arrayInsumo" :key="insumo.id" class="text-center">
                              <td v-text="insumo.marca"></td>
                              <td v-text="insumo.tipo"></td>
                              <td v-text="insumo.medidas_caucho"></td>
                              <td v-text="insumo.amperaje"></td>
                              <td v-text="insumo.tipo_aceite"></td>
                              <td>
                                  <button @click="agregarDetalleModal(insumo)" class="btn btn-success btn-sm" type="button">
                                      <i class="fas fa-check"></i>
                                  </button>
                              </td>

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
                    id :'',
                    idproveedor: '',
                    idusuario:'',
                    tipo_comprobante: 'NE',
                    serie_comprobante:'',
                    num_comprobante:'',
                    impuesto :0.16,
                    total:0.0,
                    idinsumo:0,
                    codigo:'',
                    precio:0,
                    cantidad:0,
                    marca:'',
                    observaciones:'',
                    total_impuesto:0.0,
                    total_parcial:0.0,
                    
                
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
                 $('#nuevoIngreso').modal('show');
                
            },

            listarInsumo(){
                 if(this.$gate.isAdmin()){
                    axios.get("api/listarInsumo").then(({ data })=>(this.arrayInsumo = data.data)); 
                    
                 }
            },

            buscarPorCodigo(){
                    axios.get("api/buscarPorCodigo?filtro="+this.codigo).then(({ data })=>(this.arrayInsumo=data ));
                  if(this.arrayInsumo.length>0){
                        this.marca=this.arrayInsumo[0]['marca'];
                        this.idinsumo=this.arrayInsumo[0]['id'];
                    }
                    else{
                        this.marca='No existe';
                        this.idinsumo=0;
                    }
            },
             listarIngreso(){
                 if(this.$gate.isAdmin()){
                    axios.get("api/ingreso").then(({ data })=>(this.ingresos = data)); 
                    //enviar la peticion solo si es admin
                 }
                 
             },

             encuentra(id){
                 let sw=0;

                 for (let i = 0; i < this.arrayDetalle.length; i++) {
                    if(this.arrayDetalle[i].idinsumo==id){
                        sw=true;
                    }
                     
                 }
                 return sw;
             },
             eliminarRenglon(index){
                 this.arrayDetalle.splice(index,1);
             },

             agregarDetalle(){

                 if(this.idinsumo==0 || this.marca==0 || this.precio==0 || this.cantidad==0){

                 }
                 else{
                     if(this.encuentra(this.idinsumo)){
                         swal({
                             type:'error',
                             title:'Error...',
                             text: 'Insumo ya está agregado',
                         })
                     }
                     else{
                    this.arrayDetalle.push({
                        idinsumo: this.idinsumo,
                        marca:this.marca,
                        precio: this.precio,
                        cantidad:this.cantidad,
                 });//despues del push volver todos los valores a su estado original
                    this.idinsumo='';
                    this.marca='';
                    this.precio=0;
                    this.cantidad=0;
                    this.codigo='';
                     }
                     
            }  
        },

        agregarDetalleModal(data=[]){
             if(this.encuentra(data['id'])){
                         swal({
                             type:'error',
                             title:'Error...',
                             text: 'Insumo ya está agregado',
                         })
                     }
                     else{
                    this.arrayDetalle.push({
                        idinsumo: data['id'],
                        marca: data['marca'],
                        precio: 1,
                        cantidad:1,
                 });//despues del push volver todos los valores a su estado original
                
                     }
        },
             mostrarDetalle(){
                 this.listado=0;
                        this.idproveedor="",
                        this.tipo_comprobante="NE",
                        this.serie_comprobante="",
                        this.num_comprobante="",
                        this.total=0
                        this.arrayDetalle=[]
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
                    this.idproveedor=val1.id;

            },

             crearIngreso(){
                 
               axios.post('api/ingreso',{
                   'idproveedor':this.idproveedor,
                        'tipo_comprobante':this.tipo_comprobante,
                        'serie_comprobante':this.serie_comprobante,
                        'num_comprobante':this.num_comprobante,
                        'impuesto':this.impuesto,
                        'total':this.total,
                        'observaciones': this.observaciones,
                        'data':this.arrayDetalle,
               }).then(()=>{ 
                   //validar si se envio todos los datos bien
                        this.$Progress.start();   
                        this.$Progress.finish();
                        this.listado=1,
                        this.listarIngreso();
                        this.idproveedor="",
                        this.tipo_comprobante="NE",
                        this.serie_comprobante="",
                        this.num_comprobante="",
                        this.total=0,
                        this.observaciones ="",
                        this.arrayDetalle=[]
                        toast({
                            type: 'success',
                            title: 'Compra Ingresada'
                            })

                 })
                 
                 .catch(()=>{ //mostrar error


                 })

                   
             },
             
             anular(){

             }
            
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
            this.listarInsumo();
            //this.buscarPorCodigo();
        },
        computed:{
            calcularTotal:function(){
                let resultado=0.0;
                for(let i=0; i<this.arrayDetalle.length; i++){
                    resultado= resultado+(this.arrayDetalle[i].precio*this.arrayDetalle[i].cantidad)
                }
                return resultado;
            }
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

