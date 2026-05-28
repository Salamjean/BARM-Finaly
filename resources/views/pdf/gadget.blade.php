<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Distributions</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #444;
            font-size: 2.5em;
            margin-bottom: 20px;
        }
        .distribution {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 20px;
            transition: transform 0.3s ease;
        }
        .distribution:hover {
            transform: scale(1.02);
        }
        .distribution p {
            margin: 5px 0;
        }
        .section-title {
            margin-top: 20px;
            margin-bottom: 10px;
            color: #555;
            font-size: 1.5em;
            border-bottom: 2px solid #ddd;
            padding-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
            font-size: 0.9em;
        }
        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

    </style>
</head>
<body>
    <h1>Liste des Distributions</h1>

    <div class="distribution" role="article">
        <div class="section-title">Gadget : <span aria-label="Nom du gadget">{{ $gadget->name }}</span></div>
        <p>Date : <strong>{{ date('d-m-Y') }}</strong></p>
        @php
            $qs = $gadget->distributions->pluck('quantity')->toArray();
            $sum = array_sum($qs);
        @endphp
        <p>Quantité utilisée : <strong>{{ $sum }}</strong></p>
        <p>Quantité restante : <strong>{{ $gadget->quantity }}</strong></p>

        <table class="gadget-table" aria-label="Table des distributions de gadgets">
            <thead>
                <tr>
                    <th>Date distribution</th>
                    <th>Cellule / Service</th>
                    <th>Quantité</th>
                </tr>
            </thead>
            <tbody>
                @foreach($gadget->distributions as $item)
                    <tr>
                        <td>{{ dateFr($item->distribution->created_at, 'complet') }}</td>
                        <td>{{ $item->distribution->title }}</td>
                        <td>{{ $item->quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
