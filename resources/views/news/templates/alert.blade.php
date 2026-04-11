@if (session('news_notily'))
    <div class="row">
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                </button>
                <strong>{{session('news_notily')}}</strong>
            </div>
    </div>
@endif
