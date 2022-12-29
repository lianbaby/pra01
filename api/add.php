<?php
include "base.php";
$table=$_POST['table'];
$data=[]; //因為不知道進來的table會是什麼型態，所以先給予一個空陣列

if(!empty($_FILES['img']['tmp_name'])){
    move_uploaded_file($_FILES['img']['tmp_name'],"../upload/".$_FILES['img']['name']);
    $data['img']=$_FILES['img']['name'];
}
switch($table){
    case "admin":
    break;
    case "menu":
    break;
    default:
    if(isset($_POST['text'])){  //判斷是否有text
        $data['text']=$_POST['text'];
    }
    $data['sh']=($table=="Title")?0:1; //三元運算式，如果顯示欄位是Title的預設為0不顯示，其他為1顯示
}
$$table->save($data);
to('../back.php?do='.lcfirst($table));


?>