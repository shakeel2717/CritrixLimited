<div class="card radius-10">
    <div class="card-body">
        <div class="d-flex align-items-center">
            <div>
                <p class="mb-0">{{ $title }}</p>
                <h4 class="my-1">{{ Number::currency($value ,'MYR' ,'ms_MY') }}</h4>
            </div>
            <div class="widgets-icons ms-auto"><i class='bx bxs-{{ $icon ?? 'wallet' }}'></i>
            </div>
        </div>
    </div>
</div>
