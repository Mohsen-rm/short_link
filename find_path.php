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
?>