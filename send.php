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
if (
    $_SERVER["REQUEST_METHOD"] !== "POST" ||
    empty($_POST['name']) ||
    empty($_POST['email']) ||
    empty($_POST['inquiry'])
) {
    header("Location: contact.php");
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

$email = str_replace(["\r", "\n"], '', $email);
$headers = "From: {$email}";

$mailResult = mb_send_mail($to, $subject, $body, $headers);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>お問い合わせ送信完了</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- header 表示部分 -->
    <header>
        <h1>お問い合わせフォーム-送信完了画面</h1>
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
    <main>

        <h1>送信完了</h1>

        <div class="message-box">
            <?php if ($mailResult): ?>
                <p>お問い合わせ内容を送信いたしました。ありがとうございます！</p>
            <?php else: ?>
                <p>メール送信に失敗しました。お手数ですが、再度お試しください。</p>
            <?php endif; ?>
        </div>

        <br>
        <a href="contact.php">お問い合わせフォームに戻る</a>

    </main>

    <!-- footer（背景色が変わる） -->
    <footer>
    <button id="footerBtn">押してみてね！</button>
    </footer>

    <script src="style.js"></script>            
</body>
</html>


