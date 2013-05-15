<?php
function htmlcode($text){
$stvarno = array ("<", ">");
$zamjenjeno = array ("&lt;","&gt;");
$final = str_replace($stvarno, $zamjenjeno, $text);
return $final;
}
function clear($text){
//12-10-26 h0n9t3n 추가
$final = str_replace("\\n","<br>",$text);
$final = stripslashes(stripslashes( $final));//$text->$final로 수정
return $final;
}
?>
