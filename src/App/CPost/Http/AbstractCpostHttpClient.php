<?php declare(strict_types = 1);

namespace ISPA\ApiClients\App\CPost\Http;

use InvalidArgumentException;
use ISPA\ApiClients\Domain\AbstractHttpClient;
use ISPA\ApiClients\Http\HttpClient;

abstract class AbstractCpostHttpClient extends AbstractHttpClient
{

	protected const REQUEST_TIMEOUT = 5;

	/** @var mixed[] */
	protected $config = [];

	/**
	 * @param mixed[] $config
	 */
	public function __construct(HttpClient $httpClient, array $config)
	{
		parent::__construct($httpClient);
		$this->config = $config;
	}

	protected function getUsername(): string
	{
		$this->assertUsernamePassword();

		return $this->config['http']['auth'][0];
	}

	protected function getPassword(): string
	{
		$this->assertUsernamePassword();

		return $this->config['http']['auth'][1];
	}

	protected function getTmpDir(): string
	{
		if (!array_key_exists('config', $this->config) || !isset($this->config['config']['tmp_dir'])) {
			throw new InvalidArgumentException('Mandatory CPost "tmp_dir" config missing');
		}

		return $this->config['config']['tmp_dir'];
	}

	protected function assertUsernamePassword(): void
	{
		if (!array_key_exists('http', $this->config) || !array_key_exists('auth', $this->config['http'])) {
			throw new InvalidArgumentException('Mandatory "auth" section of Cpost client configuration is missing.');
		}

		if (!isset($this->config['http']['auth'][0]) || !isset($this->config['http']['auth'][1])) {
			throw new InvalidArgumentException('You must provide both  auth username and password for Cpost client');
		}
	}

}