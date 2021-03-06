<?php

require_once("../grima-lib.php");

class AdminDemoteUser extends GrimaTask {

	function do_task() {
		$user = GrimaUser::GetCurrentUser();
		if ($user['isAdmin']) {
			$username = $this['username'];
			$institution = $this['institution'] or $user['institution'];
			$newuser = GrimaUser::LookupUser($username, $institution);
			if ($newuser === false) {
				throw new Exception( "User '$username' at $institution does not exist.");
			}
			if ($newuser['isAdmin']) {
				$newuser['isAdmin'] = false; 
				$newuser->updateDB();
				$this->addMessage('success',"User $username at $institution is no longer admin.");
			} else {
				$this->addMessage('warning',"User $username at $institution is not admin.");
			}
		} else {
			throw new Exception("User {$user['username']} (you) is not admin.");
		}
	}
}

AdminDemoteUser::RunIt();
