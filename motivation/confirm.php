
<!-- 削除確認ページ -->


<?php
    if (isset($_GET['id'])) {     // index.phpから削除したいテーブルのidを受信。
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


            // SELECT文でデータを抽出。
            // idの値を直接は書かずに、プリペアドステートメントで「:id」というプレースホルダーを記述。
            $sql = "SELECT * FROM posts WHERE post_id = :id";  
            $stmt = $db->prepare($sql);

            // bindParamメソッドを使ってプレースホルダーに変数$idの値を設定。
            $stmt->bindValue(':id', $_GET['id'], PDO::PARAM_INT);     
            
            
            // プリペアドステートメントを実行します。
            $stmt->execute();     

            // fetchメソッドを使い、データを配列形式で取得
            $data = $stmt->fetch(PDO::FETCH_OBJ);    
 
            
 
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
    <title>削除確認</title>                                     
    <link rel="stylesheet" href="./style.css">                  
    <link rel="stylesheet" href="sanitize.css">                 
</head>

<body>
    
    <div class="list">
      
     <h1>削除確認</h1>
    
     <p class=message>以下のデータを削除しますか？</p>
    
     <table>
        <tr>
            <td><?php print($data->post_content) ?></td>
        </tr>
     </table>

     <br>
     <br>
     <a href="delete.php?id=<?php print($data->post_id)?>" id="btn">削除</a>   
     <br>
    
     <hr>
     <a href="index.php" class="a">トップへ戻る</a>

    </div>

</body>

</html>

