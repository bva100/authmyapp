<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Facebook_Connect for signup and login redirects. Sends users to AuthMyApp
 *
 * @author BRIAN ANDERSON
 */
class Script_Connect_Button_Facebook extends Script_Abstract {
	
	/**
	 * data used to create this script
	 *
	 * @var string
	 */
	private $file_data;
	
	/**
	 * iframe used produce 
	 *
	 * @var string
	 */
	private $iframe;
	
	/**
	 * Set file data
	 *
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function set_file_data()
	{
		// run create (this runs twice)
		$this->create();
		
		// create size via css
		switch ($this->data['size']) {
			case 'extra-large':
				$size = 
					'font-size: 20px;
					padding: 15px 30px;
					-webkit-border-radius: 8px;
					-moz-border-radius: 8px;
					border-radius: 8px;';
				$width = '290';
				$height= '68';
				break;
			case 'large':
				$size = 
					'padding: 11px 19px;
					font-size: 17.5px;
					-webkit-border-radius: 6px;
					-moz-border-radius: 6px;
					border-radius: 6px;';
				$width = '250';
				$height ='60';
				break;
			case 'medium':
				$size = ''; //leave as default
				$width = '193';
				$height = '46';
				break;
			case 'small':
				$size = 
					'padding: 2px 10px;
					font-size: 11.9px;
					-webkit-border-radius: 3px;
					-moz-border-radius: 3px;
					border-radius: 3px;';
				$width = '165';
				$height = '42';
				break;
			default:
				throw new Exception('Button size not available. Please try again.');
				break;
		}
		
		// create html and css
		$this->file_data = '
		
		<a href="'.$this->app->sender_url().'/Facebook.php?button_version='.Controller_Api::CONNECT_VERSION.'" class="btn-facebook" target="_top">'.$this->data['text'].'</a>
		
		<style type="text/css" media="screen">
			.btn-facebook {
				font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
				text-decoration: none;
				display: inline-block;
				*display: inline;
				padding: 4px 12px;
				margin-bottom: 0;
				*margin-left: .3em;
				font-size: 14px;
				line-height: 20px;
				color: #333333;
				text-align: center;
				text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
				vertical-align: middle;
				cursor: pointer;
				background-color: #f5f5f5;
				*background-color: #e6e6e6;
				background-image: -moz-linear-gradient(top, #ffffff, #e6e6e6);
				background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ffffff), to(#e6e6e6));
				background-image: -webkit-linear-gradient(top, #ffffff, #e6e6e6);
				background-image: -o-linear-gradient(top, #ffffff, #e6e6e6);
				background-image: linear-gradient(to bottom, #ffffff, #e6e6e6);
				background-repeat: repeat-x;
				border: 1px solid #cccccc;
				*border: 0;
				border-color: #e6e6e6 #e6e6e6 #bfbfbf;
				border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
				border-bottom-color: #b3b3b3;
				-webkit-border-radius: 4px;
				-moz-border-radius: 4px;
				border-radius: 4px;
				filter: progid:DXImageTransform.Microsoft.gradient(startColorstr = "#ffffffff", endColorstr="#ffe6e6e6", GradientType=0);
				filter: progid:DXImageTransform.Microsoft.gradient(enabled       = false);
				*zoom: 1;
				-webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
				-moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
				box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
				
				'.
					$size
				.'

				background-color: hsl(221, 72%, 27%) !important;
				background-repeat: repeat-x;
				filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#1d4cb3", endColorstr="#133276");
				background-image: -khtml-gradient(linear, left top, left bottom, from(#1d4cb3), to(#133276));
				background-image: -moz-linear-gradient(top, #1d4cb3, #133276);
				background-image: -ms-linear-gradient(top, #1d4cb3, #133276);
				background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #1d4cb3), color-stop(100%, #133276));
				background-image: -webkit-linear-gradient(top, #1d4cb3, #133276);
				background-image: -o-linear-gradient(top, #1d4cb3, #133276);
				background-image: linear-gradient(#1d4cb3, #133276);
				border-color: #133276 #133276 hsl(221, 72%, 23.5%);
				color: #fff !important;
				text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.23);
				-webkit-font-smoothing: antialiased;
			}
			
			.btn-facebook:hover,
			.btn-facebook:focus {
				color: #333333;
				text-decoration: none;
				background-position: 0 -15px;
				-webkit-transition: background-position 0.1s linear;
				-moz-transition: background-position 0.1s linear;
				-o-transition: background-position 0.1s linear;
				transition: background-position 0.1s linear;
			}
		</style>
		
		';
		
		// set iframe
		$this->iframe = '

<iframe src="'.URL::base(TRUE).'assets/clients/downloads/'.$this->filename().'.html" width="'.$width.'" height="'.$height.'" sandbox="allow-top-navigation" seamless></iframe>

<style type="text/css" media="screen">
	iframe[seamless]{
		background-color: transparent;
		border: 0px none transparent;
		padding: 0px;
		overflow: hidden;
		
	}
</style>';

	}
	
	/**
	 * Create file
	 *
	 * @return bool
	 * @author BRIAN ANDERSON
	 */
	public function create()
	{
		if ( ! $this->filename) 
		{
			$this->set_filename();
		}
		
		// create file
		file_put_contents ($this->path().$this->filename().'.html', $this->file_data, LOCK_EX);
		
		return file_exists($this->path().$this->filename().'.html');
	}
	
	/**
	 * Preview generated html
	 *
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function preivew()
	{
		return $this->file_date;
	}
	
	/**
	 * create text for copy and paste
	 *
	 * @return void
	 * @author BRIAN ANDERSON
	 */
	public function text()
	{
		$button = $this->file_data;
		$iframe = $this->iframe;
		return '<hr /><span class="script-preview-title">Preview</span>'.$button.'<hr /><div class="script-description">Copy and paste the following into your html. It will automatically create the button for you.</div><pre><code>'.htmlentities($iframe).'</code></pref>';
	}
	
	/**
	 * Return url associated with file. If compression has been requested, returns compressed file. Must call create prior to calling this method.
	 *
	 * @param bool $compression. Pass as false to force url of original file
	 * @return string
	 * @author BRIAN ANDERSON
	 */
	public function url($compression = TRUE)
	{
		if ($this->compression_type() AND $compression)
		{
			// return compression url
			return $this->url_path().$this->filename().'.'.$this->compression_type();
		}
		else
		{
			// return file url
			return $this->url_path().$this->filename().'.html';
		}
	}
	
	
}
