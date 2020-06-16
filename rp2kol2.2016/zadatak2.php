<?php 

// .. Npr. $vlakovi[1]["cilj"] je "Osijek".

$vlakovi = array
(
	array( "start" => "Zagreb", "cilj" => "Split",  "polazak" => "8h",  "cijena" => 150 ),
	array( "start" => "Zagreb", "cilj" => "Osijek", "polazak" => "12h", "cijena" => 100 ),
	array( "start" => "Osijek", "cilj" => "Rijeka", "polazak" => "10h", "cijena" => 200 ),
	array( "start" => "Rijeka", "cilj" => "Zagreb", "polazak" => "21h", "cijena" => 120 ),
	array( "start" => "Zagreb", "cilj" => "Split",  "polazak" => "15h", "cijena" => 140 ),
	array( "start" => "Split",  "cilj" => "Zagreb", "polazak" => "11h", "cijena" => 150 ),
	array( "start" => "Zagreb", "cilj" => "Split",  "polazak" => "5h",  "cijena" => 120 ),
	array( "start" => "Osijek", "cilj" => "Rijeka", "polazak" => "20h", "cijena" => 220 ),
	array( "start" => "Split",  "cilj" => "Osijek", "polazak" => "14h", "cijena" => 250 ),
);

if (isset($_GET['polaz']) && !isset($_GET['cilj'])){
	$x = $_GET['polaz'];
	$gradovi = array();
	foreach($vlakovi as $vlak){
		if ($vlak['start'] === $_GET['polaz'] && !in_array($vlak['cilj'], $gradovi)){
			echo '<button class = "cilj" value="'.$vlak['cilj'].'">'.$vlak['cilj'].'</button>';
			array_push($gradovi, $vlak['cilj']);
		}
	}
}
if (isset($_GET['cilj']) && !isset($_GET['time'])){
	$x = $_GET['polaz'];
	$y = $_GET['cilj'];
	foreach($vlakovi as $vlak){
		if ($vlak['start'] === $x && $vlak['cilj'] === $y){
			echo '<button class = "time" value="'.$vlak['polazak'].'">'.$vlak['polazak'].'<br>'.$vlak['cijena'].'</button>';
		}
	}
}
if (isset($_GET['polaz']) && isset($_GET['cilj']) && isset($_GET['time'])){
	foreach ($vlakovi as $vlak ){
		if ($vlak['start'] === $_GET['polaz'] &&
			$vlak['cilj'] === $_GET['cilj'] &&
			$vlak['polazak'] === $_GET['time']) echo $vlak['cijena'];
	}
}
?>