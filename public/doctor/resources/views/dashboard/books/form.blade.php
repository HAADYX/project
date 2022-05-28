{{ csrf_field() }}


<div class="col-md-6">
    <div class="form-group">
        <label>@lang('site.doctor_id')</label>
        <select id="doctor_id" name="doctor_id"  class='form-control'>
            @isset($row)
                @foreach (\App\Models\Hotel::all() as $doc)
                    <option value="{{$doc->id}}" {{ ( $row->doctor_id ==$doc->id  ) ? 'selected' : '' }}>{{$doc->name}}</option>
                @endforeach
            @endisset
        </select>
        @error('doctor_id')
            <small class=" text text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </small>
        @enderror
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label>@lang('site.user_id')</label>
        <select id="user_id" name="user_id"  class='form-control'>
            @isset($row)
                @foreach (\App\User::where('type','0')->get() as $user)
                    <option value="{{$user->id}}" {{ ( $row->user_id ==$user->id  ) ? 'selected' : '' }}>{{$user->name}}</option>
                @endforeach
            @endisset
        </select>
        @error('user_id')
            <small class=" text text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </small>
        @enderror
    </div>
</div>