<?php
// ============================================
// contact.php（お問い合わせ入力画面）
// バックエンド処理付き
// ============================================

// -------------------------------
// 入力値の初期化
// -------------------------------
$name = "";
$company = "";
$email = "";
$age = "";
$message = "";
$errors = [];

// -------------------------------
// POSTで送信されたときのみ処理
// -------------------------------
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name    = $_POST["name"] ?? "";
    $company = $_POST["company"] ?? "";
    $email   = $_POST["email"] ?? "";
    $age     = $_POST["age"] ?? "";
    $message = $_POST["message"] ?? "";

    // ▼ 必須項目チェック
    if ($name === '') {
        $errors[] = "お名前を入力してください。";
    }
    if ($email === '') {
        $errors[] = "メールアドレスを入力してください。";
    }
    if ($message === '') {
        $errors[] = "お問い合わせ内容を入力してください。";
    }

    // ▼ エラーがなければ confirm.php へ POST転送
    if (empty($errors)) {
        ?>
        <form id="confirmForm" action="confirm.php" method="post">
            <input type="hidden" name="name" value="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>">
            <input type="hidden" name="company" value="<?= htmlspecialchars($company, ENT_QUOTES, 'UTF-8') ?>">
            <input type="hidden" name="email" value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>">
            <input type="hidden" name="age" value="<?= htmlspecialchars($age, ENT_QUOTES, 'UTF-8') ?>">
            <input type="hidden" name="inquiry" value="<?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>">
        </form>
        <script>
            document.getElementById("confirmForm").submit();
        </script>
        <?php
        exit();
    }

} else {
    // 初回アクセス
    $name = $company = $email = $age = $message = "";
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>お問い合わせフォーム</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="contact">

    <!-- ==============================
         ヘッダー
         ============================== -->
    <header>
        <h2>お問い合わせフォーム</h2>
    </header>

    <!-- ==============================
         サイドバー
         ============================== -->
    <div class="sidebar">
        <ul>
            <li><a href="index.php">トップページ</a></li>
            <li><a href="popular.php">人気投稿</a></li>
            <li><a href="products.php">エンジニアおすすめ商品</a></li>
            <li><a href="articles.php">エンジニアおすすめ記事</a></li>
            <li><a href="post.php">投稿ページ</a></li>
        </ul>
    </div>

    <!-- ==============================
         メインコンテンツ
         ============================== -->
    <main>

        <!-- ▼エラー表示 -->
        <?php if (!empty($errors)) : ?>
            <div class="error">
                <?php foreach ($errors as $e): ?>
                    ・<?php echo htmlspecialchars($e, ENT_QUOTES, 'UTF-8'); ?><br>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- ▼フォーム本体 -->
        <form action="contact.php" method="post">
            <table>
                <tr>
                    <td>お名前</td>
                    <td><input type="text" name="name" value="<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>"></td>
                </tr>
                <tr>
                    <td>会社名</td>
                    <td><input type="text" name="company" value="<?php echo htmlspecialchars($company, ENT_QUOTES, 'UTF-8'); ?>"></td>
                </tr>
                <tr>
                    <td>メールアドレス</td>
                    <td><input type="email" name="email" value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>"></td>
                </tr>
                <tr>
                    <td>年齢</td>
                    <td><input type="number" name="age" min="0" max="120" value="<?php echo htmlspecialchars($age, ENT_QUOTES, 'UTF-8'); ?>"></td>
                </tr>
                <tr>
                    <td>お問い合わせ内容</td>
                    <td>
                        <textarea name="message" rows="5" placeholder="お問い合わせ"><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </td>
                </tr>
            </table>

            <input type="submit" value="確認画面へ">
        </form>

    </main>
    <!-- footer（背景色が変わる） -->
    <footer>
        <button id="footerBtn">押してみてね！</button>
    </footer>
    <script src="style.js"></script>
</body>
</html>


