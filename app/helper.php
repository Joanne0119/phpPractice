<?php

declare(strict_types=1);

function formatDollarAmount(float $amount): string {
    $isNegative = $amount < 0;

    return ($isNegative ? '-' : '') . '$' . number_format(abs($amount), 2); //abs is to make number positive always
    //make the amout like -$600 ( - sign is infront the $ sign)
}

function formatDate(string $date): string {
    return date('M j, Y', strtotime($date)); //convert date to month day, year
}