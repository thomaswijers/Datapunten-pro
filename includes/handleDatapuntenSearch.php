<?php
$datapuntenPath = __DIR__ . '/../data/datapunten.json';
$cursussenPath = __DIR__ . '/../data/cursussen.json';

if (!file_exists($datapuntenPath) || !file_exists($cursussenPath)) {
    die("Error: Required JSON file not found.");
}

$datapunten = json_decode(file_get_contents($datapuntenPath), true);
$cursussen = json_decode(file_get_contents($cursussenPath), true);

$searchQuery = isset($_GET['search']) ? strtolower($_GET['search']) : '';

// Step 1: Sort cursussen by 'order'
usort($cursussen, fn($a, $b) => $a['order'] <=> $b['order']);

// Step 2: Group datapunten by cursus title (only if they match the search)
$groupedDatapunten = [];

foreach ($cursussen as $cursus) {
    $cursusTitle = $cursus['title'];

    // Filter datapunten for this cursus
    $filtered = array_filter($datapunten, function ($dp) use ($cursusTitle, $searchQuery) {
        $matchesCursus = isset($dp['cursus']) && $dp['cursus'] === $cursusTitle;
        $matchesSearch = !$searchQuery || stripos($dp['title'], $searchQuery) !== false;
        return $matchesCursus && $matchesSearch;
    });

    if (!empty($filtered)) {
        // Sort datapunten inside the group by their own 'order'
        usort($filtered, fn($a, $b) => $a['order'] <=> $b['order']);
        $groupedDatapunten[$cursusTitle] = array_values($filtered);
    }
}

// Output JSON
header('Content-Type: application/json');
echo json_encode($groupedDatapunten);
