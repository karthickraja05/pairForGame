@extends('common')

@section('main')
	<a href="{{ route('add_player') }}"><button type="button" class="btn btn-primary">Add</button></a>
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
	  {!! $player_data->render() !!}
	  </tbody>

	</table>
@endsection