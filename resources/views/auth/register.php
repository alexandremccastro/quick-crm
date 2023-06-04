@parent('layout.auth')

<Register alert='<?php echo session()->fetch('alert', true) ?>' />