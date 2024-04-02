@extends('base')

@section('title', 'Produk')

@section('content_header')
    <h1>Daftar Produk</h1>
@stop

@section('content')
    @if (session('msg'))
        <div class="alert alert-{{ session('type') ?? 'info' }}" role="alert">
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
                Daftar
            </h5>
            <div class="form-actions float-right">
                @if (Auth::user()->level == 'admin')
                    <a href="{{ route('product.add') }}" name="Find" class="btn btn-sm btn-primary" title="Add Data">
                        <i class="fa fa-plus"></i> Tambah Data
                    </a>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table-dtriped table bordered table-hover">
                    <thead>
                        <th class="text-center">No</th>
                        <th class="text-center">Kode Produk</th>
                        <th class="text-center">Nama Produk</th>
                        <th class="text-center">Harga</th>
                        <th class="text-center">Stok</th>
                        @if (Auth::user()->level == 'admin')
                            <th class="text-center">Aksi</th>
                        @endif
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
                                    <td class="text-center">{{ $item->KodeProduk }}</td>
                                    <td class="text-center">{{ $item->NamaProduk }}</td>
                                    <td class="text-center">{{ $item->Harga }}</td>
                                    <td class="text-center">{{ $item->Stok }}</td>
                                    @if (Auth::user()->level == 'admin')
                                        <td class="text-center">
                                            <a type="button" href="{{ route('product.edit', $item->id) }}"  class="btn btn-sm mb-1 btn-warning btn-active-light-warning">
                                                Edit
                                            </a>
                                            <a type="button" href="{{ route('product.delete', $item->id) }}" onclick="return confirm('Yakin???')" class="btn btn-sm mb-1 btn-danger btn-active-light-danger">
                                                Hapus
                                            </a>
                                        </td>
                                    @endif
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
        $(document).ready(function () {
            $('table').dataTable();
        })
    </script>
@stop

@section('footer')
@stop