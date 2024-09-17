<?php
class BahanBakar {
    private $hargaSuper;
    private $hargaVpower;
    private $hargaVpowerDiesel;
    private $hargaVpowerNitro;
    public $jenisYangDipilih;
    public $totalLiter;
    protected $totalPembayaran;

    public function setHarga($hargaSuper, $hargaVpower, $hargaVpowerDiesel, $hargaVpowerNitro) {
        $this->hargaSuper = $hargaSuper;
        $this->hargaVpower = $hargaVpower;
        $this->hargaVpowerDiesel = $hargaVpowerDiesel;
        $this->hargaVpowerNitro = $hargaVpowerNitro;
    }

    public function getHarga() {
        return [
            "ssuper" => $this->hargaSuper, 
            "svpower" => $this->hargaVpower,
            "svpowerdiesel" => $this->hargaVpowerDiesel,
            "svpowernitro" => $this->hargaVpowerNitro
        ];
    }
}

class Beli extends BahanBakar {
    private $pajak = 0.10; // PPN 10%

    public function hitungTotalHarga() {
        $hargaPerLiter = $this->getHarga()[$this->jenisYangDipilih];
        $this->totalPembayaran = $hargaPerLiter * $this->totalLiter;
    }

    public function cetakBukti() {
        $ppn = $this->totalPembayaran * $this->pajak;
        $totalDenganPPN = $this->totalPembayaran + $ppn;

        echo "<div class='alert alert-success mt-4' id='struk'>";
        echo "<h4>Struk Pembelian</h4>";
        echo "<p>Jenis Bahan Bakar: " . htmlspecialchars($this->jenisYangDipilih) . "</p>";
        echo "<p>Jumlah Liter: " . htmlspecialchars($this->totalLiter) . " L</p>";
        echo "<p>Harga per Liter: Rp " . number_format($this->getHarga()[$this->jenisYangDipilih], 0, ',', '.') . "</p>";
        echo "<p>Total Harga (Sebelum PPN): Rp " . number_format($this->totalPembayaran, 0, ',', '.') . "</p>";
        echo "<p>PPN 10%: Rp " . number_format($ppn, 0, ',', '.') . "</p>";
        echo "<p>Total Harga (Termasuk PPN): Rp " . number_format($totalDenganPPN, 0, ',', '.') . "</p>";
        echo "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Isi Bensin</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            margin-top: 20px;
        }
        .form-control {
            margin-bottom: 10px;
        }
        #struk {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="my-4">Form Isi Bensin</h1>
        <form action="" method="post" id="formBensin">
            <div class="form-group">
                <label for="liter">Masukan Jumlah Liter Pembelian:</label>
                <input type="number" name="liter" id="liter" class="form-control" required>   
            </div>
            <div class="form-group">
                <label for="jenis">Pilih Jenis Bahan Bakar:</label>
                <select name="jenis" id="jenis" class="form-control" required>
                    <option value="ssuper">Shell Super</option>
                    <option value="svpower">Shell V-Power</option>
                    <option value="svpowerdiesel">Shell V-Power Diesel</option>
                    <option value="svpowernitro">Shell V-Power Nitro</option>
                </select>
            </div>
            <button type="submit" name="beli" class="btn btn-primary">Beli</button>
            <button type="reset" class="btn btn-secondary">Reset</button>
        </form>

        <?php
        // Buat instance dari class Pembelian
        $pembelian = new Beli();

        // buat edit harga bahan bakar
        $pembelian->setHarga(15420, 16130, 18310, 16510 );

        if (isset($_POST['beli'])) {
            // ini buat dapetin data dari form
            $pembelian->jenisYangDipilih = $_POST['jenis'];
            $pembelian->totalLiter = $_POST['liter'];

            // Hitung total harga
            $pembelian->hitungTotalHarga();

            // buat mengcetak struk
            $pembelian->cetakBukti();

            echo "<script>document.getElementById('struk').style.display = 'block';</script>";
        }
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.querySelector('button[type="reset"]').addEventListener('click', function() {
            // Sembunyikan struk saat tombol reset ditekan
            document.getElementById('struk').style.display = 'none';
        });
    </script>
</body>
</html>
