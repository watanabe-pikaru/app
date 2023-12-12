
//グラフィックのメソッド取得
const canvas = document.getElementById("myCanvas");   // <canvas> 要素への参照を canvas に保存。
const ctx = canvas.getContext("2d");   //2Dグラフィックを描画するためのメソッドやプロパティを持つオブジェクトを定数ctxに格納。


//円の開始位置を定義
let x = canvas.width / 2;   //中央
let y = canvas.height - 30;   //ちなみにcanvasは右向きにX+,下向きにY+です。 


//動いてみせるために小さな値を加えたい。
//フレームごとに x と y を変数 dx、dy で更新して、更新されるたびにボールが新しい位置に描画されるようにする。
let dx = 2;
let dy = -2;


//円の半径を保持し、計算に使用するという変数を定義。
const ballRadius = 10;


//パドルに用いるいくつかの変数を定義。
const paddleHeight = 10;   //パドルの高さ
const paddleWidth = 75;   //パドルの幅
let paddleX = (canvas.width - paddleWidth) / 2;   //パドルの開始地点


//操作ボタンの初期化。最初は押されていない為、規定値はfalse。
let rightPressed = false;
let leftPressed = false;


//ロックの行と列の数、幅と高さ、ブロックがくっつかないように足元の隙間を定義
//そしてキャンバスのブロックに描画されないように上端、左端からの相対位置を定義
const brickRowCount = 3;   //ブロックの行数。c。
const brickColumnCount = 5;   //ブロックの列数。r。
const brickWidth = 75;   //幅
const brickHeight = 20;   //高さ
const brickPadding = 10;   //間隔
const brickOffsetTop = 30;   //位置（上）
const brickOffsetLeft = 30;   //位置（左）


//二次元配列はブロックの列 (c) を含んでおり、列は行 (r) を含み、行はそれぞれのブロックが描画される画面上x規定とy規定を含んでいます。
//上記の説明はよくわからなかった。
//二重ループを使い、二次元配列を作り、そのなかに連想配列を定義？
//ループを使用して一括で描画できるようにする。
//二次元配列はブロックの位置や状態を効果的に管理することができる。
const bricks = []; 
for (let c = 0; c < brickColumnCount; c++) {
  bricks[c] = [];    
  for (let r = 0; r < brickRowCount; r++) {
    bricks[c][r] = { x: 0, y: 0, status: 1 };   //status:はブロック有無ステータス。１は有、0は無。初期値は有りだから０。
  }
}


//ブロックを描画
function drawBricks() {
  for (let c = 0; c < brickColumnCount; c++) {
    for (let r = 0; r < brickRowCount; r++) {
      if (bricks[c][r].status === 1) {   //ステータスを確認。１でなければ描画しない。
        const brickX = c * (brickWidth + brickPadding) + brickOffsetLeft;   //列番＊ブロック幅と間隔+左オフセット
        const brickY = r * (brickHeight + brickPadding) + brickOffsetTop;   //列番＊ブロック高さと間隔+上オフセット
        bricks[c][r].x = brickX;
        bricks[c][r].y = brickY;
        ctx.beginPath();
        ctx.rect(brickX, brickY, brickWidth, brickHeight);   //ブロックを座標に描画
        ctx.fillStyle = "#0095DD";
        ctx.fill();
        ctx.closePath();
      }
    }
  }
}


//衝突検出関数
//衝突検出のループの内部ブロック オブジェクトを保存する変数をb定義
//ボールの中央がブロックの 1 もし何かの規定の内部だったらボールの向きを変え、有無ステータスも変更。
function collisionDetection() {
  for (let c = 0; c < brickColumnCount; c++) {
    for (let r = 0; r < brickRowCount; r++) {
      const b = bricks[c][r];
      if (b.status === 1) {
        if (
          x > b.x &&   //ボールの x 座標がブロックの x 座標より大きい
          x < b.x + brickWidth &&   //ボールの x 座標がブロックの x 座標とその幅の和より小さい
          y > b.y &&   //ボールのy座標がブロックのy座標より大きい
          y < b.y + brickHeight   //ボールのy座標がブロックのy座標とその高さの和より小さい
        ) {
          dy = -dy;   //向きを変える。
          b.status = 0;   //ステータス無にする。
        }
      }
    }
  }
}

//ボールを描画
function dorwball(){
    ctx.beginPath();
    ctx.arc(x, y, ballRadius, 0, Math.PI * 2);   //円を定義。
    ctx.fillStyle = "#0095DD";
    ctx.fill();
    ctx.closePath();
}

//パドルを描画
function drawPaddle() {
    ctx.beginPath();
    ctx.rect(paddleX, canvas.height - paddleHeight, paddleWidth, paddleHeight);
    ctx.fillStyle = "#0095DD";
    ctx.fill();
    ctx.closePath();
}



