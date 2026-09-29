<div class="max-w-2xl space-y-3">
    <div class="flex items-start gap-3 rounded-card border border-success/30 bg-success-soft p-4">
        <x-ui.icon name="check-circle" class="mt-0.5 size-5 text-success" />
        <div>
            <p class="font-semibold text-ink">Valid VAT number</p>
            <p class="text-sm text-ink-muted">Registered for intra-EU trade in Germany.</p>
        </div>
    </div>
    <div class="flex items-start gap-3 rounded-card border border-warning/30 bg-warning-soft p-4">
        <x-ui.icon name="alert-triangle" class="mt-0.5 size-5 text-warning" />
        <div>
            <p class="font-semibold text-ink">VIES is temporarily unavailable</p>
            <p class="text-sm text-ink-muted">Showing the last stored result. Try again in a few minutes.</p>
        </div>
    </div>
    <div class="flex items-start gap-3 rounded-card border border-danger/30 bg-danger-soft p-4">
        <x-ui.icon name="x-circle" class="mt-0.5 size-5 text-danger" />
        <div>
            <p class="font-semibold text-ink">Not a valid VAT number</p>
            <p class="text-sm text-ink-muted">Check the digits or ask your customer to confirm their registration.</p>
        </div>
    </div>
</div>
