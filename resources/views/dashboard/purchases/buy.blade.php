@extends('layouts.form')
@section('card-title')
    Buy Package For User
@endsection
@section('form-action')
    {{route('dashboard.purchases.store')}}
@endsection
@section('form-method')
    @method('post')
@endsection
@section('form-content')
    <div class="form-group row">
        <label for="package" class="col-sm-2 col-form-label">Training Package</label>
        <div class="col-sm-10">
            <select class="form-control select2" style="width: 100%;" id="package" name="package">
                @foreach($packages as $package)
                    <option value="{{$package->id}}">{{$package->name}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label for="user" class="col-sm-2 col-form-label">User</label>
        <div class="col-sm-10">
            <select class="form-control select2" style="width: 100%;" id="user" name="user">
                @foreach($users as $user)
                    <option value="{{$user->id}}">{{$user->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    @hasanyrole('city_manager|admin')
    <div class="form-group row">
        <label for="gym" class="col-sm-2 col-form-label">GYM</label>
        <div class="col-sm-10">
            <select class="form-control select2" style="width: 100%;" id="gym" name="gym">
                @foreach($gyms as $gym)
                    <option value="{{$gym->id}}">{{$gym->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    @endrole
@endsection

