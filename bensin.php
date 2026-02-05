<?php
// CLASS BahanBakar
class BahanBakar
{
    // Properti private hanya bisa diakses dari dalam class
    private $hargaSuper;
    private $hargaVpower;
    private $hargaVpowerDiesel;
    private $hargaVpowerNitro;

    // Properti public bisa diakses dari luar class
    public $jenisYangDipilih;
    public $totalLiter;

    // Protected hanya bisa diakses class turunan
    protected $totalPembayaran;

    // Method untuk mengatur harga bahan bakar
    public function setHarga($hargaSuper, $hargaVpower, $hargaVpowerDiesel, $hargaVpowerNitro)
    {
        $this->hargaSuper = $hargaSuper;
        $this->hargaVpower = $hargaVpower;
        $this->hargaVpowerDiesel = $hargaVpowerDiesel;
        $this->hargaVpowerNitro = $hargaVpowerNitro;
    }

    // Method untuk mengambil harga dalam bentuk array
    public function getHarga()
    {
        return [
            "ssuper" => $this->hargaSuper,
            "svpower" => $this->hargaVpower,
            "svpowerdiesel" => $this->hargaVpowerDiesel,
            "svpowernitro" => $this->hargaVpowerNitro
        ];
    }
}

// CLASS Beli (turunan dari BahanBakar)
class Beli extends BahanBakar
{
    // Pajak PPN 10%
    private $pajak = 0.10;

    // Method untuk menghitung total harga
    public function hitungTotalHarga()
    {
        // Ambil harga berdasarkan jenis yang dipilih
        $hargaPerLiter = $this->getHarga()[$this->jenisYangDipilih];
        // Total = harga per liter x jumlah liter
        $this->totalPembayaran = $hargaPerLiter * $this->totalLiter;
    }

    // Method untuk mencetak struk pembelian
    public function cetakBukti()
    {
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

        <!-- Form input -->
        <form action="" method="post">
            <div class="form-group">
                <label>Masukan Jumlah Liter:</label>
                <input type="number" name="liter" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Pilih Jenis Bahan Bakar:</label>
                <select name="jenis" class="form-control" required>
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
        // Buat object dari class Beli
        $pembelian = new Beli();

        // Set harga bahan bakar
        $pembelian->setHarga(15420, 16130, 18310, 16510);

        // Jika tombol beli ditekan
        if (isset($_POST['beli'])) {
            $pembelian->jenisYangDipilih = $_POST['jenis'];
            $pembelian->totalLiter = $_POST['liter'];

            $pembelian->hitungTotalHarga();
            $pembelian->cetakBukti();

            // Menampilkan struk
            echo "<script>document.getElementById('struk').style.display='block';</script>";
        }
        ?>
    </div>
</body>

</html>