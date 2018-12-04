<style>
.widget-user-header{
  background-position: center center;
  background-size: cover;
  height: 350px;
}
</style>


<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-3">
                <div class="card card-default">
                    
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-info-active" style="background-image:url('./img/banner.png')">
               
              </div>
              <!--<div class="widget-user-image">
                <img class="img-circle elevation-2" src="" alt="User Avatar">
              </div>-->
              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                       <h3 class="widget-user-username" v-text="form.name"></h3>
                        <h5 class="widget-user-desc" v-text="form.cargo"></h5>
                    </div>
                  

                  </div>
                    <div class="col-sm-8 border-right">
                    <div class="description-block">
                    <div class="widget-user-image">
                      <img class="img-circle elevation-2" src="" alt="User Avatar">
                    </div>
                    </div>
                    </div>
                 
                </div>
                <!-- /.row -->
              </div>
            
            </div>
        </div>
    </div>
  
              		<div class="col-md-9">
                      <div class="card">
                          <div class="card-body">
                              <div class="row">
                                  <div class="col-md-12">
                                      <h4>Tus Datos</h4>
                                      <hr>
                                  </div>
                              </div>
                                  <div class="row">
                                      <div class="col-md-12">
                                          <form>
                                                <div class="form-group row">
                                                  <label for="username" class="col-4 col-form-label">Nombre Usuario</label> 
                                                  <div class="col-8">
                                                    <input v-model="form.name" id="username" name="username" placeholder="Usuario" class="form-control here" 
                                                    :class="{ 'is-invalid': form.errors.has('name') }" required="required" type="text">
                                                    <has-error :form="form" field="email"></has-error>
                                                  </div>
                                                </div>
                                                
                                                
                                              
                                                <div class="form-group row">
                                                  <label for="email" class="col-4 col-form-label">Email</label> 
                                                  <div class="col-8">
                                                    <input v-model="form.email" id="email" name="email" placeholder="Email" class="form-control here" 
                                                    :class="{ 'is-invalid': form.errors.has('email') }" required="required" type="text">
                                                    <has-error :form="form" field="email"></has-error>
                                                  </div>
                                                </div>
                                                
                                                <div class="form-group row">
                                                  <label for="publicinfo" class="col-4 col-form-label">Cargo</label> 
                                                  <div class="col-8">
                                                    <textarea v-model="form.cargo" id="publicinfo" name="publicinfo" cols="40" rows="4" class="form-control"
                                                    :class="{ 'is-invalid': form.errors.has('cargo') }" placeholder="Breve descricpion del cargo"></textarea>
                                                    <has-error :form="form" field="cargo"></has-error>
                                                  </div>
                                                </div>
                                                <div class="form-group row">
                                                  <label for="exampleFormControlFile1">Subir foto de perfil</label>
                                                  <div class="col-8">
                                                    <input type="file" @change="subirFoto" class="form-control-file" id="exampleFormControlFile1">
                                                  </div>
                                                </div>
                                                <div class="form-group row">
                                                  <label for="newpass" class="col-4 col-form-label">Nueva Contraseña</label> 
                                                  <div class="col-8">
                                                    <input id="password" name="password" v-model="form.password" placeholder="Nueva contraseña" class="form-control here" 
                                                    :class="{ 'is-invalid': form.errors.has('password') }" type="text">
                                                    <has-error :form="form" field="password"></has-error>
                                                  </div>
                                                </div> 
                                                <div class="form-group row">
                                                  <div class="offset-4 col-8">
                                                    <button name="submit" @click.prevent="actPerfil" type="submit" class="btn btn-success">Actualizar mi Perfil</button>
                                                  </div>
                                                </div>
                                              </form>
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
          form : new Form({
                    id :'',
                    name: '',
                    email:'',
                    password: '',
                    type:0,
                    cargo:'',
                    foto:''
                    
                })
        }
      },
        mounted() {
            console.log('Component mounted.')
        },

        methods:{

          actPerfil(){
            this.$Progress.start();
            this.form.put('api/Perfil').then(()=>{
              

              this.$Progress.finish();
            }).catch(()=>{

              this.$Progress.fail();

            })
          },

          subirFoto(e){
            //console.log('Subiendo...')

            let file= e.target.files[0];//aqui agarra el archivo
            console.log(file);
            let reader= new FileReader();
            //let me = this;

            if(file['size'] < 2111775){
               reader.onloadend = (file)=>{
              //console.log('RESULT',reader.result);
              this.form.foto = reader.result; //aqui lo convierte en base64 string
            }

               reader.readAsDataURL(file); //leer como url

            }else{
              swal({
                  type: 'error',
                  title:'Ha ocurrido un error',
                  text: 'Debes subir un archivo menor a 2MB'
              }
                
              )

            }
            
          }

        },

        created(){
            axios.get('api/Perfil').then(({data})=>(this.form.fill(data))); //llena todos los datos del objeto form
            //junto con las variable que esten en ese objeto

        }
    }
</script>
