<?php

session_start();

require_once("connectdb.php");

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["logged"]) && $_SESSION["logged"] === true) {
} else {
    header("location: iniciar-sessao.php");
    exit;
}

$id = $nome = $descricao = $fotografia = "";
$diretorio = "images/grupos/";
$id = (int)$_GET['grupo_id'];
$id_user = $_SESSION['id'];


//-- Seleciona a info para o grupo
if ($stmt = $connectDB->prepare("SELECT nome, descricao, fotografia FROM grupo WHERE idgrupo=?")) {
    // Bind variables to the prepared statement as parameters
    $stmt->bind_param("s", $param_id);

    // Set parameters
    $param_id = $id;

    // Attempt to execute the prepared statement
    if ($stmt->execute()) {
        // associar os parametros de output
        $stmt->bind_result($r_nome, $r_descricao, $r_fotografia);

        // store result
        $stmt->store_result();

        // iterar / obter resultados
        $stmt->fetch();

        if ($stmt->num_rows == 1) {
            $nome = $r_nome;
            $descricao = $r_descricao;
            $fotografia = $r_fotografia;
        } else {
            echo "</br>Não existe utilizador com o id";
        }
    } else {
        echo "</br>Oops! Something went wrong. Please try again later.";
    }
}

$isMember = false;
$cargoNoGrupo = 0;

//-- Verificar se o user que visita o grupo é membro, se for qual o cargo
if ($stmt = $connectDB->prepare("SELECT cargo FROM utilizador_grupo WHERE fk_idutilizador=? AND fk_idgrupo=?")) {
    // Bind variables to the prepared statement as parameters
    $stmt->bind_param("ss", $param_user, $param_grupo);

    // Set parameters
    $param_user = $id_user;
    $param_grupo = $id;

    // Attempt to execute the prepared statement
    if ($stmt->execute()) {
        // associar os parametros de output
        $stmt->bind_result($r_cargo);

        // store result
        $stmt->store_result();

        // iterar / obter resultados
        $stmt->fetch();

        if ($stmt->num_rows == 1) {
            $isMember = true;   // pertence ao grupo
            // então vamos obter o cargo deste user no grupo
            $cargoNoGrupo = $r_cargo;
        } else {
            echo "</br>Este user nao pertence ao grupo";
        }
    } else {
        echo "</br>Oops! Something went wrong. Please try again later.";
    }
}



?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/round-about.css" rel="stylesheet">

    <!-- My styles -->
    <link href="css/stylesheet.css" rel="stylesheet">
</head>

