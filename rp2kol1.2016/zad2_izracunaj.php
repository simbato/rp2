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
$redovi = array();
$imena = array();
$iznos;

if (isset($_POST['submit'])){
    $iznos = $_POST['iznos'];
    $key = 0;
    foreach($st->fetchAll() as $row){
        if (isset($_POST[$key ])){

            array_push($redovi, $key);
            array_push($imena, $_POST[$key]);
        }
        $key++;
    }
}
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
    <table>
        <tr>
            <td><b>Prvi igrač</b></td><td><b>Drugi igrač</b></td>
        </tr>
        <?php
        $i = 0;
        $j = 0;
            foreach($st->fetchAll() as $row){
                if (!in_array($i, $redovi)){
                    $i++;
                    continue;
                } 
                echo '<tr>';
                echo "<td>";
                echo '(' . $row['koef1'] . ')';
                if ($imena[$j] == ($i . '0')){
                    echo '<span style="color:green">' . $row['igrac1'] .'</span>';
                    $iznos *= $row['koef1'];
                }
                else
                    echo $row['igrac1'];
                echo '</td>';
                echo "<td>";
                echo '(' . $row['koef2'] . ')';
                if ($imena[$j] == ($i . '1')){
                    echo '<span style="color:green">' . $row['igrac2'] .'</span>';
                    $iznos *= $row['koef2'];
                }
                else
                    echo $row['igrac2'];
                echo '</td>';
                echo '</tr>';
                $i++;
                $j++;
            }

        ?>
    </table><br>
    <p>Moguće je osvojiti <?php echo $iznos; ?> kuna</p>
</body>
</html>