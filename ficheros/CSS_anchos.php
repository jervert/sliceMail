<?
header('Content-type: text/css');

$i=20; while ($i<461) {
	echo ".ancho_".$i." {width:".($i/12)."em;}\n";
	$i++;
}
?>