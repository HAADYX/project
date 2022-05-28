<aside class="main-sidebar">

    <section class="sidebar">

        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{auth()->user()->image_path}}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{auth()->user()->name}}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> @lang('site.statue')</a>
            </div>
        </div>

        <ul class="sidebar-menu" data-widget="tree">

                <li class="{{request()->is(LaravelLocalization::getCurrentLocale().'/dashboard/home')? 'active':''}}"><a href="{{ route('dashboard.home') }}"><i
                class="fa fa-dashboard"></i><span>@lang('site.dashboard')</span></a></li>
                @if(auth()->user()->hotel_id == null )
                    @if (auth()->user()->hotel_id == null && auth()->user()->can('read-hotels'))
                        <li class="{{request()->is(LaravelLocalization::getCurrentLocale().'/dashboard/hotels*')? 'active':''}}">
                            <a href="{{ route('dashboard.hotels.index') }}"><i
                                class="fa fa-h-square"></i><span>@lang('site.hotels')</span></a></li>
                    @endif
                    @if (auth()->user()->can('read-categories'))
                        <li class="{{request()->is(LaravelLocalization::getCurrentLocale().'/dashboard/categories*')? 'active':''}}">
                        <a href="{{ route('dashboard.categories.index') }}"><i
                                class="fa fa-list"></i> @lang('site.categories')</a></li>
                    @endif

                @endif

                @if (auth()->user()->hasPermission('read-users'))
                <li class="{{request()->is(LaravelLocalization::getCurrentLocale().'/dashboard/users*')? 'active':''}}"><a href="{{ route('dashboard.users.index') }}"><i
                            class="fa fa-users"></i><span>@lang('site.users')</span></a></li>
                @endif

                @if (auth()->user()->can('read-roles'))
                    <li class="{{request()->is(LaravelLocalization::getCurrentLocale().'/dashboard/roles*')? 'active':''}}"><a href="{{ route('dashboard.roles.index') }}"><i
                            class="fa fa-hourglass-half"></i><span>@lang('site.roles')</span></a></li>
                @endif

               
                  
                @if (auth()->user()->can('read-books'))
                    <li class="{{request()->is(LaravelLocalization::getCurrentLocale().'/dashboard/books*')? 'active':''}}">
                        <a href="{{ route('dashboard.books.index') }}"><i
                            class="fa fa-shopping-cart"></i><span>@lang('site.books')</span></a></li>
                @endif
               
        </ul>
    </section>

</aside>
