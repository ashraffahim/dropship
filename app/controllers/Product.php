<?php

namespace controllers;

use libraries\Controller;
use models\_Product;
use models\_Country;

class Product extends Controller {

	private $p;

	function __construct() {
		$this->p = new _Product();
	}

	public function details($h, $n = false) {
		$pd = $this->p->details($h, $n);
		
		if (!$pd) {
			$this->error('pde');
			return;
		}
		
		$c = new _Country();
		$cur = $c->currency($pd->s_country);
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
					"priceCurrency": "' . $curr . '",
					"price": "' . $pd->p_price . '",
					"url": "' . DOMAIN . '/' . $h . '"
				}
			}',
			'data' => $pd,
			'curr' => $curr,
			'fs' => $fs
		]);
	}
}

?>