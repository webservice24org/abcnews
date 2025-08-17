@props([
    'url',
    'color' => 'primary',
    'align' => 'center',
])
<table class="action" align="{{ $align }}" width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td align="{{ $align }}">
<table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td align="{{ $align }}">
<table border="0" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td>
    <a href="{{ $url }}"
   class="button button-{{ $color }}"
   target="_blank" rel="noopener"
   @if($color === 'red')
       style="background-color:#dc2626;
              border-top:10px solid #dc2626;
              border-right:18px solid #dc2626;
              border-bottom:10px solid #dc2626;
              border-left:18px solid #dc2626;
              color:#ffffff !important;"
   @endif
>
    {!! $slot !!}
</a>

</td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>

