@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navigasi Halaman" class="flex flex-col sm:flex-row items-center justify-between gap-4 py-2 select-none">
        
        {{-- Mobile View (Kompak & Bersih) --}}
        <div class="flex items-center justify-between w-full sm:hidden gap-2">
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-bold text-slate-300 bg-slate-50 border border-slate-200/80 rounded-xl cursor-not-allowed select-none">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                    <span>Sebelumnya</span>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-bold text-slate-700 bg-white border border-slate-200 rounded-xl shadow-2xs hover:bg-red-50 hover:text-[#800000] hover:border-red-200 transition-all duration-200">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                    <span>Sebelumnya</span>
                </a>
            @endif

            <span class="text-xs font-semibold text-slate-600 bg-slate-100 px-3 py-1.5 rounded-lg border border-slate-200/80">
                Hal. <strong class="text-[#800000]">{{ $paginator->currentPage() }}</strong> dari <strong>{{ $paginator->lastPage() }}</strong>
            </span>

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-bold text-slate-700 bg-white border border-slate-200 rounded-xl shadow-2xs hover:bg-red-50 hover:text-[#800000] hover:border-red-200 transition-all duration-200">
                    <span>Berikutnya</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                </a>
            @else
                <span class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-bold text-slate-300 bg-slate-50 border border-slate-200/80 rounded-xl cursor-not-allowed select-none">
                    <span>Berikutnya</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                </span>
            @endif
        </div>

        {{-- Desktop View (Elegan dengan Ringkasan & Floating Pill) --}}
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between w-full gap-4">
            {{-- Summary Information --}}
            <div>
                <p class="text-xs text-slate-500 leading-relaxed font-medium">
                    Menampilkan 
                    @if ($paginator->firstItem())
                        <span class="font-bold text-slate-800">{{ $paginator->firstItem() }}</span>
                        sampai 
                        <span class="font-bold text-slate-800">{{ $paginator->lastItem() }}</span>
                    @else
                        <span class="font-bold text-slate-800">{{ $paginator->count() }}</span>
                    @endif
                    dari 
                    <span class="font-bold text-[#800000]">{{ $paginator->total() }}</span> 
                    data
                </p>
            </div>

            {{-- Floating Pill Navigation Buttons --}}
            <div>
                <div class="inline-flex items-center gap-1.5 p-1.5 bg-white border border-slate-200/90 rounded-2xl shadow-xs">

                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl flex items-center justify-center text-slate-300 bg-slate-50 border border-slate-100 cursor-not-allowed select-none" title="Halaman Pertama">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl flex items-center justify-center text-slate-700 bg-white border border-slate-200 hover:border-red-200 hover:bg-red-50 hover:text-[#800000] hover:-translate-y-0.5 hover:shadow-xs transition-all duration-200" title="Halaman Sebelumnya">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span class="w-7 h-9 sm:h-10 flex items-center justify-center text-slate-400 font-black tracking-widest text-xs">
                                &hellip;
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span class="min-w-[38px] sm:min-w-[40px] h-9 sm:h-10 px-2.5 rounded-xl flex items-center justify-center text-sm font-black bg-gradient-to-r from-[#800000] via-[#941515] to-[#800000] text-white shadow-md shadow-red-950/20 ring-2 ring-red-900/10 cursor-default">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="min-w-[38px] sm:min-w-[40px] h-9 sm:h-10 px-2.5 rounded-xl flex items-center justify-center text-sm font-bold bg-white text-slate-700 border border-slate-200/80 hover:border-red-200 hover:bg-red-50 hover:text-[#800000] hover:-translate-y-0.5 hover:shadow-xs transition-all duration-200">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl flex items-center justify-center text-slate-700 bg-white border border-slate-200 hover:border-red-200 hover:bg-red-50 hover:text-[#800000] hover:-translate-y-0.5 hover:shadow-xs transition-all duration-200" title="Halaman Berikutnya">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                        </a>
                    @else
                        <span class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl flex items-center justify-center text-slate-300 bg-slate-50 border border-slate-100 cursor-not-allowed select-none" title="Halaman Terakhir">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                        </span>
                    @endif

                </div>
            </div>
        </div>

    </nav>
@endif
