@include('plantshop.includes.header')
<body class="hold-transition skin-green layout-top-nav">
    <div class="wrapper">
        @include('plantshop.includes.navbar')

        {{-- Start Container --}}
        <div class="content-wrapper">
            <div class="container">

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-sm-9">
                            {{-- Start Content Body --}}

                            @yield('content-body')

                            {{-- End Content Body --}}
                        </div>

                        <div class="col-sm-3">

                            {{-- Start Sidebar --}}
                            <div class="row">
                                <div class="box box-solid box-success">
                                    <div class="box-header with-border">
                                        <h3 class="box-title"><b>Most Viewed Today</b></h3>
                                    </div>
                                    <div class="box-body">
                                        <ul id="trending">
                                            @if(!$sidebar_most_viewed->first())
                                            <h2>No Items Today</h2>
                                            @endif
                                            @foreach($sidebar_most_viewed as $product)
                                            <li>
                                                <img src="{{ $product->image() }}" width='80px' height='80px' style='border-radius: 5px; margin-right:10px;'>

                                                <a href="/product/{{ $product->slug }}">{{ $product->name }}({{ $product->counter ?? 0 }})</a>
                                            </li>
                                            <hr>
                                            @endforeach
                                            <ul>
                                    </div>
                                </div>
                            </div>
                            {{-- End Sidebar --}}

                        </div>
                    </div>
                </section>
            </div>
        </div>
        {{-- End Container --}}

        @include('plantshop.includes.footer')

    </div>
</body>
@include('plantshop.includes.scripts')
@yield('script')

</html>
