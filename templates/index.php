<?php

function vite(string $entry): string
{
    return "\n" . jsTag($entry)
        . "\n" . jsPreloadImports($entry)
        . "\n" . cssTag($entry);
}

function jsTag(string $entry): string
{
    $url = assetUrl($entry);

    if (!$url) {
        return '';
    }

    return '<script type="module" src="/' . $url . '"></script>';
}

function jsPreloadImports(string $entry): string
{
    $res = '';
    foreach (importsUrls($entry) as $url) {
        $res .= '<link rel="modulepreload" href="/'
            . $url
            . '">';
    }
    return $res;
}

function cssTag(string $entry): string
{
    $tags = '';
    foreach (cssUrls($entry) as $url) {
        $tags .= '<link rel="stylesheet" href="/'
            . $url
            . '">';
    }
    return $tags;
}


// Helpers to locate files

function getManifest(): array
{
    $content = file_get_contents(__DIR__ . '/../public/manifest.json');
    return json_decode($content, true);
}

function assetUrl(string $entry): string
{
    $manifest = getManifest();

    return isset($manifest[$entry])
        ? $manifest[$entry]['file']
        : '';
}

function importsUrls(string $entry): array
{
    $urls = [];
    $manifest = getManifest();

    if (!empty($manifest[$entry]['imports'])) {
        foreach ($manifest[$entry]['imports'] as $imports) {
            $urls[] = $manifest[$imports]['file'];
        }
    }
    return $urls;
}

function cssUrls(string $entry): array
{
    $urls = [];
    $manifest = getManifest();

    if (!empty($manifest[$entry]['css'])) {
        foreach ($manifest[$entry]['css'] as $file) {
            $urls[] = $file;
        }
    }
    return $urls;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Postal codes</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons&yav=40bde127">
</head>

<body>
  <div id="app"></div>
  <?= vite('assets/js/app.js') ?>
</body>
</html>
