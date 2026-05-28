<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>#map { height: 360px; }</style>
</head>
<body>
    <div id="map"></div>

    <div class="address-container">
        <table>
            <caption>My Address</caption>
            <tbody>
            <tr>
                <th scope="row">Pays</th>
                <td>{{ $address['country'] }}</td>
            </tr>
            <tr>
                <th scope="row">Ville</th>
                <td>{{ $address['city'] }}</td>
            </tr>
            <tr>
                <th scope="row">Operateur</th>
                <td>{{ $address['isp'] }}</td>
            </tr>
            </tbody>
        </table>
    </div>

    <style>
        .address-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%; /* Adjust width as needed */
            margin: 0 auto; /* Center horizontally */
        }

        table {
            border-collapse: collapse; /* Remove borders for cleaner look */
            width: auto; /* Allow table to adapt to content width */
            font-family: Arial, sans-serif; /* Readable font */
        }

        caption {
            padding-top: 50px;
            font-weight: bold;
            margin-bottom: 10px; /* Space between caption and table */
        }

        th,
        td {
            padding: 10px; /* Consistent padding for readability */
            border: 1px solid #ddd; /* Light border for separation */
            text-align: left; /* Align content to the left */
        }

        th {
            background-color: #f5f5f5; /* Light background for headers */
        }
    </style>
    <script src="{{ asset('assets/js/leaflet.js') }}" ></script>

    <script>
            var map = L.map('map').setView([{{$address['lat']}}, {{$address['lon']}}], 20);

        var marker = L.marker([5.35360, -4.00153]).addTo(map);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        L.marker([51.5, -0.09]).addTo(map)
            .bindPopup('A pretty CSS popup.<br> Easily customizable.')
            .openPopup();
    </script>
</body>
</html>
