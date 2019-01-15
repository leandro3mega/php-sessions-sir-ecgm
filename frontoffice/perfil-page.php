<?php

session_start();

require_once("connectdb.php");

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["logged"]) && $_SESSION["logged"] === true) {
} else {
    header("location: iniciar-sessao.php");
    exit;
}

$id = $nome = $email = $numero = $fotografia = "";
$id = $_SESSION['id'];

$result = mysqli_query($connectDB, "SELECT idutilizador, nome, email, numero, fotografia 
FROM utilizador 
WHERE idutilizador=$id");

if (mysqli_num_rows($result) == 1) {
    $row = $result->fetch_assoc();

    $nome = $row['nome'];
    $email = $row['email'];
    $numero = $row['numero'];
    $fotografia = $row['fotografia'];
} else {
    echo "</br> Não encontrou contacto";
}


?>

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
                        <a class="nav-link" href="contactos-page.php">Contactos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="grupos-page.php">Grupos</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="perfil-page.php">
                            <?php echo($nome); ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">(Sair)</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <div class="container fundo-container">

        <div class="row">
            <div class="col-lg-12" style="border-bottom: 2px solid #eee;">
                <h2 class="my-4">Dados Pessoais</h2>
            </div>
        </div>

        <div class="row" style="margin-top:1rem">
            <!-- 1ª Coluna -->
            <div class="col-lg-6" style="border-right: 2px solid #eee;">

                <!-- Label Nome -->
                <div class="form-group" id="iDivLabelNome" style="">
                    <label>Nome</label>
                    <p class="form-control-static">
                        <?php echo($nome); ?>
                    </p>

                    <button id="iBtnAlterarNome" onclick="showhideNome()" class="btn btn-outline-primary">Alterar</button>
                </div>
                <!-- Input Nome -->
                <div class="form-group" id="iDivInputNome" style="display:none">
                    <label>Nome</label>

                    <input type="text" id="iInputNome" class="form-control" style="margin-bottom:15px;" placeholder="Insira o seu nome"
                        value="<?php echo($nome); ?>">

                    <button id="iBtnSubmeterNome" class="btn btn-accept" onclick="changeNome()">Submeter</button>
                    <button id="iBtnCancelarNome" onclick="showhideNome()" class="btn btn-delete">Cancelar</button>

                </div>

                <!-- Email -->
                <div class="form-group" id="iDivLabelEmail" style="margin-top:2rem;">
                    <label>Email</label>
                    <p class="form-control-static">
                        <?php echo($email); ?>
                    </p>
                    <button id="iBtnAlterarEmail" onclick="showhideEmail()" class="btn btn-outline-primary">Alterar</button>
                </div>
                <!-- Input Email -->
                <div class="form-group" id="iDivInputEmail" style="display:none">
                    <label>Email</label>

                    <input type="text" id="iInputEmail" class="form-control" style="margin-bottom:15px;" placeholder="Insira o seu Email"
                        value="<?php echo($email); ?>">

                    <button id="iBtnSubmeterEmail" class="btn btn-accept" onclick="changeEmail()">Submeter</button>
                    <button id="iBtnCancelarEmail" onclick="showhideEmail()" class="btn btn-delete">Cancelar</button>

                </div>

                <!-- Numero -->
                <div class="form-group" id="iDivLabelNumero" style="margin-top:2rem;">
                    <label>Número de Contacto</label>
                    <p class="form-control-static">
                        <?php echo($numero); ?>
                    </p>

                    <button id="iBtnAlterarNumero" onclick="showhideNumero()" class="btn btn-outline-primary">Alterar</button>
                </div>
                <!-- Input Numero -->
                <div class="form-group" id="iDivInputNumero" style="display:none">
                    <label>Número de Contacto</label>

                    <input type="text" id="iInputNumero" class="form-control" style="margin-bottom:15px;" placeholder="Insira o seu Numero"
                        value="<?php echo($numero); ?>">

                    <button id="iBtnSubmeterNumero" class="btn btn-accept" onclick="changeNumero()">Submeter</button>
                    <button id="iBtnCancelarNumero" onclick="showhideNumero()" class="btn btn-delete">Cancelar</button>

                </div>


            </div>
            <!-- END: 1ª Coluna -->

            <!-- 2ª Coluna -->
            <div class="col-lg-6">

                <!-- Palavra Passe -->
                <div class="form-group" id="iDivLabelPassword" style="">
                    <label>Palavra Passe</label>
                    <div class="col-lg12">
                        <button id="iBtnAlterarPassword" onclick="showhidePassword()" class="btn btn-outline-primary">Alterar</button>
                    </div>
                </div>
                <!-- Input Password -->
                <div class="form-group" id="iDivInputPassword" style="display:none">
                    <label>Palavra Passe</label>

                    <input type="password" id="iInputPassword1" class="form-control" style="margin-bottom:15px; margin-bottom:30px"
                        placeholder="Insira a Palavra Passe Atual">
                    <input type="password" id="iInputPassword2" class="form-control" style="margin-bottom:15px;"
                        placeholder="Insira a Nova Palavra Passe">
                    <input type="password" id="iInputPassword3" class="form-control" style="margin-bottom:15px;"
                        placeholder="Repita a Nova Palavra Passe">

                    <button id="iBtnSubmeterPassword" class="btn btn-accept" onclick="changePassword()">Submeter</button>
                    <button id="iBtnCancelarPassword" onclick="showhidePassword()" class="btn btn-delete">Cancelar</button>

                </div>

                <!-- Fotografia -->
                <div class="form-group" id="iDivLabelFotografia" style="margin-top:2rem;">
                    <label>Fotografia</label>
                    <div class="col-lg-6 col-sm-4 text-center mb-4" style="padding-left:0px;">

                        <?php
                        $diretorio = "images/contactos/";
                        $imagem = $fotografia;
                        echo("
                        <img class='img-fluid mx-auto' src='". $diretorio . $imagem ."' alt=''>
                        ");
                        ?>

                    </div>
                    <div class="col-lg12">
                        <button id="iBtnAlterarFotografia" onclick="showhideFotografia()" class="btn btn-outline-primary">Alterar</button>
                    </div>
                </div>
                <!-- Input Fotografia -->
                <div class="form-group" id="iDivInputFotografia" style="display:none">
                    <label>Fotografia</label>

                    <form action="changeuserinfo.php" method="post" enctype='multipart/form-data'>
                        <div class="form-group">
                            <input type="file" name="fotografia" id="fotografia_file_upload_field" accept="image/jpeg,image/png" />
                            <input type="hidden" name="action" value="change_fotografia">
                        </div>

                        <input type="submit" id="iBtnSubmeterFotografia" class="btn btn-accept" value="Submeter">
                        <!-- <button id="iBtnSubmeterFotografia" class="btn btn-accept" onclick="changeFotografia()">Submeter</button> -->
                        <button id="iBtnCancelarFotografia" onclick="showhideFotografia()" class="btn btn-delete">Cancelar</button>
                    </form>

                </div>

                <!-- Link do user -->
                <div class="form-group" style="margin-top:2rem;">
                    <label>Partilhe o seu perfil</label>
                    <input type="url" class="form-control flex-fill mr-0 mr-sm-2 mb-3 mb-sm-0" disabled name="grupourl"
                        id="igrupourl" value="<?php echo $url = " http" . (($_SERVER['SERVER_PORT']==443) ? "s" : "" )
                        . "://" . $_SERVER['HTTP_HOST'] .
                        "/php-sessions-sir-ecgm/frontoffice/contacto-page.php?contacto_id=" . $id; ?>">

                </div>
            </div>
            <!-- END: 2ª Coluna -->
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

<script>
var nomeInputHidden = true;
var emailInputHidden = true;
var numeroInputHidden = true;
var passwordInputHidden = true;
var fotografiaInputHidden = true;

//-- Mostra ou esconde os inputs para mudar o nome
function showhideNome() {
    var divLabelNome = document.getElementById("iDivLabelNome");
    var divInputNome = document.getElementById("iDivInputNome");
    var btnAlterarNome = document.getElementById("iBtnAlterarNome");
    var btnSubmeterNome = document.getElementById("iBtnSubmeterNome");
    var btnCancelarNome = document.getElementById("iBtnCancelarNome");

    if (nomeInputHidden) nomeInputHidden = false;
    else nomeInputHidden = true;

    if (nomeInputHidden) {
        divLabelNome.style = "display: block";
        divInputNome.style = "display: none";
        btnAlterarNome.style = "display: block";
        btnSubmeterNome.style = "display: none;";
        btnCancelarNome.style = "display: none;";
    } else {
        divLabelNome.style = "display: none";
        divInputNome.style = "display: block";
        btnAlterarNome.style = "display: none;";
        btnSubmeterNome.style = "display: inline-block;";
        btnCancelarNome.style = "display: inline-block;";
    }

}

function changeNome() {
    novoNome = $('#iInputNome').val();
    // console.log("Novo nome: " + novoNome);

    $.ajax({
        type: "POST",
        url: 'changeuserinfo.php',
        data: {
            'action': 'change_name',
            'name': novoNome
        },
        success: function(html) {
            alert(html);
            location.reload();
        }

    });
}

//-- Mostra ou esconde os inputs para mudar o email
function showhideEmail() {
    var divLabelEmail = document.getElementById("iDivLabelEmail");
    var divInputEmail = document.getElementById("iDivInputEmail");
    var btnAlterarEmail = document.getElementById("iBtnAlterarEmail");
    var btnSubmeterEmail = document.getElementById("iBtnSubmeterEmail");
    var btnCancelarEmail = document.getElementById("iBtnCancelarEmail");

    if (emailInputHidden) emailInputHidden = false;
    else emailInputHidden = true;

    if (emailInputHidden) {
        divLabelEmail.style = "display: block; margin-top:2rem;";
        divInputEmail.style = "display: none";
        btnAlterarEmail.style = "display: block";
        btnSubmeterEmail.style = "display: none;";
        btnCancelarEmail.style = "display: none;";
    } else {
        divLabelEmail.style = "display: none";
        divInputEmail.style = "display: block; margin-top:2rem;";
        btnAlterarEmail.style = "display: none;";
        btnSubmeterEmail.style = "display: inline-block;";
        btnCancelarEmail.style = "display: inline-block;";
    }

}

function changeEmail() {
    novoEmail = $('#iInputEmail').val();
    console.log("Novo Email: " + novoEmail);

    $.ajax({
        type: "POST",
        url: 'changeuserinfo.php',
        data: {
            'action': 'change_email',
            'email': novoEmail
        },
        success: function(html) {
            alert(html);
            location.reload();
        }

    });
}

//-- Mostra ou esconde os inputs para mudar o número
function showhideNumero() {
    var divLabelNumero = document.getElementById("iDivLabelNumero");
    var divInputNumero = document.getElementById("iDivInputNumero");
    var btnAlterarNumero = document.getElementById("iBtnAlterarNumero");
    var btnSubmeterNumero = document.getElementById("iBtnSubmeterNumero");
    var btnCancelarNumero = document.getElementById("iBtnCancelarNumero");

    if (numeroInputHidden) numeroInputHidden = false;
    else numeroInputHidden = true;

    if (numeroInputHidden) {
        divLabelNumero.style = "display: block; margin-top:2rem;";
        divInputNumero.style = "display: none";
        btnAlterarNumero.style = "display: block";
        btnSubmeterNumero.style = "display: none;";
        btnCancelarNumero.style = "display: none;";
    } else {
        divLabelNumero.style = "display: none";
        divInputNumero.style = "display: block; margin-top:2rem;";
        btnAlterarNumero.style = "display: none;";
        btnSubmeterNumero.style = "display: inline-block;";
        btnCancelarNumero.style = "display: inline-block;";
    }

}

function changeNumero() {
    novoNumero = $('#iInputNumero').val();
    console.log("Novo Numero: " + novoNumero);

    $.ajax({
        type: "POST",
        url: 'changeuserinfo.php',
        data: {
            'action': 'change_numero',
            'numero': novoNumero
        },
        success: function(html) {
            alert(html);
            location.reload();
        }

    });
}

//-- Mostra ou esconde os inputs para mudar a password
function showhidePassword() {
    var divLabelPassword = document.getElementById("iDivLabelPassword");
    var divInputPassword = document.getElementById("iDivInputPassword");
    var btnAlterarPassword = document.getElementById("iBtnAlterarPassword");
    var btnSubmeterPassword = document.getElementById("iBtnSubmeterPassword");
    var btnCancelarPassword = document.getElementById("iBtnCancelarPassword");

    if (passwordInputHidden) passwordInputHidden = false;
    else passwordInputHidden = true;

    if (passwordInputHidden) {
        divLabelPassword.style = "display: block; margin-top:2rem;";
        divInputPassword.style = "display: none";
        btnAlterarPassword.style = "display: block";
        btnSubmeterPassword.style = "display: none;";
        btnCancelarPassword.style = "display: none;";
    } else {
        divLabelPassword.style = "display: none";
        divInputPassword.style = "display: block; margin-top:2rem;";
        btnAlterarPassword.style = "display: none;";
        btnSubmeterPassword.style = "display: inline-block;";
        btnCancelarPassword.style = "display: inline-block;";
    }

}

function changePassword() {
    //-- Compara se a nova pass é igual nos 2 campos
    if ($('#iInputPassword2').val() === $('#iInputPassword3').val()) {
        passAntiga = $('#iInputPassword1').val();
        passNova = $('#iInputPassword2').val();
        //alert("Pass 2 e 3 são iguais");

        $.ajax({
            type: "POST",
            url: 'changeuserinfo.php',
            data: {
                'action': 'change_password',
                'password_old': passAntiga,
                'password_new': passNova
            },
            success: function(html) {
                alert(html);
                location.reload();
            }

        });
    } else {
        alert("Confirme que a nova password que pretende inserir é igual à que está a confirmar.");
    }
}

//-- Mostra ou esconde os inputs para mudar a fotografia
function showhideFotografia() {
    var divLabelFotografia = document.getElementById("iDivLabelFotografia");
    var divInputFotografia = document.getElementById("iDivInputFotografia");
    var btnAlterarFotografia = document.getElementById("iBtnAlterarFotografia");
    var btnSubmeterFotografia = document.getElementById("iBtnSubmeterFotografia");
    var btnCancelarFotografia = document.getElementById("iBtnCancelarFotografia");

    if (fotografiaInputHidden) fotografiaInputHidden = false;
    else fotografiaInputHidden = true;

    if (fotografiaInputHidden) {
        divLabelFotografia.style = "display: block; margin-top:2rem;";
        divInputFotografia.style = "display: none";
        btnAlterarFotografia.style = "display: block";
        btnSubmeterFotografia.style = "display: none;";
        btnCancelarFotografia.style = "display: none;";
    } else {
        divLabelFotografia.style = "display: none";
        divInputFotografia.style = "display: block; margin-top:2rem;";
        btnAlterarFotografia.style = "display: none;";
        btnSubmeterFotografia.style = "display: inline-block;";
        btnCancelarFotografia.style = "display: inline-block;";
    }

}


//-- Adiciona ou remove imagens dependendo do numero selecionado
var inputImage = document.getElementById("fotografia_file_upload_field");
inputImage.onchange = function() {

    var limiteSize = 1020; // 1 Megabyte
    var file = this.files[0];
    var input = this;
    console.log(file);

    //##### Start of reader
    var reader = new FileReader(); // CREATE AN NEW INSTANCE.

    reader.onload = function(e) {
        var img = new Image();
        img.src = e.target.result;

        img.onload = function() {
            var valido = true;
            var w = this.width;
            var h = this.height;
            var size = Math.round((file.size / 1024));

            console.log("File Name: " + file.name);
            console.log("Width: " + w);
            console.log("Height: " + h);
            console.log("Size: " + Math.round((file.size / 1024)));
            console.log("File Type: " + file.type);
            console.log("Limite: " + limiteSize);

            if (file.type == "image/png" || file.type == "image/jpeg") {
                console.log("A imagem é png ou jpeg");

                //-- Check size and dimensions of image
                if (w > 1980 || h > 1080 || size > limiteSize) {
                    alert(
                        "A imagem tem tamanho superior a 1MB ou dimensões superiores a 1960x1080."
                    );
                    input.value = "";

                } else {
                    console.log("A imagem não tem tamanho superior a 1mb");
                    valido = true;
                }
            } else {
                console.log("A imagem não é png ou jpeg");
                alert("Imagens não é de tipo suportado! Insira uma imagem PNG ou JPEG");

                input.value = "";
            }
        }
    };
    reader.readAsDataURL(file, input);
    //##### End of reader
}
</script>

</html>