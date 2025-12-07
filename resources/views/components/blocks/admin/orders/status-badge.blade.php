@switch($order->status)
    @case('incomplete')
        <x-badge variant="outline-warning">{{ __('Incomplete') }}</x-badge>
    @break

    @case('paid')
        <x-badge variant="outline-success">{{ __('Paid') }}</x-badge>
    @break

    @case('completed')
        <x-badge variant="outline-success">{{ __('Completed') }}</x-badge>
    @break

    @case('pending')
        <x-badge variant="outline-info">{{ __('Pending') }}</x-badge>
    @break

    @case('failed')
        <x-badge variant="outline-danger">{{ __('Failed') }}</x-badge>
    @break

    @case('refunded')
        <x-badge variant="outline-warning">{{ __('Refunded') }}</x-badge>
    @break

    @case('disputed')
        <x-badge variant="outline-danger">{{ __('Disputed') }}</x-badge>
    @break

    @case('cancelled')
        <x-badge variant="outline-danger">{{ __('Cancelled') }}</x-badge>
    @break

    @default
        <x-badge variant="outline-danger">{{ __('Unknown') }}</x-badge>
@endswitch
