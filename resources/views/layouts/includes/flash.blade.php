@if(Session::has('flashMessageSuccess'))
    <div class="alert alert-success text-center" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
        {{ Session::get('flashMessageSuccess') }}
    </div>
@endif

@if(Session::has('flashMessageAlert'))
    <div class="alert alert-danger text-center" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
        {{ Session::get('flashMessageAlert') }}
    </div>
@endif

@if(Session::has('flashMessageWarning'))
    <div class="alert alert-warning  text-center" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
        <i class="fa fa-info-circle mr-2"></i> {{ Session::get('flashMessageWarning') }}
    </div>
@endif

@if(Session::has('flashMessageDanger'))
    <div class="alert alert-danger text-center" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
        {{ Session::get('flashMessageDanger') }}
    </div>
@endif

@if($errors->any())
<div class="alert alert-danger text-center" role="alert">
    @foreach ($errors->all() as $error)
    <div>* {{$error}}</div>
   @endforeach
</div>
@endif
