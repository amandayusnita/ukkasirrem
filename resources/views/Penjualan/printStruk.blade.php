<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body style="color:black;">
    <div class="w-25 mx-3 my-2">
        <h2 class="text-center">Nota Pembelian</h2>
        <p class="text-center">Toko Jaya</p>
    <br>
        <div class="row">
            <div class="col">Tanggal</div>
            <div class="col-auto">:</div>
            <div class="col">{{ $penjualan->TglPenjualan }}</div>
        </div>
        <div class="row">
            <div class="col">Nama Pelanggan</div>
            <div class="col-auto">:</div>
            <div class="col">{{ $penjualan->pelanggan->NamaPelanggan ?? '-' }}</div>
        </div>
    <br>
    <table border="0" cellpanding="5">
        <tr>
            <th>Nama</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>SubTotal</th>
        </tr>
        @foreach ($penjualan->detail as $value)
            <tr>
                <td>{{ $value->produk->NamaProduk }}</td>
                <td>{{ number_format($value->produk->Harga,2) }}</td>
                <td class="text-center">{{ $value->JumlahProduk }}</td>
                <td>{{ number_format($value->SubTotal,2) }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="2" align="right"><strong>Total</strong></td>
            <td colspan="2" align="right">{{ number_format($penjualan->TotalHarga,2) }}</td>
        </tr>
        <tr>
            <td colspan="2" align="right"><strong>Bayar</strong></td>
            <td colspan="2" align="right">{{ number_format($penjualan->bayar,2) }}</td>
        </tr>
        <tr>
            <td colspan="2" align="right"><strong>Kembalian</strong></td>
            <td colspan="2" align="right">{{ number_format($penjualan->bayar-$penjualan->TotalHarga,2) }}</td>
        </tr>
    </table>
<br>
<br>
<h5 class="text-center">::      Terima Kasih    ::</h5>
</div>

<script src="{{ asset('AdminLTE') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
