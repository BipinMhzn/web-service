@extends('layouts.app')

@section('content')
<div class="container">
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Name</th>
            <th scope="col">Description</th>
            <th scope="col">Rate</th>
            <th scope="col">Add to Cart</th>
        </tr>
        </thead>
        <tbody>
        @foreach($items as $item)
            <tr>
                <td>{{$item->name}}</td>
                <td>{{$item->description}}</td>
                <td>{{$item->rate}}</td>
                <td>
                    <a href="{{route('cart.rapid.add', ['id' => $item->id])}}" class="btn btn-primary btn-md">
                        <span class="text">Add to Cart</span>
                    </a>
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
    <div class="row">
        <div class="text-center">
         {{ $items->links() }}
        </div>
    </div>
</div>

@endsection
