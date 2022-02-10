@extends('common')

@section('main')
<style type="text/css">
  td,th{
    padding: 0.40rem !important;
  }
  th.player{
    width: 30%;
  }
</style>
<div class="my-5">
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th class="player">Players Name</th>
        <th>Next Round</th>
        <th>Next Round</th>
      </tr>
    </thead>
    <tbody>
      @php
      $i = 1;
      @endphp
      @forelse($paired_players as $players)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td class="player">{{$players[0]['name']}} , {{$players[1]['name']}} </td>
        @if($loop->odd)
        <td rowspan="2"></td>
          @if($i == 1)
            <td rowspan="4"></td>
          @endif
        @endif
      </tr>
      @php 
        if($i == 4){
          $i = 0;
        }
        $i++;
      @endphp
      @empty
      <tr>
        <td colspan="4"></td>
      </tr>
      @endforelse
      
    </tbody>
  </table>
</div>
@endsection