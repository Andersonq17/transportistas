<template lang="html">
    <div class="container">
       <div class="row mt-5">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Proveedores</h3>

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
                    <th>RIF</th>
                    <th>Direccion</th>
                    <th>Telefono</th>
                    <th>Status</th>
                    <th>Acciones</th>
                  </tr>

                  
                  <tr v-for="proveedor in proveedores.data" :key="proveedor.id" class="text-center">
                    <td>{{proveedor.nombre | upText}}</td>
                    <td>{{proveedor.rif | upText}}</td>
                    <td>{{proveedor.direccion}}</td>
                    <td>{{proveedor.telefono}}</td>
                    <td>
                    <div v-if="proveedor.status">
                         <span class="badge badge-success">Activo</span>

                        </div>
                        <div v-else>
                            <span class="badge badge-danger">Inactivo</span>
                        </div>
                        </td>                       
                    <td>

                        <a href="#" @click="editModal(proveedor)">
                            <i class="fa fa-edit"></i>
                        </a>
                            \
                         <a href="#" @click="borrarProveedor(proveedor.id)">
                            <i style="color:red;" class="fa fa-trash"></i>
                        </a>

                    </td>
                  
                  </tr>
                 
                </tbody></table>
                
              </div>
                
              <!-- /.card-body -->
              
            </div>
             <div class="card-footer">
                  <pagination :data="proveedores" @pagination-change-page="getResults" limit=-4></pagination>
              </div>
           
            <!-- /.card -->
          </div>
        </div>

        <div v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>

        <!-- Modal -->
<div class="modal fade" id="nuevoProv" tabindex="-1" role="dialog" aria-labelledby="nuevoProv" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 v-show="!editar" class="modal-title" id="nuevoProv">Registro Proveedor</h5>
         <h5 v-show="editar" class="modal-title" id="nuevoProv">Editar datos del Proveedor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form @submit.prevent="editar ? actProveedor() :crearProveedor()">
                <div class="form-group">
                    <input v-model="form.nombre" type="text" name="nombre" placeholder="Nombre"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('nombre') }">
                    <has-error :form="form" field="nombre"></has-error>
                </div>
                 <div class="form-group">
                    <input v-model="form.rif" type="text" name="rif" placeholder="RIF"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('rif') }">
                    <has-error :form="form" field="rif"></has-error>
                </div>

                 <div class="form-group">
                    <input v-model="form.direccion" type="text" name="direccion" placeholder="Dirección"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('direccion') }">
                    <has-error :form="form" field="direccion"></has-error>
                </div>

                 <div class="form-group">
                    <input v-model="form.telefono" type="text" name="telefono" placeholder="Telefono"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('telefono') }">
                    <has-error :form="form" field="telefono"></has-error>
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
                proveedores:{}, //objeto js de axios
                form : new Form({
                    id :'',
                    nombre: '',
                    rif:'',
                    direccion: '',
                    telefono:'',
                   status:1
    
                })
            }

        },

        methods:{
                getResults(page = 1) {
			        axios.get('api/proveedores?page=' + page)
				.then(response => {
					this.proveedores = response.data;
				});
            },

            abrirModal(){
                
                this.form.reset();
                 $('#nuevoProv').modal('show');
                 this.editar =false;
            },

             editModal(proveedor){
                this.form.reset();
                 $('#nuevoProv').modal('show');
                 this.form.fill(proveedor);
                 this.editar=true;
            },
               
             listarProveedores(){
                axios.get("api/proveedores").then(({ data })=>(this.proveedores = data)); // por defecto agara al index de primero
                 
             },


             crearProveedor(){
                 
                 this.form.post('api/proveedores').then(()=>{ //validar si se envio todos los datos bien
                        this.$Progress.start();
                        $('#nuevoProv').modal('hide')

                        this.$Progress.finish();
                        this.listarProveedores();
                        
                        toast({
                            type: 'success',
                            title: 'Proveedor registrado!'
                            })

                 })
                 
                 .catch(()=>{ //mostrar error
                        
                    toast({
                            type: 'error',
                            title: 'Hay un error!'
                            })
                 })

                   
             },

             actProveedor(){
                 this.$Progress.start();
                 this.form.put('api/proveedores/'+this.form.id).then(()=>{
                     $('#nuevoProv').modal('hide')
                     swal(
                                'Datos actualizados',
                                'Ok para continuar',
                                'success'
                                )
                     this.listarProveedores();
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

             borrarProveedor(id){
                 swal({
                    title: '¿Estas seguro de Inhabilitar este proveedor?',
                    text: "",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si'
                    }).then((result) => {

                        //enviar la peticion al servidor
                    if (result.value) { //evaluar si Si o No elimina
                        this.form.put('api/personas/'+this.form.id).then(()=>{ //llamar al metodo borrar del controlador mediante el route list
                           
                                swal(
                                'Proveedor Inhabilitado',
                                'Desactivado',
                                'success'
                                )

                                this.listarProveedores();
                    

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
                
                    axios.get('api/buscarProveedor?q='+ query)
                    .then((data)=>{
                    this.proveedores=data.data;
                    })
                    .catch(()=>{

                    })
                
                
            });
            this.listarProveedores();
        }
    }
</script>
