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
        <a href="{{ route('pairing') }}"><button type="button" class="btn btn-primary">Normal Auto Pairing</button></a>
      </div>

      <div class="m-5">
        <a href="{{ route('strict_pairing') }}"><button type="button" class="btn btn-primary">Strict Auto Pairing</button></a><br/>
        <span>
          <i>pair compare with previous pairing data. So, Max Avoid Same user come again.</i>
        </span>
      </div>

      <div class="m-5">
        <a href="{{ route('pairing_data') }}"><button type="button" class="btn btn-primary">Already Pairing Data</button></a><br/>
      </div>

      <div class="m-5">
        <span>
          <i>Created For Carrom Pairing</i>
        </span>
      </div>
      
    </div>
@endsection