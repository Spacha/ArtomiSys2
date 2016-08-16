# ArtomiSys2
Small MVC catalogue and gallery management system

## Files explained

ArtomiSys's file structure the way it is now:

```
// Root folder
ArtomiSys2/
	// Appliation folder
	ArtomiSys/
		// All configurations rest here
		config/
			// Main configurations like default paths, timezone etc.
			config.php
			// Database configurations
			database.php
			// User defined custom routes
			routes.php
		// Page controllers are here
		Controllers/
			Dashboard/
				Index.php
				Login.php
				Products.php
				Settings.php
			// Helper classes
			Libs/
				// Main controller
				Controller.php
				// Dashboard controller takes care of logins and other dashboard-related stuff
				Dashboard.php
				// Controller which talks with database
				Database.php
				// Takes care of image uploads and stuff
				Images.php
				// Main model
				Model.php
				// Handles URIs and tells which controller, method etc. to call
				Router.php
				// Manages page rendering and other view-related stuff
				View.php
			Models/
				Dashboard/
					IndexModel.php
					LoginModel.php
					ProductsModel.php
					SettingsModel.php
				// Contains html skeletons for each view
				Views/
					// Separate sections of code which can be embedded to pages
					_snippets/
						dashboard/
							header.phtml
					// Static pages, mostly those which user sees
					_static/
						contact.phtml
						gallery.phtml
						index.phtml
						products.phtml
						services.phtml
					// Basic skeletons for pages
					_tempates/
						default.phtml
						login.phtml
					dashboard/
						index/
							guide.phtml
							index.phtml
						products/
							create.phtml
							delete.phtml
							edit.phtml
							index.phtml
							view.phtml
						settings/
							index.phtml
						login.phtml
				// Operates the whole application
				Bootstrap.php
	// Public web content
	public/
		css/
			login.css
			main.css
		img/
			icons/
		index.php
		robots.txt
	.htaccess
```
