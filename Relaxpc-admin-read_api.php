<?php
// ini_set('display_errors','1');
// error_reporting(E_ALL);
//input: {"page":1, "perpage":10}

$data = file_get_contents("php://input", "r");
if ($data != "") {
    $mydata = array();
    $mydata = json_decode($data, true);
    $type = $mydata["type"];
//     if (isset($mydata["page"]) && isset($mydata["perpage"])) {
//         $page = ($mydata["page"]-1)*$mydata["perpage"];
//         $perpage = $mydata["perpage"];


//         $servername = "localhost";
//         $username = "rpc00";
//         $password = "123456";
//         $dbname = "RelaxPC";

//         $conn = mysqli_connect($servername, $username, $password, $dbname);
//         if (!$conn) {
//             die("連線失敗" . mysqli_connect_error());
//         }

//         // limit ($page-1)*$perpage, $perpage" => limit 0, 10從第0筆抓10筆
//         /* 
//         假設一頁10筆
//         limit 0, 10
//         第二頁
//         limit  10, 10
//         第三頁
//         limit 20, 10
//         */

//         // mysql專用標籤``，用於欄位或是資料表
//         $sql = "SELECT `product_name`, `product_number`, `product_amount`, `product_photo`, `product_type`, `product_remark`, `Create_at` FROM product order by product_name asc limit $page, $perpage";



//         $result = mysqli_query($conn, $sql);

//         $sql = "SELECT product.*, product_layer.* FROM product JOIN product_layer ON product_type = LayerName";
//             //驗證成功
//             //定義mydata為陣列
//             $mydata = array();
//             // 對$參數跑迴圈
//             while ($row = mysqli_fetch_assoc($result)) {
//                 $mydata[] = $row;
//             }

//             echo '{"state" : true, "data": ' . json_encode($mydata) . ', "message" : "驗證成功, 可以登入!"}';

//         mysqli_close($conn);
//     } else {
//         echo '{"state" : false, "message" : "傳遞參數格式錯誤!"}';
//     }
// } else {
//     echo '{"state" : false, "message" : "未傳遞任何參數!"}';
// }


$servername = "localhost";
$username = "rpc00";
$password = "123456";
$dbname = "RelaxPC";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("連線失敗!" . mysqli_connect_error());
}
$sql = "SELECT product.*, product_layer.LayerName FROM product JOIN product_layer ON product_type = product_layer.ID WHERE product_type = $type";
$result = mysqli_query($conn, $sql);

$mydata = array();
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $mydata[] = $row;
    }
    echo '{"state" : true, "data" : ' . json_encode($mydata) . ' ,"message" : "查詢資料成功"}';
} else {
    echo '{"state" : false, "message" : "查詢資料失敗，查無資料"}';
}
mysqli_close($conn);

}