<?php
return array(

	/*
	|--------------------------------------------------------------------------
	| Usar Roles
	|--------------------------------------------------------------------------
	|
	| El usuar roles determina si el menu y los contoles de accseso
	| al sistema estaran restringidos por la definicion de permisos
	| asignados a un rol que posteriormente es asignado a un usuario.
	|
	*/

	'usarRoles'        => true,

	/*
	|--------------------------------------------------------------------------
	| Renderizar Nombre
	|--------------------------------------------------------------------------
	|
	| Renderizar el nombre del usuario en el menu despliega el nombre 
	| registrado del usuario y no unicamentge un icono de usuario generico.
	|
	*/

	'rendernombremenu' => true,

	/*
	|--------------------------------------------------------------------------
	| Editar Perfil
	|--------------------------------------------------------------------------
	|
	| Editar perfil se refiere a que si el usuario va a tener la potestad
	| de editar su propio perfil dentro de la aplicacion. Si el valor es
	| falso no se renderizara link a cambio de perfil.
	|
	*/

	'editprofile'      => true,
	'editprofileurl'   => 'editarperfil',

	/*
	|--------------------------------------------------------------------------
	| Ver Ayuda
	|--------------------------------------------------------------------------
	|
	| Ver ayuda se refiere a que si el usuario va a tener la potestad
	| de ver una pantalla de ayuda dentro de la aplicacion. Si el valor es
	| falso no se renderizara link a ver ayuda.
	|
	*/

	'viewhelp'         => true,
	'viewhelpurl'      => 'ayuda',
	
	/*
	|--------------------------------------------------------------------------
	| Ver Acerca
	|--------------------------------------------------------------------------
	|
	| Ver acerca se refiere a que si el usuario va a tener la potestad
	| de ver una pantalla de "acerca de" dentro de la aplicacion. 
	| Si el valor es falso no se renderizara link a ver acerca de.
	|
	*/

	'viewabout'        => true,
	'viewabouturl'     => 'about',

	/*
	|--------------------------------------------------------------------------
	| Campos
	|--------------------------------------------------------------------------
	|
	| Los campos son aquellos elementos que se renderizaran en el menu;
	| Para esto se tuiliza la llave como el nombre que el sistema llama
	| para la contruccion del mismo y como valor se emplea el nombre del
	| campo real.
	|
	*/
	
	'campos'=>array(

		'titulo'  => 'nombre',
		'ruta'    => 'ruta',
		'icono'   => 'icono',
		'menuid'  => 'menuid',
		'padreid' => 'padreid'
		
	)
);
