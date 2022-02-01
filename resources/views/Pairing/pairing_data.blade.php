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
  <table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Date</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($paired_players as $paired_player)
        <tr>
          <th scope="row">{{ $loop->iteration }}</th>
          <td>{{ $paired_player[0] }}</td>
          <td>{{ $paired_player[1] }}</td>
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