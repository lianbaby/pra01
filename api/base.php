<?php
session_start();
date_default_timezone_set("Asia/Taipei"); //設置正確的時區

class DB{
    protected $dsn="mysql:host=localhost;charset=utf8;dbname=db11"; //權限db設定
    protected $table;
    protected $pdo;

    public function __construct($table)
    {
        $this->table=$table;
        $this->pdo=new PDO($this->dsn,'root',''); //連db的帳密
    }

    public function find($id){  //尋找function
        $sql="select * from $this->table "; //記得table後要空格

        if(is_array($id)){
            $tmp=$this->arrayToSqlArray($id); //使用下面預先寫好的private的function
            $sql=$sql . " where " . join(" && ",$tmp);
        }else{
            $sql=$sql . "where `id`='$id'";
        }

        return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC); //因為是查詢，回傳單筆資料

    }
    public function all(...$arg){
        $sql="select * from $this->table ";
        if(isset($arg[0])){  //判斷是否有值
            if(is_array($arg[0])){
                $tmp=$this->arrayToSqlArray($arg[0]);//使用下面預先寫好的private的function,()裡內容記得換成相對應的
                $sql=$sql . " where " . join(" && ",$tmp);
            }else{
                $sql= $sql . $arg[0];
            }
        }
        if(isset($arg[1])){
            $sql= $sql . $arg[1];
        }
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);//多筆資料
    }

    public function save($array){
        if(isset($array['id'])){ //如果有id，進行更新
            $id=$array['id'];
            unset($array['id']);//把id拿掉，因為不用更新id，只是用id進行查詢更新
            $tmp=$this->arrayToSqlArray($array);
            $sql="update $this->table set ".join(",",$tmp)." where `id`='$id'";

        }else{  //如果沒有id，就是新增
            $cols=array_keys($array);
            $sql="insert into $this->table (`".join("`,`",$cols)."`) values('".join("','",$array)."')"; 
        }
        $this->pdo->exec($sql); //執行
    }

    public function del($id){
        $sql="delete from $this->table "; //記得table後要空格

        if(is_array($id)){
            $tmp=$this->arrayToSqlArray($id); //使用下面預先寫好的private的function
            $sql=$sql . " where " . join(" && ",$tmp);
        }else{
            $sql=$sql . "where `id`='$id'";
        }

        return $this->pdo->exec($sql); //拿find資料來改，sql前面語法變delete，此行變成exec執行，而非query查詢
    }
    
    public function count(...$arg){
        return $this->math('count',...$arg);
    }
    
    public function sum($col,...$arg){ //...arg不定參數
        return $this->math('sum',$col,...$arg); //...arg為解構賦值
    }

    public function max($col,...$arg){
        return $this->math('max',$col,...$arg);
    }
    
    public function min($col,...$arg){
        return $this->math('min',$col,...$arg);

    }
    public function avg($col,...$arg){
        return $this->math('avg',$col,...$arg);

    }

    private function arrayToSqlArray($array){  //用於其他function內部簡化用
        foreach($array as $key => $value){
            $tmp[]="`$key`='$value'";
        }
        return $tmp;
    }

    private function math($math,...$arg){
        switch($math){
            case 'count':
                $sql="select count(*) from $this->table ";
                if(isset($arg[0])) $con=$arg[0];
            break;
            default:
                $col=$arg[0];
                if(isset($arg[1])){
                    $con=$arg[1];
                }
                    $sql="select $math($col) from $this->table ";
        }
        if(isset($con)){
            if(is_array($con)){
                $tmp=$this->arrayToSqlArray($con);
                $sql=$sql . " where " .  join(" && ",$tmp);
            }else{
                $sql=$sql . $con;
            }
        } 
        return $this->pdo->query($sql)->fetchColumn();
    }
}

//全域變數萬用function ，dd用來測試
function dd($array){
echo "<pre>";
print_r($array);
echo "</pre>";
}

function to($url){
    header("location:".$url);
}

function q($sql){
    $dsn="mysql:host=localhost;charset=utf8;dbname=db11";
    $pdo=new PDO($dsn,'root','');
    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

$Bottom=new DB('bottom'); //方便各個頁面引用
$Title=new DB('title');
$Ad=new DB('ad');

//測試功能是否正常
// $db=new DB('bottom');
//$bot=$db->del(3); //測試del功能
//$bot=$db->all();
//print_r($bot);
//$db->save(['bottom'=>"2022頁尾版權"]); //新增
////$bot=$db->all(); //印出所有陣列
//print_r($bot);

// $row=$db->find(1);//先找到id "1"
// $row['bottom']="2023版權所有";//改寫資料
// $db->save($row);//進行save功能，因帶有id資料，所以判斷為更新

//解構
//$array=['a'=>'b','c'=>'d'];
//extract($array);
//echo $a //會輸出b


//php結尾，如果確定該檔案不顯示在html裡，不一定需要有