<?php

namespace App\Models;

use App\App;
use App\Model;
use PDO;

class Transaction extends Model
{


    public function create(string $transaction_date, ?int $check_num, string $description, float $absolute_value, bool $negative): void
    {
        $query = 'INSERT INTO transactions (transaction_date, check_num, description, absolute_value, negative) VALUES (:date, :check_num, :description, :amount, :negative)';
        $newTransactionStmt = $this->db->prepare($query);
        $newTransactionStmt->bindValue(':date', $transaction_date, PDO::PARAM_STR);
        $newTransactionStmt->bindValue(':check_num', $check_num, PDO::PARAM_STR);
        $newTransactionStmt->bindValue(':description', $description, PDO::PARAM_STR);
        $newTransactionStmt->bindValue(':amount', $absolute_value, PDO::PARAM_STR);
        $newTransactionStmt->bindValue(':negative', $negative, PDO::PARAM_BOOL);
        $newTransactionStmt->execute();
    }

    public function get_revenue(): float
    {
        $querypositives = 'SELECT sum(absolute_value) FROM transactions WHERE negative = FALSE';
//        $querynegatives = 'SELECT sum(absolute_value) FROM transactions WHERE negative = TRUE';
        $fetchStmt = $this->db->prepare($querypositives);
        $fetchStmt->execute();
        return $fetchStmt->fetchColumn(0);
    }

    public function get_costs(): float
    {
        $querynegatives = 'SELECT sum(absolute_value) FROM transactions WHERE negative = TRUE';
        $fetchStmt = $this->db->prepare($querynegatives);
        $fetchStmt->execute();
        return $fetchStmt->fetchColumn(0);
    }

    public function get_profit(): float
    {
        $revenue = $this->get_revenue();
        $costs = $this->get_costs();
        $profit = $revenue - $costs;
        return $profit;
    }

    public function get_transactions()
    {
        $query = 'SELECT * FROM transactions';
        $fetchStmt = $this->db->prepare($query);
        $fetchStmt->execute();
        $transactions = $fetchStmt->fetchAll();
        return $transactions;
    }
}