<template>
    <div class="container">
       <div class="row mt-5">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Registro de Insumos</h3>

                <div class="card-tools">
                    <button class="btn btn-success" @click="abrirModal">Registrar Insumo <i class="fas fa-user-plus fa-fw"></i></button>
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
                    <th>Marca</th>
                    <th>Tipo</th>
                    <th>Medidas</th>
                    <th>Amperaje</th>
                    <th>Tipo Aceite</th>
                    <th>Acciones</th>
                  </tr>

                  
                  <tr v-for="insumo in insumos.data" :key="insumo.id" class="text-center">
                    <td>{{insumo.nombre | upText}}</td>
                    <td>{{insumo.apellido | upText}}</td>
                    <td>{{insumo.cedula}}</td>
                    <td>{{insumo.telefono}}</td>
                    <td>{{insumo.correo}}</td>
                    <td>{{insumo.tipo}}</td>                       
                     <td>

                        <a href="#" @click="editModal(insumo)">
                            <i class="fa fa-edit"></i>
                        </a>

                    </td>
                  
                  </tr>
                 
                </tbody></table>
                
              </div>
                
              <!-- /.card-body -->
              
            </div>
             <div class="card-footer">
                  <pagination :data="insumos" @pagination-change-page="getResults" limit=-4></pagination>
              </div>
           
            <!-- /.card -->
          </div>
        </div>

        <div v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>

        <!-- Modal -->
<div class="modal fade" id="nuevoInsumo" tabindex="-1" role="dialog" aria-labelledby="nuevoInsumo" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 v-show="!editar" class="modal-title" id="nuevoInsumo">Nuevo Insumo</h5>
         <h5 v-show="editar" class="modal-title" id="nuevoInsumo">Editar datos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form @submit.prevent="editar ? actInsumo() :crearInsumo()">
                <div class="form-group">
                    <input v-model="form.marca" type="text" name="marca" placeholder="Marca"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('marca') }">
                    <has-error :form="form" field="marca"></has-error>
                </div>
                
                 <select class="form-control" v-model="form.tipo">
                    <option disabled value="">Seleccione tipo de Insumo</option>
                    <option value="Caucho">Caucho</option>
                    <option value="Bateria">Bateria</option>
                    <option value="Aceite">Aceite</option>
                </select>

                 <div class="form-group">
                    <input v-model="form.medidas" type="text" name="medidas" placeholder="Medidas de cauchos"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('medidas') }">
                    <has-error :form="form" field="medidas"></has-error>
                </div>

                 <div class="form-group">
                    <input v-model="form.amperaje" type="text" name="amperaje" placeholder="Amperaje"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('amperaje') }">
                    <has-error :form="form" field="amperaje"></has-error>
                </div>
                 <div class="form-group">
                    <input v-model="form.tipo_aceite" type="email" name="tipo_aceite" placeholder="tipo_aceite electronico"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('tipo_aceite') }">
                    <has-error :form="form" field="tipo_aceite"></has-error>
                </div>
              
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button v-show="!editar" type="submit" class="btn btn-primary">Guardar</button>
                    <button v-show="editar" type="submit" class="btn btn-success">Actualizar</button>
                </div>
</form>
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
                editar: false,
                insumos:{}, //objeto js de axios
                form : new Form({
                    id :'',
                    marca: '',
                    tipo:'',
                    medidas_caucho: '',
                    amperaje:'',
                    tipo_aceite:'',
                   
    
                })
            }

        },

        methods:{
                getResults(page = 1) {
			        axios.get('api/insumos?page=' + page)
				.then(response => {
					this.insumos = response.data;
				});
            },

            abrirModal(){
                
                this.form.reset();
                 $('#nuevoInsumo').modal('show');
                 this.editar =false;
            },

             editModal(insumo){
                this.form.reset();
                 $('#nuevoInsumo').modal('show');
                 this.form.fill(insumo);
                 this.editar=true;
            },
               
             listarInsumos(){
                axios.get("api/insumos").then(({ data })=>(this.insumos = data)); // por defecto agara al index de primero
                 
             },


             crearInsumo(){
                 
                 this.form.post('api/insumos').then(()=>{ //validar si se envio todos los datos bien
                        this.$Progress.start();
                        $('#nuevoInsumo').modal('hide')

                        this.$Progress.finish();
                        this.listarInsumos();
                        
                        toast({
                            type: 'success',
                            title: 'Insumo registrado!'
                            })

                 })
                 
                 .catch(()=>{ //mostrar error
                        
                    toast({
                            type: 'error',
                            title: 'Hay un error!'
                            })
                 })

                   
             },

             actInsumo(){
                 this.$Progress.start();
                 this.form.put('api/insumos/'+this.form.id).then(()=>{
                     $('#nuevoInsumo').modal('hide')
                     swal(
                                'Datos actualizados',
                                'Ok para continuar',
                                'success'
                                )
                     this.listarInsumos();
                     this.$Progress.finish();
                 }).catch(()=>{

                    this.$Progress.fail();
                    swal(
                                'Falló',
                                'Algo salió mal',
                                'warning'
                                )
                 })
                 //console.log('Editando');
             },

             
             
            
        },
        created() {
            Fire.$on('buscando',() =>{
                let query = this.$parent.buscar;
                
                    axios.get('api/buscarInsumo?q='+ query)
                    .then((data)=>{
                    this.insumos=data.data;
                    })
                    .catch(()=>{

                    })
                
                
            });
            this.listarInsumos();
        }
    }
</script>
