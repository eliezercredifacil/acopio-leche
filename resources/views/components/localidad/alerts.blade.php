<div>
    <!-- The whole future lies in uncertainty: live immediately. - Seneca -->

    @props([
        'type' => 'info',
        'message' => null,
    ])

    @php
        $colors = [
            'success' => 'border-green-600 bg-green-50 text-green-700',
            'error' => 'border-red-600 bg-red-50 text-red-700',
            'info' => 'border-cyan-600 bg-cyan-50 text-cyan-700',
            'warning' => 'border-yellow-600 bg-yellow-50 text-yellow-700',
        ];

        $icons = [
            'success' => 'fa-circle-check',
            'error' => 'fa-circle-xmark',
            'info' => 'fa-circle-info',
            'warning' => 'fa-triangle-exclamation',
        ];
    @endphp

    @if ($message)
        <div class="flex">
            <div
                class="inline-flex items-center gap-2 border px-4 py-2 rounded-lg shadow-sm font-semibold text-sm {{ $colors[$type] }}">
                <i class="fa-solid {{ $icons[$type] }}"></i>
                <span>{{ $message }}</span>
            </div>
        </div>
    @endif
</div>
