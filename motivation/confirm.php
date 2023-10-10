<?php
    if (isset($_GET['post_id'])) {
        try {
 
            // 接続処理
                $db_host = "localhost";           // データベースのホスト名
                $db_name = "motivation";          // データベースの名前
                $db_user = "root";                // データベース接続ユーザー
                $db_pass = "root";                // データベース接続パスワード

                try {
                        $db = new PDO("mysql:host={$db_host};dbname={$db_name};charset=utf8", $db_user, $db_user);     // // PDOインスタンスを生成
                        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // エラーモードの設定
                        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // エミュレーションを停止。
                    } catch (PDOException $e) {
                        exit("データベースの接続に失敗しました"); 
                }

            // SELECT文を発行
            $sql = "SELECT * FROM posts WHERE post_id = :id";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':id', $_GET['post_id'], PDO::PARAM_INT);
            $stmt->execute();
            $member = $stmt->fetch(PDO::FETCH_OBJ); // 1件のレコードを取得    
 
            
 
        } catch (PDOException $e) {
            // エラー発生時  
            $db->rollBack();
            exit("クエリの実行に失敗しました");
        }
 
    }
?>

<!DOCTYPE html>

<head>                          
    <meta charset="UTF-8" />      
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />     <!-- IE(Internet Explorer)を最新バージョンで動かさせるためのコードです。 --> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />     <!-- 「width=”device-width」は使用端末の横幅にページの横の長さを合わせるという意味です。また、「initial-scale=”1.0″」は初めにページが非表示されるとき、画面の倍率が1倍(つまりズームなし)という意味です。 -->
    <title>削除確認</title>                                     <!-- タイトルは検索結果と、ブラウザのタブの上部に表示されます。 -->
    <link rel="stylesheet" href="./style.css">                  <!-- このコードにより、別に用意してあるCSSファイルを読み込むことができます。 -->
    <link rel="stylesheet" href="sanitize.css">                 <!-- ブラウザデフォルトのCSSの違いを統一して、見た目を整える -->
</head>

<body>
    
    <div class="list">
      
     <h1>削除確認</h1>
    
     <p>以下のデータを削除しますか？</p>
    
     <table>
        <tr>
            <td><?php print($member->post_content) ?></td>
        </tr>
     </table>

     <a href="delete.php?id=<?php print($member->post_id)?>">削除する</a><br>
    
     <a href="index.php" class="a">トップへ戻る</a>

    </div>

</body>
</html>