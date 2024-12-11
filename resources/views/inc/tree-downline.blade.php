<li>
    <a href="javascript:void(0);">
        <div class="member-view-box">
            <div class="bg-light p-2">
                <span class="text-white fs-5">{{ $node['user']->username }}</span>
                <br>
                <span class="text-white fs-6">{{ Number::currency($node['user']->investment()) }}</span>
            </div>
            <div class="member-image w-100 text-center">
                <img src="{{ $node['user']->avatar ? Storage::url($node['user']->avatar) : asset('assets/images/avatar.png') }}"
                    alt="Member" class="rounded img-thumbnail">
            </div>
        </div>
    </a>

    @if (count($node['downline']) > 0)
        <ul>
            @foreach ($node['downline'] as $childNode)
                @include('inc.tree-downline', ['node' => $childNode])
            @endforeach
        </ul>
    @endif
</li>
