<p>Has recibido una notificación de reservación</p>

<p>Sucursal: {{ session('branch_office')->name }}</p>

<p>del cliente {{ $client->first_name.' '.$client->last_name }}</p>

<p>para la mesa {{ $reservation->num_table }} </p>

<p>fecha y hora: {{ date_format(date_create($reservation->date), 'd-m-Y').' '.$reservation->time }} </p>