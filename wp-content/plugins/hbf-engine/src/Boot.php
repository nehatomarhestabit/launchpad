<?php
 
namespace HBF\Engine;
use HBF\Engine\AbstractClass\Base;

defined( 'ABSPATH' ) || exit;

class Boot extends Base {
 
    private static $instance = null;
 
    public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self( (new Repository( )) );
		}
		return self::$instance;
	}

	public function __construct( Repository $repository ) {

 		$this->repository = $repository;
 		
 		$this->head = new Head( );
 		$this->menu = new Menu( );
 		$this->request = new Request( );
 		$this->sidebar = new Sidebar( );
 		$this->config = new Config( );
	}

}
 