<?php

namespace controllers;

use libraries\Controller;
use models\_Product;

class Product extends Controller {

	private $p;

	function __construct() {
		$this->p = new _Product();
	}

	public function details($h, $n = false) {
		$pd = $this->p->details($h, $n);

		$fs = str_replace(DATADIR.DS.'product'.DS.$pd->id.DS, DATA.'/product/'.$pd->id.'/', glob(DATADIR.DS.'product'.DS.$pd->id.DS.'*'));

		$this->view('product' . DS . 'detail', [
			'title' => '',
			'description' => '',
			'canonical' => DOMAIN . '/' . $h,
			'schema' => '{
				"@context": "https://schema.org/",
				"@type": "Product",
				"name": "' . $pd->p_name . '",
				"image": ["' . implode("\",\" \n", $fs) . '"],
				"category": "' . $pd->p_category . '",
				'.(
					$pd->p_description != '' ? '"description": "' . $pd->p_description . '",' : ''
				).(
					
					$pd->p_brand != '' ? '"brand": {
						"@type": "Brand"
						"name": "' . $pd->p_brand . '"
					},' : ''
				
				).'
				"offer": {
					"priceCurrency": "AED",
					"price": "' . $pd->p_price . '",
					"url": "' . DOMAIN . '/' . $h . '"
				}
			}',
			'data' => $pd,
			'fs' => $fs
		]);
	}
}

?>