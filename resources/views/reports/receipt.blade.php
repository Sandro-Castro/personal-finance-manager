<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8"/>
    <title>Recibo do comprovante: {{ $receipt->title }}</title>
    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 12px;
            color: #222;
            margin: 40px;
        }

        .header {
            text-align: left;
            margin-bottom: 20px;
        }

        .company {
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 2px;
        }

        .muted {
            color: #666;
            font-size: 11px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        .table th {
            background: #f3f3f3;
        }

        .right {
            text-align: right;
        }

        .image-section {
            margin-top: 20px;
            text-align: left;
        }

        .image-section h4 {
            margin-bottom: 10px;
        }

        .image-section img {
            max-width: 100%;
            max-height: 400px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .footer {
            margin-top: 18px;
            font-size: 11px;
            color: #666;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company">Relatório de recibo</div>
        <div class="muted">Finance Manager</div>
    </div>

    <table class="table">
        <tr>
            <th>Id</th><td>{{ $receipt->id }}</td>
            <th>Data</th><td>{{ \Carbon\Carbon::parse($receipt->date)->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <th>Descrição</th><td colspan="3">{{ $receipt->description }}</td>
        </tr>
        <tr>
            <th>Categoria</th>
            <td>{{ $receipt->category ? $receipt->category->name : '—' }}</td>
            <th>Valor</th>
            <td class="right">R$ {{ number_format($receipt->amount, 2, ',', '.') }}</td>
        </tr>
        @if(!empty($receipt->notes))
        <tr>
            <th>Observações</th><td colspan="3">{{ $receipt->notes }}</td>
        </tr>
        @endif
    </table>

    @if($receipt->image_path)
    <div class="image-section">
        <h4>Imagem do Comprovante</h4>
        <img src="{{ public_path('storage/' . $receipt->image_path) }}">
    </div>
    @endif

    <div class="footer">
        Emitido por: {{ auth()->user()->name ?? 'Usuário' }} — {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>
