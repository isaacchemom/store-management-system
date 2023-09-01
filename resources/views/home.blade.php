<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CHS STORE|INVENTORY</title>
    <!-- CSS -->


<!-- JavaScript -->



    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper" id="app">

<loader-component></loader-component>

    

        <nav class="main-header navbar navbar-expand navbar-white navbar-light">

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="index3.html" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li>
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

        <aside class="main-sidebar sidebar-dark-primary elevation-4">

            <a href="index3.html" class="brand-link">
                <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">AdminLTE 3</span>
            </a>

            <div class="sidebar">

                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">Alexander Pierce</a>
                    </div>
                </div>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">

                        <li class="nav-item">

                            <router-link to="/dashboard" class="nav-link" active-class="active">
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

                            <router-link to="/suppliers" class="nav-link" active-class="active">
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

                        <router-link to="/departments" class="nav-link" active-class="active">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                DEPARTMENTS|OFFICES

                            </p>
                        </router-link>

                    </li>
                </ul>

                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">

                    <li class="nav-item">

                        <router-link to="/category" class="nav-link" active-class="active">
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

                        <router-link to="/items" class="nav-link" active-class="active">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                ITEMS MANAGEMENT

                            </p>
                        </router-link>

                    </li>
                </ul>
                   
                    
                </nav>
                

            </div>

        </aside>

        <div class="content-wrapper">
            <router-view></router-view>

        </div>

        <aside class="control-sidebar control-sidebar-dark">

            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>

        <footer class="main-footer">

            <div class="float-right d-none d-sm-inline">
                Anything you want
            </div>

            <strong>Copyright &copy; 2023 <a href="#">AdminLTE.io</a>.</strong> All rights
            reserved.
        </footer>
    </div>

   

 
</body>

</html>
