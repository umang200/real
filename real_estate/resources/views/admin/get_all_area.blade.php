@foreach($area as $a)
                                                <tr>
                                                    
                                                    <td>{{$a->id}}</td>
                                                    <td>{{$a->city_name}}</td>
                                                    <td>{{$a->area_name}}</td>
                                                    <td>

                                                            <a class="btn btn-primary" href="{{route('area.edit',$a->id)}}"><i class="ion-edit"></i></a>

                                                         <a href="" data-id="{{$a->id}}" class="deleteajax btn btn-outline-danger"><i class="ion-trash-a"></i></a>

                                                                                                    
                                                                                                                        
                                                    </td>
                                                        


                                                </tr>
                                                @endforeach