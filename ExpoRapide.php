
<h2 class="titreDansLaFonctions">Exponentiation modulaire rapide</h2>
<form action="ExpoRapide.php" method="post" >
 	<p>
		Entier : <input type="text" name="m"><br>
 		Puissance : <input type="text" name="n"><br>
 		Modulo : <input type="text" name="modulo"><br>
 		<input type='submit' class='boutton' value="Calculer">
 	</p>
 </form>
 
<?php 

function Algo1($m,$n){
	if(  preg_match("#^[0-9]+$#", $m) and preg_match("#^[0-9]+$#", $n)){
		$bin = decbin($n);
		$x=2;
		$taille = strlen($bin);
		$res=$m;
		if($n==0) return 1;
		
		for($i=1;$i<$taille;$i++){
			$res=gmp_pow($res,$x);
			if($bin[$i]==1){
				$res=gmp_mul($res,$m);
			}
		}

		
	}
	else echo "Saisie Incorrecte";
	return $res;
}

function Algo1Mod($m,$n,$modulo){
	if(  preg_match("#^[0-9]+$#", $m) and preg_match("#^[0-9]+$#", $n)){
		$bin = decbin($n);
		$x=2;
		$taille = strlen($bin);
		if($n==0) return 1;
		$res=$m;
		
		for($i=1;$i<$taille;$i++){
			$res=gmp_mod(gmp_pow($res,$x),intval($modulo));
			if($bin[$i]==1){
				$res=gmp_mod(gmp_mul($res,$m),intval($modulo));
			}
		}
		
	}
	else echo "Saisie incorrecte";
	return $res;
}

function Algo2Mod($m,$n,$modulo){
	if(  preg_match("#^[0-9]+$#", $m) and preg_match("#^[0-9]+$#", $n) and preg_match('#^[0-9]+$#', $modulo) ){
		$bin = decbin($n);
		$bin = strrev($bin);
		$taille = strlen($bin);
		$res=1;
		$puissancecons=$m;
		for($i=0;$i<$taille;$i++){
			if($bin[$i]==1){
				$res=gmp_mod(gmp_mul($res,$puissancecons),intval($modulo));
			}
			$puissancecons=gmp_mod(gmp_pow($puissancecons,2),intval($modulo));	
		}
	}			
	else
		echo "Saisie incorrecte";
	return $res;
}


function Algo2($m,$n){
	if(  preg_match("#^[0-9]+$#", $m) and preg_match("#^[0-9]+$#", $n)){
			$bin = decbin($n);
			$bin = strrev($bin);
			$taille = strlen($bin);
			$res=1;
			$puissancecons=$m;
			for($i=0;$i<$taille;$i++){
				if($bin[$i]==1){
					$res=gmp_mul($res,$puissancecons);
				}
				$puissancecons=gmp_pow($puissancecons,2);				
			}
	}
	else
		echo "Saisie incorrecte";
	return $res;
}

function Algo3($m,$n){
	if(  preg_match("#^[0-9]+$#", $m) and preg_match("#^[0-9]+$#", $n)){
		if ($n == 1) {
			return $m;}
		else if ($n%2 == 0){
			return Algo3(gmp_pow($m,2),$n/2);
		}
		else {
			return $m*Algo3(gmp_pow($m,2),($n-1)/2);
		}
	}
}

function Algo3Mod($m,$n,$modulo){
	if(  preg_match("#^[0-9]+$#", $m) and preg_match("#^[0-9]+$#", $n)){
		if ($n == 1) {
			return gmp_mod($m,intval($modulo));}
		else if ($n%2 == 0){
			return gmp_mod(Algo3(gmp_pow($m,2),$n/2),intval($modulo));
		}
		else {
			return gmp_mod($m*Algo3(gmp_pow($m,2),($n-1)/2),intval($modulo));
		}
	}
}


if(isset($_POST['m']) and isset($_POST['n']) and trim($_POST['m'])!='' and trim($_POST['n'])!=''){
	echo "Algorithme 1 sans modulo (Hörner)<br>";
	$timestamp_debut = microtime(true);	
	echo "Résultat : ".Algo1($_POST['m'],$_POST['n'])."<br>";
	$timestamp_fin = microtime(true);
	$difference_ms = $timestamp_fin - $timestamp_debut;
	echo 'Exécution du script : ' . $difference_ms . ' secondes.<br><br>';
	
}

if(isset($_POST['m']) and isset($_POST['n']) and isset($_POST['modulo']) and trim($_POST['m'])!='' and trim($_POST['n'])!='' and trim($_POST['modulo'])!=''){
	echo "Algorithme 1 modulo(Hörner)<br>";
	$timestamp_debut = microtime(true);	
	echo "Résultat : ".Algo1Mod($_POST['m'],$_POST['n'],$_POST['modulo'])."<br>";
	$timestamp_fin = microtime(true);
	$difference_ms = $timestamp_fin - $timestamp_debut;
	echo 'Exécution du script : ' . $difference_ms . ' secondes.<br><br>';
	
}

if(isset($_POST['m']) and isset($_POST['n']) and trim($_POST['m'])!='' and trim($_POST['n'])!=''){
	echo "Algorithme 2 sans modulo (Puissance de deux successives)<br>";
	$timestamp_debut = microtime(true);	
	echo "Résultat : ".Algo2($_POST['m'],$_POST['n'])."<br>";
	$timestamp_fin = microtime(true);
	$difference_ms = $timestamp_fin - $timestamp_debut;
	echo 'Exécution du script : ' . $difference_ms . ' secondes.<br><br>';
}

if(isset($_POST['m']) and isset($_POST['n']) and isset($_POST['modulo']) and trim($_POST['m'])!='' and trim($_POST['n'])!='' and trim($_POST['modulo'])!=''){
		echo "Algorithme 2 modulo (Puissance de deux successives)<br>";
		$timestamp_debut = microtime(true);
		echo "Résultat : ".Algo2Mod($_POST['m'],$_POST['n'],$_POST['modulo'])."<br>";
		$timestamp_fin = microtime(true);
		$difference_ms = $timestamp_fin - $timestamp_debut;
		echo 'Exécution du script : ' . $difference_ms . ' secondes.<br><br>';
}

if(isset($_POST['m']) and isset($_POST['n']) and trim($_POST['m'])!='' and trim($_POST['n'])!=''){
	echo "Algorithme 3 sans modulo (Puissance pair ou impaire recursif)<br>";
	$timestamp_debut = microtime(true);	
	echo "Résultat : ".Algo3($_POST['m'],$_POST['n'])."<br>";
	$timestamp_fin = microtime(true);
	$difference_ms = $timestamp_fin - $timestamp_debut;
	echo 'Exécution du script : ' . $difference_ms . ' secondes.<br><br>';
}	

if(isset($_POST['m']) and isset($_POST['n']) and isset($_POST['modulo']) and trim($_POST['m'])!='' and trim($_POST['n'])!='' and trim($_POST['modulo'])!=''){
		echo "Algorithme 3 modulo (Puissance pair ou impaire recursif)<br>";
		$timestamp_debut = microtime(true);
		echo "Résultat : ".Algo3Mod($_POST['m'],$_POST['n'],$_POST['modulo'])."<br>";
		$timestamp_fin = microtime(true);
		$difference_ms = $timestamp_fin - $timestamp_debut;
		echo 'Exécution du script : ' . $difference_ms . ' secondes.<br><br>';
}
?>