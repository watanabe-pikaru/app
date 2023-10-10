
<!-- コメントアウト -->

<!DOCTYPE html>                   <!-- DOCTYPEは、「Document Type」の略で、「ドキュメントの型」という意味です。ここでは、文書がHTMLの型であることを宣言しています。 -->
  
  <head>                          <!-- headタグで囲まれたところ(head要素)にHTMLの文書の情報を書いていきます。 -->
    <meta charset="UTF-8" />      <!-- 文字コードを指定しています。推奨されている文字コード「UTF-8」を指定しましょう。UTF-8以外だとブラウザに表示されたとき文字化けを起こす可能性があります。 -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />     <!-- IE(Internet Explorer)を最新バージョンで動かさせるためのコードです。 --> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />     <!-- 「width=”device-width」は使用端末の横幅にページの横の長さを合わせるという意味です。また、「initial-scale=”1.0″」は初めにページが非表示されるとき、画面の倍率が1倍(つまりズームなし)という意味です。 -->
    <title>自作アプリ</title>                                     <!-- タイトルは検索結果と、ブラウザのタブの上部に表示されます。 -->
    <link rel="stylesheet" href="./style.css">                  <!-- このコードにより、別に用意してあるCSSファイルを読み込むことができます。 -->
    <link rel="stylesheet" href="sanitize.css">                 <!-- ブラウザデフォルトのCSSの違いを統一して、見た目を整える -->
  </head>
  
  
  <body>                          
    
    <!-- タイトル -->
    <div class="title">
      <h1>燃えろ！あひる組</h1>
      <p>
        みんなにだって力はある。誰だってパワーを持ってる。<br>
        見た目じゃ分かんねえ。どんな凄え力が潜んでるか分からねえ。<br>
        それを「可能性」って言うんだ。<br>
      </p>
    </div>


<!-- ここからjavascript出てくる -->

    <!-- フレーズをランダムに表示 -->
    <div class="random">
      <h1>今日の「やる気が出る言葉」</h1>
      <p id="result"></p>                               <!-- ランダム結果表示。 IDはjavascriptでも使用。-->
      <button id="random_btn">やる気スイッチ</button>     <!-- ボタン。IDはjavascriptでも使用 -->
    </div>


<!-- ここからPHP出てくる -->

    <!-- フレーズを見たり、編集したりしたい -->
    <div class="list">
      
      <h1>がんばりノート</h1>

      
     <?php
      // hmlentitiesのショートカット関数。適用可能な文字を全て HTML エンティティに変換する
      // return文で関数から値を返す。出力はされない。関数heへ値を代入してるイメージ。
      // functionでユーザー定義関数つくりますよ。heは関数名。($str)は引数。
      function he($str){                    
            return htmlentities($str, ENT_QUOTES, "UTF-8");
            //htmlentities関数。適用可能な文字を全て HTML エンティティに変換する。
            //$strは入力文字列。ENT_QUOTESは定数名。"UTF-8"はエンコーディング定義。
          }


      // データベース接続で必要になる情報を変数に入れる。
      // $dsn = 'mysql:host= ホスト名 ;dbname= データベース名 ;charset= 文字エンコード ';
      $db_host = "localhost";           // データベースのホスト名
      $db_name = "motivation";          // データベースの名前
      $db_user = "root";                // データベース接続ユーザー
      $db_pass = "root";                // データベース接続パスワード

      // データベース接続
      // try - catch 文で例外処理もする。
      // new PDOでPDOインスタンスを生成。変数に代入。
      // ->アロー演算子でプロパティにアクセスできる。
      // PDO::ATTR_ERRMODEという属性でPDO::ERRMODE_EXCEPTIONの値を設定することでエラーが発生したときに、PDOExceptionの例外を投げてくれます。
      // PDO::ATTR_EMULATE_PREPARESという属性で、falseを設定することでprepareのエミュレーションを停止。trueだと常にエミュレートしてよくないらしい。
      // PDOException とし、スローされた例外インスタンスを $e 変数で受け取ることを意味します。
      // エラー発生時、exit文で処理終了。コメント表示付き。
      try {
          $db = new PDO("mysql:host={$db_host};dbname={$db_name};charset=utf8", $db_user, $db_user);     // // PDOインスタンスを生成
          $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // エラーモードの設定
          $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // エミュレーションを停止。
      } catch (PDOException $e) {             
          exit("データベースの接続に失敗しました"); 
      }


      // データの問い合わせ
      // array関数で配列を作成。配列の初期化。
      // prepareによるクエリの実行準備。
      // SELECT文でデータを抽出。＊は全部取得。postsテーブルの全フィールドを、post_idの昇順で取得。ASCは昇順、DESCは降順。
      // execute関数を使うことでSQL文を実行。
      // fetchAllメソッドで、PDOで接続したデータベースで実行したSQLの結果全てを配列として返す。
      // $rows_postは配列の中に配列が入っているので二次元配列になる。
      // つまり、$stmtに$dbからデータを抽出して、$rows_postに格納しています。
      $rows_post = array();      
      try {
          $stmt = $db->prepare("SELECT * FROM posts ORDER BY post_id ASC");  
          $stmt->execute(); 
          $rows_post = $stmt->fetchAll();      // SELECT結果を二次元配列に格納
      } catch (PDOException $e) {
          exit("クエリの実行に失敗しました");
      }
      ?>


      
      <!-- tableタグで表を作成 -->
      <!-- tableタグで大きく囲む -->
      <!-- trで行を作る囲む -->
      <!-- 行の種類はthでヘッダー部分、tdでデータ部分 -->
      <?php if ($rows_post) {?>
        <table border="1" width="100%"> 
      <?php     foreach ($rows_post as $row_post) {;?>
          <tr>
            <td class="note" width="90%"><?php echo nl2br(he($row_post["post_content"]));?></td>
            <td><a href="confirm.php?id=<?php print($row['post_id']) ?>">削除</a></td>
          </tr>
      <?php     }?>
        </table>
      <?php }?>
      
      <hr>
      <a href="post_edit.php">新規登録</a>
      
    </div>
  
    <!-- scriptタグで、JavaScriptを記述した外部ファイルを読み込む -->
    <script src="random.js"></script>     
  
  </body>
</html>