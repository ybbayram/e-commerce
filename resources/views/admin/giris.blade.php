<!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Yönetim Paneli</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Yönetim paneli." name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="/adassets/assets/images/favicon.ico">

        <!-- Bootstrap Css -->
        <link href="/adassets/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="/adassets/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="/adassets/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

    </head>

    <body class="auth-body-bg">

        <div class="container-fluid">
            <!-- Log In page -->
            <div class="row">
                <div class="col-lg-3 pr-0">
                    <div class="card mb-0 shadow-none">
                        <div class="card-body">
                            
                            <h3 class="text-center m-0">
                                <a href="/"  style="margin-left:-190px;" class="logo logo-admin"><img src="assets/images/logo1.png" height="100" alt="pethepsi logo" class="my-3"></a>
                            </h3>
                            
                            <div class="px-2 mt-2">
                                <h4 class="text-muted font-size-18 mb-2 text-center">Pethepsi</h4>
                                <p class="text-muted text-center">Yönetim Paneli</p>
                                
                                <form class="form-horizontal my-4" action="{{ route('admin.oturumac') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label for="username">Email</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"><i class="far fa-user"></i></span>
                                            </div>
                                            <input type="email" name="email" class="form-control" id="username" placeholder="Email Giriniz">
                                        </div>                                    
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="userpassword">Şifre</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon2"><i class="fa fa-key"></i></span>
                                            </div>
                                            <input type="password" name="password" class="form-control" id="userpassword" placeholder="Şifre Giriniz">
                                        </div>                                
                                    </div>
                                    <div class="form-group mb-0 row">
                                        <div class="col-12 mt-2">
                                            <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Giriş <i class="fas fa-sign-in-alt ml-1"></i></button>
                                        </div>
                                    </div>                            
                                </form>
                     
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 p-0 vh-100  d-flex justify-content-center">
                <div class="accountbg d-flex align-items-center"> 
                    <div class="account-title text-center text-white">
                        <h1 class="text-white"><span class="text-warning">Pethepsi</span> Shop</h1>
                        <div class="border w-25 mx-auto border-warning"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Log In page -->
    </div>

    

    <!-- JAVASCRIPT -->
    <script src="/adassets/assets/libs/jquery/jquery.min.js"></script>
    <script src="/adassets/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/adassets/assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="/adassets/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="/adassets/assets/libs/node-waves/waves.min.js"></script>

    <script src="/adassets/assets/js/app.js"></script>

</body>
</html>
