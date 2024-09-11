<?php declare(strict_types = 1);

namespace Api\Dividends;

use Api\Core\RequestType;
use Api\Core\Service;
use Api\Core\ServiceRequest;
use App\Portfolio\Transaction;

/**
 * @phpstan-type Transaction array{ symbol: string, shares: float, investment: float, date: string }
 */
final class DividendService extends Service
{

	public const PortfolioLink = '/dividends/portfolio';

	/**
	 * @param Transaction[] $transactions
	 */
	public function portfolio(array $transactions, int $year, bool $sensitive): ServiceRequest
	{
		return $this->requestJson(RequestType::Post, $transactions, self::PortfolioLink, [
			'year' => $year,
			'sensitive' => $sensitive ? null : 'false',
		]);
	}

}
