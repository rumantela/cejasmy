<?php

/** REST SERVICE for reset password */


include '../../../config/dbconfig.php';
require_once '../../../api/Login.php';

//phpinfo();

    if(isset($_POST['email'])){
        $params = [
            'user' => $_POST['email'],
            'password' => "",
            'connection' => $db_connection
        ];
        $login = new Login($params);
        $login->resetPassword($_POST['email']);
        
    }else{
    if(isset($_GET['email'])&&isset($_GET['reset_key'])){

    
    $params = [
        'user' => $_GET['email'],
        'password' => "",
        'connection' => $db_connection
    ];
    
    
    $login = new Login($params);
    
    // RESPONSE
    

    header("Content-Type: text/html");
    if($login->canResetPassword($_GET['email'],$_GET['key'])){
        if($login->resetPassword($_GET['email'],$_GET['key'])){
            
            ?>
            <!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Cejas My - Forgot password</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/styles.css" rel="stylesheet">

</head>

<body class="">
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container px-5">
            <a class="navbar-brand" href="index.html">
                <img class="logo" src="imgs/logo.jpg" alt="Cejas My" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto corporative-dark-green">
                    <li class="nav-item"><a class="nav-link" href="index.html#eyebrow">Cejas</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.html#lips">Labios</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.html#eyelash">Pestañas</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.html#tienda">Tienda</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.html">Log In</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="masthead margin-nav min-height">
        <div class="container">

            <!-- Outer Row -->
            <div class="row justify-content-center">

                <div class="col-xl-10 col-lg-12 col-md-9">

                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="row">
                                <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                                <div class="col-lg-6">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-2">¿Has olvidado la contraseña?</h1>
                                            <p class="mb-4">No te preocupes, a veces pasa. Simplemente introduce tu nueva contraseña a continuación!
                                            </p>
                                        </div>
                                        <form class="user">
                                            <div class="form-group">
                                                <input type="password" class="form-control form-control-user"
                                                    id="exampleInputEmail" aria-describedby="emailHelp"
                                                    placeholder="Introduce un email...">
                                                    <input type="password" class="form-control form-control-user"
                                                    id="exampleInputEmail" aria-describedby="emailHelp"
                                                    placeholder="Repita el email...">
                                            </div>
                                            <a href="./REST/password/update/" class="btn btn-primary btn-user btn-block">
                                                Reset Password
                                            </a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <footer class="py-5 bg-black">
        <div class="container px-5"><p class="m-0 text-center text-white small">Copyright &copy; Your Website 2023</p></div>
    </footer>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/scripts.js"></script>

</body>

</html>
            <?php
            $login->dbDestroy();                // Cerrar conexion con la DB
            exit();
        }

    }
    
    $login->dbDestroy();                // Cerrar conexion con la DB
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Cejas My - Forgot password</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/styles.css" rel="stylesheet">

</head>

<body class="">
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container px-5">
            <a class="navbar-brand" href="index.html">
                <img class="logo" src="imgs/logo.jpg" alt="Cejas My" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto corporative-dark-green">
                    <li class="nav-item"><a class="nav-link" href="index.html#eyebrow">Cejas</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.html#lips">Labios</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.html#eyelash">Pestañas</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.html#tienda">Tienda</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.html">Log In</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="masthead margin-nav min-height">
        <div class="container">

            <!-- Outer Row -->
            <div class="row justify-content-center">

                <div class="col-xl-10 col-lg-12 col-md-9">

                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="row">
                                <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                                <div class="col-lg-6">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-2">¿Has olvidado la contraseña?</h1>
                                            <p class="mb-4">¡No se ha podido realizar el reseteo de la contraseña!
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <footer class="py-5 bg-black">
        <div class="container px-5"><p class="m-0 text-center text-white small">Copyright &copy; Your Website 2023</p></div>
    </footer>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/scripts.js"></script>

</body>

</html>
<?php

exit();
    }
    header('Content-type: text/html');
    print "Se ha producido un error intentelo de nuevo o pongase en contacto con el administrador de la página";
    print "</br><a href='https://cejasmy.com'>Cejasmy.com</a>";
    die();
    }
    
    