{{-- @extends('web.blog.section') --}}

@section('title', 'About')

@section('path')
    <div class="path-section">
        <h2 class="section-title"> / {{$viewModel->viewModule}} </h2>
    </div>
@endsection

@extends('web.layout')

@section('breadcrumbs')

    @include('web.partial.breadcrumbs', ['paths' => $viewModel->viewPath])

@endsection

@section('module')
    <!-- ===== A B O U T ===== -->
    <section class="about">

        <article class="about-author"
                 style="background-image: url('{{ asset('assets/images/about-author-header.png')}}')">
            @include('web.partial.author')
        </article>

        @foreach ($viewModel->model as $section)
            <article class="about-section">

                <header class="about-section_header section_header"
                        style="background-image: url('{{ asset($section->thumbnail) }}');">

                    <div class="about-section_header-icon section_header-icon">
                        <i class="{{ $section->icon }}"></i>
                    </div>

                    <h3 class="about-section_header-name section_header-name">
                        {{ $section->title}}
                    </h3>

                </header>

                <section class="about-section_body">
                    {!! $section->content !!}
                </section>

                <footer class="about-section_footer">

                </footer>

            </article>
        @endforeach

    </section>
@endsection
