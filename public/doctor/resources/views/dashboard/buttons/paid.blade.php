@if($row->paid=='0')
    <a href="{{route('dashboard.paid', $row->id)}}" rel="tooltip" title="" class="btn btn-outline-warning btn-sm "
            data-original-title="@lang('site.unpaid')">
            <i class="fa fa-money"></i>@lang('site.unpaid')
    </a>
@else
    <a href="" rel="tooltip" title="" class="btn btn-outline-success btn-sm "
            data-original-title="@lang('site.paid') @lang('site.'.$module_name_singular)">
            <i class="fa fa-money"></i>@lang('site.paid')
    </a>
@endif