<body class="body-site">

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
                    <li class="nav-item">
                        <a class="nav-link" href="perfil-page.php">
                            <?php echo($_SESSION['nome']); ?>
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

        <!-- Nome do contacto -->
        <div class="row" style="padding:0rem; ">
            <div class="col-lg-12" style="padding:1rem; border-bottom: 3px solid #eee; background-color:rgb(19, 185, 157);">
                <h2 class="my-4">
                    <?php echo($nome); ?>
                </h2>
                <!-- Holder do ID do grupo em visualização -->
                <?php echo "<input id='hiddenIdGrupo' type = 'hidden' value = '" . $id . "'name = 'grupo_id' >"; ?>
            </div>
        </div>

        <!-- Menu de grupo-->
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group form-inline">
                    <div style="margin-left:auto; margin-right:auto; border-bottom: 2px solid #eee;">
                        <button id="btnInicio" class='btn btn-grupo-menu' style="min-width:150px">Página Inicial</button>
                        <button id="btnMembros" class='btn btn-grupo-menu' style="min-width:150px;">Membros</button>
                        <button id="btnAdicionar" class='btn btn-grupo-menu' style="min-width:150px">Adicionar Pessoa</button>
                        <button id="btnSobre" class='btn btn-grupo-menu' style="min-width:150px">Sobre</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Página inicial -->
        <div id="iInicioGrupo" class="row" style="min-height: 400px; padding:1rem !important; padding-top:2rem !important;">
        </div>

        <!-- Membros -->
        <div id="iMembrosGrupo" class="row" style="min-height: 400px; padding:1rem !important; padding-top:2rem !important;">

            <?php
            $lista_membros = array();
            
            //-- Select das ligações entre users e grupos para ver quais os membros deste grupo
            if ($stmt = $connectDB->prepare("SELECT fk_idutilizador, fk_idgrupo, cargo FROM utilizador_grupo WHERE fk_idgrupo = ?")) {
                // Bind variables to the prepared statement as parameters
                $stmt->bind_param("s", $param_id);

                // Set parameters
                $param_id = $id;

                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    $result = $stmt->get_result();

                    while ($row = $result->fetch_assoc()) {
                        $lista_membros[] = $row['fk_idutilizador'];
                    }
                } else {
                    echo "</br>Oops! Something went wrong. Please try again later.";
                }
            }

            // Close statement
            $stmt->close();

            //-- Se o user for criador do grupo, pode eliminar contactos

            $buttonElimina;


            //-- Select dos utilizadores que pertencem ao grupo
            if ($stmt = $connectDB->prepare("SELECT idutilizador, nome, fotografia FROM utilizador WHERE idutilizador=?")) {
                // Bind variables to the prepared statement as parameters
                $stmt->bind_param("s", $param_id);

                for ($i=0; $i < count($lista_membros); $i++) {

                    // Set parameters
                    $param_id = $lista_membros[$i];

                    // Attempt to execute the prepared statement
                    if ($stmt->execute()) {
                        // associar os parametros de output
                        $stmt->bind_result($r_iduser, $r_nome, $r_fotografia);

                        // store result
                        $stmt->store_result();

                        // iterar / obter resultados
                        $stmt->fetch();

                        if ($stmt->num_rows == 1) {
                            if ($r_iduser != $id_user) {
                                $buttonElimina = "<button id='". $r_iduser ."' class='btn btn-delete' onclick='deleteUserFromGroup(this.id)' style='margin-left:5px'>Eliminar</button>";
                            } else {
                                $buttonElimina = "";
                            }

                            echo "
                            <div class = 'col-lg-3 col-sm-3 text-center mb-4' name ='contacto[]' style=''>" .
                                //-- info em display
                                "<div class='form-group'>" .
                                    "<img class='rounded-circle img-fluid d-block mx-auto'style='height:150px' src ='images/contactos/" .
                                    $r_fotografia . "' alt = ''>" .
                                    "<h4 class='h4-overflow-limit'> " . $r_nome . "</h4>" .
                                    //"<p>" . element.numero . "</p>" .
                                "</div>" .

                                "<div class='form-group form-inline'>" .
                                    "<div style ='display:flex;margin-left:auto; margin-right:auto;'>" .
                                
                                        //-- form para ver perfil de contacto
                                        "<form id='formPesquisaContacto[]' action='contacto-page.php' enctype='multipart/form-data' method='GET'>" .
                                            "<input id='hiddenIdUser' type = 'hidden' value = '" . $r_iduser .
                                            "'name = 'contacto_id' >" .
                                            "<input type = 'hidden' value = '" . $r_nome .
                                            "'name = 'contacto_nome' >" .
                                            "<input type='submit' class='btn btn-outline-primary' value='Ver Perfil'>" .
                                            //-- botão para eliminar contacto do grupo
                                        "</form>" .
                                        $buttonElimina .
                                    "</div>" .
                                "</div>" .
                            "</div>"
                            ;
                        } else {
                            echo "</br>Não existe utilizador com o id";
                        }
                    } else {
                        echo "</br>Oops! Something went wrong. Please try again later.";
                    }
                }
            }
            // Close statement
            $stmt->close();
            ?>

        </div>

        <!-- Adicionar contactos -->
        <div id="iAdicionarGrupo" class="row" style="min-height: 100px; padding:1rem !important; padding-top:2rem !important;">

            <div class="col-md-10 col-lg-6 mx-auto text-center">
                <div class="form-group form-inline">
                    <input type="text" class="form-control flex-fill mr-0 mr-sm-2 mb-3 mb-sm-0" id="inputPesquisa"
                        placeholder="Pesquisar...">
                </div>
            </div>

        </div>

        <!-- Pesquisa Container -->
        <div id="newChildsContainer">
        </div>

        <!-- Sobre -->
        <div id="iSobreGrupo" class="row" style="min-height: 400px; padding:1rem !important; padding-top:2rem !important;">
            <div class="col-lg-6" style="padding:10px;">
                <!-- Fotografia do grupo -->
                <div class="form-group form-inline">
                    <div style="margin:auto;">
                        <img src="<?php echo $diretorio . $fotografia; ?>" style="max-width:400px" alt="">
                    </div>

                </div>
            </div>

            <div class="col-lg-6">
                <!-- Nome do grupo -->
                <div class="form-group form-inline">
                    <h5>Nome:</h5>
                    <h5 style="margin-left:15px; color:rgb(82, 82, 82)">
                        <?php echo($nome); ?>
                    </h5>
                </div>

                <!-- Descricao do grupo -->
                <div class="form-group form-inline">
                    <p>
                        <?php echo($descricao); ?>
                    </p>
                </div>

                <!-- Link do grupo -->
                <div class="form-group form-inline">

                    <input type="url" class="form-control flex-fill mr-0 mr-sm-2 mb-3 mb-sm-0" disabled name="grupourl"
                        id="igrupourl" value="<?php echo $url = " http" . (($_SERVER['SERVER_PORT']==443) ? "s" : "" )
                        . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; /*.
                        "http://localhost/php-sessions-sir-ecgm/frontoffice/grupo-page.php?grupo_id=" . $id .
                        "&grupo_nome=" . $nome*/; ?>">
                </div>

            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php
    include 'footer.html';
    ?>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
<script>
var divInicio = document.getElementById("iInicioGrupo");
var divMembros = document.getElementById("iMembrosGrupo");
var divAdicionar = document.getElementById("iAdicionarGrupo");
var divPesqResultados = document.getElementById("newChildsContainer");
var divSobre = document.getElementById("iSobreGrupo");

