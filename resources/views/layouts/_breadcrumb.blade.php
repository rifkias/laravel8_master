<div class="container-fluid page__heading-container">
    <div class="page__heading d-flex align-items-center">
        <div class="flex">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                    @if(@$breadcrumb['nested'])
                        @foreach (@$breadcrumb['pages'] as $key => $item)
                            @if($loop->last)
                                <li class="breadcrumb-item active" aria-current="page">{{@$key}}</li>
                            @else
                            <li class="breadcrumb-item"><a href="{{@$item}}">{{@$key}}</a></li>
                            @endif
                        @endforeach
                    @else
                    <li class="breadcrumb-item active">{{@$breadcrumb['currentPage']}}</a></li>
                    @endif
                </ol>
            </nav>
            <h1 class="m-0">{{@$breadcrumb['currentPage']}}</h1>
        </div>
        @if(@$breadcrumb['setting'])
        <a href="" class="btn btn-light ml-3"><i class="material-icons icon-16pt text-muted mr-1">settings</i> Settings</a>
        @endif
    </div>
</div>
