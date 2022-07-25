<p  align="center"><a  href="https://hyperpay.com"  target="_blank">
<img src="https://www.hyperpay.com/wp-content/uploads/2020/04/cropped-011-300x155.png"  width="400"> 
</a></p>

  

# Copy and Pay

( Payment package )
Copy and pay  package for Laravel >= 7 

#### requirements 
* composer version >= 2.6
* Laravel version >= 7

#### features

* Handle Payment process 
* Easy to use

#### supported brands 

 <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Mastercard-logo.svg/200px-Mastercard-logo.svg.png"  width="50">  
 <img src="https://www.smartenergydecisions.com/upload/images/company_images/american_express.jpg"  width="50">  
  <img src="https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcR_FrTaaaGEk9eULQpb355SxtAFizG5jleBqp_1q8j2dgMxqfHT"  width="50">  
<img src="https://ksaexpats.com/wp-content/uploads/2018/03/mada-card.jpg"  width="50">  

### Resources

* [ACI Documentation ](https://wordpresshyperpay.docs.oppwa.com/tutorials/integration-guide)

* [Laravel 7 Documentation ](https://laravel.com/docs/7.x)

 

### Indexes

* [Installation ](#installation)

* [Add a new payment](#add-a-new-payment)

* [Properties](#properties)

* [Methods](#methods)

* [customize Admin setting fields](#customize-admin-setting-fields)

* [JavaScript & CSS](#customize-admin-setting-fields)(#javascript-and-css)

  
  
  

## Installation

 

``` php
composer require hyperpay/payment
``` 
Publish configuration files 
``` php
php artisan vendor:publish --provider='Hyperpay\Payment\HyperpayServiceProvider'
``` 

configure the payments credentials in **config/payments.php**
```
project
|
└───config
   │   payments.php

```
```php
return [

	"environment"  =>  "test",
	  
	"gatewayes"  => [
		"card"  => [
			"enabled"  =>  false,
			'entity_id'  =>  "",
			"access_token"  =>  "",
			"currency"  =>  "SAR",
			"transaction_type"  =>  "DB",
			"brands"  =>  "VISA MASTER AMEX",
			"label"  =>  "Cridet Card",
		],
		"mada"  => [
			"enabled"  =>  false,
			'entity_id'  =>  "",
			"access_token"  =>  "",
			"currency"  =>  "SAR",
			"transaction_type"  =>  "DB",
			"brands"  =>  "MADA",
			"label"  =>  "Mada Debit Card",
			],
		]
	];
```
Fill **entity_id** and **access_token**  with credential you provided with
Define supported brands 
```php
"card"  =>  [  
	"brands"  =>  "VISA MASTER AMEX",
```

> **Make sure to write all brands with CAPITAL letter and separated with space " "** 

### Enable/Disable
By default all payment methods are disabled , to enable payment method just change **enabled** to **true**

```php
...
"card"  =>  [  
	"enabled"  =>  true,
....

```

### Basic Use 

Inside any blade template you can call payment component 

```php
<div  class="flex-center position-ref full-height">
	<x-hyper-pay-form />
</div>
``` 
**component attributes**
 - amount ( Require ) : total order amount
 - merchantTransactionId ( Require ) : typically  represent **order_id**
 - firstName ( Optional ) : customer first name
 - lastName ( Optional ) : customer last name
 - email( Optional ) : customer email
 - street ( Optional ) : customer street address
 -  city( Optional ) : customer city address
 -  country( Optional ) : customer country address
 -  zip( Optional ) : customer zip code
 
 **passing data**
 ```php
	 <x-hyper-pay-form amount="10.00" merchantTransactionId="19" />  
```
 

### customization

```php
...
"card"  =>  [  
	"label"  =>  "As you want to dispaly to customers",
....
```
**Translation**
Our package can detect your app locale and automatically translate components
If you want to customize translation edit translation file from 

```
project
|
└───resources
   |
   └─── lang
	   |
	   └─── ar
		 | payment.php
	   |
	   └─── en
		| payment.php

```

```php
return [
	"Mada Debit Card"  =>  "بطاقة مدى البنكية",
	"Cridet Card"  =>  "بطاقة ائتمان",
	"Pay_Again_?"  =>  "دفع مرة اخرى ؟"
];
```
  

## Handel Result

**Success**
To handle success status you will write your logic inside *success* method in :
```
project
|
└───app
   |
   └─── Http
	   |
	   └─── Controllers
			 | PaymentController.php

```

```php
public  function  success($result)
{
	return  $result;
}
``` 
here where you can handle success status of transaction like *( rediract , update database , etc.  )*

all data you need will be in  **$result** argument
  ```json
{
  "id": "8ac7a49f82323dc60182350fb142773d",
  "paymentType": "DB",
  "paymentBrand": "VISA",
  "amount": "95.00",
  "currency": "SAR",
  "descriptor": "9751.3590.4583 new channel Ahmad",
  "merchantTransactionId": "5",
  "result": {
    "code": "000.000.000",
    "description": "Transaction succeeded"
  },
  "resultDetails": {
    "ExtendedDescription": "Successfully processed"
  },
  "buildNumber": "a94641688adf253dbf3145d2dd0a203bbeeb50aa@2022-07-22 12:35:29 +0000",
  "timestamp": "2022-07-25 11:13:20+0000",
  "ndc": "777D1BE1744BEFD249DA95017DF97957.uat01-vm-tx03"
}
  ```

 **failed** 
By default when transaction failed the customer will redirect back to payment page with the error message 

if you want to change this approach 
create a method call ***failed()*** with **$result** argument in PaymentController.php

```php
public  function  failed($result)
{
	Session::flash('alert'  ,  $result['result']['description']);
	return  back();
}
```

