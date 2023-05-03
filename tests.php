<?php


$my_str = 'Mustafa: "5423740089925829" "06/2023-440"';
$out = preg_replace("/\D+/", "", $my_str);

$cc = substr($out, 0, 16);
$cc_m = substr($out, 16, 2);
$cc_d = substr($out, 18, 4);
$pvc = substr($out, 22, 4);
echo "FULL: $my_str<br>ONLY NUMBERS: $out<br>CC NUMBER: $cc<br>EXPIRE DATE: $cc_m/$cc_d<br>PVC: $pvc";
