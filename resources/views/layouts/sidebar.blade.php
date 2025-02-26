@php
    $data = [
        ['name' => 'Dashboard', 'link' => '/', "icon" => "circle-gauge"],
        [
            'name' => 'Cơ sở dữ liệu',
            "icon" => "database",
            'children' => [
                ['name' => 'Gỗ chế biến', 'link' => route('db.processing')],
                ['name' => 'Sản xuất giống', 'link' => '/db/processing'],
            ]
        ]
    ];
@endphp

<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
        <ul class="space-y-2 font-medium">
            @foreach ($data as $item)
                <x-layouts.item-sidebar icon="{{$item['icon']}}" link="{{ $item['link'] ?? '' }}"
                    :children="$item['children'] ?? null">
                    {{ $item['name'] }}
                </x-layouts.item-sidebar>
            @endforeach
        </ul>
    </div>
</aside>
