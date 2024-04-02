@extends('base')

@if (Auth::user()->level=='admin')
    @section('title', 'Laporan')
        
    @section('content_header')
        <h1>Daftar Laporan</h1>
    @stop
@endif

@section('title', 'Penjualan')

@section('content_header')
    <h1>Daftar Penjualan</h1>
@stop

@section('content')
    @if (Auth::user()->level == 'admin')
        <div id="accordion">
            <form action="{{ route('sales.filter') }}" method="post">
                @csrf
                <div class="card border border-dark">
                    <div class="card-header bg-dark" id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <h5 class="mb-0">
                            Filter
                        </h5>
                    </div>
                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-md-line-input">
                                        <section class="control-label">Tanggal Mulai
                                            <span class="required text-danger">
                                                *
                                            </span>
                                        </section>
                                        <input type="date" name="start_date" id="start_date" class="form-control form-control-inline input-medium date-picker input-date" date-date-format="dd-mm-yy" type="text" value="{{ $filter['start_date'] ?? date('Y-m-d')}}" style="width: 15rem;" />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group form-md-line-input">
                                        <section class="control-label">
                                            Tanggal  Akhir
                                            <span class="required text-danger">
                                                *
                                            </span>
                                        </section>
                                        <input type="date" name="end_date" id="end_date" class="form-control form-control-inline input-medium date-picker input-date" date-date-format="dd-mm-yy" type="text" value="{{ $filter['end_date'] ?? date('Y-m-d')}}" style="width: 15rem;" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="form-actions float-right">
                                <a href="{{ route('sales.filter-reset') }}" class="btn btn-danger" type="reset" name="Reset"><i class="fa fa-times"></i> Batal</a>
                                <button type="submit" class="btn btn-primary" name="Search"><i class="fas fa-search"></i> Cari</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @endif
    @if (session('msg'))
        <div class="alert aalert-{{ session('type') ?? 'info' }}" role="alert">
            {{ session('msg') }}
        </div>
    @endif
    @if (count($errors) > 0)
    <div class="alert alert-danger" role="alert">
        @foreach ($errors->all() as $e)
            {{ $e }}
        @endforeach
    </div>
@endif
    <div class="card border border-dark">
        <div class="card-header bg-dark clearfix">
            <h5 class="mb-0 float-left">
                @if(Auth::user()->level == 'kasir')
                Tambah
            </h5>
            <div class="form-actions float-right">
                <a href="{{ route('sales.add') }}" name="Find" class="btn btn-sm btn-primary" title="Add Data">
                    <i class="fa fa-plus"></i> Tambah Data
                </a>
                @endif
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <th class="text-center">No.</th>
                    <th class="text-center">Tanggal Penjualan</th>
                    <th class="text-center">Nama Pelanggan</th>
                    <th class="text-center">Total Penjualan</th>
                    <th class="text-center">Aksi</th>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @if (empty($data))
                        <tr>
                            <td colspan="5" class="text-center">Data Kosong</td>
                        </tr>
                    @else
                        @foreach ($data as $item)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td class="text-center">{{ $item->TglPenjualan }}</td>
                                <td class="text-center">{{ $item->pelanggan->NamaPelanggan ?? '-' }}</td>
                                <td class="text-center">{{ number_format($item->TotalHarga,2) }}</td>
                                <td class="text-center">
                                    <a type="button" href="{{ route('sales.detail', $item->id) }}" class="btn btn-sm mb-1 btn-success btn-active-light-success">
                                        Detail
                                    </a>
                                    @if(Auth::user()->level == 'kasir')
                                    <a type="button" href="{{ route('sales.print-struk', $item->id) }}" class="btn btn-sm mb-1 btn-secondary btn-active-light-secondary">
                                        Print
                                    </a>
                                    <a type="button" href="{{ route('sales.delete', $item->id) }}" onclick="return confirm('Yakin????')" class="btn btn-sm mb-1 btn-danger btn-active-light-danger">
                                        Hapus
                                    </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="">
@stop

@section('js')
    <script>
        $(document).ready(function (){
            $('table').dataTable();
        });
    </script>
@stop