@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-pink-400 focus:ring-pink-300 rounded-md shadow-sm']) }}>
