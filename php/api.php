<?php
require_once(__DIR__.'/hotwords.php');
// For any word, we can get the stem using Porter Stemmer Algorithm.
// $stem=HotWords::wordNormalize($anyword);

require_once(__DIR__.'/filter.php');

$text=isset($_REQUEST['text'])?$_REQUEST['text']:'';
$filter=isset($_REQUEST['filter'])?$_REQUEST['filter']:'';

$HWA=new HotWordsAgent();
$HWA->processText($text,$filter);

/**
* 
*/
class HotWordsAgent
{
	
	function __construct()
	{
		$this->word_stat=array();
	}

	private $word_stat=array();
	private $word_filter=null;

	private function getWordFilter(){
		if(!$this->word_filter){
			$this->word_filter=new WordFilter();
		}
		return $this->word_filter;
	}

	public function processText($text,$filter_name=null){
		$this->word_stat=array();
		$words=preg_split('/[^A-Za-z]+/', $text);
		foreach ($words as $word) {
			if($filter_name=='common'){
				if($this->getWordFilter()->isCommonWord($word)){
					continue;
				}
			}
			$this->register($word);
		}
		$this->stat();

		// echo json_encode($this->word_stat);
		// exit();

		$word_list=array();
		foreach ($this->word_stat as $stem=>$item) {
			// For debug, show directly.
			// echo $item['times']." time(s) [".$stem."] Origins: ".implode(',', $item['words']).PHP_EOL;

			$word_list[]=array('stem'=>$stem,'times'=>$item['times'],'words'=>array_values($item['words']));
		}

		echo json_encode($word_list);
		exit();
	}

	private function register($word){
		$word=trim($word);
		if(empty($word))return;
		$lower_word=strtolower($word);
		$stem=HotWords::wordNormalize($lower_word);
		// echo $word . " -> " . $stem . PHP_EOL;
		if(!isset($this->word_stat[$stem])){
			$this->word_stat[$stem]=array('times'=>0,'words'=>array());
		}
		$this->word_stat[$stem]['times']+=1;
		$this->word_stat[$stem]['words'][$word]=$word;
	}

	private function stat(){
		uasort($this->word_stat, function($a, $b){
			return $b['times']-$a['times'];
		});
	}

}

?>