<template>
    
  <main class="content-wrapper">
       
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Notas</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Escritorio</a></li>
              <li class="breadcrumb-item active">Notas</li>
            </ol>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
                <div class="card-header ">
                  <i class="fa fa-align-justify"></i> Notas
                  
                    <button type="button" @click="abrirModal('selects')" class="btn btn-secondary bg-secondary ml-2 border-transparent " ><i class="fa fa-plus mr-1"></i>&nbsp;Seleccionar</button>
               
                  
                
                  <hr>
                  <!-- <input type="text" id="aula2"> -->
                  <div style="display:flex; justify-content:space-between">
                    <p v-show="maestroSelected!=''" >MAESTRO : <span v-text=" maestroSelected.apellido_maestro + ', '+maestroSelected.nombre_maestro" style="font-weight: 700; font-size:23px"></span> </p>
                    <p v-show="cursoSelected!=''" >CURSO : <span v-text=" cursoSelected.nombre" style="font-weight: 700; font-size:23px"></span> </p>
                    <p v-show="aulaSelected!=''" >AULA : <span v-text=" aulaSelected.grado" style="font-weight: 700; font-size:23px"></span> </p>
                    <p v-show="aulaSelected!=''" >SECCIÓN: <span v-text=" aulaSelected.seccion" style="font-weight: 700; font-size:23px"></span>  </p>
                    <p v-show="periodoSelected!=''" >PERIODO: <span v-text=" periodoSelected.nombre" style="font-weight: 700; font-size:23px"></span>  </p>
                    
                  </div>
                </div>
              <!-- /.card-header -->
         
            <template v-if="orden==0">
              <div class="card-body">
                <table class="table table-bordered  table-sm ">
                  <tr class="bg-info text-center " >
                    <th >N° Orden</th>
                    <th style="line-height:50px">Apellidos y Nombres</th>
                    <th style="line-height:50px" v-for="(competencia, index) in arrayCompetencias" :key="competencia.id" v-text="'C'+ (index+1)">
                    </th>    
                                                  
                  </tr>

                  <tr v-for="(estudiante, index) in arrayEstudiantes" :key="estudiante.id">
                    <td v-text="index+1"  style="width:20px; text-align:center; font-weight:900"></td>
                    <!-- <td v-text="index+1"  style="background-color:#E7CDB7"></td> -->
                    <td v-text="estudiante.apellido + ', ' + estudiante.nombre" ></td>
                    
                        <!-- <input type="number" v-model.number="estudiante.nota[index]"v-bind:class= "[estudiante.nota[index]<=10 ? 'text-danger' : 'text-primary']" style="width:50px; border-radius:5px; border:1px solid black; text-align:center"> -->
                        <!-- <span v-show="estudiante.nota[index] = ''"></span> -->
                        
                       <td v-for="(nota, index) in estudiante.nota" :key="nota.id" >
                              <!-- <input type="number" v-model.number="estudiante.nota[index]"v-bind:class= "[estudiante.nota[index]<=10 ? 'text-danger' : 'text-primary']" style="width:50px; border-radius:5px; border:1px solid black; text-align:center"> -->
                              <!-- <span v-show="estudiante.nota[index] = ''"></span> -->
                              <p v-text="estudiante.nota[index]" v-bind:class= "[estudiante.nota[index]=='C' ? 'text-danger' : 'text-primary']" class="form-control">
                                
                              </p>
                          </td>
                          
                        
                         
                  </tr>                                                   
                </table>
                
               
              </div>  
            </template>
            </div>
            <!-- /.card -->
          </div>
            <!-- /.col -->
          
        </div>
        <!-- /.row -->
        
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
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
         <template v-if="listado==0">
           <div class="modal-body">
           <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
            
            <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input">Aula</label>
                <div class="col-md-9">
                    <select v-model="aula_id" class="form-control" id="aula">
                        <option value="0" disabled>Selecciona el Aula</option>
                        <option v-for="aula in arrayAulas" :key="aula.id" :value="aula.id" v-text="aula.grado +' - '+ aula.seccion"></option>
                        
                        
                    </select>                                    
                </div>
            </div> 
            <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input">Curso</label>
                <div class="col-md-9">
                    <select v-model="curso_id" class="form-control">
                        <option value="1" disabled>Selecciona el curso</option>
                        <option v-for="curso in arrayCursos " :key="curso.id" :value="curso.id" v-text="curso.nombre"></option>       
                    </select>                                    
                </div>
            </div> 
            <div class="form-group row">
                <label class="col-md-3 form-control-label" for="text-input">Periodo</label>
                <div class="col-md-9">
                    <select v-model="periodo_id" class="form-control">
                        <option value="2" disabled>Selecciona el periodo</option>
                        <option v-for="periodo in arrayPeriodos" :key="periodo.id" :value="periodo.id" v-text="periodo.nombre"></option>
                    </select>                                    
                </div>
            </div>
           </form>
         </div>
         <div class="modal-footer">
           <button  @click="cerrarModal()" type="button" class="btn btn-danger" ><i class="fas fa-window-close mr-1"></i> Cerrar</button>
           <button v-if="tipoAccion==1" type="button" @click="selectNota(),abrirEstudiantes()" class="btn btn-primary"><i class="fas fa-sign-in-alt mr-1"></i> Ingresar</button>
           <button v-if="tipoAccion==2" type="button" class="btn btn-primary" @click="actualizarNota()"><i class="fas fa-pen-alt mr-1"></i> Actualizar</button>
         </div>
         </template>
         <template v-if="listado==1">
              <div class="row">
                <div class="col-md-12">
                  <div class="card">
                      <div class="card-header ">
                        <i class="fa fa-align-justify"></i> Notas
                        
                        
                      
                        <!-- <input type="text" id="aula2"> -->
                        <div style="display:flex; justify-content:space-between">
                          <p v-show="maestroSelected!=''" >MAESTRO : <span v-text=" maestroSelected.apellido_maestro + ', '+maestroSelected.nombre_maestro" style="font-weight: 700; font-size:23px"></span> </p>
                          <p v-show="cursoSelected!=''" >CURSO : <span v-text=" cursoSelected.nombre" style="font-weight: 700; font-size:23px"></span> </p>
                          <p v-show="aulaSelected!=''" >AULA : <span v-text=" aulaSelected.grado" style="font-weight: 700; font-size:23px"></span> </p>
                          <p v-show="aulaSelected!=''" >SECCIÓN: <span v-text=" aulaSelected.seccion" style="font-weight: 700; font-size:23px"></span>  </p>
                          <!-- <p v-show="periodoSelected!=''" >PERIODO: <span v-text=" periodoSelected.nombre" style="font-weight: 700; font-size:23px"></span>  </p> -->
                          
                        </div>
                      </div>
                    <!-- /.card-header -->
                  
                    <div class="card-body">
                      <table class="table table-bordered  table-sm ">
                        <tr class="bg-info text-center " >
                          <th >N° Orden</th>
                          <th style="line-height:50px">Apellidos y Nombres</th>
                          <th style="line-height:50px" v-for="(competencia, index) in arrayCompetencias" :key="competencia.id" v-text="'C'+ (index+1)">
                          </th>    
                                                       
                        </tr>

                        <tr v-for="(estudiante, index) in arrayEstudiantes" :key="estudiante.id">
                          <td v-text="index+1"  style="width:20px; text-align:center; font-weight:900"></td>
                          <!-- <td v-text="index+1"  style="background-color:#E7CDB7"></td> -->
                          <td v-text="estudiante.apellido + ', ' + estudiante.nombre" ></td>
                          <td v-for="(nota, index) in estudiante.nota" :key="nota.id" >
                              <!-- <input type="number" v-model.number="estudiante.nota[index]"v-bind:class= "[estudiante.nota[index]<=10 ? 'text-danger' : 'text-primary']" style="width:50px; border-radius:5px; border:1px solid black; text-align:center"> -->
                              <!-- <span v-show="estudiante.nota[index] = ''"></span> -->
                              <select v-model="estudiante.nota[index]" v-bind:class= "[estudiante.nota[index]=='C' ? 'text-danger' : 'text-primary']" class="form-control">
                                <!-- <option value="" disabled></option> -->
                                <option value="AD">AD</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                              </select>
                          </td>
                                    
                        </tr>                                                   
                      </table>
                      
                    </div>
                  
              
                  </div>
                  <!-- /.card -->
                </div>
            <!-- /.col -->
              </div>
         </template>
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
          return {
            orden: 0,
            periodo_id: 0,
            aula_id: 0,
            curso_id: 0,
            estudiante_id: 0,
            competencia_id: 0,
            arrayAulas: [],
            arrayEstudiantes: [],
           
            arrayCursos: [],
            arrayCompetencias: [],
          
            arrayPeriodos: [],
            arrayNotas: [],
            arrayPadre:[],
           
            modal: 0,
            tipoAccion: 0,
            tituloModal: '',
            errorNota: 0,
            errorMostrarMsjNota: "",
            cursoSelected: [],
            aulaSelected: [],
            maestroSelected: [],
            periodoSelected: [],
            list:0,
            listado:0
          }
        },
        methods:{
          ingresarNotas(){
            this.orden=1
          },
          volver(){
            let me = this;
            me.orden=0;
            
           
          },
          listarPadre(){
              let me =this;
              var url='/padre';
              axios.get(url).then((response)=>{
                  console.log(response);
                  var respuesta = response.data;
                  me.arrayPadre= respuesta.padres;
                  me.estudiante_id=me.arrayPadre[0]['estudiante_id'];
                  console.log(me.arrayPadre.length)
                  console.log(me.estudiante_id);
              }).catch((error)=>{
                  console.log(error)
              })
          },
          selectNota(aula_id=this.aula_id,periodo_id=this.periodo_id,curso_id=this.curso_id,estudiante_id=this.estudiante_id){
            let me= this;
            var url = '/nota/seleccionar?aula_id=' + aula_id + '&curso_id=' + curso_id+'&periodo_id='+periodo_id+'&estudiante_id='+estudiante_id;

            axios.get(url).then(function (response){
              var respuesta = response.data;

              me.arrayAulas = respuesta.aulas;
              me.arrayCursos = respuesta.cursos;
              me.arrayPeriodos = respuesta.periodos;
              me.arrayNotas = respuesta.notas;
              me.arrayEstudiantes = respuesta.estudiantes;
              me.arrayCompetencias = respuesta.competencias;
             
                  
               for(let i=0;i<me.arrayEstudiantes.length;i++){
                     me.arrayEstudiantes[i]['nota']={};
                    

                        for(let j=0;j<me.arrayCompetencias.length;j++){

                          me.arrayEstudiantes[i]['nota']['nota'+j]= me.arrayNotas[j+4*i]['calificacion'];

                          }
                            
                }
                    
              console.log(response);
           
              
              
            })
            .catch(function (error) {
                    console.log(error);
            });
          },
          abrirEstudiantes(aulaId = this.aula_id, cursoId = this.curso_id, periodoId = this.periodo_id){
                // aulaId = this.aula_id;
                // cursoId = this.curso_id;
            let me= this;

            var url = '/nota/estudiantes?aula_id=' + aulaId + '&curso_id=' + cursoId+'&periodo_id='+periodoId;

            axios.get(url).then(function (response){
              var respuesta = response.data;
              me.list=1;
              
             
              me.cursoSelected = respuesta.cursoSelected;
              me.aulaSelected = respuesta.aulaSelected;
              me.maestroSelected = respuesta.maestroSelected;
              me.periodoSelected = respuesta.periodoSelected;
              // console.log(response);
                   
                    me.cerrarModal();
                    me.volver();
                    
                    

            })
            .catch(function (error) {
           
              console.log(error);
            });
          },
       
      
          listarPdf(){
            window.open("http://localhost:8000/nota/listarPdf");
          },
          abrirModal(accion,data= []){

                    switch(accion){
                          case 'selects':
                          {
                              this.modal=1;
                              this.tipoAccion=1;
                              this.tituloModal='Ingresar Notas';
                              this.listado=0;
                              this.curso_id = '1';
                              this.aula_id = '0';
                              this.periodo_id = '2';

                              break;
                          }
                          case 'actualizar':
                          {
                              this.modal=1;
                              this.tituloModal='Actualizar Notas';
                              this.tipoAccion=2;

                              break;
                          }
                          case 'view':
                          {
                            this.modal=1;
                            this.tituloModal = 'Informacion Academica del estudiante';
                            this.listado=1;
                            break;
                          }
                      }
                                
              
            },
            cerrarModal(){
                this.modal=0;   
                // this.aula_id = '0';             
                // this.curso_id = '1';             
                // this.periodo_id = '2';
                            
            }
        },
          
        mounted(){
          this.selectNota(this.aula_id,this.curso_id,this.periodo_id);
          this.abrirEstudiantes(this.aula_id, this.curso_id, this.periodo_id);
          this.listarPadre();
        }
    }
// $( "#aula" )
//   .change(function () {
//     var str = "";
//     $( "#aula option:selected" ).each(function() {
//       str += $( this ).text() + " ";
//     });
//     $( "#aula2" ).value( str );
//   })
//   .change();
</script>

<style>
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
