<?php

require_once("connectdb.php");

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

    // Check input errors before inserting in database
    if (!empty($email) && !empty($password) && !empty($confirm_password) && ($password === $confirm_password)) {

        // Prepare an insert statement
        $sql = "INSERT INTO utilizador (email, password) VALUES (?, ?)";

        if ($stmt = $connectDB->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ss", $param_email, $param_password);

            // Set parameters
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to login page
                echo "Conta de utilizador criada";
                //header("location: iniciar-sessao.php");
                //-- TODO: Insert info into contacto
                insertUserContacto($connectDB, $email);
            } else {
                echo "</br>Something went wrong. Please try again later.";
            }
        }

        // Close statement
        $stmt->close();
    }
}

//-- insere info nos contactos
function insertUserContacto($connectDB, $email)
{
    $new_user_id = "";

    //### get new ID
    // Validate username
    if (!empty($email)) {
    
        // Prepare a select statement
        $sql = "SELECT idutilizador FROM utilizador WHERE email = ?";
        
        if ($stmt2 = $connectDB->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt2->bind_param("s", $param_email);
            
            // Set parameters
            $param_email = $email;
            
            // Attempt to execute the prepared statement
            if ($stmt2->execute()) {
                // store result
                $stmt2->store_result();
                
                if ($stmt2->num_rows == 1) {
                    $stmt2->bind_result($id);

                    if ($stmt2->fetch()) {
                        $new_user_id = $id;
                        echo("</br>ID do novo user: " . $new_user_id);
                    }
                } else {
                    echo "</br>Não existe utilizador com o email";
                }
            } else {
                echo "</br>Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        $stmt2->close();
    }

    //### Insere Contacto
    if (!empty($new_user_id)) {
        // Prepare an insert statement
        $sql = "INSERT INTO contacto (fk_idutilizador, nome, numero/*, fotografia*/) VALUES (?,?,?)";
         
        if ($stmt2 = $connectDB->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt2->bind_param("sss", $param_id, $param_nome, $param_numero/*, $param_fotografia*/);
            
            // Set parameters
            $param_id = $new_user_id;
            $param_nome = trim($_POST["nome"]);
            $param_numero = trim($_POST["numero"]);
        
            if (empty(trim($_POST["avatar"]))) {
                //-- TODO: Insert photo int DB
            }

            
            // Attempt to execute the prepared statement
            if ($stmt2->execute()) {
                // Redirect to login page
                echo "</br> Dados de contacto inseridos";
                header("location: iniciar-sessao.php");
            } else {
                echo "</br>Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        $stmt2->close();
    } else {
        removeUtilizador($connectDB);
    }
}

// Close connection
$connectDB->close();