<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Product</h1>
    <div>
        @if (session()->has('success'))
            <div>
                {{ session()->get('success') }}
            </div>
            
        @endif
    </div>
    <div>
        <a href="{{ route('product.create') }}">Create a new product</a>
    <div><table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->stock }}</td>
                    <td> 
                        <a href="{{ route('product.edit',['product' => $product->id]) }}">Edit</a>
                    </td>
                    <td>
                        <form action="{{ route('product.destroy', ['product' => $product->id]) }}" method="post">
                            @csrf
                            @method('delete')
                            <input type="submit" value="Delete" />
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table></div>
</body>
</html>