<?php
namespace traits;
use exception\ValidationException;
use \Hash;

trait ChangePassword
{
	public function changePassword($input) 
	{
	    $this->setupChangePasswordRules();
	    if ($this->oldPasswordCorrect($input['old_password']))
	    {
        	if ($this->validate( $input, $this->rules, $this->messages ))
        	{
        		$this->password = $input['password'];
			    $this->password_confirmation = $input['password_confirmation'];
			    $this->touch();
			    $this->save();	
	 			return true;
        	}
	    }
	    return false;
	}

	protected function setupChangePasswordRules()
	{
		$this->rules = array(
        'old_password'              => 'required',
        'password'                  => 'required|confirmed|different:old_password|min:8|alpha_num',
        'password_confirmation'     => 'required|different:old_password|same:password'
	    );
	}

	protected function oldPasswordCorrect($oldPassword)
	{
		if( ! Hash::check($oldPassword, $this->password) ){
	        $this->errors = $this->errors->add('old_password', 'Password not match.');
	        return false;
	    }
	    return true;
	}

}
