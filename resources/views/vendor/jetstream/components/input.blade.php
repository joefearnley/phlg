@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-blue focus:ring focus:ring-blue focus:ring-opacity-50 rounded-md shadow-sm']) !!}>