var btnInicio = document.getElementById("btnInicio");
var btnMembros = document.getElementById("btnMembros");
var btnAdicionar = document.getElementById("btnAdicionar");
var btnSobre = document.getElementById("btnSobre");

$(document).ready(function() {
    divInicio.style = "display:none"; // mudar para flex neste e none nos restantes no fim
    divMembros.style = "display:none";
    divAdicionar.style =
        "display:flex; min-height: 100px; padding:1rem !important; padding-top:2rem !important;";
    divPesqResultados.style =
        "display:flex; min-height: 300px; padding:1rem !important; padding-top:2rem !important;";
    divSobre.style = "display:none";
});

btnInicio.onclick = () => {
    divInicio.style = "display:flex; min-height: 400px; padding:1rem !important; padding-top:2rem !important;";
    divMembros.style = "display:none";
    divAdicionar.style = "display:none";
    divPesqResultados.style = "display:none";
    divSobre.style = "display:none";
}

btnMembros.onclick = () => {
    divInicio.style = "display:none";
    divMembros.style = "display:flex; min-height: 400px; padding:1rem !important; padding-top:2rem !important;";
    divAdicionar.style = "display:none";
    divPesqResultados.style = "display:none";
    divSobre.style = "display:none";
}

btnAdicionar.onclick = () => {
    divInicio.style = "display:none";
    divMembros.style = "display:none";
    divAdicionar.style =
        "display:flex; min-height: 100px; padding:1rem !important; padding-top:2rem !important;";
    divPesqResultados.style =
        "display:flex; min-height: 300px; padding:1rem !important; padding-top:2rem !important;";
    divSobre.style = "display:none";
}

btnSobre.onclick = () => {
    divInicio.style = "display:none";
    divMembros.style = "display:none";
    divAdicionar.style = "display:none";
    divPesqResultados.style = "display:none";
    divSobre.style = "display:flex; min-height: 400px; padding:1rem !important; padding-top:2rem !important;";
}


function deleteUserFromGroup(user_id) {

    if (confirm('Tem a certeza que pretende remover o contacto do grupo?')) {
        $.ajax({
            type: "POST",
            url: 'delete.php',
            data: {
                'action': 'delete_from_group',
                'user': user_id
            },
            success: function(response) {
                location.reload();
            }
        });

    } else {
        return;
    }

}

var inputPesquisa = document.getElementById("inputPesquisa");
var container = document.getElementById("newChildsContainer");
var hiddenIdGrupo = document.getElementById("hiddenIdGrupo");
var idGrupo = hiddenIdGrupo.value;

inputPesquisa.addEventListener("keyup", pesquisaContacto);

//-- Pesquisar contactos para adicionar ao grupo
function pesquisaContacto() {
    var pesquisa = inputPesquisa.value;
    console.log(pesquisa);

    container.innerHTML = "";

    if (!pesquisa) {
        container.innerHTML = "";
        return;
    }

    //-- Se o input de pesquisa tive conteudo, verifica se existem contactos com info identica
    $.ajax({
        type: "POST",
        url: 'pesquisa.php',
        data: {
            'action': 'get_nomes',
            'pesquisa': pesquisa,
            'grupo': idGrupo
        },
        dataType: 'json',
        success: function(response) {
            $.each(response, function(index, element) {
                console.log(element); // print json code

                $("#newChildsContainer").append(
                    "<div class = 'col-lg-3 col-sm-3 text-center mb-4' name ='contacto[]' style=''>" +

                    "<div class='form-group'>" +
                    "<img class='rounded-circle img-fluid d-block mx-auto'style='height:150px' src ='images/contactos/" +
                    element.fotografia + "' alt = ''>" +
                    "<h4 class='h4-overflow-limit'> " + element.nome + "</h4>" +
                    "</div>" +


                    "<div class='form-group form-inline'>" +
                    "<div style ='display:flex;margin-left:auto; margin-right:auto;'>" +

                    "<form id='formPesquisaContacto[]' action='contacto-page.php' enctype='multipart/form-data' method='GET'>" +
                    "<input type = 'hidden' value = '" + element.idutilizador +
                    "'name = 'contacto_id' >" +
                    "<input type = 'hidden' value = '" + element.nome +
                    "'name = 'contacto_nome' >" +
                    "<input type='submit' class='btn btn-outline-primary' value='Ver Perfil'>" +
                    "</form>" +

                    "<button id='" + element.idutilizador +
                    "' class='btn btn-accept' onclick='addUserToGroup(this.id)' style='margin-left:5px'>Adicionar</button>" +

                    "</div>" +
                    "</div>" +

                    "</div>"

                );
            });
        }
    });

}

//-- Adicionar um user ao grupo
function addUserToGroup(user_id) {

    if (confirm('Tem a certeza que pretende adicionar este contacto ao grupo?')) {
        $.ajax({
            type: "POST",
            url: 'adicionar.php',
            data: {
                'action': 'add_to_group',
                'user': user_id,
                'grupo': idGrupo
            },
            success: function(response) {
                location.reload();
            }
        });

    } else {
        return;
    }

}
</script>

</html>