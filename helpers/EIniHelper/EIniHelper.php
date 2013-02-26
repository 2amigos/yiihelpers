<?php
/**
 * 
 * EIniHelper Class
 *
 * 
 * Example INI file
 * 
 * ; This is the default layout for a settings file.
 * ; -----------------------------------------------
 * ; Default database connection. 
 * ; -----------------------------------------------
 * 
 * [Database]
 * connectionType = mysql
 * host = localhost
 * username = root
 * password = thisismypassword
 * database = dbmydatabase
 * 
 * ; The settings parameters
 * [Parameters]
 * language = es_es
 * adminemail = admin@email.com
 * 
 * Example of use (with above INI file)
 * 
 * $helper 		= EIniHelper::Load('pathtoInifile');
 * $dataConf 	= $helper->Get('Database');
 * $username 	= $helper->Get('Database','username');
 * 
 * $dataConf = EIniHelper::Load('pathtoInifile')->Get("Database");
 * 
 * $language = EIniHelper::Load('pathtoInifile')->Get("Parameters","language");
 *
 * @author: matt tabin <amigo.tabin@gmail.com>
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 *
 * @copyright Copyright &copy; 2amigos.us 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package yii-helpers
 */
class EIniHelper {
  
  	private $settingsfile, $settings;

	/**
	  * Constructor.
	  * Loads the settings by parsing the ini file passed 
	  * in the constructor parameter.
	  * @param string $settingsfile
	  */
	function __construct($settingsfile) 
	{
		if(!file_exists($settingsfile))
			throw new CException(Yii::t('EIniHelper','INI file not found'));
			
		$this->settingsfile = $settingsfile;
		$this->settings = parse_ini_file($this->settingsfile, true);
	
	}

	/**
	 * Settings::Load
	 *
	 * Singleton functionality that creates one instance per loaded settings 
	 * file so that ini parsing needs to happen only once.
	 * @param string $settingsfile file to read for settings
	 */
	public static function Load($settingsfile= 'settings.ini')
	{
		static $instances = array();
		if(!array_key_exists($settingsfile, $instances)) {
			$instances[$settingsfile] = new EIniHelper($settingsfile);
		}
		return($instances[$settingsfile]);
	}
  
	/**
	 * Settings::Get
	 * 
	 * Gets an array of parameters for a key of settings file or 
	 * gets one specific setting under a key.
	 * @param string $param 
	 * @return string subsection | array ini section
	 */
	function Get($section, $subsection = false)
	{
		if($this->settings === false) throw new CException(Yii::t('EIniHelper','error reading INI file')); 
		return ($subsection) ? $this->settings[$section][$subsection] : $this->settings[$section];
	}
  
}

?>