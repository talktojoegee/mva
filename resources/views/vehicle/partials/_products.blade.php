@foreach($products as $product)
<tr class="">
    <th scope="row">
        <div class="form-check form-checkbox-outline form-check-primary mb-3">
            <input name="product[]" class="form-check-input productHandle" value="{{ $product->id }}" data-cost="{{$product->cost ?? 0 }}" type="radio">
            <input type="hidden" name="cost[]" value="{{ $product->cost }}">
            <label class="form-check-label" >
                {{$product->product_name ?? ''}}
            </label>
        </div>
    </th>
    <td>{{ number_format($product->cost,2) ?? '' }}</td>
</tr>
@endforeach
