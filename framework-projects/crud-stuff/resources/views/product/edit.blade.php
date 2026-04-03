<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Edit a Product</h1>
    <div>
        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    <form action="{{ route('product.update', ['product' => $product]) }}" method="post">
        @csrf
        @method('put')
        <div>
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" placeholder="Product Name" value="{{ $product->name }}">
        </div>
        <div>
            <label for="description">Description:</label>
            <textarea name="description" id="description" placeholder="Product Description" >{{ $product->description }}</textarea>
        </div>
        <div>
            <label for="price">Price:</label>
            <input type="number" name="price" id="price" placeholder="Product Price" step="0.01" value="{{ $product->price }}">
        </div>
        <div>
            <label for="stock">Stock:</label>

            <input type="number" name="stock" id="stock" placeholder="Product Stock" value="{{ $product->stock }}">
        </div>
        <div> </div>

        <input type="submit" value="Update it lol" />
    </form>
</body>

</html>