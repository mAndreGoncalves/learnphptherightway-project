<?php

declare(strict_types=1);

namespace App\Controllers;

use App\App;
use App\Models\Transaction;
use App\View;
use PDO;
use PDOException;

class CsvController
{
    public function upload(): View
    {
        return View::make('upload');
    }


    public function uploadFiles(): void
    {
        foreach ($_FILES['transaction_files']['name'] as $key => $name) {
            $filePath = STORAGE_PATH . DIRECTORY_SEPARATOR . $name;
            move_uploaded_file($_FILES['transaction_files']['tmp_name'][$key], $filePath);
            $this->readFile($filePath);
        }
        header('Location: /transactions');
        exit;
    }


    private function readFile($file)
    {
        $db = App::db();
        $current_file = fopen($file, "r");
        $header = true;
        while (($data = fgetcsv($current_file)) !== false) {
            if ($header) {
                if ($data = ["Date", "Check #", "Description", "Amount"]) {
                    $keys = $data;
                    $header = false;
                } else {
                    echo "File not valid";
                    break;
                }

            } else {

                $transactionModel = new Transaction();
                $value = (float) filter_var($data[3],FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $transaction_date = date('Y-m-d', strtotime($data[0]));
                $check_num = empty($data[1])? null : (int) $data[1];
                $description = $data[2];
                $absolute_value = abs($value);
                $negative = $value < 0;
                $transactionModel->create($transaction_date, $check_num, $description, $absolute_value, $negative);
            }
        }
        return 'Success!';
    }
}