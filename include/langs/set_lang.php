<?php

if(is_file('path.php')){
    $path = "";
}elseif (is_file('../path.php')){
    $path =  "../";
}elseif (is_file('../../path.php')){
    $path =  "../../";
}elseif (is_file('../../../path.php')){
    $path =  "../../../";
}elseif (is_file('../../../../path.php')){
    $path =  "../../../../";
}

if($_SESSION['language']){
	$_SESSION['language'] = 'English';
}else{
	$_SESSION['language'] = 'English';
}

switch ($_SESSION['language']) {
case 'English':
	include_once $path."include/langs/english.php";
	break;
case 'العربية':
	include_once $path."include/langs/arabic.php";
	break;
default:
	$_SESSION['language'] = "English";
	include_once $path."include/langs/english.php";
	break;
}

?>
