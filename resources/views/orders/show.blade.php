<x-layouts.app title="Commande">
    <section class="container section">
        <div class="grid grid-2">
            <div class="panel">
                <div class="eyebrow">Commande</div>
                <h2>{{ $order->customer_name }}</h2>
                <p>{{ $order->customer_phone }}<br>{{ $order->customer_commune }}</p>
                <p>{{ $order->customer_note }}</p>
                <strong>{{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</strong>

                <form class="form" method="POST" action="{{ route('orders.status', $order) }}" style="margin-top:18px;">
                    @csrf
                    @method('PATCH')
                    <label>Statut
                        <select name="status">
                            @foreach ($statuses as $value => $label)
                                <option value="{{ $value }}" @selected($order->status === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </label>
                    <button class="btn btn-primary" type="submit">Mettre a jour</button>
                </form>
            </div>

            <div class="panel">
                <h3>Articles</h3>
                @foreach ($order->items as $item)
                    <p><strong>{{ $item->product_name }}</strong><br>{{ $item->quantity }} x {{ number_format($item->unit_price, 0, ',', ' ') }} FCFA</p>
                @endforeach
                @php
                    $lines = $order->items->map(fn($i) => "- {$i->product_name} x{$i->quantity} = ".number_format($i->line_total, 0, ',', ' ').' FCFA')->implode("\n");
                    $message = "Bonjour {$order->customer_name}, votre commande VenteGo chez {$order->shop->name} a bien ete recue:\n{$lines}\nTotal: ".number_format($order->total_amount, 0, ',', ' ').' FCFA.';
                    $phone = preg_replace('/\D+/', '', $order->customer_phone);
                @endphp
                <a class="btn btn-soft" href="https://wa.me/{{ $phone }}?text={{ urlencode($message) }}" target="_blank" rel="noreferrer">Confirmer sur WhatsApp</a>
            </div>
        </div>
    </section>
</x-layouts.app>
