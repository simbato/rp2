<?php 

// Spoji se na bazu
$user = 'student'; // unesite username sa papira
$pass = 'pass.mysql'; // unesite password sa papira

try 
{
	// zamijenite HOST imenom servera za rp2 ili njegovom ip adresom
	// zamijenite PREZIME svojim prezimenom (malim slovima), tj. imenom vaše baze na rp2 serveru.
	$db = new PDO( 'mysql:host=rp2.studenti.math.hr;dbname=kosir;charset=utf8', $user, $pass );
} 
catch( PDOException $e ) 
{
	echo "Greška: " . $e->getMessage(); exit();
}

// Dohvati sve podatke o studentima iz tablice.
$st = $db->query( 'SELECT * FROM avioni' );
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">">
    <title>zadaca 2</title>
</head>
<body>
<p>
    Dostupni su letovi u slijedeće gradove:
    <?php
        $gradovi = array();
        foreach ($st->fetchAll() as $row){
            $grad1 = $row['cilj_mjesto'];
            $grad2 = $row['start_mjesto'];
            if (!in_array($grad1, $gradovi))
                array_push($gradovi, $grad1);
            if (!in_array($grad2, $gradovi))
                array_push($gradovi, $grad2);
        }
        foreach ($gradovi as $x) echo $x . " ";
        echo "<br>";
    ?>
</p>
<form action= "zad2trazi.php" method= "post">
Polazni grad:
<input type="text" name="polazak"><br>
Ciljni grad:
<input type="text" name="cilj"><br>
<input type="submit" name="submit" value="Trazi putovanja">
</form>
    
</body>
</html>

 