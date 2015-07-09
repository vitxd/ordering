<?php

namespace Ordering\Repository;


use Ordering\Model\User;
use Silex\Application;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserRepository extends Base implements UserProviderInterface
{
	/**
	 * @var \Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder
	 */
	protected $encoder;

	public function __construct(Application $app)
	{
		$this->encoder = $app['security.encoder.digest'];
		parent::__construct($app);
	}

	protected function buildModel(array $data)
	{
		$user = new User;

		$user
			->setId($data['id'])
			->setEmail($data['email'])
			->setName($data['name'])
			->setPassword($data['password'])
			->setSalt($data['salt'])
			->setCDate($data['c_date']);
		;

		return $user;
	}

	public function find($id)
	{
		$data = $this->db->executeQuery('SELECT * FROM users WHERE id = :id', [
			':id' => $id
		])->fetchAll();

		return count($data) ? $this->buildModel($data[0]) : null;
	}

	public function save(User $user)
	{
		$data = [
			'id' 	=> $user->getId(),
			'name' 	=> $user->getName(),
			'email'	=> $user->getEmail(),
		];

		if (strlen($user->getPassword()) != 88)
		{
			$data['salt'] = uniqid(mt_rand());
			$data['password'] = $this->encoder->encodePassword($user->getPassword(), $data['salt']);
		}

		if ($user->getId())
		{
			$this->db->update('users', $data, ['id' => $user->getId()]);
		}
		else
		{
			$data['c_date'] = date('Y-m-d H:i:s');
			$this->db->insert('users', $data);
			$user->setCDate($data['c_date']);
			$id = $this->db->lastInsertId();
			$user
				->setId($id)
				->setSalt($data['salt'])
				->setPassword($data['password'])
			;
		}
	}

	public function loadUserByUsername($username)
	{
		$queryBuilder = $this->db->createQueryBuilder();
		$queryBuilder
				->select('u.*')
				->from('users', 'u')
				->where('u.email = :username')
				->setParameter('username', $username)
				->setMaxResults(1);
		$statement = $queryBuilder->execute();
		$usersData = $statement->fetchAll();
		if (empty($usersData))
		{
			throw new UsernameNotFoundException(sprintf('User "%s" not found.', $username));
		}
		$user = $this->buildModel($usersData[0]);
		return $user;
	}

	/**
	 * Refreshes the user for the account interface.
	 *
	 * It is up to the implementation to decide if the user data should be
	 * totally reloaded (e.g. from the database), or if the UserInterface
	 * object can just be merged into some internal array of users / identity
	 * map.
	 *
	 * @param UserInterface $user
	 *
	 * @return UserInterface
	 *
	 * @throws UnsupportedUserException if the account is not supported
	 */
	public function refreshUser(UserInterface $user)
	{
		$class = get_class($user);
		if (!$this->supportsClass($class))
		{
			throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $class));
		}
		$id = $user->getId();
		$refreshedUser = $this->find($id);
		if (false === $refreshedUser)
		{
			throw new UsernameNotFoundException(sprintf('User with id %s not found', json_encode($id)));
		}
		return $refreshedUser;
	}

	/**
	 * Whether this provider supports the given user class.
	 *
	 * @param string $class
	 *
	 * @return bool
	 */
	public function supportsClass($class)
	{
		return 'Ordering\Model\User' === $class;
	}
}