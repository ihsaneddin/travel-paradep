<?php
namespace validators;
use exception\ValidationException;
use Illuminate\Validation\Factory as IlluminateValidator;
class Validator
{
	protected $validator;

    public function __construct( IlluminateValidator $validator ) {
        $this->validator = $validator;
    }
    function validate( array $data, array $rules = array(), array $custom_errors = array())
	{
		if ( ! empty($rules) && ! empty($data))
		{
			$validation = $this->validator->make( $data, $rules, $custom_errors );
			if ($validation->fails())
			{
				throw new ValidationException( $validation->messages() );
			}
		}
		return true;
	}
}
