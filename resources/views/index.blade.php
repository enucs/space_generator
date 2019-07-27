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
            <input class="stack" placeholder="Name" name="name"/>
            <input type="submit" class="stack" value="Create Space" />
            @if($errors->first() != null)
                <b>{{ $errors->first() }}</b>
            @endif
        </form>
        <div></div>
    </div>

    <hr>
    @foreach(App\Space::all() as $space)
        <article class="card">
            <header>
                <h3>{{ $space->name }}.spaces.enucs.org.uk</h3>
                <span><code>{{ $space->name }}</code>:<code>{{ $space->password }}</code></span>
            </header>
        </article>
    @endforeach
</div>
</body>

</html>