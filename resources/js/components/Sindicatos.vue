<template>
    <div class="container">
       <div class="row mt-5">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Administración de Sindicatos</h3>

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
                    <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>RIF</th>
                    <th>Direccion</th>
                    <th>Telefono</th>
                    <th>Correo</th>
                    <th>Estado</th>
                    <th>Presidente</th>
                  </tr>

                  
                  <tr v-for="sindi in sindicatos.data" :key="sindi.id">
                    <td>{{sindi.id}}</td>
                    <td>{{sindi.nombre | upText}}</td>
                    <td>{{sindi.rif}}</td>
                    <td>{{sindi.direccion}}</td>
                    <td>{{sindi.telefono}}</td>
                    <td>{{sindi.correo}}</td>
                    <td>{{sindi.estado | upText}}</td>
                    <td>{{sindi.id_persona}}</td>                    
                     <td>

                        <a href="#" @click="editModal(sindi)">
                            <i class="fa fa-edit"></i>
                        </a>
                            \
                         <a href="#" @click="borrarPersona(sindi.id)">
                            <i style="color:red;" class="fa fa-trash"></i>
                        </a>

                    </td>
                  
                  </tr>
                 
                </tbody></table>
              </div>
              <!-- /.card-body -->
              <div class="card footer">
                  <pagination :data="sindi" @pagination-change-page="getResults"></pagination>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>

        <div v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>

        <!-- Modal -->
<div class="modal fade" id="nuevoSindicato" tabindex="-1" role="dialog" aria-labelledby="nuevoSindicato" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 v-show="!editar" class="modal-title" id="nuevoSindicato">Agregar Nuevo Sindicato</h5>
         <h5 v-show="editar" class="modal-title" id="nuevoSindicato">Editar datos del Sindicato</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form @submit.prevent="editar ? actSindicato() :crearSindicato()">
                <div class="form-group">
                    <input v-model="form.nombre" type="text" name="nombre" placeholder="Nombre Completo del Sindicato"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('nombre') }">
                    <has-error :form="form" field="nombre"></has-error>
                </div>
                 <div class="form-group">
                    <input v-model="form.rif" type="text" name="rif" placeholder="RIF Sindicato"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('rif') }">
                    <has-error :form="form" field="rif"></has-error>
                </div>

                 <div class="form-group">
                    <input v-model="form.direccion" type="text" name="direccion" placeholder="Direccion"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('direccion') }">
                    <has-error :form="form" field="direccion"></has-error>
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
                 <div class="form-group">
                    <input v-model="form.estado" type="text" name="estado" placeholder="Estado"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('estado') }">
                    <has-error :form="form" field="estado"></has-error>
                </div>
                <select value="Seleccione al presidente del sindicato" class="form-group">
                    <option ></option>
                    
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
                sindicatos:{}, //objeto js de axios
                sindi:'',
                form : new Form({
                    id :'',
                    nombre: '',
                    rif:'',
                    direccion: '',
                    telefono:'',
                    correo:'',
                    estado:'',
                    id_persona:0
    
                })
            }

        },

        methods:{
                getResults(page = 1) {
			        axios.get('api/sindicatos?page=' + page)
				.then(response => {
					this.sindicatos = response.data;
				});
            },

            abrirModal(){
                
                this.form.reset();
                 $('#nuevoSindicato').modal('show');
                 this.editar =false;
            },

             editModal(sindi){
                this.form.reset();
                 $('#nuevoSindicato').modal('show');
                 this.form.fill(sindi);
                 this.editar=true;
            },
               
             listarSindicatos(){
                axios.get("api/sindicatos").then(({ data })=>(this.sindicatos =data)); // por defecto agara al index de primero
                 
             },


             crearSindicatos(){
                 
                 this.form.post('api/sindicatos').then(()=>{ //validar si se envio todos los datos bien
                        this.$Progress.start();
                        $('#nuevoSindicato').modal('hide')

                        this.$Progress.finish();
                        this.listarSindicatos();
                        
                        toast({
                            type: 'success',
                            title: 'Nuevo Sindicato registrado!'
                            })

                 })
                 
                 .catch(()=>{ //mostrar error
                        
                    toast({
                            type: 'error',
                            title: 'Hay un error!'
                            })
                 })

                   
             },

             actSindicato(){
                 this.$Progress.start();
                 this.form.put('api/sindicatos/'+this.form.id).then(()=>{
                     $('#nuevoSindicato').modal('hide')
                     swal(
                                'Datos actualizados',
                                'Ok para continuar',
                                'success'
                                )
                     this.listarSindicatos();
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

             borrarSindicato(id){
                 swal({
                    title: '¿Estas seguro de eliminar este Sindicato?',
                    text: "¡Esta acción llevará que muchas lineas de transporte queden sin sindicato!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si'
                    }).then((result) => {

                        //enviar la peticion al servidor
                    if (result.value) { //evaluar si Si o No elimina
                        this.form.delete('api/sindicatos/'+id).then(()=>{ //llamar al metodo borrar del controlador mediante el route list
                           
                                swal(
                                'Eliminado',
                                ' Sindicato eliminado',
                                'success'
                                )

                                this.listarSindicatos();
                    

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
                
                    axios.get('api/buscarSindicato?q='+ query)
                    .then((data)=>{
                    this.sindicatos=data.data;
                    })
                    .catch(()=>{

                    })
                
            });
            this.listarSindicatos();
        }
    }
</script>
