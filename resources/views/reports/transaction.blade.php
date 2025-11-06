<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Transação #{{ $transaction->id }}</title>
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
        <div class="company">Relatório de transação</div>
        <div class="muted">Finance Manager</div>
    </div>

    <table class="table">
        <tr>
            <th>Id</th>
            <td>{{ $transaction->id }}</td>
            <th>Data</th>
            <td>{{ \Carbon\Carbon::parse($transaction->date)->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <th>Descrição</th>
            <td colspan="3">{{ $transaction->description }}</td>
        </tr>
        <tr>
            <th>Categoria</th>
            <td>{{ $transaction->category ? $transaction->category->name : '—' }}</td>
            <th>Tipo</th>
            <td>
                {{ $transaction->type === 'income' ? 'Receita' : ($transaction->type === 'expense' ? 'Despesa' : ucfirst($transaction->type)) }}
            </td>
        </tr>
        <tr>
            <th>Valor</th>
            <td colspan="3" class="right">
                R$ {{ number_format($transaction->amount, 2, ',', '.') }}
            </td>
        </tr>
        @if(!empty($transaction->notes))
        <tr>
            <th>Observações</th>
            <td colspan="3">{{ $transaction->notes }}</td>
        </tr>
        @endif
    </table>

    <div class="footer">
        Emitido por: {{ auth()->user()->name ?? 'Usuário' }} — {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>
