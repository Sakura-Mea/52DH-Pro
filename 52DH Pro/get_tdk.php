<?php
// get_tdk.php
// 用法: get_tdk.php?url=https://example.com
header('Content-Type: application/json; charset=UTF-8');

$rawUrl = trim($_GET['url'] ?? '');
if (!$rawUrl) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'Missing url']);
    exit;
}

// 补齐 http 前缀
if (!preg_match('~^https?://~i', $rawUrl)) {
    $rawUrl = 'http://' . $rawUrl;
}
$urlParts = parse_url($rawUrl);
if (!$urlParts || empty($urlParts['host'])) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'Invalid URL']);
    exit;
}

// cURL 获取 HTML
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $rawUrl,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_MAXREDIRS => 5,
    CURLOPT_TIMEOUT => 10,
    CURLOPT_CONNECTTIMEOUT => 5,
    CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_ACCEPT_ENCODING => 'gzip, deflate',
    CURLOPT_HEADER => false,
]);
$html = curl_exec($ch);
$finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$err = curl_error($ch);
curl_close($ch);

if ($html === false || !$html || $httpCode >= 400) {
    http_response_code(502);
    echo json_encode(['ok' => false, 'error' => 'Fetch failed', 'detail' => $err, 'code' => $httpCode]);
    exit;
}

// 解析 HTML
libxml_use_internal_errors(true);
$dom = new DOMDocument();
$encoding = null;
if (preg_match('/<meta[^>]+charset=([^"'\s>]+)/i', $html, $m)) {
    $encoding = trim($m[1], ""'");
}
if ($encoding && stripos($encoding, 'utf') === false) {
    $html = mb_convert_encoding($html, 'HTML-ENTITIES', $encoding);
}
$dom->loadHTML($html);
$xpath = new DOMXPath($dom);

// title
$title = '';
$nodes = $xpath->query('//title');
if ($nodes && $nodes->length) $title = trim($nodes->item(0)->textContent);

// description
$description = '';
foreach (['meta[@name="description"]', 'meta[@property="og:description"]', 'meta[@name="Description"]'] as $q) {
    $nodeList = $xpath->query('//' . $q);
    if ($nodeList && $nodeList->length) {
        $description = trim($nodeList->item(0)->getAttribute('content'));
        if ($description) break;
    }
}

// keywords
$keywords = '';
foreach (['meta[@name="keywords"]', 'meta[@name="Keywords"]'] as $q) {
    $nodeList = $xpath->query('//' . $q);
    if ($nodeList && $nodeList->length) {
        $keywords = trim($nodeList->item(0)->getAttribute('content'));
        if ($keywords) break;
    }
}

// og:title
if (!$title) {
    $ogt = $xpath->query('//meta[@property="og:title"]');
    if ($ogt && $ogt->length) $title = trim($ogt->item(0)->getAttribute('content'));
}

// favicon
$favicon = '';
$favNodes = $xpath->query('//link[contains(translate(@rel, "ICON", "icon"), "icon") and @href]');
if ($favNodes && $favNodes->length) {
    $favicon = $favNodes->item(0)->getAttribute('href');
}
$base = parse_url($finalUrl ?: $rawUrl);
$origin = ($base['scheme'] ?? 'http') . '://' . ($base['host'] ?? '');
if ($favicon) {
    if (strpos($favicon, '//') === 0) {
        $favicon = ($base['scheme'] ?? 'http') . ':' . $favicon;
    } elseif (!preg_match('~^https?://~i', $favicon)) {
        if (substr($favicon, 0, 1) !== '/') {
            $path = isset($base['path']) ? preg_replace('~/[^/]*$~', '/', $base['path']) : '/';
            $favicon = $origin . $path . $favicon;
        } else {
            $favicon = $origin . $favicon;
        }
    }
} else {
    $favicon = $origin . '/favicon.ico';
}

$host = $base['host'] ?? ($urlParts['host'] ?? '');

echo json_encode([
    'ok' => true,
    'title' => $title ?: $host,
    'description' => $description,
    'keywords' => $keywords,
    'favicon' => $favicon,
    'url' => $finalUrl ?: $rawUrl,
    'host' => $host,
    'code' => $httpCode,
], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
