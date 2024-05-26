@foreach(explode(',', $sale->inventory_items) as $item)
    @php
        $parts = explode(':', $item);
        if (count($parts) === 2) {
            list($lotNumber, $quantity) = $parts;
        } else {
            // Handle the case where $item doesn't contain a colon
            $lotNumber = $item;
            $quantity = 'N/A'; // Or any default value
        }
    @endphp

    Lot Number: {{ $lotNumber }}<br>
    Sale Quantity: {{ $quantity }}<br><br>
@endforeach
