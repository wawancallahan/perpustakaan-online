@if(count($errors) > 0)
    <div class="alert alert-dismissible alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Informasi</strong>
        <ul class="list-unstyled">
            @foreach($errors->all() as $error)
                <li class="">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session()->has('flash.message'))
    <div class="alert alert-dismissible alert-{{ session()->get('flash.type') }}">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {!! session()->get('flash.message') !!}
    </div>
@endif