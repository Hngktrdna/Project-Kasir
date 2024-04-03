<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .receipt {
            width: 300px;
            border: 1px solid #ccc;
            padding: 10px;
            margin: 0 auto;
        }
        .receipt h1 {
            font-size: 20px;
            margin: 0;
            text-align: center;
        }
        .receipt h5 {
            font-size: 15px;
            margin: 0;
            text-align: center;
        }
        .receipt h6 {
            font-size: 10px;
            margin: 0;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        td span {
            display: block;
            font-size: 12px;
            color: #888;
        }
        .total {
            font-weight: bold;
        }
        button {
            transition: 1s;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #C869FF;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }
        button:hover {
            background-color: #DA9AFF;
        }
    </style>
</head>
<body>
    <?php 
    
    session_start();
    // header("Content-Disposition: attachment; filename=/" . basename('test.pdf') . "/");
    // header("Content-Type: application/octet-stream");
    // header("Connection: close");
    ?>

<div class="receipt">
        <h1>Eternally Market</h1>
        <h5>The Dream Chapter: Eternity</h5>
        <h6>18052020</h6>
        <table>
            <tr>
                <th>Item</th>
                <th>Price</th>
            </tr>
            <?php 
            foreach($_SESSION["newdataBarang"] as $key => $value) {
                echo "<tr>";
                echo '<td>'. $value['nama_barang']. ' <br><span>'.$value["jumlah_barang"].' x '.$value["harga_barang"].'</span></td>';
                echo '<td>'. $value['total_harga']. '</td>';
                echo "</tr>";

            }
            echo '<tr>';
            echo '<td>Total Payment</td>';
            echo '<td> '. array_sum(array_column($_SESSION["newdataBarang"], "total_harga")).' </td>';

            echo '</tr>';
            echo '<tr>';
            echo '<td>Payment</td>';
            echo '<td> '. $_SESSION["uang_bayar"].' </td>';

            echo '</tr>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>Change</td>';
            echo '<td> '. $_SESSION["uang_bayar"] - array_sum(array_column($_SESSION["newdataBarang"], "total_harga")).' </td>';

            echo '</tr>';
            
            ?>
        </table>
        <button onclick="window.print()">Print</button>
</div>
</body>
</html>