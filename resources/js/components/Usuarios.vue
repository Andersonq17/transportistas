<template>
    <div class="container">
       <div class="row mt-5">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Administración de usuarios</h3>

                <div class="card-tools">
                    <button class="btn btn-success" data-toggle="modal" data-target="#nuevoUsuario">Crear Nuevo <i class="fas fa-user-plus fa-fw"></i></button>
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
                    <th>Usuario</th>
                    <th>Email</th>
                    <th>Tipo</th>
                    <th>Fecha de registro</th>
                    <th>Opciones</th>
                  </tr>

                  
                  <tr v-for="user in users" :key="user.id">
                    <td>{{user.id}}</td>
                    <td>{{user.name | upText}}</td>
                    <td>{{user.email}}</td>
                    <td>{{user.type | upText}}</td>
                    <td>{{user.created_at | fechas}}</td>
                     <td>

                        <a href="#">
                            <i class="fa fa-edit"></i>
                        </a>
                            \
                         <a href="#">
                            <i class="fa fa-trash"></i>
                        </a>

                    </td>
                  </tr>
                 
                </tbody></table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>

        <!-- Modal -->
<div class="modal fade" id="nuevoUsuario" tabindex="-1" role="dialog" aria-labelledby="nuevoUsuario" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="nuevoUsuario">Agregar Nuevo Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form @submit.prevent="crearUsuario">
                <div class="form-group">
                    <input v-model="form.name" type="text" name="name" placeholder="Nombre de usuario"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                    <has-error :form="form" field="name"></has-error>
                </div>
                 <div class="form-group">
                    <input v-model="form.password" type="password" name="password" placeholder="Contraseña"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                    <has-error :form="form" field="password"></has-error>
                </div>

                 <div class="form-group">
                    <input v-model="form.email" type="text" name="email" placeholder="Correo electronico"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                    <has-error :form="form" field="email"></has-error>
                </div>

                 <div class="form-group">
                    <select v-model="form.type" type="text" name="type"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                        <option value="0">Seleccione rol de usuario</option>
                        <option value="admin">Administrador</option>
                        <option value="usuario">Usuario Estandar</option>
                    </select>
                    <has-error :form="form" field="type"></has-error>
                </div>

                <div class="form-group">
                    <label for="exampleFormControlFile1">Subir foto de perfil</label>
                    <input type="file" class="form-control-file" id="exampleFormControlFile1">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
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
                users:{}, //objeto js de axios
                form : new Form({
                    name: '',
                    email:'',
                    password: '',
                    type:0,
                    
                })
            }

        },

        methods:{
               
             listarUsuarios(){
                 axios.get("api/user").then(({ data })=>(this.users = data.data)); //(api/user) por defecto agara al index de primero
             },

             crearUsuario(){
                 this.$Progress.start();
                 this.form.post('api/user');

                    toast({
                    type: 'success',
                    title: 'Usuario creado con exito!'
                    })

                    $('#nuevoUsuario').modal('hide')

                 this.$Progress.finish();
                 this.listarUsuarios();
             }
             
            
        },

        created() {
            this.listarUsuarios();
        }
    }
</script>
