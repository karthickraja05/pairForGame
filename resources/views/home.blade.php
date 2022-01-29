@extends('common')

@section('main')
    <div class="main1 my-5">
      <div class="head_play mb-3 w-100">
          <h2>List Of Management</h2>
      </div>
      <div class="m-5">
        <a href="{{ route('players') }}"><button type="button" class="btn btn-primary">Player Management</button></a>
      </div>
      <div class="m-5">
        <a href="{{ route('add_player') }}"><button type="button" class="btn btn-primary">Pairing Management</button></a>
      </div>

      <div class="m-5">
        <span>
          <i>Created For Carrom Pairing</i>
        </span>
      </div>
      
    </div>
@endsection