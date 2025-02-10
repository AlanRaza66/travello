@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'flex items-center justify-start md:w-full p-3 text-base rounded-md text-white font-bold duration-500 cursor-pointer hover:bg-sky-600 md:mt-2'
            : 'flex items-center justify-start md:w-full p-3 text-base rounded-md text-white duration-500 cursor-pointer hover:bg-sky-600 md:mt-2';
@endphp
<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
