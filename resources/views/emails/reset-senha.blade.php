<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f1f5f9; margin: 0; padding: 20px; }
        .email-card { max-width: 450px; margin: 20px auto; background: #ffffff; padding: 40px; border-radius: 25px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1); text-align: center; }
        .logo { font-size: 2rem; font-weight: 800; color: #2563eb; margin-bottom: 20px; }
        .logo span { color: #7dd3fc; }
        .title { font-size: 1.5rem; color: #0f172a; margin-bottom: 15px; }
        .text { color: #64748b; line-height: 1.6; margin-bottom: 30px; }
        .button { background: #2563eb; color: #ffffff !important; padding: 16px 30px; text-decoration: none; border-radius: 15px; font-weight: 700; display: inline-block; transition: 0.3s; }
        .button:hover { background: #1d4ed8; transform: translateY(-2px); }
        .footer { margin-top: 30px; font-size: 0.75rem; color: #94a3b8; }
    </style>
</head>
<body>
    <div class="email-card">
        <div class="logo">CRO<span>NOS</span></div>
        <div class="title">Redefinição de Senha</div>
        <p class="text">Olá! Recebemos uma solicitação para alterar a senha da sua conta no CRONOS. Se foi você, basta clicar no botão abaixo:</p>
        
        <a href="{{ $link }}" class="button">Redefinir minha senha</a>
        
        <p class="footer">Se você não solicitou esta alteração, ignore este e-mail por segurança.</p>
    </div>
</body>
</html>