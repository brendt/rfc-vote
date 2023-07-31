<div>

    <div class="border-gray-700 border-8 flex rounded shadow-xl font-bold font-mono">
        <div class="bg-green-200 text-green-900 p-4 flex-grow text-left border-r-4 border-gray-700" style="width:{{ $vote->percentage_yes }}%; min-width: 10%;">
            {{ $vote->percentage_yes }}% <small>({{ $vote->count_yes }})</small>
        </div>
        <div class="bg-red-200 p-4 text-red-900 flex-grow text-right border-l-4 border-gray-700" style="width:{{ $vote->percentage_no }}%; min-width: 10%;">
            {{ $vote->percentage_no }}% <small>({{ $vote->count_no }})</small>
        </div>
    </div>

</div>
