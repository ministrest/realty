<?php
/**
 * @author Andrey A. Nechaev <nechaev@nmgcom.ru>
 * @copyright Copyright (c) 2015 Nechaev Marketing Group (http://www.nmgcom.ru)
 */
namespace NMG\Page;

class Page {

	public $title;
	public $description;
	public $keywords;

	// список css, которые необходимо подключить к странице
	public $css = [];
	// список js, которые необходимо подключить к странице
	public $js = [];

	private $f3;

	public function __construct($f3) {
		$this->f3 = $f3;
		$this->title = $f3->get('site.title');
		$this->description = $f3->get('site.description');
		$this->keywords = $f3->get('site.keywords');
		$this->appendDefaultJS();
		$this->appendDefaultCSS();
	}

	public function printHead() {
		include ROOTDIR.'/inc/tpl/head.tpl.php';
	}

	/**
	 * Возвращает дату(ы) копирайта.
	 * @param int $year c какого года копирайт
	 * @return string либо текущий год, либо $year-$cur
	 */
	public function copyDates($year) {
		$cur = date('Y');
		if ($cur==$year) {
			return $cur;
		} else {
			return $year.'-'.$cur;
		}
	}

	protected function appendDefaultJS() {
		if ($this->f3->exists('site.js')) {
			foreach($this->f3->get('site.js') as $row) {
				$this->js[] = $this->f3->get('homeurl').$row;
			}
		}
	}

	protected function appendDefaultCSS() {
		if ($this->f3->exists('site.css')) {
			foreach($this->f3->get('site.css') as $row) {
				$this->css[] = $this->f3->get('homeurl').$row;
			}
		}
	}
}