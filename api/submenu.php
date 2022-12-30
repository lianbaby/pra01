<?php include_once "base.php";

foreach($_POST['id'] as $idx => $id){ //編輯次選單內容
    if(isset($_POST['del']) && in_array($id,$_POST['del'])){
        $Menu->del($id);
    }else{
        $row=$Menu->find($id);
        $row['name']=$_POST['name'][$idx];
        $row['href']=$_POST['href'][$idx];
        $Menu->save($row);
    }
}

if(isset($_POST['add_name'])){ //有沒有addname這個欄位
    foreach($_POST['add_name'] as $idx => $name){
        if(!empty($name)){
            $Menu->save([
                    'name'=>$name,
                    'href'=>$_POST['add_href'][$idx],
                    'parent'=>$_POST['parent'],
                    'sh'=>1,
            ]);
        }
    }
}

to("../back.php?do=menu");
?>