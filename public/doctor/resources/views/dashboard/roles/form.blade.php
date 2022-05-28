{{ csrf_field() }}
<div class="row" style="margin: 0 !important;">
    @if(auth()->user()->hotel_id == null)
    <div class="col-md-12">
        <div class="form-group">
            <label>@lang('site.hotel_id')</label>
            <select name="hotel_id"  class='form-control' required>
                <option value="">@lang('site.choose_hotel_id')</option>
                @foreach(\App\Models\Hotel::all() as $hot)
                    <option value="{{$hot->id}}" @if(isset($row) && $row->hotel_id==$hot->id || old('hotel_id') == $hot->id) selected  @endif>{{$hot->name}}</option>
                @endforeach
            </select>
            @error('hotel_id')
            <small class=" text text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </small>
            @enderror
        </div>
    </div>
@endif

<div class="col-md-6">
    <div class="form-group">
        <label>@lang('site.name')</label>
        <input type="name" class="form-control  @error('name') is-invalid @enderror" name="name"
            value="{{ isset($row) ? $row->name : old('name') }}" required>
        @error('name')
        <small class=" text text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </small>
        @enderror
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label>@lang('site.description')</label>
        <input type="description" class="form-control  @error('description') is-invalid @enderror" name="description"
            value="{{ isset($row) ? $row->description : old('description') }}" required>
        @error('description')
        <small class=" text text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </small>
        @enderror
    </div>
</div>
</div>
@php
$models = [
    'users',
    'roles',
    'categories',
    'books',
];
if(auth()->user()->hotel_id == null)
{
    array_push($models,'hotels');
}
$maps = ['create', 'read', 'update', 'delete'];
@endphp



@foreach ($models as $index => $model)
<div class="list-group col-md-3" style="padding-left: 15px !important; padding-right: 15px !important;">
    <a href="#" class="list-group-item active">
        @lang('site.'.$model)
    </a>
    @foreach ($maps as $map)

    <label><input type="checkbox" name="permissions[]"
        {{ isset($row) && $row->hasPermission($map . '-' . $model) ? 'checked' : '' }}
        value="{{ $map . '-' . $model }}"> @lang('site.'.$map)</label>
    <hr>
    @endforeach
</div>
@endforeach



