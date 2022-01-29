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
		<h2>Players Table</h2>
		<div class="float-right"><a href="{{ route('add_player') }}"><button type="button" class="btn btn-primary">Add</button></a></div>
		
	</div>
	<table class="table">
	  <thead>
	    <tr>
	      <th scope="col">#</th>
	      <th scope="col">Name</th>
	      <th scope="col">Status</th>
	      <th scope="col">Action</th>
	    </tr>
	  </thead>
	  <tbody>
	  	@foreach($player_data as $player)
	    <tr>
	      <th scope="row">{{ $loop->iteration }}</th>
	      <td>{{ $player['name'] }}</td>
	      <td>{{ $player['status'] ? 'Active' : 'Inactive' }}</td>
	      <td>
	      	<a href="{{ route('edit_player' ,['id' => $player['_id']]) }}"><i class="fa fa-edit" aria-hidden="true">Edit</i></a>
	      	<a href="{{ route('delete_player' ,['id' => $player['_id']]) }}">Delete</a>
	      </td>
	    </tr>
	    @endforeach
	  </tbody>

	</table>
	  {!! $player_data->render() !!}
	</div>
@endsection