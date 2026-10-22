@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-[#dfe5df] focus:border-[#4e8273] focus:ring-[#4e8273] rounded-xl shadow-sm']) !!}>
