@extends('base')

@section('title', 'Produk')

@section('content_header')
    <h1>Edit Produk</h1>
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
                Edit
            </h5>
            <div class="form-actions float-right">
                <a href="{{ route('product.index') }}" name="Find" class="btn btn-sm btn-primary" title="Back">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <form action="{{ route('product.edit-process') }}" method="post">
            <div class="card-body">
                @csrf
                <div class="row">
                    <input name="id" type="hidden" value="{{ $data->id }}">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Kode Produk</label>
                            <input type="text" name="KodeProduk" value="{{ $data->KodeProduk }}" class="form-control" row="6" placeholder="Masukan...">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Nama Produk</label>
                            <input type="text" name="NamaProduk" value="{{ $data->NamaProduk }}" class="form-control" row="6" placeholder="Masukan...">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Harga</label>
                            <input type="number" name="Harga" value="{{ $data->Harga }}" class="form-control" row="6" placeholder="Masukan...">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Stok</label>
                            <input type="text" name="Stok" value="{{ $data->Stok }}" class="form-control" row="6" placeholder="Masukan..."></input>
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