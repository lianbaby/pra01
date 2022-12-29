<?php
//ad複製title的去改就好
include_once "base.php";

//先判斷陣列裡的每筆id資料是否帶有del，如果有，進行刪除，如果沒有，進行text更新
foreach($_POST['id'] as $idx=>$id){
    if(isset($_POST['del']) && in_array($id,$_POST['del'])){
        $Ad->del($id);
    }else{
        $row=$Ad->find($id); //把資料從資料庫裡撈出來
        $row['text']=$_POST['text'][$idx]; //更新text到資料庫裡
        $row['sh']=(isset($_POST['sh']) && in_array($id,$_POST['sh']))?1:0;//判斷顯示欄位是否有被點選，有點選1否則0
        $Ad->save($row);//存檔到db

    }
}

to("../back.php?do=ad")
?>