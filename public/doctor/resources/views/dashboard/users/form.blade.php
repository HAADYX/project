{{ csrf_field() }}
<div class="row" style="margin: 0 !important;">

    <div class="col-md-6">
        <div class="form-group">
            <label>@lang('site.name')</label>
            <input type="name" class="form-control  @error('name') is-invalid @enderror" name="name"
                value="{{ isset($row) ? $row->name : old('name') }}">
            @error('name')
                <small class=" text text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </small>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>@lang('site.email')</label>
            <input type="email" class="form-control  @error('email') is-invalid @enderror" name="email"
                value="{{ isset($row) ? $row->email : old('email') }}">
            @error('email')
                <small class=" text text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </small>
            @enderror
        </div>
    </div>


    <div class="col-md-6">
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

    <div class="col-md-6">
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

    <div class="col-md-6">
        <div class="form-group">
            <label>@lang('site.phone')</label>
            <input type="tel" required
                class="form-control  @error('phone') is-invalid @enderror" name="phone" value="{{ isset($row) ? $row->phone : old('phone') }}">
            @error('phone')
                <small class=" text text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </small>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>@lang('site.address')</label>
            <input type="text" required class="form-control  @error('address') is-invalid @enderror" name="address"
                value="{{ isset($row) ? $row->address : old('address') }}">
            @error('address')
                <small class=" text text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </small>
            @enderror
        </div>
    </div>

    @if(auth()->user()->hotel_id == null)
        <div class="col-md-12">
            <div class="form-group">
                <label>@lang('site.hotel_id')</label>
                <select name="hotel_id"  class='form-control'>
                    <option value="">@lang('site.choose_hotel_id')</option>
                    @foreach(\App\Models\Hotel::all() as $hot)
                        <option value="{{$hot->id}}" @if(isset($row) && $row->hotel_id==$hot->id || old('hotel_id') == $hot->id ) selected  @endif>{{$hot->name}}</option>
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

    {{-- <input type="hidden" name="user_type" value="App\User"> --}}

    <div class="col-md-12">
        <div class="form-group">
            @php
                   if(auth()->user()->hotel_id != null)
                    {
                            $hotelAdmin=App\User::where('hotel_id',auth()->user()->hotel_id)->first();
                            $ro=App\RoleUser::where('user_id',$hotelAdmin->id)->first();
                            $roles = App\Role::where('id','!=',$ro->role_id)->get();
                    }else{
                            $roles = App\Role::all();
                    }

            @endphp
            @foreach ($roles as $role)
                <div class="col-md-1">
                    <input type="checkbox" id="{{ $role->name }}"
                        {{ isset($row->roles[0]) && $row->roles[0]->id == $role->id ? 'checked' : '' }} name="role_id[]"
                        value="{{ $role->id }}">
                    <label for="{{ $role->name }}">{{ $role->name }}</label><br>
                </div>
            @endforeach
            @error('role_id')
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
        <img src="{{ isset($row) ? $row->image_path : asset('uploads/users_images/default.png') }}" style="width: 115px;height: 80px;position: relative;
                        top: 14px;" class="img-thumbnail image-preview">
    </div>
</div>


