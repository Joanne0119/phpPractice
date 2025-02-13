<?php

declare(strict_types = 1);

function getTransactionFiles(string $dirPath): array  // get all files path
{
    $files = [];

    foreach (scandir($dirPath) as $file) { // loop through all files in the directory
        if (is_dir($file)) { // if the file is directory
            continue;
        }

        $files[] = $dirPath . $file;
    }
    return $files;
}

function getTransaction(string $fileName): array { // read csv file and return data
    if(! file_exists($fileName)) { // check the file exist or not
        trigger_error("File $fileName does not exist", E_USER_ERROR);
    }

    $file = fopen($fileName, 'r'); //open file and read

    fgetcsv($file); //read the first line here. To make sure the first won't be saved in $transactions

    $transactions = [];

    //read every line of csv data, each line  of data will save in $transactions[]
    while (($transaction = fgetcsv($file)) !== false) { 
        $transactions[] = extractTransactions($transaction);
    }

    return $transactions;
}

function extractTransactions(array $transactionRow): array // make data readable(remove amount $ and , and convert to float)
{
    [$date, $checkNumber, $description, $amount] = $transactionRow;

    $amount = (float) str_replace(['$', ','], '', $amount); // remove $ and , and convert to float

    return [
        'date' => $date,
        'checkNumber' => $checkNumber,
        'description' => $description,
        'amount' => $amount
    ];

}