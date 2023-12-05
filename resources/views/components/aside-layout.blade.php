@props([
    'tight' => false,
])
<div {{
    $attributes->class([
        'flex flex-col',
        'gap-4' => !$tight,
        'lg:flex-row'
    ])
}}>
    {{ $slot }}
</div>
