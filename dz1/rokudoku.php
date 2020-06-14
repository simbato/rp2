<?php
#$db=new PDO('mysql:host=rp2.studenti.math.hr; dbname=simbato; charset=utf8','student','pass.mysql');
session_start();

if (isset($_POST['name'])) {
    $_SESSION['username'] = $_POST['name'];
}

if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
}

if(isset($_POST['game']) && $_POST['game'] == 'Rokudoku1') {
    $tablica = "004000000230300060060002021000000500";
    $_SESSION['tablica'] = $tablica;
    $_SESSION['n'] = 1;
}

if(isset($_POST['game']) && $_POST['game']=='Rokudoku2') {
    $tablica = "030001200000020010000006004650502040";
    $_SESSION['tablica']=$tablica;
    $_SESSION['n'] = 1;
}

$tablica = $_SESSION['tablica'];
$tab = $_SESSION['tablica'];


if(isset($_POST["submit"]) && $_POST["submit"] == "Izvrši akciju!") {

    if($_POST['wra'] == "1") {
        if(isset($_SESSION['tab'])) {
            $tab = $_SESSION['tab'];
        }
        if(isset($_SESSION['n'])) {
            $n = $_SESSION['n'];
        }
        for ($i=0; $i < 36; $i++) { 
            if(isset($_POST[(string)$i]) && isValidNumber($_POST[(string)$i])) {
                $tab[$i] = (int)$_POST[(string)$i];
                $_SESSION['tab'] = $tab;
            }
        }
    }
    else if($_POST['wra']=="2") {
        if(isset($_SESSION['tab'])) {
            $tab = $_SESSION['tab'];
        }
        if(isset($_SESSION['n'])) {
            $n = $_SESSION['n'];
        }
        if($tablica[ ((int)$_POST['redak'] - 1) * 6 + (int)$_POST['stupac'] - 1] == 0) {
            $tab[ ((int)$_POST['redak'] - 1) * 6 + (int)$_POST['stupac'] - 1] = 0;
            $_SESSION['n'] = $n + 1;
        }
    }
    else if($_POST['wra']=="3"){
        $_SESSION['n'] = 1;   
    }
}


//POMOCNE FUNKCIJE

function isValidNumber($s) {
    return preg_match('/^[1-6]{1}$/',$s);
}

function ok_cell($A, $x){
    $row = intdiv($x, 6);
    $col = $x % 6;

    if ($row < 2) $r = 0;
    else if ($row < 4) $r = 2;
    else $r = 4;

    for ($i = 0; $i < 2; $i++)
        if ($col < 3){
            for ($j = 0; $j < 3; $j++){
                if ($r + $i == $row && $j == $col) continue;
                if ($A[6*($r + $i) + $j] == $A[6*$row + $col]) return FALSE;
            }
        }
        else{
            for ($j = 3; $j < 6; $j++){
                if ($r + $i == $row && $j == $col) continue;
                if ($A[6*($r + $i) + $j] == $A[6*$row + $col]) return FALSE;
            }
        }
    return TRUE;
}
function ok_row($A, $x){
    $row = intdiv($x, 6);
    for ($i = 0; $i < 6; $i++)
        if ($x != (6 * $row + $i) && ($A[6 * $row + $i] == $A[$x]))
            return FALSE;
    return TRUE;
} 

function ok_col($A, $x){
    $col = $x % 6;
    for ($i = 0; $i < 6; $i++)
        if ($x != (6 * $i + $col) && $A[6 * $i + $col] == $A[$x] )
            return FALSE;
    return TRUE;
}

function ok($A, $x){
    if (ok_cell($A, $x) && ok_row($A, $x) && ok_col($A, $x))
        return TRUE;
    else return FALSE;
}

function is_over($A){
    for ($i = 0; $i < 6; $i++)
        for ($j = 0; $j < 6; $j++){
            if ($A[$i * 6 + $j] == 0 || !ok($A, $i*6 + $j))
                return FALSE;
        }
    return TRUE;
}

$_SESSION['tab'] = $tab;

