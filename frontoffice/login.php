<?php
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["logged"]) && $_SESSION["logged"] === true) {
    header("location: welcome.php");
    exit;
}

require_once("connectdb.php");

// Define variables and initialize with empty values
$email = $password = "";

//echo(password_hash("admin", PASSWORD_DEFAULT));

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    // Check if username is empty
    if (empty(trim($_POST["email"]))) {
        //$username_err = "Please enter username.";
    } else {
        $email = trim($_POST["email"]);
        echo("</br>" . $email);
    }
    
    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        //$password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
        echo("</br>" . $password);
    }
    
    // Validate credentials
    // Prepare a select statement
    $sql = "SELECT idutilizador, email, password FROM utilizador WHERE email = ?";
        
    if ($stmt = $connectDB->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("s", $param_email);
            
        // Set parameters
        $param_email = $email;
            
        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Store result
            $stmt->store_result();
                
            // Check if username exists, if yes then verify password
            if ($stmt->num_rows == 1) {
                // Bind result variables
                $stmt->bind_result($id, $email, $hashed_password);
                if ($stmt->fetch()) {
                    if (password_verify($password, $hashed_password)) {
                        // Password is correct, so start a new session
                        session_start();
                            
                        // Store data in session variables
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["email"] = $email;
                            
                        // Redirect user to welcome page
                        header("location: welcome.php");
                        echo "Logado!";
                    } else {
                        // Display an error message if password is not valid
                        //$password_err = "The password you entered was not valid.";
                    }
                }
            } else {
                // Display an error message if username doesn't exist
                //$username_err = "No account found with that username.";
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
        
    // Close statement
    $stmt->close();
    
    
    // Close connection
    $connectDB->close();
}



















/*
// inicializar prepared statement
    $stmt = $connectDB->prepare("SELECT email, password FROM utilizador");

    // executar
    $stmt->execute();

    // associar os parametros de output
    $stmt->bind_result($r_email, $r_password);

    // transfere o resultado da última query : obrigatorio para ter num_rows
    $stmt->store_result();

    // iterar / obter resultados
    $stmt->fetch();

    if ($stmt->num_rows > 0) { // seleciona o resultado da base de dados
        echo("</br> Encontrado utilizador: " . $r_email);
        $stmt->close();
    } else {
        echo("</br> Não encontrou nenhum utilizador");
        $stmt->close();
    }














//#########################################

// -- if user was found or not
$found = false;

//-- query para obter utilizadores
$usersQuery = "select email, password from utilizador";

$usersResult = $connectDB->query($usersQuery);

// check for errors
if ($connectDB->errno) {
    exit("query error");
} else {

    // fetch results as object
    $usersResult->data_seek(0);
    while (!$found && $user = $usersResult->fetch_object()) {
        echo "<li>" . $user->idutilizador . " | " . $user->username . " | " . $user->password . " | " . $user->tipo . "</li>";

        $USER = $user->username;
        $PASS = $user->password;
        $ID = $user->idutilizador;
        $TIPO = $user->tipo;


        if (isset($_SESSION['username'])) {
            header("location:iniciar-sessao.php");
        } elseif (!(isset($_POST['username']) || !(isset($_POST['password'])))) {
            // se recebeu post com username e password vazios
            header("location:iniciar-sessao.php");
        } elseif ($_POST['username'] !== $USER || $_POST['password'] !== $PASS) {
            // se o post é diferente do existente na DB
            header("location:iniciar-sessao.php");
        } else {
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['id'] = $ID;
            $_SESSION['tipo'] = $TIPO;

            //-- Converte int em string para mostrar o cargo do user no menu superior
            if ($TIPO == 0) {
                $_SESSION['cargo'] = "Administrador";
            } elseif ($TIPO == 1) {
                $_SESSION['cargo'] = "Aluno";
            } else {
                $_SESSION['cargo'] = "Professor";
            }

            //-- Get the data to add into the SESSION
            getData($connectDB, $ID, $TIPO);

            //echo ("(1) Nome na sessão: " . $_SESSION['nome']);

            //echo "</br><li>" . $USER . " | " . $PASS . "</li>";
            $found = true;
            header("location:iniciar-sessao.php");
        }
    }
}

function getData($connectDB, $ID, $TIPO)
{
    //-- é aluno
    if ($TIPO == 1) {
        $dataQuery = "select * from aluno where fk_idutilizador = '$ID'";

        $dataResult = $connectDB->query($dataQuery);

        // check for errors
        if ($connectDB->errno) {
            exit("query error");
        } else {
            $dataResult->data_seek(0);
            while ($data = $dataResult->fetch_object()) {
                //echo "<li>" . $user->idutilizador . " | " . $user->username . " | " . $user->password . " | " . $user->tipo . "</li>";
                $_SESSION['nome'] = $data->nome;
                //echo ("(2) Nome na sessão: " . $_SESSION['nome']);
                //$_SESSION['fotografia'] = $data->fotografia;
            }
        }
    }
}

session_write_close();
// Close connection
$connectDB->close();;
exit();*/