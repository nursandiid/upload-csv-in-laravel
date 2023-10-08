<div {{ $attributes->merge(['class' => "alert alert-$type"]) }}
    role="alert">
    
    {!! $message !!}

    @if($close)
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    @endif
</div>