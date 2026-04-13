<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lol</title>
</head>

<body>
    <h1>Wow ok</h1>
    <ul>
        @foreach ($gay as $ayy)
            <li>{{$ayy}}</li>
            <hr>
        @endforeach
    </ul>
        <p>You have {{count($gay)}} cherished memories</p>
        @if (count($gay) >  2)
            <p>Wow! more than 2!</p>

        @endif

        @unless (count($gay))
        <p>Sad!</p>
            
        @endunless

        @forelse ($gay as $yaay)
            <p>Existential Abatement</p>
        @empty
        <p>Nonexistential Abatement</p>
        @endforelse


        
</body>

</html>
