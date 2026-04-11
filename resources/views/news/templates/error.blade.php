@if ($errors->any())
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
            @foreach ($errors->all() as $error)
                <p class="error_p">{{ $error }}</p>
            @endforeach
    </div>
@endif
