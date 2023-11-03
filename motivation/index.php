
<!-- トップページ -->



<?php

  // hmlentitiesのショートカット関数。適用可能な文字を全て HTML エンティティに変換する。
  function he($str){                    
    return htmlentities($str, ENT_QUOTES, "UTF-8");
  }


  // データベースの変数
  $db_host = "mysql219.phy.lolipop.lan";           
  $db_name = "LAA1562925-motivation";          
  $db_user = "LAA1562925";              
  $db_pass = "root1";              


  // データベース接続
  try {
    $db = new PDO("mysql:host={$db_host};dbname={$db_name};charset=utf8",$db_user,$db_user);   
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // エラーモードの設定
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // エミュレーションを停止。
  } catch (PDOException $e) {         
    print('Error:'.$e->getMessage());    
     exit("データベースの接続に失敗しました"); 
  }


    
  // array関数で配列を作成。配列の初期化。
  $rows_post = array(); 
    
  // データの問い合わせ
  // $stmtに$dbからデータを抽出して、$rows_postに格納。
  try {
    $stmt = $db->prepare("SELECT * FROM posts ORDER BY post_id ASC");  
    $stmt->execute(); 
    $rows_post = $stmt->fetchAll();      // SELECT結果を二次元配列に格納
  } catch (PDOException $e) {
      exit("クエリの実行に失敗しました");
  }
  
?>



<!DOCTYPE html>                   
  
  <head>                          
    <meta charset="UTF-8" />      
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />     
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0" />   -->  
    <title>自作アプリ</title>                              
    <link rel="stylesheet" href="./style.css">                  
    <link rel="stylesheet" href="sanitize.css">                
  </head>
  
  
  <body>                          
    
    <!-- タイトルここからーーーーーーーーーーーーーーーーーーーーーーーーーーーーー -->
    <div class="title">
      <h1>燃えろ！あひる組</h1>
      <p>
        みんなにだって力はある。誰だってパワーを持ってる。<br>
        見た目じゃ分かんねえ。どんな凄え力が潜んでるか分からねえ。<br>
        それを「可能性」って言うんだ。<br>
      </p>
    </div>
    <!-- タイトルここまでーーーーーーーーーーーーーーーーーーーーーーーーーーーーー -->



    <!-- 今日のやる気が出る言葉ここからーーーーーーーーーーーーーーーーーーーーーーーー -->
    <div class="random">
      <h1>スイッチを押すとランダムで表示が変わります。</h1>
      <p id="result"></p>     <!-- ランダム結果 -->
      <button id="random_btn">やる気スイッチ</button>    
    </div>
    <!-- 今日のやる気が出る言葉ここまでーーーーーーーーーーーーーーーーーーーーーーーー -->



    <!-- がんばりノートここからーーーーーーーーーーーーーーーーーーーーーーーーーーーー -->
    <div class="list">
      
      <h1>メモ一覧</h1>

      <!-- データをテーブルで繰り返し処理を使い表示 --> 
      <?php if ($rows_post) { ?>
        <table border="1" width="100%"> 
          <?php foreach ($rows_post as $row_post) {; ?>
            <tr>
              <td class="note" width="90%"><?php echo nl2br(he($row_post["post_content"]));?></td>
              <td><a href="confirm.php?id=<?php print($row_post['post_id']) ?>">削除</a></td>   <!-- confirm.phpページにデータ配列番号を?idに渡す。飛ぶページのGETに使う。 -->
            </tr>
          <?php } ?>
        </table>
      <?php } ?>
      

      <hr>
      <a href="post_edit.php" id="btn">新規登録</a>
      
    </div>
    <!-- がんばりノートここまでーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーーー -->


    <!-- 外部JavaScriptファイル読み込み -->
    <script src="random.js"></script>     
  
  </body>

</html>


