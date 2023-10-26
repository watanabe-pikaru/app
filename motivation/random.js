
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

