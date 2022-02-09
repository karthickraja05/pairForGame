@extends('common')

@section('main')
<style type="text/css">
  .pagination{
    justify-content: center;
  }
  .head_play h2{
    float: left;
      position: relative;
      left: 50%;
      transform: translateX(-50%);
  }
</style>
  <div class="main1 my-5">
  <div class="head_play mb-3 w-100">
    <h2>Pairing Data</h2>
  </div>
  <div class="row my-5">
    <a href="{{ route('strict_pairing') }}"><button type="button" class="btn btn-primary">Strict Auto Pairing</button></a><br/>
  </div>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Date</th>
        <th scope="col">View</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($paired_players as $key => $paired_player)
        <tr>
          <th scope="row">{{ $loop->iteration }}</th>
          <td>{{ date('Y-m-d H:i:s',$key) }}</td>
          <td><a href="{{ route('view_paired_data',['id' => $key]) }}"><button>View</button></a></td>
        </tr>
      @empty
        <tr>
          <td colspan="3">No Data Found</td>
        </tr>
      @endforelse
    </tbody>
  </table>
  </div>
@endsection