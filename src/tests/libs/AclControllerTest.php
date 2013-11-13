<?php

class AclTest extends MainTestCase
{

	protected $acl = null;
	protected $mockedUser = null;
	protected $mockedAuth = null;

	public function setUp()
	{
		parent::setUp();

		$this->acl = new Eubby\Libs\Acl\Acl();

		$this->mockedUser = Mockery::mock('Eubby\Models\User');
	}

	public function testInjectAuthObject()
	{
		$this->assertInstanceOf('Illuminate\Auth\AuthManager', $this->acl->getAuthObj());
	}

	public function testGetUser()
	{
		$this->acl->setUser($this->mockedUser);

		$user = $this->acl->getUser();

		$this->assertInstanceOf('Eubby\Models\User', $user);
	}
}