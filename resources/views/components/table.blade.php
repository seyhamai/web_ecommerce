@props([
    'headers' => [], // Array of column titles
])

<div class="card shadow-sm border-0 rounded-4 mb-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light border-bottom">
                <tr>
                    @foreach($headers as $header)
                        <th scope="col" class="text-secondary fw-bold text-uppercase py-3" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                            {{ $header }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="border-top-0">
                {{ $slot }}
            </tbody>
        </table>
    </div>
</div>