<template>
    <div class="container">
       <div class="row mt-5">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Administración de datos de Conductores y Socios</h3>

                <div class="card-tools">
                    <button class="btn btn-success" @click="abrirModal">Registrar Nuevo <i class="fas fa-user-plus fa-fw"></i></button>
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
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Cedula</th>
                    <th>Telefono</th>
                    <th>Correo</th>
                    <th>Tipo</th>
                    <th>Acciones</th>
                  </tr>

                  
                  <tr v-for="persona in personas.data" :key="persona.id" class="text-center">
                    <td>{{persona.nombre | upText}}</td>
                    <td>{{persona.apellido | upText}}</td>
                    <td>{{persona.cedula}}</td>
                    <td>{{persona.telefono}}</td>
                    <td>{{persona.correo}}</td>
                    <td>{{persona.tipo}}</td>                       
                     <td>

                        <a href="#" @click="editModal(persona)">
                            <i class="fa fa-edit"></i>
                        </a>
                            \
                         <a href="#" @click="borrarPersona(persona.id)">
                            <i style="color:red;" class="fa fa-trash"></i>
                        </a>

                    </td>
                  
                  </tr>
                 
                </tbody></table>
                
              </div>
                
              <!-- /.card-body -->
              
            </div>
             <div class="card-footer">
                  <pagination :data="personas" @pagination-change-page="getResults" limit=-4></pagination>
              </div>
           
            <!-- /.card -->
          </div>
        </div>

        <div v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>

        <!-- Modal -->
<div class="modal fade" id="nuevoChofer" tabindex="-1" role="dialog" aria-labelledby="nuevoChofer" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 v-show="!editar" class="modal-title" id="nuevoChofer">Agregar Nuevo Chofer</h5>
         <h5 v-show="editar" class="modal-title" id="nuevoChofer">Editar datos del Chofer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form @submit.prevent="editar ? actPersona() :crearPersona()">
                <div class="form-group">
                    <input v-model="form.nombre" type="text" name="nombre" placeholder="Nombre"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('nombre') }">
                    <has-error :form="form" field="nombre"></has-error>
                </div>
                 <div class="form-group">
                    <input v-model="form.apellido" type="text" name="apellido" placeholder="Apellido"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('apellido') }">
                    <has-error :form="form" field="apellido"></has-error>
                </div>

                 <div class="form-group">
                    <input v-model="form.cedula" type="text" name="cedula" placeholder="Cedula de Identidad"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('cedula') }">
                    <has-error :form="form" field="cedula"></has-error>
                </div>

                 <div class="form-group">
                    <input v-model="form.telefono" type="text" name="telefono" placeholder="Telefono"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('telefono') }">
                    <has-error :form="form" field="telefono"></has-error>
                </div>
                 <div class="form-group">
                    <input v-model="form.correo" type="email" name="correo" placeholder="Correo electronico"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('correo') }">
                    <has-error :form="form" field="correo"></has-error>
                </div>
               <select class="form-control" v-model="form.tipo">
                    <option disabled value="">Seleccione tipo de Conductor</option>
                    <option value="Conductor">Conductor</option>
                    <option value="Socio">Socio</option>
                   
                </select>
                
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
                personas:{}, //objeto js de axios
                form : new Form({
                    id :'',
                    nombre: '',
                    apellido:'',
                    cedula: '',
                    telefono:'',
                    correo:'',
                    tipo:''
    
                })
            }

        },

        methods:{
                getResults(page = 1) {
			        axios.get('api/personas?page=' + page)
				.then(response => {
					this.personas = response.data;
				});
            },

            abrirModal(){
                
                this.form.reset();
                 $('#nuevoChofer').modal('show');
                 this.editar =false;
            },

             editModal(persona){
                this.form.reset();
                 $('#nuevoChofer').modal('show');
                 this.form.fill(persona);
                 this.editar=true;
            },
               
             listarPersonas(){
                axios.get("api/personas").then(({ data })=>(this.personas = data)); // por defecto agara al index de primero
                 
             },


             crearPersona(){
                 
                 this.form.post('api/personas').then(()=>{ //validar si se envio todos los datos bien
                        this.$Progress.start();
                        $('#nuevoChofer').modal('hide')

                        this.$Progress.finish();
                        this.listarPersonas();
                        
                        toast({
                            type: 'success',
                            title: 'Chofer registrado!'
                            })

                 })
                 
                 .catch(()=>{ //mostrar error
                        
                    toast({
                            type: 'error',
                            title: 'Hay un error!'
                            })
                 })

                   
             },

             actPersona(){
                 this.$Progress.start();
                 this.form.put('api/personas/'+this.form.id).then(()=>{
                     $('#nuevoChofer').modal('hide')
                     swal(
                                'Datos actualizados',
                                'Ok para continuar',
                                'success'
                                )
                     this.listarPersonas();
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

             borrarPersona(id){
                 swal({
                    title: '¿Estas seguro de eliminar esta persona?',
                    text: "¡Esta acción no se puede revertir!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si'
                    }).then((result) => {

                        //enviar la peticion al servidor
                    if (result.value) { //evaluar si Si o No elimina
                        this.form.delete('api/personas/'+id).then(()=>{ //llamar al metodo borrar del controlador mediante el route list
                           
                                swal(
                                'Eliminado',
                                'El usuario ha sido eliminado',
                                'success'
                                )

                                this.listarPersonas();
                    

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
                
                    axios.get('api/buscarPersona?q='+ query)
                    .then((data)=>{
                    this.personas=data.data;
                    })
                    .catch(()=>{

                    })
                
                
            });
            this.listarPersonas();
        }
    }
</script>
