# Mongor ORM

## Installation

#### via Git

	git clone https://github.com/Apathetic012/mongor.git

## Usage

#### Bundle Registration

Add the following to your **application/bundles.php** file:


	'mongor' => ['auto' => true]


> Edit **config/database.php** with your database connection details.



#### Models

To use a model you need to create a file in the models folder with the name of the class, just like Eloquent

	class Post extends Mongor\Model {}

Where Post is the name (lower case) of the collection in MongoDB, or can declare them:

	class Post extends Mongor\Model {
		public static $collection = 'posts';
		...
	}

### Copyright

This is a fork from HPaul's MongoDB bundle named [Mongor](https://github.com/hpaul/mongor)
