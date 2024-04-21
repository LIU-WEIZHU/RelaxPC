<?php
// ini_set('display_errors','1');
// error_reporting(E_ALL);
//input: {"product_name":"商品", "product_number":1, "product_amount":1000, "product_photo":"img.png", "product_type":"顯示卡", "product_remark":"介紹"}

$data = file_get_contents("php://input", "r");
if ($data != "") {
    $mydata = array();
    $mydata = json_decode($data, true);
    if (isset($mydata["product_name"]) && isset($mydata["product_number"]) && isset($mydata["product_amount"]) && isset($mydata["product_photo"]) && isset($mydata["product_type"]) && isset($mydata["product_remark"]) && $mydata["product_name"] != "" && $mydata["product_number"] != "" && $mydata["product_amount"] != "" && $mydata["product_photo"] != "" && $mydata["product_type"] != "" && $mydata["product_remark"] != ""
    ) {
        $name = $mydata["product_name"];
        $number = $mydata["product_number"];
        $amount = $mydata["product_amount"];
        $photo = $mydata["product_photo"];
        $type = $mydata["product_type"];
        $remark = $mydata["product_remark"];


        $servername = "localhost";
        $username = "rpc00";
        $password = "123456";
        $dbname = "RelaxPC";

        $conn = mysqli_connect($servername, $username, $password, $dbname);
        if (!$conn) {
            die("連線失敗" . mysqli_connect_error());
        }

        // 使用 insert into 後面要括號 mysql專用標籤``，用於欄位或是資料表，''用於字串 
        $sql = "INSERT INTO product(`product_name`, `product_number`, `product_amount`, `product_photo`, `product_type`, `product_remark`) VALUES ('$name', $number, $amount, '$photo', '$type', '$remark')";

        if(mysqli_query($conn, $sql)){
            //新增成功
            echo '{"state" : true, "message" : "新增成功!"}';
        }else{
            //新增失敗
            echo '{"state" : false, "message" : "新增失敗!"'.$sql.'}';
        }
        mysqli_close($conn);
    }else{
        echo '{"state" : false, "message" : "傳遞參數格式錯誤!"}';
    }
}else{
    echo '{"state" : false, "message" : "未傳遞任何參數!"}';
}
