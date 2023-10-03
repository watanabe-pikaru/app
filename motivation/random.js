'use strict';    //エラーを厳密にする

{
    //ボタン要素を出力しましょう。
    //今回はID属性で要素の出力を制御したいので、htmlでボタンタグにIDを設定。
    //定数btnを定義して、document.getElementByIdで要素を取得する
    const btn = document.getElementById('random_btn');      //定数btnを定義して、document.getElementByIdで要素を取得する。
    //getElementByIdは、任意のHTMLタグで指定したIDにマッチするドキュメント要素を取得するメソッドです。
    //ボタンがクリックされた時にpタグ要素を取得したいので、また定数を定期して、document.getElementByIdで要素を取得。
    const result = document.getElementById('result')

    //btnに対してクリックイベントを追加。clickをしたら次の処理をしなさいみたいなかんじ。
    btn.addEventListener('click', () => {

        //配列に要素を入れる。
        const results = [];      //配列resultsを定義。
        results[0] = 'どんな人間でも、必ず何かしら良いところがある。';
        results[1] = 'みんなも良い子ぶることはねえぞ。<br>良い生徒より、幸せな生徒になろうぜ。';
        results[2] = '教育とはコミュニケーションよ。<br>人と人がふれ合えば、そこに愛が生まれるんだよ。';
        results[3] = '今やれることをやってみようじゃねえの。<br>夢を持ってるとなあ、人は強くなれるんだ。';
        

        // 種類追加したいときは、配列追加するだけでおkな仕様にする。
        //配列の番号をランダムに変える乱数nを定義。
        const n = Math.floor(Math.random() * results.length);     
        // Math.random()で乱数を生成するメソッド。０以上１以下の数値をランダムに生成してくれる。0.000から0.999。
        //lengthは配列の要素数を表すプロパティ。これで配列を増やすだけで他にコード書く必要無しになる。
        //Math.random() と results.length をかけることで、例えば要素数が３だったら、0.000から2.999の乱数が生成。
        //整数部分だけ欲しい
        //Math.floorは指定した数値以下で、最大の整数を変えす命令



        //JavaScriptで要素の中身を変更するプロパティは『innerHTML』(いんなーえいちてぃーえむえる)、『innerText』(いんなーてきすと)、 『textContent』(てきすとこんてんと)の3つがあります。
        //要素の改行をさせたいときは、innerHTMLを使い、要素にHTMLタグの<br>を入れる。
        //要素を取得したあとに『.』でつなげて『innerHTML』とかを記述し、そのまま代入すればOKです。
        result.innerHTML = results[n];     //配列のん番目の要素をresultに代入して、中身を変更。
    
    })

}