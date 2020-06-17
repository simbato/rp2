<?php 

// Npr. $memory["PRVA"][0][2] je "B"
$memory = array
(
    "PRVA" => array( "AABB", 
                     "DDEE",
                     "GGHH",
                     "MMNN" ),

    "DRUGA" => array( "LCIAFDZ", 
                      "HKBEQHW",
                      "ENQDKGX",
                      "MAPJCMZ",
                      "JRNGLOX",
                      "PFIOBRW" ),

    "TRECA" => array( "ACEB", 
                      "HDCF",
                      "GAHE",
                      "DFGB" )
);

if (isset($_GET['igra']) && !isset($_GET['row'])){
    $rows = count($memory[$_GET['igra']]);
    $cols = strlen($memory[$_GET['igra']][1]);
    echo $rows . ',' . $cols;
}

if (isset($_GET['igra']) && isset($_GET['row']) && isset($_GET['col']))
    $slovo = $memory[$_GET['igra']][$_GET['row']][$_GET['col']];
    echo $slovo;
?>
