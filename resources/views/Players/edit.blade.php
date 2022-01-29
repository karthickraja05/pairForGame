@extends('common')

@section('main')
	<div class="my-5">
		<div class="text-center">
			<h2>Edit Player</h2>
		</div>
	<form action="{{ route('update_player',['id' => $edit_player['_id'] ]) }}" method="post">
		@csrf
	  <div class="form-group">
	    <label for="exampleInputEmail1">Name</label>
	    <input type="text" class="form-control" id="nameEx" aria-describedby="emailHelp" name='name' placeholder="Enter Name" value="{{ $edit_player['name'] }}">
	  </div>
	  <div class="form-group">
	    <label for="exampleInputPassword1">Status</label>
	    <select name="status" class="form-control" >
	    	<option value="1">Active</option>
	    	<option value="0" @if($edit_player['status'] == '0') selected @endif>Inactive</option>
	    </select>
	  </div>
	  <button type="submit" class="btn btn-primary">Update</button>
	</form>
	</div>
@endsection