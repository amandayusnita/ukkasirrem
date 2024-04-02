@extends('base')

@section('title', 'Penjualan')

@section('content_header')
    <h1>Tambah Penjualan</h1>
@stop

@section('content')
    <div class="card border border-dark">
        <div class="card-header bg-dark clearfix">
            <h5 class="mb-0 float-left">
                Detail
            </h5>
            <div class="form-actions float-right">
                <a href="{{ route('sales.index') }}" name="Find" class="btn btn-sm btn-primary" title="Add Data">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <th class="text-center">No.</th>
                        <th class="text-center">Nama Produk</th>
                        <th class="text-center">Harga Produk</th>
                        <th class="text-center">Jumlah Produk</th>
                        <th class="text-center">Subtotal</th>
                        <th class="text-center">Aksi</th>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                            $total = 0;
                            $kembalian = 0;
                        @endphp
                        @if (empty($penjualan->detail))
                            <tr>
                                <td colspan="6" class="text-center"> Data Kosong</td>
                            </tr>
                        @else
                            @foreach ($penjualan->detail as $k => $v)
                                <tr>
                                    <td class="text-center">{{ $no++ }}</td>
                                    <td>{{ $v->produk->NamaProduk }}</td>
                                    <td class="text-right">{{ number_format($v->produk->Harga,2) }}</td>
                                    <td class="text-center">{{ $v->JumlahProduk }}</td>
                                    <td class="text-right">{{ number_format($v->SubTotal,2) }}</td>
                                    <td class="text-center">
                                        <button type="reset" class="btn btn-sm btn-danger" onclick="deleteItem('{{ $k }}');"><i class="fas fa-trash"></i> Hapus</button>
                                    </td>
                                </tr>
                                @php
                                    $total += ($v->SubTotal)
                                @endphp
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-center font-weight-bold">Total</td>
                            <td colspan="2" class="text-center">{{ number_format($total,2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="card border border-dark">
        <div class="card-body">
            <form action="{{ route('sales.add-process') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-12">
                        @php
                            $bayar = $penjualan->bayar;
                            $kembalian = $bayar - $total;
                        @endphp
                        <div class="col-6">
                            <div class="form-group">
                                <label>Tanggal Penjualan</label>
                                <input type="text" name="TglPenjualan" class="form-control" disabled value="{{ date('Y-m-d', strtotime($penjualan->TglPenjualan)) }}" placeholder="Masukan.......">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Nama Pelanggan</label>
                                <input type="text" name="NamaPelanggan" class="form-control" disabled value="{{ $penjualan->pelanggan->NamaPelanggan ?? '-' }}" placeholder="Masukan.......">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Nominal Bayar</label>
                                <input name="bayar" class="form-control" disabled value="{{ number_format($bayar,2) }}" placeholder="Masukan.......">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Nominal Kembalian</label>
                                <input type="text" name="sisa" class="form-control" disabled value="{{ number_format($kembalian,2) }}" placeholder="Masukan.......">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
@stop

@section('css')
@stop

@section('js')
<script>
</script>
@stop