<?= $this->include('/dashboard/top') ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="<?= base_url() ?>dashboard/js/naujandata.js"></script>
    <style>
        #map {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 20px;
            /* Adjust the value to add space on the left side */
            right: 0;
        }
    </style>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GIS</title>
</head>

<body>
    <?= $this->include('/admin_dashboard/navbar') ?>
    <?= $this->include('/admin_dashboard/topbar') ?>
    <?= $this->include('/admin_dashboard/top') ?>


    <div id="map"></div>
    <script>
        var map = L.map('map').setView([13.27934, 121.300003], 13);


        L.tileLayer('https://api.maptiler.com/maps/streets-v2/256/{z}/{x}/{y}.png?key=UDQzhd8KRiaw4SHIFez9', {
            attribution: '<a href="https://www.maptiler.com/copyright/" target="_blank">&copy; MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">&copy; OpenStreetMap contributors</a>',
        }).addTo(map);
        var naujanData = L.geoJSON(naujandata).addTo(map);

        //marker
        var markersData = [{
                lat: 13.2953,
                lng: 121.3227,
                barangay_name: 'Barangay Kalinisan',
                variety: <?= json_encode($varietyData[0]) ?>
            },
            {
                lat: 13.3223,
                lng: 121.3113,
                barangay_name: 'Barangay Strella',
                variety: <?= json_encode($varietyData[1]) ?>
            }

        ];

        markersData.forEach(function(data) {
            var marker = L.marker([data.lat, data.lng]).addTo(map);


            var varietyName = data.variety.variety_name;


            marker.bindPopup('Barangay: ' + data.barangay_name + '<br>Variety: ' + varietyName);
        });
        googleStreets = L.tileLayer('http://{s}.google.com/vt?lyrs=m&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        });
        googleStreets.addTo(map);

        // googleTerrain = L.tileLayer('http://{s}.google.com/vt?lyrs=p&x={x}&y={y}&z={z}', {
        //  maxZoom: 20,
        //subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        //});
        googleTerrain.addTo(map);
    </script>


</body>

</html>