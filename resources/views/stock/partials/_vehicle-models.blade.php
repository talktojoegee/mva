<select class="form-control select2" name="vehicleModel">
    <option selected disabled>--Select--</option>
    @foreach($models as $model)
        <option value="{{$model->vm_id}}">{{$model->vm_name ?? '' }}</option>
    @endforeach
</select>
