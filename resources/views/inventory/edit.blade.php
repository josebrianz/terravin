@extends('layout')

@section('content')
    <a href="{{ route('inventory.index') }}" class="btn btn-secondary mb-3">← Back</a>

    <form method="POST" action="{{ route('inventory.update', $item->id) }}">
        @csrf
        @method('PUT')

        @include('inventory.form', ['item' => $item])
        <button class="btn btn-primary">✅ Update Item</button>
    </form>
@endsection
