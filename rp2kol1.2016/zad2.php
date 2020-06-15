<?php 

// Spoji se na bazu
$user = 'student'; // unesite username sa papira
$pass = 'pass.mysql'; // unesite password sa papira

try 
{
	// zamijenite HOST imenom servera za rp2 ili njegovom ip adresom
	// zamijenite PREZIME svojim prezimenom (malim slovima), tj. imenom vaše baze na rp2 serveru.
	$db = new PDO( 'mysql:host=rp2.studenti.math.hr;dbname=batovic;charset=utf8', $user, $pass );
} 
catch( PDOException $e ) 
{
	echo "Greška: " . $e->getMessage(); exit();
}

// Dohvati sve podatke o studentima iz tablice.
$st = $db->query( 'SELECT * FROM zadatak2' );
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>zadatak 2</title>
    <style>
        table,td {border: solid 1px black;}
    </style>
</head>
<body>
<form action = "zad2_izracunaj.php" method="post">
    <table>
        <tr>
            <td><b>Prvi igrač</b></td><td><b>Drugi igrač</b></td>
        </tr>
        <?php
        $i = 0;
            foreach($st->fetchAll() as $row){
                echo '<tr>';
                echo "<td>";
                echo '(' . $row['koef1'] . ')';
                echo $row['igrac1'];
                echo '<input type="radio" name="'.$i.'" value="'.$i.'0" />';
                echo '</td>';
                echo "<td>";
                echo '<input type="radio" name="'.$i.'" value="'.$i.'1" />';
                echo '(' . $row['koef2'] . ')';
                echo $row['igrac2'];
                echo '</td>';
                echo '</tr>';
                $i++;
            }

        ?>
    </table><br>
    Unesi iznos:
    <input type="text" name="iznos">
    <input type="submit" name="submit" value="Izračunaj!">
</form>
</body>
</html>