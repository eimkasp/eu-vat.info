<?php
    use Filament\Support\Facades\FilamentView;
?>

<?php if($this->hasUnsavedDataChangesAlert()): ?>
    <?php if(FilamentView::hasSpaMode()): ?>
            <?php
        $__scriptKey = '1120888020-0';
        ob_start();
    ?>
            <script>
                let formSubmitted = false

                document.addEventListener(
                    'submit',
                    () => (formSubmitted = true),
                )

                shouldPreventNavigation = () => {
                    if (formSubmitted) {
                        return
                    }

                    return (
                        window.jsMd5(
                            JSON.stringify($wire.data).replace(/\\/g, ''),
                        ) !== $wire.savedDataHash ||
                        $wire?.__instance?.effects?.redirect
                    )
                }

                const showUnsavedChangesAlert = () => {
                    return confirm(<?php echo \Illuminate\Support\Js::from(__('filament-panels::unsaved-changes-alert.body'))->toHtml() ?>)
                }

                document.addEventListener('livewire:navigate', (event) => {
                    if (typeof window.Livewire.find('<?php echo e($_instance->getId()); ?>') !== 'undefined') {
                        if (!shouldPreventNavigation()) {
                            return
                        }

                        if (showUnsavedChangesAlert()) {
                            return
                        }

                        event.preventDefault()
                    }
                })

                window.addEventListener('beforeunload', (event) => {
                    if (!shouldPreventNavigation()) {
                        return
                    }

                    event.preventDefault()
                    event.returnValue = true
                })
            </script>
            <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?>
    <?php else: ?>
            <?php
        $__scriptKey = '1120888020-1';
        ob_start();
    ?>
            <script>
                window.addEventListener('beforeunload', (event) => {
                    if (
                        window.jsMd5(
                            JSON.stringify($wire.data).replace(/\\/g, ''),
                        ) === $wire.savedDataHash ||
                        $wire?.__instance?.effects?.redirect
                    ) {
                        return
                    }

                    event.preventDefault()
                    event.returnValue = true
                })
            </script>
            <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?>
    <?php endif; ?>
<?php endif; ?>
<?php /**PATH /home/runner/work/eu-vat.info/eu-vat.info/vendor/filament/filament/resources/views/components/page/unsaved-data-changes-alert.blade.php ENDPATH**/ ?>