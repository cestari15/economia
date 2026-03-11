<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #000c17; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 20px auto; background-color: #001529; border: 1px solid #1e3a5a; border-radius: 12px; overflow: hidden; }
        .header { background-color: #000c17; padding: 30px; text-align: center; border-bottom: 2px solid #2563eb; }
        .header h1 { color: #fff; margin: 0; font-size: 24px; letter-spacing: 2px; }
        .header span { color: #00d4ff; }
        .content { padding: 40px; color: #e2e8f0; line-height: 1.6; }
        .event-box { background: rgba(37, 99, 235, 0.1); border-left: 4px solid #2563eb; padding: 20px; margin: 25px 0; border-radius: 4px; }
        .footer { padding: 20px; text-align: center; font-size: 12px; color: #64748b; background: #000c17; }
        .btn { display: inline-block; padding: 12px 25px; background-color: #2563eb; color: #fff; text-decoration: none; border-radius: 8px; font-weight: bold; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>CRO<span>NOS</span></h1>
        </div>
        <div class="content">
            <h2 style="color: #fff;">Olá, {{ $nome }}!</h2>
            <p>Este é um lembrete automático do seu sistema de gestão financeira.</p>
            
            <div class="event-box">
                <strong style="color: #00d4ff; display: block; margin-bottom: 5px;">COMPROMISSO:</strong>
                <span style="font-size: 18px; color: #fff;">{{ $tituloEvento }}</span>
                <br>
                <strong style="color: #00d4ff; display: block; margin-top: 15px;">DATA DO VENCIMENTO:</strong>
                <span style="color: #fff;">{{ $dataEvento }}</span>
            </div>

            <p>Preparamos este aviso para que você possa se organizar com antecedência.</p>
            
            <a href="{{ config('app.url') }}/calendario" class="btn">Abrir meu Calendário</a>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} CRONOS - Gestão Inteligente de Tempo e Economia.
        </div>
    </div>
</body>
</html>