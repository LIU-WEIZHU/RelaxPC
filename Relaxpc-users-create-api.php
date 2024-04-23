<?php
    //input: {"Username":"XX", "Password":"XXX", "Email":"XXXXX"}
    // {"state" : true, "message" : "註冊成功!"}
    // {"state" : false, "message" : "註冊失敗!"}
    // {"state" : false, "message" : "傳遞參數格式錯誤!"}
    // {"state" : false, "message" : "未傳遞任何參數!"}

    $data = file_get_contents("php://input", "r");
    if($data != ""){
        $mydata = array();
        $mydata = json_decode($data, true);
        if(isset($mydata["username"]) && isset($mydata["userpwd"]) && isset($mydata["useraddr"]) && isset($mydata["userphone"]) && isset($mydata["useremail"]) && $mydata["username"] != "" && $mydata["userpwd"] != "" && $mydata["useraddr"] != "" && $mydata["userphone"] != "" && $mydata["useremail"] != ""){
            $p_Username = $mydata["username"];
            // 密碼加密PASSWORD_DEFAULT
            $p_Password = password_hash($mydata["userpwd"], PASSWORD_DEFAULT);
            $p_Addr = $mydata["useraddr"];
            $p_Phone = $mydata["userphone"];
            $p_Email = $mydata["useremail"];

            $servername = "localhost";
            $username = "rpc00";
            $password = "123456";
            $dbname = "RelaxPC";

            $conn = mysqli_connect($servername, $username, $password, $dbname);
            if(!$conn){
                die("連線失敗".mysqli_connect_error());
            }

            $sql = "INSERT INTO users (`username`, `userpwd`, `useraddr`, `userphone`, `useremail`) VALUES('$p_Username', '$p_Password', '$p_Addr', '$p_Phone', '$p_Email')";
            if(mysqli_query($conn, $sql)){
                //新增成功
                echo '{"state" : true, "message" : "註冊成功!"}';
            }else{
                //新增失敗
                echo '{"state" : false, "message" : "註冊失敗!' .  $sql . mysqli_error($conn) . '"}';
            }
            mysqli_close($conn);
        }else{
            echo '{"state" : false, "message" : "傳遞參數格式錯誤!"}';
        }
    }else{
        echo '{"state" : false, "message" : "未傳遞任何參數!"}';
    }
?>
