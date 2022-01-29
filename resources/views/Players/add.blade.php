@extends('common')

@section('main')
	<form action="{{ route('store_player') }}" method="post">
		@csrf
	  <div class="form-group">
	    <label for="exampleInputEmail1">Name</label>
	    <input type="text" class="form-control" id="nameEx" aria-describedby="emailHelp" name='name' placeholder="Enter Name">
	  </div>
	  <div class="form-group">
	    <label for="exampleInputPassword1">Status</label>
	    <select name="status" class="form-control" >
	    	<option value="1">Active</option>
	    	<option value="0">Inactive</option>
	    </select>
	  </div>
	  <button type="submit" class="btn btn-primary">Add</button>
	</form>
@endsection