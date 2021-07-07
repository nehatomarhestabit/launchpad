<?php

namespace HBF\Form\AbstractClass;
use HBF\Form\Field;

defined( 'ABSPATH' ) || exit;
 
abstract class Base {
	
	/**
	 * [$forms description]
	 * @var [type]
	 */
	public $forms;

	/**
	 * [__construct description]
	 */
	public function __construct( ) {
		$this->field = new Field();
	}

	/**
	 * [register description]
	 * @param  [type] $key    [description]
	 * @param  [type] $config [description]
	 * @return [type]         [description]
	 */
	public function register( $key, $config ) {
		$this->form = $key;
		$this->forms[$key]['fields'] = $config;
		return $this;
	}

	/**
	 * [get description]
	 * @param  [type] $key [description]
	 * @return [type]      [description]
	 */
	public function get( $key ) {
		if( !isset( $this->forms[$key]) ):
			throw new \Exception("Form $key does not exist.", 101);
		endif;
		
		$this->form = $key;
		return $this;
	}

	/**
	 * [get_fields description]
	 * @return [type] [description]
	 */
	protected function get_fields( ) {
		return call_user_func( $this->forms[$this->form]['fields'] );
	}

	protected function get_field_values( ) {
		return call_user_func( $this->forms[$this->form]['values'] );
	}


	/**
	 * [onSubmit description]
	 * @param  [type] $callback [description]
	 * @return [type]           [description]
	 */
	public function onSubmit( $callback ) {
		$this->forms[$this->form]['on_submit'] = $callback;
	}

	/**
	 * [execute_submit description]
	 * @return [type] [description]
	 */
	public function execute_submit() {
		call_user_func( $this->forms[$this->form]['on_submit'] );
	}

	/**
	 * [render description]
	 * @return [type] [description]
	 */
	public function render( $callback = null ) {
		
		$template = call_user_func( $callback );

		$data = [];
		
		$fields = call_user_func($this->forms[$this->form]['fields']);

		foreach ( $fields  as $key => $field) {
			ob_start();
				call_user_func( array( $this->field, 'render'),  apply_filters( "HBF/FORM/FIELD/ARGS",  $field, $this->form ) );
			$data[$field['name']] = ob_get_clean();
		}

        if (preg_match_all("/{{(.*?)}}/", $template, $m)) {
            foreach ( $m[1] as $i => $varname ) {
                $template = str_replace($m[0][$i], sprintf('%s', $data[$varname] ), $template);
            }
        }

		do_action("HBF/FORM/START", $this->form, $fields );
			echo $template;
		do_action("HBF/FORM/END", $this->form,  $fields );
	}
}


