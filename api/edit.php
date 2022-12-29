<?php
include_once "base.php";

$table=$_POST['table'];
//先判斷陣列裡的每筆id資料是否帶有del，如果有，進行刪除，如果沒有，進行text更新
foreach($_POST['id'] as $idx=>$id){
    if(isset($_POST['del']) && in_array($id,$_POST['del'])){
        $$table->del($id);
    }else{
        $row=$$table->find($id); //把資料從資料庫裡撈出來

        switch($table){
            case "Title":
                $row['text']=$_POST['text'][$idx]; //更新text到資料庫裡
                $row['sh']=(isset($_POST['sh']) && $_POST['sh']==$id)?1:0;//判斷顯示欄位是否有被點選，有點選1否則0
            break;
            case "Admin":
            break;
            case "Menu":
            break;
            default:
                if(isset($_POST['text'])){ //如果有帶文字text資料更新的，再處理這行
                    $row['text']=$_POST['text'][$idx]; //更新text到資料庫裡
                }
                $row['sh']=(isset($_POST['sh']) && in_array($id,$_POST['sh']))?1:0;//判斷顯示欄位是否有被點選，有點選1否則0
        }
        
        $$table->save($row);//存檔到db

    }
}

to("../back.php?do=".lcfirst($table))
?>