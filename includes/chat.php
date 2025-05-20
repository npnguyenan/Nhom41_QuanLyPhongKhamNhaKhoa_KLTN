<!-- chat.php -->
<style>
#chat-container {
    position: fixed;
    bottom: 25px;
    right: 25px;
    width: 320px;
    max-height: 450px;
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    z-index: 9999;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    transition: box-shadow 0.3s ease;
}

#chat-container:hover {
    box-shadow: 0 12px 36px rgba(0, 0, 0, 0.25);
}

#chat-header {
    background: linear-gradient(135deg, #6a82fb,rgb(42, 91, 251));
    color: white;
    padding: 14px;
    cursor: pointer;
    font-weight: 700;
    text-align: center;
    font-size: 18px;
    border-top-left-radius: 20px;
    border-top-right-radius: 20px;
    user-select: none;
}

#chat-body {
    display: none;
    flex-grow: 1;
    padding: 15px;
    overflow-y: auto;
    max-height: 340px;
    font-size: 14px;
    line-height: 1.4;
    color: #333;
}

#chat-body p {
    margin: 8px 0;
    padding: 8px 12px;
    border-radius: 15px;
    max-width: 75%;
    word-wrap: break-word;
}

#chat-body p strong {
    font-weight: 600;
}

#chat-body p.user {
    background-color: #e0f7fa;
    align-self: flex-start;
}

#chat-body p.admin {
    background-color: #ffd6d6;
    align-self: flex-end;
}

#chat-form {
    display: none;
    padding: 12px 15px;
    border-top: 1px solid #eee;
    background: #fafafa;
    border-bottom-left-radius: 20px;
    border-bottom-right-radius: 20px;
    display: flex;
    gap: 10px;
}

#chat-form input[type="text"] {
    flex-grow: 1;
    padding: 10px 15px;
    border-radius: 20px;
    border: 1px solid #ccc;
    font-size: 14px;
    outline: none;
    transition: border-color 0.3s ease;
}

#chat-form input[type="text"]:focus {
    border-color: #6a82fb;
    box-shadow: 0 0 5px #6a82fb;
}

#chat-form button {
    background: #fc5c7d;
    border: none;
    padding: 10px 18px;
    border-radius: 20px;
    color: white;
    font-weight: 700;
    cursor: pointer;
    transition: background 0.3s ease;
    font-size: 13px;
}

#chat-form button:hover {
    background: #e74262;
}
</style>

<div id="chat-container">
    <div id="chat-header">💬 Hỗ trợ khách hàng</div>
    <div id="chat-body"></div>
    <form id="chat-form">
        <input type="hidden" name="sender" value="user">
        <input type="text" name="message" id="message" placeholder="Nhập tin nhắn..." required>
        <button type="submit">Gửi</button>
    </form>
</div>

<script>
    const header = document.getElementById('chat-header');
    const body = document.getElementById('chat-body');
    const form = document.getElementById('chat-form');

    let isOpen = false;

    header.addEventListener('click', function () {
        isOpen = !isOpen;
        body.style.display = isOpen ? 'block' : 'none';
        form.style.display = isOpen ? 'flex' : 'none';
    });

    document.getElementById('chat-form').addEventListener('submit', function (e) {
        e.preventDefault();
        const form = e.target;
        const input = form.message;
        const msg = input.value;

        if (!msg.trim()) return;

        // Hiển thị tin nhắn người dùng
        body.innerHTML += `<p class="user">${msg}</p>`;
        input.value = '';

        // Gửi đến AI
        fetch('includes/ai_reply.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'message=' + encodeURIComponent(msg)
        })
        .then(res => res.text())
        .then(reply => {
            body.innerHTML += `<p class="admin">${reply}</p>`;
            body.scrollTop = body.scrollHeight;
        });
    });

    // Không cần auto reload từ DB nếu dùng AI
</script>
