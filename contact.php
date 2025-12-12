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
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["from_confirm"])) {
    $name        = $_POST["name"] ?? "";
    $companyname = $_POST["companyname"] ?? "";
    $email       = $_POST["email"] ?? "";
    $age         = $_POST["age"] ?? "";
    $message     = $_POST["message"] ?? "";
} else {
    // 初回アクセスの場合は必ず空にする
    $name = $companyname = $email = $age = $message = "";
}

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
            <input type="hidden" name="name" value="<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="company" value="<?php echo htmlspecialchars($company, ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="age" value="<?php echo htmlspecialchars($age, ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="inquiry" value="<?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>">
        </form>
        <script>
            // confirm.php に自動転送
            document.getElementById("confirmForm").submit();
        </script>
        <?php
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>お問い合わせフォーム</title>
    <link rel="stylesheet" href="style.css">

    <style>
        /* ==============================
           ページ全体のレイアウト設定
           ============================== */
        body {
            font-family: "Helvetica Neue", Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: grid;
            grid-template-columns: 200px 1fr;
            grid-template-rows: auto 1fr auto;
            grid-template-areas:
                "header header"
                "sidebar main"
                "footer footer";
            min-height: 100vh;
        }

        /* ==============================
           エラー表示
           ============================== */
        .error {
            color: red;
            font-weight: bold;
            margin-bottom: 20px;
        }

        /* ==============================
           ヘッダー部分
           ============================== */
        header {
            grid-area: header;
            background-color: #f8f9fa;
            text-align: center;
            padding: 15px 0;
            border-bottom: 2px solid #ccc;
        }

        /* ==============================
           サイドバー部分
           ============================== */
        sidebar {
            grid-area: sidebar;
            background-color: #f0f0f0;
            padding: 20px;
            border-right: 2px solid #ccc;
        }

        sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        sidebar ul li {
            margin-bottom: 15px;
        }

        sidebar ul li a {
            text-decoration: none;
            color: #007BFF;
        }

        /* ==============================
           メイン（フォーム部分）
           ============================== */
        main {
            grid-area: main;
            padding: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 600px;
            border: 3px solid #333;
        }

        th, td {
            border: 3px solid #333;
            padding: 10px;
            vertical-align: middle;
        }

        td:first-child {
            width: 150px;
            background-color: #f7f7f7;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="number"],
        textarea {
            width: 95%;
            padding: 8px;
            box-sizing: border-box;
        }

        textarea::placeholder {
            color: #999;
        }

        input[type="submit"] {
            margin-top: 15px;
            padding: 8px 16px;
            font-size: 14px;
            cursor: pointer;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
        }

        /* ==============================
           フッター部分
           ============================== */
        footer {
            grid-area: footer;
            text-align: center;
            padding: 20px;
            background-color: #ddd;
            border-top: 2px solid #ccc;
            transition: background-color 0.3s ease;
        }

        footer button {
            background-color: #ff9800;
            border: none;
            padding: 10px 20px;
            color: white;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
        }
    </style>
</head>
<body>

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
    <sidebar>
        <ul>
            <li><a href="index.php">トップページ</a></li>
            <li><a href="popular.php">人気投稿</a></li>
            <li><a href="products.php">エンジニアおすすめ商品</a></li>
            <li><a href="articles.php">エンジニアおすすめ記事</a></li>
            <li><a href="post.php">投稿ページ</a></li>
        </ul>
    </sidebar>

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

    <!-- ==============================
         フッター（背景色が変わるボタン付き）
         ============================== -->
    <footer>
        <button id="footerBtn">押してみてね！</button>
    </footer>

    <script>
        /* ==============================
           JavaScript: フッター背景色変更処理
           ============================== */
        const footer = document.querySelector("footer");
        const colors = ["blue", "red", "yellow", "gray"];
        let colorIndex = 0;

        document.getElementById("footerBtn").addEventListener("click", function() {
            footer.style.backgroundColor = colors[colorIndex];
            colorIndex = (colorIndex + 1) % colors.length;
        });
    </script>

</body>
</html>


