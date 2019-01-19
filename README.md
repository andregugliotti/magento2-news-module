# Magento 2.2 News Module

This is a News module to Magento 2.2, developed to be used along Magento classes. It isn't a full module and the use on
 production environment IS NOT RECOMMENDED. You can use this module to study and improve your knowledge about Magento Commerce.

## How to use this module

Just clone the files you can found in the /src folder into the /app/code/Gugliotti/News folder in your project. 
Run the appropriated commands (like setup:upgrade) and the News module should be ready to be used. If you prefer just
 install it to see how it works, you can also add it to your store via Composer.

This module was thought to be used as support on Magento classes, containing models, controllers and templates that 
allows the student to see almost everything s/he must know to start to work with Magento 2. Currently, it contains:

* SQL installer, using DDL calls
* models for Category and Story objects
* controllers for backend grids and edit pages
* controllers for frontend lists and single category / story view (TBD)
* blocks used to display this information (TBD)
* main helper
* CSV translation file for en_US view
* data install (as an upgrade from 0.1.0 to 0.2.0) (TBD)
* latest news widget (TBD)
 
It's a work in progress, so on every new course, this module is updated with new features.

As you can guess, this is not a module to Magento 1. If you want to see the same module developed to Magento 1, take 
a look on [this repository](https://github.com/GugliottiConsulting/NewsModuleMagento1).

## Contribution

This is an open source module and can be used as a base for other modules. If you have suggestions for improvements, just submit your pull request.

## Versioning

We use SemVer to versioning. To view all versions for this module, visit the tags page, on this repository.

## Authors

Andre Gugliotti - Initial module development - [AndreGugliotti](https://github.com/AndreGugliotti)
See also the developers list, with all those who contributed to this project. [Contributors](https://github
.com/AndreGugliotti/NewsModuleMagento2/graphs/contributors)

## License

This project is licensed under GNU General Public License, version 3.