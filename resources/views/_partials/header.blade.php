<header>
    <h1>{{ trans('app.title') }}</h1>
    <div id='logo'>
        @php
            $fname = str_replace('storage/logos/', '',$logo->filename)
        @endphp
        <a href="/"><img height="100px" src="{{ url('logo/'.$fname) }}" alt="Logo: {{ $logo->title }}"/></a>
        <p>logo '{{ $logo->title }}' by <a href='{{ url('users', $logo->id) }}' class='user'>{{ $logo->name }}</a> :: {{ config('app.name') }} is brought to you with love.</p>
    </div>
</header>