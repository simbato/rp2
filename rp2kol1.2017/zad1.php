<?php
session_start();

if(!isset($_SESSION['br'])){
    $_SESSION['br'] = 1;
    $_SESSION['r1'] = 10;
    $_SESSION['max'] = 10;
    $_SESSION['min'] = 10;
    $_SESSION['trenutno'] = 10;
}

if (isset($_POST['napravi']) && isset($_POST['radio'])){
    if ($_POST['radio'] === '1' && $_POST['iznos1'] != '' && preg_match('/^[1-9][0-9]*$/', $_POST['iznos1'])){
        $iznos = $_POST['iznos1'];
        $row = $_POST['redak1'];
        if ($_SESSION['r'.$row] + $iznos <= 10){
            $_SESSION['r'.$row] += $iznos;
            $_SESSION['trenutno'] += $iznos;

            if ($_SESSION['max'] < $_SESSION['trenutno'])
                $_SESSION['max'] = $_SESSION['trenutno'];
        }
    }
    else if ($_POST['radio'] === '2' && $_POST['iznos2'] != '' && preg_match('/^[1-9][0-9]*$/', $_POST['iznos2'])){
        $iznos = $_POST['iznos2'];
        $row = $_POST['redak2'];
        if ($_SESSION['r'.$row] - $iznos >= 0){
            $_SESSION['r'.$row] -= $iznos;
            $_SESSION['trenutno'] -= $iznos;

            if ($_SESSION['min'] > $_SESSION['trenutno'])
                $_SESSION['min'] = $_SESSION['trenutno'];
        }
            
    }
    else if ($_POST['radio'] === '3'){
        $broj = $_SESSION['br'];
        $broj++;
        $_SESSION['r'.$broj] = 10;
        $_SESSION['br'] = $broj;
        $_SESSION['trenutno'] += 10;
        if ($_SESSION['min'] > $_SESSION['trenutno'])
            $_SESSION['min'] = $_SESSION['trenutno'];
        if ($_SESSION['max'] < $_SESSION['trenutno'])
            $_SESSION['max'] = $_SESSION['trenutno'];
    }
}

if (isset($_POST['kraj'])){
    $_SESSION['kraj'] = 1;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>zadatak 1</title>
    <style>
        td {border: solid 1px black;
            width: 35px; 
            height: 40px;
            text-align: center; }
    </style>
</head>
<body>
<?php 
if (isset($_SESSION['kraj']) && $_SESSION['kraj'] == 1){ 
    echo 'Najveći broj kocaka: ' . $_SESSION['max']. '<br>';
    echo 'Najmanji broj kocaka: ' . $_SESSION['min'];
    session_unset();
    session_destroy();
}
else{ ?>

    <table>
        <?php
            for ($i = 1; $i <= $_SESSION['br']; $i++){
                echo '<tr>';
                for ($j = 0; $j < $_SESSION['r'.$i]; $j++){
                    echo '<td>K</td>';
                    $flag=1;
                }
                echo '</tr>';
            }
        ?>
    </table><br>
    <form action = "zad1.php" method="post">
        <input type="radio" name="radio" value="1" id="1">
        <label for="1">Dodaj <input type="text" name="iznos1"> kocaka u red broj
        <select name="redak1" id = "redak1">
            <?php 
            for ($i = 1; $i <= $_SESSION['br']; $i++)
                echo '<option value = "'.$i.'">'.$i.'</option>';
            ?>
        </select></label><br>

        <input type="radio" name="radio" value="2" id="2">
        <label for="2">Ukloni <input type="text" name="iznos2"> kocaka iz reda broj
        <select name="redak2" id = "redak2">
            <?php 
            for ($i = 1; $i <= $_SESSION['br']; $i++)
                echo '<option value = "'.$i.'">'.$i.'</option>';
            ?>
        </select></label><br>

        <input type="radio" name="radio" value="3" id="3">
        <label for="3">Dodaj novi red!</label><br>

        <input type="submit" name="napravi" value="Napravi!">
        <input type="submit" name="kraj" value="Kraj igre!">
    </form>
<?php 
}
?>
</body>
</html>