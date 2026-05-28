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
            color: #2c3e50;
            font-size: 2.5em;
            margin-bottom: 20px;
            font-weight: 300;
        }
        .distribution {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            padding: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .distribution:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        .distribution p {
            margin: 10px 0;
            font-size: 1.1em;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 5px 15px;
            text-align: left;
            font-size: 0.9em;
        }
        th {
            padding: 10px 15px;
            background-color: #f4f4f4;
            font-weight: 600;
            text-transform: uppercase;
        }
        td {
            background-color: #fff;
        }
        .section-title {
            margin-top: 20px;
            margin-bottom: 20px;
            color: #555;
            font-size: 1.5em;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
            font-weight: 500;
        }
        .highlight {
            background-color: #eaf2f8;
            border-left: 5px solid #2980b9;
            padding-left: 10px;
        }
    </style>
</head>
<body>
    <h1>Liste des Distributions</h1>

    <div class="distribution">
        <p class="highlight">Référence: <strong>{{ $distribution->reference }}</strong></p>
        <div class="section-title">Cellule/Service: {{ $distribution->title }} {{ $distribution->title_subtitle ? ' | (' . $distribution->title_subtitle . ')' : '' }}</div>
        <p class="highlight">Date de Distribution: <strong>{{ dateFr($distribution->distribution_date, 'letter') }}</strong></p>

        <table class="gadget-table">
            <thead>
                <tr>
                    <th>Nom du Gadget</th>
                    <th>Quantité</th>
                </tr>
            </thead>
            <tbody>
                @foreach($distribution->distributions as $item)
                    <tr>
                        <td>{{ $item->gadget->name }}</td>
                        <td>{{ $item->quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
