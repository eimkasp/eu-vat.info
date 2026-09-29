<div class="app-code max-w-xl">
    <div class="flex items-center justify-between gap-3 border-b border-white/10 py-2 pl-4 pr-3">
        <p class="font-mono text-xs"><span class="font-semibold text-syntax-ok">GET</span> <span class="text-white/60">/api/v1/calculate?amount=100&amp;country=DE</span></p>
        <span class="font-mono text-xs text-syntax-ok">200</span>
    </div>
    <pre tabindex="0" class="overflow-x-auto p-4 font-mono text-xs leading-5 text-white/85"><span class="text-syntax-comment">// 100 net at the German standard rate</span>
{
  <span class="text-syntax-function">"net"</span>: <span class="text-syntax-literal">100</span>,
  <span class="text-syntax-function">"vat"</span>: <span class="text-syntax-literal">19</span>,
  <span class="text-syntax-function">"gross"</span>: <span class="text-syntax-literal">119</span>,
  <span class="text-syntax-function">"currency"</span>: <span class="text-syntax-string">"EUR"</span>
}</pre>
</div>
