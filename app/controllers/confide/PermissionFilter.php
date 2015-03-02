<?php
namespace confide;
class PermissionFilter {
    
    public function filter($route, $request)
    {
        $user = \Confide::user();
        $permitted = $user->hasRole('super_admin');
        if (is_null($permitted))
        {
            foreach($user->roles as $role) {
            $permited = $role->hasPermission($route->getName());
        }   
        }   
        if(!$permitted) {
            return Redirect::route('user.denied');
        }
    }
}