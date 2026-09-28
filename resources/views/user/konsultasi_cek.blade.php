@extends('layouts.app')

@section('content')
<div class="bg-red-50 min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-10 reveal">
            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4">Cek Status Konsultasi</h1>
            <p class="text-slate-600">Masukkan Nomor HP Anda untuk melihat semua riwayat pertanyaan dan jawaban dari Admin Dinas Perdagangan Wonogiri.</p>
        </div>

        <!-- Search Card -->
        <div class="bg-white rounded-[24px] p-6 sm:p-8 shadow-sm border border-slate-100 mb-8 reveal delay-100">
            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl font-medium text-sm text-center">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('konsultasi.cek') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <input type="text" name="phone" value="{{ request('phone') }}" required placeholder="Masukkan Nomor HP Anda..." class="w-full px-4 py-3.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-[#991b1b] focus:border-[#991b1b] outline-none transition-all text-slate-800 font-medium">
                </div>
                <button type="submit" class="bg-[#800000] hover:bg-[#600000] text-white px-8 py-3.5 rounded-xl font-bold transition-all shadow-md shrink-0">
                    Cek Status
                </button>
            </form>
        </div>

        <!-- Result Card -->
        @if(isset($consultations) && $consultations->count() > 0)
        <div class="space-y-6 reveal delay-200">
            @foreach($consultations as $consultation)
            <div class="bg-white rounded-[24px] shadow-sm border border-slate-100 overflow-hidden">
                <div class="border-b border-slate-100 bg-slate-50 p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <p class="text-sm text-slate-500 font-semibold mb-1">Nomor Tiket</p>
                        <h3 class="text-xl font-black text-slate-900">{{ $consultation->ticket_id }}</h3>
                    </div>
                    
                    <div>
                        @if($consultation->status == 'menunggu')
                            <span class="inline-flex items-center gap-1.5 bg-yellow-100 text-yellow-800 px-4 py-2 rounded-full text-sm font-bold shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Menunggu Balasan
                            </span>
                        @elseif($consultation->status == 'diproses')
                            <span class="inline-flex items-center gap-1.5 bg-blue-100 text-blue-800 px-4 py-2 rounded-full text-sm font-bold shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                Sedang Diproses
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm font-bold shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Sudah Dijawab
                            </span>
                        @endif
                    </div>
                </div>

                <div class="p-6 md:p-8 space-y-6">
                    <!-- User Question -->
                    <div>
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold">
                                {{ substr($consultation->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-bold text-slate-900">{{ $consultation->name }}</p>
                                <p class="text-xs text-slate-500">{{ $consultation->created_at->format('d M Y, H:i') }} • Topik: {{ $consultation->subject }}</p>
                            </div>
                        </div>
                        <div class="bg-slate-50 p-5 rounded-2xl text-slate-700 text-sm leading-relaxed border border-slate-100 ml-0 sm:ml-13">
                            {{ $consultation->message }}
                            
                            @if($consultation->attachment)
                                <div class="mt-4 pt-4 border-t border-slate-200">
                                    <p class="text-xs font-semibold text-slate-500 mb-2">Lampiran Berkas:</p>
                                    <a href="{{ asset('storage/' . $consultation->attachment) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors shadow-sm">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                        <span class="text-sm font-medium text-slate-700">Lihat Lampiran</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Admin Response -->
                    <div class="pt-2">
                        @if($consultation->response)
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 rounded-full bg-[#800000] flex items-center justify-center text-white font-bold">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <div>
                                    <p class="font-bold text-slate-900">Admin Dinas Perdagangan</p>
                                    <p class="text-xs text-slate-500">{{ $consultation->updated_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                            <div class="bg-red-50 p-5 rounded-2xl text-slate-800 text-sm leading-relaxed border border-red-100 ml-0 sm:ml-13 shadow-sm">
                                {!! nl2br(e($consultation->response)) !!}
                            </div>
                        @else
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center text-slate-400 font-bold">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <p class="font-bold text-slate-400">Admin</p>
                                </div>
                            </div>
                            <div class="bg-slate-50 p-5 rounded-2xl text-slate-400 text-sm italic border border-slate-100 ml-0 sm:ml-13 text-center">
                                Admin belum memberikan balasan untuk pertanyaan ini.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
            
            <div class="text-center pt-6 mt-6">
                <a href="{{ route('konsultasi') }}" class="text-[#800000] font-bold text-sm hover:underline bg-white px-6 py-3 rounded-xl shadow-sm border border-slate-200 inline-block">
                    &larr; Buat Pengajuan Konsultasi Baru
                </a>
            </div>
        </div>
        @endif
        
    </div>
</div>
@endsection