//動きを定義
function draw() {  
    ctx.clearRect(0, 0, canvas.width, canvas.height);   //キャンバスの内容を消去。 軌跡を残らないようにする。
    drawBricks();   //ブロックを表示
    dorwball();   //ボール表示
    drawPaddle();   //パドル表示
    collisionDetection();   //衝突検出関数
    x += dx;   //少し動かす
    y += dy;   //少し動かす

    //右端に円が当たった時（最大引く半径より高かったら）、または、左端に円が当たった時（半径より低かったら）、x方向の動きを反転させる。
    if (x + dx > canvas.width - ballRadius || x + dx < ballRadius) {
        dx = -dx;
    }

    //上端に円が当たった時（半径より低かったら）、y方向の動きを反転させる。
    //下端に円が当たった時（最大引く半径より高かったら）ゲームオーバー。
    //ボールの中心がパドルの左端と右端の間にあるかどうかをチェックして衝突判定。
    if (y + dy < ballRadius) {
        dy = -dy;
      } else if (y + dy > canvas.height - ballRadius) {
        if (x > paddleX && x < paddleX + paddleWidth) {
            dy = -dy;
          } else {
        //alert("GAME OVER");
        clearInterval(interval);   //繰り返し処理を取り消す。
        document.location.reload();   //再読み込み。
        }
    }

    //パドルが左端の 0 と右端の canvas.width-paddleWidth 間で動くようにする。
    if (rightPressed) {
        paddleX = Math.min(paddleX + 5, canvas.width - paddleWidth);   //右端か右に動いた位置のどちらか小さいほうが位置になる。
      } else if (leftPressed) {
        paddleX = Math.max(paddleX - 5, 0);   //左端か左に動いた位置のどちらか大きいほうが位置になる。
    }
}

//ボタン押し検知。
document.addEventListener("keydown", keyDownHandler, false);
document.addEventListener("keyup", keyUpHandler, false);


//引数eにはイベントリスナー実行時に生成されたイベントオブジェクトのイベント発生情報を取得される。
//key は押されたキーについての情報を持っています。
//キーが押された時
function keyDownHandler(e) {
    if (e.key === "Right" || e.key === "ArrowRight") {
      rightPressed = true;
    } else if (e.key === "Left" || e.key === "ArrowLeft") {
      leftPressed = true;
    }
}

//キーが離れた時
function keyUpHandler(e) {
    if (e.key === "Right" || e.key === "ArrowRight") {
      rightPressed = false;
    } else if (e.key === "Left" || e.key === "ArrowLeft") {
      leftPressed = false;
    }
}



//一定の遅延間隔を置いて関数やコードスニペットを繰り返し呼び出す。
//draw() 関数は setInterval 内で 10 ミリ秒ごとに実行されます。
const interval = setInterval(draw, 10);  



//ストップとスタート
const stopButton = document.getElementById("stopButton");
const startButton = document.getElementById("startButton");
const resetButton = document.getElementById("resetButton");


stopButton.onclick = function() {
  stop();
};

startButton.onclick = function() {
  start();
};

resetButton.onclick = function() {
  reset();
};

// ストップ
function stop() {
  clearInterval(interval);
}

// スタート
function start() {
  interval = setInterval(draw, 10); 
}

//リセット
function reset() {
  clearInterval(interval);   //繰り返し処理を取り消す。
  document.location.reload();   //再読み込み。
}




/*  使わないけどいちおう残す。
//四角形を描画  void ctx.rect(x, y, width, height);
ctx.beginPath();    //パスの定義開始。
ctx.rect(20, 40, 50, 50);   //四角形を定義。
ctx.fillStyle = "#FF0000";   //色指定。
ctx.fill();   //直前に定義したパスを塗りつぶす。。
ctx.closePath();  //パスの定義終了。

//円を描画  ctx.arc(x, y, radius, startAngle, endAngle [, counterclockwise]);
ctx.beginPath();
ctx.arc(240, 160, 20, 0, Math.PI * 2, false);   //円を定義。
ctx.fillStyle = "green";
ctx.fill();
ctx.closePath();
*/



//めも

/*   
<canvas> 要素への参照を canvas に保存しています。
2D 描画コンテキストを保存するために ctx 変数を作成しています。 
2D 描画コンテキストは実際にキャンバスに描画するために使うツールとなります。
*/

/*  getContext()
<canvas>要素はgetContext()メソッドを持つ。
getContext()メソッドは、グラフィックを描画するためのメソッドやプロパティをもつオブジェクトを返す。
getContext()メソッドに引数"2d"を渡して実行すると、2Dグラフィックを描画するためのメソッドやプロパティをもつオブジェクトを返す。
// canvas要素が持つgetContext()メソッドを実行し、
// グラフィック描画のためのメソッドやプロパティを
// 持つオブジェクトを取得する。
// 引数を"2d"とすることで2Dグラフィックの描画に
// 特化したメソッドやプロパティを持つオブジェクトを取得し、
// 定数ctxに格納する。
const ctx = canvas.getContext("2d");
// 定数ctxに格納したオブジェクトがもつプロパティやメソッドは
// ctx.プロパティ名、ctx.メソッド名() で呼び出せる
*/


