@extends('visitor.layouts.app')

@section('title', $page->title . ' | Yuvar Dhan - Strength & Vitality')
@section('meta_description', $page->title . ' - Official policy document of Yuvar Dhan and M.C.D.C.R. Vaidraj Disease Eradication Center.')

@section('content')
<!-- Policy Hero Header -->
<section class="policy-hero-section">
  <div class="container-custom">
    <div class="policy-breadcrumb">
      <a href="{{ route('home') }}"><i class="bi bi-house-door me-1"></i> Home</a>
      <span>/</span>
      <span class="text-white">{{ $page->title }}</span>
    </div>
    <h1 class="display-5 fw-bold text-white mb-2" style="font-family: var(--font-heading);">
      {{ $page->title }}
    </h1>
    <p class="mb-0" style="color: var(--silver-color); max-width: 650px;">
      Official guidelines and policies of Yuvar Dhan, associated with M.C.D.C.R. Vaidraj Disease Eradication Center (serving patients since 2022).
    </p>
  </div>
</section>

<!-- Policy Content Section -->
<section class="py-5" style="background-color: var(--body-bg);">
  <div class="container-custom">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        
        <div class="policy-card">
          {!! $page->content ?: $page->detail !!}
        </div>

      </div>
    </div>
  </div>
</section>
@endsection
