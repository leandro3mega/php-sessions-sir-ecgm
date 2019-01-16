<?php

session_start();

require_once("connectdb.php");

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["logged"]) && $_SESSION["logged"] === true) {
} else {
    header("location: iniciar-sessao.php");
    exit;
}

$mimeExt = array();
$mimeExt['image/jpeg'] = '.jpg';
$mimeExt['image/pjpeg'] = '.jpg';
$mimeExt['image/png'] = '.png';

//-- Definicao de variaveis de tamanho
define('KB', 1024);
define('MB', 1048576);
define('GB', 1073741824);
define('TB', 1099511627776);


$id_grupo = $nome = $descricao = $fotografia = "";

$user_id = $_SESSION['id'];
$nome = trim($_POST['grupo_nome']);
$descricao = trim($_POST["grupo_descricao"]);
$grupo_criado= false;

// se na verificação anterior não existia user com o mesmo email na DB, continua no script
if (!empty($nome)) {
    if ($stmt = $connectDB->prepare("INSERT INTO grupo (nome, descricao, fotografia) VALUES (?,?,?)")) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("sss", $param_nome, $param_descricao, $param_fotografia);

        // Set parameters
        $param_nome = $nome;
        $param_descricao = $descricao;

        //-- Se o user não inserir fotografia, mete a foto default
        if (!isset($_FILES['fotografia'])) {
            $param_fotografia = "default_avatar.png";
        } else {
            //-- Caso contrario insere a foto selecionada na pasta e na DB
            $diretorio = "images/grupos/";
            $type = mime_content_type($_FILES['fotografia']['tmp_name']);
            
            //Begins image upload
            $id_fotografia = md5(uniqid(time())) . $mimeExt[$_FILES["fotografia"]["type"]]; //Get image extension
            echo "id_foto: " . $id_fotografia;
            $user_foto_dir = $diretorio . $id_fotografia; //Path file
            $param_fotografia = $id_fotografia;
            echo "param_foto: " . $param_fotografia;

            //--Move image
            move_uploaded_file($_FILES["fotografia"]["tmp_name"], $user_foto_dir);

            // echo "Fotografia Alterada com Sucesso!";
        }

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Redirect to login page
            echo "</br>Grupo criado";
            $grupo_criado = true;
        } else {
            echo "</br>Something went wrong. Please try again later.";
        }
    }

    // Close statement
    $stmt->close();
} else {
    header("location: grupos-page.php");
}

if ($grupo_criado) {
    // query à base de dados
    $sqlSelect = "SELECT idgrupo FROM grupo WHERE nome=? AND descricao=?";

    // inicializar prepared statement
    $stmt = $connectDB->prepare($sqlSelect);

    $stmt->bind_param("ss", $param_nome, $param_descricao);

    $param_nome = $nome;
    $param_descricao = $descricao;

    // executar
    $stmt->execute();

    // associar os parametros de output
    $stmt->bind_result($r_id_grupo);

    // transfere o resultado da última query : obrigatorio para ter num_rows
    $stmt->store_result();

    // iterar / obter resultados
    $stmt->fetch();

    //echo ($stmt->num_rows == 1);
    if ($stmt->num_rows == 1) { // seleciona o resultado da base de dados
        $id_grupo = $r_id_grupo;
    }
    $stmt->close();
}

if ($grupo_criado) {
    // Prepare an insert statement
    $sql = "INSERT INTO utilizador_grupo (fk_idutilizador, fk_idgrupo, cargo) VALUES (?,?,?)";

    if ($stmt = $connectDB->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("sss", $param_idutilizador, $param_idgrupo, $param_cargo);

        // Set parameters
        $param_idutilizador = $user_id;
        $param_idgrupo = $id_grupo;
        $param_cargo = 3;

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Redirect to login page
            echo "</br>Ligação utilizador-grupo criada";
            header("location: grupos-page.php");
        } else {
            echo "</br>Something went wrong. Please try again later.";
        }
    }

    // Close statement
    $stmt->close();
}