@extends('admin.layout.app')
@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Manage Discounts</h4>
        
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addDiscount">Add New Coupon</button>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Type</th>
                    <th>Value</th>
                    <th>Usage</th>
                    <th>Expiry</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($discounts as $d)
                <tr>
                    <td><strong>{{ $d->code }}</strong></td>
                    <td>{{ ucfirst($d->type) }}</td>
                    <td>{{ $d->type == 'percent' ? $d->value.'%' : '$'.$d->value }}</td>
                    <td>{{ $d->used }} / {{ $d->limit }}</td>
                    <td>{{ $d->expiry_date ?? 'No Expiry' }}</td>
                    <td>
                        <form action="{{ route('admin.discounts.delete', $d->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="addDiscount">
    <div class="modal-dialog">
        <form action="{{ route('admin.discounts.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header"><h5>Create Coupon</h5></div>
            <div class="modal-body">
                <input type="text" name="code" class="form-control mb-2" placeholder="Coupon Code (e.g. SAVE20)" required>
                <select name="type" class="form-control mb-2">
                    <option value="fixed">Fixed Amount ($)</option>
                    <option value="percent">Percentage (%)</option>
                </select>
                <input type="number" name="value" class="form-control mb-2" placeholder="Discount Value" required>
                <input type="number" name="limit" class="form-control mb-2" placeholder="Usage Limit" value="100">
                <input type="date" name="expiry_date" class="form-control">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Save Coupon</button>
            </div>
        </form>
    </div>
</div>
@endsection