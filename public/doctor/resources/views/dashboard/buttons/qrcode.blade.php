@if((auth()->user()->hotel_id != null && auth()->user()->hotel->auth_code == null) || auth()->user()->hotel_id == null)
    <a href="#" class="btn btn-outline-success btn-inline btn-sm " style="padding: 5px 20px; display: inline-block; margin-top:-5px" data-toggle="modal" data-target="#qrcode{{ $row->id }}">
        <i class="fa fa-qrcode"></i>
    </a>
@else
    <a href="#" class="btn btn-outline-success btn-inline btn-sm "style="padding: 5px 20px; display: inline-block; margin-bottom:5px" data-toggle="modal" data-target="#qrcode{{ $row['RoomID'] }}">
        <i class="fa fa-qrcode"></i>
    </a>
@endif
