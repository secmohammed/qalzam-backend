<div class="tab-pane fade" id="requests" role="tabpanel" aria-labelledby="requests-tab">
    <div class="all-contant">
      @foreach ($orders as $order)
          <livewire:card.order-card
              :price="$order->total()->formatted()"
              :branchName="$order->branch->name"
              :address="$order->address ? $order->address->address_1 : '__________'"
              :orderType="$order->address ? __('website.order.delivery') : __('website.order.branch')"
              :createdAt="\Carbon\Carbon::parse( $order->created_at)->format('Y-m-d')"
              :status="$order->status"
              key="'order-card-'.$order->id"
          />
      @endforeach


    </div>
  </div>
