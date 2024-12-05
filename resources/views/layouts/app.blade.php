<!DOCTYPE html>
<html>
    // ...existing code...
    <body>
        // ...existing code...
        
        {{-- Add padding to prevent content from being hidden behind the bottom nav on mobile --}}
        <div class="pb-16 md:pb-0">
            {{ $slot }}
        </div>
        
        
        // ...existing code...
    </body>
</html>
