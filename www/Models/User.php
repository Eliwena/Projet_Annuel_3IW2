<?php

namespace App\Models;

use App\Core\Database;

class User extends Database
{
    protected $tableName = 'users';

	protected $id = null;
	protected $firstname;
	protected $lastname;
	protected $email;
	protected $pwd;
	protected $country;
	protected $role = 0;
	protected $status = 1;
	protected $isDeleted = 0;

	/*
		role
		status
		createdAt
		updatedAt
		isDeleted (hard delete du soft delete) attention au RGPD
	*/


	public function __construct(){
	    $this->_tableName = $this->tableName;
        parent::__construct();
	}

	//Parse error: syntax error, unexpected 'return' (T_RETURN) in /var/www/html/Models/User.php on line 41

	/**
	 * @return integer|null
	 */
	public function getId(): ?int
	{
	    return $this->id;
	}
	/**
	 * @param integer|null $id
	 */
	public function setId($id): ?User
	{
	    $this->id = $id;
	    return $this;
	    //ON doit peupler (populate) l'objet avec les valeurs de la bdd ...
	}

	/**
	 * @return string|null
	 */
	public function getFirstname(): ?string
	{
	    return $this->firstname;
	}
	/**
	 * @param string|null $firstname
	 */
	public function setFirstname($firstname): ?User
	{
	    $this->firstname = $firstname;
	    return $this;
	}
	/**
	 * @return string|null
	 */
	public function getLastname(): ?string
	{
	    return $this->lastname;
	}
	/**
	 * @param string|null $lastname
	 */
	public function setLastname($lastname): ?User
	{
	    $this->lastname = $lastname;
	    return $this;
	}


	/**
	 * @return mixed
	 */
	public function getEmail()
	{
	    return $this->email;
	}
	/**
	 * @param mixed $email
	 */
	public function setEmail($email): void
	{
	    $this->email = $email;
	}
	/**
	 * @return mixed
	 */
	public function getPwd()
	{
	    return $this->pwd;
	}
	/**
	 * @param mixed $pwd
	 */
	public function setPwd($pwd): void
	{
	    $this->pwd = PASSWORD_HASH($pwd, PASSWORD_DEFAULT);
	}
	/**
	 * @return mixed
	 */
	public function getCountry()
	{
	    return $this->country;
	}
	/**
	 * @param mixed $country
	 */
	public function setCountry($country): void
	{
	    $this->country = $country;
	}
	/**
	 * @return int
	 */
	public function getRole(): int
	{
	    return $this->role;
	}
	/**
	 * @param int $role
	 */
	public function setRole(int $role): void
	{
	    $this->role = $role;
	}
	/**
	 * @return int
	 */
	public function getStatus(): int
	{
	    return $this->status;
	}
	/**
	 * @param int $status
	 */
	public function setStatus(int $status): void
	{
	    $this->status = $status;
	}
	/**
	 * @return int
	 */
	public function getIsDeleted(): int
	{
	    return $this->isDeleted;
	}
	/**
	 * @param int $isDeleted
	 */
	public function setIsDeleted(int $isDeleted): void
	{
	    $this->isDeleted = $isDeleted;
	}


	public function formBuilderLogin(){
		return [

			"Configurations"=>[
				"method"=>"POST",
				"action"=>"",
				"class"=>"form_control",
				"id"=>"form_register",
				"submit"=>"Se connecter"
			],
			"inputs"=>[

				"email"=>[
								"type"=>"email",
								"placeholder"=>"Exemple : nom@gmail.com",
								"label"=>"Votre Email",
								"required"=>true,
								"class"=>"form_input",
								"minLength"=>8,
								"maxLength"=>320,
								"error"=>"Votre email doit faire entre 8 et 320 caractères"
							],

				"pwd"=>[
								"type"=>"password",
								"label"=>"Votre mot de passe",
								"required"=>true,
								"class"=>"form_input",
								"minLength"=>8,
								"error"=>"Votre mot de passe doit faire au minimum 8 caractères"
							]
			]

		];
	}

	public function formBuilderRegister(){

		return [

			"Configurations"=>[
				"method"=>"POST",
				"action"=>"",
				"class"=>"form_control",
				"id"=>"form_register",
				"submit"=>"S'inscrire"
			],
			"inputs"=>[
				"firstname"=>[
								"type"=>"text",
								"placeholder"=>"Exemple : Yves",
								"label"=>"Votre Prénom",
								"required"=>true,
								"class"=>"form_input",
								"minLength"=>2,
								"maxLength"=>50,
								"error"=>"Votre prénom doit faire entre 2 et 50 caractères"
							],
				"lastname"=>[
								"type"=>"text",
								"placeholder"=>"Exemple : Skrzypczyk",
								"label"=>"Votre Nom",
								"required"=>true,
								"class"=>"form_input",
								"minLength"=>2,
								"maxLength"=>100,
								"error"=>"Votre nom doit faire entre 2 et 100 caractères"
							],

				"email"=>[
								"type"=>"email",
								"placeholder"=>"Exemple : nom@gmail.com",
								"label"=>"Votre Email",
								"required"=>true,
								"class"=>"form_input",
								"minLength"=>8,
								"maxLength"=>320,
								"error"=>"Votre email doit faire entre 8 et 320 caractères"
							],

				"pwd"=>[
								"type"=>"password",
								"label"=>"Votre mot de passe",
								"required"=>true,
								"class"=>"form_input",
								"minLength"=>8,
								"error"=>"Votre mot de passe doit faire au minimum 8 caractères"
							],

				"pwdConfirm"=>[
								"type"=>"password",
								"label"=>"Confirmation",
								"required"=>true,
								"class"=>"form_input",
								"confirm"=>"pwd",
								"error"=>"Votre mot de passe de confirmation ne correspond pas"
							],

				"country"=>[
								"type"=>"text",
								"placeholder"=>"Exemple : fr",
								"label"=>"Votre Pays",
								"required"=>true,
								"class"=>"form_input",
								"minLength"=>2,
								"maxLength"=>2,
								"error"=>"Votre pays doit faire 2 caractères"
							],
			]

		];

	}

}









