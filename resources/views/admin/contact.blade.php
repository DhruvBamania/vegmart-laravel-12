@extends('admin.layout.app')

@section('title','Contact Us')

@section('content')

{{-- Category --}}
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <p class="card-title mb-4">Customer Queries</p>
                @if (Session::has('success'))
                    <div class="alert alert-success">
                        <p>{{Session::get('success')}}</p>                               
                    </div>
                @endif
                <div class="table-responsive">
{{-- Main category --}}
                    <table class="table table-striped table-borderless">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Message</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $sr=1 @endphp
                           @foreach ($contacts as $contact)
                            <tr>
                                <td>{{$sr++}}</td>                                              
                                <td>{{$contact->name}}</td>                                                                   
                                <td>{{$contact->email}}</td>                                                                   
                                <td class="text-wrap text-break" style="max-width: 300px;">
                                    {{$contact->message}}
                                </td> 
                                <td>
                                    <form action="{{route('contactStatus.update')}}" method="POST">
                                        @csrf

                                        <input type="hidden" name="id" value="{{$contact->id}}">
                                        <select name="status" class="form-select form-select-sm shadow-sm w-50"  onchange="this.form.submit()">
                                            <option value="pending" {{$contact->status=='pending' ? 'selected' : ''}}>Pending</option>
                                            <option value="under_review" {{$contact->status=='under_review' ? 'selected' : ''}}>Under Review</option>
                                            <option value="solved" {{$contact->status=='solved' ? 'selected' : ''}}>Solved</option>
                                        </select>
                                    </form>    
                                </td>                                                   
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection