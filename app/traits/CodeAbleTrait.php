<?php
namespace traits;

trait CodeAble {

	protected $codeable = array();

	public function set_code()
	{
		if (!empty($this->codeable))
		{
			$codeable = $this->codeable;
			foreach ($codeable as $attribute => $elements_code) {
				if (is_array($elements_code))
				{
					$options = array();
					$options['timestamp'] = array_key_exists('timestamp', $codeable) ? $codeable['timestamp'] : false ;
					$options['separator'] = array_key_exists('separator', $codeable) ? $codeable['separator'] : '' ;
					unset($codeable['timestamp']);
					unset($codeable['separator']);
					$this->codeable($attribute, $elements_code, $options);
				}
			}
		}
	}

	protected function codeable($attribute, array $elements_code, array $options)
	{
		$code_arr = array();
		foreach ($elements_code as $element) {
			$element_arr = explode('.', $element);
			$object = $this;
			foreach ($element_arr as $method) {
				if ($method != end($element_arr))
				{
					$object = $object->$method()->first();
				}else{
					array_push($code_arr, $object->$method);
				}

			}
		}
		$this->$attribute = implode($options['separator'], $code_arr).$this->set_timestamp($options);
	}

	protected function set_timestamp($options)
	{
		$timestamp =  new \DateTime();

		return $options['timestamp'] ? $options['separator'].$timestamp->getTimestamp() : '' ;
	}

}