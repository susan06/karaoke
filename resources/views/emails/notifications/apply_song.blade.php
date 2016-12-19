<p>Has recibido una notificación de solicitud de canción</p>

<p>Sucursal: {{ session('branch_office')->name }}</p>

<p>del cliente {{ $client->first_name.' '.$client->last_name }}</p>

<p>para la canción {{ $song->title.' de '.$song->artist }} </p>
