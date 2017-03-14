
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
		for($i=0;$i<$taille-1;$i++){
			if($i==0 and $bin[$i+1]==1){
				$res=gmp_pow($m,$x+1);
			}
			else{
				$res=gmp_pow($res,$x);
				if($bin[$i+1]==1){
					$res=gmp_mul($res,$m);
				}
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
		$res=$m;
		for($i=0;$i<$taille-1;$i++){
			if($i==0 and $bin[$i+1]==1){
				$res=gmp_mod(gmp_pow($m,$x+1),intval($modulo));
			}
			else{
				$res=gmp_mod(gmp_pow($res,$x),intval($modulo));
				if($bin[$i+1]==1){
					$res=gmp_mod(gmp_mul($res,$m),intval($modulo));
				}
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
				if($i==0) $res= $puissancecons;
				else $res=gmp_mod(gmp_mul($res,$puissancecons),intval($modulo));
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
					if($i==0) $res=$puissancecons;
					else $res=gmp_mul($res,$puissancecons);
				}
				$puissancecons=gmp_pow($puissancecons,2);				
			}
	}
	else
		echo "Saisie incorrecte";
	return $res;
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
	
?>