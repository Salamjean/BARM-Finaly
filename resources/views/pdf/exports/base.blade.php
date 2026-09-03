<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Document PDF' }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #333;
            margin: 0;
            padding: 15px;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border-bottom: 2px solid #001B63;
            padding-bottom: 10px;
        }
        .header-table td {
            border: none !important;
            padding: 0;
        }
        .app-title {
            font-size: 18px;
            font-weight: bold;
            color: #001B63;
        }
        .doc-title {
            font-size: 14px;
            font-weight: bold;
            color: #2c3e50;
            margin-top: 4px;
        }
        .meta-info {
            font-size: 10px;
            color: #666;
            text-align: right;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table.data-table th {
            background-color: #001B63;
            color: #ffffff;
            font-weight: bold;
            padding: 7px 5px;
            font-size: 10px;
            text-align: left;
            border: 1px solid #001B63;
        }
        table.data-table td {
            padding: 5px;
            border: 1px solid #ddd;
            font-size: 9px;
        }
        table.data-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 25px;
            font-size: 9px;
            color: #888;
            text-align: center;
            border-top: 1px solid #eee;
            padding-top: 8px;
        }
    </style>
</head>
<body>
    <table class="header-table">
        <tr>
            <td style="width: 65%;">
                <div class="app-title">BARM - Bureau d'Accompagnement et de Reconversion des Militaires</div>
                <div class="doc-title">{{ $title }}</div>
            </td>
            <td class="meta-info" style="width: 35%;">
                <div><strong>Date d'extraction :</strong> {{ date('d/m/Y H:i') }}</div>
                <div><strong>Total :</strong> {{ $total ?? (isset($items) ? count($items) : 0) }}</div>
            </td>
        </tr>
    </table>

    @yield('pdf_content')

    <div class="footer">
        Document officiel généré par l'application BARM - {{ date('d/m/Y H:i:s') }}
    </div>
</body>
</html>
