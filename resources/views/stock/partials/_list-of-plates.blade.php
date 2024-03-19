@foreach($plates as $plate)
<div class="form-check form-radio-primary mb-3">
    <input class="form-check-input" value="{{ $plate->plate_no ?? '' }}"  type="radio" name="plateNo" >
    <label class="form-check-label" for="formRadioColor1">
        {{$plate->plate_no ?? ''}}
    </label>
</div>
@endforeach
