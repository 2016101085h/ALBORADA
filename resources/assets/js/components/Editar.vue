<template>
    
  <main class="content-wrapper">
            
  

        
          
        
     

    <!-- Main content -->
    <section class="content contenido"  >
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Perfil</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Escritorio</a></li>
              <li class="breadcrumb-item active">Editar Perfil de Usuario</li>
            </ol>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6" style="margin:0 auto">
            <div class="card">
                <div class="card-header bg-info text-uppercase text-bold ">
                  <i class="fa fa-align-justify"></i> Editar Perfil de Usuario 
               
                </div>
              <!-- /.card-header -->
              <div class="card-body ">
                <form action="" method="post" enctype="multipart/form-data" class="form-horizontal ">
            
             
            <div class="form-group row">
               <label class="col-md-3 form-control-label" for="email-input">Nombre </label>
               <div class="col-md-9">
                 <input type="text" v-model="auth.nombre" class="form-control" placeholder="Ingrese el Nombre">
               </div>
             </div> 
            <div class="form-group row">
               <label class="col-md-3 form-control-label" for="email-input">Apellidos</label>
               <div class="col-md-9">
                 <input type="text" @change="toUpper()" v-model="auth.apellido" class="form-control" placeholder="Ingrese el Apellido">
               </div>
             </div> 
            <div class="form-group row">
               <label class="col-md-3 form-control-label" for="email-input">Fecha de Nacimiento</label>
               <div class="col-md-9">
                 <input type="date" v-model="auth.fech_nacimiento" class="form-control" placeholder="Ingrese la fecha de su Nacimiento">
               </div>
             </div> 
             <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input">Sexo</label>
                <div class="col-md-9">
                    <!-- <select v-model="auth.sexo" class="form-control">
                        <option value="sexo" disabled>Selecciona tu sexo</option>
                        <option value="masculino">Masculino</option>
                        <option value="femenino">Femenino</option>
                        
                    </select>    -->
                    <v-select v-model="auth.sexo" :options="['masculino','femenino']" placeholder="Seleccione su Sexo"></v-select>                                 
                </div>
            </div> 
            <div class="form-group row">
               <label class="col-md-3 form-control-label" for="email-input">DNI</label>
               <div class="col-md-9">
                 <input type="number" v-model="auth.dni" class="form-control" placeholder="Ingrese el DNI">
               </div>
             </div> 
            <div class="form-group row">
               <label class="col-md-3 form-control-label" for="email-input">Celular</label>
               <div class="col-md-9">
                 <input type="number" v-model="auth.num_celular" class="form-control" placeholder="Ingrese el numero de celular">
               </div>
             </div> 
            <div class="form-group row">
               <label class="col-md-3 form-control-label" for="email-input">Dirección</label>
               <div class="col-md-9">
                 <input type="text" v-model="auth.direccion" class="form-control" placeholder="Ingrese la Dirección">
               </div>
             </div> 
            <div class="form-group row">
               <label class="col-md-3 form-control-label" for="email-input">Nombre del Usuario</label>
               <div class="col-md-9">
                 <input type="text" v-model="auth.usuario" class="form-control" placeholder="Ingrese el Nombre del Usuario">
               </div>
             </div> 
            <div class="form-group row">
               <label class="col-md-3 form-control-label" for="email-input">Contraseña del Usuario</label>
               <div class="col-md-9">
                 <input type="text" v-model="auth.password" class="form-control" placeholder="Ingrese la contraseña del Usuario">
               </div>
             </div> 
           
                 <div class="form-group row">
              <label class="col-md-3 form-control-label" for="text-input">Imagen</label>
              <div class="col-md-9">
                  
                  <!--poniendo :src se llama a la variable imagen que esta declarada en la propiedad data-->
                      <!--poner this.imagen=""; en cerrarModal para limpiar el campo ya que aparecia la imagen al registrar un registro-->
                  <div>
                      <input type="file" @change="subirImagen" class="form-control" placeholder="">
                      <img :src="auth.imagen" class="img-fluid" width="100px" height="100px">
                  </div>
                    
                  
              </div>
            </div>
            
           
             
        
              <div v-show="errorPersona" class="form-group row div-error">
                <div class="text-center text-error">
                    <div v-for="error in errorMostrarMsjPersona" :key="error" v-text="error">
                        
                    </div>
                  
                </div>
            </div>
           </form>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix text-right">
                   <!-- <button  @click="cerrarModal()" type="button" class="btn btn-danger" ><i class="fas fa-window-close mr-1"></i> Cerrar</button> -->
           
           <button  type="button" class="btn btn-warning" @click="actualizarPersona()"><i class="fas fa-pen-alt mr-1"></i> Actualizar</button>
              </div>
            </div>
            <!-- /.card -->

          
          </div>
          <!-- /.col -->
          
        </div>
        <!-- /.row -->
        
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  
   <!--Fin del modal-->
   
   <!-- Fin del modal Eliminar -->
   <!-- Profile Image -->
           

  </main>
 
  
