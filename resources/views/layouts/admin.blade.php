<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - {{ __('admin.admin_panel') }}</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
    <!-- Alpine.js for interactivity -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        .sidebar-transition { transition: transform 0.3s ease-in-out; }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-900">
    <div class="relative min-h-screen flex" x-data="{ sidebarOpen: false }">
        
        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false" 
             class="fixed inset-0 bg-gray-900/50 z-40 lg:hidden" x-cloak></div>

        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 transform lg:translate-x-0 lg:static lg:inset-0 sidebar-transition"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" x-cloak>
            
            <!-- Sidebar Header -->
            <div class="h-16 flex items-center justify-between px-6 border-b border-gray-200 bg-gradient-to-r from-[#0d3a37] to-[#3dab8c]">
                <div class="flex items-center gap-2 font-bold text-xl text-white">
                    <img src="{{ asset('images/logo.svg') }}" class="h-8 w-auto" alt="Logo">
                    <span>{{ __('admin.admin_panel') }}</span>
                </div>
                <button @click="sidebarOpen = false" class="lg:hidden text-white hover:text-gray-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Sidebar Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-[#3dab8c] text-white shadow-md' : 'text-gray-600 hover:bg-green-50 hover:text-[#0d3a37]' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    {{ __('admin.dashboard') }}
                </a>

                <div class="pt-4 pb-2">
                    <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('admin.management') }}</p>
                </div>

                <a href="{{ route('admin.notices.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.notices.*') ? 'bg-[#3dab8c] text-white shadow-md' : 'text-gray-600 hover:bg-green-50 hover:text-[#0d3a37]' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    {{ __('admin.notices') }}
                </a>

                <a href="{{ route('admin.form-downloads.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.form-downloads.*') ? 'bg-[#3dab8c] text-white shadow-md' : 'text-gray-600 hover:bg-green-50 hover:text-[#0d3a37]' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    {{ __('admin.form_downloads') }}
                </a>

                <a href="{{ route('admin.teacher-vacant-posts.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.teacher-vacant-posts.*') ? 'bg-[#3dab8c] text-white shadow-md' : 'text-gray-600 hover:bg-green-50 hover:text-[#0d3a37]' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    {{ __('admin.teacher_vacant_posts') }}
                </a>

                <a href="{{ route('admin.staff-vacant-posts.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.staff-vacant-posts.*') ? 'bg-[#3dab8c] text-white shadow-md' : 'text-gray-600 hover:bg-green-50 hover:text-[#0d3a37]' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    {{ __('admin.staff_vacant_posts') }}
                </a>

                <a href="{{ route('admin.galleries.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.galleries.*') ? 'bg-[#3dab8c] text-white shadow-md' : 'text-gray-600 hover:bg-green-50 hover:text-[#0d3a37]' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    {{ __('admin.gallery') }}
                </a>

                <a href="{{ route('admin.sliders.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.sliders.*') ? 'bg-[#3dab8c] text-white shadow-md' : 'text-gray-600 hover:bg-green-50 hover:text-[#0d3a37]' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    {{ __('admin.sliders') }}
                </a>

                <a href="{{ route('admin.website-links.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.website-links.*') ? 'bg-[#3dab8c] text-white shadow-md' : 'text-gray-600 hover:bg-green-50 hover:text-[#0d3a37]' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                    {{ __('admin.website_links') }}
                </a>

                <a href="{{ route('admin.daily-attendances.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.daily-attendances.*') ? 'bg-[#3dab8c] text-white shadow-md' : 'text-gray-600 hover:bg-green-50 hover:text-[#0d3a37]' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    {{ __('admin.daily_attendance') }}
                </a>

                <!-- Dynamic Pages Dropdown -->
                <div x-data="{ open: {{ request()->routeIs('admin.custom-pages.*') ? 'true' : 'false' }} }" class="space-y-1">
                    <button @click="open = !open" 
                        class="w-full flex items-center justify-between px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.custom-pages.*') ? 'bg-green-50 text-[#0d3a37]' : 'text-gray-600 hover:bg-green-50 hover:text-[#0d3a37]' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            {{ __('admin.pages_control') }}
                        </div>
                        <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div x-show="open" x-cloak class="pl-8 space-y-1">
                        <a href="{{ route('admin.custom-pages.index') }}" class="block px-3 py-1.5 text-xs font-medium rounded-md {{ request()->routeIs('admin.custom-pages.index') ? 'text-[#3dab8c] bg-green-50' : 'text-gray-500 hover:text-[#3dab8c] hover:bg-green-50' }}">
                            {{ __('admin.list_of_pages') }}
                        </a>

                        @foreach($groupedCustomPages as $category => $subcategories)
                            @php
                                $isBn = app()->getLocale() === 'bn';
                                // Get category display name from first item in subcategories
                                $catDisplayName = $category;
                                foreach($subcategories as $subcategory => $items) {
                                    foreach($items as $item) {
                                        if ($category && $item->category_bn && $isBn) {
                                            $catDisplayName = $item->category_bn;
                                        }
                                        break 2;
                                    }
                                }
                            @endphp
                            @if($category)
                                <div x-data="{ catOpen: false }" class="space-y-1">
                                    <button @click="catOpen = !catOpen" class="w-full flex items-center justify-between px-3 py-1 text-xs font-semibold text-gray-400 uppercase tracking-wider hover:text-[#3dab8c]">
                                        {{ $catDisplayName }}
                                        <svg class="w-3 h-3 transition-transform" :class="catOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>
                                    <div x-show="catOpen" class="pl-3 space-y-1">
                                        @foreach($subcategories as $subcategory => $items)
                                            @php
                                                $subDisplayName = $subcategory;
                                                foreach($items as $item) {
                                                    if ($subcategory && $item->subcategory_bn && $isBn) {
                                                        $subDisplayName = $item->subcategory_bn;
                                                    }
                                                    break;
                                                }
                                            @endphp
                                            @if($subcategory)
                                                <div x-data="{ subOpen: false }" class="space-y-1">
                                                    <button @click="subOpen = !subOpen" class="w-full flex items-center justify-between px-3 py-1 text-[10px] font-bold text-gray-500 uppercase hover:text-[#3dab8c]">
                                                        {{ $subDisplayName }}
                                                        <svg class="w-2 h-2 transition-transform" :class="subOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                                    </button>
                                                    <div x-show="subOpen" class="pl-3 space-y-1 border-l border-gray-100 ml-1">
                                                        @foreach($items as $item)
                                                            <a href="{{ route('admin.custom-pages.settings', $item->id) }}" class="block px-3 py-1 text-[11px] text-gray-500 hover:text-[#3dab8c] hover:bg-green-50 rounded">
                                                                {{ ($isBn && $item->page_name_bn) ? $item->page_name_bn : $item->page_name }}
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @else
                                                @foreach($items as $item)
                                                    <a href="{{ route('admin.custom-pages.settings', $item->id) }}" class="block px-3 py-1 text-[11px] text-gray-500 hover:text-[#3dab8c] hover:bg-green-50 rounded">
                                                        {{ ($isBn && $item->page_name_bn) ? $item->page_name_bn : $item->page_name }}
                                                    </a>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                @foreach($subcategories as $subcategory => $items)
                                    @foreach($items as $item)
                                        <a href="{{ route('admin.custom-pages.settings', $item->id) }}" class="block px-3 py-1.5 text-xs text-gray-500 hover:text-[#3dab8c] hover:bg-green-50 rounded">
                                            • {{ ($isBn && $item->page_name_bn) ? $item->page_name_bn : $item->page_name }}
                                        </a>
                                    @endforeach
                                @endforeach
                            @endif
                        @endforeach
                    </div>
                </div>

                <a href="{{ route('admin.custom-page2.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.custom-page2.*') ? 'bg-[#3dab8c] text-white shadow-md' : 'text-gray-600 hover:bg-green-50 hover:text-[#0d3a37]' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    {{ __('admin.pages_control_2') }}
                </a>

                <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.settings.*') ? 'bg-[#3dab8c] text-white shadow-md' : 'text-gray-600 hover:bg-green-50 hover:text-[#0d3a37]' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    {{ __('admin.settings') }}
                </a>

                @if(Auth::user()->isAdmin())
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.users.*') ? 'bg-[#3dab8c] text-white shadow-md' : 'text-gray-600 hover:bg-green-50 hover:text-[#0d3a37]' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    {{ __('admin.admin_users') }}
                </a>
                @endif

                @if(Auth::user()->email === 'info@htdc.edu.bd')
                <a href="{{ route('admin.database-export.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.database-export.*') ? 'bg-[#3dab8c] text-white shadow-md' : 'text-gray-600 hover:bg-green-50 hover:text-[#0d3a37]' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    {{ __('admin.db_export') }}
                </a>
                @endif

                @if(!Auth::user()->isAdmin())
                <a href="{{ config('services.external_api.base_url') }}accounts/login/admin/" target="_blank" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg text-gray-600 hover:bg-green-50 hover:text-[#0d3a37]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                    {{ __('admin.software_login') }}
                </a>
                @endif

                <div class="pt-4 pb-2">
                    <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('admin.applications') }}</p>
                </div>

                <a href="{{ route('admin.teacher-applications.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.teacher-applications.*') ? 'bg-[#3dab8c] text-white shadow-md' : 'text-gray-600 hover:bg-green-50 hover:text-[#0d3a37]' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    {{ __('admin.teachers') }}
                </a>

                <a href="{{ route('admin.applications.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('admin.applications.*') ? 'bg-[#3dab8c] text-white shadow-md' : 'text-gray-600 hover:bg-green-50 hover:text-[#0d3a37]' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l9-5-9-5-9 5 9 5zm0 0v6m0 0l4-2.223M12 20l-4-2.223"></path></svg>
                    {{ __('admin.students') }}
                </a>

                <div class="pt-10">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            {{ __('admin.logout') }}
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            
            <!-- Top Header (Mobile & Desktop) -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 lg:px-8 flex-shrink-0">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-md text-gray-600 hover:bg-gray-100 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <h2 class="text-lg font-semibold text-gray-800 lg:hidden">{{ __('admin.admin_panel') }}</h2>
                </div>
                
                <div class="flex items-center gap-4">
                    <!-- Language Switcher -->
                    <div x-data="{ langOpen: false }" class="relative">
                        <button @click="langOpen = !langOpen" class="flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-lg transition-colors border border-gray-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                            <span>{{ app()->getLocale() === 'bn' ? 'বাংলা' : 'English' }}</span>
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="langOpen" @click.away="langOpen = false" x-cloak
                             class="absolute right-0 mt-2 w-36 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50">
                            <a href="{{ route('language.switch', 'en') }}" class="block px-4 py-2 text-sm {{ app()->getLocale() === 'en' ? 'bg-green-50 text-[#3dab8c] font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">
                                English
                            </a>
                            <a href="{{ route('language.switch', 'bn') }}" class="block px-4 py-2 text-sm {{ app()->getLocale() === 'bn' ? 'bg-green-50 text-[#3dab8c] font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">
                                বাংলা
                            </a>
                        </div>
                    </div>

                    <span class="text-sm font-medium text-gray-700 hidden sm:block">{{ Auth::user()->name }}</span>
                    <div class="h-8 w-8 rounded-full bg-gradient-to-br from-[#3dab8c] to-[#0d3a37] flex items-center justify-center text-white font-bold text-sm shadow-md">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
            </header>

            <!-- Scrollable Content Area -->
            <main class="flex-1 overflow-y-auto p-4 lg:p-8">
                @if(session('success'))
                    <div class="mb-6 p-4 rounded-xl bg-green-50 text-green-700 border border-green-200 flex items-center gap-3 shadow-sm">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 rounded-xl bg-red-50 text-red-700 border border-red-200 flex items-center gap-3 shadow-sm">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                @endif

                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>

                <div class="mt-8 pt-4 border-t border-gray-200 text-center">
                    <p class="text-sm text-gray-500">{{ __('admin.powered_by') }} <a href="https://automateinfosys.com/" target="_blank" class="text-[#3dab8c] font-semibold hover:text-[#0d3a37] hover:underline">AutomateInfosys</a></p>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
