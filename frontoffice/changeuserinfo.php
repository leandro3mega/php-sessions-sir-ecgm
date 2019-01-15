<?php
session_start();

require_once("connectdb.php");

// $username = $_SESSION['nome'];
$id = $_SESSION['id'];

if ($_POST['action'] == 'change_name') {
    $new_nome = trim($_POST["name"]);
    changeNome($connectDB, $id, $new_nome);
} elseif ($_POST['action'] == 'change_email') {
    $new_email = $_POST['email'];
    changeEmail($connectDB, $id, $new_email);
} elseif ($_POST['action'] == 'change_numero') {
    $new_numero = $_POST['numero'];
    changeNumero($connectDB, $id, $new_numero);
} elseif ($_POST['action'] == 'change_password') {
    changePassword($connectDB, $id);
} elseif ($_POST['action'] == 'change_fotografia') {
    changeFotografia($connectDB, $id);
}


//-- Function that change the name of a user in the DB
function changeNome($connectDB, $id, $new_nome)
{
    $sql = "UPDATE utilizador SET nome=? WHERE idutilizador=?";

    if ($stmt = $connectDB->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("ss", $param_nome, $param_id);

        // Set parameters
        $param_nome = $new_nome;
        $param_id = $id;

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Redirect to login page
            echo "Nome mudado com sucesso";
        } else {
            echo "</br>Something went wrong. Please try again later.";
        }
    }
}

//-- Function that change the email of a user in the DB
function changeEmail($connectDB, $id, $new_email)
{
    $sql = "UPDATE utilizador SET email=? WHERE idutilizador=?";

    if ($stmt = $connectDB->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("ss", $param_email, $param_id);

        // Set parameters
        $param_email = $new_email;
        $param_id = $id;

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Redirect to login page
            echo "Email mudado com sucesso";
        } else {
            echo "</br>Something went wrong. Please try again later.";
        }
    }
}

//-- Function that change the email of a user in the DB
function changeNumero($connectDB, $id, $new_numero)
{
    $sql = "UPDATE utilizador SET numero=? WHERE idutilizador=?";

    if ($stmt = $connectDB->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("ss", $param_numero, $param_id);

        // Set parameters
        $param_numero = $new_numero;
        $param_id = $id;

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Redirect to login page
            echo "Numero mudado com sucesso";
        } else {
            echo "</br>Something went wrong. Please try again later.";
        }
    }
}


//-- Function that change the password of a user in the DB
function changePassword($connectDB, $id)
{
    $pass_old = $_POST['password_old'];
    $pass_new = $_POST['password_new'];
    $podeMudar = false;

    //echo ("Irá Mudar a passe de " . $pass_old . " para " . $pass_new);
    
    // query à base de dados
    $sqlSelect = "SELECT password FROM utilizador WHERE idutilizador=?";

    // inicializar prepared statement
    $stmt = $connectDB->prepare($sqlSelect);

    // md5 para desincriptar a password
    //$password = md5($pass_old);
    $stmt->bind_param("s", $id);

    // executar
    $stmt->execute();

    // associar os parametros de output
    $stmt->bind_result($r_password);

    // transfere o resultado da última query : obrigatorio para ter num_rows
    $stmt->store_result();

    // iterar / obter resultados
    $stmt->fetch();

    //echo ($stmt->num_rows == 1);
    if ($stmt->num_rows == 1) { // seleciona o resultado da base de dados
        
        //-- Se a password inserida e a na DB forem iguais
        if (password_verify($pass_old, $r_password)) {
            $podeMudar = true;
        // echo("A password atual inserida está Correta!");
        } else {
            //-- se as password não forem iguais
            echo("A password atual inserida está errada!");
        }
    }
    $stmt->close();

    if ($podeMudar == true) {
        $sql = "UPDATE utilizador SET password=? WHERE idutilizador=?";

        if ($stmt = $connectDB->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ss", $param_Password, $param_id);

            // Set parameters
            $param_Password = password_hash($pass_new, PASSWORD_DEFAULT); // Creates a password hash
            $param_id = $id;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to login page
                echo "Palavra passe mudada com sucesso";
            } else {
                echo "</br>Something went wrong. Please try again later.";
            }
        }
        $stmt->close();
    }
}

//-- Function that change the photo of a user in the DB
function changeFotografia($connectDB, $id)
{
    $mimeExt = array();
    $mimeExt['image/jpeg'] = '.jpg';
    $mimeExt['image/pjpeg'] = '.jpg';
    $mimeExt['image/png'] = '.png';

    //-- Definicao de variaveis de tamanho
    define('KB', 1024);
    define('MB', 1048576);
    define('GB', 1073741824);
    define('TB', 1099511627776);

    deleteOldFoto($connectDB, $id);

    $sql = "UPDATE utilizador SET fotografia=? WHERE idutilizador=?";

    if ($stmt = $connectDB->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("ss", $param_fotografia, $param_id);

        // Set parameters
        $param_id = $id;

        //-- Se não existir foto, aborta
        if (!isset($_FILES['fotografia'])) {
            return;
        } else {
            //-- Caso contrario insere a foto selecionada na pasta e na DB
            $diretorio = "images/contactos/";
            $type = mime_content_type($_FILES['fotografia']['tmp_name']);
                
            //Begins image upload
            $id_fotografia = md5(uniqid(time())) . $mimeExt[$_FILES["fotografia"]["type"]]; //Get image extension
            $user_foto_dir = $diretorio . $id_fotografia; //Path file
            $param_fotografia = $id_fotografia;

            //--Move image
            move_uploaded_file($_FILES["fotografia"]["tmp_name"], $user_foto_dir);
        }

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Redirect to login page
            echo "Fotografia mudada com sucesso";
            header("location: perfil-page.php");
        } else {
            echo "</br>Something went wrong. Please try again later.";
        }
    }
}

//-- Apaga a foto antiga do user
function deleteOldFoto($connectDB, $id)
{
    $result = mysqli_query($connectDB, "SELECT fotografia FROM utilizador WHERE idutilizador=$id");

    if (mysqli_num_rows($result) == 1) {
        $row = $result->fetch_assoc();

        $fotografia = $row['fotografia'];
    } else {
        echo "</br> Não encontrou contacto";
    }

    $diretorio = "images/contactos/";

    unlink($diretorio . $fotografia);   // apaga foto com um nome
}


// Close connection
$connectDB->close();