/*
canvas の描画機能は非常にシンプルです。基本的には、以下の 3 種類の図形しか用意されていません。
矩形、パス、ビットマップ画像。
パスには直線だけでなく円弧やベジェ曲線なども含められるので、ほぼすべての図形が描画できます。
*/

/*  パス
パスを描画するためには、まずパスの形状を定義し、その上で輪郭の描画、もしくは塗りつぶしを実行します。
具体的な手順は以下のようになります。
beginPath() を呼び出し、パスの定義を開始する
直線、円弧などのメソッドを必要なだけ呼び出し、パスの形状を定義する。
closePath() を呼び出し、パスを閉じる（これは必須ではありません）。
fill(), stroke() のどちらか、もしくは両方を呼び出し、描画領域にパスを描画する。
*/

/*  rect()
ctx.rect(x, y, width, height);
最初の 2 つの値は左上の角のキャンバス上での座標を指定し、あとの 2 つの値は幅と高さを指定しています。
*/

/*  arc()
ctx.arc(x, y, radius, startAngle, endAngle [, counterclockwise]);
arc() メソッドは (x, y) を中心とし、 radius を半径とした円弧を作成します。
角度は startAngle から endAngle まで、 
counterclockwise で指定された向き（既定では時計回り）に描かれます。
時計回りは false で、既定値。反時計回りは true。) この最後の引数は省略可能です。
*/

/*  Math.PI
円弧を描き始める角度と描き終える角度は、ラジアンで指定します。
角度は円の中心座標からx軸正方向（円の中心の右）が0で、時計回りに増加します。
360度が2πラジアンであり、JavaScriptでπはMath.PIという定数で与えられています。
従って2πはMath.PI*2と書くことができます。
円弧を0からMath.PI*2（2πラジアン＝360度）まで描くことで正円を描画しています。
*/

/*   setInterval()
setInterval() メソッドは Window および Worker メソッドで提供され、
一定の遅延間隔を置いて関数やコードスニペットを繰り返し呼び出します。
*/


/*  draw() 関数
draw() 関数は setInterval 内で 10 ミリ秒ごとに実行されます。
*/


/*
ちなみにcanvasは右向きにX+,下向きにY+です。
*/

/*  clearRect() 
前のフレームを削除せずに毎フレーム描画しているために軌跡が残ってしまいます。
でも心配する必要はありません。
キャンバスの内容を消去するメソッド、 clearRect() があります。
このメソッドは 4 つの引数をとります。
四角形の左上端の x、y 座標と四角形の右下端の x、y 座標です。この四角形で囲われた領域にある内容全てが消去されます。
*/

/*
OR 演算子
||のこと。
OR演算子||は、左から順にtrueを探しにいき、
見つかればその値を返す。
見つからなければ最後の値を返すよ。
*/

/*
AND演算子
&&のこと。
かつ？
*/s


/*  addEventListenerとは
マウスによるクリックやキーボードからの入力といった様々なイベント処理を実行するメソッド。
一般的な書き方は、イベントの種類と実行するための関数を指定する。
第1引数にイベントの種類、第2引数に関数、第3引数にイベント伝搬の方式をtrueかfalseで指定する。
第3引数は通常はfalseを指定する。
*/

/*   変数e
addEventListener(イベントリスナ)はイベントと関数を紐づけるとともに、イベントオブジェクトを生成する。
イベントオブジェクトとは、イベント発生時の情報がまとめられたもの。
生成されたオブジェクトは、イベント発生時に呼び出される関数の第１引数に渡される。
関数にはオブジェクトを受け取るための第１引数を明記しておかなければならない。
そのために記述してされているのが、引数「e」。
引数名は任意ではあるが、「e」としたほうが分かりやすいので、慣例的に使われている。
*/


/*
Math.minとは、引数として与えられた値から最も小さい値を返すメソッド
*/

/*
clearInterval()メソッドは、繰り返し動作を取り消します。
*/


/*  ocation: reload() メソッド
location.reload() メソッドは、再読み込みボタンのように現在の URL を再読み込みします。
*/




/*  onload
onload = initにより、ページが読み込んでからinit関数の中身を実行するようにしている。
まず、onloadイベントとはページや画像が読み込みが完了した時点でイベントを実行するよというもの。
つまり、自動的に処理を実行したい場合などに使用します。
但し、実行するタイミングについては正しく記述できていないとエラーが起こったり、
上手く実行されないことがある為、正しい記述方法をしっかり理解する必要があります。
*/

/*
因みに「イベント」と違って「イベントハンドラ」という言葉もあるのですが、
Webページの中のボタンを押したら表示されている画像が変わるというような例で
『表示されている画像が変わる』が「イベント」
『Webページの中のボタンを押したら』が「イベントハンドラ」となります。
見分け方として、”onClick”や”onMouse”など処理の前に”on”がついているかいないかそれだけです。
*/
