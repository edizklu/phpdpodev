<?php

function minJobSchedulingTime(int $n, int $m, array $processingTime, array $transitionCost): array
{
    $dp = array();
    for ($i = 0; $i < $n; $i++) {
        $dp[$i] = array();
        for ($j = 0; $j < $m; $j++) {
            $dp[$i][$j] = PHP_INT_MAX;
        }
    }

    for ($j = 0; $j < $m; $j++) {
        $dp[0][$j] = $processingTime[0][$j];
    }

    for ($i = 1; $i < $n; $i++) {
        for ($j = 0; $j < $m; $j++) {
            $minPrevTime = PHP_INT_MAX;
            for ($k = 0; $k < $m; $k++) {
                $timeFromPrev = $dp[$i-1][$k];
                if ($timeFromPrev != PHP_INT_MAX) {
                    $timeFromPrev += $transitionCost[$k][$j] + $processingTime[$i][$j];
                    $minPrevTime = min($minPrevTime, $timeFromPrev);
                }
            }
            if ($minPrevTime != PHP_INT_MAX) {
                 $dp[$i][$j] = $minPrevTime;
            }
        }
    }

    $minTotalTime = PHP_INT_MAX;
    for ($j = 0; $j < $m; $j++) {
        $minTotalTime = min($minTotalTime, $dp[$n-1][$j]);
    }

    if ($minTotalTime == PHP_INT_MAX) {
         return ["Minimum Toplam Süre: Ulaşılamaz", $dp];
    }

    return ["Minimum Toplam Süre: " . $minTotalTime, $dp];
}

$n = 3;
$m = 2;

$processingTime = [
    [3, 5],
    [4, 6],
    [2, 4]
];

$transitionCost = [
    [0, 1],
    [2, 0]
];

list($minTimeResult, $dpTable) = minJobSchedulingTime($n, $m, $processingTime, $transitionCost);

echo "İşlem Süreleri Matrisi:\n";
foreach ($processingTime as $row) {
    echo "[" . implode(", ", $row) . "]\n";
}

echo "\nGeçiş Maliyetleri Matrisi:\n";
foreach ($transitionCost as $row) {
    echo "[" . implode(", ", $row) . "]\n";
}

echo "\nDP Tablosu:\n";
echo str_pad("İş/Makine", 15);
for ($j = 0; $j < $m; $j++) {
    echo str_pad("M" . ($j+1), 10);
}
echo "\n";

for ($i = 0; $i < $n; $i++) {
     echo str_pad("İş " . ($i+1), 15);
     for ($j = 0; $j < $m; $j++) {
         $displayValue = ($dpTable[$i][$j] == PHP_INT_MAX) ? 'INF' : $dpTable[$i][$j];
         echo str_pad($displayValue, 10);
     }
     echo "\n";
}

echo "\n" . $minTimeResult . "\n";

?>