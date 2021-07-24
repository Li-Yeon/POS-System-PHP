<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/php_posv3/PHP/addproduct.php';
if(isset($_SESSION['currentUser']))
    {

    }
    else
    {
        echo '<script>alert("You must login first!");</script>';
        echo '<script>location.href="index.php";</script>';
        exit();
    }  
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <title>POS System</title>
    <!-- Custom CSS -->
    <link href="assets/extra-libs/c3/c3.min.css" rel="stylesheet">
    <link href="assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
    <link href="assets/extra-libs/jvector/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
    <script src="Functions/inactivity.js"></script>
    <!-- Custom CSS -->
    <link href="dist/css/style.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar" data-navbarbg="skin6">
            <nav class="navbar top-navbar navbar-expand-md">
                <div class="navbar-header" data-logobg="skin6">
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                            class="ti-menu ti-close"></i></a>
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <div class="navbar-brand">
                        <!-- Logo icon -->
                        <a href="dashboard.php">
                            <b class="logo-icon">
                                <!-- Dark Logo icon -->
                                <img src="assets/images/logo-icon.png" alt="homepage" class="dark-logo" />
                                <!-- Light Logo icon -->
                                <img src="assets/images/logo-icon.png" alt="homepage" class="light-logo" />
                            </b>
                            <!--End Logo icon -->
                            <!-- Logo text -->
                            <span class="logo-text">
                                <!-- dark Logo text -->
                                <img src="assets/images/logo-text.png" alt="homepage" class="dark-logo" />
                                <!-- Light Logo text -->
                                <img src="assets/images/logo-light-text.png" class="light-logo" alt="homepage" />
                            </span>
                        </a>
                    </div>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Toggle which is visible on mobile only -->
                    <!-- ============================================================== -->
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                        data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i
                            class="ti-more"></i></a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-left mr-auto ml-3 pl-1">            
                        
                    </ul>
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-right">
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <img src="assets/images/users/profile-pic.jpg" alt="user" class="rounded-circle"
                                    width="40">
                                <span class="ml-2 d-none d-lg-inline-block"><span>Hello,</span> <span
                                        class="text-dark"><?php echo $getCurrentUser;?></span> <i data-feather="chevron-down"
                                        class="svg-icon"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                                <a class="dropdown-item" href="javascript:void(0)"><i data-feather="settings"
                                        class="svg-icon mr-2 ml-1"></i>
                                    Account Setting</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="javascript:void(0)" onclick = "confirmLogOut()" id="logOut"><i data-feather="power"
                                        class="svg-icon mr-2 ml-1"></i>
                                    Logout</a>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar" data-sidebarbg="skin6">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar" data-sidebarbg="skin6">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="dashboard.php"
                                aria-expanded="false"><i data-feather="home" class="feather-icon"></i><span
                                    class="hide-menu">Dashboard</span></a></li>
                        <li class="list-divider"></li>
                        <li class="nav-small-cap"><span class="hide-menu">Inventory</span></li>

                        <li class="sidebar-item"> <a class="sidebar-link" href="products.php"
                                aria-expanded="false"><i data-feather="tag" class="feather-icon"></i><span
                                    class="hide-menu">Products
                                </span></a>
                        </li>
                        <li class="sidebar-item"> <a class="sidebar-link" href="category.php"
                                aria-expanded="false"><i data-feather="box" class="feather-icon"></i><span
                                    class="hide-menu">Category
                                </span></a>
                        </li>
                        
                        <li class="list-divider"></li>

                        <li class="nav-small-cap"><span class="hide-menu">Stocks</span></li>

                        <li class="sidebar-item"> <a class="sidebar-link" href="addstocks.php"
                            aria-expanded="false"><i data-feather="plus" class="feather-icon"></i><span
                                class="hide-menu">Add Stocks
                            </span></a>
                        </li>

                        <li class="sidebar-item"> <a class="sidebar-link" href="dropstocks.php"
                            aria-expanded="false"><i data-feather="minus" class="feather-icon"></i><span
                                class="hide-menu">Drop Stocks
                            </span></a>
                        </li>

                        <li class="list-divider"></li>

                        <li class="nav-small-cap"><span class="hide-menu">Supplier</span></li>

                        <li class="sidebar-item"> <a class="sidebar-link" href="suppliers.php"
                            aria-expanded="false"><i data-feather="truck" class="feather-icon"></i><span
                                class="hide-menu">Suppliers
                            </span></a>
                        </li>

                        <li class="list-divider"></li>

                        <li class="nav-small-cap"><span class="hide-menu">Transactions</span></li>

                        <li class="sidebar-item"> <a class="sidebar-link" href="transaction.php"
                            aria-expanded="false"><span
                                class="hide-menu">Transactions
                            </span></a>
                        </li>

                        <li class="sidebar-item"> <a class="sidebar-link" href="checkout.php"
                            aria-expanded="false"><span
                                class="hide-menu">Checkout
                            </span></a>
                        </li>

                        <li class="list-divider"></li>

                        <li class="nav-small-cap"><span class="hide-menu">Users</span></li>

                        <li class="sidebar-item"> <a class="sidebar-link sidebar-link"
                            href="customers.php" aria-expanded="false"><i data-feather="users"
                                class="feather-icon"></i><span class="hide-menu">Customers
                            </span></a>
                    </li>

                        <li class="sidebar-item"> <a class="sidebar-link sidebar-link"
                                href="users.php" aria-expanded="false"><i data-feather="lock"
                                    class="feather-icon"></i><span class="hide-menu">Users
                                </span></a>
                        </li>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-7 align-self-center">
                        <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">POS SYSTEM</h3>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb m-0 p-0">
                                    <li class="breadcrumb-item">Add Product
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <?php
        if(isset($_SESSION['status']))
        {
        ?>
        <div class="alert alert-success" role="alert" style="margin-top:1%">
        <?php echo $_SESSION['status']; ?>
        </div>
        <?php
        unset($_SESSION['status']);
        }
            ?>
            </div>
            <div class="container-fluid">             
                <div class="card">
                    <div class="card-body">
                         <div class="text-input">
                         <form method="POST">
                                     <div class="form-group">
                                         <p>Product ID<p>
                                         <input type="text" class="form-control" style="border-radius: 10px;" name="product_ID" placeholder="Enter Product ID" required>
                                         <p>Product Name<p>
                                         <input type="text" class="form-control" style="border-radius: 10px;" name="product_Name" placeholder="Enter Product Name" required>
                                         <p>Category<p>
                                         <select class="form-control" name = "category" style="border-radius: 10px;" required>
                                         <?php while($row = mysqli_fetch_array($result)):;?>
                                         <option selected hidden value ="">Select Category</option>
                                         <option value="<?php echo $row[1];?>"><?php echo $row[1];?></option>
                                         <?php endwhile;?>
                                         </select>
                                         <p>Price<p>
                                         <div class="input-group mb-3">
                                             <div class="input-group-prepend">
                                                 <label class="input-group-text">RM</label>
                                             </div>
                                         <input type="number" class="form-control" name="price" placeholder="Enter Price" required>                        
                                         </div>
                                         <p>Barcode<p>
                                         <input type="text" class="form-control" style="border-radius: 10px;" name="barcode" placeholder = "Enter Barcode (Optional)">                        
                                     </div>
                                     <hr>
                                     <button type="submit" class="btn waves-effect waves-light btn-outline-success" name="addProduct">Add Product</button>
                                     <button type="reset" class="btn waves-effect waves-light btn-outline-danger">Reset</button>
 
                         </form>
                         </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center text-muted">
                All Rights Reserved by <a
                    href="https://adminmart.com/">Adminmart</a>. Designed and Developed by <a
                    href="https://wrappixel.com">WrapPixel</a>. System Made by <a
                    href="https://shopee.com.my/liyeontech">LiyeonTech</a>.
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- apps -->
    <!-- apps -->
    <script src="dist/js/app-style-switcher.js"></script>
    <script src="dist/js/feather.min.js"></script>
    <script src="assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="dist/js/custom.min.js"></script>
    <!--This page JavaScript -->
    <script src="assets/extra-libs/c3/d3.min.js"></script>
    <script src="assets/extra-libs/c3/c3.min.js"></script>
    <script src="assets/libs/chartist/dist/chartist.min.js"></script>
    <script src="assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
    <script src="assets/extra-libs/jvector/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="assets/extra-libs/jvector/jquery-jvectormap-world-mill-en.js"></script>
    <script src="dist/js/pages/dashboards/dashboard1.min.js"></script>
</body>

</html>

<script>
    function confirmLogOut() {
            var answer = window.confirm("Confirm log out?");
            if (answer) {
                window.location = "./PHP/logout.php";
            }
            else
            {

            }
        }
</script>
