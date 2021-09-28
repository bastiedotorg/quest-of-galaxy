<?php

/**
 *  2Moons 
 *   by Jan-Otto Kröpke 2009-2016
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @package 2Moons
 * @author Jan-Otto Kröpke <slaver7@gmail.com>
 * @copyright 2009 Lucky
 * @copyright 2016 Jan-Otto Kröpke <slaver7@gmail.com>
 * @licence MIT
 * @version 1.8.0
 * @link https://github.com/jkroepke/2Moons
 */


class ShowLoginPage extends AbstractLoginPage
{
	public static $requireModule = 0;

	function __construct() 
	{
		parent::__construct();
	}
	
	function show() 
	{
		if (empty($_POST)) {
			HTTP::redirectTo('index.php');	
		}

		$db = Database::get();

		$username = HTTP::_GP('username', '', UTF8_SUPPORT);
		$password = HTTP::_GP('password', '', true);

		$sql = "SELECT id, password FROM %%USERS%% WHERE universe = :universe AND username = :username;";
		$loginData = $db->selectSingle($sql, array(
			':universe'	=> Universe::current(),
			':username'	=> $username
		));

		$sql = "SELECT capaktiv, cappublic, capprivate FROM uni1_config";
		$verkey = $db->selectSingle($sql);

		if (!empty($verkey["capaktiv"]) && !empty($verkey["cappublic"]) && !empty($verkey["capprivate"])) {
			require 'includes/libs/reCAPTCHA/invisible/Recaptcha.php';
			$recaptcha = $_POST['g-recaptcha-response'];
			$object = new Recaptcha(['client-key' => $verkey["cappublic"], 'secret-key' => $verkey["capprivate"]]);
			$response = $object->verifyResponse($recaptcha);

			if(isset($response['success']) and $response['success'] != true) {
				echo "An Error Occured and Error code is :".$response['error-codes'][0].'<br>';
				echo 'You will be redirected to the home page in 5 seconds.';
				die('<meta http-equiv="refresh" content="5; url=index.php" />');
				}
		}

		if (!empty($loginData))
		{
			if (!password_verify($password, $loginData['password'])) {
                HTTP::redirectTo('index.php?code=1');
			}

			$session	= Session::create();
			$session->userId		= (int) $loginData['id'];
			$session->adminAccess	= 0;
			$session->save();

			HTTP::redirectTo('game.php');
		}
		else
		{
			HTTP::redirectTo('index.php?code=1');
		}
	}
}
