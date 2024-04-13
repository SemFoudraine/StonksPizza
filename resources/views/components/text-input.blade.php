@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-stonks-groen focus:border-stonks-groen2 focus:ring-stonks-groen rounded-md shadow-sm']) !!}>
