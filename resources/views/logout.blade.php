<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Logout - {{ config('app.name') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .logout-container {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 400px;
        }
        .logout-icon {
            font-size: 64px;
            color: #ff9800;
            margin-bottom: 20px;
        }
        h1 {
            color: #333;
            margin-bottom: 10px;
        }
        p {
            color: #666;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        .btn-group {
            display: flex;
            gap: 10px;
            justify-content: center;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s;
            font-weight: bold;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        .btn-confirm {
            background-color: #f44336;
        }
        .btn-confirm:hover {
            background-color: #da190b;
        }
        .btn-cancel {
            background-color: #4CAF50;
        }
        .btn-cancel:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="logout-container">
        <div class="logout-icon">⚠</div>
        <h1>Confirmar Logout</h1>
        <p>Tem certeza que deseja sair do sistema?<br>Sua sessão será encerrada.</p>
        
        <div class="btn-group">
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-confirm">Sim, Sair</button>
            </form>
            <a href="{{ route('dashboard') }}" class="btn btn-cancel">Cancelar</a>
        </div>
    </div>
</body>
</html>