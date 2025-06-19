@extends('layout')

@section('content')
    <a href="{{ route('inventory.index') }}" class="btn btn-secondary mb-3">← Back</a>

    <form method="POST" action="{{ route('inventory.store') }}">
        @csrf

        @include('inventory.form', ['item' => null])
        <button class="btn btn-success">💾 Save Item</button>
    </form>
@endsection
