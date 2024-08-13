<?php declare(strict_types = 1);

namespace Api\Dividends;

use App\Portfolio\Transaction;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * @phpstan-type Transaction array{ symbol: string, shares: float, investment: float, date: string }
 */
final class DividendService
{

	public const PortfolioLink = '/dividends/portfolio';

	private HttpClientInterface $httpClient;

	public function __construct(
		private string $baseUrl,
		?HttpClientInterface $httpClient,
	)
	{
		$this->httpClient = $httpClient ?? HttpClient::create();
	}

	/**
	 * @param Transaction[] $transactions
	 */
	public function requestPortfolio(array $transactions): ResponseInterface
	{
		return $this->httpClient->request('POST', $this->buildUrl(self::PortfolioLink), [
			'json' => $transactions,
		]);
	}

	/**
	 * @param array<string, scalar> $params
	 */
	private function buildUrl(string $path, array $params = []): string
	{
		$url = $this->baseUrl . $path;

		if (count($params) > 0) {
			$url .= '?' . http_build_query($params);
		}

		return $url;
	}

}