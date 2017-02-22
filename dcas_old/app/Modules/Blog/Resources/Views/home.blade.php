@extends('layouts.app')

@section('content')
<div id="content">
    <div class="alert alert-success fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Success!</strong> You have successfully loaded the <em>Comdexx Solutions LLC</em> Blog Resource.
    </div>

    
    <form class="form-inline" role="form">
        <div class="form-group">
            <label for="focusedInput">Database query</label>
            <input class="form-control" id="focusedInput" type="text">

            <button type="button" class="btn btn-info">
                <span class="glyphicon glyphicon-search"></span> Find
            </button>
        </div>
    </form>
</div>
@endsection