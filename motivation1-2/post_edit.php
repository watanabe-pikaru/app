
<!-- 新規登録ページ -->


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


    //データベース接続
    try {
        $db = new PDO("mysql:host={$db_host};dbname={$db_name};charset=utf8", $db_user, $db_user);    
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />    
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





<!-- もめもめ -->

<!-- 
解説　　formタグについて
formタグによって、以降のinputタグに入力された値を送信します。

「送信する」ボタンが押されると、formタグに囲まれた範囲の入力項目がセットになって、指定されたページに飛ばされます。
フォームの送信先は、action属性で指定します。
今回は“post_edit.php”（自分自身のページ）へ、”post”方式で送信するという記述になります。
なお、主なmethodには「post」と「get」があります。
こういったフォーム送信については、まずは「post」で行うと覚えておいてください。
-->


<!-- 
解説　　formタグについて
textareaタグは、複数行のテキストを入力するための入力項目を表示します。
name=”post_content”という指定により、入力された値はpost_contentという名前で送信されます。
rows=”5″は入力枠の行数が5行であることを意味します。
cols=”20″は入力枠の幅が20文字であることを意味します。　　　
rowsとcols属性ではなく、大きさはCSSでwidthとheightで指定するほうがブラウザの影響出なくて良し。
placeholder属性でヒント文を表示できます。
-->


<!--
解説　　inputタグについて
<input>は、様々なフォームパーツを作るためのタグです。
type属性を何にするかによって、異なる役割を与えることができます。
type=”submit”と指定されたボタンをクリックされると、formの中身を送信します。
name=”send”という指定により、value値（「登録する」という文字列）はsendという名前で送信されます。
form の method 属性が「post」なので送信されたデータは、$_POST という連想配列（スーパーグローバル変数）に格納されます。
送信ボタンの name 属性が「send」なのでスーパーグローバル変数 $_POST のキーに「send」を指定して $_POST['send'] とします。
-->


<!--
解説　　issetについて
issetは変数がセットされているかを調べます。
form の method 属性が「post」なので送信されたデータは、$_POST という連想配列（スーパーグローバル変数）に格納されます。
送信ボタンの name 属性が「send」なのでスーパーグローバル変数 $_POST のキーに「send」を指定して $_POST['send'] とします。
isset($_POST['send']) が true の場合、送信ボタンがクリックされてデータが送信され、 $_POST['send']が定義済みになっています。
-->


<!--
解説　　INSERT文について
INSERT文はテーブルにデータを登録します。テーブル名のあとにカッコで、列名を並べます。
VALUESのあとのカッコに、登録したい値をカンマで区切って並べます。列名と値は順番を合わせる必要があります。
SQLの中で、「?」となっている箇所は、プリペアドステートメントを利用する構文となっています。
SQLに直接変数を流し込むと、SQLインジェクションの攻撃をされる恐れがあります。
SQLに変数を渡す際は、必ずプリペアドステートメントを利用するようにしましょう。
executeメソッドでプレースホルダに値をセット。execute関数を使うことでSQL文を実行。

-->


<!--
解説　トランザクションについて
トランザクションはMySQL データベースに複数のデータを保存するときに役立つ機能です。
例えば、30人分の試験結果をデータベースに保存するとします。
全て問題なく登録できれば良いですが、16人目で何かエラーが起きて登録に失敗するかもしれません。
このとき15人目までの登録処理をキャンセルしてくれるのがトランザクションです。
トランザクションを使うと「全て登録できる」か「全て登録できない」かのどちらかになります。
beginTransaction()でトランザクション開始。
全てが問題無ければcommit()で実行。
途中でエラーが出たらロールバックで中断。
-->