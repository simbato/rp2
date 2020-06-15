<?php
session_start();

if (!isset($_SESSION['br_rijeci']))
    $_SESSION['br_rijeci'] = 0;

if (isset($_POST['rijec']) && $_POST['rijec'] !== '' && preg_match('/^[a-zA-Z]+$/',$_POST['rijec'])){
    //echo "doslo";
    $rijec = $_POST['rijec'];
    if ($rijec === "KRAJ"){
        $_SESSION['KRAJ'] = 1;
    }
    else {
        if (isset($_POST['boja']) && $_POST['boja'] !== ''){
            $boja = $_POST['boja'];
            for ($i = 0; $i < strlen( $boja ); $i++ ){
                if ($boja[$i] !== "B" && $boja[$i] !== "R" && $boja[$i] !== 'Y' && $boja[$i] !== 'G'){
                    $boja='X';
                    break;
                }
            }
            if (strlen($boja) > strlen($rijec)) {
                
                $boja = 'X';
            }
        }
        else {
            $boja = 'X';
        }
        $_SESSION["'" . $_SESSION['br_rijeci'] . "'" ] = $rijec . "," . $boja;
        $_SESSION['br_rijeci'] = $_SESSION['br_rijeci'] + 1;
    }
}
if (isset($_SESSION['KRAJ']) && isset($_POST['naslov']) && $_POST['naslov'] !== '' 
                    && preg_match('/^[a-zA-Z\s]+$/',$_POST['naslov'])){
    $_SESSION['naslov'] = $_POST['naslov'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>1. zadatak</title>
</head>
<body>
<?php if (isset($_SESSION['KRAJ']) && $_SESSION['KRAJ'] == 1 && !isset($_SESSION['naslov'])) { ?>
    <form action = "zad1.php" method="post">
    Unesi naslov:
    <input type="text" name="naslov"><br>
    <input type="submit" value="Unesi naslov!">
    </form>

<?php }
else if (isset($_SESSION['KRAJ']) && $_SESSION['KRAJ'] == 1 && isset($_SESSION['naslov'])) {
?>
    <h1><?php echo $_SESSION['naslov']; ?></h1><br>
    <p><?php 
    if(isset($_SESSION['br_rijeci']) && $_SESSION['br_rijeci'] != 0){
        for ($i = 0; $i < $_SESSION['br_rijeci']; $i++){
            $vars = explode("," ,$_SESSION["'" . $i . "'"]);
            if (strlen($vars[1]) == 1){
                if ($vars[1] === "X")
                    echo '<span style="color:black">' . $vars[0] . '</span>' . ' ';
                else if ($vars[1] === "B")
                    echo '<span style="color:blue">' . $vars[0] . '</span>' . ' ';
                else if ($vars[1] === 'R')
                    echo '<span style="color:red">' . $vars[0] . '</span>' . ' ';
                else if ($vars[1] === 'G')
                    echo '<span style="color:green">' . $vars[0] . '</span>' . ' ';
                else if ($vars[1] === 'Y')
                    echo '<span style="color:yellow">' . $vars[0] . '</span>' . ' ';
            }
            else{
                for ($j = 0; $j < strlen($vars[1]); $j++){
                    if ($vars[1][$j] === "X")
                        echo '<span style="color:black">' . $vars[0][$j] . '</span>';
                    else if ($vars[1][$j] === "B")
                        echo '<span style="color:blue">' . $vars[0][$j] . '</span>';
                    else if ($vars[1][$j] === 'R')
                        echo '<span style="color:red">' . $vars[0][$j] . '</span>';
                    else if ($vars[1][$j] === 'G')
                        echo '<span style="color:green">' . $vars[0][$j] . '</span>';
                    else if ($vars[1][$j] === 'Y')
                        echo '<span style="color:yellow">' . $vars[0][$j] . '</span>';
                }
                echo " ";
            }
        }
    } 

    ?> </p><br>

<?php
}
else  { ?>
<form action = "zad1.php" method="post">
    <p id="p"><?php 
    if(isset($_SESSION['br_rijeci']) && $_SESSION['br_rijeci'] != 0){
        for ($i = 0; $i < $_SESSION['br_rijeci']; $i++){
            $vars = explode("," ,$_SESSION["'" . $i . "'"]);
            if (strlen($vars[1]) == 1){
                if ($vars[1] === "X")
                    echo '<span style="color:black">' . $vars[0] . '</span>' . ' ';
                else if ($vars[1] === "B")
                    echo '<span style="color:blue">' . $vars[0] . '</span>' . ' ';
                else if ($vars[1] === 'R')
                    echo '<span style="color:red">' . $vars[0] . '</span>' . ' ';
                else if ($vars[1] === 'G')
                    echo '<span style="color:green">' . $vars[0] . '</span>' . ' ';
                else if ($vars[1] === 'Y')
                    echo '<span style="color:yellow">' . $vars[0] . '</span>' . ' ';
            }
            else{
                for ($j = 0; $j < strlen($vars[1]); $j++){
                    if ($vars[1][$j] === "X")
                        echo '<span style="color:black">' . $vars[0][$j] . '</span>';
                    else if ($vars[1][$j] === "B")
                        echo '<span style="color:blue">' . $vars[0][$j] . '</span>';
                    else if ($vars[1][$j] === 'R')
                        echo '<span style="color:red">' . $vars[0][$j] . '</span>';
                    else if ($vars[1][$j] === 'G')
                        echo '<span style="color:green">' . $vars[0][$j] . '</span>';
                    else if ($vars[1][$j] === 'Y')
                        echo '<span style="color:yellow">' . $vars[0][$j] . '</span>';
                }
                echo " ";
            }
        }
    } 

    ?> </p><br>
    Unesi novu riječ:
    <input type="text" name="rijec"><br>
    Unesi boju nove riječi:
    <input type="text" name="boja"><br>
    <input type="submit" name="submit" value="Unesi!">
</form>
<?php } ?>
</body>
</html>