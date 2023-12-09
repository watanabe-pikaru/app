
<!-- 削除確認ページ -->


<?php
    if (isset($_GET['id'])) {     // index.phpから削除したいテーブルのidを受信。
        try {
 
            // 接続処理
            $db_host = "localhost";           
            $db_name = "motivation";          
            $db_user = "root";                
            $db_pass = "root";                

            try {
                    $db = new PDO("mysql:host={$db_host};dbname={$db_name};charset=utf8", $db_user, $db_user);     
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />     
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



<!-- もめもめ -->

<!--
解説　$_GETについて
$_GETはスーパーグロバル変数で、URLパラメータを受信できる。
-->


<!--
解説　SELECT文について
SQLの中のDML(Data Manipulation Language:データ操作言語)には、
SELECT(抽出)・INSERT(挿入)・UPDATE(更新)・DELETE(削除)がありますが、
その中のSELECT文について説明します。
SELECT文は、テーブルからデータを抽出するときに使います。
とあるテーブル(データの集合体)からどのような条件でデータを抽出してほしいのかを表した命令文です。
-->


<!--
解説　プレースホルダについて
プレースホルダは「SQLインジェクション対策」のために使う。
SQL文の中で「変動する箇所」には必ずプレースホルダを使う。
-->


<!--
解説　今回のメインPHPについて
idの値を直接は書かずに、プリペアドステートメントで「:id」というプレースホルダーを記述しておきます。
bindParamメソッドを使ってプレースホルダーに変数$idの値を設定します。
bindParamメソッドの第3パラメータで指定している「PDO::PARAM_INT」はPDOがあらかじめ用意している定数で、セットする値の型によって使い分けます。
もしセットする値が文字列なら「PDO::PARAM_STR」を使いますが、今回のidカラムのような数値であれば「PDO::PARAM_INT」を指定します。
プリペアドステートメントを実行します。
変数$stmtには取得したデータではなく、クエリ自体が正常に実行されたかが論理値で入ります。
-->


