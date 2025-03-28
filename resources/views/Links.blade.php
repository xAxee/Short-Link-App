@extends('layouts.app')

@section('content')
<div class="mt-24 overflow-x-auto">
    <table class="w-full bg-gray-800 text-white rounded-lg overflow-hidden">
        <caption class="sr-only">Lista linków</caption>
        <thead class="bg-gray-700">
          <tr>
            <th scope="col" class="px-6 py-3">#</th>
            <th scope="col" class="px-6 py-3">Short Link</th>
            <th scope="col" class="px-6 py-3">Orginal Link</th>
            <th scope="col" class="px-6 py-3">Clicks</th>
            <th scope="col" class="px-6 py-3">Create Date</th>
            <th scope="col" class="px-6 py-3">Options</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-700">
            <?php $lp = 1; ?>
            @foreach($Links as $link)
            <tr class="hover:bg-gray-700 transition-colors">
                <th scope="row" class="px-6 py-4">{{ $lp++ }}</th>
                <td class="px-6 py-4"><a href="{{route('get', $link->short_link)}}" class="text-blue-400 hover:text-blue-300">{{route('get', $link->short_link)}}</a></td>
                <td class="px-6 py-4"><a href="{{ $link->orginal_link }}" class="text-blue-400 hover:text-blue-300">{{ Str::limit($link->orginal_link, 30) }}</a></td>
                <td class="px-6 py-4">{{ $link->clicks }}</td>
                <td class="px-6 py-4" title="{{$link->created_at}}">{{ $link->created_at->toDateString() }}</td>
                <td class="px-6 py-4 space-x-3">
                    <button class="inline-block" data-toggle="modal" data-target="#delete_{{ $link->id }}"><i class="fa-solid fa-trash text-red-500 hover:text-red-400"></i></button>
                    @include('partials.delete')
                    <button class="copy inline-block" data-clipboard-text="{{route('get', $link->short_link)}}"><i class="fa-solid fa-copy text-blue-500 hover:text-blue-400"></i></button>
                    
                    <button class="inline-block" data-toggle="modal" data-target="#qrcode_{{ $link->id }}"><i class="fa-solid fa-qrcode text-cyan-500 hover:text-cyan-400"></i></button>
                    @include('partials.qrcode')
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@section('script')
<script>
    var clipboard = new ClipboardJS('.copy');

    var myModal = document.getElementById('myModal')
    var myInput = document.getElementById('myInput')

    myModal.addEventListener('shown.bs.modal', function () {
        myInput.focus()
    })
</script>
@endsection
