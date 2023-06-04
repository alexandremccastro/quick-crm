@parent('layout.admin')

<list-customer customers='<?php echo json_encode($customers) ?>'></list-customer>