</template>

<script>
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';
var moment = require('moment');
moment().format();
    export default {
        data(){
            return{
              moment:moment,
              imagen:'',
               persona_id: 0,
                id:0,
                nombre : '',
                apellido : '',
                sexo : '',
                dni : '',
                num_celular : '',
                fech_nacimiento : '',
                direccion : '',
                usuario : '',
                password : '',
                rol:'',
                rol_id : 0,
                arrayPersona : [],
                arrayRol : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorPersona : 0,
                errorMostrarMsjPersona : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'nombre',
                buscar : '',
                auth: []


            }
        },
        components:{
            vSelect
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //calcula los elemenos de la paginacion
            pagesNumber: function(){
                if(!this.pagination.to){
                    return [];
                }
                var from = this.pagination.current_page-this.offset;
                if(from<1){
                    from=1;
                }
                var to = from+(this.offset*2);
                if(to>=this.pagination.last_page){
                    to=this.pagination.last_page;
                }
                var pagesArray=[];
                while(from <= to){

                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            }
        },
        methods:{
           toUpper:function(){
                this.apellido=this.apellido.toUpperCase();
            },
            
               subirImagen(e){
                
                let me=this;

                let file = e.target.files[0];
             
              //  console.log(file);

                let reader = new FileReader();

                reader.onloadend = (file) => {
                    
                    // console.log('RESULT', reader.result)

                    me.auth.imagen = reader.result;
                }
                reader.readAsDataURL(file);
            },
            auth_user(){
                 let me= this;
                var url = '/user/user_auth';
                axios.get(url).then(function (response) {
                    var respuesta=response.data;
                    // // // handle success
                    // // console.log(response);
                    me.auth=respuesta.user_auth;
                        // me.pagination=respuesta.pagination;
                        
                    
                    console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            
          
            
          
            actualizarPersona(){
               if (this.validarPersona()){
                    return;
                }
                
                let me = this;

                axios.put('/user/actualizar',{
                    'id': this.auth.id,
                    'rol_id':this.auth.rol_id,
                    'nombre':this.auth.nombre,
                    'apellido':this.auth.apellido,
                    'direccion':this.auth.direccion,
                    'fech_nacimiento':this.auth.fech_nacimiento,
                    'dni':this.auth.dni,
                    'sexo':this.auth.sexo,
                    'num_celular':this.auth.num_celular,
                    'usuario':this.auth.usuario,
                    'password':this.auth.password,
                     'imagen':this.auth.imagen,
                    
                    
                    
                }).then(function (response) {
                    Swal.fire({
                      position: 'center',
                      type: 'success',
                      title: 'Actualizacion de Dato Exitoso ',
                      showConfirmButton: true,
                      timer: 3500
                    })
                    location.reload();
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
         
            
            validarPersona(){
                this.errorPersona=0;
                this.errorMostrarMsjPersona =[];

               if (this.auth.imagen=='') this.errorMostrarMsjPersona.push("Ingrese la imagen.");
               if (this.auth.nombre=='') this.errorMostrarMsjPersona.push("El campo nombre es Obligatorio.");
               if (this.auth.apellido=='') this.errorMostrarMsjPersona.push("El campo apellido es Obligatorio.");
               if (this.auth.fech_nacimiento==null) this.errorMostrarMsjPersona.push("El campo fecha es Obligatorio.");
               if (this.auth.num_celular==null) this.errorMostrarMsjPersona.push("El campo celular es Obligatorio.");
               if (this.auth.dni==null) this.errorMostrarMsjPersona.push("El campo dni es Obligatorio.");
               if (this.auth.password==null) this.errorMostrarMsjPersona.push("Cambie su Password");
            //     if (this.maestro_id=='1') this.errorMostrarMsjGrado.push("La sección no puede estar vacío.");

              if (this.errorMostrarMsjPersona.length) this.errorPersona = 1;

              return this.errorPersona;
            },
           
        },
        mounted() {
           
           this.auth_user();
        }
    }
</script>

<style >
    .modal-content{
        width: 100%;
        position: absolute !important;
        top: 5rem;
        border-radius: 10px!important;
      

    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
       
        background-color: #3c29297a !important;
        transition: all .5s ease-in-out !important;
    }
    .mostrar:hover{
        opacity: 2 !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
    .navbar-nav > .user-menu > .dropdown-menu {
   
    width: 400px!important;
}
.contenido{
    background-image:url(https://www.tuexpertoapps.com/wp-content/uploads/2017/04/fondos-de-pantalla-glitchart-05.png)!important; 
    height:100vh!important;
    background-size: cover!important;
    background-position: center center!important;
    background-repeat: no-repeat!important
}
</style>
