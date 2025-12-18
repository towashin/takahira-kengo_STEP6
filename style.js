// =============================================================
//  contact.php / confirm.php / send.php の共通バリデーション
// =============================================================

document.addEventListener("DOMContentLoaded", function () {

        /* ==============================
        フッター背景色変更処理
           ============================== */
        const footer = document.querySelector("footer");
        const footerBtn = document.getElementById("footerBtn");
           
        if (footer && footerBtn) {
        const colors = ["blue", "red", "yellow", "gray"];
        let colorIndex = 0;
           
        footerBtn.addEventListener("click", function () {
        footer.style.backgroundColor = colors[colorIndex];
        colorIndex = (colorIndex + 1) % colors.length;
        });
    }
    // ページ内にフォームが存在しない場合は処理しない
    const form = document.querySelector("form");
    if (!form) return;

    form.addEventListener("submit", function (e) {

        // ---------------------------------------------------------
        // 各入力フィールド取得
        // contact.php → テキストボックス
        // confirm.php → hiddenフィールド
        // send.php → hidden（メール送信用）
        // ---------------------------------------------------------
        const name = document.querySelector("[name='name']");
        const company = document.querySelector("[name='companyname'], [name='company']");
        const email = document.querySelector("[name='email']");
        const age = document.querySelector("[name='age']");
        const message = document.querySelector("[name='message'], [name='inquiry']");

        // エラーメッセージ表示部分（なければ作る）
        let errorBox = document.querySelector(".js-error-box");
        if (!errorBox) {
            errorBox = document.createElement("div");
            errorBox.classList.add("js-error-box");
            errorBox.style.color = "red";
            errorBox.style.fontWeight = "bold";
            errorBox.style.marginBottom = "20px";
            form.prepend(errorBox);
        }

        errorBox.textContent = ""; // 初期化

        // ---------------------------------------------------------
        // 必須項目のチェック
        // ---------------------------------------------------------
        if (
            !name || name.value.trim() === "" ||
            !company || company.value.trim() === "" ||
            !email || email.value.trim() === "" ||
            !age || age.value.trim() === "" ||
            !message || message.value.trim() === ""
        ) {
            e.preventDefault(); // 送信キャンセル
            errorBox.textContent = "必須項目が未入力です。入力内容をご確認ください。";
            return;
        }

        // ---------------------------------------------------------
        // 入力内容の確認ダイアログ
        // （confirm.php と send.php では上書き確認となるが問題なし）
        // ---------------------------------------------------------
        const confirmMessage =
            "以下の内容で送信します。\n\n"
            + "お名前: " + name.value + "\n"
            + "会社名: " + company.value + "\n"
            + "メールアドレス: " + email.value + "\n"
            + "年齢: " + age.value + "\n"
            + "お問い合わせ内容:\n" + message.value + "\n\n"
            + "よろしいですか？";

        if (!confirm(confirmMessage)) {
            e.preventDefault(); // キャンセルなら送信しない
        
        }
    });
});
