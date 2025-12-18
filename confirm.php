<?php
// ★ POST以外（フォーム以外）からアクセスされた場合、contact.php にリダイレクト
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: contact.php");
    exit();
}

// ------------------------------------------------------------
// contact.php のフォームから送信されたデータを受け取る
// $_POST は POST送信された値を取得できるスーパーグローバル変数
// ------------------------------------------------------------
$name = $_POST['name'] ?? '';
$company = $_POST['company'] ?? '';
$email = $_POST['email'] ?? '';
$age = $_POST['age'] ?? '';
$inquiry = $_POST['inquiry'] ?? '';

// ★ 入力チェック
$errors = [];
if ($name === '')    $errors[] = "お名前が入力されていません。";
if ($email === '')   $errors[] = "メールアドレスが入力されていません。";
if ($inquiry === '') $errors[] = "お問い合わせ内容が入力されていません。";

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <!-- ページタイトル（確認画面） -->
    <title>お問い合わせフォーム - 確認画面</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <!-- header 表示部分 -->
    <header>
        <h2>お問い合わせフォーム</h2> <!-- h2で表示 -->
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

        <?php if (!empty($errors)): ?>
            <div class="error">
                <h3>入力エラーがあります</h3>
                <ul>
                    <?php foreach ($errors as $e): ?>
                        <li><?php echo htmlspecialchars($e, ENT_QUOTES, 'UTF-8'); ?></li>
                    <?php endforeach; ?>
                </ul>
                <button onclick="history.back();">戻る</button>
            </div>
        <?php else: ?>

        <!-- ---------------------------------------------------
             表示用テーブル
             左列：項目名
             右列：contact.php から送信された内容を表示
           --------------------------------------------------- -->
        <form action="send.php" method="post">
            <table>
                <tr>
                    <td>お名前</td>
                    <td><?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
                <tr>
                    <td>会社名</td>
                    <td><?php echo htmlspecialchars($company, ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
                <tr>
                    <td>メールアドレス</td>
                    <td><?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
                <tr>
                    <td>年齢</td>
                    <td><?php echo htmlspecialchars($age, ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
                <tr>
                    <td>お問い合わせ内容</td>
                    <td><?php echo nl2br(htmlspecialchars($inquiry, ENT_QUOTES, 'UTF-8')); ?></td>
                </tr>
            </table>

            <!-- ---------------------------------------------------
                 send.php に値を送る hidden（非表示）タグ
               --------------------------------------------------- -->
             <input type="hidden" name="from_confirm" value="1">
    <input type="hidden" name="name" value="<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>">
    <input type="hidden" name="company" value="<?php echo htmlspecialchars($company, ENT_QUOTES, 'UTF-8'); ?>">
    <input type="hidden" name="email" value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>">
    <input type="hidden" name="age" value="<?php echo htmlspecialchars($age, ENT_QUOTES, 'UTF-8'); ?>">
    <input type="hidden" name="inquiry" value="<?php echo htmlspecialchars($inquiry, ENT_QUOTES, 'UTF-8'); ?>">

            <br><br>

            <!-- 送信ボタン（指定通り input type="submit"） -->
            <input type="submit" value="送信">

            <!-- 戻るボタン（history.back を使用） -->
            <input type="button" value="戻る" onclick="history.back();">
        </form>

        <?php endif; ?>

    </div>

    <!-- footer（背景色が変わる） -->
    <footer id="footer">
        <button id="changeColorBtn" onclick="changeFooterColor()">押してみてね！</button>
    </footer>
    <script src="style.js"></script>
</body>
</html>
