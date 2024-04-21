<?php
$data = file_get_contents("php://input", "r");
if ($data != "") {
    $mydata = array();
    $mydata = json_decode($data, true);
    if (isset($mydata["ID"]) && isset($mydata["product_photo"]) && ($mydata["ID"] != "") && ($mydata["product_photo"] != "")) {
        $p_ID = $mydata["ID"];
        $p_product_photo = $mydata["product_photo"];

        //  /   根目錄
        //  ./  目前所在目錄
        //  ../ 跳到上一層              
        // require_once '../../conn.php';

        $servername = "localhost";
        $username = "rpc00";
        $password = "123456";
        $dbname = "RelaxPC";

        $conn = mysqli_connect($servername, $username, $password, $dbname);
        if (!$conn) {
            die("連線錯誤!" . mysqli_connect_error());
        }

        // 照片不是空白的  
        $sql = "SELECT product_photo FROM product WHERE ID = '$p_ID' AND product_photo = '$p_product_photo'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row["product_photo"] != "") {
                    $p_folderPath = "/var/www/html/RelaxPC/upload";
                    $filename = $p_folderPath . "/" . $row["product_photo"];
                    if (file_exists($filename))
                        unlink($filename);
                    echo '{"state":true, "message":"刪除產品圖片成功"}';
                }
            }
        } else {
            echo '{"state":false, "message":"刪除產品圖片失敗, 找不到檔案"}';
        }
        mysqli_close($conn);
    } else {
        echo '{"state" : false, "message" : "傳遞參數格式錯誤!"}';
    }
} else {
    echo '{"state":false, "message":"未傳遞任何參數"}';
}
