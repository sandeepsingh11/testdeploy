All gear-pieces

@if ($gearpieces->count())
    @foreach ($gearpieces as $gearpiece)

        {{-- get skill names and push into array --}}
        @if ($gearpiece->gear_piece_main !== null)
            @foreach ($skills as $skill)
                @if ($skill['id'] == $gearpiece->gear_piece_main)
                    @php
                        $skillNames[] = $skill['skill'];
                    @endphp
                @endif
            @endforeach
        @else
            @php
                $skillNames[] = 'unknown';
            @endphp
        @endif

        @if ($gearpiece->gear_piece_sub_1 !== null)
            @foreach ($skills as $skill)
                @if ($skill['id'] == $gearpiece->gear_piece_sub_1)
                    @php
                        $skillNames[] = $skill['skill'];
                    @endphp
                @endif
            @endforeach
        @else
            @php
                $skillNames[] = 'unknown';
            @endphp
        @endif

        @if ($gearpiece->gear_piece_sub_2 !== null)
            @foreach ($skills as $skill)
                @if ($skill['id'] == $gearpiece->gear_piece_sub_2)
                    @php
                        $skillNames[] = $skill['skill'];
                    @endphp
                @endif
            @endforeach
        @else
            @php
                $skillNames[] = 'unknown';
            @endphp
        @endif

        @if ($gearpiece->gear_piece_sub_3 !== null)
            @foreach ($skills as $skill)
                @if ($skill['id'] == $gearpiece->gear_piece_sub_3)
                    @php
                        $skillNames[] = $skill['skill'];
                    @endphp
                @endif
            @endforeach
        @else
            @php
                $skillNames[] = 'unknown';
            @endphp
        @endif




        {{-- gearpiece component --}}
        <x-gear-piece.base :gearpiece="$gearpiece" :skills="$skillNames" />
        
    @endforeach
@else
    {{ $user }} does not have any gear pieces yet...
@endif