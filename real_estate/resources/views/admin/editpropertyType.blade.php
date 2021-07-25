 @extends('admin.master')
@section('content')

            <!-- Start right Content here -->

            <div class="content-page">
                <!-- Start content -->
                <div class="content">

                    <!-- Top Bar Start -->
                    <div class="topbar">

                        <nav class="navbar-custom">

                            <ul class="list-inline float-right mb-0">
                                

                                <li class="list-inline-item dropdown notification-list">
                                    <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button"
                                       aria-haspopup="false" aria-expanded="false">
                                        <img src="{{url('assets/images/users/avatar-1.jpg')}}" alt="user" class="rounded-circle">
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                        
                                        <a class="dropdown-item" href="{{route('logout')}}"><i class="mdi mdi-logout m-r-5 text-muted"></i> Logout</a>
                                    </div>
                                </li>

                            </ul>

                            <ul class="list-inline menu-left mb-0">
                                <li class="list-inline-item">
                                    <button type="button" class="button-menu-mobile open-left waves-effect">
                                        <i class="ion-navicon"></i>
                                    </button>
                                </li>
                                <li class="hide-phone list-inline-item app-search">
                                    <h3 class="page-title">PropertyType</h3>
                                </li>
                            </ul>

                            <div class="clearfix"></div>

                        </nav>

                    </div>
                    <!-- Top Bar End -->

                    <div class="page-content-wrapper ">

                        <div class="container-fluid">

                            <div class="col-lg-6">
                                    <div class="card m-b-20">
                                        <div class="card-body">
                                            {{Session::get('status')}}
                                            <form method="POST" action="{{route('propertyType.update',$propertyType->id)}}">
                                                @csrf
                                                @method('PATCH')
                                                <div class="form-group">
                                                    <label for="example">Add PropertyType</label>
                                                    <div>
                                                        <input type="text" class="form-control" id="example"
                                                               data-parsley-minlength="6" placeholder="Add PropertyType" name="property_type_name" value="{{$propertyType->property_type_name}}">
                                                        @error('property_type_name')
                                                        <label style="color: red">{{$message}}</label>
                                                        @enderror
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group m-b-0">
                                                    <div>
                                                        <input type="submit" class="btn btn-primary" value="Update" name="submit">
                                                                                                                    
                                                        <button type="reset" class="btn btn-secondary waves-effect m-l-5">
                                                            Cancel
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->


                            
                            <!-- end row -->

                        </div><!-- container-fluid -->


                    </div> <!-- Page content Wrapper -->

                </div> <!-- content -->
@endsection