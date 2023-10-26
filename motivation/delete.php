
 <!-- 削除ページ -->


<?php
    if (isset($_GET['id'])) {
        try {
 
            // 接続処理
            $db_host = "mysql219.phy.lolipop.lan";           
            $db_name = "LAA1562925-motivation";          
            $db_user = "LAA1562925";              
            $db_pass = "root";             

            try {
                    $db = new PDO("mysql:host={$db_host};dbname={$db_name};charset=utf8", $db_user, $db_pass);    
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
                    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 
            } 
            catch (PDOException $e) {
                    exit("データベースの接続に失敗しました"); 
            }

 
            // DELETE文を発行
            $id = $_GET['id']; // DELETEするレコードのID
 
            $sql = "DELETE FROM posts WHERE post_id = :id";
            $stmt = $db->prepare($sql);
 
            $stmt->bindValue(":id", $id); // 削除したいIDでバインド
            $stmt->execute(); // DELETE文実行
 
            // 接続切断
            $db = null;

        } catch (PDOException $e) {
            exit("クエリの実行に失敗しました");
        }
    }
?>


<!DOCTYPE html>

<head>                          
    <meta charset="UTF-8" />      
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />  
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0" />   -->   
    <title>削除</title>                                     
    <link rel="stylesheet" href="./style.css">             
    <link rel="stylesheet" href="sanitize.css">                 
</head>

<body>
    
    <div class="list"> 
      
     <h1>削除</h1>

     <p class=message>削除が完了しました。</p>

     <hr>
     <a href="index.php" class="a">トップへ戻る</a>

    </div>

</body>

</html>



