
// 外部JavaScriptファイル


'use strict';    // エラーを厳密化

{
    // 定数を定義して、document.getElementByIdで要素を取得する。
    const btn = document.getElementById('random_btn');     // index.phpの「やる気スイッチ」の</button>要素を取得。
    const result = document.getElementById('result')     // index.phpの「ランダム言葉」の<p>要素を取得。

    // 定数btnに対しaddEventListenerでイベントを追加。
    btn.addEventListener('click', () => {     //「やる気スイッチ」クリックされたら以下を実施。

        // 配列に要素を入れる。
        const results = [];      // 配列resultsを定義。
        results[0] = 'どんな人間でも、必ず何かしら良いところがある。';
        results[1] = 'みんなも良い子ぶることはねえぞ。<br>良い生徒より、幸せな生徒になろうぜ。';
        results[2] = '教育とはコミュニケーションよ。<br>人と人がふれ合えば、そこに愛が生まれるんだよ。';
        results[3] = '今やれることをやってみようじゃねえの。<br>夢を持ってるとなあ、人は強くなれるんだ。';
        

        // 配列の番号をランダムに変える乱数nを定義。
        const n = Math.floor(Math.random() * results.length);     // 0以上配列数以下の整数をランダムに取得。
        

        // 配列結果をresultに代入。
        result.innerHTML = results[n];     // innerHTMLプロパティで中身を変更
    
    })

}


// めもめも

// 解説　　　getElementByIdについて
// getElementByIdは、任意のHTMLタグで指定したIDにマッチするドキュメント要素を取得するメソッドです。
// 定数を定義して、document.getElementByIdで要素を取得します。

// 解説　　　Math.random()について
// Math.random()は乱数を生成するメソッドです。
// ０以上１以下の数値（0.000から0.999。）をランダムに生成してくれるます。

// 解説　　　lengthについて
// lengthは配列の要素数を表すプロパティです。
// Math.random() と results.length をかけることで、例えば要素数が３だったら、0.000から2.999の乱数が生成されます。
// これで配列を増やすだけで他にコード書く必要無しになります。

// 解説　　　Math.floorについて
// Math.floorは指定した数値以下で、最大の整数を変えす命令  

// 解説　　innerHTMLプロパティについて
// JavaScriptで要素の中身を変更するプロパティは『innerHTML』(いんなーえいちてぃーえむえる)、『innerText』(いんなーてきすと)、 『textContent』(てきすとこんてんと)の3つがあります。
// 要素の改行をさせたいときは、innerHTMLを使い、要素にHTMLタグの<br>を入れる。
// 要素を取得したあとに『.』でつなげて『innerHTML』とかを記述し、そのまま代入すればOKです。


// 解説　　　DOMについて
// DOM はドキュメントオブジェクトモデルという名前の通り、 HTML や XML のドキュメントに含まれる要素や要素に含まれるテキストのデータをオブジェクトとして扱います。
// そしてドキュメントをオブジェクトが階層的に組み合わされたものとして識別します。
// そして DOM では JavaScript など色々なプログラミング言語などから、オブジェクトを扱うための API を提供しています。