@if ($link)
    <li>
        <a href="{{ $link }}"
            class="{{request()->is($link) ? 'bg-gray-100' : ""}} flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
            <i data-lucide="{{$icon}}"
                class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
            <span class="ms-3">
                {{ $slot }}
            </span>
        </a>
    </li>
@elseif ($children)
    <li>
        <button type="button"
            class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
            aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
            <i data-lucide="{{$icon}}"
                class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
            <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">
                {{ $slot }}
            </span>
            <i data-lucide="chevron-down" class="size-4"></i>
        </button>
        @php
            $hidden = in_array(request()->url(), array_column($children, 'link')) ? '' : 'hidden';
        @endphp
        <ul id="dropdown-example" class="{{$hidden}} py-2 space-y-2">
            @foreach ($children as $chil)
                <li>
                    <a href="{{ $chil['link'] }}"
                        class="{{request()->fullUrlIs($chil['link']) ? 'bg-gray-100' : ""}} flex items-center w-full p-2 text-gray-700 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                        {{ $chil['name'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    </li>
@endif
