<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://static.vecteezy.com/system/resources/previews/003/108/337/large_2x/fitness-gym-logo-with-strong-athlete-and-barbell-vector.jpg" class="logo" alt="Laravel Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
