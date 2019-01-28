<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\Lotus\Client;

use ISPA\ApiClients\Domain\AbstractHttpClient;
use ISPA\ApiClients\Http\Utils\Helpers;
use Psr\Http\Message\ResponseInterface;

class UserClient extends AbstractHttpClient
{

	private const PATH = 'users';

	public function list(int $limit = 10, int $offset = 0): ResponseInterface
	{
		$query = Helpers::buildQuery([
			'limit' => $limit > 0 ? $limit : 10,
			'offset' => $offset >= 0 ? $offset : 0,
		]);
		return $this->httpClient->request('GET', sprintf('%s?%s', self::PATH, $query));
	}

	public function getById(int $id): ResponseInterface
	{
		return $this->httpClient->request('GET', sprintf('%s/detail/%d', self::PATH, $id));
	}

	public function getByEmail(string $email): ResponseInterface
	{
		$query = Helpers::buildQuery(['email' => $email]);
		return $this->httpClient->request('GET', sprintf('%s/detail/email?%s', self::PATH, $query));
	}

}