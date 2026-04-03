<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Create a Product</h1>
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
    <form action="{{ route('product.store') }}" method="post">
        @csrf
        @method('post')
        <div>
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" placeholder="Product Name">
        </div>
        <div>
            <label for="description">Description:</label>
            <textarea name="description" id="description" placeholder="Product Description"></textarea>
        </div>
        <div>
            <label for="price">Price:</label>
            <input type="number" name="price" id="price" placeholder="Product Price" step="0.01">
        </div>
        <div>
            <label for="stock">Stock:</label>

            <input type="number" name="stock" id="stock" placeholder="Product Stock">
        </div>
        <div> </div>

        <input type="submit" value="Save a product" />
    </form>
</body>

</html>