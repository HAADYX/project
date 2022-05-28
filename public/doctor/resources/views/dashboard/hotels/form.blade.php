{{ csrf_field() }}

@foreach (config('translatable.locales') as $index => $locale)
    <div class="col-md-3">
        <div class="form-group">
            <label>@lang('site.' . $locale . '.name')</label>
            <input type="text" class="form-control @error($locale . ' .name') is-invalid
        @enderror " name=" {{ $locale }}[name]"
                   value="{{ isset($row) ? $row->translate($locale)->name : old($locale . '.name') }}">

            @error($locale . '.name')
            <small class=" text text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </small>
            @enderror
        </div>
    </div>
@endforeach
<div class="col-md-3">
    <div class="form-group">
        <label>@lang('site.phone')</label>
        <input type="tel"
            class="form-control  @error('phone') is-invalid @enderror" name="phone" value="{{ isset($user) ? $user->phone : old('phone') }}">
        @error('phone')
            <small class=" text text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </small>
        @enderror
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label>@lang('site.address')</label>
        <input type="text"  class="form-control  @error('address') is-invalid @enderror" name="address"
            value="{{ isset($user) ? $user->address : old('address') }}">
        @error('address')
            <small class=" text text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </small>
        @enderror
    </div>
</div>
@foreach (config('translatable.locales') as $index => $locale)
    <div class="col-md-12">
        <div class="form-group">
            <label>@lang('site.' . $locale . '.description')</label>
            <input type="text" class="form-control @error($locale . ' .description') is-invalid
        @enderror " name=" {{ $locale }}[description]"
                   value="{{ isset($row) ? $row->translate($locale)->description : old($locale . '.description') }}">

            @error($locale . '.description')
            <small class=" text text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </small>
            @enderror
        </div>
    </div>
@endforeach
<div class="col-md-12">
    <div class="form-group">
        <label>@lang('site.category_id')</label>
        <select id="category_id" name="category_id"  class='form-control'>
                @foreach ($categories as $cat)
                    <option value="{{$cat->id}}" {{ (isset($row) && $row->category_id ==$cat->id  ) ? 'selected' : '' }}>{{$cat->name}}</option>
                @endforeach
        </select>
        @error('category_id')
            <small class=" text text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </small>
        @enderror
    </div>
</div>
<div class="col-md-2">
    <div class="form-group">
        <label for="exampleFormControlSelect1">@lang('site.status')</label>
        <select class="form-control" id="exampleFormControlSelect1" name="status">
            <option value=" ">@lang('site.Choose Status')</option>
            <option value="active" {{ isset($row) && $row->status=='active' || old('status') == 'active' ? 'selected' : '' }}>@lang('site.active')</option>
            <option value="pending" {{ isset($row) && $row->status=='pending' || old('status')  == 'pending'? 'selected' : '' }}>@lang('site.pending')</option>
        </select>
        @error('status')
        <small class=" text text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </small>
        @enderror
    </div>
</div>
{{-- users data --}}

    <div class="col-md-2">
        <div class="form-group">
            <label>@lang('site.email')</label>
            <input type="email" class="form-control  @error('email') is-invalid @enderror" name="email"
                value="{{ isset($user) ? $user->email : old('email') }}">
            @error('email')
                <small class=" text text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </small>
            @enderror
        </div>
    </div>


    <div class="col-md-2">
        <div class="form-group">
            <label>@lang('site.password')</label>
            <input type="password" class="form-control  @error('password') is-invalid @enderror" name="password" value="">
            @error('password')
                <small class=" text text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </small>
            @enderror
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group">
            <label>@lang('site.password_confirmation')</label>
            <input type="password" class="form-control  @error('password_confirmation') is-invalid @enderror"
                name="password_confirmation" value="">
            @error('password_confirmation')
                <small class=" text text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </small>
            @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>@lang('site.image')</label>
            <input type="file" name="image" class="form-control image @error('image') is-invalid @enderror">
            @error('image')
                <small class=" text text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </small>
            @enderror
        </div>
    </div>

    <div class="form-group col-md-3">
        <img src="{{ isset($user) ? $user->image_path : asset('uploads/users_images/default.png') }}" style="width: 115px;height: 80px;position: relative;
                        top: 14px;" class="img-thumbnail image-preview">
                                                            <label>200 * 200</label>

    </div>
{{-- end the model --}}

</div>








