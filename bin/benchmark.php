<?php

/**
 * Benchmarker of HTTP Latency
 * 
 * Use: php benchmark.php [URL] [--requests=N] [--concurrency=N] [--output=json]
 */

$defaultOptions = [
  'requests'    => 100,
  'concurrency' => 10,
  'timeout'     => 10,
  'output'      => 'text' // or 'json'
];

$options = getopt('', ['requests:', 'concurrency:', 'timeout:', 'output::', 'help']);
$url = $argv[1] ?? null;

if (isset($options['help']) || !$url) {
  echo "Use: php " . basename(__FILE__) . " URL [OPTIONS]\n\n";
  echo "Options:\n";
  echo "  --requests=N     Total number of requests (default: {$defaultOptions['requests']})\n";
  echo "  --concurrency=N  Concurrency level (default: {$defaultOptions['concurrency']})\n";
  echo "  --timeout=N      Timeout in seconds (default: {$defaultOptions['timeout']})\n";
  echo "  --output=json    Output in JSON format\n";
  echo "  --help           Show this help\n";
  exit(1);
}

$config = array_merge($defaultOptions, [
  'requests'    => $options['requests'] ?? $defaultOptions['requests'],
  'concurrency' => $options['concurrency'] ?? $defaultOptions['concurrency'],
  'timeout'     => $options['timeout'] ?? $defaultOptions['timeout'],
  'output'      => $options['output'] ?? $defaultOptions['output']
]);

if (!filter_var($url, FILTER_VALIDATE_URL)) {
  die("Error: Invalid URL.\n");
}

$mh = curl_multi_init();
$handles = [];
$results = [
  'success' => 0,
  'errors' => 0,
  'times' => [],
  'start_time' => microtime(true)
];

for ($i = 0; $i < $config['concurrency']; $i++) {
  addRequest($mh, $handles, $url, $config['timeout']);
}

$completed = 0;
do {
  while (($execrun = curl_multi_exec($mh, $running)) == CURLM_CALL_MULTI_PERFORM);
  if ($execrun != CURLM_OK) break;

  while ($done = curl_multi_info_read($mh)) {
    $handle = $done['handle'];
    $info = curl_getinfo($handle);
    $error = curl_error($handle);

    if ($error || $info['http_code'] != 200) {
      $results['errors']++;
    } else {
      $results['success']++;
      $results['times'][] = $info['total_time'];
    }

    curl_multi_remove_handle($mh, $handle);
    curl_close($handle);
    $completed++;

    if ($completed < $config['requests']) {
      addRequest($mh, $handles, $url, $config['timeout']);
    }
  }

  if ($running) {
    curl_multi_select($mh);
  }
} while ($running && $completed < $config['requests']);

curl_multi_close($mh);

$results['total_time'] = microtime(true) - $results['start_time'];
$results['requests_per_second'] = $results['success'] / $results['total_time'];
$results['avg_time'] = array_sum($results['times']) / count($results['times']);
sort($results['times']);
$results['min_time'] = $results['times'][0];
$results['max_time'] = end($results['times']);
$results['p95'] = $results['times'][(int)(count($results['times']) * 0.95)];

if ($config['output'] === 'json') {
  header('Content-Type: application/json');
  echo json_encode($results, JSON_PRETTY_PRINT);
} else {
  echo "Benchmark Results:\n";
  echo "=======================\n";
  echo "URL: {$url}\n";
  echo "Total requests: {$config['requests']}\n";
  echo "Concurrency: {$config['concurrency']}\n";
  echo "Total time: " . round($results['total_time'], 3) . " segundos\n";
  echo "Requests per second:" . round($results['requests_per_second'], 2) . "\n";
  echo "Success: {$results['success']}\n";
  echo "Errors: {$results['errors']}\n";
  echo "Average time: " . round($results['avg_time'] * 1000, 2) . " ms\n";
  echo "Min Time: " . round($results['min_time'] * 1000, 2) . " ms\n";
  echo "Max Time: " . round($results['max_time'] * 1000, 2) . " ms\n";
  echo "95th percentile: " . round($results['p95'] * 1000, 2) . " ms\n";
}

function addRequest(&$mh, &$handles, $url, $timeout)
{
  $ch = curl_init();
  curl_setopt_array($ch, [
    CURLOPT_URL            => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_MAXREDIRS      => 3,
    CURLOPT_TIMEOUT        => $timeout,
    CURLOPT_CONNECTTIMEOUT => $timeout,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_HEADER         => false,
    CURLOPT_USERAGENT      => 'LatencyBenchmark/1.0'
  ]);
  curl_multi_add_handle($mh, $ch);
  $handles[] = $ch;
}
