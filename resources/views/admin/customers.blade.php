@extends('admin.layout.app')

@section('title','Customers')

@section('content')

{{-- Category --}}
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <p class="card-title mb-0">Customers</p>

                <div class="table-responsive">
{{-- Main category --}}
                    <table class="table table-striped table-borderless">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Profile Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Registration Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $sr=1 @endphp
                            @foreach ($customers as $customer)
                                
                            @endforeach
                            <tr>
                                <td>{{$sr++}}</td>
                                <td><img src="{{ asset('uploads/profile_images/'.$customer->image)}}"width="100px" alt=""></td>                                                                   
                                <td>{{$customer->name}}</td>                                                                   
                                <td>{{$customer->email}}</td>                                                                   
                                <td class="font-weight-bold">{{$customer->status}}</td>                                                                   
                                <td>{{$customer->created_at}}</td>  

                                @if ($customer->status=='Active')
                                <td><a class="btn btn-danger" href="{{ route('changeStatus',['status'=>'Blocked','id'=>$customer->id] ) }}">Block</a></td>  

                                @else
                                <td><a class="btn btn-success" href="{{ route('changeStatus',['status'=>'Active','id'=>$customer->id]) }}">Un-Block</a></td>                                       
                                    
                                @endif                                                                 
                                                                                                
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection