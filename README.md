YiiHelpers
==========

Developing a library of useful Helper functions to give your apps an extra hand.

###FinanceLibHelper
financial calculators and functions:

#####BlackScholesCalculator()
The Black-Schole calculator allows you to figure out the value of a European call or put option.  The calculator uses the stock's current share price, 
the option strike price, time to expiration, risk-free interest rate, and volatility to derive the value of these options. The Black-Scholes calculation used here assumes no dividend is paid on the stock.

Example use:
~~~
  $CallPutFlag = 'c';
  $S='49.25'; //Current Share Price ($)
  $X='50.00'; //Option Strike Price ($)
  $T='0.1'; //Time to Expiration (Years)
  $r='0.35'; //Risk-Free Interest Rate (% in decimal)
  $v='0.30'; //Volatility (% in decimal)
  echo FinanceLibHelper::BlackScholesCalculator($CallPutFlag,$S,$X,$T,$r,$v);
~~~ 

#####IRRCalculator()
Calculates Internal Rate of Return (IRR) similar to excel IRR function from a cashflow array.

Example of use:
~~~
  $cashflowArr = array(-4000,1200,1410,1875,1050,1350,1025);
  echo FinanceLibHelper::IRRCalculator($cashflowArr);
~~~
