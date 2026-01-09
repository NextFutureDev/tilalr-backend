@extends('filament::components.layouts.base')

@section('title', 'Debug Offers')

@section('body')
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Debug Offers (Admin)</h1>

        @if(session('success'))
            <div class="mb-4 px-4 py-3 rounded bg-green-50 text-green-700">{{ session('success') }}</div>
        @endif

        <div class="mb-6">
            <h2 class="font-semibold mb-2">Create Offer (Server-side)</h2>
            <form method="POST" action="{{ url('/admin/debug-offers/create') }}" class="grid grid-cols-2 gap-4 max-w-3xl">
                @csrf
                <input name="title_en" placeholder="Title (EN)" class="border px-3 py-2" required />
                <input name="title_ar" placeholder="Title (AR)" class="border px-3 py-2" />
                <input name="slug" placeholder="Slug (optional)" class="border px-3 py-2" />
                <input name="image" placeholder="Image path (storage/... )" class="border px-3 py-2" />
                <input name="discount" placeholder="Discount (e.g. 10%)" class="border px-3 py-2" />
                <input name="badge" placeholder="Badge" class="border px-3 py-2" />
                <input name="duration" placeholder="Duration" class="border px-3 py-2" />
                <input name="location_en" placeholder="Location (EN)" class="border px-3 py-2" />
                <input name="group_size" placeholder="Group size" class="border px-3 py-2" />
                <input name="features" placeholder="Features (comma separated)" class="border px-3 py-2" />
                <input name="highlights" placeholder="Highlights (comma separated)" class="border px-3 py-2" />
                <textarea name="description_en" placeholder="Description (EN)" class="border px-3 py-2 col-span-2"></textarea>
                <div class="col-span-2 flex gap-2">
                    <label class="inline-flex items-center"><input type="checkbox" name="is_active" checked class="mr-2"> Active</label>
                    <button type="submit" class="ml-auto bg-blue-600 text-white px-4 py-2 rounded">Create Offer</button>
                </div>
            </form>
        </div>

        @if($offers->isEmpty())
            <div class="text-red-600">No offers found.</div>
        @else
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Slug</th>
                        <th class="px-4 py-2">Title (EN)</th>
                        <th class="px-4 py-2">Active</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($offers as $o)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $o->id }}</td>
                        <td class="px-4 py-2">{{ $o->slug }}</td>
                        <td class="px-4 py-2">{{ $o->title_en }}</td>
                        <td class="px-4 py-2">{{ $o->is_active ? 'Yes' : 'No' }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif

    </div>
@endsection
