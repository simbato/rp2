<?php

require_once __DIR__ . '/app/database/db.class.php';
$db = DB::getConnection();

if(isset($_POST['username']) && isset($_POST['password']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];
    if ($_POST['gumb'] == "login"){
        try{
			$st = $db->prepare( 'SELECT password_hash FROM dz2_users WHERE username=:username' );
			$st->execute( array( 'username' => $username ) );
        }
        catch(PDOException $e){
			echo "Greška: " . $e;
        }
        $row = $st->fetch();

        if( $row === false )
        {
            // Taj user ne postoji, upit u bazu nije vratio ništa.
            echo "Takav username ne postoji.";
        }
        else {
            if (password_verify($password, $row['password_hash'])){
                $_SESSION['username'] = $username;
                $_SESSION['login'] = 1;
                header( 'Location: index.php' );
            }
            else
                echo "Kriva lozinka.";
        }
    }
    else {
        //stvori novog usera
        if (isset($_POST['email']) && $_POST['email'] != "") {
            $email = $_POST['email'];
            try{
                $st = $db->prepare( 'SELECT password_hash FROM dz2_users WHERE username=:username' );
                $st->execute( array( 'username' => $username ) );
            }
            catch(PDOException $e){
                echo "Greška: " . $e;
            }
            if ($st->rowCount() > 0) {
                echo "Već postoji takav username.";
            }
            else {
                //dodavanje u bazu
                $hash = password_hash($password ,PASSWORD_DEFAULT);
                try{
                    $st = $db->prepare( 'INSERT INTO dz2_users 
                        (username, password_hash, email, registration_sequence, has_registered) 
                        VALUES (:username, :hash, :email, :registration_sequence, :has_registered)' );
                    $st->execute( array( 'username' => $username, 'hash' => $hash, 'email' => $email, 'registration_sequence' =>'abcd','has_registered' => 1 ) );
                }catch(PDOException $e){
                    echo "Greška: " . $e;
                }
            }
        }
        else{
            echo "Za registraciju je potrebno unijeti mail.";
        }
    }
}

require_once __DIR__ . '/view/loginview.php';
?>