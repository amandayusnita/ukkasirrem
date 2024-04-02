@extends('base')

@section('title', 'Produk')

@section('content_header')
    <h1>Tambah Produk</h1>
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
                Tambah
            </h5>
            <div class="form-actions float-right">
                <a href="{{ route('product.index') }}" name="Find" class="btn btn-sm btn-primary" title="Back">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <form action="{{ route('product.add-process') }}" method="post">
            <div class="card-body">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Kode Produk</label>
                            <input type="text" name="KodeProduk" value="{{ $sessiondata['KodeProduk'] ?? '' }}" class="form-control" row="6" placeholder="Masukan...">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Nama Produk</label>
                            <input type="text" name="NamaProduk" value="{{ $sessiondata['NamaProduk'] ?? '' }}" class="form-control" row="6" placeholder="Masukan...">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Harga</label>
                            <input type="number" name="Harga" value="{{ $sessiondata['Harga'] ?? '' }}" class="form-control" row="6" placeholder="Masukan...">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Stok</label>
                            <input type="text" name="Stok" value="{{ $sessiondata['Stok'] ?? '' }}" class="form-control" row="6" placeholder="Masukan..."></input>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-muted">
                <div class="form-actions float-right">
                    <button type="reset" class="btn btn-danger">Cancel</button>
                    <button type="submit" class="btn btn-success" onclick="$(this).addClass('disabled');$('form').submit();">Submit</button>
                </div>
            </div>
        </form>
    </div>
@stop