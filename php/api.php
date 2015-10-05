<?php
require_once(__DIR__.'/hotwords.php');
// For any word, we can get the stem using Porter Stemmer Algorithm.
// $stem=HotWords::wordNormalize($anyword);

$text=isset($_REQUEST['text'])?$_REQUEST['text']:'';

$HWA=new HotWordsAgent();
$HWA->processText($text);

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

	public function processText($text){
		$this->word_stat=array();
		$words=preg_split('/[^A-Za-z]+/', $text);
		foreach ($words as $word) {
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