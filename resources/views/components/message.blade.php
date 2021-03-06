@if ($errors->any())
    <div class="">
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                {{ $error }}
            </div>
        @endforeach
    </div>
@endif
@if ($msg = Session::get('message'))
    @php $msg = Session::get('message'); @endphp
    <div class="">
        <div class="alert alert-{{ $msg['type'] }}" role="alert">
            {{ $msg['text'] }}
        </div>
    </div>
@endif