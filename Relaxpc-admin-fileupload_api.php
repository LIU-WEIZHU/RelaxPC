<?php
// 如果輸入檔案名字存在或是檔案名稱不為空白時
if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != "") {
    if ($_FILES['file']['type'] == "image/png" || $_FILES['file']['type'] == "image/jpeg") {
        // 重新命名檔案傳遞至伺服器
        $myfile = date("YmdHis") . '_' . uniqid() . '_' . $_FILES['file']['name'];
        $filename = 'upload/' . $myfile;
        if (move_uploaded_file($_FILES['file']['tmp_name'], $filename)) {
            $datainfo = array();
            $datainfo["name"] = $_FILES['file']['name'];
            $datainfo["type"] = $_FILES['file']['type'];
            $datainfo["size"] = $_FILES['file']['size'];
            $datainfo["tmp_name"] = $_FILES['file']['tmp_name'];
            $datainfo["error"] = $_FILES['file']['error'];
            $datainfo["serverfilename"] = $myfile;

            echo '{"state" : true, "datainfo" : ' . json_encode($datainfo) . ' ,"message" : "檔案上傳成功!!"}';
        } else {
            $errorinfo = array();
            $errorinfo["error"] = $_FILES['file']['error'];

            echo '{"state" : false, "error_info" : ' . json_encode($errorinfo) . ' ,"message" : "檔案上傳失敗!!"}';
        }
    } else {
        echo '{"state" : false, "message" : "檔案格式錯誤, 必須為jepg or png!"}';
    }
} else {
    echo '{"state" : false, "message" : "檔案不存在!"}';
}
