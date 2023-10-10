<!DOCTYPE html>                   <!-- DOCTYPEは、「Document Type」の略で、「ドキュメントの型」という意味です。ここでは、文書がHTMLの型であることを宣言しています。 -->
  
  <head>                          <!-- headタグで囲まれたところ(head要素)にHTMLの文書の情報を書いていきます。 -->
    <meta charset="UTF-8" />      <!-- 文字コードを指定しています。推奨されている文字コード「UTF-8」を指定しましょう。UTF-8以外だとブラウザに表示されたとき文字化けを起こす可能性があります。 -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />     <!-- IE(Internet Explorer)を最新バージョンで動かさせるためのコードです。 --> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />     <!-- 「width=”device-width」は使用端末の横幅にページの横の長さを合わせるという意味です。また、「initial-scale=”1.0″」は初めにページが非表示されるとき、画面の倍率が1倍(つまりズームなし)という意味です。 -->
    <title>新規登録</title>                                     <!-- タイトルは検索結果と、ブラウザのタブの上部に表示されます。 -->
    <link rel="stylesheet" href="./style.css">                  <!-- このコードにより、別に用意してあるCSSファイルを読み込むことができます。 -->
    <link rel="stylesheet" href="sanitize.css">                 <!-- ブラウザデフォルトのCSSの違いを統一して、見た目を整える -->
  </head>
  
  
  <body>   

        <div class="list">
      
            <h1>新規登録</h1>

            <?php   //データベース接続
          
                function he($str){                    
                    return htmlentities($str, ENT_QUOTES, "UTF-8");
                }

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
            ?>


            <?php     //空白の場合、エラー表示

                // issetは変数がセットされているかを調べます。
                // form の method 属性が「post」なので送信されたデータは、$_POST という連想配列（スーパーグローバル変数）に格納されます。送信ボタンの name 属性が「send」なのでスーパーグローバル変数 $_POST のキーに「send」を指定して $_POST['send'] とします。isset($_POST['send']) が true の場合、送信ボタンがクリックされてデータが送信され、 $_POST['send']が定義済みになっています。
                if (isset($_POST['send'])) {
                        if ($_POST['post_content'] == ''){
                            echo "<div class=echo_red>";     //赤字
                            echo "記入欄が空白です。入力してください";
                            echo "</div>";
                        }
                    }
            ?>

            <?php     //データ保存

                // 登録実行   
                // 登録ボタン押されて、名言が空欄で無かったなら、データベース保存開始
                if (isset($_POST['send']) && $_POST['post_content'] != "" ) {
                    // データベースへ保存
                    // beginTransaction()でトランザクション開始
                    // INSERT文はテーブルにデータを登録します。テーブル名のあとにカッコで、列名を並べます。VALUESのあとのカッコに、登録したい値をカンマで区切って並べます。列名と値は順番を合わせる必要があります。
                    // SQLの中で、「?」となっている箇所は、プリペアドステートメントを利用する構文となっています。SQLに直接変数を流し込むと、SQLインジェクションの攻撃をされる恐れがあります。SQLに変数を渡す際は、必ずプリペアドステートメントを利用するようにしましょう。
                    // executeメソッドでプレースホルダに値をセット。execute関数を使うことでSQL文を実行。
                    // 以上全てが問題無ければcommit()で実行
                    // 途中でエラーが出たらロールバックで中断

                $db_host = "localhost";           // データベースのホスト名
                $db_name = "motivation";          // データベースの名前
                $db_user = "root";                // データベース接続ユーザー
                $db_pass = "root";                // データベース接続パスワード

                try {
                        $db = new PDO("mysql:host={$db_host};dbname={$db_name};charset=utf8", $db_user, $db_user);  // PDOインスタンスを生成
                        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // エラーモードの設定
                        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // エミュレーションを停止。
                 
                        $db->beginTransaction();
                        
                        $sql = 'INSERT INTO posts (post_content) VALUES (:post_content)';
                        $data = array(':post_content' => $_POST['post_content']);     //先にSQL文とexcecuteで使う配列データをそれぞれ変数にいれておく。
                        
                        $stmt = $db->prepare($sql);
                        $stmt->execute($data);

                        $db->commit();

                        // 以下４文はうまくいかなかった。
                        // $db->beginTransaction();
                        // $stmt = $db->prepare("INSERT INTO posts (post_content) VALUES (?)");
                        // $stmt->execute(array($_POST["post_content"]));
                        // $db->commit();

                    } catch (PDOException $e) {
                    // エラー発生時  
                    $db->rollBack();
                    exit("クエリの実行に失敗しました");
                    // print_r($stmt -> errorInfo());     //エラー時確認用
                    }

                // 完了
                echo "登録されました。";
                // var_dump($_POST["post_content"]);     //エラー時確認用
                }
            ?>

            


            <!-- 
                formタグによって、以降のinputタグに入力された値を送信します。<input>は、様々なフォームパーツを作るためのタグです。type属性を何にするかによって、異なる役割を与えることができます。
                「送信する」ボタンが押されると、formタグに囲まれた範囲の入力項目がセットになって、指定されたページに飛ばされます。
                フォームの送信先は、action属性で指定します。“post_edit.php”（自分自身のページ）へ、”post”方式で送信するという記述になります。
                なお、主なmethodには「post」と「get」があります。こういったフォーム送信については、まずは「post」で行うと覚えておいてください。
            -->
            <form action="post_edit.php" method="post">
                
                <!--
                    textareaタグは、複数行のテキストを入力するための入力項目を表示します。
                    name=”post_content”という指定により、入力された値はpost_contentという名前で送信されます。
                    rows=”5″は入力枠の行数が5行であることを意味します。
                    cols=”20″は入力枠の幅が20文字であることを意味します。　　　
                    rowsとcols属性ではなく、大きさはCSSでwidthとheightで指定するほうがブラウザの影響出なくて良し。
                    placeholder属性でヒントを表示
                -->
                <div>
                <br>
                <textarea name="post_content" placeholder="入力して登録ボタンを押してください。" ><?php echo he($_POST["post_content"]); ?></textarea>
                </div>

                <!--
                    type=”submit”と指定されたボタンをクリックされると、formの中身を送信します。
                    name=”send”という指定により、value値（「登録する」という文字列）はsendという名前で送信されます。
                    form の method 属性が「post」なので送信されたデータは、$_POST という連想配列（スーパーグローバル変数）に格納されます。送信ボタンの name 属性が「send」なのでスーパーグローバル変数 $_POST のキーに「send」を指定して $_POST['send'] とします。
                -->
                <div>
                <input type="submit" name="send" value="登録" class="submit_btn">
                </div>
            </form>

            <hr>
            <a href="index.php" class="a">トップへ戻る</a>

        </div>
        

  </body>
</html>