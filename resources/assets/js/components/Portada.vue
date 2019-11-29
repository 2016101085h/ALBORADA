<template>
    
  <main class="content-wrapper bg-light">
  <div class="container">
    <div class="row">
      <div class="col-md-12 mt-5 text-center">
        <h1 class="text-center mb-3 text-info text-uppercase text-bold">Administración Institucion Educativa 'LA ALBORADA 30225'</h1>
        <!-- <img class="img-fluid " src="https://cdne.diariocorreo.pe/redactor/uploads/2018/10/24/Collage%20sin%20t%C3%ADtulo%20(1).jpg" alt=""> -->
        <video src="video/portada1.mp4" autoplay  loop muted class="ml-auto mt-5 mb-5" style="width:1300px;max-width:100%;box-shadow:5px 5px 25px black" ></video>
      </div>
    </div>
  </div>
  
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
            listarPersona(page,buscar,criterio){
                let me= this;
                var url = '/user?page='+page +'&buscar=' + buscar + '&criterio='+criterio;
                axios.get(url).then(function (response) {
                    var respuesta=response.data;
                    // // // handle success
                    // // console.log(response);
                    me.arrayPersona=respuesta.personas.data;
                        me.pagination=respuesta.pagination;
                    
                    console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
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
                 
                let me =this;
                           
                var url = '/user/user_auth';
                axios.get(url).then(function (response) {
                    var respuesta=response.data;
                    // // // handle success
                    // // console.log(response);
                    me.auth=respuesta.user_auth;
                        // me.pagination=respuesta.pagination;
                if(me.auth.nombre =='' && me.auth.apellido=='' && me.auth.dni==null && me.auth.fech_nacimiento==null && me.auth.num_celular==null && me.auth.sexo==null && me.auth.direccion==null){
                  Swal.fire({
                      position: 'center',
                      type: 'info',
                      title: 'Dirigase al perfil para actualizar sus datos ',
                      showConfirmButton: true,
                      timer: 4500
                    })
                }  
                        
                    console.log(me.auth.nombre)
                    ;
                    console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            
            selectRol(){
                 let me= this;
                var url = '/rol/selectrol';
                axios.get(url).then(function (response) {
                    var respuesta=response.data;
                    // // // handle success
                    // // console.log(response);
                    me.arrayRol=respuesta.rols;
                        // me.pagination=respuesta.pagination;
                    
                    console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            
             cambiarpagina(page,buscar,criterio){
                let me = this;
                //Actualiza la pagina actual
                me.pagination.current_page = page;

                //Envia la peticion para visualizar la data de esa pagina
                me.listarPersona(page,buscar,criterio);
            },
           
            actualizarPersona(){
               if (this.validarPersona()){
                    return;
                }
                
                let me = this;

                axios.put('/user/actualizar',{
                    'id': this.auth.id,
                    'rol_id':this.rol_id,
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
                    me.cerrarModal();
                    me.listarPersona(1,'','nombre');
                    location.reload();
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
         
            abrirModal(modelo,accion,data= []){

                switch(modelo){
                    case "persona":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal=1;
                                this.tipoAccion=1;
                                this.tituloModal='Registrar persona';
                                this.rol_id='0';
                                this.nombre='';
                                this.apellido='';
                                this.sexo='sexo';
                                this.dni='';
                                this.direccion='';
                                this.fech_nacimiento='';
                                this.num_celular='';
                                this.usuario='';
                                this.password='';
                                this.imagen='';
                            
                                break;
                            }
                            case 'actualizar':
                            {
                                this.modal=1;
                                this.tituloModal='Actualstrar persona';
                                this.tipoAccion=2;
                                this.persona_id=data['id'];
                                
                                this.nombre=data['nombre'];
                                this.apellido=data['apellido'];
                                this.sexo=data['sexo'];
                                this.direccion=data['direccion'];
                                this.dni=data['dni'];
                                this.fech_nacimiento=data['fech_nacimiento'];
                                this.num_celular=data['num_celular'];
                                this.usuario=data['usuario'];
                                this.password=data['password'];
                                this.rol_id=data['rol_id'];
                                this.imagen=data['imagen'];
                               
                                
                               
                                // this.grado=data['grado'];
                                // this.seccion_grado=data['seccion_grado'];
                                // this.turno_grado=data['turno_grado'];
                               
                                
                               
                                break;
                            }
                        }
                    }
                    
                    this.selectRol();
                    
                }
            },
            validarPersona(){
                this.errorPersona=0;
                this.errorMostrarMsjPersona =[];

            //    if (this.grado=='0') this.errorMostrarMsjGrado.push("El grado no puede estar vacío.");
            //     if (this.maestro_id=='1') this.errorMostrarMsjGrado.push("La sección no puede estar vacío.");

            //     if (this.errorMostrarMsjGradoMaestro.length) this.errorGradoMaestro = 1;

            //     return this.errorGradoMaestro;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.rol_id=0;
                this.nombre='';
                this.apellido='';
                this.fech_nacimiento='';
                this.dni='';
                this.sexo='';
                this.direccion='';
                this.num_celular='';
                this.usuario='';
                
                this.password='';
            
                
               
                this.errorPersona=0;
                
            },
        },
        mounted() {
           this.listarPersona(1,this.buscar,this.criterio);
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
</style>
