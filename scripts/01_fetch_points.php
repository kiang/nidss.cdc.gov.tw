<?php
$basePath = dirname(__DIR__);
file_put_contents($basePath . '/data/points.csv', file_get_contents('https://docs.google.com/spreadsheets/d/13QYwutWYw27Tbs7gKBkugIg9sWKitxC5X7RSPitMyDI/export?format=csv'));
$fh = fopen($basePath . '/data/points.csv', 'r');
$header = fgetcsv($fh, 2048);
$fc = [
    'type' => 'FeatureCollection',
    'features' => [],
];
while ($line = fgetcsv($fh, 2048)) {
    $data = array_combine($header, $line);
    if(empty($data['longitude']) || empty($data['latitude'])) {
        continue;
    }
    $feature = [
        'type' => 'Feature',
        'properties' => $data,
        'geometry' => [
            'type' => 'Point',
            'coordinates' => [
                floatval($data['longitude']), floatval($data['latitude'])
            ],
        ],
    ];
    $fc['features'][] = $feature;
}
file_put_contents(dirname(__DIR__) . '/data/points.json', json_encode($fc, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));