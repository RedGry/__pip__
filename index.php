<pre style="padding-top: 20%; padding-left: 40%">
<?php
print_r(array(
    "laba#1" => "<a href='/l1'>".apache_request_headers()['Host']."/l1</a>",
    "laba#2" => "<a href='/l1'>".apache_request_headers()['Host']."/l2</a>"
));
?>
<br>
<div style="text-align: center">
<span id="clock" ></span>
</div>
</pre>
<script>
    function clock() {
        var date = new Date(),
            hours = (date.getHours() < 10) ? '0' + date.getHours() : date.getHours(),
            minutes = (date.getMinutes() < 10) ? '0' + date.getMinutes() : date.getMinutes(),
            seconds = (date.getSeconds() < 10) ? '0' + date.getSeconds() : date.getSeconds();
        document.getElementById('clock').innerHTML = hours + ':' + minutes + ':' + seconds;
    }
    setInterval(clock, 1000)
</script>