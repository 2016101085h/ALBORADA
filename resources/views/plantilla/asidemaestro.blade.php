<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link" @click="menu=0">
      <img src="img/logo.jpeg"
           alt="AdminLTE Logo"
           class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">LA ALBORADA 30225</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="img/usuario/{{Auth::user()->imagen}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block text-uppercase">{{ Auth::user()->nombre.' '.Auth::user()->apellido}}</a>
          
        </div>
        
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-header">EXAMPLES</li>  
      
         
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Periodos
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li @click="menu=7" class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Periodos</p>
                </a>
              </li>
             
             
{{--              
              <li @click="menu=8" class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Collapsed Sidebar</p>
                </a>
              </li> --}}
            </ul>
          </li>
           
           <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
             <i class="fas fa-user-edit"></i>
              <p>
                Notas
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li @click="menu=11" class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Competencias</p>
                </a>
              </li>
              <li @click="menu=12" class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Alumnos</p>
                </a>
              </li>
              
              
             
            </ul>
          </li>
          
        
          <li class="nav-header">OTROS</li>
          <li @click="menu=14" class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-calendar-alt"></i>
              <p>
                Calendar
                <span class="badge badge-info right">2</span>
              </p>
            </a>
          </li>
        
        
           <li @click="menu=16" class="nav-item ">
             <a href="" class="nav-link">
               <i class="nav-icon fas fa-th"></i>
               <p>
                 Ayuda
                 <span class="right badge badge-danger">PDF</span>
               </p>
             </a>
           </li>
          
          <li @click="menu=17" class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-calendar-alt"></i>
              <p>
                Acerca de
                <span class="badge badge-info right">IT</span>
              </p>
            </a>
          </li>
        
        
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>