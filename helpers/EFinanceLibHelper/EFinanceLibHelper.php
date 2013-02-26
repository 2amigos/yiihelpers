<?php
/**
 * FinanceLibHelper.php
 *
 * @author: matt tabin <amigo.tabin@gmail.com>
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 *
 * @copyright Copyright &copy; 2amigos.us 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package yii-helpers
 */
class EFinanceLibHelper
{
	/**
	 *  cumulative normal distribution function from Sanjay Ichalkaranje from http://php.net/manual/en/book.math.php
	 *  used for black-scholes pricing formula
	 */
	public static function cnd($val)
	{
		$p = floatval(0.2316419);
		$b1 = floatval(0.319381530);
		$b2 = floatval(-0.356563782);
		$b3 = floatval(1.781477937);
		$b4 = floatval(-1.821255978);
		$b5 = floatval(1.330274429);
		$t = 1 / (1 + ($p * floatval($val)));
		$zx = (1 / (sqrt(2 * pi())) * (exp(0 - pow($val, 2) / 2)));

		$px = 1 - floatval($zx) * (($b1 * $t) + ($b2 * pow($t, 2)) + ($b3 * pow($t, 3)) + ($b4 * pow($t, 4)) + ($b5 * pow($t, 5)));
		return $px;
	}

	/**
	 *  BlackScholesCalculator()
	 *  Computes the theoretical price of an equity option.
	 *  allows you to figure out the value of a European call or put option.  The calculator uses the stock's current share price,
	 *  the option strike price, time to expiration, risk-free interest rate, and volatility to derive the value of these options.
	 *  The Black-Scholes calculation used here assumes no dividend is paid on the stock.
	 *
	 * @param callPutFlag                     The Call Put Flag. (Required)."c" = Call else considered Put option.
	 * @param $currAssetPrice      The current asset price. (Required).
	 * @param $exercisePrice          Exercise price. (Required)
	 * @param $timeToMaturity      Time to maturity. (Required)
	 * @param $riskFreeInterestRate Risk-free Interest rate. (Required)
	 * @param $annualVolatility     Annualized volatility. (Required)
	 * @return Returns a number.
	 */

	public static function BlackScholesCalculator($callPutFlag, $currAssetPrice, $exercisePrice, $timeToMaturity, $riskFreeInterestRate, $annualVolatility)
	{
		$d1 = (log($currAssetPrice / $exercisePrice) + ($riskFreeInterestRate + (pow($annualVolatility, 2)) / 2) * $timeToMaturity) / ($annualVolatility * (pow($timeToMaturity, 0.5)));
		$d2 = $d1 - $annualVolatility * (pow($timeToMaturity, 0.5));

		if ($callPutFlag === 'c')
		{
			return $currAssetPrice * self::cnd($d1) - $exercisePrice * exp(-$riskFreeInterestRate * $timeToMaturity) * self::cnd($d2);
		} else
		{
			return $exercisePrice * exp(-$riskFreeInterestRate * $timeToMaturity) * self::cnd(-$d2) - $currAssetPrice * self::cnd(-$d1);
		}
	}

	/**
	 *  IRRCalculator()
	 *  Calculates Internal Rate of Return (IRR) similar to excel IRR function.
	 *
	 * @param $cashFlow    array of cashflow (Required).
	 * @return Returns a number.
	 */
	public static function IRRCalculator($cashFlowArray)
	{
		$base = floatval(0.1);
		$inc = floatval(0.00001);
		do
		{
			$base += $inc;
			$netPresentValue = 0;
			for ($i = 1; $i <= count($cashFlowArray); $i++)
				$netPresentValue += $cashFlowArray[$i - 1] / (pow((1 + $base), $i));
		} while ($netPresentValue > 0);

		$irr = $base * 100;
		return $irr;
	}

	/**
	 *  compoundInterest()
	 *  Calculate the compound interest after n years.
	 *
	 * @param $rate        Interest rate (% as decimal).
	 * @param $principal   Principal
	 * @param $duration    Duration of the loan in years.
	 * @return Returns a number.
	 */
	public static function compoundInterest($rate, $principal, $duration)
	{
		return ($principal * pow((1 + $rate), $duration));
	}
}
