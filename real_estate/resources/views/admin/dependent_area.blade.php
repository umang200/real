<option value="">Select Area</option>
@foreach($area as $a)
<option value="{{$a->id}}">{{$a->area_name}}</option>
@endforeach