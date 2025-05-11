<?php
// Load the datapunten and cursussen data
$datapuntenPath = __DIR__ . '/../data/datapunten.json';
$cursussenPath = __DIR__ . '/../data/cursussen.json';

if (!file_exists($datapuntenPath)) {
    die("Error: datapunten.json file not found.");
}

if (!file_exists($cursussenPath)) {
    die("Error: cursussen.json file not found.");
}

// Read and decode JSON data
$datapunten = json_decode(file_get_contents($datapuntenPath), true);
$cursussen = json_decode(file_get_contents($cursussenPath), true);

// If a search query is present, filter the datapunten
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchQuery = strtolower($_GET['search']);
    $datapunten = array_filter($datapunten, function ($datapunt) use ($searchQuery) {
        return strpos(strtolower($datapunt['title']), $searchQuery) !== false;
    });
}

// Sort the cursussen (courses) by their order field
usort($cursussen, function ($a, $b) {
    return $a['order'] - $b['order'];
});

// Group the datapunten by cursus title
$groupedDatapunten = [];
foreach ($datapunten as $datapunt) {
    $groupedDatapunten[$datapunt['cursus']][] = $datapunt;
}

// Sort each group of datapunten by their order field
foreach ($groupedDatapunten as $cursusTitle => $datapuntenGroup) {
    usort($datapuntenGroup, function ($a, $b) {
        return $a['order'] - $b['order'];
    });
    $groupedDatapunten[$cursusTitle] = $datapuntenGroup;
}

// Return the grouped datapunten by cursus in JSON format
echo json_encode($groupedDatapunten);
