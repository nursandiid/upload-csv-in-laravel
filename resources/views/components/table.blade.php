<table {{ $attributes->merge(['class' => 'table']) }}>
    @isset($thead)
    <thead>
        {{ $thead }}
    </thead>
    @endisset
    
    <tbody>
        {{ $slot }}
    </tbody>
</table>