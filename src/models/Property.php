<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
	public $table = 'property';
	//indicates if the model needs a timestamp
	public $timestamps = false;

	protected $fillable = [
		'ZooplaID',
		'County',
		'Country',
		'Description',
		'DisplayableAddress',
		'Latitude',
		'Longitude',
		'NoOfBathrooms',
		'NoOfBedrooms',
		'Postcode',
		'Price',
		'PropertyType',
		'SaleOrRent',
		'ThumnailURL',
		'Town',
		'Image',
		'Postcode',
			
	];
}