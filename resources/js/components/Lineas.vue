<template>
    <div class="container">
       <div class="row mt-5">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Administración Lineas de transporte</h3>

                <div class="card-tools">
                    <button class="btn btn-success" @click="abrirModal">Nueva Linea <i class="fas fa-plus fa-fw"></i></button>
                  
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody>
                    <tr class="text-center">
                    <th>Nombre</th>
                    <th>RIF</th>
                    <th>Municipio</th>
                    <th>Correo</th>
                    <th>Telefono</th>
                    <th>Tipo de Ruta</th>
                    <th>Representante</th>
                    <th>Sindicato</th>
                    <th>Status</th>
                    <th>Acciones</th>
                  </tr>

                  
                  <tr v-for="linea in lineas.data" :key="linea.id" class="text-center">
                    <td>{{linea.nombre | upText}}</td>
                    <td>{{linea.rif | upText}}</td>
                    <td>{{linea.municipio | upText}}</td>
                    <td>{{linea.correo}}</td>
                     <td>{{linea.telefono}}</td>
                    <td>{{linea.tipo_ruta}}</td>
                    <td>{{linea.presidente+' '+linea.apellido |upText}}</td>
                    <td>{{linea.nombre_sindicato}}</td>
                    
                    <td>
                    <div v-if="linea.status">
                         <span class="badge badge-success">Activa</span>

                        </div>
                        <div v-else>
                            <span class="badge badge-danger">Inactiva</span>
                        </div>
                        </td>
                                          
                     <td>

                        <a href="#" @click="editModal(linea)">
                            <i class="fa fa-edit"></i>
                        </a>
                            |
                         <a href="#" @click="borrarLinea(linea.id)">
                            <i style="color:red;" class="fa fa-trash"></i>
                        </a>

                    </td>
                  
                  </tr>
                 
                </tbody></table>
              </div>
              <!-- /.card-body -->
              <div class="card footer">
                  <pagination :data="lineas" @pagination-change-page="getResults"></pagination>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>

        <div v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>

        <!-- Modal -->
