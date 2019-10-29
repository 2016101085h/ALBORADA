<template>
    
  <main class="content-wrapper">
       
       <template v-if="listado==0">
             <section class="content">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="d-inline mr-5">Competencias</h1>
            <button class="btn btn-lg btn-danger" type="button" @click="abrirModal('competencia','seleccionar')"><i class="fas fa-check-circle"></i> Seleccionar</button>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Escritorio</a></li>
              <li class="breadcrumb-item active">Competencias</li>
            </ol>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
                <div class="card-header ">
                  <i class="fa fa-align-justify"></i> Competencias
                    
                
                  
                 
                </div>
              <!-- /.card-header -->
              
            </div>
            <!-- /.card -->

          
          </div>
          <!-- /.col -->
          
        </div>
        <!-- /.row -->
        
      </div><!-- /.container-fluid -->
    </section>
       </template>
    <template v-if="listado==1">
            <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="d-inline mr-5">Competencias</h1>
            <button class="btn btn-lg btn-danger" type="button" @click="abrirModal('competencia','seleccionar')"><i class="fas fa-check-circle"></i> Seleccionar</button>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Escritorio</a></li>
              <li class="breadcrumb-item active">Competencias</li>
            </ol>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
                <div class="card-header ">
                  <i class="fa fa-align-justify"></i> Competencias
                  <button type="button" @click="abrirModal('competencia','registrar')" class="btn btn-secondary bg-secondary ml-2 border-transparent " >
                    <i class="fa fa-plus"></i>&nbsp;Nuevo
                  </button>
                   <div class="row mt-4  text-uppercase">
                  
                  <div class="col-md-3">
                     <span class="mt-2">Curso:   <b    v-for="cursos in arrayCurso1" :key="cursos.curso_id" v-text="cursos.nombre">  </b></span> 
                    </div> 
                 </div>
                 
                </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="form-group row">
                  <div class="col-md-6">
                    <div class="input-group">
                      <select class="form-control col-md-3" v-model="criterio">
                        <option value="grado">Grado</option>
                        <option value="nombre">Nombre</option>
                        
                        
                        
                      </select>
                      <input type="text" v-model="buscar" @keyup.enter="listarCompetencia(1,buscar,criterio,curso_id)" class="form-control" placeholder="Texto a buscar">
                      <button type="submit" @click="listarCompetencia(1,buscar,criterio,curso_id)" class="btn btn-warning text-white rounded-0"><i class="fa fa-search"></i> Buscar</button>
                    </div>
                  </div>
                </div>
                <table class="table table-bordered  table-sm  ">
                  <tr class="bg-info text-center ">
                    <th>Opciones</th>
                 
                    <th>Competencia</th>                                 
                    <th >Estado</th>

                  </tr>
                  <tr v-for="competencia in arrayCompetencia" :key="competencia.id">
                    <td >
                        <button type="button" @click="abrirModal('competencia','actualizar',competencia)" class="btn btn-warning btn-sm" 
                          >
                          <i class="fa fa-pen"></i>
                        </button> &nbsp;
                        <template v-if="competencia.condicion">
                         <button type="button" class="btn btn-danger btn-sm" @click="desactivarCompetencia(competencia.id)">
                          <i class="fa fa-trash"></i>
                        </button>
                        </template>
                        <template v-else>
                         <button type="button" class="btn btn-primary btn-sm" @click="activarCompetencia(competencia.id)">
                          <i class="fa fa-check"></i>
                        </button>
                        </template>
                    </td>
                    <!-- <td v-text="competencia.nombre_curso  "></td> -->
                    <td v-text="competencia.nombre_competencia "></td>
                   
                    <td>
                        <div v-if="competencia.condicion">
                            <span class="badge bg-success">Activo</span>
                        </div>
                        <div v-else>
                            <span class="badge bg-danger">Inactivo</span>
                        </div>
                    </td>
                  </tr>
                 
                  
                  
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                    <li class="page-item" v-if="pagination.current_page > 1">
                      <a class="page-link" href="#" @click.prevent="cambiarpagina(pagination.current_page - 1,buscar,criterio,curso_id)" >&laquo;</a>
                    </li>
                    <li class="page-item " v-for="page in pagesNumber" :key="page" :class = "[page == isActived ? 'active' :'' ]">
                        <a class="page-link" href="#" @click.prevent="cambiarpagina(page,buscar,criterio,curso_id)" v-text="page"></a>
                    </li>
                  
                     <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                         <a class="page-link" href="#" @click.prevent="cambiarpagina(pagination.current_page + 1,buscar,criterio,curso_id)">&raquo;</a>
                     </li>
                </ul>
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
    </template>
    <!--Inicio del modal agregar/actualizar-->
   <div class="modal fade" :class="{'mostrar': modal} " tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     style="display: none;" aria-hidden="true">
     <div class="modal-dialog modal-primary modal-lg" role="document">
       <div class="modal-content">
         <div class="modal-header bg-info">
           <h4 class="modal-title" v-text="tituloModal" ></h4>
           <button @click="cerrarModal()" type="button" class="close"  aria-label="Close">
             <span aria-hidden="true">×</span>
           </button>
         </div>
         <div class="modal-body">
           <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
            <template v-if="filtro==0">
              
            <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input">Curso</label>
                <div class="col-md-9">
                    <select v-model="curso_id" class="form-control" @click="buscarCurso(curso_id)" @change="listarCompetencia(1,'',criterio,curso_id)">
                        <option value="0" disabled>Selecciona el Curso</option>
                        <option v-for="curso in arrayCurso " :key="curso.id" :value="curso.id" v-text="curso.nombre"></option>
                        
                        
                    </select>                                    
                </div>
            </div> 
           
           
             
           
            </template>
             
        <template v-if="filtro==1">
          
              <div class="form-group row">
               <label class="col-md-3 form-control-label" for="email-input">Nombre de la competencia</label>
               <div class="col-md-9">
                 <input type="text" v-model="nombre_competencia" class="form-control" placeholder="Ingrese el Nombre de la Competencia">
               </div>
             </div> 

              <div v-show="errorCompetencia" class="form-group row div-error">
                <div class="text-center text-error">
                    <div v-for="error in errorMostrarMsjCompetencia" :key="error" v-text="error">
                        
                    </div>
                  
                </div>
            </div>
        </template>
           </form>
         </div>
         <div class="modal-footer">
           <button  @click="cerrarModal()" type="button" class="btn btn-danger" ><i class="fas fa-window-close mr-1"></i> Cerrar</button>
           <button v-if="tipoAccion==1" type="button" @click="registrarCompetencia()" class="btn btn-primary"><i class="fas fa-sign-in-alt mr-1"></i>  Guardar</button>
           <button v-if="tipoAccion==2" type="button" class="btn btn-primary" @click="actualizarCompetencia()"><i class="fas fa-pen-alt mr-1"></i> Actualizar</button>
           <button v-if="tipoAccion==3" type="button" class="btn btn-primary" @click="seleccionarCurso()"><i class="fas fa-hand-pointer mr-1"></i> Seleccionar</button>
         </div>
       </div>
       <!-- /.modal-content -->
     </div>
     <!-- /.modal-dialog -->
   </div>
   <!--Fin del modal-->
   
   <!-- Fin del modal Eliminar -->

  </main>
 
  
