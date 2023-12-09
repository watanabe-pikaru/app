
<!-- トップページ -->



<?php

  // hmlentitiesのショートカット関数。適用可能な文字を全て HTML エンティティに変換する。
  function he($str){                    
    return htmlentities($str, ENT_QUOTES, "UTF-8");
  }


  // データベースの変数
  $db_host = "localhost";           
  $db_name = "motivation";          
  $db_user = "root";              
  $db_pass = "root";              


  // データベース接続
  try {
    $db = new PDO("mysql:host={$db_host};dbname={$db_name};charset=utf8", $db_user, $db_user);   
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // エラーモードの設定
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // エミュレーションを停止。
  } catch (PDOException $e) {             
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />    
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
      <h1>今日の「やる気が出る言葉」</h1>
      <p id="result"></p>     <!-- ランダム結果 -->
      <button id="random_btn">やる気スイッチ</button>    
    </div>
    <!-- 今日のやる気が出る言葉ここまでーーーーーーーーーーーーーーーーーーーーーーーー -->



    <!-- がんばりノートここからーーーーーーーーーーーーーーーーーーーーーーーーーーーー -->
    <div class="list">
      
      <h1>がんばりノート</h1>

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


<!-- めもめも -->

<!-- 
解説　　<!DOCTYPE html>について
DOCTYPEは、「Document Type」の略で、「ドキュメントの型」という意味です。
ここでは、文書がHTMLの型であることを宣言しています。 
-->


<!-- 
解説　headについて
headタグで囲まれたところ(head要素)にHTMLの文書の情報を書いていきます。 
-->


<!-- 
解説　　charset="UTF-8"について
文字コードを指定しています。
推奨されている文字コード「UTF-8」を指定しましょう。
UTF-8以外だとブラウザに表示されたとき文字化けを起こす可能性があります。 -->


 <!-- 
解説　　幅自動設定について
「width=”device-width」は使用端末の横幅にページの横の長さを合わせるという意味です。
 また、「initial-scale=”1.0″」は初めにページが非表示されるとき、画面の倍率が1倍(つまりズームなし)という意味です。 
-->


<!-- 
解説　　tableタグについて
tableタグで表を作成できます。
tableタグで大きく囲むイメージです。。
trで行を作るイメージです。
行の種類はthでヘッダー部分、tdでデータ部分を作ることができます。
-->


<!-- 
解説　　
function he($str){                    
  return htmlentities($str, ENT_QUOTES, "UTF-8");
}
hmlentitiesのショートカット関数。適用可能な文字を全て HTML エンティティに変換する
return文で関数から値を返す。出力はされない。関数heへ値を代入してるイメージ。
functionでユーザー定義関数つくりますよ。heは関数名。($str)は引数。
htmlentities関数。適用可能な文字を全て HTML エンティティに変換する。
$strは入力文字列。ENT_QUOTESは定数名。"UTF-8"はエンコーディング定義。
-->


<!-- 
解説　　データベース接続で必要になる情報について
$dsn = 'mysql:host= ホスト名 ;dbname= データベース名 ;charset= 文字エンコード '; 
        $db_host = "localhost";           // データベースのホスト名
        $db_name = "motivation";          // データベースの名前
        $db_user = "root";                // データベース接続ユーザー
        $db_pass = "root";                // データベース接続パスワード
-->


<!--
解説　　データベース接続について
try {
  $db = new PDO("mysql:host={$db_host};dbname={$db_name};charset=utf8", $db_user, $db_user);     // // PDOインスタンスを生成
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // エラーモードの設定
  $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // エミュレーションを停止。
} catch (PDOException $e) {             
  exit("データベースの接続に失敗しました"); 
}

      // try - catch 文で例外処理もする。
      // new PDOでPDOインスタンスを生成。変数に代入。
      // ->アロー演算子でプロパティにアクセスできる。
      // PDO::ATTR_ERRMODEという属性でPDO::ERRMODE_EXCEPTIONの値を設定することでエラーが発生したときに、PDOExceptionの例外を投げてくれます。
      // PDO::ATTR_EMULATE_PREPARESという属性で、falseを設定することでprepareのエミュレーションを停止。trueだと常にエミュレートしてよくないらしい。
      // PDOException とし、スローされた例外インスタンスを $e 変数で受け取ることを意味します。
      // エラー発生時、exit文で処理終了。コメント表示付き。
-->


<!--
解説　　データの問い合わせについて
$rows_post = array();      
    
try {
  $stmt = $db->prepare("SELECT * FROM posts ORDER BY post_id ASC");  
  $stmt->execute(); 
  $rows_post = $stmt->fetchAll();      // SELECT結果を二次元配列に格納
} catch (PDOException $e) {
    exit("クエリの実行に失敗しました");
}

    // array関数で配列を作成。配列の初期化。
    // prepareによるクエリの実行準備。
    // SELECT文でデータを抽出。＊は全部取得。postsテーブルの全フィールドを、post_idの昇順で取得。ASCは昇順、DESCは降順。
    // execute関数を使うことでSQL文を実行。
    // fetchAllメソッドで、PDOで接続したデータベースで実行したSQLの結果全てを配列として返す。
    // $rows_postは配列の中に配列が入っているので二次元配列になる。
    // つまり、$stmtに$dbからデータを抽出して、$rows_postに格納しています。
    
  -->