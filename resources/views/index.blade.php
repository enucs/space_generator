<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Anaheim|Roboto+Slab&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://unpkg.com/picnic">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<div class="content">
    <header>
        <img src="/img/logo.png" />
        <h1>Space Generator</h1>
    </header>
    <div class="flex">
        <div></div>
        <form action="{{ route('space.create') }}" method="post" class="third">
            @csrf
            <input class="stack" placeholder="Name" />
            <input class="stack" placeholder="Sub Domain" />
            <input type="submit" class="stack" value="Create Space" />
        </form>
        <div></div>
    </div>

    <hr>
    <p>List of spaces here</p>
</div>
</body>

</html>