<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembelian Bahan Bakar</title>
    <style>
        body {
            text-align: center;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        #container h2{
            font-weight: 800;
        
        }

        #container {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;

        }

        form {
            margin-bottom: 20px;
            background-color: grey;
            padding: 30px;
            border-radius: 20px;
            width: 500px;
            font-weight: 700;
            
        }

        hr {
            width: 20%;
            border-style: dotted;
            border-width: 3px;
            margin: 20px auto;
        }

        button {
            padding: 5px;
            font-weight: 600;
            width: 100px;
            border-radius: 10px;
            border: none;
            
        }

        .bungkus {
            margin-bottom: 20px;
            background-color: grey;
            padding: 30px;
            border-radius: 20px;
            width: 500px;
            font-weight: 700;
        }

        button:hover {
            background-color: black;
            color: white;
            cursor: pointer;
        }

    </style>
</head>

<body>
    <div id="container">
        <h2>Pembelian Bahan Bakar</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="jenis">Jenis Bahan Bakar:</label>
            <select id="jenis" name="jenis">
                <option value="Shell Super">Shell Super</option>
                <option value="Shell V-Power">Shell V-Power</option>
                <option value="Shell V-Power Diesel">Shell V-Power Diesel</option>
                <option value="Shell V-Power Nitro">Shell V-Power Nitro</option>
            </select>
            <br><br>
            <label for="jumlah">Jumlah Liter :</label>
            <input type="number" id="jumlah" name="jumlah" min="0" step="1" required>
            <br><br>
            <button type="submit">Beli</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            class Shell
            {
                protected $jenis;
                protected $harga;
                protected $jumlah;
                protected $ppn;

                public function __construct($jenis, $harga, $jumlah)
                {
                    $this->jenis = $jenis;
                    $this->harga = $harga;
                    $this->jumlah = $jumlah;
                    $this->ppn = 10; // PPN 10%
                }

                public function getJenis()
                {
                    return $this->jenis;
                }

                public function getHarga()
                {
                    return $this->harga;
                }

                public function getJumlah()
                {
                    return $this->jumlah;
                }

                public function getPpn()
                {
                    return $this->ppn;
                }
            }

            class Beli extends Shell
            {
                public function hitungTotal()
                {
                    $total = $this->harga * $this->jumlah;
                    $total += $total * $this->ppn / 100;
                    return $total;
                }

                public function buktiTrx()
                {
                    $total = $this->hitungTotal();
                    echo "<div class='bungkus'>";
                    echo "<div style='text-align: center;'>";
                    echo "<h3>Bukti Transaksi:</h3>";
                    echo "<p><strong>Anda mambeli bahan bakar minyak dengan tipe :</strong> " . $this->jenis . "</p>";
                    echo "<p><strong>dengan jumlah :</strong> " . $this->jumlah . " Liter</p>"; 
                    echo "<p><strong>Total yang harus anda bayar:</strong> Rp " . number_format($total, 2, ',', '.') . "</p>";
                    echo "</div>";
                }

            }

            $hargaBahanBakar = [
                "Shell Super" => 15420.00,
                "Shell V-Power" => 16130.00,
                "Shell V-Power Diesel" => 18310.00,
                "Shell V-Power Nitro" => 16510.00,
            ];

            $jenis = $_POST["jenis"];
            $jumlah = $_POST["jumlah"];

            if (array_key_exists($jenis, $hargaBahanBakar)) {
                $harga = $hargaBahanBakar[$jenis];
                $beli = new Beli($jenis, $harga, $jumlah);
                $beli->buktiTrx();
            } else {
                echo "<p style='text-align: center;'>Jenis bahan bakar tidak valid.</p>";
            }
        }
        ?>

    </div>
</body>
</html>