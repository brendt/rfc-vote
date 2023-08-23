<tr>
<td>
<table class="footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td class="content-cell" align="center">
<p>&copy; {{ date('Y') }} {{ config('app.name') }}.<br />This project is open source. <a href="https://github.com/brendt/rfc-vote" target="_blank">Contribute</a> and collaborate with us!</p>
{{ Illuminate\Mail\Markdown::parse($slot) }}
</td>
</tr>
</table>
</td>
</tr>
