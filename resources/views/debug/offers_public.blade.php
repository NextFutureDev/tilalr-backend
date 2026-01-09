<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Debug Offers (public)</title>
</head>
<body>
    <h1>Offers (public debug)</h1>
    <p>Total: {{ $offers->count() }}</p>

    <ul>
        @foreach($offers as $offer)
            <li>
                <strong>{{ $offer->title_en }}</strong> ({{ $offer->is_active ? 'active' : 'inactive' }})<br>
                {{ $offer->description_en }}<br>
                Image: {{ $offer->image ?? 'none' }}<br>
                Features: @if(is_array($offer->features)) {{ implode(', ', $offer->features) }} @endif
            </li>
        @endforeach
    </ul>
</body>
</html>