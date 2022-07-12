<?php

namespace controllers;

use libraries\Controller;
use models\_Product;

class Product extends Controller {

	private $p;

	function __construct() {
		$this->p = new _Product();
	}

	public function details($h) {
		$pd = $this->p->details($h);
		
		if (!$pd) {
			$this->error('pde');
			return;
		}
		
		$fs = str_replace(DATADIR.DS.'product'.DS.$pd->id.DS, DATA.'/product/'.$pd->id.'/', glob(DATADIR.DS.'product'.DS.$pd->id.DS.'*'));

		$this->view('product' . DS . 'detail', [
			'title' => '',
			'description' => '',
			'canonical' => DOMAIN . '/' . $h,
			'meta' => '',
			'schema' => '{
				"@context": "https://schema.org/",
				"@type": "Product",
				"name": "' . $pd->p_name . '",
				"image": ["' . implode("\",\"", $fs) . '"],
				"category": "' . $pd->p_category . '",
				'.(
					$pd->p_description != '' ? '"description": "' . str_replace("\r\n", '', $pd->p_description) . '",
					' : ''
				).(
					
					$pd->p_brand != '' ? '"brand": {
						"@type": "Brand"
						"name": "' . $pd->p_brand . '"
					},' : ''
				
				).'
				"offer": {
					"priceCurrency": "' . $pd->s_currency . '",
					"price": "' . $pd->p_price . '",
					"url": "' . DOMAIN . '/' . $h . '"
				}
			}',
			'data' => $pd,
			'curr' => $pd->s_currency,
			'fs' => $fs
		]);
	}
}

?>