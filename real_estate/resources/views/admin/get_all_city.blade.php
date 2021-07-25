@foreach($city as $c)
        <tr>
            
            <td>{{$c->id}}</td>
            <td>{{$c->city_name}}</td>
            <td>

                <a class="btn btn-primary" href="{{route('city.edit',$c->id)}}"><i class="ion-edit"></i></a>

                 <a data-id="{{$c->id}}" class="deleteajax btn btn-danger"><i class="ion-trash-a"></i></a>
                                                                                
            </td>
                


        </tr>
        @endforeach