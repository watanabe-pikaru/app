'use strict';    //エラーを厳密にする

{
    const btn = document.getElementById('btn');
    const result = document.getElementById('result')

    btn.addEventListener('click', () => {
        const results = ['大吉', '中吉','凶','小吉'];
        const n = Math.floor(Math.random() * results.length); // おみくじの種類追加したいときは、配列追加するだけでおk

        result.textContent = results[n];
    })

}

    /*
        Math.random()で乱数を生成。
        実行すると０以上１未満の数字を少数第３位まで生成。
        0.000から0.999まで。
        これを３倍すれば0.000から2.999までになる。
        大吉０
        中吉１
        凶２
        で設定したい。
        Math.floor()で指定した数値の整数部分を返してくる。
    */


        /*   switch文を使う場合
        //result.textContent = n;

        switch (n) {
            case 0:
                result.textContent = '大吉'
                break;
            case 1:
                result.textContent = '中吉'
                break;
            case 2:
                result.textContent = '凶'
                break;    
        }/*

*/