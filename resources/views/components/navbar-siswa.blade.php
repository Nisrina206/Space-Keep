<div class="siswa-navbar">
    <div class="navbar-left">
        <h1 class="navbar-title">
            @yield('navbar-title', 'Dashboard')
        </h1>
    </div>

    <div class="navbar-icons">

@php
use Carbon\Carbon;

$notif = \App\Models\Notifikasi::where('target_id', auth()->user()->id)
            ->orderBy('created_at','desc')
            ->get();

$today = $notif->filter(fn($n) => $n->created_at->isToday());
$yesterday = $notif->filter(fn($n) => $n->created_at->isYesterday());
$others = $notif->filter(fn($n) => !$n->created_at->isToday() && !$n->created_at->isYesterday());

$unread = $notif->where('is_read', false)->count();
@endphp

        <div class="notif-wrapper">

            {{-- ICON --}}
            <img src="{{ asset('img/notif.png') }}"
                 alt="Notifikasi"
                 id="notifToggle"
                 class="notif-icon">

            {{-- BADGE --}}
            @if($unread > 0)
                <span class="notif-badge">{{ $unread }}</span>
            @endif

            {{-- PANEL --}}
            <div id="notifPanel" class="notif-dropdown">

                {{-- HEADER --}}
                <div class="notif-header">
                    <div class="notif-title">
                        <strong>Notifikasi</strong>

                        @if($unread > 0)
                            <span class="notif-count">{{ $unread }}</span>
                        @endif
                    </div>
                </div>

                <div class="notif-container">

                    {{-- ================= HARI INI ================= --}}
                    @if($today->count())
                    <div class="notif-group-title">Hari ini</div>

                    @foreach($today as $n)
                    <a href="{{ route('notif.baca',$n->id_notif) }}"
                       class="notif-item {{ $n->is_read ? '' : 'unread' }}">

                        <div class="notif-icon-box">

                            @php
                                $pesan = strtolower($n->pesan);
                            @endphp

                            @if(str_contains($pesan,'selesai'))
                                <img src="{{ asset('img/notifgreen.png') }}">
                            @elseif(str_contains($pesan,'diproses'))
                                <img src="{{ asset('img/notiforen.png') }}">
                            @else
                                <img src="{{ asset('img/notiforen.png') }}">
                            @endif

                        </div>

                        <div class="notif-text">
                            <div class="notif-top">
                                <span class="notif-judul">{{ $n->judul }}</span>
                                <span class="notif-time">{{ $n->created_at->diffForHumans() }}</span>
                            </div>

                            <div class="notif-pesan">
                                {{ $n->pesan }}
                            </div>
                        </div>

                    </a>
                    @endforeach
                    @endif


                    {{-- ================= KEMARIN ================= --}}
                    @if($yesterday->count())
                    <div class="notif-group-title">Kemarin</div>

                    @foreach($yesterday as $n)
                    <a href="{{ route('notif.baca',$n->id_notif) }}"
                       class="notif-item {{ $n->is_read ? '' : 'unread' }}">

                        <div class="notif-icon-box">

                            @php
                                $pesan = strtolower($n->pesan);
                            @endphp

                            @if(str_contains($pesan,'selesai'))
                                <img src="{{ asset('img/notifgreen.png') }}">
                            @elseif(str_contains($pesan,'diproses'))
                                <img src="{{ asset('img/notiforen.png') }}">
                            @else
                                <img src="{{ asset('img/notiforen.png') }}">
                            @endif

                        </div>

                        <div class="notif-text">
                            <div class="notif-top">
                                <span class="notif-judul">{{ $n->judul }}</span>
                                <span class="notif-time">{{ $n->created_at->diffForHumans() }}</span>
                            </div>

                            <div class="notif-pesan">
                                {{ $n->pesan }}
                            </div>
                        </div>

                    </a>
                    @endforeach
                    @endif


                    {{-- ================= TANGGAL LAMA ================= --}}
                    @if($others->count())

                    @php
                    $grouped = $others->groupBy(function($n){
                        return $n->created_at->format('Y-m-d');
                    });
                    @endphp

                    @foreach($grouped as $date => $items)

                    <div class="notif-group-title">
                        {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}
                    </div>

                    @foreach($items as $n)
                    <a href="{{ route('notif.baca',$n->id_notif) }}"
                       class="notif-item {{ $n->is_read ? '' : 'unread' }}">

                        <div class="notif-icon-box">

                            @php
                                $pesan = strtolower($n->pesan);
                            @endphp

                            @if(str_contains($pesan,'selesai'))
                                <img src="{{ asset('img/notifgreen.png') }}">
                            @elseif(str_contains($pesan,'diproses'))
                                <img src="{{ asset('img/notiforen.png') }}">
                            @else
                                <img src="{{ asset('img/notiforen.png') }}">
                            @endif

                        </div>

                        <div class="notif-text">
                            <div class="notif-top">
                                <span class="notif-judul">{{ $n->judul }}</span>
                                <span class="notif-time">{{ $n->created_at->diffForHumans() }}</span>
                            </div>

                            <div class="notif-pesan">
                                {{ $n->pesan }}
                            </div>
                        </div>

                    </a>
                    @endforeach

                    @endforeach
                    @endif

                </div>

                {{-- ================= BACA SEMUA ================= --}}
                @if($unread > 0)
                <form method="POST" action="{{ route('notif.bacaSemua') }}">
                    @csrf 
                    <button class="notif-readall"> 
                        ✔ Tandai telah dibaca semua
                     </button> 
                </form> 
                @endif

            </div>
        </div>

    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const toggle = document.getElementById("notifToggle");
    const panel  = document.getElementById("notifPanel");

    if(toggle && panel){

        toggle.addEventListener("click", function(e){
            e.stopPropagation();
            panel.style.display =
                panel.style.display === "block" ? "none" : "block";
        });

        document.addEventListener("click", function(e){
            if(!panel.contains(e.target) && e.target !== toggle){
                panel.style.display = "none";
            }
        });

    }

});
</script>