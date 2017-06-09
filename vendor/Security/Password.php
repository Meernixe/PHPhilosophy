<?php 

	namespace Phphilosophy\Security;
	
	/**
	* Hashes the users password with Blowfish and a salt
	* which is to be stored in the database seperately. 
	*
	* @author Pandoria <info@hippodora.de>
	* @copyright 2015 Pandoria
	* @version 0.1.0
	* @package Phphilosophy
	* @subpackage Security
	*/
	class Password {
		
		/**
		* Creates a random salt value. This salt needs to be
		* stored in the database as well, ad it is also required
		* for checking a hash against a password.
		* @access public
		* @return string
		*/
		public function createSalt() {
			$random 	= mt_rand();
			$hashed 	= hash('md5', $random);
			$salt 		= str_shuffle($hashed);
			return $salt;
		}
		
		/**
		* Hashes the password using a salt value, whirlpool and 
		* blowfish
		* @access public
		* @param string $raw
		* @param string $salt
		* @return string
		*/
		public function hash($raw, $salt) {
			$string = hash_hmac('whirlpool' ,$raw, $salt);
            $hash   = crypt($string, '$2a$06$'.$string);
            return $hash;
		}
		
		/**
		* Checks the password against the stored hash.
		* @access public
		* @param string $raw
		* @param string $salt
		* @param string $hashed
		* @return boolean
		*/
		public function check($raw, $salt, $hashed) {
			if ($hashed === $this->hash($raw, $salt)) {
				return true;
			}
			return false;
		}
	}
?>