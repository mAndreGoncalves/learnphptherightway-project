<!DOCTYPE html>
<html>
    <head>
        <title>Transactions</title>
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
                text-align: center;
            }

            table tr th, table tr td {
                padding: 5px;
                border: 1px #eee solid;
            }

            tfoot tr th, tfoot tr td {
                font-size: 20px;
            }

            tfoot tr th {
                text-align: right;
            }
        </style>
    </head>
    <body>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Check #</th>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <!-- TODO -->
                <?php foreach ($transactions as $transaction): ?>
                <tr>
                    <td><?php echo date('M j, Y', strtotime($transaction['transaction_date']) ) ; ?></td>
                    <td><?php echo $transaction['check_num'];?></td>
                    <td><?php echo $transaction['description'];?></td>
                    <?php echo '<td ' . ($transaction['negative']? "style='color:red'> -$" : "style='color:green'> $") . number_format($transaction['absolute_value'],2, ".", "," ) . '</td>' ; ?>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total Income:</th>
                    <td><?php echo $revenue;?></td>
                </tr>
                <tr>
                    <th colspan="3">Total Expense:</th>
                    <td><?php echo $costs;?></td>
                </tr>
                <tr>
                    <th colspan="3">Net Total:</th>
                    <td><?php echo $profit;?>
                </tr>
            </tfoot>
        </table>
    </body>
</html>
