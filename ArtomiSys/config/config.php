<?php

/* GENERAL */

switch(APP_ENV) {
	case 'development':


		/*************************
		*   DEVELOPMENT CONFIG   *
		*************************/


		define('APP_NAME', 'ArtomiSys');

		define('DATE_DEFAULT_TIMEZONE', 'Europe/Helsinki');
		define('DATE_FORM', 'j.m.y \&\n\b\s\p\; \k\l\o H:i');

		/* PATHS */

		/* PUBLIC */

		// leave this empty if in root (no backslash!)
		define('ROOT_DIR', '/ArtomiSys2');


		/* SERVER */

		define('PATH_TO_LOGS', 'ArtomiSys/logs');
		define('PATH_TO_TEMPLATES', 'ArtomiSys/Views/_templates');
		define('PATH_TO_SHEETS', 'ArtomiSys/Views');
		define('PATH_TO_SNIPPETS', 'ArtomiSys/Views/_snippets');
		define('PATH_TO_ERROR_FILES', 'ArtomiSys/Views/_errors');

		/* FILES */

		define('UPLOAD_DESTINATION', PATH_FILE_ROOT . '/' . PUBLIC_HTML . '/uploads/products');
		define('DEFAULT_PREVIEW_IMG', ROOT_DIR . '/img/no-image.png');
		define('UPLOAD_MAX_SIZE', 1000000);

		break;

	default:


		/************************
		*   PRODUCTION CONFIG   *
		************************/


		define('APP_NAME', 'ArtomiSys');

		define('DATE_DEFAULT_TIMEZONE', 'Europe/Helsinki');
		define('DATE_FORM', 'j.m.y \&\n\b\s\p\; \k\l\o H:i');

		/* PATHS */

		define('PATH_ROOT', $_SERVER['SERVER_NAME'] . '/ArtomiSys2');

		define('PATH_TO_LOGS', 'ArtomiSys/logs');
		
		define('PATH_TO_CSS', 'public/css');
		define('PATH_TO_TEMPLATES', 'ArtomiSys/Views/_templates');
		define('PATH_TO_SHEETS', 'ArtomiSys/Views');
		define('PATH_TO_SNIPPETS', 'ArtomiSys/Views/_snippets');
		define('PATH_TO_ERROR_FILES', 'ArtomiSys/Views/_errors');

		/* FILES */

		define('UPLOAD_DESTINATION', 'public/uploads/products');
		define('DEFAULT_PREVIEW_IMG', 'public/img/no-image.png');
		define('UPLOAD_MAX_SIZE', 1000000);

		break;
}