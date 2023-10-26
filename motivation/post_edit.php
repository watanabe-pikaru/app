
<!-- 新規登録ページ -->


<?php   
          
    // hmlentitiesのショートカット関数。適用可能な文字を全て HTML エンティティに変換する。
    function he($str){                    
        return htmlentities($str, ENT_QUOTES, "UTF-8");
    }

    // データベースの変数
    $db_host = "mysql219.phy.lolipop.lan";           
    $db_name = "LAA1562925-motivation";          
    $db_user = "LAA1562925";              
    $db_pass = "root";                               


    //データベース接続
    try {
        $db = new PDO("mysql:host={$db_host};dbname={$db_name};charset=utf8", $db_user, $db_pass);    
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);            
    } catch (PDOException $e) {             
        exit("データベースの接続に失敗しました"); 
    }
            


    // 登録ボタンが押されて、入力欄が空白の場合、エラー表示
    if (isset($_POST['send'])) {
        if ($_POST['post_content'] == ''){
            echo "<div class=message>";     //赤字
            echo "記入欄が空白です。入力してください";
            echo "</div>";
        }
    }
            

    
    // 登録ボタン押されて、入力欄が空欄で無かったなら、データベースにデータ保存
    if (isset($_POST['send']) && $_POST['post_content'] != "" ) {
        try {
            $db->beginTransaction();    // トランザクション開始
                        
                $sql = 'INSERT INTO posts (post_content) VALUES (:post_content)';   // データを登録するSQL（INSERT文）用意
                $data = array(':post_content' => $_POST['post_content']);     // 登録するデータを変数に格納
                $stmt = $db->prepare($sql);  // SQL準備
                $stmt->execute($data);  // SQL実行

            $db->commit();  // トランザクション実行
            
        } catch (PDOException $e) {
            $db->rollBack();   // トランザクション失敗したらキャンセル
            exit("クエリの実行に失敗しました");
            // print_r($stmt -> errorInfo());     //エラー確認用
        }

    // 登録成功
    echo "<div class=message>";
    echo "登録完了しました。";
    echo "</div>";
    // var_dump($_POST["post_content"]);     //確認用
    }
?>



<!DOCTYPE html>                  

  <head>                          
    <meta charset="UTF-8" />      
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />    
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0" />   -->    
    <title>新規登録</title>                                     
    <link rel="stylesheet" href="./style.css">                  
    <link rel="stylesheet" href="sanitize.css">              
  </head>
  
  
  <body>   

        <div class="list">
      
            <h1>新規登録</h1>

            <!-- formタグ内のデータを、action属性で送信先を指定して、post方式で送信 -->
            <form action="post_edit.php" method="post">
                
                <!-- 入力した内容がデータベースに送信され、登録されたらechoで表示-->
                <textarea name="post_content" placeholder="入力して登録ボタンを押してください。" ><?php echo he($_POST["post_content"]); ?></textarea>
                

                <!-- formの中身を送信。 -->
                <!-- 送信されたデータは、$_POST という連想配列（スーパーグローバル変数）に格納。 -->
                <input type="submit" name="send" value="登録" class="submit_btn">
                
            </form>

            <hr>
            <a href="index.php" class="a">トップへ戻る</a>

        </div>

  </body>

</html>