</template>

<script>
    export default {
        data(){
            return{
                competencia_id:'',
                curso_id:0,
                nombre_curso:'',
                nombre_competencia:'',                        
                listado:0,
                arrayCompetencia:[],
                modal:0,
                tituloModal:'',
                tipoAccion:0,
                errorCompetencia:0,
                errorMostrarMsjCompetencia:[],
                pagination:{
                    'total':0,
                    'current_page':0,
                    'per_page':0,
                    'last_page':0,
                    'from':0,
                    'to':0,
                },
                offset:3,
                criterio:'grado',
                buscar:'',
                arrayCurso:[],
                arrayCurso1:[],
                filtro:0,
              
               



            }
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
            listarCompetencia(page,buscar,criterio,curso_id){
                let me= this;
                
                var url = '/competencia?page='+page +'&buscar=' + buscar + '&criterio='+criterio+'&curso_id='+curso_id;
                axios.get(url).then(function (response) {
                    var respuesta=response.data;
                    // // // handle success
                    // // console.log(response);
                    me.arrayCompetencia=respuesta.competencias.data;
                        me.pagination=respuesta.pagination;
                    
                    console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            
            selectCurso(){
                 let me= this;
                var url = '/curso/selectcurso';
                axios.get(url).then(function (response) {
                    var respuesta=response.data;
                    // // // handle success
                    // // console.log(response);
                    me.arrayCurso=respuesta.cursos;
                        // me.pagination=respuesta.pagination;
                    
                    console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            buscarCurso(curso_id){
            let me= this;
            var url = '/curso/buscarcurso?curso_id='+curso_id;

            axios.get(url).then(function (response){
              var respuesta = response.data;

               me.arrayCurso1=respuesta.cursos;
              console.log(response);
            })
            .catch(function (error) {
                    console.log(error);
            });
          },
            
             cambiarpagina(page,buscar,criterio,curso_id){
                let me = this;
                //Actualiza la pagina actual
                me.pagination.current_page = page;

                //Envia la peticion para visualizar la data de esa pagina
                me.listarCompetencia(page,buscar,criterio,curso_id);
            },
            registrarCompetencia(){
                 if (this.validarCompetencia()){
                    return;
                }
                let me=this;
                axios.post('competencia/registrar',{
                    'curso_id':this.curso_id,
                    'nombre_curso':this.nombre_curso,
                    'nombre_competencia':this.nombre_competencia,
                   
                   
            
                }
                ).then(function (response){
                    me.cerrarModal();
                    me.listarCompetencia(1,'','nombre',1);
                     me.buscarCurso(1);
                }).catch(function(error){
                    console.log(error);
                });
            },
            seleccionarCurso(){
              let me = this;
              me.listado=1;
              me.modal=0;
            },
            actualizarCompetencia(){
               if (this.validarCompetencia()){
                    return;
                }
                
                let me = this;

                axios.put('/competencia/actualizar',{
                    'id': this.competencia_id,
                    'curso_id':this.curso_id,
                    'nombre_curso':this.nombre_curso,
                    'nombre_competencia':this.nombre_competencia,
                    
                    
                    
                    
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarCompetencia(1,'','nombre',1);
                     me.buscarCurso(1);
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            desactivarCompetencia(id){
               const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false,
                })

                swalWithBootstrapButtons.fire({
                title: 'Esta de seguro de eliminar esta Competencia?',
                
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me=this;
                    axios.put('competencia/desactivar',{
                       
                        'id':id
                    }
                    ).then(function (response){
                        
                        me.listarCompetencia(1,'','nombre',1);
                        me.buscarCurso(1);
                        
                          swalWithBootstrapButtons.fire(
                            'Eliminado!',
                            'El registro ha sido eliminado con exito.',
                            'success'
                            )
                    }).catch(function(error){
                        console.log(error);
                    });
                  
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Your imaginary file is safe :)',
                    'error'
                    )
                }
                }) 
            },
            activarCompetencia(id){
                
               const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false,
                })

                swalWithBootstrapButtons.fire({
                title: 'Esta de seguro de activar esta Competencia?',
                
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me=this;
                    axios.put('competencia/activar',{
                       
                        'id':id
                    }
                    ).then(function (response){
                        
                        me.listarCompetencia(1,'','nombre',curso_id);
                          swalWithBootstrapButtons.fire(
                            'Activado!',
                            'El registro ha sido activado con exito.',
                            'success'
                            )
                    }).catch(function(error){
                        console.log(error);
                    });
                  
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Your imaginary file is safe :)',
                    'error'
                    )
                }
                }) 
            },
            
            abrirModal(modelo,accion,data= []){

                switch(modelo){
                    case "competencia":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal=1;
                                this.tipoAccion=1;
                                this.filtro=1;
                                

                                this.tituloModal='Registrar Competencia';
                                // this.curso_id='0';
                                // this.nombre_curso='';
                                this.nombre_competencia='';
                                break;
                            }
                            case 'actualizar':
                            {
                                this.modal=1;
                                this.tituloModal='Actualizar Competencia';
                                this.filtro=1;
                                this.tipoAccion=2;
                                this.competencia_id=data['id'];
                                this.curso_id=data['curso_id'];
                                this.nombre_curso=data['nombre_curso'];
                                this.nombre_competencia=data['nombre_competencia'];
                                break;
                            }
                            case 'seleccionar':
                            {
                              this.modal=1;
                              this.tituloModal = 'Seleccionar Curso';
                              this.tipoAccion=3;
                              this.filtro=0;
                              this.curso_id='0';
                              this.nombre_curso='';
                              break;
                            }
                        }
                    }
                    
                    this.selectCurso();
                    this.buscarCurso(this.curso_id);
                    
                }
            },
            validarCompetencia(){
                this.errorCompetencia=0;
                this.errorMostrarMsjCompetencia =[];

               if (!this.nombre_competencia) this.errorMostrarMsjCompetencia.push("El nombre de la competencia estar vacío.");
            //     if (this.maestro_id=='1') this.errorMostrarMsjGrado.push("La sección no puede estar vacío.");

            if (this.errorMostrarMsjCompetencia.length) this.errorCompetencia = 1;

            return this.errorCompetencia;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.curso_id='';
                this.listado=1;
                this.nombre_curso='';
                this.nombre_competencia='';
                
               
            
                
               
                this.errorCompetencia=0;
                
            },
        },
        mounted() {
           this.listarCompetencia(1,this.buscar,this.criterio,this.curso_id);
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
</style>
