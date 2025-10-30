@extends('admin.layout.app')

@section('title','Products Dashoboard')

@section('content')

{{-- Category --}}
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <p class="card-title mb-0">Categories</p>
{{-- Category Modal form --}}
                <button type="button" class="btn btn-info my-3" data-toggle="modal" data-target="#addCategory">
                    Add Category
                </button>

<!-- category form Modal -->
                <div class="modal fade" id="addCategory">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Add New Category</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                                <form action="{{ route('addProduct') }}" method="POST">
                                    @csrf
                                    <label for="category">Category</label>
                                    <input type="text" name="category" placeholder="Enter the Category"
                                        class="form-control mb-2" id="category">
                                    <input type="submit" name="save" class="btn btn-success mt-2" value="Add Category">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
{{-- Category modal form end --}}
                <div class="table-responsive">
{{-- Main category --}}
                    <table class="table table-striped table-borderless">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Category</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $sr=1 @endphp
                            @foreach ($category as $item )
                            <tr>
                                <td>{{$sr++}}</td>
                                <td class="font-weight-bold">{{$item->category}}</td>
                                <td class="font-weight-medium">
                                    <button class="btn btn-success px-3" data-toggle="collapse"
                                        data-target="#{{$item->category}}" aria-expanded="true"
                                        aria-controls="{{$item->category}}">
                                        Manage
                                    </button>
                                    <form action="{{ route('deleteCategory',$item->id) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this category?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type='submit' class="btn btn-danger px-3">Delete</button>
                                    </form>
                                </td>
                            </tr>
{{-- Sub-category --}}
                            <tr class="collapse" id="{{$item->category}}">
                                <td colspan="3">
                                    <table class="table table-striped ">
                                        <thead>
                                            <tr class="table-active">
                                                <th>Sr.No</th>
                                                <th>Image</th>
                                                <th>Title</th>
                                                <th>Description</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $sr2=1 @endphp
                                            @if(isset($products[$item->category]))
                                            @foreach($products[$item->category] as $product)
                                            <tr>
                                                <td>{{ $sr2++ }}</td>
                                                <td><img src="{{ asset('uploads/products/'.$product->image)}}"
                                                        width="100px" alt=""></td>
                                                <td>{{ $product->title }}</td>
                                                <td class="text-wrap description-column"
                                                style=".description-column {max-width: 250px;white-space: normal;word-wrap: break-word;}">
                                                    {{ $product->description }}
                                                </td>
                                                <td>${{ $product->price }}</td>
                                                <td>{{ $product->quantity }}</td>
                                                <td>
{{-- Sub category Update modal --}}
                                                    <button type="button" class="btn btn-primary px-3"
                                                        data-toggle="modal" data-target="#updateItem{{ $product->id }}">
                                                        Edit
                                                    </button>
                                                    <!-- The Modal -->
                                                    <div class="modal fade" id="updateItem{{ $product->id }}">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">

                                                                <!-- Modal Header -->
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Edit Item</h4>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal">&times;</button>
                                                                </div>

                                                                <!-- Modal body -->
                                                                <div class="modal-body">
                                                                    <form action="{{ route('updateItem',$product->id) }}" method="POST"
                                                                        enctype="multipart/form-data">
                                                                        @csrf
                                                                        <label for="">Name</label>
                                                                        <input type="text" name="title"
                                                                        value="{{ $product->title }}"
                                                                            placeholder="Enter the Title"
                                                                            class="form-control mb-2" id="" required>
                                                                        <label for="">Description</label>
                                                                        <input type="text" name="description"
                                                                        value="{{ $product->description }}"
                                                                            placeholder="Enter the Description"
                                                                            class="form-control mb-2" id="" required>
                                                                        <label for="">Price</label>
                                                                        <input type="text" name="price"
                                                                        value="{{ $product->price }}"
                                                                            placeholder="Enter the Price"
                                                                            class="form-control mb-2" id="" required>
                                                                        <label for="">Quantity</label>
                                                                        <input type="text" name="quantity"
                                                                        value="{{ $product->quantity }}"
                                                                            placeholder="Enter the Quantity"
                                                                            class="form-control mb-2" id="" required>
                                                                        <label for="">Image</label>
                                                                        <input type="file" name="image"
                                                                            class="form-control mb-2" id="" >

                                                                        <input type="hidden" name="category"
                                                                            value="{{ $item->category }}">

                                                                        <input type="submit" name="save"
                                                                            class="btn btn-success mt-2"
                                                                            value="Update Item">
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                            
                                                    <form action="{{ route('itemDelete',$product->id) }}" method="POST" class="d-inline"
                                                        onsubmit="return confirm('Are you sure you want to delete the selected product?')">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type='submit' class="btn btn-danger px-3"><i
                                                                class="icon-trash"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td colspan="6" class="text-center">No products available</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
{{-- Item modal form --}}
                                    <button type="button" class="btn btn-success my-3" data-toggle="modal"
                                        data-target="#addItem{{$item->id}}">
                                        Add Item
                                    </button>
                                    <!-- The Modal -->
                                    <div class="modal fade" id="addItem{{$item->id}}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Add New Item</h4>
                                                    <button type="button" class="close"
                                                        data-dismiss="modal">&times;</button>
                                                </div>

                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <form action="{{ route('addItem') }}" method="POST"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        <label for="">Name</label>
                                                        <input type="text" name="title" placeholder="Enter the Title"
                                                            class="form-control mb-2" id="" required>
                                                        <label for="">Description</label>
                                                        <input type="text" name="description"
                                                            placeholder="Enter the Description"
                                                            class="form-control mb-2" id="" required>
                                                        <label for="">Price</label>
                                                        <input type="text" name="price" placeholder="Enter the Price"
                                                            class="form-control mb-2" id="" required>
                                                        <label for="">Quantity</label>
                                                        <input type="text" name="quantity"
                                                            placeholder="Enter the Quantity" class="form-control mb-2"
                                                            id="" required>
                                                        <label for="">Image</label>
                                                        <input type="file" name="image" class="form-control mb-2" id=""
                                                            required>

                                                        <input type="hidden" name="category"
                                                            value="{{ $item->category }}">

                                                        <input type="submit" name="save" class="btn btn-success mt-2"
                                                            value="Add Item">
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
<!-- Item Modal form end -->
                                </td>
                            </tr>
{{-- Sub-category end --}}
                            @endforeach
                        </tbody>
                    </table>
{{-- Main Category end --}}
                </div>
            </div>
        </div>
    </div>
</div>



@endsection