<template>
    <div class="container">
       <div class="row mt-5">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Unidades de transporte</h3>

                <div class="card-tools">
                    <button class="btn btn-success" @click="abrirModal">Registrar Nueva Unidad <i class="fas fa-plus fa-fw"></i></button>
                  
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody>
                    <tr class="text-center">
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Año</th>
                    <th>Placa</th>
                    <th>Tipo</th>
                    <th>Número de Cupo</th>
                    <th>Status</th>
                    <th>Organización</th>
                    <th>Propietario</th>
                    <th>Acciones</th>
                  </tr>

                  
                  <tr v-for="unidad in unidades.data" :key="unidad.id" class="text-center">
                    <td>{{unidad.marca | upText}}</td>
                    <td>{{unidad.modelo | upText}}</td>
                    <td>{{unidad.anio}}</td>
                    <td>{{unidad.placa}}</td>
                    <td>{{unidad.tipo | upText}}</td>
                    <td>{{unidad.numero_cupo}}</td> 
                     <td>
                    <div v-if="unidad.status">
                         <span class="badge badge-success">Activa</span>

                        </div>
                        <div v-else>
                            <span class="badge badge-danger">Inactiva</span>
                        </div>
                        </td>
                    <td>{{unidad.nombre_linea}}</td>
                    <td>{{unidad.propietario+' '+unidad.apellido |upText}}</td>
                     <td>

                        <a href="#" @click="editModal(unidad)">
                            <i class="fa fa-edit"></i>
                        </a>
                            |
                         <a href="#" @click="borrarUnidad(unidad.id)">
                            <i style="color:red;" class="fa fa-trash"></i>
                        </a>

                    </td>                        
                  
                  </tr>
                 
                </tbody></table>
              </div>
              <!-- /.card-body -->
              <div class="card footer">
                  <pagination :data="unidades" @pagination-change-page="getResults"></pagination>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>

        <div v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>

        <!-- Modal -->
<div class="modal fade" id="nuevaUnidad" tabindex="-1" role="dialog" aria-labelledby="nuevaUnidad" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 v-show="!editar" class="modal-title" id="nuevaUnidad">Agregar Nueva Unidad de Transporte</h5>
         <h5 v-show="editar" class="modal-title" id="nuevaUnidad">Editar datos de Unidad de transporte</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form @submit.prevent="editar ? actUnidad() :crearUnidad()">
                <div class="form-group">
                    <input v-model="form.marca" type="text" name="marca" placeholder="Marca del Vehiculo"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('marca') }">
                    <has-error :form="form" field="marca"></has-error>
                </div>
                 <div class="form-group">
                    <input v-model="form.modelo" type="text" name="modelo" placeholder="Modelo"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('modelo') }">
                    <has-error :form="form" field="modelo"></has-error>
                </div>

                 <div class="form-group">
                    <input v-model="form.anio" type="text" name="anio" placeholder="Año del Vehiculo"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('anio') }">
                    <has-error :form="form" field="anio"></has-error>
                </div>

                 <div class="form-group">
                    <input v-model="form.placa" type="text" name="placa" placeholder="Placa"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('placa') }">
                    <has-error :form="form" field="placa"></has-error>
                </div>
                <div class="form-group">
                 <select class="form-control" v-model="form.tipo"
                 :class="{ 'is-invalid': form.errors.has('tipo') }">
                    <has-error :form="form" field="tipo"></has-error>>
                    <option disabled value="">Seleccione tipo de Vehiculo</option>
                    <option value="Autobus">Autobus</option>
                    <option value="Minibus">Minibus</option>
                    <option value="Rustico">Rustico</option>
                    <option value="Por Puesto">Por Puesto</option>
                    <option value="Van">Van</option>
                </select>
                </div>
                
                <div class="form-group">
                    <input v-model="form.numero_cupo" type="text" name="numero_cupo" placeholder="Numero de cupo (opcional)"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('numero_cupo') }">
                    <has-error :form="form" field="numero_cupo"></has-error>
                </div>
                <div class="form-group">
                <select class="form-control" v-model="form.status">
                    <option disabled value="0">Seleccione Condición del Vehiculo</option>
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </select>
                </div>
                
                 <div class="form-group">
                 <select class="form-control" v-model="form.id_linea" :class="{ 'is-invalid': form.errors.has('id_linea') }">
                    <has-error :form="form" field="id_linea"></has-error>>
                    <option disabled value="0">Seleccione organización a la que pertenece</option>
                    <option v-for="linea in selectL" :key="linea.id" :value="linea.id" v-text="linea.nombre"></option>
                </select>
                </div>

                <div class="form-group">
                <select class="form-control" v-model="form.id_persona" :class="{ 'is-invalid': form.errors.has('id_persona') }">
                    <has-error :form="form" field="id_persona"></has-error>>
                    <option disabled value="0">Seleccione Propietario del Vehiculo</option>
                    <option v-for="persona in select" :key="persona.id" :value="persona.id" v-text="persona.nombre+ ' ' +persona.apellido"></option>
                </select>
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
                unidades:{},
                select:{},
                selectL:{}, //objeto js de axios
                form : new Form({
                    id :'',
                    marca: '',
                    modelo:'',
                    anio: '',
                    placa:'',
                    tipo:'',
                    numero_cupo:'',
                    status:0,
                    id_linea:0,
                    id_persona:0
    
                })
            }

        },

        methods:{
                getResults(page = 1) {
			        axios.get('api/unidades?page=' + page)
				.then(response => {
					this.unidades = response.data;
				});
            },

            abrirModal(){
                
                this.form.reset();
                 $('#nuevaUnidad').modal('show');
                 this.editar =false;
            },

             editModal(linea){
                this.form.reset();
                 $('#nuevaUnidad').modal('show');
                 this.form.fill(linea);
                 this.editar=true;
            },
               
             listarUnidades(){
                axios.get("api/unidades").then(({ data })=>(this.unidades = data)); // por defecto agara al index de primero
                 
             },


             crearUnidad(){
                 
                 this.form.post('api/unidades').then(()=>{ //validar si se envio todos los datos bien
                        this.$Progress.start();
                        $('#nuevaUnidad').modal('hide')

                        this.$Progress.finish();
                        this.listarUnidades();
                        
                        toast({
                            type: 'success',
                            title: 'Nueva Unidad de transporte registrada!'
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

            selectLinea(){
                axios.get('api/selectLinea').then((data)=>{
                    this.selectL=data.data;
                    })
                    .catch(()=>{

                    })
            },

             actUnidad(){
                 this.$Progress.start();
                 this.form.put('api/unidades/'+this.form.id).then(()=>{
                     $('#nuevaUnidad').modal('hide')
                     swal(
                                'Datos actualizados',
                                'Ok para continuar',
                                'success'
                                )
                     this.listarUnidades();
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

             borrarUnidad(id){
                 swal({
                    title: '¿Estas seguro de eliminar esta Unidad de transporte?',
                    text: "¡Esta acción no se puede revertir!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si'
                    }).then((result) => {

                        //enviar la peticion al servidor
                    if (result.value) { //evaluar si Si o No elimina
                        this.form.delete('api/unidades/'+id).then(()=>{ //llamar al metodo borrar del controlador mediante el route list
                           
                                swal(
                                'Eliminado',
                                'Unidad de Transporte eliminada',
                                'success'
                                )

                                this.listarUnidades();
                    

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
                
                    axios.get('api/buscarUnidad?q='+ query)
                    .then((data)=>{
                    this.unidades=data.data;
                    })
                    .catch(()=>{

                    })
                
                
            });
            this.listarUnidades();
            this.selectPersona();
            this.selectLinea();
        }
    }
</script>
