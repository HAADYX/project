@extends('dashboard.layouts.app')

@section('content')

    <div class="content-wrapper" style="min-height: 0">

        <section class="content-header">

            <h1>{{auth()->user()->hotel_id != null ? auth()->user()->hotel->name : __('site.dashboard') }}</h1>

            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</li>
            </ol>
        </section>

        <section class="content">
            <div class="row">
                    @if (auth()->user()->hotel_id == null && auth()->user()->can('read-hotels'))
                        <div class="col-lg-3 col-xs-6">
                            <div class="small-box">
                                <div class="inner">
                                    <h3>{{count(App\Models\Hotel::get())}}</h3>
                                    <p>@lang('site.hotels')</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-user"></i>
                                </div>
                                <a href="{{ route('dashboard.hotels.index') }}" class="small-box-footer">@lang('site.read') <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    @endif
                    @if (auth()->user()->hotel_id == null && auth()->user()->can('read-categories'))
                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box">
                            <div class="inner">
                                <h3>{{count(App\Models\Category::get())}}</h3>
                                <p>@lang('site.categories')</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-list"></i>
                            </div>
                            <a href="{{ route('dashboard.categories.index') }}" class="small-box-footer">@lang('site.read') <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                @endif
                    @if (auth()->user()->can('read-books'))
                        <div class="col-lg-3 col-xs-6">
                            <div class="small-box">
                                <div class="inner">
                                    <h3>{{count(App\Models\Book::all())}}</h3>
                                    <p>@lang('site.books')</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                                <a href="{{ route('dashboard.books.index') }}" class="small-box-footer">@lang('site.read') <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    @endif
                   
                    @if (auth()->user()->can('read-users'))
                        <div class="col-lg-3 col-xs-6">
                            <div class="small-box">
                                <div class="inner">
                                    <h3>{{count(App\User::get())}}</h3>
                                    <p>@lang('site.users')</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-users"></i>
                                </div>
                                <a href="{{ route('dashboard.users.index') }}" class="small-box-footer">@lang('site.read') <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    @endif

                    @if (auth()->user()->can('read-roles'))
                        <div class="col-lg-3 col-xs-6">
                            <div class="small-box">
                                <div class="inner">
                                    <h3>{{count(App\Role::get())}}</h3>
                                    <p>@lang('site.roles')</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-hourglass-half"></i>
                                </div>
                                <a href="{{ route('dashboard.roles.index') }}" class="small-box-footer">@lang('site.read') <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    @endif

                  
                  
            </div>
         </section>

    </div>


@endsection
@push('script')
<script>

@php
  $hotels=json_encode(\App\Models\Hotel::all()->pluck('name')->toArray());
  $order_count=json_encode(\App\Models\Hotel::all()->pluck('order_count')->toArray());
@endphp
var hotels=[@php echo $hotels;  @endphp];
var order_count=[@php echo $order_count;  @endphp];
const ctx = document.getElementById('myChart');
const myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ['neferita','pms','sds'],
        datasets: [{
            label: '# of Votes',
            data: [12,15,7],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',

            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',

            ],
            borderWidth: 1
        }]
    },
    options: {
        animation: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
  </script>
@endpush

