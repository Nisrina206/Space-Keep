@extends('layouts.app')

@section('title', 'Splash Screen')

@section('content')
<div class="splash">
    <div class="brand">

        <!-- LOGO -->
        <img src="{{ asset('img/Spacekeep-white.png') }}" alt="Logo Sekolah" class="logo">

        <!-- GARIS -->
        <span class="divider">|</span>

        <!-- TEKS -->
        <div class="text-mask"></div>
        <div class="text">
            <span class="smkn">SpaceKeep</span>
            <span class="school">SMKN 4 BOJONEGORO</span>
        </div>

        <script>
            setTimeout(() => {
                window.location.href = "/landing";
            }, 3500); // 3,5 detik
        </script>


    </div>
</div>
@endsection
