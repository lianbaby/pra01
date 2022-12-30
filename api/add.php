<?php
include "base.php";
$table=$_POST['table'];
$data=[]; //因為不知道進來的table會是什麼型態，所以先給予一個空陣列

if(!empty($_FILES['img']['tmp_name'])){
    move_uploaded_file($_FILES['img']['tmp_name'],"../upload/".$_FILES['img']['name']);
    $data['img']=$_FILES['img']['name'];
}
switch($table){
    case "Admin":
        $data['acc']=$_POST['acc'];
        $data['pw']=$_POST['pw'];
    break;
    case "Menu":
        $data['name']=$_POST['name'];
        $data['href']=$_POST['href'];
        $data['sh']=1;//預設顯示
        $data['parent']=0;//0為主選單，帶有id的為次選單
    break;
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