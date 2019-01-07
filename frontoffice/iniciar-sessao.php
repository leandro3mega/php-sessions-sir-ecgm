<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Round About - Start Bootstrap Template</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/round-about.css" rel="stylesheet">

    <!-- My styles -->
    <link href="css/stylesheet.css" rel="stylesheet">

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">Tou Xim</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="btn btn-primary" href="registar-page.php">Criar Conta</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <div class="container" style="">

        <div class="card card-login mx-auto mt-5" style="margin-bottom:100px">
            <div class="card-header">Iniciar Sessão</div>
            <div class="card-body">
                <!-- Formulario -->
                <form id="formlogin" action="login.php" method="post">

                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="email" id="iemail" class="form-control" name="email" placeholder="Email"
                                required="required" autofocus="autofocus">

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-label-group">
                            <input type="password" id="ipassword" class="form-control" name="password" placeholder="Palavra Passe"
                                required="required">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="remember-me"> Lembrar Palavra Passe</label>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-lg btn-success btn-block" value="Iniciar Sessão">

                </form>
                <div class="text-center">
                    <a class="d-block small mt-3" href="registar-page.php">Registar</a>
                    <a class="d-block small" href="">Esqueceu-se da palavra passe?</a>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container -->

    <!-- Footer -->
    <?php
    include 'footer.html';
    ?>
    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>