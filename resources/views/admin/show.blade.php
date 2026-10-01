<div class="col-md-9">

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h4 class="alert-heading">Danger!</h4>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li> <button type="button" class="btn-close" data-bs-dismiss="alert"
                    aria-label="Close"></button>
            @endforeach
        </div>
    @endif
    @if (session()->get('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <h4 class="alert-heading">Success!</h4>
            {{ session()->get('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session()->get('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h4 class="alert-heading">Danger!</h4>
            {{ session()->get('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('unsentEmailsFile'))
        <div class="alert alert-warning">
            <h4 class="alert-heading">Warning!</h4>
            Some emails could not be sent.
            <a href="{{ session('unsentEmailsFile') }}" class="btn btn-sm btn-warning">Download Unsent Emails</a>
        </div>
    @endif

</div>
