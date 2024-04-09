<div>
    <h3>VAT Rates History in {{ $country->name }} </h3>
    @php
    @endphp
    @if ($country->vatHistory)
        <table class="table-fixed table">
            <tr>
                <th>Year</th>
                <th>VAT Rate</th>
            </tr>
            @foreach ($country->vatHistory as $item)
                <tr>
                    <td>
                        <div>
                            <p>{{ $item->year }}</p>
                        </div>
                    </td>
                    <td>
                        <p>{{ $item->vat_rate }}%</p>
                    </td>

                <tr>
            @endforeach
        </table>
    @else
        <p>No VAT history found for {{ $country->name }}</p>
    @endif
    <!-- Nothing worth having comes easy. - Theodore Roosevelt -->
</div>
