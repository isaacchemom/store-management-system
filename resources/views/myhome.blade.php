


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CHS STORE|INVENTORY</title>
    <!-- CSS -->
   

    <!-- JavaScript -->

<style>

.sidebar {
    position: fixed;
    top:0;
 
    z-index: 1000; /* Adjust this value */
  
}

.main{
    top: 0;
    position: fixed;
 width: 100%;
    z-index: 1030; /* Adjust this value */
    z-index: 1; /* Adjust this value */
    
   
}
.main-footer{

    position: fixed;
    bottom:0;
    width: 100%;
    z-index: 1030;
}


</style>

    @vite(['resources/css/app.css', 'resources/js/app1.js'])
    

</head>

<body class="hold-transition sidebar-mini fixedx" style="background-color: rgb(8, 166, 93)">
 

  
    
    <div class="wrapper" id="app">

        <loader-component></loader-component>


        
        <nav class="main-header  navbar navbar-expand navbar-whitex navbar-light " style="height:55%">

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/" class="nav-link"></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-linkX tex-center text-success">
                        <b style="font-size: 170%; font-family: 'Courier New', monospace;">CHUKA BOYS CENTRAL STORE MANAGEMENT SYSTEM</b></a>
                </li>
            </ul>

              
            <ul class="navbar-nav ">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                <span style="margin-left:70px">
                    <li class="nav-item dropdown ">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                </span>
                @endguest
            </ul>
            <ul class="navbar-nav ml-auto">

                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
 

        </nav>


        <div class="sideBar bg-successx">
        <aside class="main-sidebar  sidebar-dark-primary elevation-4 bg-success layout-navbar-fixed ">

          

            <div class="sidebar " style="margin-top:">
               
                <a href="#" class="brand-linkx">
                    <img src="https://chukahighschool.sc.ke/wp-content/uploads/2021/07/cropped-cropped-cropped-cropped-logo-1-e1688070850624.png" height="40px" width="40px" alt=" Logo" class="brand-image img-circle elevation-3"
                        style="opacity: .8">
                    
                </a>
                <div class="user-panel mt-3 pb-3 mb-3 d-flex ">
                    
                    <div class="info">
                        <a href="#" class="d-block">Admin</a>
                    </div>
                   
                </div>

                <nav class="mt-0">

                    

                  
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">

                        <li class="nav-item">

                            <router-link to="/" class="nav-link" active-class="active">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    DASHBOARD

                                </p>
                            </router-link>

                        </li>
                    </ul>

                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">

                        <li class="nav-item">

                            <router-link to="/1/staff" class="nav-link" active-class="active">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    STAFF

                                </p>
                            </router-link>

                        </li>
                    </ul>

                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">

                    <li class="nav-item">

                        <router-link to="/1/suppliers" class="nav-link" active-class="active">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                SUPPLIERS

                            </p>
                        </router-link>

                    </li>
                </ul>
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">

                        <li class="nav-item">

                            <router-link to="/1/departments" class="nav-link" active-class="active">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    DEPARTMENTS

                                </p>
                            </router-link>

                        </li>
                    </ul>

                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">

                        <li class="nav-item">

                            <router-link to="/1/category" class="nav-link" active-class="active">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    CATEGORIES

                                </p>
                            </router-link>

                        </li>
                    </ul>
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">

                        <li class="nav-item">

                            <router-link to="/1/units" class="nav-link" active-class="active">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    MANAGE UNITS

                                </p>
                            </router-link>

                        </li>
                    </ul>

                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">

                        <li class="nav-item">

                            <router-link to="/1/items" class="nav-link" active-class="active">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    MANAGE ITEMS

                                </p>
                            </router-link>

                        </li>
                    </ul>

                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">

                        <li class="nav-item">

                            <router-link to="/1/issueItems" class="nav-link" active-class="active">
                                <i class="nav-icon fas fa-th"></i>
                                <p>

                                    ISSUE ITEMS
                                </p>
                            </router-link>

                        </li>
                    </ul>

                </nav>





            </div>

        </aside>
        

        <div class="content-wrapper"  style="background-color:white">
            <router-view></router-view>


            <myloader-component></myloader-component>
          
        </div>
     
{{-- 
        <aside class="control-sidebar control-sidebar-dark"> 
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside> --}}

       
     <footer class="main-footer" style="mar">


            <small>Copyright &copy; 2024 <a href="#">CHUKA BOYS</a> :</small> All rights
            reserved.
        </footer> 

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  
</body>

</html>