<div class="modal fade" id="nuevaLinea" tabindex="-1" role="dialog" aria-labelledby="nuevaLinea" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 v-show="!editar" class="modal-title" id="nuevaLinea">Agregar Nueva Linea de Transporte</h5>
         <h5 v-show="editar" class="modal-title" id="nuevaLinea">Editar datos de Linea de transporte</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form @submit.prevent="editar ? actLinea() :crearLinea()">
                <div class="form-group">
                    <input v-model="form.nombre" type="text" name="nombre" placeholder="Nombre completo de la linea"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('nombre') }">
                    <has-error :form="form" field="nombre"></has-error>
                </div>
                 <div class="form-group">
                    <input v-model="form.rif" type="text" name="rif" placeholder="RIF"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('rif') }">
                    <has-error :form="form" field="rif"></has-error>
                </div>

                 <div class="form-group">
                    <input v-model="form.correo" type="email" name="correo" placeholder="Correo"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('correo') }">
                    <has-error :form="form" field="correo"></has-error>
                </div>

                 <div class="form-group">
                    <input v-model="form.direccion" type="text" name="direccion" placeholder="Direccion"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('direccion') }">
                    <has-error :form="form" field="direccion"></has-error>
                </div>
                 <div class="form-group">
                    <input v-model="form.estado" type="text" name="estado" placeholder="Estado"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('estado') }">
                    <has-error :form="form" field="estado"></has-error>
                </div>
                <div class="form-group">
                    <input v-model="form.municipio" type="text" name="municipio" placeholder="Municipio"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('municipio') }">
                    <has-error :form="form" field="municipio"></has-error>
                </div>
                <div class="form-group">
                    <input v-model="form.telefono" type="text" name="telefono" placeholder="Numero de telefono"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('telefono') }">
                    <has-error :form="form" field="telefono"></has-error>
                </div>
                
                  <div class="form-group">
                <select class="form-control" v-model="form.id_persona">
                    <option disabled value="">Seleccione Presidente de Linea</option>
                    <option v-for="persona in select" :key="persona.id" :value="persona.id" v-text="persona.nombre+ ' ' +persona.apellido+ ' ' +persona.cedula"></option>
                </select>
                
                </div>
                <div class="form-group">
                <select class="form-control" v-model="form.id_sindicato">
                    <option disabled value="">Seleccione Sindicato al que pertenece</option>
                    <option v-for="sindicato in selectS" :key="sindicato.id" :value="sindicato.id" v-text="sindicato.nombre"></option>
                </select>
                </div>
                <div class="form-group">
                    <input v-model="form.cps" type="text" name="cps" placeholder="Numero de cps (opcional)"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('cps') }">
                    <has-error :form="form" field="cps"></has-error>
                </div>
               <select class="form-control" v-model="form.tipo_ruta">
                    <option disabled value="">Seleccione tipo de Ruta</option>
                    <option value="Urbana">Urbana</option>
                    <option value="SubUrbana">Sub-Urbana</option>
                    <option value="InterUrbana">Inter-Urbana</option>
                    <option value="Periferica">Periferica</option>
                    <option value="ExtraUrbana">Extra-Urbana</option>
                   
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
                lineas:{},
                select:{},
                selectS:{}, //objeto js de axios
                form : new Form({
                    id :'',
                    nombre: '',
                    rif:'',
                    correo: '',
                    direccion:'',
                    estado:'',
                    municipio:'',
                    telefono:'',
                    tipo_ruta:'',
                    id_persona:'',
                    id_sindicato:'',
                    cps:'',
                    cedula:'',
                      
                })
            }

        },

        methods:{
                getResults(page = 1) {
			        axios.get('api/lineas?page=' + page)
				.then(response => {
					this.lineas = response.data;
				});
            },

            abrirModal(){
                
                this.form.reset();
                 $('#nuevaLinea').modal('show');
                 this.editar =false;
            },

             editModal(linea){
                this.form.reset();
                 $('#nuevaLinea').modal('show');
                 this.form.fill(linea);
                 this.editar=true;
            },
               
             listarLineas(){
                axios.get("api/lineas").then(({ data })=>(this.lineas = data)); // por defecto agara al index de primero
                 
             },


             crearLinea(){
                 
                 this.form.post('api/lineas').then(()=>{ //validar si se envio todos los datos bien
                        this.$Progress.start();
                        $('#nuevaLinea').modal('hide')

                        this.$Progress.finish();
                        this.listarLineas();
                        
                        toast({
                            type: 'success',
                            title: 'Nueva linea registrada!'
                            })

                 })
                 
                 .catch(()=>{ //mostrar error
                        
                    toast({
                            type: 'error',
                            title: 'Hay un error!'
                            })
                 })

                   
             },

                selectPersona(){
                axios.get('api/selectPersona').then((data)=>{
                    this.select=data.data;
                    })
                    .catch(()=>{

                    })
            },

             selectSindicato(){
                axios.get('api/selectSindicato').then((data)=>{
                    this.selectS=data.data;
                    })
                    .catch(()=>{

                    })
            },
             actLinea(){
                 this.$Progress.start();
                 this.form.put('api/lineas/'+this.form.id).then(()=>{
                     $('#nuevaLinea').modal('hide')
                     swal(
                                'Datos actualizados',
                                'Ok para continuar',
                                'success'
                                )
                     this.listarLineas();
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

             borrarLinea(id){
                 swal({
                    title: '¿Estas seguro de eliminar esta Linea de transporte?',
                    text: "¡Esta acción no se puede revertir! Muchas unidades de transporte se quedarán sin linea ",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si'
                    }).then((result) => {

                        //enviar la peticion al servidor
                    if (result.value) { //evaluar si Si o No elimina
                        this.form.put('api/lineas/desactivar/'+this.form.id).then(()=>{ //llamar al metodo borrar del controlador mediante el route list
                           
                                swal(
                                'Eliminado',
                                'Linea de Transporte eliminada',
                                'success'
                                )

                                this.listarLineas();
                    

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
                
                    axios.get('api/buscarLinea?q='+ query)
                    .then((data)=>{
                    this.lineas=data.data;
                    })
                    .catch(()=>{

                    })
                
                
            });
            this.listarLineas();
            this.selectPersona();
            this.selectSindicato();
        }
    }
</script>
