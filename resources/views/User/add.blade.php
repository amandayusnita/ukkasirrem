@extends('base')

@section('title', 'User')

@section('content_header')
    <h1>Tambah User</h1>
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
                <a href="{{ route('user.index') }}" name="Find" class="btn btn-sm btn-primary" title="Back">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <form action="{{ route('user.add-process') }}" method="post">
            <div class="card-body">
                @csrf
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Nama</label>
                            <input name="name" value="{{ $sessiondata['name'] ?? '' }}" class="form-control" rows="3" placeholder="Masukkan">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Username</label>
                            <input name="username" value="{{ $sessiondata['username'] ?? '' }}" class="form-control" rows="3" placeholder="Masukkan">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Password</label>
                            <input name="password" type="password" value="{{ $sessiondata['password'] ?? '' }}" class="form-control" rows="3" placeholder="Masukkan">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Level</label>
                            <select name="level" class="form-control select2bs4" style="width: 100%;" placeholder="Pilih Level.......">
                                <option value="" disabled selected>Pilih Level....</option>
                                @foreach ($level as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
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