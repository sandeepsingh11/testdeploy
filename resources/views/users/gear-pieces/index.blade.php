All gear-pieces

@if ($gearpieces->count())
    @foreach ($gearpieces as $gearpiece)
        <h1>{{ $gearpiece->gear_piece_name }}</h1>
        <h3><i>{{ $gearpiece->gear_piece_desc }}</i></h3>


        {{-- get gear piece image --}}
        @if ($gearpiece->gear_piece_type == 'h')
            @php
                $gearpiecesList = $headgears;
            @endphp
        @elseif ($gearpiece->gear_piece_type == 'c')
            @php
                $gearpiecesList = $clothes;
            @endphp
        @elseif ($gearpiece->gear_piece_type == 's')
            @php
                $gearpiecesList = $shoes;
            @endphp
        @endif
        
        @foreach ($gearpiecesList as $gearpiecesEntry)
            @if ($gearpiecesEntry['ModelName'] == $gearpiece->gear_piece_id)
                <img src="{{ asset('storage/gear/' . $gearpiece->gear_piece_id . '.png') }}" alt="">
                @break
            @endif
        @endforeach


        {{-- get skill images --}}
        @if ($gearpiece->gear_piece_main !== null)
            @foreach ($skills as $skill)
                @if ($skill['id'] == $gearpiece->gear_piece_main)
                    <img src="{{ asset('storage/skills/' . $skill['skill'] . '.png') }}" alt="{{ $skill['skill'] }}">
                @endif
            @endforeach
        @else
            <img src="{{ asset('storage/skills/unknown.png') }}" alt="unknown skill">
        @endif

        @if ($gearpiece->gear_piece_sub_1 !== null)
            @foreach ($skills as $skill)
                @if ($skill['id'] == $gearpiece->gear_piece_sub_1)
                    <img src="{{ asset('storage/skills/' . $skill['skill'] . '.png') }}" alt="{{ $skill['skill'] }}">
                @endif
            @endforeach
        @else
            <img src="{{ asset('storage/skills/unknown.png') }}" alt="unknown skill">
        @endif

        @if ($gearpiece->gear_piece_sub_2 !== null)
            @foreach ($skills as $skill)
                @if ($skill['id'] == $gearpiece->gear_piece_sub_2)
                    <img src="{{ asset('storage/skills/' . $skill['skill'] . '.png') }}" alt="{{ $skill['skill'] }}">
                @endif
            @endforeach
        @else
            <img src="{{ asset('storage/skills/unknown.png') }}" alt="unknown skill">
        @endif

        @if ($gearpiece->gear_piece_sub_3 !== null)
            @foreach ($skills as $skill)
                @if ($skill['id'] == $gearpiece->gear_piece_sub_3)
                    <img src="{{ asset('storage/skills/' . $skill['skill'] . '.png') }}" alt="{{ $skill['skill'] }}">
                @endif
            @endforeach
        @else
            <img src="{{ asset('storage/skills/unknown.png') }}" alt="unknown skill">
        @endif
    @endforeach
@else
    there are no gear pieces
@endif