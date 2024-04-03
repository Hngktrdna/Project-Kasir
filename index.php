<?php 
    session_start();

        if(isset($_POST["cetak"])) {
            
            if($_POST["uang_bayar"] < array_sum(array_column($_SESSION["dataBarang"], "total_harga"))) {
                echo "<script>alert('Sorry, not enough money.')</script>";
            } else {
                $_SESSION["newdataBarang"] = [];
                $_SESSION["newdataBarang"] = $_SESSION["dataBarang"];
                $_SESSION["uang_bayar"] = $_POST["uang_bayar"];
                // unset($_SESSION["dataBarang"]);
                header("Location: cetak.php");
            }
        } 

        if (isset($_POST['reset'])) {
            session_unset();
        }
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Counter</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
        }
        h4 {
            text-align: center;
            margin-bottom: 30px;
        }

        form {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }

        form input[type="text"], form input[type="number"], form input[type="submit"] {
            flex-basis: calc(33% - 10px);
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        form input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        form input[type="submit"]:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        table th, table td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }

        table th {
            background-color: #4CAF50;
            color: #fff;
        }

        table td:last-child {
            text-align: right;
        }

        table td a {
            background-color: #f44336;
            color: #fff;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
            margin-right: 10px;
        }

        table td a:hover {
            background-color: #da190b;
        }

        #totalharga {
            font-weight: bold;
            color: #f44336;
        }

        #tagcetak {
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }

        #childtag {
            margin-right: 10px;
        }

        .footer {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px;
            text-align: center;
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Checkout Counter</h1>
        <h4>Eternally Market</h4>
        <form action="" method="post">
            <table>
                <tr>
                    <td>Name of Item</td>
                    <td>:</td>
                    <td><input type="text" name="nama_barang"></td>
                </tr>
                <tr>
                    <td>Quantity</td>
                    <td>:</td>
                    <td><input type="number" name="jumlah_barang"></td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td></td>
                    <td><input type="text" name="harga_barang"></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td><button type="submit" name="submit">Add</button></td>
                </tr>
        </table>
    </form>

    <?php 
            if(!isset($_SESSION['dataBarang'])){
                $_SESSION['dataBarang']=array();
            }

            if (isset($_GET['hapus'])) {
                $index = $_GET['hapus'];
                unset($_SESSION['dataBarang'][$index]);
            }

            if(isset($_POST['submit'])) {
                if(@$_POST['nama_barang'] && @$_POST['jumlah_barang'] && @$_POST['harga_barang']) {
                    if(isset($_SESSION['dataBarang'])) {
                        if(count($_SESSION["dataBarang"]) <= 0) {
                            $data = [
                                'nama_barang' => $_POST['nama_barang'],
                                'jumlah_barang' => $_POST['jumlah_barang'],
                                'harga_barang' => $_POST['harga_barang'],
                                'total_harga' => $_POST['jumlah_barang'] * $_POST['harga_barang'],
                            ];
                            array_push($_SESSION['dataBarang'],$data);
                        } else {
                            $cek = array_search($_POST["nama_barang"], array_column($_SESSION["dataBarang"], "nama_barang"));
    
                            if ($cek !== false) {
                                $_SESSION["dataBarang"][$cek]["jumlah_barang"] =  $_SESSION["dataBarang"][$cek]["jumlah_barang"] + $_POST['jumlah_barang'];
                                $_SESSION["dataBarang"][$cek]["harga_barang"] = $_POST['harga_barang'];
                                $_SESSION["dataBarang"][$cek]["total_harga"] = $_SESSION["dataBarang"][$cek]["jumlah_barang"] * $_SESSION["dataBarang"][$cek]["harga_barang"];

                            } else {
                                $data = [
                                    'nama_barang' => $_POST['nama_barang'],
                                    'jumlah_barang' => $_POST['jumlah_barang'],
                                    'harga_barang' => $_POST['harga_barang'],
                                    'total_harga' => $_POST['jumlah_barang'] * $_POST['harga_barang']
                                ];
                                array_push($_SESSION['dataBarang'],$data);
                            }
                        }
                    
                    }
                }
        
            }

            if(!empty($_SESSION['dataBarang'])) {
                echo "<form method='post' action=''>";
                echo '<table>';
                echo '<tr>';
                echo '<td>Name of Item</td>';
                echo '<td>Quantity</td>';
                echo '<td>Price</td>';
                echo '<td>Total Price</td>';
                echo '</tr>';

        
                // Menampilkan data memakai tabel
                foreach($_SESSION['dataBarang'] as $index => $value){
                echo '<tr>';
                echo '<td>'. $value['nama_barang']. '</td>';
                echo '<td>'. $value['jumlah_barang']. '</td>';
                echo '<td>'. $value['harga_barang']. '</td>';
                echo '<td>'. $value['total_harga']. '</td>';
                echo '<td><a href="?hapus=' . $index .' ">DELETE</a></td>';
                echo '</tr>';
        
            }
            echo '<tr>';
            echo '<td colspan= "3">Total Price</td>';
            echo '<td id="totalharga"> '. array_sum(array_column($_SESSION["dataBarang"], "total_harga")).' </td>';

            echo '</tr>';
            echo '<tr>';
            echo '<td>Payment</td>';
            echo '<td><input type="number" name="uang_bayar" id="uang_bayar"/></td>';
            echo '</tr>';
            
            echo '<tr>';
            ?>
            <td id="tagcetak"><input id="childtag" type="submit" value="cetak" name="cetak"></td>
            <td><input type="submit" name="reset" value="reset" /></td>
            <?php
            echo '</tr>';

                echo '</table>';
                echo "</form>";
            } else {
                echo 'You can input the data first.';
            }

        
        ?>
       
        
</body>
</html>