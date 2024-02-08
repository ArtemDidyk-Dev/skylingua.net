
@if (!empty(array_filter((array)$links)) or $documents)
    <div class="single-tag__wrapper">
        @if (!empty(array_filter((array)$links)))
            <x-inc.single.title class="single-project-overview-title">
                {{ language('Links') }}
            </x-inc.single.title>
            @foreach ($links as $link)
                @if ($link)
                    <x-inc.single.profile-link class="offset-sm">
                        {{ $link }}
                    </x-inc.single.profile-link>
                @endif
            @endforeach
        @endif
        @if ($documents)
            @foreach ($documents as $document)
                <x-inc.single.download-link link="{{ asset('storage/project-documents/' . $document) }}">
                    {{ pathinfo(public_path('storage/project-documents/' . $document))['basename'] }}
                </x-inc.single.download-link>
            @endforeach
        @endif
    </div>
@endif
