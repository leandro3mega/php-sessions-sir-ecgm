<?php

require_once("connectdb.php");

$mimeExt = array();
$mimeExt['image/jpeg'] = '.jpg';
$mimeExt['image/pjpeg'] = '.jpg';
$mimeExt['image/png'] = '.png';

//-- Definicao de variaveis de tamanho
define('KB', 1024);
define('MB', 1048576);
define('GB', 1073741824);
define('TB', 1099511627776);


// Define variables and initialize with empty values
$email = $password = $confirm_password = "";
 
// Processing form data when form is submitted

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Validate username
    if (!empty(trim($_POST["email"]))) {

        // Prepare a select statement
        $sql = "SELECT idutilizador FROM utilizador WHERE email = ?";

        if ($stmt = $connectDB->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_email);

            // Set parameters
            $param_email = trim($_POST["email"]);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // store result
                $stmt->store_result();

                if ($stmt->num_rows == 1) {
                    echo "</br>Já se encontra um utilizador registado com o email " . trim($_POST['email']);
                } else {
                    $email = trim($_POST["email"]);
                    echo "</br>Não existe utilizador com o email";
                }
            } else {
                echo "</br>Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        $stmt->close();
    }

    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirmPassword"]);

    // se na verificação anterior não existia user com o mesmo email na DB, continua no script
    if (!empty($email) && !empty($password) && !empty($confirm_password) && ($password === $confirm_password)) {

        // Prepare an insert statement
        $sql = "INSERT INTO utilizador (email, password, nome, numero, fotografia) VALUES (?,?,?,?,?)";

        if ($stmt = $connectDB->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sssss", $param_email, $param_password, $param_nome, $param_numero, $param_fotografia);

            // Set parameters
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_nome = trim($_POST["nome"]);
            $param_numero = trim($_POST["numero"]);

            //-- Se o user não inserir fotografia, mete a foto default
            if (!isset($_FILES['fotografia'])) {
                $param_fotografia = "default_avatar.png";
            } else {
                //-- Caso contrario insere a foto selecionada na pasta e na DB
                $diretorio = "images/contactos/";
                $type = mime_content_type($_FILES['fotografia']['tmp_name']);
                
                //Begins image upload
                $id_fotografia = md5(uniqid(time())) . $mimeExt[$_FILES["fotografia"]["type"]]; //Get image extension
                $user_foto_dir = $diretorio . $id_fotografia; //Path file
                $param_fotografia = $id_fotografia;

                //echo("id_fotografia: " . $id_fotografia);
                //--Move image
                move_uploaded_file($_FILES["fotografia"]["tmp_name"], $user_foto_dir);

                echo "Fotografia Alterada com Sucesso!";


                //-- Insert image name into de DB
                //insertImage($connectDB, $id_utilizador, $user_foto, $user_foto_dir);
                //echo("</br>Nome: " . $id_fotografia);
                //echo("</br>Diretorio: " . $user_foto_dir);
            }

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to login page
                echo "</br>Conta de utilizador criada";
                header("location: iniciar-sessao.php");
            } else {
                echo "</br>Something went wrong. Please try again later.";
            }
        }

        // Close statement
        $stmt->close();
    }
}

function getUserID($connectDB, $email)
{
    if ($stmt = $connectDB->prepare("SELECT idutilizador FROM utilizador WHERE email = ?")) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("s", $param_email);

        // Set parameters
        $param_email = $email;
        echo("</br>Param email: " . $param_email);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // associar os parametros de output
            $stmt->bind_result($r_id);

            // store result
            $stmt->store_result();

            // iterar / obter resultados
            $stmt->fetch();

            if ($stmt->num_rows == 1) {
                echo "</br>Encontrou um utilizador registado com o email: " . $email;
                return $r_id;
                echo("</br>ID: " . $r_id);
            } else {
                echo "</br>Não existe utilizador com o email";
                return null;
            }
        } else {
            echo "</br>Oops! Something went wrong. Please try again later.";
        }
    }

    // Close statement
    $stmt->close();
}


function removeUtilizador($connectDB, $id)
{
    // inicializar prepared statement
    $stmt = $connectDB->prepare("DELETE FROM utilizador WHERE idutilizador=?");
    
    if (false === $stmt) {
        echo "</br>(removeUtilizador) Não conseguiu preparar a query";
    }
    
    $stmt->bind_param("s", $id);

    // executar
    if ($stmt->execute()) {
        echo "</br>(removeUtilizador) Utilizador removidas com sucesso.";
    } else {
        echo "</br>(removeUtilizador) Ocurreu um erro: Não conseguiu executar a query: " . mysqli_error($connectDB) . ". ";
    }

    $stmt->close();
}


// Close connection
$connectDB->close();