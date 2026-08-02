<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hazera-Taju Degree College</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script src="//unpkg.com/alpinejs" defer></script>

    <!-- Custom CSS -->
    <link href="<?php echo e(asset('css/custom.css')); ?>" rel="stylesheet">

    <style>
        [x-cloak] {
            display: none !important;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #3dab8c;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #2d8a71;
        }
    </style>
</head>

<body class="antialiased flex flex-col md:px-[50px] lg:px-[70px] overflow-hidden bg-[#e0ffea]"
    x-data="{
        sidebarOpen: false,
        lang: 'en',
        sidebarHeight: 0,
        headerHeight: 0,
        footerHeight: 0,
        init() {
            this.updateHeights();
            window.addEventListener('resize', () => this.updateHeights());
        },
        updateHeights() {
            this.$nextTick(() => {
                if (this.$refs.sidebar && this.$refs.sidebar.offsetWidth > 0) {
                    this.sidebarHeight = this.$refs.sidebar.scrollHeight || this.$refs.sidebar.offsetHeight;
                } else {
                    this.sidebarHeight = 0;
                }
                if (this.$refs.header) {
                    this.headerHeight = this.$refs.header.offsetHeight;
                }
                if (this.$refs.footer) {
                    this.footerHeight = this.$refs.footer.offsetHeight;
                }
            });
        },
        get bodyHeight() {
            if (window.innerHeight < 800) {
                if (this.sidebarHeight > 0) {
                    return (this.headerHeight + this.sidebarHeight + this.footerHeight) + 'px';
                }
                return '100vh';
            }
            return '800px';
        }
    }"
    :style="`height: ${bodyHeight}; background-color: #e0ffea;`">

    <!-- Header Section (Fixed at top on Desktop) -->
    <header class="md:shrink-0" x-ref="header">
        <!-- TopBar -->
        <div class="topbar-bg text-white relative">
            <div class="topbar-bg-inner py-1 sm:py-0.5">
                <div class="absolute inset-0"></div>
                <div class="relative px-2 md:px-4 flex flex-col items-center  ">
                    
                    <!-- Top Row: Logo + Title -->
                    <div class="flex items-center justify-center gap-6 sm:gap-8 md:gap-12 lg:gap-16 w-full">
                        <!-- Logo -->
                        <div class="shrink-0 mt-1 sm:mt-2 md:mt-3 lg:mt-4">
                            <img src="<?php echo e(asset('images/logo.svg')); ?>" alt="Hazera-Taju logo"
                                class="w-12 h-12 sm:w-14 sm:h-14 md:w-20 md:h-20 lg:w-24 lg:h-24 xl:w-28 xl:h-28 rounded-full">
                        </div>

                        <!-- Title (Bangla + English) -->
                        <div class="text-white text-center min-w-0 px-1">
                            <p class="bn-font bn-text-stroke leading-tight text-sm sm:text-lg md:text-3xl lg:text-4xl xl:text-5xl"
                                style="transform: scaleX(1.15);">
                                হাজেরা-তজু ডিগ্রী কলেজ
                            </p>
                            <p class="font-sans font-bold text-[0.5rem] sm:text-[0.6rem] md:text-[1rem] lg:text-[1.3rem] xl:text-[1.6rem] [-webkit-text-stroke:0.02rem_black] md:[-webkit-text-stroke:0.05rem_black] lg:[-webkit-text-stroke:0.06rem_black]"
                                style="text-align: center;">
                                Hazera-Taju Degree College
                            </p>
                        </div>
                    </div>

                    <!-- Bottom Row: Slogan (Right side) -->
                    <div class="w-full flex justify-end"
                         x-data="{ 
                            slogan: 'A NON POLITICAL INSTITUTION',
                            visible: [],
                            barPos: 0,
                            async init() {
                                this.visible = Array(this.slogan.length).fill(true);
                                this.startAnimation();
                            },
                            async startAnimation() {
                                while(true) {
                                    for(let i=0; i < this.slogan.length; i++) {
                                        this.barPos = (i / (this.slogan.length - 1)) * 100;
                                        this.visible[i] = false;
                                        await new Promise(r => setTimeout(r, 70));
                                    }
                                    await new Promise(r => setTimeout(r, 1000));
                                    for(let i=this.slogan.length - 1; i >= 0; i--) {
                                        this.barPos = (i / (this.slogan.length - 1)) * 100;
                                        this.visible[i] = true;
                                        await new Promise(r => setTimeout(r, 70));
                                    }
                                    await new Promise(r => setTimeout(r, 2000));
                                }
                            }
                         }">
                        <div class="relative flex items-center py-0.5 px-2 md:px-3 min-h-[1.2rem] md:min-h-[1.5rem] max-w-full">
                            <div class="absolute h-full bg-[#0d3a37]/50 backdrop-blur-[2px] rounded-sm border border-white/5 transition-all duration-75"
                                 :style="`left: calc(${barPos}%); width: calc(100% - ${barPos}%);`"
                                 x-show="true"></div>
                            <div class="absolute h-full w-[2px] bg-white shadow-[0_0_10px_white] z-20 transition-all duration-75 animate-slogan-blink"
                                 :style="`left: ${barPos}%`"
                                 x-show="true"></div>
                            <div class="relative z-10 flex gap-[1px] text-[0.45rem] sm:text-[0.5rem] md:text-[0.65rem] lg:text-[0.7rem] font-bold tracking-widest text-white/90 uppercase overflow-visible">
                                <template x-for="(char, index) in slogan.split('')" :key="index">
                                    <span x-html="char === ' ' ? '&nbsp;' : char"
                                          class="inline-block transition-all duration-300"
                                          :class="visible[index] ? 'opacity-100 scale-100' : 'opacity-0 scale-50'">
                                    </span>
                                </template>
                            </div>
                        </div>
                        <style>
                            @keyframes slogan-blink {
                                0%, 100% { opacity: 1; }
                                50% { opacity: 0; }
                            }
                            .animate-slogan-blink {
                                animation: slogan-blink 0.8s infinite;
                            }
                        </style>
                    </div>
                </div>
            </div>
        </div>

        <!-- NavBar -->
        <nav class="bg-[#0d3a37] shadow-sm text-white" x-data="{ mobileMenuOpen: false }">
            <div class="mx-auto px-2 sm:px-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2 min-w-0">
                        <!-- Sidebar Toggle (Mobile + Tablet) -->
                        <button @click="sidebarOpen = !sidebarOpen"
                            class="lg:hidden px-2 py-1 bg-[rgb(20,89,84)] text-white hover:bg-[rgb(20,89,84)] shrink-0"
                            aria-label="Toggle sidebar">☰</button>

                        <!-- Desktop Nav (lg and above) -->
                        <div class="hidden lg:flex items-center space-x-1 xl:space-x-2 shrink-0">
                            <a href="/" class="text-xs xl:text-sm text-slate-100 px-2 xl:px-3 py-1 hover:bg-[rgb(20,89,84)] whitespace-nowrap">HOME</a>
                            <a href="/bou" class="text-xs xl:text-sm text-slate-100 px-2 xl:px-3 py-1 hover:bg-[rgb(20,89,84)] whitespace-nowrap">BOU</a>

                            <?php
                                $admissionPrograms = $admissionPrograms ?? [];
                                $hscProg = collect($admissionPrograms)->first(fn($p) => stripos(data_get($p, 'name') ?? data_get($p, 'program_name') ?? '', 'HSC') !== false);
                                $honoursProg = collect($admissionPrograms)->first(fn($p) => stripos(data_get($p, 'name') ?? data_get($p, 'program_name') ?? '', 'Honours') !== false);
                                $degreeProg = collect($admissionPrograms)->first(fn($p) => stripos(data_get($p, 'name') ?? data_get($p, 'program_name') ?? '', 'Degree') !== false);

                                $hscEnabled = !empty($hscProg);
                                $honoursEnabled = !empty($honoursProg);
                                $degreeEnabled = !empty($degreeProg);

                                $hscId = data_get($hscProg, 'id') ?? data_get($hscProg, 'program_id');
                                $honoursId = data_get($honoursProg, 'id') ?? data_get($honoursProg, 'program_id');
                                $degreeId = data_get($degreeProg, 'id') ?? data_get($degreeProg, 'program_id');
                            ?>
                            <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                                <a href="#" class="text-xs xl:text-sm text-slate-100 px-2 xl:px-3 py-1 hover:bg-[rgb(20,89,84)] flex items-center whitespace-nowrap">
                                    ONLINE ADMISSION
                                    <svg class="h-3 w-3 xl:h-4 xl:w-4 ml-1 transition-transform duration-300" :class="{'rotate-180': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </a>
                                <ul x-show="open" class="absolute z-50 top-full left-0 w-44 bg-[#0d3a37] shadow-lg py-0" x-cloak>
                                    <li class="border-b border-gray-50">
                                        <a href="<?php echo e($hscEnabled ? '/apply?program_id=' . $hscId : 'javascript:alert(\'HSC Admission is currently off\')'); ?>" class="text-xs xl:text-sm text-slate-100 px-3 py-1 hover:bg-[rgb(20,89,84)] block flex justify-between items-center">
                                            <span>HSC</span>
                                            <?php if(!$hscEnabled): ?> <span class="text-[8px] bg-red-600 px-1 rounded">OFF</span> <?php endif; ?>
                                        </a>
                                    </li>
                                    <li class="border-b border-gray-50">
                                        <a href="<?php echo e($honoursEnabled ? '/apply?program_id=' . $honoursId : 'javascript:alert(\'Honours Admission is currently off\')'); ?>" class="text-xs xl:text-sm text-slate-100 px-3 py-1 hover:bg-[rgb(20,89,84)] block flex justify-between items-center">
                                            <span>HONOURS</span>
                                            <?php if(!$honoursEnabled): ?> <span class="text-[8px] bg-red-600 px-1 rounded">OFF</span> <?php endif; ?>
                                        </a>
                                    </li>
                                    <li class="border-b border-gray-50">
                                        <a href="<?php echo e($degreeEnabled ? '/apply?program_id=' . $degreeId : 'javascript:alert(\'Degree Admission is currently off\')'); ?>" class="text-xs xl:text-sm text-slate-100 px-3 py-1 hover:bg-[rgb(20,89,84)] block flex justify-between items-center">
                                            <span>DEGREE</span>
                                            <?php if(!$degreeEnabled): ?> <span class="text-[8px] bg-red-600 px-1 rounded">OFF</span> <?php endif; ?>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <a href="/results" class="text-xs xl:text-sm text-slate-100 px-2 xl:px-3 py-1 hover:bg-[rgb(20,89,84)] whitespace-nowrap">RESULT</a>
                            <a href="/notices" class="text-xs xl:text-sm text-slate-100 px-2 xl:px-3 py-1 hover:bg-[rgb(20,89,84)] whitespace-nowrap">NOTICE</a>
                            <a href="/form-downloads" class="text-xs xl:text-sm text-slate-100 px-2 xl:px-3 py-1 hover:bg-[rgb(20,89,84)] whitespace-nowrap">FORM DOWNLOAD</a>
                            <a href="/gallery" class="text-xs xl:text-sm text-slate-100 px-2 xl:px-3 py-1 hover:bg-[rgb(20,89,84)] whitespace-nowrap">PHOTO GALLARY</a>
                            <a href="/contact" class="text-xs xl:text-sm text-slate-100 px-2 xl:px-3 py-1 hover:bg-[rgb(20,89,84)] whitespace-nowrap">CONTACT</a>
                            <a href="/daily-attendance" class="text-xs xl:text-sm text-slate-100 px-2 xl:px-3 py-1 hover:bg-[rgb(20,89,84)] whitespace-nowrap">DAILY ATTENDANCE</a>
                        </div>
                    </div>

                    <!-- Mobile Menu Button (Right side) -->
                    <div class="lg:hidden shrink-0">
                        <button @click="mobileMenuOpen = !mobileMenuOpen" aria-label="Toggle menu"
                            class="px-2 py-1 bg-[rgb(20,89,84)] text-white hover:bg-[rgb(20,89,84)]">☰</button>
                    </div>
                </div>

                <!-- Mobile Navigation Dropdown -->
                <div x-show="mobileMenuOpen" class="lg:hidden pb-3" x-cloak>
                    <div class="flex flex-col space-y-1">
                        <a href="/" class="text-sm text-slate-100 px-3 py-2 hover:bg-[rgb(20,89,84)] rounded block">HOME</a>
                        <a href="/bou" class="text-sm text-slate-100 px-3 py-2 hover:bg-[rgb(20,89,84)] rounded block">BOU</a>

                        <!-- ONLINE ADMISSION -->
                        <li x-data="{ open: false }" class="list-none">
                            <a href="#" @click.prevent="open = !open"
                                class="text-sm text-slate-100 px-3 py-2 hover:bg-[rgb(20,89,84)] rounded block flex justify-between items-center">
                                <span>ONLINE ADMISSION</span>
                                <svg class="h-4 w-4 transition-transform" :class="{'rotate-90': open}" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10l-3.293-3.293a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <ul x-show="open" class="pl-4 space-y-1 mt-1" x-cloak>
                                <li>
                                    <a href="<?php echo e($hscEnabled ? '/apply?program_id=' . $hscId : 'javascript:alert(\'HSC Admission is currently off\')'); ?>"
                                        class="text-sm text-slate-100 px-3 py-2 hover:bg-[rgb(20,89,84)] rounded block flex justify-between items-center">
                                        <span>HSC</span>
                                        <?php if(!$hscEnabled): ?> <span class="text-[8px] bg-red-600 px-1 rounded">OFF</span> <?php endif; ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo e($honoursEnabled ? '/apply?program_id=' . $honoursId : 'javascript:alert(\'Honours Admission is currently off\')'); ?>"
                                        class="text-sm text-slate-100 px-3 py-2 hover:bg-[rgb(20,89,84)] rounded block flex justify-between items-center">
                                        <span>HONOURS</span>
                                        <?php if(!$honoursEnabled): ?> <span class="text-[8px] bg-red-600 px-1 rounded">OFF</span> <?php endif; ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo e($degreeEnabled ? '/apply?program_id=' . $degreeId : 'javascript:alert(\'Degree Admission is currently off\')'); ?>"
                                        class="text-sm text-slate-100 px-3 py-2 hover:bg-[rgb(20,89,84)] rounded block flex justify-between items-center">
                                        <span>DEGREE</span>
                                        <?php if(!$degreeEnabled): ?> <span class="text-[8px] bg-red-600 px-1 rounded">OFF</span> <?php endif; ?>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <a href="/results" class="text-sm text-slate-100 px-3 py-2 hover:bg-[rgb(20,89,84)] rounded block">RESULT</a>
                        <a href="/notices" class="text-sm text-slate-100 px-3 py-2 hover:bg-[rgb(20,89,84)] rounded block">NOTICE</a>
                        <a href="/form-downloads" class="text-sm text-slate-100 px-3 py-2 hover:bg-[rgb(20,89,84)] rounded block">FORM DOWNLOAD</a>
                        <a href="/gallery" class="text-sm text-slate-100 px-3 py-2 hover:bg-[rgb(20,89,84)] rounded block">PHOTO GALLARY</a>
                        <a href="/contact" class="text-sm text-slate-100 px-3 py-2 hover:bg-[rgb(20,89,84)] rounded block">CONTACT</a>
                        <a href="/daily-attendance" class="text-sm text-slate-100 px-3 py-2 hover:bg-[rgb(20,89,84)] rounded block">DAILY ATTENDANCE</a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Notice Bar -->
        <div class="bg-gray-50 text-black" x-data="{ 
        paused: false, 
        modalOpen: false, 
        selectedNotice: null,
        notices: [
            <?php $__currentLoopData = $globalNotices ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($notice->isNew()): ?>
                    { 
                        id: <?php echo e($notice->id); ?>,
                        text: '<?php echo e($notice->title); ?>', 
                        content: '<?php echo addslashes(preg_replace('/\s+/', ' ', $notice->content)); ?>',
                        file: '<?php echo e($notice->file_path ? Storage::url($notice->file_path) : ''); ?>',
                        isNew: true
                    },
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        ]
    }">
            <div class="flex items-center gap-1 ">
                <!-- Exclusive Updates Badge - Fixed width matching sidebar (w-60 = 240px) -->
                <div class="hidden lg:flex bg-[#3dab8c] font-semibold py-2 px-2 text-white items-center text-sm w-44">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                        <path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z" />
                        <line x1="4" y1="22" x2="4" y2="15" />
                    </svg>
                    <span class="ml-1">Exclusive Updates</span>
                </div>

                <!-- Marquee Container - Full width scrolling area -->
                <div class="flex-1 overflow-hidden" @mouseenter="paused = true" @mouseleave="paused = false">
                    <div class="marquee whitespace-nowrap flex items-center h-full">
                        <div class="marquee-content inline-flex items-center animate-marquee"
                            :class="{ 'paused': paused }">
                            <template x-for="notice in notices">
                                <span class="mr-8 cursor-pointer hover:underline flex items-center"
                                    @click="selectedNotice = notice; modalOpen = true">
                                    <span x-text="notice.text"></span>
                                    <img src="<?php echo e(asset('images/new.gif')); ?>" alt="New" class="inline-block h-6 ml-2">
                                </span>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div x-show="modalOpen" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center"
                x-cloak>
                <div class="bg-white p-6 rounded-lg shadow-xl max-w-lg w-full mx-4" @click.away="modalOpen = false">
                    <h3 class="text-xl font-bold text-gray-800 mb-4" x-text="selectedNotice?.text"></h3>
                    <div class="text-gray-700 prose max-w-none" x-html="selectedNotice?.content"></div>

                    <template x-if="selectedNotice?.file">
                        <div class="mt-4 p-4 bg-gray-50 rounded-lg border border-gray-100">
                            <a :href="selectedNotice.file" target="_blank"
                                class="inline-flex items-center gap-2 text-[#3dab8c] font-semibold hover:underline">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                Download Attachment
                            </a>
                        </div>
                    </template>

                    <div class="mt-6 flex justify-end">
                        <button @click="modalOpen = false"
                            class="bg-[#3dab8c] text-white px-4 py-2 rounded hover:bg-green-700 transition">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Middle Section -->
    <div class="flex-1 flex flex-col md:flex-row min-h-0 bg-gray-50 overflow-hidden">
            <aside class="bg-white text-sm hidden md:block w-40 lg:w-44 border-r shrink-0 shadow-sm" x-ref="sidebar">
                <ul class="divide-y divide-gray-200">
                    <!-- About College -->
                    <li class="relative group">
                        <a href="#"
                            class="block py-3 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 font-medium flex justify-between items-center pr-2 <?php echo e(request()->is('about*') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">
                            <span class="truncate">About College</span>
                            <svg class="h-4 w-4 shrink-0 transition-transform duration-200" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10l-3.293-3.293a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <ul
                            class="absolute left-full top-0 w-52 lg:w-60 bg-[#0d3a37] shadow-lg hidden group-hover:block z-50 max-h-[80vh] overflow-y-auto">
                            <li><a href="/about" class="block py-3 text-white hover:bg-[rgb(20,89,84)] pl-5 <?php echo e(request()->is('about') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">About Us</a></li>
                            <li><a href="/at-a-glance" class="block py-3 text-white hover:bg-[rgb(20,89,84)] pl-5 <?php echo e(request()->is('at-a-glance') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">At A Glance</a></li>
                        </ul>
                    </li>
                    <!-- Academic -->
                    <li class="relative group">
                        <a href="#"
                            class="block py-3 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 font-medium flex justify-between items-center pr-2 <?php echo e(request()->is('apply*') || request()->is('teacher/apply*') || request()->is('principle-list*') || request()->is('vice-principle-list*') || request()->is('governing-board*') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">
                            <span class="truncate">Academic</span>
                            <svg class="h-4 w-4 shrink-0 transition-transform duration-200" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10l-3.293-3.293a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <ul
                            class="absolute left-full top-0 w-52 lg:w-60 bg-[#0d3a37] shadow-lg hidden group-hover:block z-50 max-h-[80vh] overflow-y-auto">
                            <li><a href="/apply" class="block py-3 text-white hover:bg-[rgb(20,89,84)] pl-5 <?php echo e(request()->is('apply') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Admission</a></li>
                            <li><a href="/teacher/apply" class="block py-3 text-white hover:bg-[rgb(20,89,84)] pl-5 <?php echo e(request()->is('teacher/apply') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Teacher Application</a></li>
                            <li><a href="/principle-list" class="block py-3 text-white hover:bg-[rgb(20,89,84)] pl-5 <?php echo e(request()->is('principle-list') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Principal List</a></li>
                            <li><a href="/vice-principle-list" class="block py-3 text-white hover:bg-[rgb(20,89,84)] pl-5 <?php echo e(request()->is('vice-principle-list') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Vice Principal List</a></li>
                            <li><a href="/governing-board" class="block py-3 text-white hover:bg-[rgb(20,89,84)] pl-5 <?php echo e(request()->is('governing-board') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">GB</a></li>
                        </ul>
                    </li>

                    <!-- Department -->
                    <li class="relative" x-data="{
                        deptOpen: false,
                        deptTimer: null,
                        hscOpen: false,
                        hscTimer: null,
                        honoursOpen: false,
                        honoursTimer: null,
                        degreeOpen: false,
                        degreeTimer: null
                    }">
                        <a href="#"
                            @mouseenter="clearTimeout(deptTimer); deptOpen = true"
                            @mouseleave="deptTimer = setTimeout(() => { deptOpen = false; hscOpen = false; honoursOpen = false; degreeOpen = false }, 300)"
                            class="block py-3 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 font-medium flex justify-between items-center pr-2 <?php echo e(request()->is('science*') || request()->is('business-studies*') || request()->is('humanities*') || request()->is('accounting*') || request()->is('management*') || request()->is('economics*') || request()->is('ba*') || request()->is('bbs*') || request()->is('bss*') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">
                            <span class="truncate">Department</span>
                            <svg class="h-4 w-4 shrink-0 transition-transform duration-200" :class="{'rotate-90': deptOpen}" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10l-3.293-3.293a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <!-- Level 1: HSC, Honours, Degree -->
                        <ul x-show="deptOpen" x-cloak
                            @mouseenter="clearTimeout(deptTimer)"
                            @mouseleave="deptTimer = setTimeout(() => { deptOpen = false; hscOpen = false; honoursOpen = false; degreeOpen = false }, 300)"
                            class="absolute left-full top-0 w-52 lg:w-60 bg-[#0d3a37] shadow-lg z-50">
                            <!-- HSC -->
                            <li class="relative"
                                @mouseenter="clearTimeout(hscTimer); hscOpen = true"
                                @mouseleave="hscTimer = setTimeout(() => { hscOpen = false }, 300)">
                                <a href="#"
                                    class="block py-3 text-white hover:bg-[rgb(20,89,84)] pl-5 flex justify-between items-center <?php echo e(request()->is('science*') || request()->is('business-studies*') || request()->is('humanities*') ? 'bg-[rgb(20,89,84)]' : ''); ?>">
                                    <span>HSC</span>
                                    <svg class="h-4 w-4 shrink-0 transition-transform duration-200" :class="{'rotate-90': hscOpen}" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10l-3.293-3.293a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                                <ul x-show="hscOpen" x-cloak
                                    @mouseenter="clearTimeout(hscTimer); clearTimeout(deptTimer)"
                                    @mouseleave="hscTimer = setTimeout(() => { hscOpen = false }, 300)"
                                    class="absolute left-full top-0 w-52 lg:w-60 bg-[#0d3a37] shadow-lg z-[60]">
                                    <li><a href="/science" class="block py-3 text-white hover:bg-[rgb(20,89,84)] pl-5 <?php echo e(request()->is('science') ? 'bg-[rgb(20,89,84)]' : ''); ?>">Science</a></li>
                                    <li><a href="/business-studies" class="block py-3 text-white hover:bg-[rgb(20,89,84)] pl-5 <?php echo e(request()->is('business-studies') ? 'bg-[rgb(20,89,84)]' : ''); ?>">Business Studies</a></li>
                                    <li><a href="/humanities" class="block py-3 text-white hover:bg-[rgb(20,89,84)] pl-5 <?php echo e(request()->is('humanities') ? 'bg-[rgb(20,89,84)]' : ''); ?>">Humanities</a></li>
                                </ul>
                            </li>
                            <!-- Honours -->
                            <li class="relative"
                                @mouseenter="clearTimeout(honoursTimer); honoursOpen = true"
                                @mouseleave="honoursTimer = setTimeout(() => { honoursOpen = false }, 300)">
                                <a href="#"
                                    class="block py-3 text-white hover:bg-[rgb(20,89,84)] pl-5 flex justify-between items-center <?php echo e(request()->is('accounting*') || request()->is('management*') || request()->is('economics*') ? 'bg-[rgb(20,89,84)]' : ''); ?>">
                                    <span>Honours</span>
                                    <svg class="h-4 w-4 shrink-0 transition-transform duration-200" :class="{'rotate-90': honoursOpen}" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10l-3.293-3.293a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                                <ul x-show="honoursOpen" x-cloak
                                    @mouseenter="clearTimeout(honoursTimer); clearTimeout(deptTimer)"
                                    @mouseleave="honoursTimer = setTimeout(() => { honoursOpen = false }, 300)"
                                    class="absolute left-full top-0 w-52 lg:w-60 bg-[#0d3a37] shadow-lg z-[60]">
                                    <li><a href="/accounting" class="block py-3 text-white hover:bg-[rgb(20,89,84)] pl-5 <?php echo e(request()->is('accounting') ? 'bg-[rgb(20,89,84)]' : ''); ?>">Accounting</a></li>
                                    <li><a href="/management" class="block py-3 text-white hover:bg-[rgb(20,89,84)] pl-5 <?php echo e(request()->is('management') ? 'bg-[rgb(20,89,84)]' : ''); ?>">Management</a></li>
                                    <li><a href="/economics" class="block py-3 text-white hover:bg-[rgb(20,89,84)] pl-5 <?php echo e(request()->is('economics') ? 'bg-[rgb(20,89,84)]' : ''); ?>">Economics</a></li>
                                </ul>
                            </li>
                            <!-- Degree -->
                            <li class="relative"
                                @mouseenter="clearTimeout(degreeTimer); degreeOpen = true"
                                @mouseleave="degreeTimer = setTimeout(() => { degreeOpen = false }, 300)">
                                <a href="#"
                                    class="block py-3 text-white hover:bg-[rgb(20,89,84)] pl-5 flex justify-between items-center <?php echo e(request()->is('ba*') || request()->is('bbs*') || request()->is('bss*') ? 'bg-[rgb(20,89,84)]' : ''); ?>">
                                    <span>Degree</span>
                                    <svg class="h-4 w-4 shrink-0 transition-transform duration-200" :class="{'rotate-90': degreeOpen}" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10l-3.293-3.293a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                                <ul x-show="degreeOpen" x-cloak
                                    @mouseenter="clearTimeout(degreeTimer); clearTimeout(deptTimer)"
                                    @mouseleave="degreeTimer = setTimeout(() => { degreeOpen = false }, 300)"
                                    class="absolute left-full top-0 w-52 lg:w-60 bg-[#0d3a37] shadow-lg z-[60]">
                                    <li><a href="/ba" class="block py-3 text-white hover:bg-[rgb(20,89,84)] pl-5 <?php echo e(request()->is('ba') ? 'bg-[rgb(20,89,84)]' : ''); ?>">BA</a></li>
                                    <li><a href="/bbs" class="block py-3 text-white hover:bg-[rgb(20,89,84)] pl-5 <?php echo e(request()->is('bbs') ? 'bg-[rgb(20,89,84)]' : ''); ?>">BBS</a></li>
                                    <li><a href="/bss" class="block py-3 text-white hover:bg-[rgb(20,89,84)] pl-5 <?php echo e(request()->is('bss') ? 'bg-[rgb(20,89,84)]' : ''); ?>">BSS</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <!-- Facilities -->
                    <li class="relative group">
                        <a href="#"
                            class="block py-3 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 font-medium flex justify-between items-center pr-2 <?php echo e(request()->is('digital-content*') || request()->is('multimedia-classroom*') || request()->is('central-library*') || request()->is('ict-lab*') || request()->is('wifi*') || request()->is('rover-scout*') || request()->is('bncc*') || request()->is('red-crescent*') || request()->is('science-lab*') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">
                            <span class="truncate">Facilities</span>
                            <svg class="h-4 w-4 shrink-0 transition-transform duration-200" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10l-3.293-3.293a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <ul
                            class="absolute left-full top-0 w-52 lg:w-60 bg-[#0d3a37] shadow-lg hidden group-hover:block z-50 max-h-[80vh] overflow-y-auto">
                            <li><a href="/digital-content" class="block py-3 text-white hover:bg-[rgb(20,89,84)] pl-5 <?php echo e(request()->is('digital-content') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Digital Content</a></li>
                            <li><a href="/multimedia-classroom" class="block py-3 text-white hover:bg-[rgb(20,89,84)] pl-5 <?php echo e(request()->is('multimedia-classroom') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Multimedia Classroom</a></li>
                            <li><a href="/central-library" class="block py-3 text-white hover:bg-[rgb(20,89,84)] pl-5 <?php echo e(request()->is('central-library') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Central Library</a></li>
                            <li><a href="/ict-lab" class="block py-3 text-white hover:bg-[rgb(20,89,84)] pl-5 <?php echo e(request()->is('ict-lab') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">ICT Lab</a></li>
                            <li><a href="/wifi" class="block py-3 text-white hover:bg-[rgb(20,89,84)] pl-5 <?php echo e(request()->is('wifi') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Wi-Fi</a></li>
                            <li><a href="/rover-scout" class="block py-3 text-white hover:bg-[rgb(20,89,84)] pl-5 <?php echo e(request()->is('rover-scout') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Rover Scout</a></li>
                            <li><a href="/bncc" class="block py-3 text-white hover:bg-[rgb(20,89,84)] pl-5 <?php echo e(request()->is('bncc') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">BNCC</a></li>
                            <li><a href="/red-crescent" class="block py-3 text-white hover:bg-[rgb(20,89,84)] pl-5 <?php echo e(request()->is('red-crescent') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Red Crescent</a></li>
                            <li><a href="/science-lab" class="block py-3 text-white hover:bg-[rgb(20,89,84)] pl-5 <?php echo e(request()->is('science-lab') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Science Lab</a></li>
                        </ul>
                    </li>

                    <!-- Teacher Information -->
                    <li class="relative group">
                        <a href="#"
                            class="block py-3 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 font-medium flex justify-between items-center pr-2 <?php echo e(request()->is('teacher-information*') || request()->is('teacher-vacant-posts*') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">
                            <span class="truncate">Teacher Information</span>
                            <svg class="h-4 w-4 shrink-0 transition-transform duration-200" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10l-3.293-3.293a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <ul
                            class="absolute left-full top-0 w-52 lg:w-60 bg-[#0d3a37] shadow-lg hidden group-hover:block z-50 max-h-[80vh] overflow-y-auto">
                            <li><a href="/teacher-information" class="block py-3 text-white hover:bg-[rgb(20,89,84)] pl-5 <?php echo e(request()->is('teacher-information') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Teacher Information</a></li>
                            <li><a href="/teacher-vacant-posts" class="block py-3 text-white hover:bg-[rgb(20,89,84)] pl-5 <?php echo e(request()->is('teacher-vacant-posts') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Teacher Vacant Post</a></li>
                            <li><a href="<?php echo e(config('services.external_api.base_url')); ?>accounts/login/employee/" target="_blank" class="block py-3 text-white hover:bg-[rgb(20,89,84)] pl-5">Teacher's Panel</a></li>
                        </ul>
                    </li>

                    <!-- Staff Information -->
                    <li class="relative group">
                        <a href="#"
                            class="block py-3 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 font-medium flex justify-between items-center pr-2 <?php echo e(request()->is('staff-information*') || request()->is('staff-vacant-posts*') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">
                            <span class="truncate">Staff Information</span>
                            <svg class="h-4 w-4 shrink-0 transition-transform duration-200" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10l-3.293-3.293a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <ul
                            class="absolute left-full top-0 w-52 lg:w-60 bg-[#0d3a37] shadow-lg hidden group-hover:block z-50 max-h-[80vh] overflow-y-auto">
                            <li><a href="/staff-information" class="block py-3 text-white hover:bg-[rgb(20,89,84)] pl-5 <?php echo e(request()->is('staff-information') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Staff Information</a></li>
                            <li><a href="/staff-vacant-posts" class="block py-3 text-white hover:bg-[rgb(20,89,84)] pl-5 <?php echo e(request()->is('staff-vacant-posts') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Staff Vacant Post</a></li>
                            <li><a href="<?php echo e(config('services.external_api.base_url')); ?>accounts/login/employee/" target="_blank" class="block py-3 text-white hover:bg-[rgb(20,89,84)] pl-5">Staff's Panel</a></li>
                        </ul>
                    </li>

                    <!-- Student Information -->
                    <li class="relative group">
                        <a href="#"
                            class="block py-3 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 font-medium flex justify-between items-center pr-2 <?php echo e(request()->is('student-details*') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">
                            <span>Student Information</span>
                            <svg class="h-4 w-4 transition-transform duration-200" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10l-3.293-3.293a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <ul
                            class="absolute left-full top-0 w-60 bg-[#0d3a37] shadow-lg hidden group-hover:block z-20">
                            <li><a href="/student-details" class="block py-3 text-white hover:bg-[rgb(20,89,84)] pl-5 <?php echo e(request()->is('student-details') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Student's Details</a></li>
                            <li><a href="<?php echo e(config('services.external_api.base_url')); ?>accounts/login/student/" target="_blank" class="block py-3 text-white hover:bg-[rgb(20,89,84)] pl-5">Student's Panel</a></li>
                        </ul>
                    </li>

                    <!-- Activity -->
                    <li class="relative group">
                        <a href="#"
                            class="block py-3 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 font-medium flex justify-between items-center pr-2 <?php echo e(request()->is('class-routine*') || request()->is('academic-calendar*') || request()->is('exam-routine*') || request()->is('yearly-holidays*') || request()->is('testimonial-tc*') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">
                            <span>Activity</span>
                            <svg class="h-4 w-4 transition-transform duration-200" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10l-3.293-3.293a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <ul
                            class="absolute left-full top-0 w-60 bg-[#0d3a37] shadow-lg hidden group-hover:block z-20">
                            <li><a href="/class-routine" class="block py-3 text-white hover:bg-[rgb(20,89,84)] pl-5 <?php echo e(request()->is('class-routine') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Class Routine</a></li>
                            <li><a href="/academic-calendar" class="block py-3 text-white hover:bg-[rgb(20,89,84)] pl-5 <?php echo e(request()->is('academic-calendar') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Academic Calendar</a></li>
                            <li><a href="/exam-routine" class="block py-3 text-white hover:bg-[rgb(20,89,84)] pl-5 <?php echo e(request()->is('exam-routine') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Exam Routine</a></li>
                            <li><a href="/yearly-holidays" class="block py-3 text-white hover:bg-[rgb(20,89,84)] pl-5 <?php echo e(request()->is('yearly-holidays') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Yearly Holidays List</a></li>
                            <li><a href="/testimonial-tc" target="_blank" class="block py-3 text-white hover:bg-[rgb(20,89,84)] pl-5 <?php echo e(request()->is('testimonial-tc') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Testimonial and TC</a></li>
                        </ul>
                    </li>

                    <!-- Archive -->
                    <li class="relative group">
                        <a href="#"
                            class="block py-3 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 font-medium flex justify-between items-center pr-2 <?php echo e(request()->is('ex-teacher-list*') || request()->is('magazine*') || request()->is('exam-results*') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">
                            <span>Archive</span>
                            <svg class="h-4 w-4 transition-transform duration-200" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10l-3.293-3.293a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <ul
                            class="absolute left-full top-0 w-60 bg-[#0d3a37] shadow-lg hidden group-hover:block z-20">
                            <li><a href="/ex-teacher-list" class="block py-3 text-white hover:bg-[rgb(20,89,84)] pl-5 <?php echo e(request()->is('ex-teacher-list') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Ex. Teacher List</a></li>
                            <li><a href="/magazine" class="block py-3 text-white hover:bg-[rgb(20,89,84)] pl-5 <?php echo e(request()->is('magazine') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Magazine</a></li>
                            <li><a href="/exam-results" class="block py-3 text-white hover:bg-[rgb(20,89,84)] pl-5 <?php echo e(request()->is('exam-results') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Three Years Public Exam Result</a></li>
                        </ul>
                    </li>

                    <!-- Feedback -->
                    <li>
                        <a href="/feedback" class="block py-3 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 font-medium <?php echo e(request()->is('feedback') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">
                            <span>Feedback</span>
                        </a>
                    </li>
                </ul>
            </aside>

            <!-- Mobile Sidebar -->
            <div x-show="sidebarOpen" class="fixed inset-0 z-40 md:hidden" x-cloak>
                <div @click="sidebarOpen = false" class="absolute inset-0 bg-black/40"></div>
                <aside class="relative h-full w-4/5 max-w-xs overflow-auto bg-white shadow-xl">
                    <div class="bg-[rgb(20,89,84)] px-4 py-3 flex items-center justify-between">
                        <div class="font-semibold text-base text-white">Menu</div>
                        <button @click="sidebarOpen = false" class="text-xl text-white hover:text-gray-200">✕</button>
                    </div>
                    <ul class="divide-y divide-gray-200">
                        <!-- About College -->
                        <li x-data="{ open: false }">
                            <a href="#" @click.prevent="open = !open"
                                class="block py-3 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 flex justify-between items-center <?php echo e(request()->is('about*') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">
                                <span>About College</span>
                                <svg class="h-4 w-4 transition-transform" :class="{'rotate-90': open}"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10l-3.293-3.293a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                            <ul x-show="open" class="pl-4 space-y-1" x-cloak>
                                <li><a href="/about" class="block py-2 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 <?php echo e(request()->is('about') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">About Us</a></li>
                                <li><a href="/at-a-glance" class="block py-2 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 <?php echo e(request()->is('at-a-glance') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">At A Glance</a></li>
                            </ul>
                        </li>                        <!-- Academic -->
                        <li x-data="{ open: false }">
                            <a href="#" @click.prevent="open = !open"
                                class="block py-3 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 flex justify-between items-center <?php echo e(request()->is('apply*') || request()->is('teacher/apply*') || request()->is('principle-list*') || request()->is('vice-principle-list*') || request()->is('governing-board*') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">
                                <span>Academic</span>
                                <svg class="h-4 w-4 transition-transform" :class="{'rotate-90': open}"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10l-3.293-3.293a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                            <ul x-show="open" class="pl-4 space-y-1" x-cloak>
                                <li><a href="/apply" class="block py-2 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 <?php echo e(request()->is('apply*') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Admission</a></li>
                                <li><a href="/teacher/apply" class="block py-2 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 <?php echo e(request()->is('teacher/apply') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Teacher Application</a></li>
                                <li><a href="/principle-list" class="block py-2 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 <?php echo e(request()->is('principle-list') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Principal
                                        List</a>
                                </li>
                                <li><a href="/vice-principle-list" class="block py-2 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 <?php echo e(request()->is('vice-principle-list') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Vice
                                        Principal
                                        List</a></li>
                                <li><a href="/governing-board" class="block py-2 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 <?php echo e(request()->is('governing-board') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">GB</a></li>
                            </ul>
                        </li>

                        <!-- Department -->
                        <li x-data="{ open: false }">
                            <a href="#" @click.prevent="open = !open"
                                class="block py-3 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 flex justify-between items-center <?php echo e(request()->is('science*') || request()->is('business-studies*') || request()->is('humanities*') || request()->is('accounting*') || request()->is('management*') || request()->is('economics*') || request()->is('ba*') || request()->is('bbs*') || request()->is('bss*') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">
                                <span>Department</span>
                                <svg class="h-4 w-4 transition-transform" :class="{'rotate-90': open}"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10l-3.293-3.293a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                            <ul x-show="open" class="pl-4 space-y-1" x-cloak>
                                <!-- HSC -->
                                <li x-data="{ open: false }">
                                    <a href="#" @click.prevent="open = !open"
                                        class="block py-2 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 flex justify-between items-center <?php echo e(request()->is('science*') || request()->is('business-studies*') || request()->is('humanities*') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">
                                        <span>HSC</span>
                                        <svg class="h-3 w-3 transition-transform" :class="{'rotate-90': open}"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10l-3.293-3.293a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                    <ul x-show="open" class="pl-4 space-y-1" x-cloak>
                                        <li><a href="/science" class="block py-2 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 <?php echo e(request()->is('science') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Science</a></li>
                                        <li><a href="/business-studies" class="block py-2 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 <?php echo e(request()->is('business-studies') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Business Studies</a></li>
                                        <li><a href="/humanities" class="block py-2 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 <?php echo e(request()->is('humanities') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Humanities</a></li>
                                    </ul>
                                </li>
                                <!-- Honours -->
                                <li x-data="{ open: false }">
                                    <a href="#" @click.prevent="open = !open"
                                        class="block py-2 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 flex justify-between items-center <?php echo e(request()->is('accounting*') || request()->is('management*') || request()->is('economics*') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">
                                        <span>Honours</span>
                                        <svg class="h-3 w-3 transition-transform" :class="{'rotate-90': open}"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10l-3.293-3.293a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                    <ul x-show="open" class="pl-4 space-y-1" x-cloak>
                                        <li><a href="/accounting" class="block py-2 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 <?php echo e(request()->is('accounting') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Accounting</a></li>
                                        <li><a href="/management" class="block py-2 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 <?php echo e(request()->is('management') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Management</a></li>
                                        <li><a href="/economics" class="block py-2 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 <?php echo e(request()->is('economics') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Economics</a></li>
                                    </ul>
                                </li>
                                <!-- Degree -->
                                <li x-data="{ open: false }">
                                    <a href="#" @click.prevent="open = !open"
                                        class="block py-2 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 flex justify-between items-center <?php echo e(request()->is('ba*') || request()->is('bbs*') || request()->is('bss*') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">
                                        <span>Degree</span>
                                        <svg class="h-3 w-3 transition-transform" :class="{'rotate-90': open}"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10l-3.293-3.293a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                    <ul x-show="open" class="pl-4 space-y-1" x-cloak>
                                        <li><a href="/ba" class="block py-2 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 <?php echo e(request()->is('ba') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">BA</a></li>
                                        <li><a href="/bbs" class="block py-2 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 <?php echo e(request()->is('bbs') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">BBS</a></li>
                                        <li><a href="/bss" class="block py-2 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 <?php echo e(request()->is('bss') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">BSS</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <!-- Facilities -->
                        <li x-data="{ open: false }">
                            <a href="#" @click.prevent="open = !open"
                                class="block py-3 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 flex justify-between items-center <?php echo e(request()->is('digital-content*') || request()->is('multimedia-classroom*') || request()->is('central-library*') || request()->is('ict-lab*') || request()->is('wifi*') || request()->is('rover-scout*') || request()->is('bncc*') || request()->is('red-crescent*') || request()->is('science-lab*') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">
                                <span>Facilities</span>
                                <svg class="h-4 w-4 transition-transform" :class="{'rotate-90': open}"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10l-3.293-3.293a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                            <ul x-show="open" class="pl-4 space-y-1" x-cloak>
                                <li><a href="/digital-content" class="block py-2 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 <?php echo e(request()->is('digital-content') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Digital Content</a></li>
                                <li><a href="/multimedia-classroom" class="block py-2 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 <?php echo e(request()->is('multimedia-classroom') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Multimedia Classroom</a></li>
                                <li><a href="/central-library" class="block py-2 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 <?php echo e(request()->is('central-library') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Central Library</a></li>
                                <li><a href="/ict-lab" class="block py-2 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 <?php echo e(request()->is('ict-lab') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">ICT Lab</a></li>
                                <li><a href="/wifi" class="block py-2 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 <?php echo e(request()->is('wifi') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Wi-Fi</a></li>
                                <li><a href="/rover-scout" class="block py-2 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 <?php echo e(request()->is('rover-scout') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Rover Scout</a></li>
                                <li><a href="/bncc" class="block py-2 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 <?php echo e(request()->is('bncc') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">BNCC</a></li>
                                <li><a href="/red-crescent" class="block py-2 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 <?php echo e(request()->is('red-crescent') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Red Crescent</a></li>
                                <li><a href="/science-lab" class="block py-2 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 <?php echo e(request()->is('science-lab') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Science Lab</a></li>
                            </ul>
                        </li>

                        <!-- Teacher Information -->
                        <li x-data="{ open: false }">
                            <a href="#" @click.prevent="open = !open"
                                class="block py-3 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 flex justify-between items-center <?php echo e(request()->is('teacher-information*') || request()->is('teacher-vacant-posts*') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">
                                <span>Teacher Information</span>
                                <svg class="h-4 w-4 transition-transform" :class="{'rotate-90': open}"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10l-3.293-3.293a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                            <ul x-show="open" class="pl-4 space-y-1" x-cloak>
                                <li><a href="/teacher-information" class="block py-2 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 <?php echo e(request()->is('teacher-information') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Teacher Information</a></li>
                                <li><a href="/teacher-vacant-posts" class="block py-2 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 <?php echo e(request()->is('teacher-vacant-posts') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Teacher Vacant Post</a></li>
                                <li><a href="<?php echo e(config('services.external_api.base_url')); ?>accounts/login/employee/" target="_blank" class="block py-2 hover:bg-[rgb(20,89,84)] hover:text-white pl-2">Teacher's Panel</a></li>
                            </ul>
                        </li>

                        <!-- Staff Information -->
                        <li x-data="{ open: false }">
                            <a href="#" @click.prevent="open = !open"
                                class="block py-3 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 flex justify-between items-center <?php echo e(request()->is('staff-information*') || request()->is('staff-vacant-posts*') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">
                                <span>Staff Information</span>
                                <svg class="h-4 w-4 transition-transform" :class="{'rotate-90': open}"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10l-3.293-3.293a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                            <ul x-show="open" class="pl-4 space-y-1" x-cloak>
                                <li><a href="/staff-information" class="block py-2 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 <?php echo e(request()->is('staff-information') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Staff Information</a></li>
                                <li><a href="/staff-vacant-posts" class="block py-2 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 <?php echo e(request()->is('staff-vacant-posts') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Staff Vacant Post</a></li>
                                <li><a href="<?php echo e(config('services.external_api.base_url')); ?>accounts/login/employee/" target="_blank" class="block py-2 hover:bg-[rgb(20,89,84)] hover:text-white pl-2">Staff's Panel</a></li>
                            </ul>
                        </li>

                        <!-- Student Information -->
                        <li x-data="{ open: false }">
                            <a href="#" @click.prevent="open = !open"
                                class="block py-3 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 flex justify-between items-center <?php echo e(request()->is('student-details*') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">
                                <span>Student Information</span>
                                <svg class="h-4 w-4 transition-transform" :class="{'rotate-90': open}"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10l-3.293-3.293a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                            <ul x-show="open" class="pl-4 space-y-1" x-cloak>
                                <li><a href="/student-details" class="block py-2 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 <?php echo e(request()->is('student-details') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Student's Details</a></li>
                                <li><a href="<?php echo e(config('services.external_api.base_url')); ?>accounts/login/student/" target="_blank" class="block py-2 hover:bg-[rgb(20,89,84)] hover:text-white pl-2">Student's Panel</a></li>
                            </ul>
                        </li>

                        <!-- Activity -->
                        <li x-data="{ open: false }">
                            <a href="#" @click.prevent="open = !open"
                                class="block py-3 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 flex justify-between items-center <?php echo e(request()->is('class-routine*') || request()->is('academic-calendar*') || request()->is('exam-routine*') || request()->is('yearly-holidays*') || request()->is('testimonial-tc*') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">
                                <span>Activity</span>
                                <svg class="h-4 w-4 transition-transform" :class="{'rotate-90': open}"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10l-3.293-3.293a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                            <ul x-show="open" class="pl-4 space-y-1" x-cloak>
                                <li><a href="/class-routine" class="block py-2 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 <?php echo e(request()->is('class-routine') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Class Routine</a></li>
                                <li><a href="/academic-calendar" class="block py-2 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 <?php echo e(request()->is('academic-calendar') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Academic Calendar</a></li>
                                <li><a href="/exam-routine" class="block py-2 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 <?php echo e(request()->is('exam-routine') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Exam Routine</a></li>
                                <li><a href="/yearly-holidays" class="block py-2 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 <?php echo e(request()->is('yearly-holidays') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Yearly Holidays List</a></li>
                                <li><a href="/testimonial-tc" target="_blank" class="block py-2 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 <?php echo e(request()->is('testimonial-tc') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Testimonial and TC</a></li>
                            </ul>
                        </li>

                        <!-- Archive -->
                        <li x-data="{ open: false }">
                            <a href="#" @click.prevent="open = !open"
                                class="block py-3 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 flex justify-between items-center <?php echo e(request()->is('ex-teacher-list*') || request()->is('magazine*') || request()->is('exam-results*') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">
                                <span>Archive</span>
                                <svg class="h-4 w-4 transition-transform" :class="{'rotate-90': open}"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10l-3.293-3.293a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                            <ul x-show="open" class="pl-4 space-y-1" x-cloak>
                                <li><a href="/ex-teacher-list" class="block py-2 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 <?php echo e(request()->is('ex-teacher-list') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Ex. Teacher List</a></li>
                                <li><a href="/magazine" class="block py-2 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 <?php echo e(request()->is('magazine') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Magazine</a></li>
                                <li><a href="/exam-results" class="block py-2 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 <?php echo e(request()->is('exam-results') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Three Years Public Exam Result</a></li>
                            </ul>
                        </li>

                        <!-- Feedback -->
                        <li>
                            <a href="/feedback" class="block py-3 hover:bg-[rgb(20,89,84)] hover:text-white pl-2 font-medium <?php echo e(request()->is('feedback') ? 'bg-[rgb(20,89,84)] text-white' : ''); ?>">Feedback</a>
                        </li>
                    </ul>
                </aside>
            </div>

            <main class="flex-1 p-2 md:p-4 h-full overflow-y-auto custom-scrollbar">
                <?php echo $__env->yieldContent('content'); ?>
            </main>
    </div>

    <!-- Footer Section (Fixed at bottom on Desktop) -->
    <footer class="md:shrink-0 bg-green-900 text-white w-full z-10" x-ref="footer">
        <!-- Links Section -->
        <div class="w-full border-b border-green-800 bg-[#225c4c] item-center">
            <ul class="text-[12px] flex flex-wrap justify-center md:justify-center gap-x-1 gap-y-2 p-2">
                <?php $__currentLoopData = $websiteLinks ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="bg-[#0e3f3c] px-1"><a href="<?php echo e($link->url); ?>" target="_blank"
                        class="hover:text-green-300 transition whitespace-nowrap"><?php echo e($link->name); ?></a></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>

        <!-- Copyright Section with Social Icons -->
        <div class="flex flex-col md:flex-row items-center justify-center gap-4 p-1 bg-[#0e3f3c]">
            <!-- Copyright Text -->
            <div class="text-[14px] text-center md:text-left">
                <p>&copy; <?php echo e(date('Y')); ?> Hazera-Taju Degree College. All rights reserved.</p>
            </div>

            <!-- Social Media Icons -->
            <div class="flex items-center gap-4">
                <?php if(isset($settings) && $settings->facebook_url): ?>
                <a href="<?php echo e($settings->facebook_url); ?>" target="_blank" class="group" aria-label="Facebook">
                    <svg class="w-6 h-6 text-white group-hover:text-blue-500 transition" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                    </svg>
                </a>
                <?php endif; ?>
                <?php if(isset($settings) && $settings->youtube_url): ?>
                <a href="<?php echo e($settings->youtube_url); ?>" target="_blank" class="group" aria-label="YouTube">
                    <svg class="w-6 h-6 text-white group-hover:text-red-500 transition" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                    </svg>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </footer>

</body>

</html><?php /**PATH D:\Project Conver\laravelPr\resources\views/layouts/app.blade.php ENDPATH**/ ?>