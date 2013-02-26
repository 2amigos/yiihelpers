<?php 
/**
 * 
 * EDownloadHelper Class
 *
 * Example of Usage:
 * 
 * // Import library (in protected.extensions.helpers)
 * Yii::import('ext.helpers.EDownloadHelper');
 * 
 * // assumming I have a folder docs under my webroot folder
 * EDownloadHelper::download(Yii::getPathOfAlias('webroot.docs').DIRECTORY_SEPARATOR.'myhugefile.zip');
 * 
 *
 *
 * @author: matt tabin <amigo.tabin@gmail.com>
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 *
 * @copyright Copyright &copy; 2amigos.us 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package yii-helpers
 */
class EDownloadHelper{
	
	public static $stream_types = array(
		'mp3','m3u','m4a','mid','ogg','ra','ram','wm', 
        'wav','wma','aac','3gp','avi','mov','mp4','mpeg',
        'mpg','swf','wmv','divx','asf'); 
	
	/**
	 * 
	 * Download a file with resume, stream and speed options
	 * 
	 * @param string $filename path to file including filename
	 * @param integer $speed maximum download speed
	 * @param boolean $doStream if stream or not
	 */
	public static function download( $filepath, $maxSpeed = 100, $doStream = false ){
	
		$seek_start 	=  0;
		$seek_end 		= -1;
		$data_section 	=  false;
		$buffsize 		=  2048; // you can set by multiple of 1024
		
		if(!file_exists($filepath) && is_file($filepath))
			throw new CException(Yii::t('EDownloadHelper','Filepath does not exists on specified location or is not a regular file'));
		
		$mimeType = CFileHelper::getMimeType( $filepath );
		$filename = basename( $filepath );
		
		if($mimeType == null) $mimeType = "application/octet-stream";
		
		$extension = CFileHelper::getExtension( $filepath );
		
		// resuming?
		if(isset($_SERVER['HTTP_RANGE']))
		{
			$seek_range = substr($_SERVER['HTTP_RANGE'], strlen('bytes='));
			
			$range = explode('-', $seek_range);
			
			// do it the old way, no fancy stuff
			// to avoid problems
			if($range[0] > 0)
				$seek_start = intval($range[0]);
			if($range[1] > 0)
				$seek_end = intval($range[1]);
				
			$data_section = true;
		}
		// do some cleaning before we start
		ob_end_clean();
		$old_status = ignore_user_abort(true);
		set_time_limit(0);

		$size = filesize( $filepath );
		
		if($seek_start > ($size -1)) $seek_start = 0;
		
		// open the file and move pointer
		// to started chunk
		$res = fopen( $filepath , 'rb');
		if($seek_start) fseek($res, $seek_start);
		if($seek_end < $seek_start) $seek_end = $size -1;
		
		
		header('Content-Type: '.$mimeType);
		
		$contentDisposition = 'attachment';
		if($doStream == true){ 
	        if(in_array( $extension,self::$stream_types )){  
	            $contentDisposition = 'inline'; 
        	} 
	    } 
		if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE")) { 
	        $fileName= preg_replace('/\./', '%2e', $filename, substr_count($filename, '.') - 1); 
	    } 
	    header('Content-Disposition: '.$contentDisposition.'; filename="'.$filename.'"');
	    header('Last-Modified: ' . date('D, d M Y H:i:s \G\M\T', filemtime( $filepath )));
	    
	    // flushing a data section?
	    if( $data_section )
	    {
	    	header("HTTP/1.0 206 Partial Content"); 
            header("Status: 206 Partial Content"); 
            header('Accept-Ranges: bytes'); 
            header("Content-Range: bytes $seek_start-$seek_end/$size"); 
            header("Content-Length: " . ($seek_end - $seek_start + 1)); 	
	    	
	    }else // nope, just 
	    	header('Content-Length: '.$size);
	    
	    $size = $seek_end - $seek_start + 1;
	    
	    while(!( connection_aborted() || connection_status() == 1) && !feof($res))
	    {
	    	print(fread($res, $buffsize*$maxSpeed));
	    	
	    	flush();
	    	@ob_flush();
	    	sleep(1);
	    }
	    // close file
	    fclose($res);
	    // restore defaults
	    ignore_user_abort($old_status);
	    set_time_limit(ini_get('max_execution_time'));
	    
	}
}