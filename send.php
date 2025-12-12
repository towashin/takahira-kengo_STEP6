<?php
// ------------------------------------------------------------
// confirm.php から送信されたデータ受け取り
// ------------------------------------------------------------
$name = $_POST['name'] ?? '';
$company = $_POST['company'] ?? '';
$email = $_POST['email'] ?? '';
$age = $_POST['age'] ?? '';
$inquiry = $_POST['inquiry'] ?? '';


// ------------------------------------------------------------
// 入力チェック（confirm.php を通らず直接アクセスした場合の保護）
// ------------------------------------------------------------
if ($name === '' && $email === '' && $inquiry === '') {
    echo "不正なアクセスです。<br>";
    echo '<a href="contact.php">お問い合わせフォームに戻る</a>';
    exit;
}


// ------------------------------------------------------------
// メール送信処理（必要に応じて編集）
// ------------------------------------------------------------
$to = "your-mail@example.com"; 
$subject = "お問い合わせがありました";

$body  = "お問い合わせ内容\n";
$body .= "--------------------------\n";
$body .= "お名前: {$name}\n";
$body .= "会社名: {$company}\n";
$body .= "メール: {$email}\n";
$body .= "年齢: {$age}\n";
$body .= "お問い合わせ内容:\n{$inquiry}\n";
$body .= "--------------------------\n";

$headers = "From: " . $email;

$mailResult = mb_send_mail($to, $subject, $body, $headers);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>お問い合わせ送信完了</title>
    <link rel="stylesheet" href="style.css">

    <style>
        /* サイドバーのデザイン */
        .sidebar {
            width: 200px;
            float: left;
        }

        /* メインコンテンツ部分 */
        .content {
            margin-left: 220px;
        }

        /* 表の基本デザイン */
        table {
            border-collapse: collapse;
            margin-top: 20px;
        }

        /* 表の枠線（太さ 3px） */
        table, th, td {
            border: 3px solid #000;
            padding: 10px;
        }

        footer {
            margin-top: 40px;
            padding: 20px;
            background: lightgray;
            text-align: center;
        }

        /* footer 内ボタン */
        #changeColorBtn {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }

        /* メッセージボックス */
        .message-box {
            border: 3px solid #000;
            padding: 30px;
            width: 500px;
            margin-top: 30px;
            border-radius: 10px;
        }
    </style>

    <script>
        // -------------------------------------------------------
        // footer の背景色を青 → 赤 → 黄色 → 灰色 → 青…と循環させる処理
        // -------------------------------------------------------

        let colors = ["blue", "red", "yellow", "gray"];
        let index = 0;

        function changeFooterColor() {
            const footer = document.getElementById("footer");
            footer.style.backgroundColor = colors[index];
            index = (index + 1) % colors.length;
        }
    </script>

</head>
<body>

    <!-- header 表示部分 -->
    <header>
        <h2>お問い合わせフォーム</h2>
    </header>

    <!-- サイドバー（リンク付き箇条書き） -->
    <div class="sidebar">
        <ul>
            <li><a href="index.php">トップページ</a></li>
            <li><a href="popular.php">人気投稿</a></li>
            <li><a href="items.php">エンジニアおすすめ商品</a></li>
            <li><a href="articles.php">エンジニアおすすめ記事</a></li>
            <li><a href="post.php">投稿ページ</a></li>
        </ul>
    </div>

    <!-- メインコンテンツ -->
    <div class="content">

        <h3>送信完了</h3>

        <div class="message-box">
            <?php if ($mailResult): ?>
                <p>お問い合わせ内容を送信いたしました。ありがとうございます！</p>
            <?php else: ?>
                <p>メール送信に失敗しました。お手数ですが、再度お試しください。</p>
            <?php endif; ?>
        </div>

        <br>
        <a href="index.php">トップへ戻る</a>

    </div>

    <!-- footer（背景色が変わる） -->
    <footer id="footer">
        <button id="changeColorBtn" onclick="changeFooterColor()">押してみてね！</button>
    </footer>

</body>
</html>


