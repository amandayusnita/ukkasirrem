@extends('base')

@section('title', 'Pelanggan')

@section('content_header')
    <h1>Edit Pelanggan</h1>
@stop

@section('content')
    @if (session('msg'))
        <div class="alert alert-{{ session('type') ?? 'info' }}" role="alert">
            {{ session('msg') }}
        </div>
    @endif
    @if (count($errors) > 0)
        <div class="alert alert-danger" role="alert">
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
        </div>
    @endif
    <div class="card border border-dark">
        <div class="card-header bg-dark clearfix">
            <h5 class="mb-0 float-left">
                Tambah
            </h5>
            <div class="form-actions float-right">
                <a href="{{ route('customer.index') }}" name="Find" class="btn btn-sm btn-primary" title="Back">
                    <i class="fa fa-arrow-left"></i> Kembali</a>
            </div>
        </div>
        <form action="{{ route('customer.add-process') }}" method="post">
            <div class="card-body">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Nama Pelanggan</label>
                            <input type="text" name="NamaPelanggan" value="{{ $sessiondata['NamaPelanggan'] ?? '' }}" class="form-control" rows="6" placeholder="Masukan">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Nomor Telepon</label>
                            <input type="number" name="NoTelp" value="{{ $sessiondata['NoTelp'] ?? '' }}" class="form-control" rows="6" placeholder="Masukan">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea type="text" name="Alamat" value="{{ $sessiondata['Alamat'] ?? '' }}" class="form-control" rows="6" placeholder="Masukan"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-muted">
                <div class="form-actions float-right">
                    <button type="reset" class="btn btn-danger">Cancel</button>
                    <button type="submit" class="btn btn-success" onclick="$(this).addClass('disabled');$('form').submit();">Simpan</button>
                </div>
            </div>
        </form>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
