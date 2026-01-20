<div>
@php($path = $getState())
@if($path)
    <img src="{{ asset('storage/' . ltrim($path, '/')) }}" alt="" style="width:40px;height:40px;object-fit:cover;border-radius:6px" />
@else
    <span class="text-muted">—</span>
@endif
</div>


