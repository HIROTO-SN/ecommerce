{{-- prettier-ignore-start --}}

@props(['type' => 'order', 'status'])

@php
$colors = [
'order' => [
'new' => 'bg-blue-500',
'processing' => 'bg-yellow-500',
'shipped' => 'bg-green-500',
'delivered' => 'bg-green-700',
'cancelled' => 'bg-red-500',
],
'payment' => [
'pending' => 'bg-blue-500',
'paid' => 'bg-green-600',
'failed' => 'bg-red-600',
]
];

$label = ucfirst($status);
$color = $colors[$type][$status] ?? 'bg-gray-400';
@endphp

<span class="{{ $color }} py-1 px-3 rounded text-white shadow">
  {{ $label }}
</span>
{{-- prettier-ignore-end --}}