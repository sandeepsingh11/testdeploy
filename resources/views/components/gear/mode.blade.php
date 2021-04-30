@props(['gear'])

<div class="flex justify-center mt-2">
    @if ($gear->gear_mode_rm)
        <img src="{{ asset('storage/modes/Rainmaker.png') }}" alt="Rainmaker" class="mx-2" style="width: 32px; height: 32px">
    @endif
    
    @if ($gear->gear_mode_cb)
        <img src="{{ asset('storage/modes/Clam_Blitz.png') }}" alt="Clam blitz" class="mx-2" style="width: 32px; height: 32px">
    @endif
    
    @if ($gear->gear_mode_sz)
        <img src="{{ asset('storage/modes/Splat_Zones.png') }}" alt="Splat zones" class="mx-2" style="width: 32px; height: 32px">
    @endif

    @if ($gear->gear_mode_tc)
        <img src="{{ asset('storage/modes/Tower_Control.png') }}" alt="Tower control" class="mx-2" style="width: 32px; height: 32px">
    @endif
</div>