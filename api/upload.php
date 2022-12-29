<?php
include_once "base.php";
$table=$_POST['table'];
$row=$$table->find($_POST['id']);
if(!empty($_FILES['img']['tmp_name'])){ //如果上傳檔案不為空
    move_uploaded_file($_FILES['img']['tmp_name'],'../upload/'.$_FILES['img']['name']);//將檔案移到upload
    $row['img']=$_FILES['img']['name'];//原本資料庫圖片變成新得到的圖片
    $$table->save($row);//存檔
}
to("../back.php?do=".lcfirst($table));
?>