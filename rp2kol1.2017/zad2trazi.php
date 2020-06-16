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
    <?php
        $polaz = $_POST['polazak'];
        $cilj = $_POST['cilj'];
        echo 'Između ' . $polaz . ' i ' . $cilj . ' su dostupni slijedeći letovi:<hr>';

        foreach ($st->fetchAll() as $row){
            $grad2 = $row['cilj_mjesto']; //<-----
            $grad1 = $row['start_mjesto'];
            if ($grad1 === $polaz && $grad2 === $cilj){
                echo $polaz . ' polazak u ' . $row['start_vrijeme'] . '<br>';
                echo $cilj . ' dolazak u ' . $row['cilj_vrijeme'] . '<br>';
                echo 'Cijena ' . $row['cijena'] . '<hr>';
            }
            else {
                $zd = $db->query( 'SELECT * FROM avioni' );
                foreach ($zd->fetchAll() as $red){
                    if ($grad2 === $red['start_mjesto'] && $cilj=== $red['cilj_mjesto']){
                        $cijena = $row['cijena'] + $red['cijena'];
                        echo $polaz . ' polazak u ' . $row['start_vrijeme'] . '<br>';
                        echo 'via ' . $grad2 . '<br>';
                        echo $cilj . ' dolazak u ' . $red['cilj_vrijeme'] . '<br>';
                        echo 'Cijena '. $cijena . '<hr>';
                    }
                }
            }
        }
        foreach ($gradovi as $x) echo $x . " ";
        echo "<br>";
    ?>
</p>
    
</body>
</html>
