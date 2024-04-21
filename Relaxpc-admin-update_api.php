<?php
//input: {"ID":"1","Pname":"奶茶", "Price":"50"}
// output:
// {"state" : true, "message" : "更新成功!"}
// {"state" : false, "message" : "更新失敗!"}
// {"state" : false, "message" : "傳遞參數格式錯誤!"}
// {"state" : false, "message" : "未傳遞任何參數!"}
$data = file_get_contents("php://input", "r");
if ($data != "") {
    $mydata = array();
    $mydata = json_decode($data, true);
    if (isset($mydata["ID"]) && isset($mydata["product_name"]) && isset($mydata["product_number"]) && isset($mydata["product_amount"]) && isset($mydata["product_photo"]) && isset($mydata["product_type"]) && isset($mydata["product_remark"]) &&  $mydata["ID"] != "" && $mydata["product_name"] != "" && $mydata["product_number"] != "" && $mydata["product_amount"] != "" && $mydata["product_photo"] != "" && $mydata["product_type"] != "" && $mydata["product_remark"] != "") {
        // 依據ID當作指標，來修改欄位
        $ID = $mydata["ID"];
        $product_name = $mydata["product_name"];
        $product_number = $mydata["product_number"];
        $product_amount = $mydata["product_amount"];
        $product_photo = $mydata["product_photo"];
        $product_type = $mydata["product_type"];
        $product_remark = $mydata["product_remark"];

        $servername = "localhost";
        $username = "rpc00";
        $password = "123456";
        $dbname = "RelaxPC";

        $conn = mysqli_connect($servername, $username, $password, $dbname);
        if (!$conn) {
            die("連線失敗" . mysqli_connect_error());
        }

        $sql = "UPDATE product SET product_name = '$product_name', product_number = '$product_number', product_amount = '$product_amount', product_photo = '$product_photo', product_type = '$product_type', product_remark = '$product_remark' WHERE ID = '$ID'";
        if (mysqli_query($conn, $sql)) {
            //更新成功
            echo '{"state" : true, "message" : "更新成功!"}';
        } else {
            //更新失敗
            echo '{"state" : false, "message" : "更新失敗!"}';
        }
        mysqli_close($conn);
    } else {
        echo '{"state" : false, "message" : "傳遞參數格式錯誤!"}';
    }
} else {
    echo '{"state" : false, "message" : "未傳遞任何參數!"}';
}
