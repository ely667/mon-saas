<x-layouts.app title="Commandes">
    <section class="container section">
        <div class="row">
            <div>
                <div class="eyebrow">Suivi</div>
                <h2>Commandes</h2>
            </div>
        </div>

        <div class="panel table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Client</th>
                        <th>Montant</th>
                        <th>Statut</th>
                        <th>Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td><strong>{{ $order->customer_name }}</strong><br><span class="muted">{{ $order->customer_phone }}</span></td>
                            <td>{{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</td>
                            <td><span class="badge">{{ $order->statusLabel() }}</span></td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td><a class="btn btn-line" href="{{ route('orders.show', $order) }}">Voir</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="5">Aucune commande pour le moment.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $orders->links() }}
    </section>
</x-layouts.app>
