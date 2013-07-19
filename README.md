# EoEcommerceBundle

A lightweight yet flexible ecommerce bundle (based on Sylius and Spree) that works on MongoDB.

## Prerequisites
This version of the bundle requires Symfony 2.1+

## Concepts

### Product options

Often you need to have different options for the same product. For example think of a simple store that sells iPhones and iPads:

```
Products:
    1) iPhone (starting from: $649)
        Options:
            1) iPhone 16GB ($649)
            2) iPhone 32GB ($749)
            3) iPhone 64GB ($849)
    2) iPad (starting from: $499)
        Options:
            1) iPad 16GB ($499)
            1) iPad 32GB ($599)
            1) iPad 64GB ($699)
            1) iPad 128GB ($799)

```

To add options you must first implement `CustomProductInterface` on your product class. This interface will give you access to 3 new fields (*options, variants and prices*). Once implemented you need to set an options map for your product:

```php
<?php
# Your product class
use Eo\EcommerceBundle\Document\Option\Option;
use Eo\EcommerceBundle\Document\Product\BaseCustomProduct;

class AcmeProduct extends BaseCustomProduct
{
    public function getOptions()
    {
        // Set product options
        $model = new Option();
        $model->setName('Model');
        $model->setMethod('getModels');
        return new ArrayCollection(array($model));
    }

    /**
     * This method should return an ArrayCollection of `OptionInterface` objects
     *
     * @return ArrayCollection $optionValues
     */
    public function getModels()
    {
        # Implement your custom logic here
        $models = array();

        // 16 GB - $649
        $price649 = new Price();
        // In some cases you will need to have a price
        // name for easy identifying and order filtering.
        $price649->setName("Price name");
        $price649->setPrice(64900);

        $model16gb = new OptionValue();
        $model16gb->setName('16GB');
        $model16gb->setPrice($price649);
        $models[] = $model16gb;

        // 32 GB - $749
        $price749 = new Price();
        $price749->setName("Price name");
        $price749->setPrice(74900);

        $model32gb = new OptionValue();
        $model32gb->setName('32GB');
        $model32gb->setPrice($price749);
        $models[] = $model32gb;

        // 64 GB - $849
        $price849 = new Price();
        $price849->setName("Price name");
        $price849->setPrice(84900);

        $model64gb = new OptionValue();
        $model64gb->setName('64GB');
        $model64gb->setPrice($price849);
        $models[] = $model64gb;

        return $models;
    }
}
```

## Installation

### Step 1: Download EoEcommerceBundle using composer
Add EoEcommerceBundle in your composer.json:

```json
{
    "require": {
        "eo/ecommerce-bundle": "dev-master"
    }
}
```

Now tell composer to download the bundle by running the command:

```bash
$ php composer.phar update "eo/ecommerce-bundle"
```
Composer will install the bundle to your project's vendor/eo directory.

### Step 2: Enable the bundle
Enable the bundle in the kernel:

```php
<?php
// app/AppKernel.php
public function registerBundles()
{
    $bundles = array(
        // ...
        new Eo\PassbookBundle\EoEcommerceBundle(),
    );
}
```