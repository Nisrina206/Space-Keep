<div class="admin-navbar">

    <div class="navbar-left">
        <h1 class="navbar-title">
            @yield('navbar-title', 'Dashboard')
        </h1>
    </div>

    <div class="navbar-icons">

        {{-- HISTORY --}}
        <a href="{{ route('admin.history') }}">
            <img src="{{ asset('img/history.png') }}" class="history-icon">
        </a>

        @php
            use Carbon\Carbon;

            $notif = \App\Models\Notifikasi::where('target_id', auth()->user()->id)
                        ->orderBy('created_at','desc')
                        ->get();

            $today     = $notif->filter(fn($n)=>$n->created_at->isToday());
            $yesterday = $notif->filter(fn($n)=>$n->created_at->isYesterday());
            $others    = $notif->filter(fn($n)=>!$n->created_at->isToday() && !$n->created_at->isYesterday());

            $unread = $notif->where('is_read', false)->count();
        @endphp

        <div class="notif-wrapper">

            <img src="{{ asset('img/notif.png') }}"
                 id="notifToggle"
                 class="notif-icon">

            @if($unread > 0)
                <span class="notif-badge">{{ $unread }}</span>
            @endif

            <div class="notif-panel" id="notifPanel">

                <div class="notif-header">
                    <span>Notifikasi</span>

                    @if($unread > 0)
                        <span class="notif-count">{{ $unread }}</span>
                    @endif
                </div>

                <div class="notif-content">

                    {{-- HARI INI --}}
                    @if($today->count())

                        <div class="notif-group">Hari ini</div>

                        @foreach($today as $n)

                        <a href="{{ route('notif.baca',$n->id_notif) }}"
                           class="notif-item {{ $n->is_read ? '' : 'unread' }}">

                            <div class="notif-icon-box">

                                @if(str_contains(strtolower($n->judul),'aspirasi'))
                                    <img src="{{ asset('img/notifblue.png') }}">

                                @elseif(str_contains(strtolower($n->judul),'login'))
                                    <img src="{{ asset('img/notifgreen.png') }}">

                                @else
                                    <img src="{{ asset('img/notifblue.png') }}">
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


                    {{-- KEMARIN --}}
                    @if($yesterday->count())

                        <div class="notif-group">Kemarin</div>

                        @foreach($yesterday as $n)

                        <a href="{{ route('notif.baca',$n->id_notif) }}"
                           class="notif-item {{ $n->is_read ? '' : 'unread' }}">

                            <div class="notif-icon-box">

                                @if(str_contains(strtolower($n->judul),'aspirasi'))
                                    <img src="{{ asset('img/notifblue.png') }}">

                                @elseif(str_contains(strtolower($n->judul),'login'))
                                    <img src="{{ asset('img/notifgreen.png') }}">

                                @else
                                    <img src="{{ asset('img/notifblue.png') }}">
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


                    {{-- TANGGAL LAMA --}}
                    @if($others->count())

                        @php
                            $grouped = $others->groupBy(function($n){
                                return $n->created_at->format('Y-m-d');
                            });
                        @endphp

                        @foreach($grouped as $date => $items)

                            <div class="notif-group">
                                {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}
                            </div>

                            @foreach($items as $n)

                            <a href="{{ route('notif.baca',$n->id_notif) }}"
                               class="notif-item {{ $n->is_read ? '' : 'unread' }}">

                                <div class="notif-icon-box">

                                    @if(str_contains(strtolower($n->judul),'aspirasi'))
                                        <img src="{{ asset('img/notifblue.png') }}">

                                    @elseif(str_contains(strtolower($n->judul),'login'))
                                        <img src="{{ asset('img/notifgreen.png') }}">

                                    @else
                                        <img src="{{ asset('img/notifblue.png') }}">
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
document.addEventListener("DOMContentLoaded", function(){

    const toggle = document.getElementById("notifToggle");
    const panel  = document.getElementById("notifPanel");

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

});
</script>