?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rokudoku</title>
    <style>
        td {border: solid 1px black;
            text-align: center;
            height: 70px;
            width: 80px;
            font-size: 25px; 
        }
        table {
            border: solid 4px black;
            
            border-collapse: collapse;
        }
        tr{
          /*  border: solid 2px black;*/
        }
    </style>
</head>
<body>
<?php
if (isset($_SESSION['username'])){ ?>

    <form action="rokudoku.php" method="post">
    <h1> Rokudoku </h1>
    <br>
    <strong>Igrač: <?php echo $username ?></strong>
    <br>
    <strong>Broj Pokušaja: <?php echo $_SESSION['n']; ?></strong>
    <br><br>
        <table>
            <?php
                for ($i = 0; $i < 6; $i++){
                    echo "<tr>";
                    for ($j = 0; $j < 6; $j++){
                        if ($i % 2 == 1){
                            if ($j % 3 == 2)
                                echo '<td style = "border-right: solid 4px; 
                                                border-bottom: solid 4px;" >';
                            else echo '<td style = "border-bottom: solid 4px;" >';
                        }
                        else{
                            if($j%3==2)
                                echo '<td style = "border-right: solid 4px;">';
                            else echo '<td>';
                        }
                        

                        $x = $i * 6 + $j;
                        if ($tab[$x] != '0'){
                            if ($tablica[$x] != '0') 
                                echo '<span style = "font-size: 120%"><b>' . $tab[$x] . '</b></span>';
                            else if ( ok($tab, $x))
                                echo ' <span style = "color:blue" "font-size: 150%"  >'.$tab[$x].' </span>';
                            else
                                echo ' <span style = "color:red" "font-size:200%" >'.$tab[$x].'</span>';
                        }
                        else{
                            ?>
                            <input type="text" maxlength="1" size="1" text-align="center" name= <?php echo $x; ?> >
                            <?php
                            $s = "";
                            for ($k = 1; $k <= 6; $k++){
                                $tab[$x] = (string)$k;
                                if (ok($tab, $x))
                                    $s .= (string)$k;
                            }
                            $tab[$x] = '0';
                            echo "<br>";
                            echo '<span style="font-size: 10px;">'.$s.'</span>';
                        }
                    }
                    echo "</tr>";
                }
            ?>
        </table>
    <br><br>
    <input type="radio" name="wra" value="1" id = "1" checked> 
    <label for = "1"> Unesi broj pomoću textboxeva</label>
    <br><br>
    <input type="radio" name="wra" value="2" id = "2">  
        <label for = "2"> Obrisi broj iz retka </label> 
        <select name="redak" id = "redak">
            <option value = "1">1</option>
            <option value = "2">2</option>
            <option value = "3">3</option>
            <option value = "4">4</option>
            <option value = "5">5</option>
            <option value = "6">6</option> </select>
        <label for = "redak"> i stupca </label>
        <select name="stupac" id = "stupac">
            <option value = "1">1</option>
            <option value = "2">2</option>
            <option value = "3">3</option>
            <option value = "4">4</option>
            <option value = "5">5</option>
            <option value = "6">6</option> </select> 
    <br><br> 
    <input type="radio" name="wra" value="3" id = "3"> 
    <label for = "3"> Želim sve ispočetka!</label> 
    <br><br> 
    
    <input type="submit" name = "submit" value = "Izvrši akciju!">
    </form>

    <?php
    if (is_over($tab)){
        echo "<h1>Pobijedili ste!</h1><br>";
        echo "<h3>Za novu igru pritisnite gumb <i>Izvrši akciju!</i></h3>";
        session_unset();
        session_destroy();
    }
    
}
else{
    ?>
    <form action="rokudoku.php" method="post">
    <h1>Rokudoku</h1>
    <br>
    <label for="name">Unesi svoje ime:</label>
    <input type="text" name="name">
    <input type="submit" name="submit" value="Započni igru!">
    <select name="game" id="game">
        <option value="Rokudoku1">Rokudoku1</option>
        <option value="Rokudoku2">Rokudoku2</option>
    </select>
    </form>
    <?php
}
    ?>
</body>
</html>